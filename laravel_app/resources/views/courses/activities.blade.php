@extends('layouts.app')

@section('title', 'Actividades · '.$course->title)

@section('styles')
<style>
.activity-panel { max-width: 1080px; margin: 0 auto; padding: 3rem 1.2rem 5rem; }
.activity-panel-head { margin-bottom: 2rem; }
.activity-panel-head h1 { color: var(--ink); margin: .35rem 0; }
.activity-panel-head p { color: var(--slate); max-width: 680px; }
.activity-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:1.2rem; }
.activity-card { display:block; padding:1.6rem; border:1px solid var(--line); border-radius:16px; background:var(--white); text-decoration:none; color:inherit; transition:.2s ease; }
.activity-card:hover { transform:translateY(-3px); border-color:var(--gold); box-shadow:0 16px 34px rgba(11,24,41,.1); }
.activity-index { color:var(--gold); font-weight:700; letter-spacing:.12em; font-size:.75rem; }
.activity-card h2 { font-size:1.15rem; margin:.7rem 0; color:var(--ink); }
.activity-card p { color:var(--slate); font-size:.88rem; line-height:1.55; }
.activity-card .activity-link { display:inline-flex; margin-top:1rem; color:var(--gold); font-weight:700; font-size:.82rem; }
.group-summary { margin:0 0 2rem; padding:1rem 1.2rem; border-radius:12px; background:var(--gold-pale); color:var(--ink); }
@media(max-width:700px){.activity-grid{grid-template-columns:1fr}.activity-panel{padding-top:2rem}}
</style>
@endsection

@section('content')
<main class="activity-panel">
  <div class="activity-panel-head">
    <div class="course-hero-category" style="color:var(--gold)">Panel de actividades</div>
    <h1>{{ $course->title }}</h1>
    <p>Selecciona una actividad para abrir sus recursos y resolver los ejercicios dentro de la plataforma.</p>
  </div>
  @php($group = session('course_group_'.$course->id))
  @if($group)
    <div class="group-summary"><strong>Trabajo grupal · {{ $group['code'] }}</strong><br>Integrantes: {{ collect($group['members'])->pluck('name')->implode(', ') }}</div>
  @endif
  <div class="activity-grid">
    @foreach($course->modules as $module)
      @php($firstLesson = $module->lessons->first())
      @if($firstLesson)
        <a class="activity-card" href="{{ route('lessons.show', $firstLesson) }}">
          <span class="activity-index">ACTIVIDAD {{ str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          <h2>{{ preg_replace('/^Módulo\s*\d+:\s*/u', '', $module->title) }}</h2>
          <p>Accede al recurso inicial, revisa la información y resuelve las actividades interactivas.</p>
          <span class="activity-link">Abrir actividad →</span>
        </a>
      @endif
    @endforeach
  </div>
</main>
@endsection
