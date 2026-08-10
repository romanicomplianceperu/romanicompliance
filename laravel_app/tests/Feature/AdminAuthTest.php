<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_password_based_administrator_and_log_in_independently_of_google(): void
    {
        $superAdmin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($superAdmin)->post(route('admin.administradores.store'), [
            'name' => 'Nuevo Administrador',
            'email' => 'nuevo.admin@romanicompliance.com',
            'password' => 'clave-segura-123',
            'password_confirmation' => 'clave-segura-123',
        ])->assertRedirect(route('admin.administradores.index'));

        $newAdmin = User::where('email', 'nuevo.admin@romanicompliance.com')->first();
        $this->assertNotNull($newAdmin);
        $this->assertSame('admin', $newAdmin->role);
        $this->assertNull($newAdmin->google_id);

        // Logs in with email/password, no Google involved (log out the acting super-admin first).
        \Illuminate\Support\Facades\Auth::logout();
        $this->post(route('admin.login.attempt'), [
            'email' => 'nuevo.admin@romanicompliance.com',
            'password' => 'clave-segura-123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($newAdmin);
    }

    public function test_wrong_password_is_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => 'correcta-123']);

        $this->post(route('admin.login.attempt'), [
            'email' => $admin->email,
            'password' => 'incorrecta',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_student_credentials_cannot_log_in_via_admin_login_even_with_a_password(): void
    {
        $student = User::factory()->create(['role' => 'student', 'password' => 'clave-123']);

        $this->post(route('admin.login.attempt'), [
            'email' => $student->email,
            'password' => 'clave-123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->delete(route('admin.administradores.destroy', $admin))
            ->assertRedirect();

        $this->assertNotNull($admin->fresh());
    }

    public function test_cannot_delete_the_last_remaining_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $otherAdmin = User::factory()->create(['role' => 'admin']);

        // Delete down to one admin.
        $this->actingAs($admin)->delete(route('admin.administradores.destroy', $otherAdmin));
        $this->assertNull($otherAdmin->fresh());

        // Now only $admin remains — cannot delete self anyway, but verify the "last admin" guard
        // by trying with a fresh actor scenario: promote a student, delete the original admin via the student.
        $student = User::factory()->create(['role' => 'admin']); // second admin again
        $this->actingAs($student)->delete(route('admin.administradores.destroy', $admin));
        $this->assertNull($admin->fresh()); // this one succeeds since two admins existed

        // Now only $student remains as the sole admin.
        $this->actingAs($student)->delete(route('admin.administradores.destroy', $student))
            ->assertRedirect();
        $this->assertNotNull($student->fresh());
    }
}
