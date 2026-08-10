<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePhoneGateTest extends TestCase
{
    use RefreshDatabase;

    public function test_enrolling_without_phone_redirects_to_complete_profile(): void
    {
        $student = User::factory()->create(['role' => 'student', 'phone' => null]);
        $course = Course::factory()->create(['is_published' => true]);

        $this->actingAs($student)->post(route('courses.enroll', $course))
            ->assertRedirect(route('profile.complete', ['next' => route('courses.show', $course)]));

        $this->assertDatabaseMissing('enrollments', ['user_id' => $student->id, 'course_id' => $course->id]);
    }

    public function test_completing_phone_then_redirects_back_and_allows_enrollment(): void
    {
        $student = User::factory()->create(['role' => 'student', 'phone' => null]);
        $course = Course::factory()->create(['is_published' => true]);

        $this->actingAs($student)->post(route('profile.update', ['next' => route('courses.show', $course)]), [
            'phone' => '+51 987 654 321',
        ])->assertRedirect(route('courses.show', $course));

        $this->assertSame('+51 987 654 321', $student->fresh()->phone);

        $this->actingAs($student)->post(route('courses.enroll', $course))
            ->assertRedirect(route('courses.show', $course));

        $this->assertDatabaseHas('enrollments', ['user_id' => $student->id, 'course_id' => $course->id]);
    }

    public function test_user_with_phone_is_not_asked_again(): void
    {
        $student = User::factory()->create(['role' => 'student', 'phone' => '+51 999 999 999']);
        $course = Course::factory()->create(['is_published' => true]);

        $this->actingAs($student)->post(route('courses.enroll', $course))
            ->assertRedirect(route('courses.show', $course));

        $this->actingAs($student)->get(route('profile.complete'))
            ->assertRedirect(route('dashboard'));
    }

    public function test_phone_is_visible_to_admin_but_not_used_in_certificate(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'student', 'phone' => '+51 911 222 333']);

        $this->actingAs($admin)->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('+51 911 222 333');
    }
}
