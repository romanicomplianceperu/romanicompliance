<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentLearningTest extends TestCase
{
    use RefreshDatabase;

    private function makeCourseWithLessons(): Course
    {
        $course = Course::factory()->create(['is_published' => true, 'slug' => 'curso-prueba']);
        $module = CourseModule::create(['course_id' => $course->id, 'title' => 'Módulo 1', 'order' => 1]);
        Lesson::create(['module_id' => $module->id, 'title' => 'Lección 1', 'type' => 'text', 'content' => 'Contenido 1', 'order' => 1]);
        Lesson::create(['module_id' => $module->id, 'title' => 'Lección 2', 'type' => 'text', 'content' => 'Contenido 2', 'order' => 2]);

        return $course;
    }

    public function test_unpublished_course_returns_404_for_student(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['is_published' => false]);

        $this->actingAs($student)->get(route('courses.show', $course))->assertNotFound();
    }

    public function test_student_can_enroll_and_view_lesson_after_enrolling(): void
    {
        $student = User::factory()->create(['role' => 'student', 'phone' => '+51 999 888 777']);
        $course = $this->makeCourseWithLessons();

        $this->actingAs($student)->get(route('courses.show', $course))->assertOk();

        $lesson = $course->lessons()->first();
        $this->actingAs($student)->get(route('lessons.show', $lesson))->assertForbidden();

        $this->actingAs($student)->post(route('courses.enroll', $course))
            ->assertRedirect(route('courses.show', $course));

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress_percent' => 0,
        ]);

        $this->actingAs($student)->get(route('lessons.show', $lesson))->assertOk();
    }

    public function test_completing_lessons_updates_progress_and_marks_course_completed(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = $this->makeCourseWithLessons();
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active', 'progress_percent' => 0]);

        $lessons = $course->lessons()->orderBy('order')->get();

        $this->actingAs($student)->post(route('lessons.complete', $lessons[0]))
            ->assertRedirect(route('lessons.show', $lessons[1]));

        $enrollment = Enrollment::first();
        $this->assertSame(50, $enrollment->fresh()->progress_percent);

        $this->actingAs($student)->post(route('lessons.complete', $lessons[1]))
            ->assertRedirect(route('courses.show', $course));

        $enrollment->refresh();
        $this->assertSame(100, $enrollment->progress_percent);
        $this->assertSame('completed', $enrollment->status);
        $this->assertNotNull($enrollment->completed_at);
    }

    public function test_student_cannot_complete_lesson_without_enrolling(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = $this->makeCourseWithLessons();
        $lesson = $course->lessons()->first();

        $this->actingAs($student)->post(route('lessons.complete', $lesson))->assertForbidden();
    }
}
