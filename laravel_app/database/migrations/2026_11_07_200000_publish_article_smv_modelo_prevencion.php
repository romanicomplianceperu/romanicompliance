<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

/**
 * Publica el artículo de Denis Romani sobre los requerimientos fiscales a la SMV
 * (Boletín Modelo de Prevención de Delitos N.° 51). El texto está en
 * database/content/articulo-smv-modelo-prevencion.html, tal como lo entregó el autor.
 * Es idempotente: si se vuelve a correr, actualiza el mismo artículo.
 */
return new class extends Migration
{
    private const SLUG = 'responsabilidad-persona-juridica-26-requerimientos-fiscales-un-solo-informe-tecnico';

    public function up(): void
    {
        $author = User::where('email', 'denis@romanicompliance.com')->first()
            ?? User::where('name', 'like', 'Denis%Romani%')->first();
        if (! $author) {
            return;
        }

        $content = trim((string) file_get_contents(database_path('content/articulo-smv-modelo-prevencion.html')));
        $words = str_word_count(strip_tags($content));

        $category = ArticleCategory::firstOrCreate(['slug' => 'compliance-penal'], ['name' => 'Compliance penal']);

        $article = Article::updateOrCreate(['slug' => self::SLUG], [
            'author_id' => $author->id,
            'article_category_id' => $category->id,
            'type' => 'articulo_especializado',
            'title' => 'Responsabilidad de la persona jurídica: 26 requerimientos fiscales y un solo informe técnico sobre el modelo de prevención',
            'excerpt' => 'La responsabilidad administrativa de las personas jurídicas por delitos se discute casi siempre desde el catálogo de delitos y la severidad de las sanciones. Yo quiero plantear otra pregunta: si el mecanismo que ya existe, el análisis del modelo de prevención, se está aplicando.',
            'content' => $content,
            'cover_image' => 'images/blog/smv-modelo-prevencion.jpg',
            'reading_minutes' => max(1, (int) round($words / 200)),
            'status' => 'published',
            'published_at' => Article::where('slug', self::SLUG)->value('published_at') ?? now(),
        ]);

        $tagIds = collect(['Derecho Penal', 'Compliance', 'Ley 30424', 'Lavado de Activos'])
            ->map(fn ($name) => Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name])->id);
        $article->tags()->sync($tagIds);
    }

    public function down(): void
    {
        Article::where('slug', self::SLUG)->first()?->tags()->detach();
        Article::where('slug', self::SLUG)->delete();
    }
};
