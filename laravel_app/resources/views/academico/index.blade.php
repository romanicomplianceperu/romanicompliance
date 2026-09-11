@extends('layouts.app')

@section('title', 'Espacio Académico — Romani Compliance')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
<div class="ac-shell ac-full">
  @if(session('academico_success'))
    <div class="ac-response-sent" style="margin-bottom:1.4rem;">{{ session('academico_success') }}</div>
  @endif

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

  <a href="{{ route('academico.convocatoria.info') }}" class="ac-convocatoria-card">
    <span class="ac-convocatoria-badge"><span class="dot"></span> {{ \App\Models\InternshipApplication::applicationsOpen() ? 'Convocatoria abierta' : 'Convocatoria cerrada' }}</span>
    @if(\App\Models\InternshipApplication::applicationsOpen())
      <p style="font-size:0.82rem;font-weight:700;color:var(--gold);margin:2px 0 10px;">Por la gran acogida, cerramos inscripciones {{ \App\Models\InternshipApplication::APPLICATION_DEADLINE_LABEL }}</p>
    @endif
    <h2>¿Te gustaría formar parte del equipo de Romani Compliance?</h2>
    <p>Estamos buscando estudiantes de derecho para realizar una pasantía en el estudio: casos reales de compliance, ALA/CFT y derecho penal, con mentoría directa de nuestros abogados.</p>
    <ul class="ac-convocatoria-highlights">
      <li>Certificado de prácticas en papel membretado y digital, con QR verificable</li>
      <li>Mentoría directa de abogados especializados</li>
      <li>Aprendizaje con casos y clientes reales</li>
    </ul>
    <span class="ac-convocatoria-cta">Ver más información →</span>
  </a>
</div>

@include('academico._floating-cta')
@endsection
