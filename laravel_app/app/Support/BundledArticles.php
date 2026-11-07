<?php

namespace App\Support;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Artículos que vienen incluidos en el código (texto en database/content). Se publican
 * solos la primera vez que se visita el sitio tras un despliegue, sin correr comandos.
 * Para agregar uno: sumar su ficha a ARTICLES y cambiar VERSION.
 */
class BundledArticles
{
    private const VERSION = 'v1';

    private const ARTICLES = [
        [
            'slug' => 'responsabilidad-persona-juridica-26-requerimientos-fiscales-un-solo-informe-tecnico',
            'file' => 'articulo-smv-modelo-prevencion.html',
            'title' => 'Responsabilidad de la persona jurídica: 26 requerimientos fiscales y un solo informe técnico sobre el modelo de prevención',
            'excerpt' => 'La responsabilidad administrativa de las personas jurídicas por delitos se discute casi siempre desde el catálogo de delitos y la severidad de las sanciones. Yo quiero plantear otra pregunta: si el mecanismo que ya existe, el análisis del modelo de prevención, se está aplicando.',
            'cover' => 'images/blog/smv-modelo-prevencion.jpg',
            'type' => 'articulo_especializado',
            'category' => ['compliance-penal', 'Compliance penal'],
            'tags' => ['Derecho Penal', 'Compliance', 'Ley 30424', 'Lavado de Activos'],
            'author_email' => 'denis@romanicompliance.com',
            'author_name' => 'Romani',
        ],
    ];

    /** Se llama en cada visita; trabaja de verdad una sola vez por versión. */
    public static function ensure(): void
    {
        $key = 'bundled_articles_'.self::VERSION;
        try {
            if (Cache::get($key)) {
                return;
            }
        } catch (\Throwable $e) {
            // Si la caché falla, se sigue: la consulta de abajo es liviana.
        }
        try {
            if (! Schema::hasTable('articles')) {
                return;
            }
            $missing = collect(self::ARTICLES)->reject(fn ($d) => Article::where('slug', $d['slug'])->where('status', 'published')->exists());
            foreach ($missing as $data) {
                self::publish($data);
            }
            rescue(fn () => Cache::forever($key, true), null, false);
        } catch (\Throwable $e) {
            Log::warning('No se pudo publicar un artículo incluido: '.$e->getMessage());
            rescue(fn () => Cache::put($key, true, now()->addMinutes(10)), null, false);
        }
    }

    public static function publish(array $data): ?Article
    {
        $author = User::where('email', $data['author_email'])->first()
            ?? User::where('name', 'like', '%'.$data['author_name'].'%')->orderBy('id')->first()
            ?? User::where('role', 'admin')->orderBy('id')->first()
            ?? User::orderBy('id')->first();
        if (! $author) {
            return null;
        }

        $content = trim((string) file_get_contents(database_path('content/'.$data['file'])));
        [$catSlug, $catName] = $data['category'];
        $category = ArticleCategory::firstOrCreate(['slug' => $catSlug], ['name' => $catName]);
        $existing = Article::where('slug', $data['slug'])->first();

        $article = Article::updateOrCreate(['slug' => $data['slug']], [
            'author_id' => $author->id,
            'article_category_id' => $category->id,
            'type' => $data['type'],
            'title' => $data['title'],
            'excerpt' => $data['excerpt'],
            'content' => $content,
            'cover_image' => $data['cover'],
            'reading_minutes' => max(1, (int) round(str_word_count(strip_tags($content)) / 200)),
            'status' => 'published',
            'published_at' => $existing?->published_at ?? now(),
        ]);

        $article->tags()->sync(collect($data['tags'])->map(fn ($n) => Tag::firstOrCreate(['slug' => Str::slug($n)], ['name' => $n])->id));

        return $article;
    }
}
