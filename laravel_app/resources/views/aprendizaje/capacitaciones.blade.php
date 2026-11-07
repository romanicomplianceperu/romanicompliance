@extends('layouts.site')

@section('title', 'Capacitaciones · Romani Compliance')

@section('styles')
.ap-hero { padding: clamp(40px, 6vw, 80px) 0 clamp(24px, 3vw, 36px); }
.ap-back { display: inline-flex; align-items: center; gap: 6px; font-weight: 700; color: var(--muted); margin-bottom: 22px; }
.ap-back:hover { color: var(--blue); }
.ap-back svg { width: 18px; height: 18px; }
.ap-hero .lead { margin-top: 14px; }
.ap-course { display: grid; grid-template-columns: 0.9fr 1.1fr; border: 1px solid var(--line); border-radius: 28px; overflow: hidden; background: #fff; transition: transform .35s var(--ease), border-color .3s, box-shadow .3s; }
.ap-course:hover { transform: translateY(-4px); border-color: var(--blue); box-shadow: 0 24px 50px -32px rgba(10,23,48,.5); }
.ap-course .cv { background: var(--ink); min-height: 260px; }
.ap-course .cv img { width: 100%; height: 100%; object-fit: cover; }
.ap-course .bd { padding: clamp(24px, 3.5vw, 40px); display: flex; flex-direction: column; gap: 14px; }
.ap-course .badge-x { align-self: flex-start; padding: 6px 12px; border-radius: 999px; background: var(--blue-50); color: var(--blue); font-weight: 700; font-size: .84rem; }
.ap-course h2 { font-size: clamp(1.4rem, 2.6vw, 2rem); font-weight: 800; letter-spacing: -0.025em; line-height: 1.2; }
.ap-course p { color: var(--muted); }
.ap-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
.ap-stats div { background: var(--soft); border-radius: 14px; padding: 12px; text-align: center; }
.ap-stats b { display: block; font-size: 1.4rem; font-weight: 800; line-height: 1.1; }
.ap-stats span { font-size: .78rem; color: var(--muted); font-weight: 600; }
.ap-course .lnk { margin-top: auto; }
@media (max-width: 820px) { .ap-course { grid-template-columns: 1fr; } .ap-course .cv { min-height: 200px; } .ap-stats { grid-template-columns: repeat(2, 1fr); } }
@endsection

@section('content')
<section class="ap-hero">
  <div class="wrap">
    <a href="{{ route('aprendizaje.index') }}" class="ap-back"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg> Volver</a>
    <div class="kicker rv">Aprendizaje</div>
    <h1 class="display rv">Capacitaciones</h1>
    <p class="lead rv">Programas de formación en compliance, prevención LA/FT y gestión de riesgos.</p>
  </div>
</section>

@php
  $featured = \App\Models\Course::where('slug', 'cuestiones-problematicas-lavado-activos')->where('is_published', true)->first();
@endphp

<section class="sec" style="padding-top:0">
  <div class="wrap">
    @if($featured)
      <a href="{{ route('courses.show', $featured) }}" class="ap-course rv">
        <div class="cv">@if($featured->cover_image)<img src="{{ asset('storage/'.$featured->cover_image) }}" alt="{{ $featured->title }}">@endif</div>
        <div class="bd">
          <span class="badge-x">Programa INL · Embajada de EE. UU. en el Perú</span>
          <h2>{{ $featured->title }}</h2>
          <p>{{ \Illuminate\Support\Str::limit($featured->description, 220) }}</p>
          <div class="ap-stats">
            <div><b>{{ $featured->modules->count() }}</b><span>Módulos</span></div>
            <div><b>{{ $featured->lessons()->count() }}</b><span>Lecciones</span></div>
            <div><b>{{ $featured->lectiveHours() }}</b><span>Horas</span></div>
            <div><b>{{ $featured->exam?->questions()->count() ?? 0 }}</b><span>Preguntas</span></div>
          </div>
          <span class="lnk">Ver curso @include('site.partials.icon', ['name' => 'arrow'])</span>
        </div>
      </a>
    @else
      <p class="lead">Estamos preparando esta sección. Muy pronto encontrará aquí más programas de formación.</p>
    @endif
    <p class="muted" style="margin-top:28px">¿Busca una capacitación para su empresa? <a class="lnk" href="{{ route('capacitaciones') }}">Ver programas corporativos @include('site.partials.icon', ['name' => 'arrow'])</a></p>
  </div>
</section>
@endsection
