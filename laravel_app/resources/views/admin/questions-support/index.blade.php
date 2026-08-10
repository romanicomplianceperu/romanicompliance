@extends('admin.layout')

@section('title', 'Preguntas de alumnos')

@section('content')
<div class="page-head">
  <h2 style="font-size:1.15rem">Preguntas y dudas</h2>
</div>

@if($questions->isEmpty())
  <div class="empty-state">Todavía no hay preguntas.</div>
@else
  @foreach($questions as $q)
    <div class="card">
      <div class="page-head" style="margin-bottom:0.6rem;">
        <div>
          <div class="form-hint">{{ $q->course->title }} &middot; {{ $q->user->name }} &middot; {{ $q->created_at->format('d/m/Y H:i') }}</div>
          <h3 style="font-size:1rem;margin-top:4px;">{{ $q->subject }}</h3>
        </div>
        <span class="badge {{ $q->isAnswered() ? 'badge-gold' : 'badge-gray' }}">{{ $q->isAnswered() ? 'Respondida' : 'Pendiente' }}</span>
      </div>
      <p style="font-size:0.88rem;color:var(--slate);margin-bottom:1rem;">{{ $q->question }}</p>

      @if($q->isAnswered())
        <div style="padding:12px 14px;background:var(--ivory);border-left:3px solid var(--gold);border-radius:4px;margin-bottom:1rem;">
          <div class="form-hint">Respuesta enviada</div>
          <p style="font-size:0.85rem;">{{ $q->answer }}</p>
        </div>
      @endif

      <details class="add-panel">
        <summary style="cursor:pointer;font-size:0.8rem;font-weight:600;color:var(--gold);">{{ $q->isAnswered() ? 'Editar respuesta' : '+ Responder' }}</summary>
        <div style="margin-top:0.8rem;">
          <form action="{{ route('admin.questions-support.answer', $q) }}" method="POST">
            @csrf
            <div class="form-group">
              <textarea name="answer">{{ old('answer', $q->answer) }}</textarea>
            </div>
            <button type="submit" class="btn btn-gold btn-sm">Enviar respuesta</button>
          </form>
        </div>
      </details>
    </div>
  @endforeach
@endif
@endsection
