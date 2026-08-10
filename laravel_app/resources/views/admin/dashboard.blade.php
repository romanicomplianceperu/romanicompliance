@extends('admin.layout')

@section('title', 'Panel')

@section('styles')
.stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.2rem; }
.stat-card { background: var(--white); border: 1px solid var(--line); border-radius: 6px; padding: 1.5rem; }
.stat-num { font-family: var(--serif); font-size: 2rem; font-weight: 600; color: var(--ink); }
.stat-label { font-size: 0.75rem; color: var(--slate); text-transform: uppercase; letter-spacing: 0.04em; margin-top: 4px; }
@media (max-width: 900px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
@endsection

@section('content')
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-num">{{ $stats['courses'] }}</div>
    <div class="stat-label">Cursos totales</div>
  </div>
  <div class="stat-card">
    <div class="stat-num">{{ $stats['published_courses'] }}</div>
    <div class="stat-label">Publicados</div>
  </div>
  <div class="stat-card">
    <div class="stat-num">{{ $stats['students'] }}</div>
    <div class="stat-label">Alumnos</div>
  </div>
  <div class="stat-card">
    <div class="stat-num">{{ $stats['enrollments'] }}</div>
    <div class="stat-label">Inscripciones</div>
  </div>
  <div class="stat-card">
    <div class="stat-num">{{ $stats['certificates'] }}</div>
    <div class="stat-label">Certificados activos</div>
  </div>
</div>
@endsection
