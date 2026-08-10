@php $article = $article ?? null; @endphp
@if($article)
<a href="{{ route('blog.show', $article) }}" class="article-card reveal">
  <div class="article-card-cover">
    @if($article->cover_image)
      <img src="{{ asset('storage/'.$article->cover_image) }}" alt="{{ $article->title }}">
    @endif
    @if($article->category)
      <span class="article-card-category">{{ $article->category->name }}</span>
    @endif
  </div>
  <div class="article-card-body">
    <div class="article-card-meta">
      <span>{{ $article->published_at?->format('d M Y') }}</span>
      @if($article->reading_minutes)<span>· {{ $article->reading_minutes }} min de lectura</span>@endif
    </div>
    <h3>{{ $article->title }}</h3>
    <p>{{ $article->excerpt }}</p>
    <div class="article-card-author">
      <img src="{{ $article->author->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $article->author->name }}">
      <span>{{ $article->author->name }}</span>
    </div>
  </div>
</a>
@endif
