<?php

namespace Tests\Feature;

use App\Models\AnswerOption;
use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use RefreshDatabase;

    private function makeExamWithQuestions(Course $course, int $passingScore = 70, int $maxAttempts = 2): Exam
    {
        $exam = $course->exam()->create([
            'title' => 'Examen final',
            'passing_score' => $passingScore,
            'max_attempts' => $maxAttempts,
        ]);

        foreach (range(1, 2) as $n) {
            $question = $exam->questions()->create(['question_text' => "Pregunta {$n}", 'order' => $n, 'points' => 1]);
            $question->options()->create(['option_text' => 'Correcta', 'is_correct' => true, 'order' => 0]);
            $question->options()->create(['option_text' => 'Incorrecta', 'is_correct' => false, 'order' => 1]);
        }

        return $exam;
    }

    public function test_admin_can_create_exam_and_question_via_form(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $course = Course::factory()->create();

        $this->actingAs($admin)->post(route('admin.exams.store', $course), [
            'title' => 'Examen SPLAFT',
            'passing_score' => 80,
            'max_attempts' => 3,
        ])->assertRedirect(route('admin.courses.edit', $course));

        $exam = $course->fresh()->exam;
        $this->assertNotNull($exam);
        $this->assertSame(80, $exam->passing_score);

        $this->actingAs($admin)->post(route('admin.questions.store', $exam), [
            'question_text' => '¿Qué es SPLAFT?',
            'correct' => 1,
            'options' => ['Opción incorrecta', 'Opción correcta', '', ''],
        ])->assertRedirect(route('admin.courses.edit', $course));

        $question = Question::first();
        $this->assertSame(2, $question->options()->count());
        $this->assertSame('Opción correcta', $question->options()->where('is_correct', true)->first()->option_text);
    }

    public function test_student_can_take_exam_and_gets_graded_automatically(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active']);
        $exam = $this->makeExamWithQuestions($course, passingScore: 50);

        $this->actingAs($student)->post(route('exams.start', $course), ['certificate_name' => $student->name])->assertRedirect();
        $attempt = ExamAttempt::first();
        $this->assertSame(1, $attempt->attempt_number);
        $this->assertSame('in_progress', $attempt->status);

        $this->actingAs($student)->get(route('exams.take', $attempt))->assertOk();

        $questions = $exam->questions()->with('options')->get();
        $answers = [];
        foreach ($questions as $i => $question) {
            $correctOption = $question->options->firstWhere('is_correct', true);
            $wrongOption = $question->options->firstWhere('is_correct', false);
            $answers[$question->id] = $i === 0 ? $correctOption->id : $wrongOption->id;
        }

        $this->actingAs($student)->post(route('exams.submit', $attempt), ['answers' => $answers])
            ->assertRedirect(route('exams.result', $attempt));

        $attempt->refresh();
        $this->assertSame('50.00', (string) $attempt->score);
        $this->assertSame('passed', $attempt->status);
        $this->assertNotNull($attempt->finished_at);
        $this->assertGreaterThanOrEqual(0, $attempt->time_spent_seconds);

        $this->actingAs($student)->get(route('exams.result', $attempt))->assertOk();
    }

    public function test_student_cannot_exceed_max_attempts(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active']);
        $exam = $this->makeExamWithQuestions($course, maxAttempts: 1);

        $this->actingAs($student)->post(route('exams.start', $course), ['certificate_name' => $student->name]);
        $attempt = ExamAttempt::first();
        $wrongOptionId = AnswerOption::where('is_correct', false)->first()->id;
        $answers = $exam->questions->mapWithKeys(fn ($q) => [$q->id => $wrongOptionId]);
        $this->actingAs($student)->post(route('exams.submit', $attempt), ['answers' => $answers->all()]);

        $this->actingAs($student)->post(route('exams.start', $course), ['certificate_name' => $student->name])->assertStatus(422);
    }

    public function test_student_cannot_take_another_students_attempt(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $intruder = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active']);
        $this->makeExamWithQuestions($course);

        $this->actingAs($student)->post(route('exams.start', $course), ['certificate_name' => $student->name]);
        $attempt = ExamAttempt::first();

        $this->actingAs($intruder)->get(route('exams.take', $attempt))->assertForbidden();
    }

    public function test_timer_counts_down_instead_of_up_when_attempt_was_started_earlier(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active']);
        $exam = $this->makeExamWithQuestions($course);
        $exam->update(['time_limit_minutes' => 10]);

        $this->actingAs($student)->post(route('exams.start', $course), ['certificate_name' => $student->name]);
        $attempt = ExamAttempt::first();
        $attempt->update(['started_at' => now()->subMinutes(2)]);

        $response = $this->actingAs($student)->get(route('exams.take', $attempt));
        $response->assertOk();

        preg_match('/id="timer" data-seconds="(-?\d+)"/', $response->getContent(), $matches);
        $remaining = (int) $matches[1];

        $this->assertGreaterThanOrEqual(0, $remaining);
        $this->assertLessThan(600, $remaining);
    }
}
