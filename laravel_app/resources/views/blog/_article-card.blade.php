@php $article = $article ?? null; @endphp
@if($article)
<a href="{{ route('blog.show', $article) }}" class="post rv">
  <div class="cv">
    @if($article->cover_image)<img src="{{ asset('storage/'.$article->cover_image) }}" alt="{{ $article->title }}" loading="lazy">@endif
  </div>
  <div class="bd">
    <div class="mt">{{ $article->category->name ?? $article->typeLabel() }} · {{ $article->published_at?->translatedFormat('d M Y') }}@if($article->reading_minutes) · {{ $article->reading_minutes }} min @endif</div>
    <h3>{{ $article->title }}</h3>
    <p>{{ $article->excerpt }}</p>
    <div style="display:flex;align-items:center;gap:10px;margin-top:auto;padding-top:8px">
      <img src="{{ $article->author->displayPhoto() ?? asset('images/logos.png') }}" alt="" style="width:30px;height:30px;border-radius:50%;object-fit:cover">
      <span style="font-size:.9rem;font-weight:700">{{ $article->author->name }}</span>
    </div>
  </div>
</a>
@endif
