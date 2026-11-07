@extends('layouts.site')

@section('title', $article->title.' · Romani Compliance')
@section('description', $article->excerpt)
@section('og_type', 'article')
@section('og_title', $article->title)
@if($article->coverUrl())
@section('og_image', $article->coverUrl())
@endif
@section('og_extra')
<meta property="article:published_time" content="{{ $article->published_at?->toIso8601String() }}">
<meta property="article:author" content="{{ $article->author->name }}">
@foreach($article->tags as $tag)<meta property="article:tag" content="{{ $tag->name }}">@endforeach
@endsection

@section('styles')
.ar-hero { padding: clamp(48px, 7vw, 96px) 0 clamp(28px, 4vw, 44px); }
.ar-hero .wrap { max-width: 920px; }
.ar-hero h1 { font-size: clamp(2.1rem, 4.6vw, 3.8rem); font-weight: 800; line-height: 1.08; letter-spacing: -0.035em; margin: 18px 0 22px; }
.ar-meta { display: flex; gap: 8px 18px; flex-wrap: wrap; color: var(--muted); font-weight: 600; font-size: .95rem; }
.ar-cover { max-width: 1120px; margin: 0 auto 8px; padding: 0 32px; }
.ar-cover img { width: 100%; max-height: 560px; object-fit: cover; border-radius: 26px; }
@media (max-width: 720px) { .ar-cover { padding: 0 20px; } .ar-cover img { border-radius: 18px; } }
.ar-lay { max-width: 1120px; margin: 0 auto; padding: clamp(36px, 5vw, 64px) 32px; display: grid; grid-template-columns: minmax(0, 1fr) 280px; gap: 56px; }
@media (max-width: 960px) { .ar-lay { grid-template-columns: 1fr; padding-left: 20px; padding-right: 20px; } }
.ar-author { display: flex; gap: 16px; align-items: center; padding: 18px 20px; border: 1px solid var(--line); border-radius: 18px; margin-bottom: 36px; }
.ar-author img { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; }
.ar-author a { font-weight: 800; }
.ar-author span { display: block; color: var(--muted); font-size: .9rem; }
.prose { font-size: 1.14rem; line-height: 1.85; color: #1E2B42; max-width: 70ch; }
.prose p { text-wrap: pretty; }
.prose .lead { font-size: 1.32rem; line-height: 1.65; color: var(--ink); font-weight: 500; letter-spacing: -0.01em; }
.prose h2 { padding-top: .2em; position: relative; }
.prose h2::before { content: ''; display: block; width: 36px; height: 4px; border-radius: 2px; background: var(--blue); margin-bottom: 14px; }
.prose ul.figures { list-style: none; padding: 0; display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 1.4em; }
.prose ul.figures li { margin: 0; background: var(--soft); border-radius: 18px; padding: 18px 20px; font-size: 1rem; line-height: 1.5; color: var(--muted); }
.prose ul.figures li strong { display: block; font-size: 2.3rem; line-height: 1; font-weight: 800; letter-spacing: -0.03em; color: var(--ink); margin-bottom: 8px; }
.prose ul.figures li:last-child { grid-column: 1 / -1; background: var(--ink); color: rgba(255,255,255,.78); }
.prose ul.figures li:last-child strong { color: var(--blue-l); }
.prose .obs { border-left: 4px solid var(--blue); background: var(--blue-50); border-radius: 0 18px 18px 0; padding: 18px 22px; }
.prose .obs p { margin: 0; }
.prose .obs strong { display: block; color: var(--ink); font-size: 1.12rem; line-height: 1.4; margin-bottom: 6px; }
.prose ul.questions { list-style: none; padding: 0; display: grid; gap: 10px; }
.prose ul.questions li { margin: 0; display: flex; gap: 14px; align-items: flex-start; padding: 14px 18px; border: 1px solid var(--line); border-radius: 16px; font-weight: 600; color: var(--ink); line-height: 1.5; }
.prose ul.questions li::before { content: '?'; flex-shrink: 0; width: 28px; height: 28px; border-radius: 50%; background: var(--blue); color: #fff; display: grid; place-items: center; font-weight: 800; font-size: .95rem; margin-top: 1px; }
.prose .callout { background: var(--ink); color: #fff; border-radius: 22px; padding: 26px 28px; }
.prose .callout p { margin: 0; font-size: 1.2rem; line-height: 1.65; color: rgba(255,255,255,.9); }
.prose .sources { margin-top: 2.2em; padding-top: 18px; border-top: 1px solid var(--line); font-size: .92rem; line-height: 1.6; color: var(--muted); font-style: italic; }
.prose .sources p + p { margin-top: .5em; }
.prose .sources a { font-style: normal; font-weight: 600; word-break: break-word; }
@media (max-width: 720px) {
  .prose { font-size: 1.06rem; line-height: 1.8; }
  .prose .lead { font-size: 1.16rem; }
  .prose h2 { font-size: 1.4rem; }
  .prose ul.figures { gap: 8px; }
  .prose ul.figures li { padding: 14px; font-size: .9rem; }
  .prose ul.figures li strong { font-size: 1.9rem; }
  .prose .obs { padding: 16px 18px; }
  .prose .callout { padding: 20px; border-radius: 18px; }
  .prose .callout p { font-size: 1.08rem; }
}
.prose > * + * { margin-top: 1.1em; }
.prose h2, .prose h3 { font-weight: 800; letter-spacing: -0.02em; line-height: 1.25; color: var(--ink); margin-top: 1.8em; }
.prose h2 { font-size: 1.7rem; } .prose h3 { font-size: 1.35rem; }
.prose a { color: var(--blue); text-decoration: underline; text-underline-offset: 3px; }
.prose ul, .prose ol { padding-left: 1.3em; }
.prose li + li { margin-top: .4em; }
.prose blockquote { border-left: 3px solid var(--blue); padding: 4px 0 4px 20px; color: var(--muted); }
.prose img { border-radius: 16px; margin: 1.6em 0; }
.prose table { width: 100%; border-collapse: collapse; font-size: 1rem; }
.prose th, .prose td { border: 1px solid var(--line); padding: 10px 12px; text-align: left; }
.mats { margin-top: 40px; display: grid; gap: 10px; }
.mat { display: flex; align-items: center; gap: 14px; padding: 16px 18px; border: 1px solid var(--line); border-radius: 16px; }
.mat .icon-tile { width: 44px; height: 44px; font-size: 20px; }
.mat b { display: block; }
.mat span { color: var(--muted); font-size: .88rem; }
.mat a { margin-left: auto; }
.share { display: flex; align-items: center; gap: 10px; margin-top: 36px; padding-top: 28px; border-top: 1px solid var(--line); font-weight: 700; }
.share a { width: 42px; height: 42px; border-radius: 50%; border: 1px solid var(--line); display: grid; place-items: center; transition: border-color .2s, background .2s; }
.share a:hover { border-color: var(--blue); background: var(--blue-50); }
.share svg { width: 18px; height: 18px; fill: var(--ink); }
.ar-side { position: sticky; top: 110px; align-self: start; }
.ar-side .card { padding: 24px; }
.ar-side h4 { font-size: 1rem; font-weight: 800; margin-bottom: 12px; }
.ar-side .rec { display: flex; gap: 12px; padding: 10px 0; border-top: 1px solid var(--line); }
.ar-side .rec:first-of-type { border-top: 0; }
.ar-side .rec img { width: 54px; height: 54px; border-radius: 12px; object-fit: cover; flex-shrink: 0; }
.ar-side .rec a { font-weight: 700; font-size: .92rem; line-height: 1.35; }
@media (max-width: 960px) { .ar-side { position: static; } }
@endsection

@section('content')
<section class="ar-hero">
  <div class="wrap">
    <div class="chips rv"><span class="chip">{{ $article->typeLabel() }}</span>@if($article->category)<span class="chip">{{ $article->category->name }}</span>@endif</div>
    <h1 class="rv">{{ $article->title }}</h1>
    <div class="ar-meta rv"><span>{{ $article->published_at?->translatedFormat('d \d\e F \d\e Y') }}</span>@if($article->reading_minutes)<span>{{ $article->reading_minutes }} min de lectura</span>@endif</div>
  </div>
</section>

@if($article->cover_image)
  <div class="ar-cover rv"><img src="{{ $article->coverUrl() }}" alt="{{ $article->title }}"></div>
@endif

<div class="ar-lay">
  <article>
    <div class="ar-author">
      <img src="{{ $article->author->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $article->author->name }}">
      <div><a href="{{ route('blog.author', $article->author) }}">{{ $article->author->name }}</a><span>{{ $article->author->title }}</span></div>
    </div>

    <div class="prose">{!! $article->content !!}</div>

    @if($article->materials->isNotEmpty())
      <div class="mats">
        <h3 class="h3">Material adicional</h3>
        @foreach($article->materials as $material)
          <div class="mat"><span class="icon-tile">@include('site.partials.icon', ['name' => 'doc'])</span><div><b>{{ $material->original_name }}</b>@if($material->humanSize())<span>PDF · {{ $material->humanSize() }}</span>@endif</div><a class="b b-ghost b-sm" href="{{ asset('storage/'.$material->path) }}" target="_blank" download>Descargar</a></div>
        @endforeach
      </div>
    @endif

    @if($article->tags->isNotEmpty())
      <div class="chips" style="margin-top:32px">@foreach($article->tags as $tag)<a class="chip" href="{{ route('blog.index', ['etiqueta' => $tag->slug]) }}">{{ $tag->name }}</a>@endforeach</div>
    @endif

    <div class="share">
      <span>Compartir</span>
      <a target="_blank" rel="noopener" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" aria-label="Compartir en LinkedIn"><svg viewBox="0 0 24 24"><path d="M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 110-4.13 2.06 2.06 0 010 4.13zm1.78 13.02H3.56V9h3.56v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0z"/></svg></a>
      <a target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" aria-label="Compartir en Facebook"><svg viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0022 12z"/></svg></a>
      <a target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" aria-label="Compartir en X"><svg viewBox="0 0 24 24"><path d="M18.24 2.25h3.31l-7.23 8.26 8.5 11.24h-6.65l-5.21-6.82-5.97 6.82H1.68l7.73-8.84L1.25 2.25h6.83l4.71 6.23zm-1.16 17.52h1.83L7.08 4.13H5.12z"/></svg></a>
      <a target="_blank" rel="noopener" href="https://api.whatsapp.com/send?text={{ urlencode($article->title.' '.url()->current()) }}" aria-label="Compartir en WhatsApp"><svg viewBox="0 0 24 24"><path d="M12.05 2C6.53 2 2.05 6.48 2.05 12c0 1.77.46 3.5 1.34 5.02L2 22l5.12-1.34A9.94 9.94 0 0012.05 22C17.57 22 22 17.52 22 12S17.57 2 12.05 2zm5.43 13.6c-.23.65-1.36 1.24-1.87 1.32-.48.07-1.08.1-1.74-.11-.4-.13-.92-.3-1.58-.58-2.78-1.2-4.6-4-4.73-4.18-.14-.19-1.13-1.5-1.13-2.87s.72-2.04.97-2.32c.26-.28.56-.35.75-.35h.53c.17 0 .4-.06.62.48.23.55.79 1.9.86 2.04.07.14.11.3.02.49-.09.19-.14.3-.28.46-.14.16-.29.36-.42.48-.14.14-.28.29-.12.57.16.28.72 1.19 1.55 1.92 1.06.95 1.96 1.24 2.24 1.38.28.14.44.12.6-.07.16-.19.69-.81.88-1.09.18-.28.37-.23.62-.14.26.09 1.62.77 1.9.9.28.14.46.21.53.33.07.12.07.67-.16 1.32z"/></svg></a>
    </div>

    @if($related->isNotEmpty())
      <div style="margin-top:56px"><h2 class="h3" style="margin-bottom:22px">Publicaciones relacionadas</h2><div class="posts" style="grid-template-columns:repeat(auto-fill,minmax(240px,1fr))">@foreach($related as $item)@include('blog._article-card', ['article' => $item])@endforeach</div></div>
    @endif
  </article>

  <aside class="ar-side">
    @if($recent->isNotEmpty())
      <div class="card"><h4>Recientes</h4>
        @foreach($recent as $item)
          <div class="rec"><img src="{{ $item->cover_image ? $item->coverUrl() : asset('images/logos.png') }}" alt=""><div><a href="{{ route('blog.show', $item) }}">{{ $item->title }}</a></div></div>
        @endforeach
      </div>
    @endif
    <div class="card" style="margin-top:16px;background:var(--ink);color:#fff;border-color:transparent"><h4 style="color:#fff">¿Tiene un caso parecido?</h4><p style="color:rgba(255,255,255,.7);font-size:.95rem;margin-bottom:16px">Converse con el equipo sobre su situación.</p><a href="{{ route('home') }}#contacto" class="b b-light b-sm b-block">Agendar consulta</a></div>
  </aside>
</div>
@endsection
