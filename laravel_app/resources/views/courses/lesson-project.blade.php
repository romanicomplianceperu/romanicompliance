@extends('layouts.app')

@section('title', $lesson->title.' — '.$course->title)

@section('styles')
.rdp-shell { display: grid; grid-template-columns: 300px 1fr; min-height: calc(100vh - 70px); }
.rdp-sidebar { background: var(--ink); color: var(--white); padding: 1.6rem 1.2rem; overflow-y: auto; position: sticky; top: 70px; height: calc(100vh - 70px); }
.rdp-sidebar-head { margin-bottom: 1.2rem; }
.rdp-sidebar-head .k { font-size: 0.65rem; color: var(--gold-light); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px; }
.rdp-sidebar-head h4 { font-size: 0.95rem; color: var(--white); font-weight: 700; line-height: 1.3; }
.rdp-progress-track { background: rgba(255,255,255,0.1); border-radius: 20px; height: 8px; overflow: hidden; margin: 12px 0 6px; }
.rdp-progress-fill { background: linear-gradient(90deg, var(--gold), var(--gold-light)); height: 100%; transition: width 0.5s cubic-bezier(0.22,1,0.36,1); }
.rdp-progress-label { font-size: 0.72rem; color: rgba(255,255,255,0.5); margin-bottom: 1.4rem; }
.rdp-module-title { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: rgba(255,255,255,0.35); margin: 1.1rem 0 0.5rem; }
.rdp-lesson-link { display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 6px; font-size: 0.82rem; color: rgba(255,255,255,0.65); transition: background 0.2s; }
.rdp-lesson-link:hover { background: rgba(255,255,255,0.05); }
.rdp-lesson-link.current { background: rgba(184,154,86,0.16); color: var(--gold-light); font-weight: 600; }
.rdp-lesson-link.done { color: #7FD1A0; }
.rdp-check { width: 16px; flex-shrink: 0; display: inline-flex; }
.rdp-check svg { width: 13px; height: 13px; }
.rdp-extra-link { display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 6px; font-size: 0.82rem; color: rgba(255,255,255,0.55); border: 1px dashed rgba(255,255,255,0.15); margin-top: 4px; }
.rdp-extra-link svg { width: 15px; height: 15px; flex-shrink: 0; }

.rdp-cert-box { margin-top: 1.6rem; padding-top: 1.4rem; border-top: 1px solid rgba(255,255,255,0.08); }
.rdp-cert-status { display: flex; align-items: center; gap: 10px; padding: 12px 14px; border-radius: 8px; font-size: 0.82rem; font-weight: 600; position: relative; cursor: default; }
.rdp-cert-locked { background: rgba(255,255,255,0.04); color: rgba(255,255,255,0.4); }
.rdp-cert-ready { background: rgba(184,154,86,0.15); color: var(--gold-light); cursor: pointer; }
.rdp-cert-done { background: rgba(37,150,90,0.15); color: #7FD1A0; }
.rdp-tooltip { position: absolute; bottom: 100%; left: 0; right: 0; margin-bottom: 8px; background: var(--ink-90); color: var(--white); font-size: 0.72rem; font-weight: 400; padding: 10px 12px; border-radius: 6px; line-height: 1.4; opacity: 0; visibility: hidden; transition: opacity 0.2s; box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
.rdp-cert-locked:hover .rdp-tooltip { opacity: 1; visibility: visible; }

.rdp-drawer-toggle { display: none; }
@media (max-width: 900px) {
  .rdp-shell { grid-template-columns: 1fr; }
  .rdp-sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: 82%; max-width: 320px; height: 100vh; z-index: 150; transform: translateX(-100%); transition: transform 0.3s ease; }
  .rdp-sidebar.open { transform: translateX(0); }
  .rdp-drawer-backdrop { display: none; position: fixed; inset: 0; background: rgba(11,24,41,0.5); z-index: 140; }
  .rdp-drawer-backdrop.open { display: block; }
  .rdp-drawer-toggle { display: flex; align-items: center; gap: 8px; padding: 10px 16px; margin: 1rem auto 0; background: var(--ink); color: var(--white); border: none; border-radius: 30px; font-size: 0.8rem; font-weight: 600; }
}

.rdp-main { padding: 2.2rem 2.4rem 3rem; }
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
    <div class="rdp-sidebar-head">
      <div class="k">{{ $course->project->company->name ?? 'Capacitación' }}</div>
      <h4>{{ $course->title }}</h4>
    </div>
    <div class="rdp-progress-track"><div class="rdp-progress-fill" style="width:{{ $progressPercent }}%"></div></div>
    <div class="rdp-progress-label">{{ $progressPercent }}% del curso completado</div>

    @foreach($course->modules as $module)
      <div class="rdp-module-title">{{ $module->title }}</div>
      @foreach($module->lessons as $l)
        <a href="{{ route('lessons.show', $l) }}" class="rdp-lesson-link {{ $l->id === $lesson->id ? 'current' : '' }} {{ $completedLessonIds->contains($l->id) ? 'done' : '' }}">
          <span class="rdp-check">
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
      <div class="rdp-module-title">Autoevaluación</div>
      <a href="{{ route('exams.show', $course) }}" class="rdp-extra-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4M11 11l-7 7"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h11"/></svg>
        <span>{{ $course->exam->title }}</span>
      </a>
    @endif

    <div class="rdp-module-title">Más</div>
    <a href="{{ route('courses.show', $course) }}#material-extra" class="rdp-extra-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
      <span>📚 Material extra</span>
    </a>
    <a href="{{ route('panel.questions.index') }}" class="rdp-extra-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
      <span>💬 Preguntas y dudas</span>
    </a>

    <div class="rdp-cert-box">
      @if($certificate)
        <a href="{{ route('certificates.download', $certificate) }}" class="rdp-cert-status rdp-cert-done">✅ Certificado disponible</a>
      @elseif($pendingCertificate)
        <div class="rdp-cert-status rdp-cert-locked">⏳ Certificado en proceso</div>
      @elseif($progressPercent >= 100)
        <a href="{{ route('exams.show', $course) }}" class="rdp-cert-status rdp-cert-ready">🔓 Certificado disponible</a>
      @else
        <div class="rdp-cert-status rdp-cert-locked">
          🔒 Certificado bloqueado
          <div class="rdp-tooltip">Completa la revisión de todo el material para desbloquear tu certificado.</div>
        </div>
      @endif
    </div>
  </aside>

  <div>
    <button type="button" class="rdp-drawer-toggle" onclick="rdpToggleDrawer()" style="margin-left:1.2rem;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
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
