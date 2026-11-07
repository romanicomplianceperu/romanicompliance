@extends('layouts.site')

@section('title', 'Equipo · Romani Compliance')
@section('description', 'El equipo de Romani Compliance: compliance, prevención LA/FT y defensa penal económica.')

@section('styles')
.pg-hero { padding: clamp(56px, 8vw, 104px) 0 clamp(36px, 5vw, 56px); }
.pg-hero .lead { margin-top: 20px; }
.lead-m { display: grid; grid-template-columns: auto 1fr; gap: clamp(36px, 6vw, 96px); align-items: center; }
.lead-m .ph { width: clamp(240px, 30vw, 380px); aspect-ratio: 1; border-radius: 50%; overflow: hidden; background: radial-gradient(circle at 50% 35%, #2F5FE6, #10264D 72%); border: 8px solid #fff; box-shadow: 0 0 0 1px var(--line), 0 30px 60px -30px rgba(10,23,48,.55); }
.lead-m .ph img { width: 100%; height: 100%; object-fit: cover; object-position: 50% 12%; }
.lead-m .role { color: var(--blue); font-weight: 700; margin: 8px 0 22px; }
.lead-m p.bio { color: var(--muted); font-size: 1.08rem; margin-bottom: 16px; }
.lead-m .acts { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 26px; }
@media (max-width: 860px) { .lead-m { grid-template-columns: 1fr; gap: 28px; justify-items: center; text-align: center; } .lead-m .ph { width: min(260px, 70vw); } .lead-m .acts, .lead-m .chips { justify-content: center; } .lead-m p.bio { text-align: left; } }
.team { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; align-items: start; }
@media (max-width: 980px) { .team { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 640px) { .team { grid-template-columns: 1fr; gap: 12px; } }
.mem { border: 1px solid var(--line); border-radius: 22px; background: #fff; padding: 22px; display: flex; flex-direction: column; gap: 14px; transition: transform .35s var(--ease), border-color .3s, box-shadow .3s; }
.mem:hover { transform: translateY(-3px); border-color: var(--blue); box-shadow: 0 18px 40px -28px rgba(10,23,48,.45); }
.mem .top { display: flex; gap: 14px; align-items: center; }
.mem .av { width: 72px; height: 72px; border-radius: 50%; overflow: hidden; flex-shrink: 0; background: radial-gradient(circle at 50% 35%, #2F5FE6, #10264D 72%); color: #fff; display: grid; place-items: center; font-weight: 800; font-size: 1.4rem; letter-spacing: -0.02em; border: 3px solid #fff; box-shadow: 0 8px 20px -10px rgba(10,23,48,.5); }
.mem .av { position: relative; }
.mem .av img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: 50% 20%; }
.mem h3 { font-size: 1.1rem; font-weight: 800; line-height: 1.25; letter-spacing: -0.01em; }
.mem h3 a:hover { color: var(--blue); }
.mem .r { color: var(--blue); font-weight: 700; font-size: .86rem; line-height: 1.35; margin-top: 3px; }
.mem .bio { color: var(--muted); font-size: .95rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; }
.mem.open .bio { -webkit-line-clamp: unset; display: block; }
.mem .more { align-self: flex-start; background: none; border: 0; padding: 0; color: var(--blue); font: inherit; font-weight: 700; font-size: .88rem; cursor: pointer; }
.mem .ln { display: flex; gap: 8px; flex-wrap: wrap; padding-top: 14px; border-top: 1px solid var(--line); margin-top: auto; }
.mem .ln a { display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; border-radius: 999px; background: var(--soft); font-size: .85rem; font-weight: 700; color: var(--ink); transition: background .2s, color .2s; }
.mem .ln a:hover { background: var(--blue); color: #fff; }
.mem .ln svg { width: 15px; height: 15px; }
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
    <h1 class="display rv">Las personas detrás de cada caso.</h1>
    <p class="lead rv">Abogados y especialistas en compliance, prevención de lavado de activos y derecho penal económico, con un mismo estándar de rigor y reserva.</p>
  </div>
</section>

@if($director)
<section class="sec" style="padding-top:0">
  <div class="wrap lead-m">
    <div class="ph rv"><img src="{{ asset('images/denis-romani-avatar.webp') }}?v=2" alt="{{ $director->name }}"></div>
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
    <div class="sec-head"><div><div class="kicker rv">Equipo legal</div><h2 class="h2 rv">Nuestro equipo.</h2></div></div>
    <div class="team">
      @foreach($associates as $member)
        @php
          $photo = $member->displayPhoto();
          $initials = collect(preg_split('/\s+/', trim($member->name)))->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->join('');
        @endphp
        <article class="mem rv" style="--d:{{ ($loop->index % 3) * 0.05 }}s">
          <div class="top">
            <div class="av">@if($photo)<img src="{{ $photo }}" alt="{{ $member->name }}" loading="lazy" onerror="this.remove()">@endif<span>{{ $initials }}</span></div>
            <div><h3><a href="{{ route('blog.author', $member) }}">{{ $member->name }}</a></h3><div class="r">{{ $member->title }}</div></div>
          </div>
          @if($member->bio)
            <p class="bio">{{ $member->bio }}</p>
            @if(mb_strlen($member->bio) > 190)<button type="button" class="more" onclick="const m=this.closest('.mem');m.classList.toggle('open');this.textContent=m.classList.contains('open')?'Ver menos':'Ver más'">Ver más</button>@endif
          @endif
          <div class="ln">
            <a href="mailto:{{ $member->email }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>Correo</a>
            @if($member->linkedin_url)<a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.34V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 110-4.13 2.06 2.06 0 010 4.13zM7.12 20.45H3.56V9h3.56v11.45z"/></svg>LinkedIn</a>@endif
            <a href="{{ route('blog.author', $member) }}">Publicaciones</a>
          </div>
        </article>
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
