<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_student_can_register_with_email_and_password_and_is_logged_in(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Ana Torres',
            'email' => 'ana.torres@example.com',
            'phone' => '+51 987654321',
            'password' => 'clave-segura-123',
            'password_confirmation' => 'clave-segura-123',
        ]);

        $response->assertRedirect(route('dashboard'));

        $user = User::where('email', 'ana.torres@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('student', $user->role);
        $this->assertSame('+51 987654321', $user->phone);
        $this->assertNull($user->google_id);
        $this->assertAuthenticatedAs($user);
    }

    public function test_registration_requires_matching_password_confirmation(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Ana Torres',
            'email' => 'ana.torres@example.com',
            'phone' => '+51 987654321',
            'password' => 'clave-segura-123',
            'password_confirmation' => 'otra-clave',
        ])->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function test_registered_student_can_log_in_with_email_and_password(): void
    {
        $user = User::factory()->create(['role' => 'student', 'password' => 'clave-123456']);

        $this->post(route('login.attempt'), [
            'email' => $user->email,
            'password' => 'clave-123456',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_password_is_rejected_on_student_login(): void
    {
        $user = User::factory()->create(['role' => 'student', 'password' => 'clave-123456']);

        $this->post(route('login.attempt'), [
            'email' => $user->email,
            'password' => 'incorrecta',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_google_only_account_cannot_log_in_with_a_password(): void
    {
        $user = User::factory()->create(['role' => 'student', 'password' => null, 'google_id' => 'g-123']);

        $this->post(route('login.attempt'), [
            'email' => $user->email,
            'password' => 'cualquier-cosa',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
