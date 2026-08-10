<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\ExamAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OptionalCertificationTest extends TestCase
{
    use RefreshDatabase;

    private function makeExamWithQuestions(Course $course, int $passingScore = 50): void
    {
        $exam = $course->exam()->create([
            'title' => 'Examen final',
            'passing_score' => $passingScore,
            'max_attempts' => 3,
        ]);

        $question = $exam->questions()->create(['question_text' => 'Pregunta 1', 'order' => 1, 'points' => 1]);
        $question->options()->create(['option_text' => 'Correcta', 'is_correct' => true, 'order' => 0]);
        $question->options()->create(['option_text' => 'Incorrecta', 'is_correct' => false, 'order' => 1]);
    }

    public function test_passing_exam_on_optional_course_does_not_auto_issue_certificate(): void
    {
        Storage::fake('public');

        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['certificate_type' => 'opcional', 'certificate_price' => 99]);
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active']);
        $this->makeExamWithQuestions($course);

        $this->actingAs($student)->post(route('exams.start', $course), ['certificate_name' => $student->name]);
        $attempt = ExamAttempt::first();
        $correctOptionId = $attempt->exam->questions->first()->options->firstWhere('is_correct', true)->id;

        $response = $this->actingAs($student)->post(route('exams.submit', $attempt), [
            'answers' => [$attempt->exam->questions->first()->id => $correctOptionId],
        ]);

        $this->assertDatabaseMissing('certificates', [
            'user_id' => $student->id,
            'course_id' => $course->id,
        ]);

        $response->assertRedirect(route('exams.result', $attempt));

        // Passing the exam alone (without claiming payment) must NOT jump straight
        // to "processing" — it should still ask the student to pay first.
        $this->actingAs($student)->get(route('exams.result', $attempt))
            ->assertOk()
            ->assertSee('falta completar el pago')
            ->assertDontSee('Tu certificado está en proceso');
    }

    public function test_passing_exam_on_free_course_still_auto_issues_certificate(): void
    {
        Storage::fake('public');

        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['certificate_type' => 'gratuita']);
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active']);
        $this->makeExamWithQuestions($course);

        $this->actingAs($student)->post(route('exams.start', $course), ['certificate_name' => $student->name]);
        $attempt = ExamAttempt::first();
        $correctOptionId = $attempt->exam->questions->first()->options->firstWhere('is_correct', true)->id;

        $this->actingAs($student)->post(route('exams.submit', $attempt), [
            'answers' => [$attempt->exam->questions->first()->id => $correctOptionId],
        ]);

        $this->assertDatabaseHas('certificates', [
            'user_id' => $student->id,
            'course_id' => $course->id,
        ]);
    }

    public function test_claiming_payment_after_passing_exam_moves_to_processing_and_admin_can_issue(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['certificate_type' => 'opcional', 'certificate_price' => 99]);
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active']);
        $this->makeExamWithQuestions($course);

        $this->actingAs($student)->post(route('exams.start', $course), ['certificate_name' => $student->name]);
        $attempt = ExamAttempt::first();
        $correctOptionId = $attempt->exam->questions->first()->options->firstWhere('is_correct', true)->id;
        $this->actingAs($student)->post(route('exams.submit', $attempt), [
            'answers' => [$attempt->exam->questions->first()->id => $correctOptionId],
        ]);

        // Student claims payment from the banner.
        $this->actingAs($student)->post(route('courses.claim-payment', $course), [
            'certificate_name' => 'Nombre Para Certificado',
        ]);

        $this->actingAs($student)->get(route('exams.result', $attempt))
            ->assertOk()
            ->assertSee('Tu certificado está en proceso');

        $enrollment = Enrollment::where('user_id', $student->id)->where('course_id', $course->id)->first();

        $this->actingAs($admin)->get(route('admin.certificates.index'))
            ->assertOk()
            ->assertSee('Certificaciones pendientes de pago')
            ->assertSee($student->name)
            ->assertSee('Nombre Para Certificado');

        $this->actingAs($admin)->post(route('admin.certificates.issue-pending', $enrollment))
            ->assertRedirect();

        $this->assertDatabaseHas('certificates', [
            'user_id' => $student->id,
            'course_id' => $course->id,
            'holder_name' => 'Nombre Para Certificado',
        ]);

        $this->actingAs($student)->get(route('exams.result', $attempt))
            ->assertOk()
            ->assertSee('Tu certificado está listo');
    }

    public function test_admin_can_issue_a_claimed_certificate_even_without_an_exam_attempt(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['certificate_type' => 'opcional', 'certificate_price' => 20]);
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'completed', 'progress_percent' => 100]);

        $this->actingAs($student)->post(route('courses.claim-payment', $course), [
            'certificate_name' => 'Sin Examen Todavia',
        ]);

        $enrollment = Enrollment::where('user_id', $student->id)->where('course_id', $course->id)->first();

        $this->actingAs($admin)->post(route('admin.certificates.issue-pending', $enrollment))
            ->assertRedirect();

        $this->assertDatabaseHas('certificates', [
            'user_id' => $student->id,
            'course_id' => $course->id,
            'holder_name' => 'Sin Examen Todavia',
        ]);
    }

    public function test_student_cannot_issue_own_pending_certificate(): void
    {
        Storage::fake('public');

        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['certificate_type' => 'opcional', 'certificate_price' => 99]);
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'completed', 'progress_percent' => 100]);

        $this->actingAs($student)->post(route('courses.claim-payment', $course), [
            'certificate_name' => $student->name,
        ]);

        $enrollment = Enrollment::where('user_id', $student->id)->where('course_id', $course->id)->first();

        $this->actingAs($student)->post(route('admin.certificates.issue-pending', $enrollment))
            ->assertForbidden();

        $this->assertDatabaseMissing('certificates', [
            'user_id' => $student->id,
            'course_id' => $course->id,
        ]);
    }
}
