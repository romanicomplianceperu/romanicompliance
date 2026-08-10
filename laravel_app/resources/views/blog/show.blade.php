@extends('layouts.app')

@section('title', $article->title.' — Romani Compliance')
@section('description', $article->excerpt)

@section('styles')
.article-hero { background: var(--ink); padding: 3rem 0 2rem; position: relative; }
.article-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
.article-hero-category { display: inline-block; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: var(--gold); color: var(--white); padding: 5px 14px; border-radius: 20px; margin-bottom: 1rem; }
.article-hero h1 { font-size: clamp(1.6rem, 3.5vw, 2.4rem); color: var(--white); font-weight: 400; line-height: 1.25; margin-bottom: 1rem; max-width: 780px; }
.article-hero-meta { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 0.4rem; }
.article-hero-meta span { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; background: rgba(255,255,255,0.08); color: var(--gold-light); padding: 5px 12px; border-radius: 20px; }

.article-cover { max-width: 900px; margin: 2rem auto 0; padding: 0 24px; }
.article-cover img { width: 100%; aspect-ratio: 21 / 9; object-fit: cover; border-radius: 8px; box-shadow: var(--shadow-m); display: block; }

.article-layout { display: grid; grid-template-columns: 2.3fr 1fr; gap: 2.5rem; align-items: start; padding: 3rem 0; }
.article-body { font-size: 0.95rem; color: var(--ink); line-height: 1.9; white-space: pre-line; }
.article-body p { margin-bottom: 1.2rem; }

.author-card { display: flex; gap: 1rem; align-items: center; background: var(--ivory); border: 1px solid var(--line); border-radius: 8px; padding: 1.2rem; margin-bottom: 2rem; }
.author-card img { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
.author-card a.author-name { font-size: 0.95rem; font-weight: 700; color: var(--ink); }
.author-card a.author-name:hover { color: var(--gold); }
.author-card .author-title { font-size: 0.76rem; color: var(--gold); font-weight: 600; margin-bottom: 2px; }
.author-card p { font-size: 0.8rem; color: var(--slate); margin: 0; }

.tags-row { display: flex; flex-wrap: wrap; gap: 6px; margin: 2rem 0; }
.tags-row a { font-size: 0.72rem; padding: 5px 12px; background: var(--ivory-dim); color: var(--slate); border-radius: 20px; }
.tags-row a:hover { background: var(--gold-pale); color: var(--gold); }

.share-row { display: flex; align-items: center; gap: 10px; padding: 1.2rem 0; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); margin-bottom: 2.5rem; }
.share-row span { font-size: 0.78rem; font-weight: 600; color: var(--slate); margin-right: 6px; }
.share-btn { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--ivory-dim); color: var(--slate); transition: background 0.2s, color 0.2s; }
.share-btn:hover { background: var(--gold); color: var(--white); }
.share-btn svg { width: 15px; height: 15px; fill: currentColor; }

.related-section h3, .sidebar-title { font-size: 1rem; margin-bottom: 1.2rem; }
.related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem; }

@media (max-width: 900px) {
  .article-layout { grid-template-columns: 1fr; }
  .related-grid { grid-template-columns: 1fr; }
  .article-cover img { height: 220px; }
  .author-card { flex-direction: column; text-align: center; }
}
@endsection

@section('content')
<section class="article-hero">
  <div class="wrap">
    @if($article->category)
      <span class="article-hero-category">{{ $article->category->name }}</span>
    @endif
    <h1>{{ $article->title }}</h1>
    <div class="article-hero-meta">
      <span>{{ $article->published_at?->translatedFormat('d \d\e F \d\e Y') }}</span>
      @if($article->reading_minutes)<span>{{ $article->reading_minutes }} min de lectura</span>@endif
    </div>
  </div>
</section>

@if($article->cover_image)
  <div class="article-cover">
    <img src="{{ asset('storage/'.$article->cover_image) }}" alt="{{ $article->title }}">
  </div>
@endif

<section class="wrap article-layout">
  <div>
    <div class="author-card">
      <img src="{{ $article->author->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $article->author->name }}">
      <div>
        <div class="author-title">{{ $article->author->title }}</div>
        <a href="{{ route('blog.author', $article->author) }}" class="author-name">{{ $article->author->name }}</a>
        <p>{{ \Illuminate\Support\Str::limit($article->author->bio, 110) }}</p>
      </div>
    </div>

    <div class="article-body">{{ $article->content }}</div>

    @if($article->tags->isNotEmpty())
      <div class="tags-row">
        @foreach($article->tags as $tag)
          <a href="{{ route('blog.index', ['etiqueta' => $tag->slug]) }}">#{{ $tag->name }}</a>
        @endforeach
      </div>
    @endif

    <div class="share-row">
      <span>Compartir:</span>
      <a class="share-btn" target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" aria-label="Compartir en Facebook">
        <svg viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0022 12z"/></svg>
      </a>
      <a class="share-btn" target="_blank" rel="noopener" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" aria-label="Compartir en LinkedIn">
        <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
      </a>
      <a class="share-btn" target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" aria-label="Compartir en X">
        <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
      </a>
      <a class="share-btn" target="_blank" rel="noopener" href="https://api.whatsapp.com/send?text={{ urlencode($article->title.' '.url()->current()) }}" aria-label="Compartir en WhatsApp">
        <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347M12.05 22c-1.75 0-3.46-.47-4.96-1.36l-.35-.21-3.68.97.99-3.59-.23-.37a9.86 9.86 0 01-1.51-5.26C2.31 6.73 6.73 2.31 12.05 2.31c2.58 0 5 1.01 6.82 2.83a9.72 9.72 0 012.83 6.86c0 5.32-4.42 9.74-9.65 9.74"/></svg>
      </a>
    </div>

    @if($related->isNotEmpty())
      <div class="related-section">
        <h3>Artículos relacionados</h3>
        <div class="related-grid">
          @foreach($related as $item)
            @include('blog._article-card', ['article' => $item])
          @endforeach
        </div>
      </div>
    @endif
  </div>

  <aside>
    @if($recent->isNotEmpty())
      <div class="blog-sidebar-block" style="background:var(--white);border:1px solid var(--line);border-radius:8px;padding:1.4rem;">
        <h4 class="sidebar-title">Artículos recientes</h4>
        @foreach($recent as $item)
          <div class="recent-item" style="display:flex;gap:10px;align-items:flex-start;margin-bottom:1rem;">
            <img src="{{ $item->cover_image ? asset('storage/'.$item->cover_image) : asset('images/logos.png') }}" alt="{{ $item->title }}" style="width:52px;height:52px;object-fit:cover;border-radius:4px;flex-shrink:0;">
            <div>
              <a href="{{ route('blog.show', $item) }}" style="font-size:0.82rem;color:var(--ink);font-weight:600;line-height:1.4;">{{ $item->title }}</a>
              <div style="font-size:0.68rem;color:var(--slate-light);margin-top:2px;">{{ $item->published_at?->format('d/m/Y') }}</div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </aside>
</section>
@endsection
