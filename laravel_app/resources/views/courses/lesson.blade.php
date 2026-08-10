@extends('layouts.app')

@section('title', $lesson->title.' — '.$course->title)

@section('styles')
.lesson-layout { display: grid; grid-template-columns: 2.2fr 1fr; gap: 2rem; padding: 2.5rem 0; align-items: start; }
.lesson-main h1 { font-size: 1.4rem; margin-bottom: 1.2rem; }
.lesson-video { position: relative; width: 100%; padding-top: 56.25%; background: var(--ink); border-radius: 6px; overflow: hidden; margin-bottom: 1.5rem; }
.lesson-video iframe, .lesson-video video { position: absolute; inset: 0; width: 100%; height: 100%; border: none; }
.lesson-pdf { width: 100%; height: 70vh; border: 1px solid var(--line); border-radius: 6px; margin-bottom: 1.5rem; }
.lesson-file-link { display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px; background: var(--white); border: 1px solid var(--line); border-radius: var(--radius); font-size: 0.85rem; font-weight: 600; color: var(--ink); margin-bottom: 1.5rem; }
.lesson-file-link:hover { border-color: var(--gold); color: var(--gold); }
.lesson-text-content { background: var(--white); border: 1px solid var(--line); border-radius: 6px; padding: 1.8rem; font-size: 0.9rem; line-height: 1.8; color: var(--ink); margin-bottom: 1.5rem; white-space: pre-line; }
.lesson-nav { display: flex; justify-content: space-between; gap: 1rem; margin-top: 1.5rem; }
.lesson-nav a, .lesson-nav button { font-size: 0.82rem; }

