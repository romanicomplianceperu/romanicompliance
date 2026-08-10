<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_panel_sections_are_reachable_for_an_authenticated_student(): void
    {
        $student = User::factory()->create(['role' => 'student', 'phone' => '+51 900000000']);

        $this->actingAs($student)->get(route('dashboard'))->assertOk()->assertSee('Mis cursos');
        $this->actingAs($student)->get(route('panel.certificates'))->assertOk()->assertSee('Mis certificados');
        $this->actingAs($student)->get(route('panel.calendar'))->assertOk()->assertSee('Mi calendario');
        $this->actingAs($student)->get(route('panel.profile'))->assertOk()->assertSee('Mi perfil');
    }

    public function test_calendar_lists_enrollment_and_certificate_dates(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create(['title' => 'Curso de prueba']);
        $course->enrollments()->create(['user_id' => $student->id, 'status' => 'active']);
        Certificate::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'code' => 'RC-TEST-0001',
            'issued_at' => now(),
        ]);

        $response = $this->actingAs($student)->get(route('panel.calendar'));

        $response->assertOk()
            ->assertSee('Inscripción: Curso de prueba')
            ->assertSee('Certificado emitido: Curso de prueba');
    }

    public function test_non_google_student_can_update_phone_name_and_password_from_profile(): void
    {
        $student = User::factory()->create(['role' => 'student', 'phone' => '+51 900000000', 'password' => 'clave-vieja12']);

        $this->actingAs($student)->post(route('panel.profile.update'), [
            'name' => 'Nuevo Nombre',
            'phone' => '+51 911111111',
            'password' => 'clave-nueva123',
            'password_confirmation' => 'clave-nueva123',
        ])->assertRedirect(route('panel.profile'));

        $student->refresh();
        $this->assertSame('Nuevo Nombre', $student->name);
        $this->assertSame('+51 911111111', $student->phone);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('clave-nueva123', $student->password));
    }

    public function test_google_student_cannot_change_name_and_password_from_profile(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
            'phone' => '+51 900000000',
            'google_id' => 'g-999',
            'name' => 'Nombre De Google',
        ]);

        $this->actingAs($student)->post(route('panel.profile.update'), [
            'phone' => '+51 922222222',
        ])->assertRedirect(route('panel.profile'));

        $student->refresh();
        $this->assertSame('Nombre De Google', $student->name);
        $this->assertSame('+51 922222222', $student->phone);
    }
}
