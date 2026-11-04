@extends('layouts.site')

@section('title', 'Equipo · Romani Compliance')
@section('description', 'El equipo de Romani Compliance: compliance, prevención LA/FT y defensa penal económica.')

@section('styles')
.pg-hero { padding: clamp(56px, 8vw, 104px) 0 clamp(36px, 5vw, 56px); }
.pg-hero .lead { margin-top: 20px; }
.lead-m { display: grid; grid-template-columns: 0.85fr 1.15fr; gap: clamp(36px, 6vw, 96px); align-items: start; }
.lead-m .ph { border-radius: 28px; overflow: hidden; aspect-ratio: 4 / 5; position: sticky; top: 110px; background: radial-gradient(circle at 50% 38%, #2A57D6 0%, #10264D 55%, var(--ink) 100%); }
.lead-m .ph img { position: absolute; left: 50%; bottom: 0; transform: translateX(-50%); height: 94%; width: auto; max-width: none; }
.lead-m .role { color: var(--blue); font-weight: 700; margin: 8px 0 22px; }
.lead-m p.bio { color: var(--muted); font-size: 1.08rem; margin-bottom: 16px; }
.lead-m .acts { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 26px; }
@media (max-width: 860px) { .lead-m { grid-template-columns: 1fr; } .lead-m .ph { position: relative; top: 0; max-width: 380px; width: 100%; } }
.team { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
.mem { border: 1px solid var(--line); border-radius: var(--r); overflow: hidden; background: #fff; display: flex; flex-direction: column; transition: transform .35s var(--ease), border-color .3s; }
.mem:hover { transform: translateY(-4px); border-color: var(--blue); }
.mem .ph { aspect-ratio: 1 / 1; background: var(--soft); }
.mem .ph img { width: 100%; height: 100%; object-fit: cover; }
.mem .bd { padding: 22px; display: flex; flex-direction: column; gap: 6px; flex: 1; }
.mem h3 { font-size: 1.15rem; font-weight: 800; }
.mem .r { color: var(--blue); font-weight: 700; font-size: .92rem; }
.mem p { color: var(--muted); font-size: .95rem; }
.mem .ln { margin-top: auto; padding-top: 12px; display: flex; gap: 14px; flex-wrap: wrap; font-size: .9rem; }
.vals { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.vals .card { padding: 32px; }
.vals .no { width: 46px; height: 46px; border-radius: 14px; background: rgba(127,163,255,.14); color: var(--blue-l); display: grid; place-items: center; }
.vals .no .ic { width: 24px; height: 24px; }
.vals h3 { font-size: 1.35rem; font-weight: 800; margin: 14px 0 10px; letter-spacing: -0.02em; }
.vals p { color: rgba(255,255,255,.68); }
.vals .card { background: rgba(255,255,255,.04); border-color: rgba(255,255,255,.1); }
@media (max-width: 860px) { .vals { grid-template-columns: 1fr; } }
@endsection

@section('content')
<section class="pg-hero">
  <div class="wrap">
    <div class="kicker rv">Equipo</div>
    <h1 class="display rv" style="font-size:clamp(2.4rem,5.4vw,4.6rem)">Las personas detrás de cada caso.</h1>
    <p class="lead rv">Abogados y especialistas en compliance, prevención de lavado de activos y derecho penal económico, con un mismo estándar de rigor y reserva.</p>
  </div>
</section>

@if($director)
<section class="sec" style="padding-top:0">
  <div class="wrap lead-m">
    <div class="ph rv"><img src="{{ asset('images/denis-romani.webp') }}" alt="{{ $director->name }}"></div>
    <div>
      <div class="kicker rv">Dirección</div>
      <h2 class="h2 rv">{{ $director->name }}</h2>
      <div class="role rv">{{ $director->title }}</div>
      @foreach(array_filter(explode("\n\n", $director->bio ?? '')) as $paragraph)<p class="bio rv">{{ $paragraph }}</p>@endforeach
      @if($director->credentialsList())<div class="chips rv" style="margin-top:10px">@foreach($director->credentialsList() as $cred)<span class="chip">{{ $cred }}</span>@endforeach</div>@endif
      <div class="acts rv">
        <a href="mailto:{{ $director->email }}" class="b b-dark">Escribir a {{ \Illuminate\Support\Str::of($director->name)->explode(' ')->first() }}</a>
        @if($director->linkedin_url)<a href="{{ $director->linkedin_url }}" target="_blank" rel="noopener" class="b b-ghost">LinkedIn</a>@endif
        <a href="{{ route('blog.author', $director) }}" class="b b-ghost">Publicaciones</a>
      </div>
    </div>
  </div>
</section>
@endif

@if($associates->isNotEmpty())
<section class="sec sec-soft">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Equipo legal</div><h2 class="h2 rv">Quienes trabajan cada expediente.</h2></div></div>
    <div class="team m-scroll">
      @foreach($associates as $member)
        <div class="mem rv" style="--d:{{ ($loop->index % 4) * 0.05 }}s">
          <div class="ph"><img src="{{ $member->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $member->name }}" loading="lazy"></div>
          <div class="bd">
            <h3><a href="{{ route('blog.author', $member) }}">{{ $member->name }}</a></h3>
            <div class="r">{{ $member->title }}</div>
            <p>{{ $member->bio }}</p>
            <div class="ln"><a href="mailto:{{ $member->email }}" class="lnk">Correo</a>@if($member->linkedin_url)<a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener" class="lnk">LinkedIn</a>@endif</div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="sec sec-dark on-dark">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Cómo trabajamos</div><h2 class="h2 rv">Tres compromisos con cada cliente.</h2></div></div>
    <div class="vals m-scroll">
      <div class="card rv"><span class="no">@include('site.partials.icon', ['name' => 'scale'])</span><h3>Rigor técnico</h3><p>Cada análisis se apoya en la normativa vigente, la jurisprudencia y los estándares internacionales aplicables.</p></div>
      <div class="card rv" style="--d:.06s"><span class="no">@include('site.partials.icon', ['name' => 'shield'])</span><h3>Reserva</h3><p>La información que nos confía se maneja con la más estricta confidencialidad, de principio a fin.</p></div>
      <div class="card rv" style="--d:.12s"><span class="no">@include('site.partials.icon', ['name' => 'check'])</span><h3>Claridad</h3><p>Le explicamos dónde está el riesgo y qué recomendamos, sin rodeos y por escrito.</p></div>
    </div>
    <div style="margin-top:48px" class="rv"><a href="{{ route('home') }}#contacto" class="b b-light">Conversar con el equipo @include('site.partials.icon', ['name' => 'arrow'])</a></div>
  </div>
</section>
@endsection
