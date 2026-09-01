@extends('layouts.app')

@section('title', 'Espacio Académico — Romani Compliance')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
<div class="ac-shell ac-full">
  <div class="ac-eyebrow">Espacio Académico</div>
  <h1 class="ac-title">Espacio Académico</h1>
  <p class="ac-subtitle">Selecciona cómo deseas ingresar.</p>

  <div class="ac-choice-grid">
    <a href="{{ route('academico.alumno') }}" class="ac-choice-card">
      <span class="ac-choice-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/></svg>
      </span>
      <h3>Soy alumno</h3>
      <p>Ingresa a tu universidad y tus cursos, actividades y participaciones.</p>
    </a>
    <a href="{{ route('academico.visitante') }}" class="ac-choice-card">
      <span class="ac-choice-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
      </span>
      <h3>Soy visitante</h3>
      <p>Conoce esta sección y descubre nuestros cursos gratuitos abiertos al público.</p>
    </a>
  </div>
</div>

@include('academico._floating-cta')
@endsection
