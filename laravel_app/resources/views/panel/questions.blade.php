@extends('layouts.panel')

@section('title', 'Preguntas y dudas')

@section('content')
<h1 style="font-size:1.3rem;margin-bottom:1.4rem;display:flex;align-items:center;gap:10px;">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
  Preguntas y dudas
</h1>

@if(session('success'))
  <div style="padding:12px 16px;border-radius:4px;font-size:0.85rem;margin-bottom:1.5rem;background:rgba(37,150,90,0.08);color:#1F7A4D;border:1px solid rgba(37,150,90,0.2);">{{ session('success') }}</div>
@endif

<div style="background:var(--white);border:1px solid var(--line);border-radius:8px;padding:1.6rem;margin-bottom:1.6rem;">
  <h3 style="font-size:1rem;margin-bottom:1rem;">Enviar una nueva pregunta</h3>
  @if($courses->isEmpty())
    <p style="font-size:0.85rem;color:var(--slate);">Inscríbete en un curso para poder enviar preguntas.</p>
  @else
    <form action="{{ route('panel.questions.store') }}" method="POST">
      @csrf
      <div style="margin-bottom:1rem;">
        <label style="display:block;font-size:0.75rem;font-weight:600;color:var(--slate);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:6px;">Curso</label>
        <select name="course_id" required style="width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:4px;">
          @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->title }}</option>
          @endforeach
        </select>
      </div>
      <div style="margin-bottom:1rem;">
        <label style="display:block;font-size:0.75rem;font-weight:600;color:var(--slate);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:6px;">Asunto</label>
        <input type="text" name="subject" required maxlength="255" style="width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:4px;">
      </div>
      <div style="margin-bottom:1.2rem;">
        <label style="display:block;font-size:0.75rem;font-weight:600;color:var(--slate);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:6px;">Tu pregunta</label>
        <textarea name="question" required maxlength="2000" rows="4" style="width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:4px;"></textarea>
      </div>
      <button type="submit" class="btn btn-gold">Enviar pregunta</button>
    </form>
  @endif
</div>

<h3 style="font-size:1rem;margin-bottom:1rem;">Tus preguntas</h3>
@if($questions->isEmpty())
  <div style="text-align:center;padding:2.5rem 1rem;color:var(--slate);font-size:0.88rem;border:1px dashed var(--line);border-radius:8px;">Todavía no has enviado ninguna pregunta.</div>
@else
  @foreach($questions as $q)
    <div style="background:var(--white);border:1px solid var(--line);border-radius:8px;padding:1.2rem 1.4rem;margin-bottom:1rem;">
      <div style="display:flex;justify-content:space-between;align-items:start;gap:1rem;flex-wrap:wrap;">
        <div>
          <div style="font-size:0.72rem;color:var(--gold);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:4px;">{{ $q->course->title }}</div>
          <h4 style="font-size:0.95rem;">{{ $q->subject }}</h4>
        </div>
        <span style="font-size:0.7rem;font-weight:600;padding:3px 10px;border-radius:20px;{{ $q->isAnswered() ? 'background:rgba(37,150,90,0.1);color:#1F7A4D;' : 'background:var(--ivory-dim);color:var(--slate);' }}">{{ $q->isAnswered() ? 'Respondida' : 'Pendiente' }}</span>
      </div>
      <p style="font-size:0.85rem;color:var(--slate);margin-top:8px;">{{ $q->question }}</p>
      @if($q->isAnswered())
        <div style="margin-top:10px;padding:12px 14px;background:var(--ivory);border-left:3px solid var(--gold);border-radius:4px;">
          <div style="font-size:0.7rem;color:var(--gold);font-weight:700;text-transform:uppercase;letter-spacing:0.04em;margin-bottom:4px;">Respuesta</div>
          <p style="font-size:0.85rem;">{{ $q->answer }}</p>
        </div>
      @endif
      <div style="font-size:0.7rem;color:var(--slate-light);margin-top:8px;">{{ $q->created_at->format('d/m/Y H:i') }}</div>
    </div>
  @endforeach
@endif
@endsection
