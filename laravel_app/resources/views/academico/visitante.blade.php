@extends('layouts.app')

@section('title', 'Espacio Académico — Visitante — Romani Compliance')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
<div class="ac-shell ac-full">
  <a href="{{ route('academico.index') }}" class="ac-back-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
    Volver
  </a>
  <div class="ac-eyebrow">Visitante</div>
  <h1 class="ac-title">Bienvenido al Espacio Académico</h1>
  <p class="ac-subtitle">
    Esta sección contiene herramientas, actividades y recursos destinados principalmente a estudiantes.
    <br><br>
    Si deseas aprender por tu cuenta, puedes acceder gratuitamente a nuestra sección de cursos y capacitaciones.
  </p>

  <a href="{{ route('courses.catalog') }}" class="ac-btn-primary">
    Explorar cursos gratuitos
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
  </a>
</div>
@endsection
