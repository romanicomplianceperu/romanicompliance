@extends('layouts.app')

@section('title', 'Participación — '.$course->name.' — Espacio Académico')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
@php $acCrumbExtra = 'Participación'; @endphp
@include('academico._course-header')

@php $acActiveTab = 'participacion'; @endphp
@include('academico._course-tabs')

<div class="ac-shell">
  <div class="wrap" style="padding:2.2rem 24px;">
    <h2 style="font-family:var(--serif);font-size:1.3rem;color:var(--ink);margin-bottom:0.4rem;">Participación en clase</h2>
    <p style="font-size:0.86rem;color:var(--slate);margin-bottom:1.6rem;">Cada semana encontrarás aquí el caso o la pregunta de participación correspondiente.</p>

    @if(session('academico_error'))
      <div class="ac-form-error" style="margin-bottom:1.4rem;">{{ session('academico_error') }}</div>
    @endif

    @forelse($activities as $activity)
      @if($activity->isAvailable())
        <a href="{{ route('academico.activity.show', [$university->slug, $course->slug, $activity->slug]) }}" class="ac-activity-card">
          <span class="ac-activity-week">S{{ $activity->week_number }}</span>
          <span class="ac-activity-body">
            <h4>{{ $activity->title }}</h4>
            <p>{{ $activity->case_title ?? 'Participación en clase' }}</p>
          </span>
          <span class="ac-status-badge {{ $activity->status }}">{{ ucfirst($activity->status) }}</span>
        </a>
      @else
        <div class="ac-activity-card" style="opacity:0.55;cursor:default;">
          <span class="ac-activity-week">S{{ $activity->week_number }}</span>
          <span class="ac-activity-body">
            <h4>{{ $activity->title }}</h4>
            <p>{{ $activity->case_title ?? 'Participación en clase' }}</p>
          </span>
          <span class="ac-status-badge {{ $activity->status }}">{{ ucfirst($activity->status) }}</span>
        </div>
      @endif
    @empty
      <p style="color:var(--slate-light);font-size:0.86rem;">Todavía no hay actividades de participación publicadas.</p>
    @endforelse
  </div>
</div>

@include('academico._floating-cta')
@endsection
