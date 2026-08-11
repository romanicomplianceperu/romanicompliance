@extends('layouts.app')

@section('title', $lesson->title.' — '.$course->title)

@php
  $totalLessons = $course->modules->sum(fn ($m) => $m->lessons->count());
  $doneLessons = $completedLessonIds->count();
@endphp

@section('styles')
.rdp-shell { display: grid; grid-template-columns: 310px 1fr; align-items: start; }
.rdp-sidebar { background: var(--ink); color: var(--white); padding: 1.5rem 1.1rem 1.5rem; position: sticky; top: 71px; max-height: calc(100vh - 71px); overflow-y: auto; }
.rdp-sidebar::-webkit-scrollbar { width: 6px; }
.rdp-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 10px; }

.rdp-sh-title { font-size: 0.92rem; font-weight: 700; color: var(--white); line-height: 1.3; margin-bottom: 4px; }
.rdp-sh-stat { font-size: 0.72rem; color: rgba(255,255,255,0.4); margin-bottom: 1.2rem; }

.rdp-progress-label { display: flex; justify-content: space-between; font-size: 0.68rem; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
.rdp-progress-track { background: rgba(255,255,255,0.08); border-radius: 20px; height: 8px; overflow: hidden; margin-bottom: 6px; }
.rdp-progress-fill { background: linear-gradient(90deg, var(--gold), var(--gold-light)); height: 100%; transition: width 0.6s cubic-bezier(0.22,1,0.36,1); }
.rdp-progress-sub { font-size: 0.72rem; color: rgba(255,255,255,0.4); margin-bottom: 1.6rem; }

.rdp-module { border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; margin-bottom: 8px; overflow: hidden; }
.rdp-module[open] { border-color: rgba(184,154,86,0.3); background: rgba(255,255,255,0.02); }
.rdp-module summary { list-style: none; cursor: pointer; display: flex; align-items: center; gap: 10px; padding: 12px 12px; user-select: none; }
.rdp-module summary::-webkit-details-marker { display: none; }
.rdp-module-icon { width: 30px; height: 30px; border-radius: 7px; background: rgba(184,154,86,0.12); color: var(--gold-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rdp-module-icon svg { width: 15px; height: 15px; }
.rdp-module-head-text { flex: 1; min-width: 0; }
.rdp-module-head-text .t { font-size: 0.82rem; font-weight: 600; color: var(--white); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rdp-module-head-text .c { font-size: 0.68rem; color: rgba(255,255,255,0.4); }
.rdp-module-chevron { width: 14px; height: 14px; color: rgba(255,255,255,0.35); transition: transform 0.25s ease; flex-shrink: 0; }
.rdp-module[open] .rdp-module-chevron { transform: rotate(180deg); }
.rdp-module-body { padding: 2px 10px 10px; }

.rdp-lesson-link { display: flex; align-items: center; gap: 9px; padding: 8px 10px; border-radius: 7px; font-size: 0.8rem; color: rgba(255,255,255,0.6); border: 1px solid transparent; margin-bottom: 2px; }
.rdp-lesson-link:hover { background: rgba(255,255,255,0.04); }
.rdp-lesson-link.current { background: rgba(184,154,86,0.14); border-color: rgba(184,154,86,0.35); color: var(--white); font-weight: 600; }
.rdp-lesson-link.done { color: rgba(255,255,255,0.75); }
.rdp-lesson-icon { width: 17px; height: 17px; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.3); }
.rdp-lesson-icon svg { width: 100%; height: 100%; }
.rdp-lesson-link.done .rdp-lesson-icon { color: #6FCF97; }
.rdp-lesson-link.current .rdp-lesson-icon { color: var(--gold-light); }
.rdp-lesson-title { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

.rdp-block-title { display: flex; align-items: center; gap: 8px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: rgba(255,255,255,0.35); margin: 1.3rem 0 0.6rem; }
.rdp-extra-link { display: flex; align-items: center; gap: 10px; padding: 9px 11px; border-radius: 8px; font-size: 0.8rem; color: rgba(255,255,255,0.6); border: 1px solid rgba(255,255,255,0.08); margin-bottom: 6px; }
.rdp-extra-link:hover { background: rgba(255,255,255,0.04); }
.rdp-extra-link svg { width: 16px; height: 16px; flex-shrink: 0; }

.rdp-cert-box { margin-top: 1.4rem; padding-top: 1.3rem; border-top: 1px solid rgba(255,255,255,0.08); }
.rdp-cert-status { display: flex; align-items: center; gap: 10px; padding: 13px 14px; border-radius: 9px; font-size: 0.82rem; font-weight: 600; position: relative; }
.rdp-cert-status svg { width: 17px; height: 17px; flex-shrink: 0; }
.rdp-cert-locked { background: rgba(255,255,255,0.04); color: rgba(255,255,255,0.4); cursor: default; }
.rdp-cert-ready { background: rgba(184,154,86,0.15); color: var(--gold-light); cursor: pointer; }
.rdp-cert-done { background: rgba(111,207,151,0.12); color: #6FCF97; }
.rdp-tooltip { position: absolute; bottom: 100%; left: 0; right: 0; margin-bottom: 8px; background: var(--ink-90); color: var(--white); font-size: 0.72rem; font-weight: 400; padding: 10px 12px; border-radius: 6px; line-height: 1.4; opacity: 0; visibility: hidden; transition: opacity 0.2s; box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
.rdp-cert-locked:hover .rdp-tooltip { opacity: 1; visibility: visible; }

.rdp-drawer-toggle { display: none; }
.rdp-drawer-backdrop { display: none; }
@media (max-width: 900px) {
  .rdp-shell { grid-template-columns: 1fr; }
  .rdp-sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: 86%; max-width: 340px; max-height: 100vh; z-index: 150; transform: translateX(-100%); transition: transform 0.3s ease; box-shadow: 8px 0 30px rgba(0,0,0,0.3); }
  .rdp-sidebar.open { transform: translateX(0); }
  .rdp-drawer-backdrop { display: none; position: fixed; inset: 0; background: rgba(11,24,41,0.5); z-index: 140; }
  .rdp-drawer-backdrop.open { display: block; }
  .rdp-drawer-toggle { display: flex; align-items: center; gap: 8px; padding: 10px 16px; margin: 1rem 0 0 1.2rem; background: var(--ink); color: var(--white); border: none; border-radius: 30px; font-size: 0.8rem; font-weight: 600; }
  .rdp-drawer-toggle svg { width: 16px; height: 16px; }
}

.rdp-main { padding: 2.2rem 2.4rem 3.5rem; }
.rdp-eyebrow { font-size: 0.72rem; color: var(--gold); font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem; }
.rdp-main h1 { font-size: 1.5rem; margin-bottom: 1.4rem; }
.rdp-video { position: relative; width: 100%; padding-top: 56.25%; background: var(--ink); border-radius: 10px; overflow: hidden; margin-bottom: 1.6rem; }
.rdp-video iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: none; }
.rdp-pdf { width: 100%; height: 68vh; border: 1px solid var(--line); border-radius: 10px; margin-bottom: 1.6rem; }
.rdp-text { background: var(--white); border: 1px solid var(--line); border-radius: 10px; padding: 1.8rem; font-size: 0.92rem; line-height: 1.85; white-space: pre-line; margin-bottom: 1.6rem; box-shadow: var(--shadow-s); }
.rdp-nav { display: flex; justify-content: space-between; gap: 1rem; margin-top: 1.6rem; }
.rdp-nav-btn { padding: 12px 22px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; border: 1px solid var(--line); background: var(--white); color: var(--ink); transition: transform 0.2s, border-color 0.2s; }
.rdp-nav-btn:hover { transform: translateY(-1px); border-color: var(--gold); }
.rdp-nav-btn.primary { background: var(--gold); color: var(--white); border: none; }
.rdp-main-fade { animation: rd-fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both; }
@keyframes rd-fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

@media (max-width: 900px) { .rdp-main { padding: 1.4rem 1.2rem 2.4rem; } .rdp-pdf { height: 55vh; } .rdp-nav { flex-wrap: wrap; } }
@endsection

@section('content')
<div class="rdp-drawer-backdrop" id="rdpBackdrop" onclick="rdpToggleDrawer()"></div>
<div class="rdp-shell">
  <aside class="rdp-sidebar" id="rdpSidebar">
    <div class="rdp-sh-title">{{ $course->title }}</div>
    <div class="rdp-sh-stat">{{ $course->modules->count() }} módulos &middot; {{ $totalLessons }} lecciones</div>

    <div class="rdp-progress-label"><span>Tu progreso</span><span>{{ $progressPercent }}%</span></div>
    <div class="rdp-progress-track"><div class="rdp-progress-fill" style="width:{{ $progressPercent }}%"></div></div>
    <div class="rdp-progress-sub">{{ $doneLessons }} de {{ $totalLessons }} lecciones completadas</div>

    @foreach($course->modules as $module)
      @php $moduleHasCurrent = $module->lessons->contains('id', $lesson->id); @endphp
      <details class="rdp-module" {{ $moduleHasCurrent ? 'open' : '' }}>
        <summary>
          <span class="rdp-module-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg></span>
          <span class="rdp-module-head-text">
            <div class="t">{{ $module->title }}</div>
            <div class="c">{{ $module->lessons->count() }} {{ $module->lessons->count() === 1 ? 'lección' : 'lecciones' }}</div>
          </span>
          <svg class="rdp-module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
        </summary>
        <div class="rdp-module-body">
          @foreach($module->lessons as $l)
            @php $lDone = $completedLessonIds->contains($l->id); $lCurrent = $l->id === $lesson->id; @endphp
            <a href="{{ route('lessons.show', $l) }}" class="rdp-lesson-link {{ $lCurrent ? 'current' : '' }} {{ $lDone ? 'done' : '' }}">
              <span class="rdp-lesson-icon">
                @if($lDone)
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                @else
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="8"/></svg>
                @endif
              </span>
              <span class="rdp-lesson-title">{{ $l->title }}</span>
            </a>
          @endforeach
        </div>
      </details>
    @endforeach

    @if($course->exam)
      <div class="rdp-block-title">Evaluación</div>
      <a href="{{ route('exams.show', $course) }}" class="rdp-extra-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4M11 11l-7 7"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h11"/></svg>
        <span>Autoevaluación</span>
      </a>
    @endif

    <div class="rdp-block-title">Complementos</div>
    <a href="{{ route('courses.show', $course) }}#material-extra" class="rdp-extra-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg>
      <span>Material extra</span>
    </a>
    <a href="{{ route('panel.questions.index') }}" class="rdp-extra-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
      <span>Preguntas y dudas</span>
    </a>

    <div class="rdp-cert-box">
      @if($certificate)
        <a href="{{ route('certificates.download', $certificate) }}" class="rdp-cert-status rdp-cert-done">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M8.5 12.5L7 21l5-2.5L17 21l-1.5-8.5"/></svg>
          Certificado disponible
        </a>
      @elseif($pendingCertificate)
        <div class="rdp-cert-status rdp-cert-locked">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
          Certificado en proceso
        </div>
      @elseif($progressPercent >= 100)
        <a href="{{ route('exams.show', $course) }}" class="rdp-cert-status rdp-cert-ready">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="11" width="14" height="9" rx="1.5"/><path d="M8 11V8a4 4 0 017.6-1.8"/></svg>
          Certificado disponible
        </a>
      @else
        <div class="rdp-cert-status rdp-cert-locked">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="11" width="14" height="9" rx="1.5"/><path d="M8 11V8a4 4 0 018 0v3"/></svg>
          Certificado bloqueado
          <div class="rdp-tooltip">Completa la revisión de todo el material para desbloquear tu certificado.</div>
        </div>
      @endif
    </div>
  </aside>

  <div>
    <button type="button" class="rdp-drawer-toggle" onclick="rdpToggleDrawer()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
      Contenido del curso
    </button>

    <div class="rdp-main rdp-main-fade">
      <div class="rdp-eyebrow">{{ $course->title }}</div>
      <h1>{{ $lesson->title }}</h1>

      @if($lesson->type === 'video' && $lesson->embedUrl())
        <div class="rdp-video"><iframe src="{{ $lesson->embedUrl() }}" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe></div>
      @elseif($lesson->type === 'pdf' && $lesson->file_path)
        <iframe src="{{ asset('storage/'.$lesson->file_path) }}" class="rdp-pdf"></iframe>
      @elseif($lesson->type === 'file' && $lesson->file_path)
        <a href="{{ asset('storage/'.$lesson->file_path) }}" target="_blank" class="rdp-nav-btn primary" style="display:inline-flex;margin-bottom:1.6rem;">Descargar archivo</a>
      @elseif($lesson->type === 'text')
        <div class="rdp-text">{{ $lesson->content }}</div>
      @endif

      <div class="rdp-nav">
        <div>
          @if($previousLesson)
            <a href="{{ route('lessons.show', $previousLesson) }}" class="rdp-nav-btn">← Anterior</a>
          @endif
        </div>
        <form action="{{ route('lessons.complete', $lesson) }}" method="POST">
          @csrf
          <button type="submit" class="rdp-nav-btn primary">{{ $isCompleted ? ($nextLesson ? 'Siguiente →' : 'Volver al curso') : 'Marcar como completada' }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function rdpToggleDrawer() {
  document.getElementById('rdpSidebar')?.classList.toggle('open');
  document.getElementById('rdpBackdrop')?.classList.toggle('open');
}
</script>
@endsection
