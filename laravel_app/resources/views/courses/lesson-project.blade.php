@extends('layouts.app')

@section('title', $lesson->title.' — '.$course->title)

@php
  $totalLessons = $course->modules->sum(fn ($m) => $m->lessons->count());
  $doneLessons = $completedLessonIds->count();
  $resources = $course->modules->flatMap->lessons->filter(fn ($l) => in_array($l->type, ['pdf', 'file'], true) && $l->file_path);
@endphp

@section('styles')
.rdp-shell { display: grid; grid-template-columns: 1fr 340px; align-items: start; background: var(--ivory); }
.rdp-panel { background: var(--white); border-left: 1px solid var(--line); position: sticky; top: 71px; max-height: calc(100vh - 71px); overflow-y: auto; display: flex; flex-direction: column; box-shadow: -8px 0 24px rgba(11,24,41,0.03); }
.rdp-panel::-webkit-scrollbar { width: 6px; }
.rdp-panel::-webkit-scrollbar-thumb { background: var(--line); border-radius: 10px; }

.rdp-panel-head { padding: 1.3rem 1.3rem 1rem; border-bottom: 1px solid var(--line); }
.rdp-sh-title { font-size: 0.9rem; font-weight: 700; color: var(--ink); line-height: 1.3; margin-bottom: 4px; }
.rdp-sh-stat { font-size: 0.72rem; color: var(--slate-light); margin-bottom: 1rem; }
.rdp-progress-label { display: flex; justify-content: space-between; font-size: 0.68rem; color: var(--slate); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; font-weight: 600; }
.rdp-progress-track { background: var(--ivory-dim); border-radius: 20px; height: 8px; overflow: hidden; margin-bottom: 6px; }
.rdp-progress-fill { background: linear-gradient(90deg, var(--gold), var(--gold-light)); height: 100%; transition: width 0.6s cubic-bezier(0.22,1,0.36,1); }
.rdp-progress-sub { font-size: 0.72rem; color: var(--slate-light); }

.rdp-tabs { display: flex; gap: 4px; background: var(--ivory-dim); border-radius: 9px; padding: 4px; margin: 1rem 1.3rem 0; }
.rdp-tab { flex: 1; text-align: center; padding: 9px 4px; border-radius: 6px; font-size: 0.74rem; font-weight: 700; color: var(--slate); cursor: pointer; border: none; background: none; transition: background 0.2s, color 0.2s; }
.rdp-tab.active { background: var(--ink); color: var(--white); }
.rdp-tabpanel { display: none; flex: 1; padding: 1rem 1.3rem 1.5rem; }
.rdp-tabpanel.active { display: block; }

