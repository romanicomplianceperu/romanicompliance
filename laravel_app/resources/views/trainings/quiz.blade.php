@extends('layouts.app')

@section('title', 'Evaluación · '.$training->title)

@section('styles')
@include('trainings._styles')
.tr-quiz-shell { max-width: 760px; margin: 0 auto; padding-top: 1.5rem; }
.tr-timer-bar { position: sticky; top: 0; z-index: 50; background: var(--ink); color: var(--white); padding: 12px 20px; border-radius: 10px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.6rem; box-shadow: var(--shadow-m); }
.tr-timer-label { font-size: 0.78rem; color: rgba(255,255,255,0.6); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
.tr-timer-value { font-family: var(--serif); font-size: 1.3rem; font-weight: 700; color: var(--gold-light); font-variant-numeric: tabular-nums; }
.tr-timer-bar.tr-timer-low .tr-timer-value { color: #E07A6B; }
.tr-quiz-progress { font-size: 0.78rem; color: var(--slate); margin-bottom: 1.6rem; }
.tr-question-card { background: var(--white); border: 1px solid var(--line); border-radius: 14px; padding: 1.6rem 1.8rem; margin-bottom: 1.1rem; }
.tr-question-num { font-size: 0.7rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
.tr-question-text { font-size: 0.96rem; color: var(--ink); font-weight: 600; margin-bottom: 1.1rem; line-height: 1.55; }
.tr-option { display: flex; align-items: flex-start; gap: 10px; padding: 11px 14px; border: 1.5px solid var(--line); border-radius: 9px; margin-bottom: 8px; cursor: pointer; transition: all 0.15s ease; }
.tr-option:hover { border-color: var(--gold); }
.tr-option input { margin-top: 3px; accent-color: var(--gold); flex-shrink: 0; }
.tr-option span { font-size: 0.85rem; color: var(--ink); line-height: 1.5; }
.tr-option:has(input:checked) { border-color: var(--gold); background: var(--gold-pale); }
.tr-submit-bar { display: flex; justify-content: center; margin-top: 1.8rem; }
@endsection

@section('content')
<div class="tr-shell">
  <div class="wrap">
    <div class="tr-quiz-shell">

      <div class="tr-timer-bar" id="trTimerBar">
        <span class="tr-timer-label">{{ $training->title }}</span>
        <span class="tr-timer-value" id="trTimerValue">--:--</span>
      </div>

      <div class="tr-quiz-progress">{{ $questions->count() }} preguntas · Marque una opción por pregunta y envíe antes de que el tiempo termine.</div>

      <form method="POST" action="{{ route('capacitacion.submit', $training) }}" id="trQuizForm">
        @csrf
        @foreach($questions as $question)
          <div class="tr-question-card">
            <div class="tr-question-num">Pregunta {{ $loop->iteration }} de {{ $questions->count() }}</div>
            <div class="tr-question-text">{{ $question->question }}</div>
            @foreach($question->options() as $letter => $text)
              <label class="tr-option">
                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $letter }}" required>
                <span><strong>{{ $letter }}.</strong> {{ $text }}</span>
              </label>
            @endforeach
          </div>
        @endforeach

        <div class="tr-submit-bar">
          <button type="submit" class="tr-btn tr-btn-solid">Enviar evaluación →</button>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
  let remaining = {{ $attempt->remainingSeconds() }};
  const valueEl = document.getElementById('trTimerValue');
  const barEl = document.getElementById('trTimerBar');
  const form = document.getElementById('trQuizForm');
  let submitted = false;

  function render() {
    const m = Math.floor(remaining / 60);
    const s = remaining % 60;
    valueEl.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
    if (remaining <= 120) barEl.classList.add('tr-timer-low');
  }
  render();

  const interval = setInterval(() => {
    remaining--;
    if (remaining <= 0) {
      remaining = 0;
      render();
      clearInterval(interval);
      if (!submitted) {
        submitted = true;
        form.submit();
      }
      return;
    }
    render();
  }, 1000);

  form.addEventListener('submit', () => { submitted = true; });
})();
</script>
@endsection
