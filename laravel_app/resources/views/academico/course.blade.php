@extends('layouts.app')

@section('title', $course->name.' — '.$university->short_name.' — Espacio Académico')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
@include('academico._course-header')

@php $acActiveTab = 'inicio'; @endphp
@include('academico._course-tabs')

@php
  $firstActivity = $course->activities()->where('type', 'participacion')->orderBy('week_number')->first();
  $totalWeeks = $course->total_weeks ?: 16;
@endphp

<div class="ac-shell">
  <div class="wrap" style="padding:2.2rem 24px;">
    <h2 style="font-family:var(--serif);font-size:1.3rem;color:var(--ink);margin-bottom:1.4rem;">Bienvenido a {{ $course->name }}</h2>

    <div class="ac-widget-grid">
      <div class="ac-widget">
        <div class="k">Progreso</div>
        <div class="v">Semana 1 <small>de {{ $totalWeeks }}</small></div>
        <div class="ac-progress-track"><div class="ac-progress-fill" style="width:{{ round(1 / $totalWeeks * 100) }}%;"></div></div>
      </div>
      <div class="ac-widget">
        <div class="k">Actividad actual</div>
        <div class="v" style="font-size:1rem;">{{ $firstActivity->title ?? 'Sin actividades aún' }}</div>
        @if($firstActivity)
          <span class="ac-status-badge {{ $firstActivity->status }}" style="margin-top:8px;display:inline-block;">{{ ucfirst($firstActivity->status) }}</span>
        @endif
      </div>
      <div class="ac-widget">
        <div class="k">Participaciones realizadas</div>
        <div class="v">0 <small>de {{ $course->activities()->where('type', 'participacion')->count() }}</small></div>
      </div>
      <div class="ac-widget">
        <div class="k">Actividades pendientes</div>
        <div class="v">{{ $course->activities()->where('status', 'disponible')->count() }}</div>
      </div>
    </div>

    <h3 style="font-size:0.98rem;color:var(--ink);margin-bottom:1rem;">Esta semana</h3>
    @forelse($course->activities()->where('week_number', 1)->get() as $activity)
      <a href="{{ route('academico.activity.show', [$university->slug, $course->slug, $activity->slug]) }}" class="ac-activity-card">
        <span class="ac-activity-week">S{{ $activity->week_number }}</span>
        <span class="ac-activity-body">
          <h4>{{ $activity->title }}</h4>
          <p>{{ ucfirst($activity->type) }}{{ $activity->case_title ? ' — '.$activity->case_title : '' }}</p>
        </span>
        <span class="ac-status-badge {{ $activity->status }}">{{ ucfirst($activity->status) }}</span>
      </a>
    @empty
      <p style="color:var(--slate-light);font-size:0.86rem;">Todavía no hay actividades programadas para esta semana.</p>
    @endforelse
  </div>
</div>

@include('academico._floating-cta')
@endsection
