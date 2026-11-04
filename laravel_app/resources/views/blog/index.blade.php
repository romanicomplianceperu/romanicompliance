@extends('layouts.site')

@section('title', 'Publicaciones · Romani Compliance')
@section('description', 'Análisis jurídico y novedades regulatorias sobre compliance, prevención LA/FT y derecho penal económico.')

@section('styles')
.pg-hero { padding: clamp(56px, 8vw, 104px) 0 clamp(36px, 5vw, 56px); }
.pg-hero .lead { margin-top: 20px; }
.bl { display: grid; grid-template-columns: 1fr 300px; gap: 48px; align-items: start; }
@media (max-width: 960px) { .bl { grid-template-columns: 1fr; } }
.bl .posts { grid-template-columns: repeat(2, 1fr); }
@media (max-width: 680px) { .bl .posts { grid-template-columns: 1fr; } }
.search { display: flex; gap: 10px; margin-bottom: 20px; }
.search input { flex: 1; min-width: 0; padding: 15px 18px; border-radius: 999px; border: 1.5px solid var(--line); font: inherit; }
.search input:focus { outline: none; border-color: var(--blue); }
.filters { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 30px; }
.filters a { padding: 9px 16px; border-radius: 999px; background: var(--soft); font-weight: 600; font-size: .9rem; transition: background .2s, color .2s; }
.filters a.on, .filters a:hover { background: var(--ink); color: #fff; }
.side { position: sticky; top: 110px; display: grid; gap: 16px; }
.side .card { padding: 24px; }
.side h4 { font-size: 1rem; font-weight: 800; margin-bottom: 14px; }
.side .rec { display: flex; gap: 12px; padding: 10px 0; border-top: 1px solid var(--line); }
.side .rec:first-of-type { border-top: 0; padding-top: 0; }
.side .rec img { width: 54px; height: 54px; border-radius: 12px; object-fit: cover; flex-shrink: 0; background: var(--soft); }
.side .rec a { font-weight: 700; font-size: .92rem; line-height: 1.35; }
.side .rec span { display: block; font-size: .8rem; color: var(--muted-2); margin-top: 3px; }
.side .cats a { display: flex; justify-content: space-between; padding: 8px 0; font-weight: 600; border-top: 1px solid var(--line); }
.side .cats a:first-child { border-top: 0; }
.side .cats a span:last-child { color: var(--muted-2); }
.pager { display: flex; justify-content: space-between; align-items: center; margin-top: 36px; font-weight: 700; }
.pager .off { color: var(--muted-2); }
@endsection

@section('content')
<section class="pg-hero">
  <div class="wrap">
    <div class="kicker rv">Publicaciones</div>
    <h1 class="display rv" style="font-size:clamp(2.4rem,5.4vw,4.6rem)">Análisis y novedades regulatorias.</h1>
    <p class="lead rv">Lo que cambia en compliance, prevención de lavado de activos y derecho penal económico, explicado con claridad.</p>
  </div>
</section>

<section class="sec" style="padding-top:0">
  <div class="wrap bl">
    <div>
      <form class="search" method="GET" action="{{ route('blog.index') }}">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar publicaciones" aria-label="Buscar publicaciones">
        <button type="submit" class="b b-dark">Buscar</button>
      </form>
      @if($categories->isNotEmpty())
        <div class="filters">
          <a href="{{ route('blog.index') }}" class="{{ request('categoria') ? '' : 'on' }}">Todas</a>
          @foreach($categories as $cat)
            <a href="{{ route('blog.index', ['categoria' => $cat->slug]) }}" class="{{ request('categoria') === $cat->slug ? 'on' : '' }}">{{ $cat->name }}</a>
          @endforeach
        </div>
      @endif

      @if($articles->isEmpty())
        <div class="card" style="text-align:center"><p class="muted">No encontramos publicaciones con ese criterio.</p></div>
      @else
        <div class="posts">
          @foreach($articles as $article)
            @include('blog._article-card', ['article' => $article])
          @endforeach
        </div>
        @if($articles->hasPages())
          <div class="pager">
            @if($articles->onFirstPage())<span class="off">Anterior</span>@else<a href="{{ $articles->previousPageUrl() }}" class="lnk">Anterior</a>@endif
            <span class="muted">Página {{ $articles->currentPage() }} de {{ $articles->lastPage() }}</span>
            @if($articles->hasMorePages())<a href="{{ $articles->nextPageUrl() }}" class="lnk">Siguiente @include('site.partials.icon', ['name' => 'arrow'])</a>@else<span class="off">Siguiente</span>@endif
          </div>
        @endif
      @endif
    </div>

    <aside class="side">
      @if($recent->isNotEmpty())
        <div class="card"><h4>Recientes</h4>
          @foreach($recent as $item)
            <div class="rec"><img src="{{ $item->cover_image ? asset('storage/'.$item->cover_image) : asset('images/logos.png') }}" alt=""><div><a href="{{ route('blog.show', $item) }}">{{ $item->title }}</a><span>{{ $item->published_at?->translatedFormat('d M Y') }}</span></div></div>
          @endforeach
        </div>
      @endif
      @if($categories->isNotEmpty())
        <div class="card cats"><h4>Categorías</h4>
          @foreach($categories as $cat)<a href="{{ route('blog.index', ['categoria' => $cat->slug]) }}"><span>{{ $cat->name }}</span><span>{{ $cat->articles_count }}</span></a>@endforeach
        </div>
      @endif
      @if($tags->isNotEmpty())
        <div class="card"><h4>Etiquetas</h4><div class="chips">@foreach($tags as $tag)<a class="chip" href="{{ route('blog.index', ['etiqueta' => $tag->slug]) }}">{{ $tag->name }}</a>@endforeach</div></div>
      @endif
    </aside>
  </div>
</section>
@endsection
