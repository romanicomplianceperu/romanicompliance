<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->with('author', 'category');

        if ($request->filled('q')) {
            $term = '%'.$request->string('q').'%';
            $query->where(fn ($q) => $q->where('title', 'like', $term)->orWhere('excerpt', 'like', $term));
        }

        if ($request->filled('categoria')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->string('categoria')));
        }

        if ($request->filled('etiqueta')) {
            $query->whereHas('tags', fn ($q) => $q->where('slug', $request->string('etiqueta')));
        }

        $articles = $query->paginate(9)->withQueryString();
        $categories = ArticleCategory::withCount(['articles' => fn ($q) => $q->published()])->orderBy('name')->get();
        $tags = Tag::withCount(['articles' => fn ($q) => $q->published()])->orderBy('name')->get();
        $recent = Article::published()->take(5)->get();

        return view('blog.index', compact('articles', 'categories', 'tags', 'recent'));
    }

    public function show(Article $article)
    {
        abort_unless($article->isPublished(), 404);

        $article->load('author', 'category', 'tags');
        $article->increment('views_count');

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->when($article->article_category_id, fn ($q) => $q->where('article_category_id', $article->article_category_id))
            ->take(3)
            ->get();

        $recent = Article::published()->where('id', '!=', $article->id)->take(5)->get();

        return view('blog.show', compact('article', 'related', 'recent'));
    }

    public function author(User $user)
    {
        abort_unless($user->is_team_member, 404);

        $articles = $user->articles()->published()->paginate(9);

        return view('blog.author', compact('user', 'articles'));
    }
}
