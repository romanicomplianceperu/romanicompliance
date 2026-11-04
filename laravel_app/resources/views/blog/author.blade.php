@extends('layouts.site')

@section('title', $user->name.' · Autor · Romani Compliance')

@section('styles')
.au { display: grid; grid-template-columns: 220px 1fr; gap: 48px; align-items: center; padding: clamp(56px, 8vw, 100px) 0 clamp(36px, 5vw, 56px); }
.au img { width: 220px; height: 220px; border-radius: 28px; object-fit: cover; background: var(--soft); }
.au .role { color: var(--blue); font-weight: 700; margin: 10px 0 16px; }
@media (max-width: 720px) { .au { grid-template-columns: 1fr; gap: 24px; } .au img { width: 160px; height: 160px; } }
@endsection

@section('content')
<section class="wrap au">
  <img src="{{ $user->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $user->name }}" class="rv">
  <div>
    <div class="kicker rv">Autor</div>
    <h1 class="h2 rv">{{ $user->name }}</h1>
    @if($user->title)<div class="role rv">{{ $user->title }}</div>@endif
    @if($user->bio)<p class="lead rv">{{ $user->bio }}</p>@endif
  </div>
</section>
<section class="sec" style="padding-top:0">
  <div class="wrap">
    <h2 class="h3 rv" style="margin-bottom:26px">Publicaciones</h2>
    @if($articles->isEmpty())
      <div class="card"><p class="muted">Todavía no hay publicaciones de este autor.</p></div>
    @else
      <div class="posts">@foreach($articles as $article)@include('blog._article-card', ['article' => $article])@endforeach</div>
    @endif
  </div>
</section>
@endsection
