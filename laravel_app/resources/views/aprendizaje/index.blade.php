@extends('layouts.app')

@section('title', 'Aprendizaje · Romani Compliance')
@section('description', 'Elija entre nuestros programas de capacitación o el espacio académico universitario de Romani Compliance.')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
<div class="ac-shell ac-full">
  <div class="ac-eyebrow">Aprendizaje</div>
  <h1 class="ac-title">¿Qué está buscando?</h1>
  <p class="ac-subtitle">Seleccione una opción para continuar.</p>

  <div class="ac-choice-grid">
    <a href="{{ route('aprendizaje.capacitaciones') }}" class="ac-choice-card">
      <span class="ac-choice-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 3L2 8l10 5 10-5-10-5z"/><path d="M6 10.5V16c0 1.7 2.7 3 6 3s6-1.3 6-3v-5.5"/><path d="M22 8v6.5"/></svg>
      </span>
      <h3>Capacitaciones</h3>
      <p>Programas de formación y certificación en compliance, prevención LA/FT y gestión de riesgos.</p>
    </a>
    <a href="{{ route('academico.index') }}" class="ac-choice-card">
      <span class="ac-choice-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/></svg>
      </span>
      <h3>Académico Universitario</h3>
      <p>Espacio para alumnos y visitantes: cursos, actividades y participaciones universitarias.</p>
    </a>
  </div>
</div>
@endsection
