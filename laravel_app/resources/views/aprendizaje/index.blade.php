@extends('layouts.site')

@section('title', 'Aprendizaje · Romani Compliance')
@section('description', 'Elija entre nuestros programas de capacitación o el espacio académico universitario de Romani Compliance.')

@section('styles')
.ap-hero { padding: clamp(48px, 7vw, 96px) 0 clamp(24px, 3vw, 36px); }
.ap-hero .lead { margin-top: 14px; }
.ap-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
@media (max-width: 760px) { .ap-grid { grid-template-columns: 1fr; } }
.ap-card { border: 1px solid var(--line); border-radius: 26px; background: #fff; padding: clamp(24px, 3.5vw, 36px); display: flex; flex-direction: column; gap: 14px; transition: transform .35s var(--ease), border-color .3s, box-shadow .3s; }
.ap-card:hover { transform: translateY(-4px); border-color: var(--blue); box-shadow: 0 24px 50px -32px rgba(10,23,48,.5); }
.ap-card.dark { background: var(--ink); color: #fff; border-color: transparent; }
.ap-card.dark p { color: rgba(255,255,255,.7); }
.ap-card.dark .icon-tile { background: rgba(127,163,255,.16); color: var(--blue-l); }
.ap-card h2 { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; }
.ap-card p { color: var(--muted); }
.ap-card .lnk { margin-top: auto; padding-top: 6px; }
.ap-card.dark .lnk { color: var(--blue-l); }
@endsection

@section('content')
<section class="ap-hero">
  <div class="wrap">
    <div class="kicker rv">Aprendizaje</div>
    <h1 class="display rv">¿Qué está buscando?</h1>
    <p class="lead rv">Seleccione una opción para continuar.</p>
  </div>
</section>
<section class="sec" style="padding-top:0">
  <div class="wrap ap-grid">
    <a href="{{ route('aprendizaje.capacitaciones') }}" class="ap-card dark rv">
      <span class="icon-tile">@include('site.partials.icon', ['name' => 'cap'])</span>
      <h2>Capacitaciones</h2>
      <p>Programas de formación y certificación en compliance, prevención LA/FT y gestión de riesgos.</p>
      <span class="lnk">Ver capacitaciones @include('site.partials.icon', ['name' => 'arrow'])</span>
    </a>
    <a href="{{ route('academico.index') }}" class="ap-card rv" style="--d:.06s">
      <span class="icon-tile">@include('site.partials.icon', ['name' => 'doc'])</span>
      <h2>Académico Universitario</h2>
      <p>Espacio para alumnos y visitantes: cursos, actividades y participaciones universitarias.</p>
      <span class="lnk">Entrar al espacio académico @include('site.partials.icon', ['name' => 'arrow'])</span>
    </a>
  </div>
</section>
@endsection
