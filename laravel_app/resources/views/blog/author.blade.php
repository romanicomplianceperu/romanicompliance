@extends('layouts.app')

@section('title', $user->name.' — Autor — Romani Compliance')
@section('description', $user->bio ? \Illuminate\Support\Str::limit($user->bio, 150) : $user->name)

@section('styles')
.author-hero { background: var(--ink); padding: 4rem 0 3.5rem; position: relative; }
.author-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
.author-hero-inner { display: flex; gap: 2rem; align-items: center; }
.author-hero-photo { width: 120px; height: 120px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 3px solid var(--gold-light); }
.author-hero-photo img { width: 100%; height: 100%; object-fit: cover; }
.author-hero h1 { font-size: clamp(1.5rem, 3vw, 2rem); color: var(--white); font-weight: 400; margin-bottom: 0.3rem; }
.author-hero .role { font-size: 0.82rem; color: var(--gold-light); font-weight: 600; margin-bottom: 0.8rem; }
.author-hero p { font-size: 0.85rem; color: rgba(255,255,255,0.5); max-width: 600px; line-height: 1.7; white-space: pre-line; }

.author-articles { padding: 3.5rem 0; }
.article-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }

@media (max-width: 900px) {
  .author-hero-inner { flex-direction: column; text-align: center; }
  .article-grid { grid-template-columns: 1fr; max-width: 480px; margin: 0 auto; }
}
@endsection

@section('content')
<section class="author-hero">
  <div class="wrap author-hero-inner">
    <div class="author-hero-photo">
      <img src="{{ $user->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $user->name }}">
    </div>
    <div>
      <h1>{{ $user->name }}</h1>
      @if($user->title)<div class="role">{{ $user->title }}</div>@endif
      @if($user->bio)<p>{{ $user->bio }}</p>@endif
    </div>
  </div>
</section>

<section class="author-articles">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Artículos publicados</h2>
    </div>
    @if($articles->isEmpty())
      <div class="empty-state" style="text-align:center;padding:3rem;color:var(--slate);border:1px dashed var(--line);border-radius:8px;">Este autor todavía no ha publicado artículos.</div>
    @else
      <div class="article-grid">
        @foreach($articles as $article)
          @include('blog._article-card', ['article' => $article])
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection
