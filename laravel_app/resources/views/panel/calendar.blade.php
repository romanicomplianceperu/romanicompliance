@extends('layouts.panel')

@section('title', 'Mi calendario')

@section('styles')
.timeline { position: relative; padding-left: 2rem; }
.timeline::before { content: ''; position: absolute; left: 9px; top: 6px; bottom: 6px; width: 1px; background: var(--line); }
.timeline-item { position: relative; padding-bottom: 1.6rem; }
.timeline-item:last-child { padding-bottom: 0; }
.timeline-dot { position: absolute; left: -2rem; top: 3px; width: 20px; height: 20px; border-radius: 50%; background: var(--white); border: 1px solid var(--line); display: flex; align-items: center; justify-content: center; }
.timeline-dot svg { width: 11px; height: 11px; }
.timeline-item.certificate .timeline-dot { border-color: var(--gold); color: var(--gold); }
.timeline-item.enrollment .timeline-dot { border-color: var(--slate-light); color: var(--slate); }
.timeline-date { font-size: 0.7rem; color: var(--slate-light); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 2px; }
.timeline-label { font-size: 0.9rem; color: var(--ink); font-weight: 500; }
@endsection

@section('content')
<div class="card">
  @if($events->isEmpty())
    <div class="empty-state">No hay fechas para mostrar todavía. Aquí verás tus inscripciones y certificados a medida que avances.</div>
  @else
    <div class="timeline">
      @foreach($events as $event)
        <div class="timeline-item {{ $event['type'] }}">
          <div class="timeline-dot">
            @if($event['type'] === 'certificate')
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M8.5 12.5L7 21l5-2.5L17 21l-1.5-8.5"/></svg>
            @else
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5V6a2 2 0 012-2h8.5L20 8.5V19.5a1.5 1.5 0 01-1.5 1.5h-13A1.5 1.5 0 014 19.5z"/></svg>
            @endif
          </div>
          <div class="timeline-date">{{ $event['date']->translatedFormat('d \d\e F \d\e Y') }}</div>
          <div class="timeline-label">{{ $event['label'] }}</div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
