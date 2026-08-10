<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertificatePaymentNoticeTest extends TestCase
{
    use RefreshDatabase;

    public function test_completed_optional_course_shows_awaiting_payment_notice_on_panel_and_course_page(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['certificate_type' => 'opcional', 'certificate_price' => 20, 'is_published' => true]);
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'completed', 'progress_percent' => 100]);

        $this->actingAs($student)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('obtén tu certificación')
            ->assertSee('S/ 20.00')
            ->assertSee('Hacer el pago ahora')
            ->assertSee('Ya hice el pago');

        $this->actingAs($student)->get(route('courses.show', $course))
            ->assertOk()
            ->assertSee('obtén tu certificación');
    }

    public function test_incomplete_optional_course_does_not_show_payment_notice(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['certificate_type' => 'opcional', 'certificate_price' => 20, 'is_published' => true]);
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active', 'progress_percent' => 40]);

        $this->actingAs($student)->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee('obtén tu certificación');
    }

    public function test_free_course_never_shows_payment_notice(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['certificate_type' => 'gratuita', 'is_published' => true]);
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'completed', 'progress_percent' => 100]);

        $this->actingAs($student)->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee('obtén tu certificación');
    }

    public function test_claiming_payment_saves_name_and_switches_notice_to_processing(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['certificate_type' => 'opcional', 'certificate_price' => 20, 'is_published' => true]);
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'completed', 'progress_percent' => 100]);

        $this->actingAs($student)->post(route('courses.claim-payment', $course), [
            'certificate_name' => 'Nombre Para Mi Certificado',
        ])->assertRedirect();

        $enrollment = Enrollment::where('user_id', $student->id)->where('course_id', $course->id)->first();
        $this->assertSame('Nombre Para Mi Certificado', $enrollment->certificate_name);
        $this->assertNotNull($enrollment->certificate_payment_claimed_at);

        $this->actingAs($student)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Tu certificado está en proceso')
            ->assertDontSee('Hacer el pago ahora');
    }

    public function test_guest_cannot_claim_payment(): void
    {
        $course = Course::factory()->create(['certificate_type' => 'opcional', 'is_published' => true]);

        $this->post(route('courses.claim-payment', $course), ['certificate_name' => 'X'])
            ->assertRedirect(route('login'));
    }
}
