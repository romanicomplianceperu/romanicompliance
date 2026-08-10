<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseCertificateBadgeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_set_certificate_type_on_course(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('admin.courses.store'), [
            'title' => 'Curso con certificación opcional',
            'certificate_type' => 'opcional',
            'certificate_price' => 49.90,
        ])->assertRedirect(route('admin.courses.index'));

        $course = Course::first();
        $this->assertSame('opcional', $course->certificate_type);
        $this->assertEquals(49.90, $course->certificate_price);
    }

    public function test_certificate_badge_shows_on_catalog_and_course_page(): void
    {
        $free = Course::factory()->create(['certificate_type' => 'gratuita', 'is_published' => true]);
        $optional = Course::factory()->create(['certificate_type' => 'opcional', 'is_published' => true]);

        $this->get(route('courses.catalog'))
            ->assertOk()
            ->assertSee('Certificación gratuita')
            ->assertSee('Certificación opcional');

        $this->get(route('courses.show', $free))->assertOk()->assertSee('Certificación gratuita');
        $this->get(route('courses.show', $optional))->assertOk()->assertSee('Certificación opcional');
    }
}
