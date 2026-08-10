<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_browse_catalog_and_course_summary(): void
    {
        $course = Course::factory()->create(['is_published' => true]);

        $this->get(route('courses.catalog'))->assertOk()->assertSee($course->title);
        $this->get(route('courses.show', $course))->assertOk()->assertSee($course->title);
    }

    public function test_guest_is_redirected_to_login_when_enrolling(): void
    {
        $course = Course::factory()->create(['is_published' => true]);

        $this->post(route('courses.enroll', $course))->assertRedirect(route('login'));
    }

    public function test_google_redirect_stores_intended_url_in_session(): void
    {
        $course = Course::factory()->create(['is_published' => true]);

        $this->get(route('auth.google.redirect', ['intended' => route('courses.show', $course)]))
            ->assertRedirect();

        $this->assertSame(route('courses.show', $course), session('url.intended'));
    }

    public function test_home_page_shows_published_courses(): void
    {
        $course = Course::factory()->create(['is_published' => true, 'title' => 'Curso Visible En Home']);
        Course::factory()->create(['is_published' => false, 'title' => 'Curso Oculto']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Curso Visible En Home')
            ->assertDontSee('Curso Oculto');
    }
}
