<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Support\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * A deliberately simple, single-purpose publishing screen for Federico
 * Chunga. It is gated by a single shared password (not a full account
 * login) — see the constant below — and lets him write, preview and
 * publish an article straight to the public blog without touching the
 * admin panel.
 */
class FedericoEditorController extends Controller
{
    private const PASSWORD = 'vivanlosderechoshumanos';

    private const SESSION_KEY = 'federico_editor_authed';

    private const AUTHOR_EMAIL = 'federico.chunga@romanicompliance.com';

    public function gate(Request $request)
    {
        if ($request->session()->get(self::SESSION_KEY)) {
            return redirect()->route('federico.editor');
        }

        return view('federico.gate');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (! hash_equals(self::PASSWORD, (string) $request->input('password'))) {
            return back()->withErrors(['password' => 'Contraseña incorrecta. Inténtalo de nuevo.']);
        }

        $request->session()->put(self::SESSION_KEY, true);

        return redirect()->route('federico.editor');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('federico.gate');
    }

    public function editor(Request $request)
    {
        if ($redirect = $this->requireAuthed($request)) {
            return $redirect;
        }

        $author = $this->author();

        $recent = Article::query()
            ->where('author_id', $author?->id)
            ->latest()
            ->take(8)
            ->get();

        return view('federico.editor', [
            'author' => $author,
            'recent' => $recent,
        ]);
    }

    public function uploadImage(Request $request)
    {
        if (! $request->session()->get(self::SESSION_KEY)) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $request->validate([
            'image' => ['required', 'image', 'max:4096'],
        ]);

        $path = $request->file('image')->store('articles/content', 'public');

        return response()->json([
            'location' => Storage::disk('public')->url($path),
        ]);
    }

    public function store(Request $request)
    {
        if ($redirect = $this->requireAuthed($request)) {
            return $redirect;
        }

        $author = $this->author();

        if (! $author) {
            return back()->withErrors(['title' => 'No se encontró la cuenta de Federico Chunga. Contacta al administrador del sitio.']);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'action' => ['required', 'in:draft,publish'],
        ]);

        $content = HtmlSanitizer::clean($data['content']);

        if (trim(strip_tags($content)) === '') {
            return back()->withInput()->withErrors(['content' => 'Escribe el contenido del artículo antes de continuar.']);
        }

        $wordCount = str_word_count(strip_tags($content));

        $article = new Article();
        $article->author_id = $author->id;
        $article->title = $data['title'];
        $article->slug = $this->uniqueSlug($data['title']);
        $article->excerpt = $data['excerpt'] ?? Str::limit(strip_tags($content), 160);
        $article->content = $content;
        $article->reading_minutes = max(1, (int) ceil($wordCount / 200));

        if ($request->hasFile('cover_image')) {
            $article->cover_image = $request->file('cover_image')->store('articles/covers', 'public');
        }

        if ($data['action'] === 'publish') {
            $article->status = 'published';
            $article->published_at = now();
        } else {
            $article->status = 'draft';
        }

        $article->save();

        if ($article->isPublished()) {
            return redirect()->route('blog.show', $article->slug)
                ->with('federico_success', '¡Publicado! Ya está visible en la web de Romani Compliance.');
        }

        return redirect()->route('federico.editor')
            ->with('federico_success', 'Borrador guardado. Aún no está visible en la web.');
    }

    private function requireAuthed(Request $request): ?\Illuminate\Http\RedirectResponse
    {
        if ($request->session()->get(self::SESSION_KEY)) {
            return null;
        }

        return redirect()->route('federico.gate');
    }

    private function author(): ?User
    {
        return User::where('email', self::AUTHOR_EMAIL)->first();
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$base}-".++$i;
        }

        return $slug;
    }
}
