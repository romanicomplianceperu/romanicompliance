@extends('layouts.app')

@section('title', $exam->title.' — '.$course->title)

@section('styles')
.exam-hero { background: var(--ink); padding: 3.5rem 0; position: relative; }
.exam-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
.exam-hero h1 { font-size: clamp(1.5rem, 3vw, 2rem); color: var(--white); font-weight: 400; }
.exam-hero p { font-size: 0.85rem; color: rgba(255,255,255,0.45); margin-top: 0.5rem; }
.exam-meta-list { display: flex; gap: 1.5rem; margin-top: 1.2rem; flex-wrap: wrap; }
.exam-meta-list span { font-size: 0.8rem; color: rgba(255,255,255,0.6); }

.exam-section { padding: 3rem 0; }
.exam-action { background: var(--white); border: 1px solid var(--line); border-radius: 6px; padding: 2rem; text-align: center; margin-bottom: 2rem; }
.exam-action p { font-size: 0.85rem; color: var(--slate); margin-bottom: 1.2rem; }

.attempts-table { width: 100%; border-collapse: collapse; background: var(--white); border: 1px solid var(--line); border-radius: 6px; overflow: hidden; }
.attempts-table th, .attempts-table td { padding: 12px 14px; text-align: left; font-size: 0.82rem; border-bottom: 1px solid var(--line); }
.attempts-table th { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.04em; color: var(--slate-light); background: var(--ivory); }
.attempts-table tr:last-child td { border-bottom: none; }
.status-tag { font-size: 0.68rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; }
.status-passed { background: rgba(37,150,90,0.1); color: #1F7A4D; }
.status-failed { background: var(--danger-pale, rgba(179,65,59,0.08)); color: #B3413B; }
.status-in_progress { background: var(--gold-pale); color: var(--gold); }
.attempts-table-wrap { overflow-x: auto; border-radius: 6px; }
@media (max-width: 680px) { .attempts-table { min-width: 560px; } }
@endsection

@section('content')
<section class="exam-hero">
  <div class="wrap">
    <h1>{{ $exam->title }}</h1>
    <p>{{ $course->title }}</p>
    <div class="exam-meta-list">
      <span>{{ $exam->questions->count() }} preguntas</span>
      <span>Nota mínima: {{ $exam->passing_score }}%</span>
      <span>Intentos máximos: {{ $exam->max_attempts }}</span>
      @if($exam->time_limit_minutes)<span>Tiempo límite: {{ $exam->time_limit_minutes }} min</span>@endif
    </div>
  </div>
</section>

<section class="exam-section">
  <div class="wrap">
    <div class="exam-action">
      @if($inProgress)
        <p>Tienes un intento en curso.</p>
        <a href="{{ route('exams.take', $inProgress) }}" class="btn btn-gold">Continuar examen</a>
      @elseif($canStart)
        <p>Cuando comiences, se registrará tu intento y el tiempo empleado.</p>
        <form action="{{ route('exams.start', $course) }}" method="POST" style="max-width:420px;margin:0 auto;text-align:left;">
          @csrf
          <div class="form-group" style="margin-bottom:1rem;">
            <label style="font-size:0.72rem;font-weight:600;color:var(--slate);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px;display:block;">Nombre para tu certificado</label>
            <input type="text" name="certificate_name" value="{{ old('certificate_name', auth()->user()->name) }}" required style="width:100%;padding:11px 14px;border:1px solid var(--line);border-radius:var(--radius);font-family:var(--sans);font-size:0.9rem;">
            <div class="form-hint" style="margin-top:4px;">Así aparecerá impreso en tu certificado. Puedes ajustarlo si lo necesitas.</div>
          </div>
          <button type="submit" class="btn btn-gold btn-block">Comenzar examen</button>
        </form>
      @else
        <p>Has alcanzado el número máximo de intentos permitidos para este examen.</p>
      @endif
    </div>

    @if($attempts->isNotEmpty())
      <div class="attempts-table-wrap">
      <table class="attempts-table">
        <thead>
          <tr><th>Intento</th><th>Fecha</th><th>Hora</th><th>Nota</th><th>Tiempo</th><th>Estado</th></tr>
        </thead>
        <tbody>
          @foreach($attempts as $attempt)
            <tr>
              <td>#{{ $attempt->attempt_number }}</td>
              <td>{{ $attempt->started_at?->format('d/m/Y') }}</td>
              <td>{{ $attempt->started_at?->format('H:i') }}</td>
              <td>{{ $attempt->score !== null ? $attempt->score.'%' : '—' }}</td>
              <td>{{ $attempt->time_spent_seconds ? gmdate('i:s', $attempt->time_spent_seconds) : '—' }}</td>
              <td>
                @if($attempt->status === 'in_progress')
                  <span class="status-tag status-in_progress">En curso</span>
                @elseif($attempt->status === 'passed')
                  <span class="status-tag status-passed">Aprobado</span>
                @else
                  <span class="status-tag status-failed">Reprobado</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      </div>
    @endif
  </div>
</section>
@endsection
