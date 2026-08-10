<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\ExamAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CertificateTest extends TestCase
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

    public function test_certificate_is_issued_automatically_when_exam_is_passed(): void
    {
        Storage::fake('public');

        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
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

        $certificate = $course->certificates()->first();
        $this->assertNotNull($certificate->pdf_path);
        Storage::disk('public')->assertExists($certificate->pdf_path);

        $this->actingAs($student)->get(route('certificates.download', $certificate))->assertOk();
    }

    public function test_student_cannot_download_another_students_certificate(): void
    {
        Storage::fake('public');

        $owner = User::factory()->create(['role' => 'student']);
        $intruder = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
        $course->enrollments()->create(['user_id' => $owner->id, 'status' => 'active']);
        $this->makeExamWithQuestions($course);

        $this->actingAs($owner)->post(route('exams.start', $course), ['certificate_name' => $owner->name]);
        $attempt = ExamAttempt::first();
        $correctOptionId = $attempt->exam->questions->first()->options->firstWhere('is_correct', true)->id;
        $this->actingAs($owner)->post(route('exams.submit', $attempt), [
            'answers' => [$attempt->exam->questions->first()->id => $correctOptionId],
        ]);

        $certificate = $course->certificates()->first();

        $this->actingAs($intruder)->get(route('certificates.download', $certificate))->assertForbidden();
    }

    public function test_public_verification_shows_valid_revoked_and_not_found_states(): void
    {
        Storage::fake('public');

        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active']);
        $this->makeExamWithQuestions($course);

        $this->actingAs($student)->post(route('exams.start', $course), ['certificate_name' => $student->name]);
        $attempt = ExamAttempt::first();
        $correctOptionId = $attempt->exam->questions->first()->options->firstWhere('is_correct', true)->id;
        $this->actingAs($student)->post(route('exams.submit', $attempt), [
            'answers' => [$attempt->exam->questions->first()->id => $correctOptionId],
        ]);

        $certificate = $course->certificates()->first();

        $this->get(route('certificates.verify', $certificate->code))
            ->assertOk()
            ->assertSee('Certificado válido')
            ->assertSee($student->name);

        $this->get(route('certificates.verify', 'CODIGO-INEXISTENTE'))
            ->assertOk()
            ->assertSee('no encontrado');

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->post(route('admin.certificates.revoke', $certificate));

        $this->get(route('certificates.verify', $certificate->code))
            ->assertOk()
            ->assertSee('revocado');
    }

    public function test_admin_can_reissue_a_revoked_certificate(): void
    {
        Storage::fake('public');

        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active']);
        $this->makeExamWithQuestions($course);

        $this->actingAs($student)->post(route('exams.start', $course), ['certificate_name' => $student->name]);
        $attempt = ExamAttempt::first();
        $correctOptionId = $attempt->exam->questions->first()->options->firstWhere('is_correct', true)->id;
        $this->actingAs($student)->post(route('exams.submit', $attempt), [
            'answers' => [$attempt->exam->questions->first()->id => $correctOptionId],
        ]);

        $certificate = $course->certificates()->first();
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('admin.certificates.revoke', $certificate));
        $this->assertNotNull($certificate->fresh()->revoked_at);

        $this->actingAs($admin)->post(route('admin.certificates.reissue', $certificate));
        $this->assertNull($certificate->fresh()->revoked_at);
    }
}
