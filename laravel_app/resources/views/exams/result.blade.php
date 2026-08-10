@extends('layouts.app')

@section('title', 'Resultado: '.$exam->title)

@section('styles')
.result-hero { padding: 4.5rem 0; text-align: center; position: relative; overflow: hidden; }
.result-hero.passed { background: linear-gradient(180deg, rgba(37,150,90,0.08) 0%, rgba(37,150,90,0.02) 100%); }
.result-hero.failed { background: linear-gradient(180deg, rgba(179,65,59,0.07) 0%, rgba(179,65,59,0.02) 100%); }

.result-ring-wrap { width: 150px; height: 150px; margin: 0 auto 1.5rem; position: relative; }
.result-ring-wrap svg { width: 100%; height: 100%; transform: rotate(-90deg); }
.result-ring-track { fill: none; stroke: var(--ivory-dim); stroke-width: 8; }
.result-ring-fill { fill: none; stroke-width: 8; stroke-linecap: round; stroke-dasharray: 408; stroke-dashoffset: 408; animation: ringFill 1.2s cubic-bezier(0.22,1,0.36,1) 0.2s forwards; }
.result-hero.passed .result-ring-fill { stroke: #1F7A4D; }
.result-hero.failed .result-ring-fill { stroke: #B3413B; }
@keyframes ringFill { to { stroke-dashoffset: var(--ring-offset); } }
.result-ring-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; }
.result-ring-score { font-family: var(--serif); font-size: 2.3rem; font-weight: 700; color: var(--ink); opacity: 0; animation: fadeIn 0.6s ease 0.9s forwards; }
.result-ring-icon { width: 56px; height: 56px; opacity: 0; animation: popIn 0.5s cubic-bezier(0.34,1.56,0.64,1) 1s forwards; }
@keyframes fadeIn { to { opacity: 1; } }
@keyframes popIn { to { opacity: 1; transform: scale(1); } from { transform: scale(0.4); } }

.result-hero h1 { font-size: 1.7rem; margin-bottom: 0.5rem; opacity: 0; animation: slideUpFade 0.6s ease 0.5s forwards; }
.result-hero .subtitle { font-size: 0.9rem; color: var(--slate); opacity: 0; animation: slideUpFade 0.6s ease 0.6s forwards; }
@keyframes slideUpFade { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

.result-meta { display: flex; justify-content: center; gap: 1.2rem; margin-top: 2rem; flex-wrap: wrap; opacity: 0; animation: slideUpFade 0.6s ease 1.1s forwards; }
.result-meta-card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 1rem 1.6rem; min-width: 110px; }
.result-meta-card .num { font-family: var(--serif); font-size: 1.5rem; font-weight: 600; color: var(--ink); }
.result-meta-card .label { font-size: 0.68rem; color: var(--slate-light); text-transform: uppercase; letter-spacing: 0.04em; margin-top: 2px; }

.cert-banner { max-width: 560px; margin: 2rem auto 0; background: var(--ink); border-radius: 10px; padding: 1.6rem 2rem; display: flex; align-items: center; gap: 1.2rem; opacity: 0; animation: slideUpFade 0.6s ease 1.3s forwards; }
.cert-banner-icon { width: 48px; height: 48px; flex-shrink: 0; background: var(--gold-pale); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
.cert-banner-text { flex: 1; text-align: left; }
.cert-banner-text h3 { font-size: 1rem; color: var(--white); margin-bottom: 2px; }
.cert-banner-text p { font-size: 0.78rem; color: rgba(255,255,255,0.5); }
.cert-banner .btn { flex-shrink: 0; }

.actions-row { display: flex; gap: 12px; justify-content: center; margin-top: 2rem; flex-wrap: wrap; opacity: 0; animation: slideUpFade 0.6s ease 1.2s forwards; }

.review-section { padding: 3rem 0; }
.review-toggle { display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 1.5rem; cursor: pointer; color: var(--slate); font-size: 0.85rem; font-weight: 600; }
.review-toggle svg { width: 16px; height: 16px; transition: transform 0.3s; }
.review-toggle.open svg { transform: rotate(180deg); }
.review-list { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
.review-item { background: var(--white); border: 1px solid var(--line); border-radius: 6px; padding: 1.5rem; margin-bottom: 1rem; }
.review-item h4 { font-size: 0.9rem; margin-bottom: 0.8rem; }
.review-answer { font-size: 0.82rem; padding: 6px 0; display: flex; align-items: center; gap: 8px; }
.review-answer.correct { color: #1F7A4D; font-weight: 600; }
.review-answer.incorrect { color: #B3413B; font-weight: 600; }
.review-icon { display: inline-flex; }
.review-icon svg { width: 13px; height: 13px; }

@media (max-width: 680px) {
  .cert-banner { flex-direction: column; text-align: center; padding: 1.4rem; }
  .cert-banner-text { text-align: center; }
  .result-meta { gap: 0.7rem; }
  .result-meta-card { min-width: 90px; padding: 0.8rem 1rem; }
}
@endsection

@section('content')
@php
  $pct = min(100, max(0, (float) $attempt->score));
  $circumference = 408;
  $offset = $circumference - ($pct / 100) * $circumference;
@endphp
<section class="result-hero {{ $attempt->status }}">
  <div class="wrap">
    <div class="result-ring-wrap">
      <svg viewBox="0 0 140 140">
        <circle class="result-ring-track" cx="70" cy="70" r="65"></circle>
        <circle class="result-ring-fill" cx="70" cy="70" r="65" style="--ring-offset: {{ $offset }}"></circle>
      </svg>
      <div class="result-ring-center">
        <div class="result-ring-score">{{ rtrim(rtrim(number_format($attempt->score, 1), '0'), '.') }}%</div>
      </div>
    </div>

    <h1>{{ $attempt->status === 'passed' ? '¡Felicidades, aprobaste!' : 'No alcanzaste la nota mínima' }}</h1>
    <p class="subtitle">{{ $exam->title }} — {{ $course->title }}</p>

    <div class="result-meta">
      <div class="result-meta-card"><div class="num">#{{ $attempt->attempt_number }}</div><div class="label">Intento</div></div>
      <div class="result-meta-card"><div class="num">{{ $exam->passing_score }}%</div><div class="label">Nota mínima</div></div>
      <div class="result-meta-card"><div class="num">{{ gmdate('i:s', $attempt->time_spent_seconds ?? 0) }}</div><div class="label">Tiempo empleado</div></div>
    </div>

    @if($certificate)
      <div class="cert-banner">
        <div class="cert-banner-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:22px;height:22px;color:var(--gold);"><circle cx="12" cy="8" r="5"/><path d="M8.5 12.5L7 21l5-2.5L17 21l-1.5-8.5"/></svg></div>
        <div class="cert-banner-text">
          <h3>Tu certificado está listo</h3>
          <p>Código {{ $certificate->code }} — disponible también en tu panel</p>
        </div>
        <a href="{{ route('certificates.download', $certificate) }}" class="btn btn-gold">Descargar certificado</a>
      </div>
    @elseif($pendingCertificate)
      <div class="cert-banner">
        <div class="cert-banner-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:22px;height:22px;color:var(--gold);"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg></div>
        <div class="cert-banner-text">
          <h3>Tu certificado está en proceso</h3>
          <p>Registramos tu solicitud. Nuestro equipo la emitirá una vez confirmado tu pago.</p>
        </div>
      </div>
    @elseif($awaitingPayment)
      <div class="cert-banner">
        <div class="cert-banner-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:22px;height:22px;color:var(--gold);"><rect x="5" y="11" width="14" height="9" rx="1.5"/><path d="M8 11V8a4 4 0 018 0v3"/></svg></div>
        <div class="cert-banner-text">
          <h3>Aprobaste el examen — falta completar el pago</h3>
          <p>Esta es una certificación opcional de pago. Completa tu solicitud desde el curso para que emitamos tu certificado.</p>
        </div>
        <a href="{{ route('courses.show', $course) }}" class="btn btn-gold">Ir a completar el pago</a>
      </div>
    @endif

    <div class="actions-row">
      @if($attempt->status !== 'passed')
        <a href="{{ route('exams.show', $course) }}" class="btn btn-gold">Volver a intentar</a>
      @endif
      <a href="{{ route('courses.show', $course) }}" class="btn btn-ghost-dark" style="border:1px solid var(--line);color:var(--ink);">Volver al curso</a>
    </div>
  </div>
</section>

<section class="review-section">
  <div class="wrap" style="max-width:760px;margin:0 auto;">
    <div class="review-toggle" id="reviewToggle" onclick="toggleReview()">
      <span>Ver revisión de respuestas</span>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
    </div>
    <div class="review-list" id="reviewList">
      @foreach($attempt->answers as $answer)
        <div class="review-item">
          <h4>{{ $answer->question->question_text }}</h4>
          <div class="review-answer {{ $answer->is_correct ? 'correct' : 'incorrect' }}">
            <span class="review-icon">{!! $answer->is_correct ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>' : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M6 6l12 12M18 6L6 18"/></svg>' !!}</span> Tu respuesta: {{ $answer->answerOption->option_text ?? 'Sin responder' }}
          </div>
          @if(!$answer->is_correct)
            <div class="review-answer correct"><span class="review-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></span> Respuesta correcta: {{ $answer->question->options->firstWhere('is_correct', true)?->option_text }}</div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
function toggleReview() {
  const toggle = document.getElementById('reviewToggle');
  const list = document.getElementById('reviewList');
  const isOpen = toggle.classList.toggle('open');
  list.style.maxHeight = isOpen ? list.scrollHeight + 'px' : null;
}
</script>
@endsection
