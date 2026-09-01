@extends('layouts.app')

@section('title', $university->name.' — Espacio Académico — Romani Compliance')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
<div class="ac-campus-header">
  <div class="wrap ac-campus-header-row">
    <div class="ac-campus-brand">
      <img src="{{ $university->logo_url }}" alt="Logo {{ $university->short_name }}" style="height:26px;width:auto;">
      Espacio Académico <span class="tag">{{ $university->short_name }}</span>
    </div>
    <div class="ac-campus-nav">
      <a href="{{ route('academico.index') }}">Salir del espacio académico</a>
    </div>
  </div>
</div>

<div class="ac-shell">
  <div class="wrap" style="padding:2.4rem 24px;">
    <div class="ac-crumbs">
      <a href="{{ route('academico.index') }}">Académico</a>
      <span class="sep">›</span>
      <span class="current">{{ $university->short_name }}</span>
    </div>

    <div style="display:flex; align-items:center; gap:16px; margin-bottom:1.8rem;">
      <img src="{{ $university->logo_url }}" alt="Logo {{ $university->name }}" style="height:56px;width:auto;object-fit:contain;">
      <div>
        <h1 style="font-family:var(--serif); font-size:1.5rem; color:var(--ink);">{{ $university->name }}</h1>
        @if($courses->first()?->faculty)
          <p style="font-size:0.85rem;color:var(--slate);">{{ $courses->first()->faculty }}</p>
        @endif
      </div>
    </div>

    <h2 style="font-size:1.1rem;color:var(--ink);margin-bottom:1rem;">Mis cursos</h2>

    <div style="display:grid; gap:1rem;">
      @forelse($courses as $course)
        <div class="ac-activity-card" style="align-items:stretch;flex-direction:column;align-items:flex-start;padding:1.6rem 1.8rem;">
          <div style="display:flex;justify-content:space-between;width:100%;align-items:flex-start;gap:1rem;flex-wrap:wrap;">
            <div>
              <h3 style="font-family:var(--serif);font-size:1.2rem;color:var(--ink);margin-bottom:2px;">{{ $course->name }}</h3>
              @if($course->subtitle)<p style="font-size:0.88rem;color:var(--gold);font-weight:600;margin-bottom:8px;">{{ $course->subtitle }}</p>@endif
              <div style="display:flex;gap:1.2rem;font-size:0.78rem;color:var(--slate-light);">
                <span>Estado: <strong style="color:#1F7A4D;">{{ $course->isActive() ? 'Activo' : 'Próximamente' }}</strong></span>
                @if($course->period)<span>Periodo: {{ $course->period }}</span>@endif
              </div>
            </div>
            @if($course->isActive())
              <a href="{{ route('academico.course', [$university->slug, $course->slug]) }}" class="ac-btn-primary" style="padding:11px 22px;font-size:0.82rem;">Entrar al curso →</a>
            @else
              <span class="ac-uni-soon-badge">Próximamente</span>
            @endif
          </div>
        </div>
      @empty
        <p style="color:var(--slate-light);font-size:0.88rem;">Todavía no hay cursos publicados para esta universidad.</p>
      @endforelse
    </div>
  </div>
</div>

@include('academico._floating-cta')
@endsection
