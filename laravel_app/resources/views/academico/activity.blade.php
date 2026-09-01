@extends('layouts.app')

@section('title', $activity->title.' — '.$course->name.' — Espacio Académico')

@section('styles')
@include('academico._styles')
.ac-pending-box { background: var(--white); border: 1.5px dashed var(--line); border-radius: 14px; padding: 2rem; text-align: center; color: var(--slate); }
.ac-pending-box .icon { font-size: 1.6rem; margin-bottom: 10px; }
@endsection

@section('content')
@php $acCrumbExtra = $activity->title; @endphp
@include('academico._course-header')

@php $acActiveTab = 'participacion'; @endphp
@include('academico._course-tabs')

<div class="ac-shell">
  <div class="wrap" style="padding:2.2rem 24px;max-width:820px;">

    @if(session('academico_success'))
      <div class="ac-response-sent" style="margin-bottom:1.4rem;">{{ session('academico_success') }}</div>
    @endif

    <div class="ac-case-card">
      <div class="ac-case-tags">
        <span class="ac-case-tag">Semana {{ $activity->week_number }}</span>
        @if($activity->unit)<span class="ac-case-tag">{{ $activity->unit }}</span>@endif
        @if($activity->modality)<span class="ac-case-tag">{{ $activity->modality }}</span>@endif
        @if($activity->group_size)<span class="ac-case-tag">{{ $activity->group_size }}</span>@endif
      </div>

      <h2>{{ $activity->case_title ?? $activity->title }}</h2>

      @if($activity->case_body)
        <div class="body">
          @foreach($activity->caseBodyParagraphs() as $p)
            <p>{{ $p }}</p>
          @endforeach
        </div>
        @if($activity->case_document_path)
          <a href="{{ asset('storage/'.$activity->case_document_path) }}" target="_blank" class="ac-case-doc-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg>
            Ver documento original
          </a>
        @endif
      @else
        <div class="ac-pending-box">
          <div class="icon">📄</div>
          <strong style="display:block;color:var(--ink);margin-bottom:6px;">Contenido del caso en preparación</strong>
          <p style="font-size:0.85rem;">Esta pantalla ya está lista para mostrar el caso completo y sus preguntas — se publicará en cuanto se cargue el documento oficial de la Semana 1.</p>
        </div>
      @endif
    </div>

    @if($activity->questions->count() > 0)
      <h3 style="font-size:1rem;color:var(--ink);margin-bottom:1rem;">Preguntas de participación</h3>
      @foreach($activity->questions as $i => $question)
        @php $resp = $responses[$question->id] ?? null; @endphp
        <div class="ac-question-card">
          <div class="q-num">Pregunta {{ $i + 1 }}</div>
          <div class="q-text">{{ $question->prompt }}</div>

          @if($resp && $resp->status === 'enviada')
            <div class="ac-response-sent">
              {{ $resp->body }}
              <span class="when">Enviada el {{ $resp->submitted_at?->format('d/m/Y H:i') }}</span>
            </div>
          @else
            <form method="POST" action="{{ route('academico.activity.respond', [$university->slug, $course->slug, $activity->slug]) }}" class="ac-response-form" data-question="{{ $question->id }}">
              @csrf
              <input type="hidden" name="question_id" value="{{ $question->id }}">
              <textarea name="body" maxlength="2000" placeholder="Escribe tu respuesta…">{{ $resp->body ?? '' }}</textarea>
              <div class="ac-question-footer">
                <span class="ac-char-count">0 / 2000</span>
                <div class="ac-question-actions">
                  <button type="submit" name="action" value="borrador" class="ac-btn-ghost">Guardar borrador</button>
                  <button type="submit" name="action" value="enviar" class="ac-btn-solid" onclick="return confirm('¿Deseas enviar tu participación?');">Enviar participación</button>
                </div>
              </div>
              @if($resp && $resp->status === 'borrador')
                <div style="margin-top:8px;"><span class="ac-status-badge borrador">Borrador guardado</span></div>
              @endif
            </form>
          @endif
        </div>
      @endforeach
    @elseif($activity->case_body)
      <div class="ac-pending-box"><p style="font-size:0.85rem;">Las preguntas de esta actividad se publicarán próximamente.</p></div>
    @endif

  </div>
</div>

@include('academico._floating-cta')
@endsection

@section('scripts')
<script>
document.querySelectorAll('.ac-response-form').forEach(form => {
  const textarea = form.querySelector('textarea');
  const counter = form.querySelector('.ac-char-count');
  function update() { counter.textContent = textarea.value.length + ' / 2000'; }
  textarea.addEventListener('input', update);
  update();
});
</script>
@endsection
