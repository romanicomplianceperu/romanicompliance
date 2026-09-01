@extends('layouts.app')

@section('title', 'Selecciona tu universidad — Espacio Académico — Romani Compliance')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
<div class="ac-shell ac-full">
  <a href="{{ route('academico.index') }}" class="ac-back-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
    Volver
  </a>
  <div class="ac-eyebrow">Alumno</div>
  <h1 class="ac-title">Selecciona tu universidad</h1>
  <p class="ac-subtitle">Elige la universidad a la que perteneces para ingresar a tus cursos.</p>

  <div class="ac-uni-grid">
    @foreach($universities as $u)
      @if($u->isActive())
        <a href="{{ route('academico.university', $u->slug) }}" class="ac-uni-card active">
          <img src="{{ $u->logo_url }}" alt="Logo {{ $u->name }}" class="ac-uni-logo" loading="lazy">
          <h3>{{ $u->name }}</h3>
          <div class="ac-uni-short">{{ $u->short_name }}</div>
          <span class="ac-uni-cta">Ingresar →</span>
        </a>
      @else
        <div class="ac-uni-card soon">
          <img src="{{ $u->logo_url }}" alt="Logo {{ $u->name }}" class="ac-uni-logo" loading="lazy">
          <h3>{{ $u->name }}</h3>
          <div class="ac-uni-short">{{ $u->short_name }}</div>
          <span class="ac-uni-soon-badge">Campus próximamente disponible</span>
        </div>
      @endif
    @endforeach
  </div>
</div>

@include('academico._floating-cta')
@endsection
