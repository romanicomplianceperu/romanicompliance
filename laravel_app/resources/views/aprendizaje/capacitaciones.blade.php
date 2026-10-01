@extends('layouts.app')

@section('title', 'Capacitaciones · Romani Compliance')

@section('styles')
@include('academico._styles')
.cap-course-card { display: block; max-width: 760px; width: 100%; margin: 0 auto; background: var(--white); border: 1.5px solid var(--line); border-radius: 18px; overflow: hidden; text-align: left; transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease; }
.cap-course-card:hover { border-color: var(--gold); transform: translateY(-4px); box-shadow: 0 16px 40px rgba(11,24,41,0.1); }
.cap-course-cover { aspect-ratio: 16/7; background: var(--ink); overflow: hidden; }
.cap-course-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
.cap-course-body { padding: 1.8rem 2rem; }
.cap-course-badge { display: inline-block; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gold); background: var(--gold-pale); padding: 4px 12px; border-radius: 20px; margin-bottom: 0.8rem; }
.cap-course-body h3 { font-family: var(--serif); font-size: 1.3rem; color: var(--ink); margin-bottom: 0.6rem; line-height: 1.3; }
.cap-course-body p { font-size: 0.86rem; color: var(--slate); line-height: 1.65; margin-bottom: 1.2rem; }
.cap-course-stats { display: flex; gap: 1.6rem; margin-bottom: 1.4rem; flex-wrap: wrap; }
.cap-course-stat { display: flex; flex-direction: column; gap: 2px; }
.cap-course-stat .n { font-family: var(--serif); font-size: 1.1rem; color: var(--ink); font-weight: 700; }
.cap-course-stat .l { font-size: 0.68rem; color: var(--slate-light); text-transform: uppercase; letter-spacing: 0.04em; }
.cap-course-cta { display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: var(--gold); }
@endsection

@section('content')
<div class="ac-shell ac-full">
  <a href="{{ route('aprendizaje.index') }}" class="ac-back-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
    Volver
  </a>
  <div class="ac-eyebrow">Aprendizaje</div>
  <h1 class="ac-title">Capacitaciones</h1>
  <p class="ac-subtitle">Programas de formación en compliance, prevención LA/FT y gestión de riesgos.</p>

  @php
    $featured = \App\Models\Course::where('slug', 'cuestiones-problematicas-lavado-activos')->where('is_published', true)->first();
  @endphp

  @if($featured)
    <a href="{{ route('courses.show', $featured) }}" class="cap-course-card reveal">
      <div class="cap-course-cover">
        @if($featured->cover_image)
          <img src="{{ asset('storage/'.$featured->cover_image) }}" alt="{{ $featured->title }}">
        @endif
      </div>
      <div class="cap-course-body">
        <span class="cap-course-badge">Programa INL · Embajada de EE. UU. en el Perú</span>
        <h3>{{ $featured->title }}</h3>
        <p>{{ \Illuminate\Support\Str::limit($featured->description, 220) }}</p>
        <div class="cap-course-stats">
          <div class="cap-course-stat"><span class="n">{{ $featured->modules->count() }}</span><span class="l">Módulos</span></div>
          <div class="cap-course-stat"><span class="n">{{ $featured->lessons()->count() }}</span><span class="l">Lecciones</span></div>
          <div class="cap-course-stat"><span class="n">{{ $featured->lectiveHours() }}</span><span class="l">Horas</span></div>
          <div class="cap-course-stat"><span class="n">{{ $featured->exam?->questions()->count() ?? 0 }}</span><span class="l">Preguntas</span></div>
        </div>
        <span class="cap-course-cta">Ver curso →</span>
      </div>
    </a>
  @else
    <p class="ac-subtitle">Estamos preparando esta sección. Muy pronto encontrará aquí más programas de formación.</p>
  @endif
</div>
@endsection