.rdp-module { border: 1px solid var(--line); border-radius: 10px; margin-bottom: 8px; overflow: hidden; }
.rdp-module[open] { border-color: var(--gold); box-shadow: 0 4px 16px rgba(11,24,41,0.06); }
.rdp-module summary { list-style: none; cursor: pointer; display: flex; align-items: center; gap: 10px; padding: 12px 12px; user-select: none; background: var(--ivory); }
.rdp-module summary::-webkit-details-marker { display: none; }
.rdp-module-icon { width: 30px; height: 30px; border-radius: 7px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rdp-module-icon svg { width: 15px; height: 15px; }
.rdp-module-head-text { flex: 1; min-width: 0; }
.rdp-module-head-text .t { font-size: 0.82rem; font-weight: 700; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rdp-module-head-text .c { font-size: 0.68rem; color: var(--slate-light); }
.rdp-module-chevron { width: 14px; height: 14px; color: var(--slate-light); transition: transform 0.25s ease; flex-shrink: 0; }
.rdp-module[open] .rdp-module-chevron { transform: rotate(180deg); }
.rdp-module-body { padding: 8px; background: var(--white); }

.rdp-lesson-link { display: flex; align-items: center; gap: 10px; padding: 9px 9px; border-radius: 8px; font-size: 0.82rem; color: var(--ink); border: 1px solid transparent; margin-bottom: 3px; transition: background 0.15s, border-color 0.15s, transform 0.15s; }
.rdp-lesson-link:hover { background: var(--ivory); transform: translateX(2px); }
.rdp-lesson-link.current { background: var(--gold-pale); border-color: var(--gold); font-weight: 700; }
.rdp-lesson-link.done .rdp-lesson-title { color: var(--slate); }
.rdp-lesson-link.locked { color: var(--slate-light); cursor: not-allowed; position: relative; }
.rdp-lesson-link.locked:hover .rdp-lock-tip { opacity: 1; visibility: visible; }
.rdp-lesson-thumb { width: 46px; height: 34px; border-radius: 6px; flex-shrink: 0; background: linear-gradient(135deg, var(--ink), var(--ink-light)); display: flex; align-items: center; justify-content: center; color: var(--white); position: relative; overflow: hidden; }
.rdp-lesson-thumb svg { width: 13px; height: 13px; }
.rdp-lesson-thumb .dur { position: absolute; bottom: 2px; right: 3px; font-size: 0.55rem; background: rgba(0,0,0,0.55); padding: 1px 3px; border-radius: 3px; line-height: 1.2; }
.rdp-lesson-icon { width: 34px; height: 34px; border-radius: 6px; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center; color: var(--slate-light); background: var(--ivory-dim); }
.rdp-lesson-icon svg { width: 15px; height: 15px; }
.rdp-lesson-link.done .rdp-lesson-icon { color: #1F7A4D; background: rgba(37,150,90,0.1); }
.rdp-lesson-body { flex: 1; min-width: 0; }
.rdp-lesson-title { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block; }
.rdp-lesson-sub { font-size: 0.68rem; color: var(--slate-light); }
.rdp-lock-tip { position: absolute; right: 100%; top: 0; margin-right: 8px; background: var(--ink-90); color: var(--white); font-size: 0.7rem; padding: 8px 10px; border-radius: 6px; white-space: nowrap; opacity: 0; visibility: hidden; transition: opacity 0.2s; z-index: 5; box-shadow: 0 8px 20px rgba(0,0,0,0.3); }

.rdp-block-title { display: flex; align-items: center; gap: 8px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--slate-light); margin: 1.2rem 0 0.6rem; }
.rdp-extra-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 9px; font-size: 0.82rem; color: var(--ink); border: 1px solid var(--line); margin-bottom: 6px; font-weight: 600; }
.rdp-extra-link:hover { border-color: var(--gold); background: var(--gold-pale); }
.rdp-extra-link svg { width: 16px; height: 16px; flex-shrink: 0; color: var(--gold); }

.rdp-resource-card { display: flex; align-items: center; gap: 10px; padding: 11px 12px; border-radius: 10px; border: 1px solid var(--line); margin-bottom: 8px; transition: box-shadow 0.2s, border-color 0.2s; }
.rdp-resource-card:hover { border-color: var(--gold); box-shadow: 0 4px 16px rgba(11,24,41,0.06); }
.rdp-resource-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rdp-resource-icon svg { width: 17px; height: 17px; }
.rdp-resource-info { flex: 1; min-width: 0; }
.rdp-resource-info .t { font-size: 0.8rem; font-weight: 700; color: var(--ink); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.rdp-resource-info .m { font-size: 0.68rem; color: var(--slate-light); text-transform: uppercase; }
.rdp-resource-dl { width: 30px; height: 30px; border-radius: 7px; background: var(--ivory-dim); color: var(--ink); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rdp-resource-dl:hover { background: var(--gold); color: var(--white); }
.rdp-resource-dl svg { width: 15px; height: 15px; }
.rdp-resource-empty { font-size: 0.8rem; color: var(--slate-light); padding: 1rem 0; }

.rdp-notes-title { font-size: 0.8rem; font-weight: 700; color: var(--ink); margin-bottom: 8px; }
.rdp-notes-toolbar { display: flex; gap: 4px; margin-bottom: 6px; }
.rdp-notes-toolbar button { width: 27px; height: 27px; border-radius: 5px; background: var(--ivory-dim); border: 1px solid var(--line); color: var(--slate); font-size: 0.78rem; cursor: pointer; }
.rdp-notes-toolbar button:hover { border-color: var(--gold); color: var(--gold); }
.rdp-notes-box { min-height: 150px; background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 10px 12px; font-size: 0.83rem; color: var(--ink); line-height: 1.6; outline: none; }
.rdp-notes-box:focus { border-color: var(--gold); }
.rdp-notes-box:empty::before { content: attr(data-placeholder); color: var(--slate-light); }
.rdp-notes-status { font-size: 0.68rem; color: var(--slate-light); margin-top: 6px; }
.rdp-other-notes { margin-top: 1.3rem; }
.rdp-other-note { padding: 9px 10px; border-radius: 7px; border: 1px solid var(--line); margin-bottom: 6px; }
.rdp-other-note .t { font-size: 0.75rem; font-weight: 700; color: var(--ink); margin-bottom: 3px; }
.rdp-other-note .c { font-size: 0.74rem; color: var(--slate); overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }

.rdp-cert-box { margin: 1.3rem 1.3rem 1.5rem; padding-top: 1.2rem; border-top: 1px solid var(--line); }
.rdp-cert-status { display: flex; align-items: center; gap: 10px; padding: 13px 14px; border-radius: 10px; font-size: 0.82rem; font-weight: 700; position: relative; }
.rdp-cert-status svg { width: 17px; height: 17px; flex-shrink: 0; }
.rdp-cert-locked { background: var(--ivory-dim); color: var(--slate-light); cursor: default; }
.rdp-cert-ready { background: var(--gold-pale); color: var(--gold); cursor: pointer; }
.rdp-cert-ready:hover { background: var(--gold); color: var(--white); }
.rdp-cert-done { background: rgba(37,150,90,0.1); color: #1F7A4D; }
.rdp-tooltip { position: absolute; bottom: 100%; left: 0; right: 0; margin-bottom: 8px; background: var(--ink-90); color: var(--white); font-size: 0.72rem; font-weight: 400; padding: 10px 12px; border-radius: 6px; line-height: 1.4; opacity: 0; visibility: hidden; transition: opacity 0.2s; box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
.rdp-cert-locked:hover .rdp-tooltip { opacity: 1; visibility: visible; }

.rdp-drawer-toggle { display: none; }
.rdp-drawer-backdrop { display: none; }
@media (max-width: 960px) {
  .rdp-shell { grid-template-columns: 1fr; }
  .rdp-panel { position: fixed; top: 0; right: 0; bottom: 0; width: 90%; max-width: 380px; max-height: 100vh; z-index: 150; transform: translateX(100%); transition: transform 0.3s ease; box-shadow: -8px 0 30px rgba(0,0,0,0.2); border-left: none; }
  .rdp-panel.open { transform: translateX(0); }
  .rdp-drawer-backdrop { display: none; position: fixed; inset: 0; background: rgba(11,24,41,0.5); z-index: 140; }
  .rdp-drawer-backdrop.open { display: block; }
  .rdp-drawer-toggle { display: flex; align-items: center; gap: 8px; padding: 10px 16px; margin: 1rem 1.2rem 0 auto; background: var(--ink); color: var(--white); border: none; border-radius: 30px; font-size: 0.8rem; font-weight: 600; }
  .rdp-drawer-toggle svg { width: 16px; height: 16px; }
}

.rdp-main { padding: 2.2rem 2.6rem 3.5rem; }
.rdp-eyebrow { display: flex; align-items: center; gap: 8px; font-size: 0.72rem; color: var(--gold); font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem; }
.rdp-eyebrow svg { width: 14px; height: 14px; }
.rdp-main h1 { font-size: 1.6rem; margin-bottom: 0.5rem; }
.rdp-main-sub { font-size: 0.88rem; color: var(--slate); margin-bottom: 1.5rem; }
.rdp-video { position: relative; width: 100%; padding-top: 56.25%; background: var(--ink); border-radius: 12px; overflow: hidden; margin-bottom: 1.6rem; box-shadow: var(--shadow-m); }
.rdp-video iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: none; }
.rdp-pdf { width: 100%; height: 68vh; border: 1px solid var(--line); border-radius: 12px; margin-bottom: 1.6rem; }
.rdp-text { background: var(--white); border: 1px solid var(--line); border-radius: 12px; padding: 1.8rem; font-size: 0.92rem; line-height: 1.85; white-space: pre-line; margin-bottom: 1.6rem; box-shadow: var(--shadow-s); }
.rdp-nav { display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-top: 1.6rem; padding-top: 1.4rem; border-top: 1px solid var(--line); }
.rdp-nav-btn { padding: 12px 22px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; border: 1px solid var(--line); background: var(--white); color: var(--ink); transition: transform 0.2s, border-color 0.2s; }
.rdp-nav-btn:hover { transform: translateY(-1px); border-color: var(--gold); }
.rdp-nav-btn.primary { background: var(--gold); color: var(--white); border: none; }
.rdp-nav-btn.primary:hover { background: var(--gold-light); }
.rdp-main-fade { animation: rd-fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both; }
@keyframes rd-fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

.rdp-toast { position: fixed; top: 84px; right: 20px; z-index: 300; background: var(--white); border: 1px solid var(--line); border-radius: 10px; padding: 14px 18px; box-shadow: var(--shadow-m); max-width: 300px; opacity: 0; transform: translateY(-8px); transition: opacity 0.4s ease, transform 0.4s ease; pointer-events: none; }
.rdp-toast.show { opacity: 1; transform: translateY(0); }
.rdp-toast .t { font-size: 0.85rem; font-weight: 700; color: var(--ink); margin-bottom: 3px; }
.rdp-toast .s { font-size: 0.74rem; color: var(--slate); }

@media (max-width: 900px) { .rdp-main { padding: 1.4rem 1.2rem 2.4rem; } .rdp-pdf { height: 55vh; } .rdp-nav { flex-wrap: wrap; } .rdp-toast { right: 12px; left: 12px; max-width: none; top: 76px; } }
@endsection

@section('content')
<div class="rdp-toast" id="rdpToast">
  <div class="t">Bienvenido, {{ explode(' ', auth()->user()->name)[0] }}</div>
  <div class="s">Tu avance se guarda automáticamente en tu cuenta.</div>
</div>

<div class="rdp-drawer-backdrop" id="rdpBackdrop" onclick="rdpToggleDrawer()"></div>
<button type="button" class="rdp-drawer-toggle" id="rdpFloatingToggle" onclick="rdpToggleDrawer()">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
  Contenido del curso
</button>

<div class="rdp-shell">
  <div>
    <div class="rdp-main rdp-main-fade">
      <div class="rdp-eyebrow">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
        {{ $course->title }}
      </div>
      <h1>{{ $lesson->title }}</h1>
      @if($lesson->type === 'text')
        <div class="rdp-main-sub">Lectura &middot; {{ $lesson->duration_minutes ? $lesson->duration_minutes.' min' : 'contenido teórico' }}</div>
      @endif

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
          <button type="submit" class="rdp-nav-btn primary">{{ $isCompleted ? ($nextLesson ? 'Siguiente →' : 'Volver al curso') : '✓ Marcar como completada' }}</button>
        </form>
      </div>
    </div>
  </div>

  <aside class="rdp-panel" id="rdpSidebar">
    <div class="rdp-panel-head">
      <div class="rdp-sh-title">{{ $course->title }}</div>
      <div class="rdp-sh-stat">{{ $course->modules->count() }} módulos &middot; {{ $totalLessons }} lecciones</div>
      <div class="rdp-progress-label"><span>Tu progreso</span><span>{{ $progressPercent }}%</span></div>
      <div class="rdp-progress-track"><div class="rdp-progress-fill" style="width:{{ $progressPercent }}%"></div></div>
      <div class="rdp-progress-sub">{{ $doneLessons }} de {{ $totalLessons }} lecciones completadas</div>
    </div>

    <div class="rdp-tabs">
      <button type="button" class="rdp-tab active" data-tab="contenido" onclick="rdpTab('contenido')">Contenido</button>
      <button type="button" class="rdp-tab" data-tab="actividades" onclick="rdpTab('actividades')">Actividades</button>
      <button type="button" class="rdp-tab" data-tab="apuntes" onclick="rdpTab('apuntes')">Apuntes</button>
    </div>

    <div class="rdp-tabpanel active" data-panel="contenido">
      @foreach($course->modules as $module)
        @php $moduleHasCurrent = $module->lessons->contains('id', $lesson->id); @endphp
        <details class="rdp-module" {{ $moduleHasCurrent ? 'open' : '' }}>
          <summary>
            <span class="rdp-module-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg></span>
            <span class="rdp-module-head-text">
              <div class="t">{{ $module->title }}</div>
              <div class="c">{{ $module->lessons->count() }} {{ $module->lessons->count() === 1 ? 'contenido' : 'contenidos' }}</div>
            </span>
            <svg class="rdp-module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
          </summary>
          <div class="rdp-module-body">
            @foreach($module->lessons as $l)
              @php $lDone = $completedLessonIds->contains($l->id); $lCurrent = $l->id === $lesson->id; $lLocked = $lockedLessonIds->contains($l->id); @endphp
              @if($lLocked)
                <span class="rdp-lesson-link locked">
                  <span class="rdp-lesson-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="11" width="14" height="9" rx="1.5"/><path d="M8 11V8a4 4 0 018 0v3"/></svg></span>
                  <span class="rdp-lesson-body"><span class="rdp-lesson-title">{{ $l->title }}</span></span>
                  <span class="rdp-lock-tip">Completa la lección anterior para desbloquear</span>
                </span>
              @else
                <a href="{{ route('lessons.show', $l) }}" class="rdp-lesson-link {{ $lCurrent ? 'current' : '' }} {{ $lDone ? 'done' : '' }}">
                  @if($l->type === 'video')
                    <span class="rdp-lesson-thumb">
                      @if($lDone)
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                      @else
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                      @endif
                      @if($l->duration_minutes)<span class="dur">{{ sprintf('%02d:%02d', intdiv($l->duration_minutes,60), $l->duration_minutes%60) }}</span>@endif
                    </span>
                  @else
                    <span class="rdp-lesson-icon">
                      @if($lDone)
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                      @elseif(in_array($l->type, ['pdf','file']))
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg>
                      @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                      @endif
                    </span>
                  @endif
                  <span class="rdp-lesson-body">
                    <span class="rdp-lesson-title">{{ $l->title }}</span>
                    @if($l->duration_minutes && $l->type !== 'video')<span class="rdp-lesson-sub">{{ $l->duration_minutes }} min</span>@endif
                  </span>
                </a>
              @endif
            @endforeach
          </div>
        </details>
      @endforeach

      <div class="rdp-block-title">Recursos</div>
      @forelse($resources as $r)
        <div class="rdp-resource-card">
          <div class="rdp-resource-icon">
            @if($r->type === 'pdf')
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg>
            @else
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a5 5 0 01-7.07-7.07l9.19-9.19a3.5 3.5 0 014.95 4.95l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
            @endif
          </div>
          <div class="rdp-resource-info">
            <div class="t">{{ $r->title }}</div>
            <div class="m">{{ $r->type === 'pdf' ? 'PDF' : 'Archivo' }}</div>
          </div>
          <a href="{{ asset('storage/'.$r->file_path) }}" target="_blank" class="rdp-resource-dl" title="Descargar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4v11m0 0l4-4m-4 4l-4-4M5 19h14"/></svg>
          </a>
        </div>
      @empty
        <div class="rdp-resource-empty">Todavía no hay recursos descargables en este curso.</div>
      @endforelse
    </div>

    <div class="rdp-tabpanel" data-panel="actividades">
      @if($course->exam)
        <a href="{{ route('exams.show', $course) }}" class="rdp-extra-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4M11 11l-7 7"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h11"/></svg>
          <span>Autoevaluación</span>
        </a>
        <p style="font-size:0.8rem;color:var(--slate);margin-top:8px;">Responde las preguntas del curso y conoce tu puntaje al instante.</p>
      @else
        <div class="rdp-resource-empty">La autoevaluación de este curso está en preparación.</div>
      @endif

      <div class="rdp-block-title">Soporte</div>
      <a href="{{ route('panel.questions.index') }}" class="rdp-extra-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
        <span>Preguntas y dudas</span>
      </a>
    </div>

    <div class="rdp-tabpanel" data-panel="apuntes">
      <div class="rdp-notes-title">Apuntes — {{ $lesson->title }}</div>
      <div class="rdp-notes-toolbar">
        <button type="button" onclick="document.execCommand('bold')" title="Negrita"><strong>B</strong></button>
        <button type="button" onclick="document.execCommand('italic')" title="Cursiva"><em>I</em></button>
        <button type="button" onclick="document.execCommand('underline')" title="Subrayado"><u>U</u></button>
        <button type="button" onclick="document.execCommand('insertUnorderedList')" title="Lista">&bull;</button>
      </div>
      <div class="rdp-notes-box" id="rdpNotesBox" contenteditable="true" data-placeholder="Escribe tus apuntes sobre esta lección...">{!! $myNotes[$lesson->id] ?? '' !!}</div>
      <div class="rdp-notes-status" id="rdpNotesStatus">&nbsp;</div>

      @php $otherNotes = $myNotes->except($lesson->id)->filter(); @endphp
      @if($otherNotes->isNotEmpty())
        <div class="rdp-other-notes">
          <div class="rdp-block-title" style="margin-top:0;">Otros apuntes de este curso</div>
          @foreach($course->modules->flatMap->lessons as $l)
            @continue(!$otherNotes->has($l->id))
            <div class="rdp-other-note">
              <div class="t">{{ $l->title }}</div>
              <div class="c">{{ strip_tags($otherNotes[$l->id]) }}</div>
            </div>
          @endforeach
        </div>
      @endif
    </div>

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
</div>
@endsection

@section('scripts')
<script>
function rdpToggleDrawer() {
  document.getElementById('rdpSidebar')?.classList.toggle('open');
  document.getElementById('rdpBackdrop')?.classList.toggle('open');
}

function rdpTab(name) {
  document.querySelectorAll('.rdp-tab').forEach(t => t.classList.toggle('active', t.dataset.tab === name));
  document.querySelectorAll('.rdp-tabpanel').forEach(p => p.classList.toggle('active', p.dataset.panel === name));
}

(function rdpToast() {
  if (sessionStorage.getItem('rdp_toast_seen')) return;
  sessionStorage.setItem('rdp_toast_seen', '1');
  const t = document.getElementById('rdpToast');
  setTimeout(() => t?.classList.add('show'), 500);
  setTimeout(() => t?.classList.remove('show'), 6000);
})();

(function rdpNotes() {
  const box = document.getElementById('rdpNotesBox');
  const status = document.getElementById('rdpNotesStatus');
  if (!box) return;
  let timer;
  box.addEventListener('input', () => {
    status.textContent = 'Guardando...';
    clearTimeout(timer);
    timer = setTimeout(async () => {
      try {
        await fetch('{{ route("lessons.notes.store", $lesson) }}', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: JSON.stringify({ content: box.innerHTML })
        });
        status.textContent = 'Apuntes guardados.';
      } catch (e) {
        status.textContent = 'No se pudo guardar. Revisa tu conexión.';
      }
    }, 900);
  });
})();
</script>
@endsection
