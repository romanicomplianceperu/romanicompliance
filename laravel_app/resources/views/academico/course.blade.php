@extends('layouts.app')

@section('title', $course->name.' · '.$university->short_name.' · Espacio Académico')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
@include('academico._course-header')

@php $acActiveTab = 'inicio'; @endphp
@include('academico._course-tabs')

@php
  $currentActivity = $course->activities()->visible()->where('type', 'participacion')->where('status', 'disponible')->orderByDesc('week_number')->first()
      ?? $course->activities()->visible()->where('type', 'participacion')->orderBy('week_number')->first();
  $totalWeeks = $course->total_weeks ?: 16;
@endphp

<div class="ac-shell">
  <div class="wrap" style="padding:2.2rem 24px;">
    <h2 style="font-family:var(--serif);font-size:1.3rem;color:var(--ink);margin-bottom:1.4rem;">Bienvenido a {{ $course->name }}</h2>

    <div class="ac-widget-grid">
      <div class="ac-widget">
        <div class="k">Progreso</div>
        <div class="v">Semana {{ $currentActivity->week_number ?? 1 }} <small>de {{ $totalWeeks }}</small></div>
        <div class="ac-progress-track"><div class="ac-progress-fill" style="width:{{ round(($currentActivity->week_number ?? 1) / $totalWeeks * 100) }}%;"></div></div>
      </div>
      <div class="ac-widget">
        <div class="k">Actividad actual</div>
        <div class="v" style="font-size:1rem;">{{ $currentActivity->title ?? 'Sin actividades aún' }}</div>
        @if($currentActivity)
          <span class="ac-status-badge {{ $currentActivity->status }}" style="margin-top:8px;display:inline-block;">{{ $currentActivity->statusLabel() }}</span>
        @endif
      </div>
      <div class="ac-widget">
        <div class="k">Participaciones realizadas</div>
        <div class="v">{{ ($done ?? collect())->filter(fn ($s) => ! $s->activity->is_hidden && $s->activity->type === 'participacion')->count() }} <small>de {{ $course->activities()->visible()->where('type', 'participacion')->count() }}</small></div>
      </div>
      <div class="ac-widget">
        <div class="k">Actividades pendientes</div>
        <div class="v">{{ $course->activities()->visible()->where('status', 'disponible')->count() }}</div>
      </div>
    </div>

    <h3 style="font-size:0.98rem;color:var(--ink);margin-bottom:1rem;">Actividades</h3>
    @forelse($course->activities()->visible()->reorder()->orderByRaw("status = 'disponible' desc")->orderByDesc('week_number')->get() as $activity)
      @if($activity->isAvailable())
        <a href="{{ route('academico.activity.show', [$university->slug, $course->slug, $activity->slug]) }}" class="ac-activity-card">
          <span class="ac-activity-week">S{{ $activity->week_number }}</span>
          <span class="ac-activity-body">
            <h4>{{ $activity->title }}</h4>
            <p>{{ $activity->typeLabel() }}{{ $activity->case_title ? ': '.$activity->case_title : '' }}</p>
          </span>
@php $mine = ($done ?? collect())->get($activity->id); $g = $mine ? $mine->activity->grade($mine) : null; @endphp
          @if($mine)<span class="ac-status-badge enviada">✓ Enviada @if($g && $g['total_points'])· {{ rtrim(rtrim(number_format($g['earned_points'], 1), '0'), '.') }}/{{ $g['total_points'] }}@endif</span>@else<span class="ac-status-badge {{ $activity->status }}">{{ $activity->statusLabel() }}</span>@endif
        </a>
      @else
        <div class="ac-activity-card" style="opacity:0.55;cursor:default;">
          <span class="ac-activity-week">S{{ $activity->week_number }}</span>
          <span class="ac-activity-body">
            <h4>{{ $activity->title }}</h4>
            <p>{{ $activity->typeLabel() }}{{ $activity->case_title ? ': '.$activity->case_title : '' }}</p>
          </span>
@php $mine = ($done ?? collect())->get($activity->id); $g = $mine ? $mine->activity->grade($mine) : null; @endphp
          @if($mine)<span class="ac-status-badge enviada">✓ Enviada @if($g && $g['total_points'])· {{ rtrim(rtrim(number_format($g['earned_points'], 1), '0'), '.') }}/{{ $g['total_points'] }}@endif</span>@else<span class="ac-status-badge {{ $activity->status }}">{{ $activity->statusLabel() }}</span>@endif
        </div>
      @endif
    @empty
      <p style="color:var(--slate-light);font-size:0.86rem;">Todavía no hay actividades programadas.</p>
    @endforelse
  </div>
</div>

@include('academico._floating-cta')
@endsection
