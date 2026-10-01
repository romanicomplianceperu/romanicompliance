@extends('layouts.app')

@section('title', 'Actividades · '.$course->title)

@section('styles')
<style>
.activities-page { background: #f5f3ee; min-height: calc(100vh - 80px); }
.activities-hero { position:relative; overflow:hidden; background:linear-gradient(120deg,#0b1829,#142941 68%,#233b52); color:#fff; padding:4rem 1.2rem 4.5rem; }
.activities-hero:after { content:""; position:absolute; width:480px; height:480px; right:-130px; top:-240px; border:1px solid rgba(184,154,86,.35); border-radius:50%; box-shadow:0 0 0 35px rgba(184,154,86,.05),0 0 0 70px rgba(184,154,86,.04); }
.activities-hero-inner { position:relative; z-index:1; max-width:1120px; margin:auto; }
.activity-kicker { display:inline-flex; align-items:center; gap:9px; color:#d9bd78; font-size:.74rem; font-weight:700; letter-spacing:.16em; text-transform:uppercase; }
.activity-kicker:before { content:""; width:26px; height:1px; background:#d9bd78; }
.activities-hero h1 { max-width:820px; color:#fff; font-size:clamp(2rem,4vw,3.15rem); line-height:1.08; margin:1rem 0; }
.activities-hero p { max-width:650px; color:#cbd3dc; font-size:1rem; line-height:1.65; }
.activity-panel { max-width:1120px; margin:-2.5rem auto 0; padding:0 1.2rem 5rem; position:relative; z-index:2; }
.activity-toolbar { display:flex; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:1.1rem; color:#637083; font-size:.8rem; }
.activity-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:1.3rem; }
.activity-card { min-height:305px; display:flex; flex-direction:column; padding:1.8rem; border:1px solid #e0ddd4; border-radius:18px; background:#fff; text-decoration:none; color:inherit; box-shadow:0 16px 36px rgba(11,24,41,.08); transition:.22s ease; }
.activity-card:hover { transform:translateY(-5px); border-color:#b89a56; box-shadow:0 22px 42px rgba(11,24,41,.14); }
.activity-card-top { display:flex; justify-content:space-between; align-items:flex-start; }
.activity-index { color:#8b7340; font-weight:800; letter-spacing:.14em; font-size:.72rem; }
.activity-status { color:#1f7a4d; background:#e8f4ed; border-radius:999px; padding:5px 9px; font-size:.68rem; font-weight:700; }
.activity-icon { width:58px; height:58px; display:grid; place-items:center; margin:1.5rem 0 1.15rem; border-radius:16px; color:#b89a56; background:#0b1829; }
.activity-icon svg { width:29px; height:29px; }
.activity-card h2 { font-family:var(--serif); font-size:1.35rem; line-height:1.25; margin:0 0 .75rem; color:#0b1829; }
.activity-card p { color:#637083; font-size:.87rem; line-height:1.55; margin:0; }
.activity-link { display:flex; justify-content:space-between; align-items:center; margin-top:auto; padding-top:1.25rem; color:#8b7340; font-weight:800; font-size:.83rem; border-top:1px solid #eeeae1; }
.group-summary { margin:1.5rem 0; padding:1rem 1.2rem; border:1px solid #dbc994; border-radius:12px; background:#fff7e1; color:#26364a; }
@media(max-width:700px){.activities-hero{padding:3rem 1rem 4rem}.activity-grid{grid-template-columns:1fr}.activity-panel{padding:0 .9rem 3rem}.activity-toolbar{align-items:flex-start;flex-direction:column}.activity-card{min-height:275px}}
</style>
@endsection

@section('content')
<div class="activities-page">
  <section class="activities-hero"><div class="activities-hero-inner"><span class="activity-kicker">Espacio de aprendizaje</span><h1>{{ $course->title }}</h1><p>Selecciona una actividad para revisar sus recursos y resolver los ejercicios dentro de la plataforma.</p></div></section>
<main class="activity-panel">
  @php($group = session('course_group_'.$course->id))
  @if($group)
    <div class="group-summary"><strong>Trabajo grupal · {{ $group['code'] }}</strong><br>Integrantes: {{ collect($group['members'])->pluck('name')->implode(', ') }}</div>
  @endif
  <div class="activity-toolbar"><span>2 actividades disponibles</span><span>Selecciona una tarjeta para comenzar</span></div><div class="activity-grid">
    @foreach($course->modules as $module)
      @php($firstLesson = $module->lessons->first())
      @if($firstLesson)
        <a class="activity-card" href="{{ route('lessons.show', $firstLesson) }}">
          <div class="activity-card-top"><span class="activity-index">ACTIVIDAD {{ str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><span class="activity-status">Disponible</span></div>
          <span class="activity-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M5 4h14v16H5zM8 8h8M8 12h8M8 16h5"/></svg></span>
          <h2>{{ preg_replace('/^Módulo\s*\d+:\s*/u', '', $module->title) }}</h2>
          <p>Accede al recurso inicial, revisa la información y resuelve las actividades interactivas.</p>
          <span class="activity-link">Abrir actividad <span>→</span></span>
        </a>
      @endif
    @endforeach
  </div>
</main></div>
@endsection
