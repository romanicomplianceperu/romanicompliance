<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_student_cannot_access_admin(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $this->actingAs($student)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_view_dashboard_and_lists(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/admin')->assertOk();
        $this->actingAs($admin)->get('/admin/categories')->assertOk();
        $this->actingAs($admin)->get('/admin/categories/create')->assertOk();
        $this->actingAs($admin)->get('/admin/courses')->assertOk();
        $this->actingAs($admin)->get('/admin/courses/create')->assertOk();
    }

    public function test_admin_can_manage_category_course_module_and_lesson(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'Prevención LA/FT',
        ])->assertRedirect('/admin/categories');

        $category = Category::first();
        $this->assertSame('prevencion-laft', $category->slug);

        $this->actingAs($admin)->post('/admin/courses', [
            'title' => 'Curso SPLAFT Básico',
            'category_id' => $category->id,
            'description' => 'Curso de prueba',
            'instructor_name' => 'Denis Romani',
            'duration_hours' => 2,
            'is_published' => '1',
            'certificate_type' => 'gratuita',
        ])->assertRedirect('/admin/courses');

        $course = Course::first();
        $this->assertTrue($course->is_published);
        $this->assertSame(120, $course->duration_minutes);

        $this->actingAs($admin)->get(route('admin.courses.edit', $course))->assertOk();

        $this->actingAs($admin)->post(route('admin.modules.store', $course), [
            'title' => 'Módulo 1: Introducción',
        ])->assertRedirect(route('admin.courses.edit', $course));

        $module = $course->modules()->first();
        $this->assertNotNull($module);

        $this->actingAs($admin)->post(route('admin.lessons.store', $module), [
            'title' => 'Bienvenida al curso',
            'type' => 'video',
            'video_url' => 'https://youtube.com/watch?v=abc123',
        ])->assertRedirect(route('admin.courses.edit', $course));

        $this->assertSame(1, $module->lessons()->count());

        $lesson = $module->lessons()->first();
        $this->actingAs($admin)->delete(route('admin.lessons.destroy', $lesson))
            ->assertRedirect(route('admin.courses.edit', $course));
        $this->assertSame(0, $module->lessons()->count());

        $this->actingAs($admin)->delete(route('admin.courses.destroy', $course))
            ->assertRedirect('/admin/courses');
        $this->assertSame(0, Course::count());
    }
}
