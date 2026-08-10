<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author', 'category')->latest()->get();

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return $this->form(new Article());
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $this->applyStatus($data, $request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('articles/covers', 'public');
        }

        $tags = $this->extractTags($request);
        unset($data['tags']);

        $article = Article::create($data);
        $article->tags()->sync($tags);

        return redirect()->route('admin.articulos.index')->with('success', 'Artículo creado correctamente.');
    }

    public function edit(Article $article)
    {
        return $this->form($article);
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validated($request);

        if ($data['title'] !== $article->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $article->id);
        }

        $this->applyStatus($data, $request, $article);

        if ($request->hasFile('cover_image')) {
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('articles/covers', 'public');
        }

        $tags = $this->extractTags($request);
        unset($data['tags']);

        $article->update($data);
        $article->tags()->sync($tags);

        return redirect()->route('admin.articulos.index')->with('success', 'Artículo actualizado correctamente.');
    }

    public function destroy(Article $article)
    {
        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }

        $article->delete();

        return redirect()->route('admin.articulos.index')->with('success', 'Artículo eliminado.');
    }

    private function form(Article $article)
    {
        $categories = ArticleCategory::orderBy('name')->get();
        $authors = User::teamMembers()->get();
        $tagNames = $article->exists ? $article->tags->pluck('name')->implode(', ') : '';

        return view('admin.articles.form', compact('article', 'categories', 'authors', 'tagNames'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author_id' => ['required', 'exists:users,id'],
            'article_category_id' => ['nullable', 'exists:article_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'reading_minutes' => ['nullable', 'integer', 'min:1'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'tags' => ['nullable', 'string'],
        ]);
    }

    private function applyStatus(array &$data, Request $request, ?Article $article = null): void
    {
        $publish = $request->input('action') === 'publish';
        $data['status'] = $publish ? 'published' : 'draft';

        if ($publish && ! ($article?->published_at)) {
            $data['published_at'] = now();
        }
    }

    private function extractTags(Request $request): array
    {
        $names = array_filter(array_map('trim', explode(',', (string) $request->input('tags'))));
        $ids = [];

        foreach ($names as $name) {
            $tag = Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
            $ids[] = $tag->id;
        }

        return $ids;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (Article::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-".++$i;
        }

        return $slug;
    }
}
