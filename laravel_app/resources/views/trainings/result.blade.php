@extends('layouts.app')

@section('title', 'Resultado · '.$training->title)

@section('styles')
@include('trainings._styles')
.tr-result-shell { max-width: 560px; margin: 3.5rem auto; text-align: center; }
.tr-result-card { background: var(--white); border: 1px solid var(--line); border-radius: 18px; padding: 3rem 2.4rem; box-shadow: var(--shadow-m); }
.tr-result-badge { width: 84px; height: 84px; border-radius: 50%; background: linear-gradient(135deg, var(--gold-light), var(--gold)); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.4rem; box-shadow: 0 14px 34px rgba(184,154,86,0.35); }
.tr-result-badge svg { width: 42px; height: 42px; color: var(--white); }
.tr-result-score { font-family: var(--serif); font-size: 3rem; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
.tr-result-score span { font-size: 1.3rem; color: var(--slate-light); font-weight: 500; }
.tr-result-sub { font-size: 0.85rem; color: var(--slate); margin-bottom: 1.6rem; }
.tr-result-card h1 { font-family: var(--serif); font-size: 1.5rem; color: var(--ink); margin-bottom: 0.6rem; }
.tr-result-message { font-size: 0.92rem; color: var(--slate); line-height: 1.75; margin-bottom: 1.8rem; }
.tr-result-meta { display: flex; justify-content: center; gap: 2rem; padding-top: 1.4rem; border-top: 1px solid var(--line); margin-bottom: 1.8rem; }
.tr-result-meta-item { display: flex; flex-direction: column; gap: 3px; }
.tr-result-meta-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-light); }
.tr-result-meta-value { font-size: 0.88rem; font-weight: 700; color: var(--ink); }
@endsection

@section('content')
<div class="tr-shell">
  <div class="wrap">
    <div class="tr-result-shell">
      <div class="tr-result-card">
        <div class="tr-result-badge">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2.5l8 3.3v5.4c0 5-3.4 8.8-8 10.3-4.6-1.5-8-5.3-8-10.3V5.8l8-3.3z"/><path d="M9 12l2 2 4-4.5"/></svg>
        </div>
        <div class="tr-result-score">{{ rtrim(rtrim(number_format($attempt->score_percent, 1), '0'), '.') }}<span>/100</span></div>
        <div class="tr-result-sub">{{ $attempt->correct_count }} de {{ $attempt->total_questions }} respuestas correctas</div>

        <h1>¡Gracias por participar, {{ \Illuminate\Support\Str::of($attempt->full_name)->explode(' ')->first() }}!</h1>
        <p class="tr-result-message">Ha completado la evaluación de <strong>{{ $training->title }}</strong>. Su participación fortalece el análisis del lavado de activos desde la judicatura y el Ministerio Público, y es un aporte valioso para el programa. Felicitaciones por su compromiso con esta capacitación.</p>

        <div class="tr-result-meta">
          <div class="tr-result-meta-item">
            <span class="tr-result-meta-label">Cargo</span>
            <span class="tr-result-meta-value">{{ $attempt->positionLabel() }}</span>
          </div>
          <div class="tr-result-meta-item">
            <span class="tr-result-meta-label">Fecha</span>
            <span class="tr-result-meta-value">{{ $attempt->finished_at->timezone('America/Lima')->translatedFormat('d \d\e F, Y') }}</span>
          </div>
        </div>

        <a href="{{ route('capacitacion.show', $training) }}" class="tr-btn tr-btn-outline">Volver al taller</a>
      </div>
    </div>
  </div>
</div>
@endsection
