@extends('layouts.app')

@section('title', 'Rindiendo: '.$exam->title)

@section('styles')
.take-hero { background: var(--ink); padding: 2.5rem 0; position: relative; }
.take-hero-inner { display: flex; align-items: center; justify-content: space-between; }
.take-hero h1 { font-size: 1.3rem; color: var(--white); font-weight: 400; }
#timer { font-family: var(--serif); font-size: 1.4rem; color: var(--gold-light); font-weight: 600; }

.take-section { padding: 2.5rem 0; }
.question-card { background: var(--white); border: 1px solid var(--line); border-radius: 6px; padding: 1.8rem; margin-bottom: 1.2rem; }
.question-card h3 { font-size: 0.95rem; margin-bottom: 1rem; line-height: 1.5; }
.option-row { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid var(--line); border-radius: var(--radius); margin-bottom: 8px; cursor: pointer; transition: border-color 0.2s, background 0.2s; }
.option-row:hover { border-color: var(--gold); }
.option-row input { width: auto; }
.option-row span { font-size: 0.85rem; }
@endsection

@section('content')
<section class="take-hero">
  <div class="wrap take-hero-inner">
    <h1>{{ $exam->title }}</h1>
    @if($exam->time_limit_minutes)
      @php $remaining = max(0, (int) round($exam->time_limit_minutes * 60 - now()->diffInSeconds($attempt->started_at, absolute: true))); @endphp
      <div id="timer" data-seconds="{{ $remaining }}">--:--</div>
    @endif
  </div>
</section>

<section class="take-section">
  <div class="wrap">
    <form action="{{ route('exams.submit', $attempt) }}" method="POST" id="examForm">
      @csrf
      @foreach($exam->questions as $question)
        <div class="question-card">
          <h3>{{ $loop->iteration }}. {{ $question->question_text }}</h3>
          @foreach($question->options as $option)
            <label class="option-row">
              <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required>
              <span>{{ $option->option_text }}</span>
            </label>
          @endforeach
        </div>
      @endforeach
      <button type="submit" class="btn btn-gold">Enviar examen</button>
    </form>
  </div>
</section>
@endsection

@section('scripts')
<script>
const timerEl = document.getElementById('timer');
if (timerEl) {
  let seconds = parseInt(timerEl.dataset.seconds, 10);
  function render() {
    if (seconds <= 0) {
      document.getElementById('examForm').submit();
      return;
    }
    const m = Math.floor(seconds / 60).toString().padStart(2, '0');
    const s = (seconds % 60).toString().padStart(2, '0');
    timerEl.textContent = `${m}:${s}`;
    seconds--;
  }
  render();
  setInterval(render, 1000);
}
</script>
@endsection
