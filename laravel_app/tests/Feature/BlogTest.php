<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_shows_only_published_articles(): void
    {
        $published = Article::factory()->create(['status' => 'published', 'title' => 'Artículo Publicado']);
        Article::factory()->create(['status' => 'draft', 'title' => 'Artículo Borrador']);

        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee('Artículo Publicado')
            ->assertDontSee('Artículo Borrador');
    }

    public function test_draft_article_returns_404_when_visited_directly(): void
    {
        $draft = Article::factory()->create(['status' => 'draft']);

        $this->get(route('blog.show', $draft))->assertNotFound();
    }

    public function test_show_increments_view_count_and_displays_author(): void
    {
        $author = User::factory()->create(['name' => 'Autor De Prueba', 'is_team_member' => true]);
        $article = Article::factory()->create(['author_id' => $author->id, 'views_count' => 5]);

        $this->get(route('blog.show', $article))
            ->assertOk()
            ->assertSee('Autor De Prueba');

        $this->assertSame(6, $article->fresh()->views_count);
    }

    public function test_author_page_lists_only_their_published_articles(): void
    {
        $author = User::factory()->create(['is_team_member' => true]);
        $other = User::factory()->create(['is_team_member' => true]);
        Article::factory()->create(['author_id' => $author->id, 'title' => 'Mío Publicado', 'status' => 'published']);
        Article::factory()->create(['author_id' => $author->id, 'title' => 'Mío Borrador', 'status' => 'draft']);
        Article::factory()->create(['author_id' => $other->id, 'title' => 'De Otro Autor', 'status' => 'published']);

        $this->get(route('blog.author', $author))
            ->assertOk()
            ->assertSee('Mío Publicado')
            ->assertDontSee('Mío Borrador')
            ->assertDontSee('De Otro Autor');
    }

    public function test_filters_by_category_and_tag(): void
    {
        $category = ArticleCategory::create(['name' => 'Compliance', 'slug' => 'compliance']);
        $otherCategory = ArticleCategory::create(['name' => 'BCRP', 'slug' => 'bcrp']);
        $tag = Tag::create(['name' => 'SPLAFT', 'slug' => 'splaft']);

        $match = Article::factory()->create(['title' => 'Artículo De Compliance', 'article_category_id' => $category->id]);
        $match->tags()->attach($tag);
        Article::factory()->create(['title' => 'Artículo De BCRP', 'article_category_id' => $otherCategory->id]);

        $assertOnlyMatches = function ($articles) {
            $titles = $articles->pluck('title');

            return $titles->contains('Artículo De Compliance') && ! $titles->contains('Artículo De BCRP');
        };

        $this->get(route('blog.index', ['categoria' => 'compliance']))
            ->assertOk()
            ->assertViewHas('articles', $assertOnlyMatches);

        $this->get(route('blog.index', ['etiqueta' => 'splaft']))
            ->assertOk()
            ->assertViewHas('articles', $assertOnlyMatches);
    }
}
