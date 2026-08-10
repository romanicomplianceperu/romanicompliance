<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_article_as_draft_and_then_publish_it(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $author = User::factory()->create(['is_team_member' => true, 'name' => 'Autora Equipo']);
        $category = ArticleCategory::create(['name' => 'Compliance', 'slug' => 'compliance']);

        $response = $this->actingAs($admin)->post(route('admin.articulos.store'), [
            'title' => 'Mi primer artículo de prueba',
            'author_id' => $author->id,
            'article_category_id' => $category->id,
            'excerpt' => 'Resumen breve',
            'content' => 'Contenido completo del artículo.',
            'reading_minutes' => 5,
            'tags' => 'splaft, compliance',
            'cover_image' => UploadedFile::fake()->image('cover.jpg'),
            'action' => 'draft',
        ]);

        $response->assertRedirect(route('admin.articulos.index'));

        $article = Article::first();
        $this->assertSame('draft', $article->status);
        $this->assertNull($article->published_at);
        $this->assertSame(2, $article->tags()->count());
        Storage::disk('public')->assertExists($article->cover_image);

        // Draft should not be publicly visible yet.
        $this->get(route('blog.index'))->assertOk()->assertDontSee('Mi primer artículo de prueba');

        $this->actingAs($admin)->put(route('admin.articulos.update', $article), [
            'title' => $article->title,
            'author_id' => $author->id,
            'content' => $article->content,
            'action' => 'publish',
        ])->assertRedirect(route('admin.articulos.index'));

        $article->refresh();
        $this->assertSame('published', $article->status);
        $this->assertNotNull($article->published_at);

        $this->get(route('blog.index'))->assertOk()->assertSee('Mi primer artículo de prueba');
    }

    public function test_non_admin_cannot_manage_articles(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $this->actingAs($student)->get(route('admin.articulos.index'))->assertForbidden();
    }
}