.lesson-sidebar { background: var(--white); border: 1px solid var(--line); border-radius: 6px; padding: 1.2rem; position: sticky; top: 90px; }
.lesson-sidebar h4 { font-size: 0.85rem; margin-bottom: 1rem; }
.sidebar-progress-track { background: var(--ivory-dim); border-radius: 20px; height: 7px; overflow: hidden; margin-bottom: 6px; }
.sidebar-progress-fill { background: var(--gold); height: 100%; transition: width 0.4s ease; }
.sidebar-progress-label { font-size: 0.7rem; color: var(--slate); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 1.2rem; }
.sidebar-module { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: var(--slate-light); margin: 1rem 0 0.4rem; }
.sidebar-lesson { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: var(--radius); font-size: 0.8rem; color: var(--slate); }
.sidebar-lesson.current { background: var(--gold-pale); color: var(--gold); font-weight: 600; }
.sidebar-lesson.done { color: #1F7A4D; }
.sidebar-check { width: 16px; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center; }
.sidebar-check svg { width: 13px; height: 13px; }
.sidebar-exam { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: var(--radius); font-size: 0.8rem; color: var(--slate); border: 1px dashed var(--line); margin-top: 4px; }
.sidebar-exam svg { width: 15px; height: 15px; flex-shrink: 0; color: var(--gold); }
.sidebar-cert { margin-top: 1.4rem; padding-top: 1.2rem; border-top: 1px solid var(--line); }
.btn-cert { border: 1px solid var(--gold); color: var(--gold); background: transparent; display: block; text-align: center; width: 100%; padding: 11px; border-radius: var(--radius); font-size: 0.82rem; font-weight: 600; }
.btn-cert:hover { background: var(--gold-pale); }
.btn-cert-locked { border: 1px solid var(--line); color: var(--slate-light); background: transparent; cursor: not-allowed; }
.btn-cert-locked:hover { background: transparent; }

@media (max-width: 900px) {
  .lesson-layout { grid-template-columns: 1fr; padding: 1.5rem 0; gap: 1.2rem; }
  .lesson-sidebar { position: static; max-height: 320px; overflow-y: auto; order: 2; }
  .lesson-main { order: 1; }
  .lesson-pdf { height: 55vh; }
  .lesson-nav { flex-wrap: wrap; }
}
@endsection

@section('content')
<div class="wrap lesson-layout">
  <div class="lesson-main">
    <div class="course-hero-category" style="color:var(--gold)">{{ $course->title }}</div>
    <h1>{{ $lesson->title }}</h1>

    @if($lesson->type === 'video' && $lesson->embedUrl())
      <div class="lesson-video">
        <iframe src="{{ $lesson->embedUrl() }}" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
      </div>
    @elseif($lesson->type === 'pdf' && $lesson->file_path)
      <iframe src="{{ asset('storage/'.$lesson->file_path) }}" class="lesson-pdf"></iframe>
      <a href="{{ asset('storage/'.$lesson->file_path) }}" target="_blank" class="lesson-file-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;"><path d="M12 4v11m0 0l4-4m-4 4l-4-4M5 19h14"/></svg>
        Descargar PDF
      </a>
    @elseif($lesson->type === 'file' && $lesson->file_path)
      <a href="{{ asset('storage/'.$lesson->file_path) }}" target="_blank" class="lesson-file-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;"><path d="M12 4v11m0 0l4-4m-4 4l-4-4M5 19h14"/></svg>
        Descargar archivo
      </a>
    @elseif($lesson->type === 'text')
      <div class="lesson-text-content">{{ $lesson->content }}</div>
    @endif

    <div class="lesson-nav">
      <div>
        @if($previousLesson)
          <a href="{{ route('lessons.show', $previousLesson) }}" class="btn btn-outline-dark" style="border:1px solid var(--line);padding:10px 18px;border-radius:4px;">← Anterior</a>
        @endif
      </div>
      <form action="{{ route('lessons.complete', $lesson) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-gold">{{ $isCompleted ? ($nextLesson ? 'Siguiente lección →' : 'Volver al curso') : 'Marcar como completada' }}</button>
      </form>
    </div>
  </div>

  <div class="lesson-sidebar">
    <h4>Contenido del curso</h4>
    <div class="sidebar-progress-track"><div class="sidebar-progress-fill" style="width:{{ $progressPercent }}%"></div></div>
    <div class="sidebar-progress-label">{{ $progressPercent }}% del curso completado</div>
    @foreach($course->modules as $module)
      <div class="sidebar-module">{{ $module->title }}</div>
      @foreach($module->lessons as $l)
        <a href="{{ route('lessons.show', $l) }}" class="sidebar-lesson {{ $l->id === $lesson->id ? 'current' : '' }} {{ $completedLessonIds->contains($l->id) ? 'done' : '' }}">
          <span class="sidebar-check">
            @if($completedLessonIds->contains($l->id))
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
            @else
              <svg viewBox="0 0 24 24" fill="currentColor" width="6" height="6"><circle cx="12" cy="12" r="3"/></svg>
            @endif
          </span>
          <span>{{ $l->title }}</span>
        </a>
      @endforeach
    @endforeach

    @if($course->exam)
      <div class="sidebar-module">Evaluación</div>
      <a href="{{ route('exams.show', $course) }}" class="sidebar-exam">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4M11 11l-7 7"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h11"/></svg>
        <span>{{ $course->exam->title }}</span>
      </a>

      <div class="sidebar-cert">
        @if($certificate)
          <a href="{{ route('certificates.download', $certificate) }}" class="btn-cert">Descargar certificado</a>
        @elseif($pendingCertificate)
          <div class="btn-cert btn-cert-locked" style="cursor:default;">Certificado en proceso</div>
        @elseif($progressPercent >= 100)
          @if(($course->certificate_type ?? 'gratuita') === 'opcional')
            <button type="button" class="btn-cert" onclick="abrirModalCompra()">Conseguir certificación</button>
          @else
            <a href="{{ route('exams.show', $course) }}" class="btn-cert">Conseguir certificación</a>
          @endif
        @else
          <button type="button" class="btn-cert btn-cert-locked" onclick="abrirModalBloqueo()">Conseguir certificación</button>
        @endif
      </div>
    @endif
  </div>
</div>

<div class="modal-overlay" id="modalBloqueo">
  <div class="modal-backdrop" onclick="cerrarModalesLeccion()"></div>
  <div class="modal-box" style="max-width:420px;text-align:center;">
    <button class="modal-close" onclick="cerrarModalesLeccion()">&times;</button>
    <h3>Completa el curso primero</h3>
    <p class="modal-text">Debes finalizar todas las lecciones del curso para poder acceder a tu certificación.</p>
  </div>
</div>

@if(($course->certificate_type ?? 'gratuita') === 'opcional')
<div class="modal-overlay" id="modalCompra">
  <div class="modal-backdrop" onclick="cerrarModalesLeccion()"></div>
  <div class="modal-box" style="max-width:440px;text-align:center;">
    <button class="modal-close" onclick="cerrarModalesLeccion()">&times;</button>
    <h3>Certificación opcional</h3>
    <p class="modal-sub">{{ $course->title }}</p>
    <div class="modal-price">S/ {{ number_format($course->certificate_price ?? 0, 2) }} <span>/ certificado</span></div>
    <p class="modal-text">Esta certificación tiene un costo adicional. Coordina tu pago escribiéndonos por WhatsApp y te habilitaremos el examen para obtenerla.</p>
    <a href="https://wa.me/51969754983?text={{ urlencode('Hola, deseo adquirir la certificación opcional del curso "'.$course->title.'".') }}" target="_blank" class="btn-whatsapp">
      <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      Comprar a través de WhatsApp
    </a>
    <a href="{{ route('exams.show', $course) }}" class="modal-text" style="display:block;margin-top:14px;color:var(--gold);font-weight:600;text-decoration:underline;">Ya realicé el pago, continuar con el examen</a>
  </div>
</div>
@endif
@endsection

@section('scripts')
<script>
function abrirModalCompra() { document.getElementById('modalCompra')?.classList.add('active'); }
function abrirModalBloqueo() { document.getElementById('modalBloqueo')?.classList.add('active'); }
function cerrarModalesLeccion() { document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active')); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModalesLeccion(); });
</script>
@endsection
