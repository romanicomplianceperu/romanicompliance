@extends('layouts.app')

@section('title', 'Blog — Romani Compliance')
@section('description', 'Análisis jurídico, novedades regulatorias y contenido de interés sobre compliance, prevención LA/FT y derecho penal.')

@section('styles')
.blog-hero { background: var(--ink); padding: 3.5rem 0; position: relative; }
.blog-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
.blog-hero h1 { font-size: clamp(1.6rem, 3.5vw, 2.2rem); color: var(--white); font-weight: 400; margin-bottom: 0.6rem; }
.blog-hero p { font-size: 0.88rem; color: rgba(255,255,255,0.45); max-width: 500px; }

.blog-section { padding: 3.5rem 0; }
.blog-layout { display: grid; grid-template-columns: 2.3fr 1fr; gap: 2.5rem; align-items: start; }

.blog-search { display: flex; gap: 8px; margin-bottom: 1.5rem; }
.blog-search input { flex: 1; padding: 11px 14px; border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.85rem; }
.blog-search input:focus { outline: none; border-color: var(--gold); }

.filter-pills { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 2rem; }
.filter-pills a { font-size: 0.76rem; font-weight: 600; padding: 7px 14px; border-radius: 20px; border: 1px solid var(--line); color: var(--slate); }
.filter-pills a.active, .filter-pills a:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-pale); }

.article-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }

.blog-sidebar-block { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 1.4rem; margin-bottom: 1.5rem; }
.blog-sidebar-block h4 { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 1rem; color: var(--ink); }
.recent-item { display: flex; gap: 10px; align-items: flex-start; margin-bottom: 1rem; }
.recent-item:last-child { margin-bottom: 0; }
.recent-item img { width: 52px; height: 52px; object-fit: cover; border-radius: 4px; flex-shrink: 0; }
.recent-item a { font-size: 0.82rem; color: var(--ink); font-weight: 600; line-height: 1.4; }
.recent-item a:hover { color: var(--gold); }
.recent-item .date { font-size: 0.68rem; color: var(--slate-light); margin-top: 2px; }
.sidebar-cat-list a { display: flex; justify-content: space-between; padding: 8px 0; font-size: 0.82rem; color: var(--slate); border-bottom: 1px solid var(--line); }
.sidebar-cat-list a:last-child { border-bottom: none; }
.sidebar-cat-list a:hover { color: var(--gold); }
.tag-cloud { display: flex; flex-wrap: wrap; gap: 6px; }
.tag-cloud a { font-size: 0.72rem; padding: 5px 12px; background: var(--ivory-dim); color: var(--slate); border-radius: 20px; }
.tag-cloud a:hover { background: var(--gold-pale); color: var(--gold); }

.pagination-row { display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 2.5rem; }
.pagination-row a, .pagination-row span { font-size: 0.82rem; font-weight: 600; color: var(--slate); }
.pagination-row a:hover { color: var(--gold); }

@media (max-width: 900px) {
  .blog-layout { grid-template-columns: 1fr; }
  .article-grid { grid-template-columns: 1fr; max-width: 480px; margin: 0 auto; }
}
@endsection

@section('content')
<section class="blog-hero">
  <div class="wrap">
    <h1>Noticias y publicaciones</h1>
    <p>Análisis jurídico, novedades regulatorias y contenido de interés en materia de compliance y prevención LA/FT.</p>
  </div>
</section>

<section class="blog-section">
  <div class="wrap blog-layout">
    <div>
      <form class="blog-search" method="GET" action="{{ route('blog.index') }}">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar artículos...">
        <button type="submit" class="btn btn-gold">Buscar</button>
      </form>

      @if($categories->isNotEmpty())
        <div class="filter-pills">
          <a href="{{ route('blog.index') }}" class="{{ request('categoria') ? '' : 'active' }}">Todos</a>
          @foreach($categories as $cat)
            <a href="{{ route('blog.index', ['categoria' => $cat->slug]) }}" class="{{ request('categoria') === $cat->slug ? 'active' : '' }}">{{ $cat->name }} ({{ $cat->articles_count }})</a>
          @endforeach
        </div>
      @endif

      @if($articles->isEmpty())
        <div class="empty-state" style="text-align:center;padding:3rem;color:var(--slate);border:1px dashed var(--line);border-radius:8px;">No se encontraron artículos.</div>
      @else
        <div class="article-grid">
          @foreach($articles as $article)
            @include('blog._article-card', ['article' => $article])
          @endforeach
        </div>

        @if($articles->hasPages())
          <div class="pagination-row">
            @if($articles->onFirstPage())
              <span>← Anterior</span>
            @else
              <a href="{{ $articles->previousPageUrl() }}">← Anterior</a>
            @endif
            <span>Página {{ $articles->currentPage() }} de {{ $articles->lastPage() }}</span>
            @if($articles->hasMorePages())
              <a href="{{ $articles->nextPageUrl() }}">Siguiente →</a>
            @else
              <span>Siguiente →</span>
            @endif
          </div>
        @endif
      @endif
    </div>

    <aside>
      @if($recent->isNotEmpty())
        <div class="blog-sidebar-block">
          <h4>Artículos recientes</h4>
          @foreach($recent as $item)
            <div class="recent-item">
              <img src="{{ $item->cover_image ? asset('storage/'.$item->cover_image) : asset('images/logos.png') }}" alt="{{ $item->title }}">
              <div>
                <a href="{{ route('blog.show', $item) }}">{{ $item->title }}</a>
                <div class="date">{{ $item->published_at?->format('d/m/Y') }}</div>
              </div>
            </div>
          @endforeach
        </div>
      @endif

      @if($categories->isNotEmpty())
        <div class="blog-sidebar-block">
          <h4>Categorías</h4>
          <div class="sidebar-cat-list">
            @foreach($categories as $cat)
              <a href="{{ route('blog.index', ['categoria' => $cat->slug]) }}"><span>{{ $cat->name }}</span><span>{{ $cat->articles_count }}</span></a>
            @endforeach
          </div>
        </div>
      @endif

      @if($tags->isNotEmpty())
        <div class="blog-sidebar-block">
          <h4>Etiquetas</h4>
          <div class="tag-cloud">
            @foreach($tags as $tag)
              <a href="{{ route('blog.index', ['etiqueta' => $tag->slug]) }}">#{{ $tag->name }}</a>
            @endforeach
          </div>
        </div>
      @endif
    </aside>
  </div>
</section>
@endsection
