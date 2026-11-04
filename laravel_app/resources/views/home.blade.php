@extends('layouts.site')

@php $services = \App\Support\ServiceCatalog::all(); @endphp

@section('styles')
/* Portada azul con la foto del director e insignias animadas */
.hero { position: relative; overflow: hidden; background: var(--ink); color: #fff; padding: clamp(48px, 7vw, 96px) 0 0; }
.hero::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,.06) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.06) 1px, transparent 1px); background-size: 64px 64px; mask-image: radial-gradient(ellipse 70% 80% at 72% 40%, #000 5%, transparent 72%); -webkit-mask-image: radial-gradient(ellipse 70% 80% at 72% 40%, #000 5%, transparent 72%); animation: gridMove 22s linear infinite; }
@keyframes gridMove { to { background-position: 64px 64px, 64px 64px; } }
.hero .glow { position: absolute; border-radius: 50%; pointer-events: none; }
.hero .g1 { width: 680px; height: 680px; right: -140px; top: -120px; background: radial-gradient(circle, rgba(31,79,216,.55), transparent 62%); animation: drift 14s ease-in-out infinite alternate; }
.hero .g2 { width: 420px; height: 420px; left: -180px; bottom: -220px; background: radial-gradient(circle, rgba(127,163,255,.22), transparent 65%); animation: drift 18s ease-in-out infinite alternate-reverse; }
@keyframes drift { to { transform: translate(-60px, 50px) scale(1.1); } }
.hero-grid { position: relative; z-index: 1; display: grid; grid-template-columns: 1.15fr .85fr; gap: 40px; align-items: end; }
.hero-txt { padding-bottom: clamp(48px, 7vw, 96px); }
.hero-tag { display: inline-flex; align-items: center; gap: 10px; padding: 8px 16px 8px 10px; border-radius: 999px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.14); font-size: .9rem; font-weight: 600; color: rgba(255,255,255,.8); margin-bottom: 26px; }
.hero-tag i { width: 8px; height: 8px; border-radius: 50%; background: #3DDC97; animation: blink 2.4s ease-in-out infinite; }
@keyframes blink { 0%, 100% { box-shadow: 0 0 0 0 rgba(61,220,151,.5); } 50% { box-shadow: 0 0 0 7px rgba(61,220,151,0); } }
.hero h1 { font-size: clamp(2.3rem, 5.4vw, 4.8rem); }
.hero h1 .w { display: inline-block; opacity: 0; transform: translateY(.45em); filter: blur(6px); animation: wIn .8s var(--ease) forwards; }
@keyframes wIn { to { opacity: 1; transform: none; filter: none; } }
.hero h1 em { font-style: normal; color: var(--blue-l); }
.hero .lead { margin: 24px 0 34px; color: rgba(255,255,255,.72); }
.hero-acts { display: flex; gap: 12px; flex-wrap: wrap; }
.hero-vis { position: relative; height: clamp(420px, 44vw, 600px); }
.hv-ring { position: absolute; left: 50%; top: 46%; width: 88%; aspect-ratio: 1; transform: translate(-50%, -50%); border-radius: 50%; border: 1.5px dashed rgba(127,163,255,.35); animation: spin 40s linear infinite; }
.hv-disc { position: absolute; left: 50%; top: 46%; width: 70%; aspect-ratio: 1; transform: translate(-50%, -50%); border-radius: 50%; background: radial-gradient(circle at 50% 40%, #2F5FE6, #173DAE 55%, rgba(16,38,77,0) 72%); }
@keyframes spin { to { transform: translate(-50%, -50%) rotate(360deg); } }
.hero-vis img { position: absolute; left: 50%; bottom: 0; transform: translateX(-50%); height: 100%; width: auto; max-width: none; filter: drop-shadow(0 30px 40px rgba(0,0,0,.45)); animation: rise 1.1s var(--ease) .25s both; }
@keyframes rise { from { opacity: 0; transform: translateX(-50%) translateY(40px); } }
.bf { position: absolute; z-index: 2; display: flex; align-items: center; gap: 12px; padding: 12px 16px 12px 12px; border-radius: 18px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); box-shadow: 0 20px 40px -16px rgba(0,0,0,.5); animation: bfIn .8s var(--ease) both, bob 6s ease-in-out infinite; }
.bf b { font-size: 1.7rem; font-weight: 800; letter-spacing: -0.04em; line-height: 1; }
.bf span { font-size: .82rem; line-height: 1.25; color: rgba(255,255,255,.8); font-weight: 600; max-width: 120px; }
.bf .rg { position: relative; width: 48px; height: 48px; flex-shrink: 0; }
.bf .rg svg { width: 48px; height: 48px; transform: rotate(-90deg); }
.bf .rg circle { fill: none; stroke-width: 4; }
.bf .rg .t { stroke: rgba(255,255,255,.15); }
.bf .rg .v { stroke: var(--blue-l); stroke-linecap: round; stroke-dasharray: 126; stroke-dashoffset: 126; transition: stroke-dashoffset 1.6s var(--ease); }
.bf .rg b { position: absolute; inset: 0; display: grid; place-items: center; font-size: 1.05rem; }
.bf.on .rg .v { stroke-dashoffset: var(--off, 20); }
.b1 { left: -4%; top: 22%; animation-delay: .8s, .8s; }
.b2 { right: -2%; top: 46%; animation-delay: 1s, 2s; }
.b3 { left: 2%; bottom: 12%; animation-delay: 1.2s, 3.2s; }
.b3 i { width: 10px; height: 10px; border-radius: 50%; background: #3DDC97; animation: blink 2.4s infinite; flex-shrink: 0; margin-left: 4px; }
@keyframes bfIn { from { opacity: 0; transform: translateY(16px) scale(.9); } }
@keyframes bob { 0%, 100% { translate: 0 0; } 50% { translate: 0 -8px; } }
.hv-name { position: absolute; right: 0; bottom: 18px; z-index: 3; font-size: .82rem; color: rgba(255,255,255,.65); font-weight: 600; text-align: right; }
.hv-name b { display: block; color: #fff; font-size: .95rem; }
@media (max-width: 900px) {
  .hero-grid { grid-template-columns: 1fr; gap: 0; }
  .hero-txt { padding-bottom: 28px; }
  .hero-vis { height: 430px; margin: 0 -20px; }
  .hero-vis::after { content: ''; position: absolute; left: 0; right: 0; bottom: 0; height: 120px; z-index: 1; background: linear-gradient(transparent, rgba(10,23,48,.92)); pointer-events: none; }
  .b1 { left: 12px; top: auto; bottom: 92px; } .b2 { right: 12px; top: 40%; } .b3 { display: none; }
  .hv-name { left: 20px; right: auto; bottom: 22px; text-align: left; }
  .bf { padding: 9px 12px 9px 9px; border-radius: 14px; } .bf b { font-size: 1.35rem; } .bf .rg, .bf .rg svg { width: 40px; height: 40px; } .bf span { font-size: .76rem; max-width: 100px; }
}
@media (prefers-reduced-motion: reduce) { .hero h1 .w { animation: none; opacity: 1; transform: none; filter: none; } .hero::before, .hero .glow, .hv-ring, .bf { animation: none; } }

/* Estándares */
.std { display: flex; align-items: center; gap: 12px 28px; justify-content: center; padding: 26px 0; border-bottom: 1px solid var(--line); }
.std span { font-weight: 700; color: var(--muted-2); font-size: .9rem; }
.std b { font-size: 1.02rem; font-weight: 800; white-space: nowrap; }
@media (max-width: 720px) { .std { justify-content: flex-start; overflow-x: auto; flex-wrap: nowrap; scrollbar-width: none; margin: 0 -20px; padding: 20px; } .std::-webkit-scrollbar { display: none; } }

/* Servicios condensados: selector + una tarjeta */
.svw { display: grid; grid-template-columns: 340px 1fr; gap: 20px; align-items: stretch; }
.svw-tabs { display: grid; gap: 6px; align-content: start; }
.svw-tab { display: flex; align-items: center; gap: 14px; padding: 14px 16px; border-radius: 16px; border: 1px solid transparent; background: none; text-align: left; font-weight: 700; font-size: 1rem; cursor: pointer; color: var(--muted); transition: background .25s, color .25s, border-color .25s; }
.svw-tab .mi { width: 40px; height: 40px; border-radius: 12px; background: var(--soft); color: var(--muted); display: grid; place-items: center; font-size: 20px; flex-shrink: 0; transition: background .25s, color .25s; }
.svw-tab:hover { color: var(--ink); background: var(--soft); }
.svw-tab[aria-selected="true"] { color: var(--ink); background: #fff; border-color: var(--line); box-shadow: 0 14px 34px -24px rgba(10,23,48,.4); }
.svw-tab[aria-selected="true"] .mi { background: var(--blue); color: #fff; }
.svw-panel { position: relative; overflow: hidden; border-radius: 26px; background: linear-gradient(150deg, var(--navy), var(--ink)); color: #fff; padding: clamp(26px, 4vw, 48px); min-height: 420px; display: flex; flex-direction: column; }
.svw-panel .big { position: absolute; right: -40px; bottom: -40px; font-size: 280px; color: rgba(127,163,255,.08); }
.svw-panel .q { font-size: .95rem; font-weight: 700; color: var(--blue-l); margin-bottom: 14px; }
.svw-panel h3 { font-size: clamp(1.6rem, 3vw, 2.4rem); font-weight: 800; letter-spacing: -0.03em; line-height: 1.1; margin-bottom: 14px; }
.svw-panel p { color: rgba(255,255,255,.72); font-size: 1.08rem; max-width: 560px; }
.svw-panel .chips { margin: 24px 0 30px; position: relative; }
.svw-panel .acts { margin-top: auto; display: flex; gap: 10px; flex-wrap: wrap; position: relative; }
.svw-pane { animation: paneIn .45s var(--ease); display: flex; flex-direction: column; flex: 1; }
@media (max-width: 900px) {
  .svw { grid-template-columns: 1fr; gap: 14px; }
  .svw-tabs { display: flex; overflow-x: auto; gap: 8px; margin: 0 -20px; padding: 2px 20px 6px; scrollbar-width: none; scroll-snap-type: x proximity; }
  .svw-tabs::-webkit-scrollbar { display: none; }
  .svw-tab { flex: 0 0 auto; padding: 9px 14px 9px 9px; border-radius: 999px; border-color: var(--line); background: #fff; font-size: .9rem; scroll-snap-align: start; }
  .svw-tab .mi { width: 30px; height: 30px; border-radius: 50%; font-size: 15px; }
  .svw-panel { min-height: 0; border-radius: 22px; }
  .svw-panel .big { font-size: 180px; right: -30px; bottom: -30px; }
  .svw-panel p { font-size: 1rem; }
  .svw-panel .chips { margin: 18px 0 22px; }
  .svw-panel .acts .b { flex: 1; }
}

/* Diagnóstico destacado */
.dg { margin-top: 18px; display: grid; grid-template-columns: 1fr auto; gap: 28px; align-items: center; border: 1px solid var(--line); border-radius: 26px; padding: clamp(22px, 3.5vw, 40px); background: #fff; position: relative; overflow: hidden; }
.dg::before { content: ''; position: absolute; inset: 0; background: linear-gradient(110deg, transparent 30%, rgba(31,79,216,.06) 50%, transparent 70%); background-size: 220% 100%; animation: sweep 5s ease-in-out infinite; }
@keyframes sweep { from { background-position: 120% 0; } to { background-position: -120% 0; } }
.dg > * { position: relative; }
.dg h3 { font-size: clamp(1.4rem, 2.6vw, 2rem); font-weight: 800; letter-spacing: -0.025em; line-height: 1.15; margin: 8px 0; }
.dg .mg { width: 150px; height: 150px; position: relative; }
.dg .mg svg { width: 100%; height: 100%; transform: rotate(-90deg); }
.dg .mg circle { fill: none; stroke-width: 12; }
.dg .mg .t { stroke: var(--soft); }
.dg .mg .v { stroke: var(--blue); stroke-linecap: round; stroke-dasharray: 402; stroke-dashoffset: 402; animation: gauge 4.5s var(--ease) infinite; }
@keyframes gauge { 0% { stroke-dashoffset: 402; } 45%, 75% { stroke-dashoffset: 110; } 100% { stroke-dashoffset: 402; } }
.dg .mg b { position: absolute; inset: 0; display: grid; place-items: center; font-size: .85rem; color: var(--muted); font-weight: 700; text-align: center; line-height: 1.2; }
.dg .acts { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 18px; }
@media (max-width: 720px) { .dg { grid-template-columns: 1fr; text-align: left; gap: 0; } .dg .mg { width: 76px; height: 76px; position: absolute; right: 18px; top: 18px; } .dg .mg b { font-size: 0; } .dg h3 { padding-right: 70px; font-size: 1.35rem; } .dg .acts .b { flex: 1 1 100%; justify-content: center; } }
@media (max-width: 720px) {
  .hero { padding-top: 26px !important; }
  .hero-tag { font-size: .8rem; padding: 6px 12px 6px 8px; margin-bottom: 16px; }
  .hero h1 { font-size: 2.05rem; }
  .hero .lead { font-size: 1rem; margin: 14px 0 20px; }
  .hero-txt { padding-bottom: 8px !important; }
  .hero-acts { flex-wrap: nowrap; gap: 8px; }
  .hero-acts .b { flex: 1 1 auto; justify-content: center; padding-left: 14px; padding-right: 14px; font-size: .92rem; white-space: nowrap; }
  .hero-acts .b .ic { display: none; }
}

/* Método (sin numeración) */
.steps4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; position: relative; }
.steps4 > div { position: relative; padding: 28px; border-radius: 22px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); transition: background .3s, border-color .3s, transform .35s var(--ease); }
.steps4 > div:hover { background: rgba(127,163,255,.09); border-color: rgba(127,163,255,.3); transform: translateY(-4px); }
.steps4 .no { width: 52px; height: 52px; border-radius: 16px; background: rgba(127,163,255,.14); color: var(--blue-l); display: grid; place-items: center; font-size: 24px; margin-bottom: 22px; }
.steps4 h3 { font-size: 1.3rem; font-weight: 800; margin-bottom: 8px; letter-spacing: -0.02em; }
.steps4 p { color: rgba(255,255,255,.65); }
.steps4 .bar { position: absolute; left: 28px; right: 28px; bottom: 0; height: 3px; border-radius: 3px; background: var(--blue-l); transform: scaleX(0); transform-origin: left; transition: transform 1s var(--ease); }
.steps4.in .bar { transform: scaleX(1); }
.steps4.in > div:nth-child(2) .bar { transition-delay: .3s; } .steps4.in > div:nth-child(3) .bar { transition-delay: .6s; } .steps4.in > div:nth-child(4) .bar { transition-delay: .9s; }
@media (max-width: 1020px) { .steps4 { grid-template-columns: 1fr 1fr; } }

/* Clientes */
.logos { overflow: hidden; mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent); -webkit-mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent); }
.logos-track { display: flex; gap: 14px; width: max-content; animation: marquee 34s linear infinite; }
.logos-track > div { width: 200px; height: 92px; border-radius: 18px; border: 1px solid var(--line); background: #fff; display: grid; place-items: center; padding: 18px 26px; flex-shrink: 0; }
.logos-track img { max-height: 46px; max-width: 100%; width: auto; object-fit: contain; filter: grayscale(1); opacity: .75; transition: filter .3s, opacity .3s; }
.logos-track > div:hover img { filter: none; opacity: 1; }
.logos-track .txt { font-size: 1.4rem; font-weight: 800; letter-spacing: -0.03em; color: var(--muted); }
.logos:hover .logos-track { animation-play-state: paused; }
@keyframes marquee { to { transform: translateX(calc(-50% - 7px)); } }
@media (max-width: 720px) { .logos-track > div { width: 150px; height: 72px; padding: 14px 18px; border-radius: 14px; } .logos-track img { max-height: 34px; } .logos-track .txt { font-size: 1.1rem; } }

/* Dirección (compacta) */
.dir { display: grid; grid-template-columns: auto 1fr; gap: clamp(22px, 4vw, 48px); align-items: center; background: var(--soft); border-radius: 28px; padding: clamp(22px, 4vw, 44px); }
.dir-ph { width: 190px; height: 190px; border-radius: 50%; overflow: hidden; background: radial-gradient(circle at 50% 35%, #2F5FE6, #10264D 70%); position: relative; flex-shrink: 0; }
.dir-ph img { position: absolute; left: 50%; top: 6%; transform: translateX(-50%); width: 112%; max-width: none; height: auto; }
.dir h2 { font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; letter-spacing: -0.03em; }
.dir .role { color: var(--blue); font-weight: 700; margin: 6px 0 14px; }
.dir p.bio { color: var(--muted); max-width: 640px; }
.dir .chips { margin-top: 16px; }
.dir .contact { display: flex; gap: 10px 22px; flex-wrap: wrap; margin-top: 18px; }
@media (max-width: 720px) { .dir { grid-template-columns: 1fr; text-align: left; } .dir-ph { width: 96px; height: 96px; } .dir-top { display: flex; gap: 16px; align-items: center; } .dir p.bio { font-size: .95rem; } }

/* Contacto */
.ct { display: grid; grid-template-columns: 0.9fr 1.1fr; gap: clamp(36px, 6vw, 96px); align-items: start; }
.ct-ch { display: grid; gap: 12px; margin-top: 30px; }
.ct-ch a { display: flex; align-items: center; gap: 16px; padding: 18px 20px; border-radius: 16px; border: 1px solid var(--line); background: #fff; font-weight: 700; transition: border-color .25s; }
.ct-ch a:hover { border-color: var(--blue); }
.ct-ch a .icon-tile { width: 44px; height: 44px; font-size: 20px; }
.ct-ch small { display: block; font-weight: 500; color: var(--muted); }
.form { background: #fff; border: 1px solid var(--line); border-radius: 26px; padding: clamp(24px, 4vw, 44px); }
.form .row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.form label { display: block; font-weight: 700; font-size: .92rem; margin-bottom: 8px; }
.form .f { margin-bottom: 18px; }
.form input, .form select, .form textarea { width: 100%; padding: 15px 16px; border-radius: 14px; border: 1.5px solid var(--line); font: inherit; font-size: 1rem; background: #fff; color: var(--ink); transition: border-color .2s; }
.form input:focus, .form select:focus, .form textarea:focus { outline: none; border-color: var(--blue); }
.form textarea { min-height: 130px; resize: vertical; }
.form-ok { display: none; text-align: center; padding: 30px 10px; }
@media (max-width: 860px) { .ct { grid-template-columns: 1fr; } }
@media (max-width: 520px) { .form .row2 { grid-template-columns: 1fr; } }
@endsection

@section('content')
<section class="hero">
  <span class="glow g1" aria-hidden="true"></span><span class="glow g2" aria-hidden="true"></span>
  <div class="wrap hero-grid">
    <div class="hero-txt">
      <div class="hero-tag rv"><i></i> Firma especializada en Lima, Perú</div>
      <h1 class="display" id="heroTitle">Especialistas en compliance penal y <em>prevención de lavado de activos.</em></h1>
      <p class="lead rv" style="--d:.35s">Acompañamos a empresas, sujetos obligados y proveedores de activos virtuales, desde la prevención hasta la defensa.</p>
      <div class="hero-acts rv" style="--d:.45s">
        <a href="{{ route('services.show', 'compliance-penal') }}#herramienta" class="b b-primary">Hacer mi diagnóstico @include('site.partials.icon', ['name' => 'arrow'])</a>
        <a href="#servicios" class="b b-ghost-dark">Ver servicios</a>
      </div>
    </div>
    <div class="hero-vis" aria-label="Denis Gabriel Romani Seminario, director">
      <span class="hv-disc"></span><span class="hv-ring"></span>
      <img src="{{ asset('images/denis-romani.webp') }}" alt="Denis Gabriel Romani Seminario" fetchpriority="high">
      <div class="bf b1" data-ring><div class="rg"><svg viewBox="0 0 48 48"><circle class="t" cx="24" cy="24" r="20"/><circle class="v" cx="24" cy="24" r="20" style="--off:18"/></svg></div><div><b data-count="15" data-suffix="+">0</b><span>años de experiencia</span></div></div>
      <div class="bf b2" data-ring><div class="rg"><svg viewBox="0 0 48 48"><circle class="t" cx="24" cy="24" r="20"/><circle class="v" cx="24" cy="24" r="20" style="--off:0"/></svg><b data-count="6">0</b></div><span>áreas de práctica especializadas</span></div>
      <div class="bf b3"><i></i><span>Estándares GAFI y Ley 30424</span></div>
      <div class="hv-name"><b>Denis Romani Seminario</b>Director</div>
    </div>
  </div>
</section>

<div class="wrap"><div class="std"><span>Trabajamos con</span><b>Ley 30424</b><b>SBS / UIF</b><b>GAFI</b><b>ISO 37001</b><b>COSO</b></div></div>

<section class="sec" id="servicios">
  <div class="wrap">
    <div class="sec-head">
      <div><div class="kicker rv">Servicios</div><h2 class="h2 rv">¿Qué necesita resolver?</h2></div>
      <p class="lead rv m-hide" style="max-width:420px">Elija su situación. Cada servicio tiene su propia página con herramientas para entender su caso.</p>
    </div>
    <div class="svw rv">
      <div class="svw-tabs" role="tablist" aria-label="Servicios">
        @foreach($services as $slug => $s)
          <button type="button" class="svw-tab" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}" aria-controls="svp-{{ $slug }}" data-k="{{ $slug }}"><span class="mi">@include('site.partials.icon', ['name' => $s['icon']])</span>{{ $s['short'] ?? $s['name'] }}</button>
        @endforeach
      </div>
      <div class="svw-panel">
        @foreach($services as $slug => $s)
          <div class="svw-pane" id="svp-{{ $slug }}" role="tabpanel" @unless($loop->first) hidden @endunless>
            <span class="big" aria-hidden="true">@include('site.partials.icon', ['name' => $s['icon']])</span>
            <div class="q">«{{ $s['situation'] }}»</div>
            <h3>{{ $s['name'] }}</h3>
            <p>{{ $s['card'] }}</p>
            <div class="chips">@foreach(array_slice($s['includes'], 0, 3) as $it)<span class="chip">@include('site.partials.icon', ['name' => 'check']) {{ $it }}</span>@endforeach</div>
            <div class="acts">
              @if(isset($s['cta2']))
                <a href="{{ route('services.show', $slug) }}#inmobiliario" class="b b-light">{{ $s['cta'] }} @include('site.partials.icon', ['name' => 'arrow'])</a>
                <a href="{{ route('services.show', $slug) }}#notarial" class="b b-ghost-dark">{{ $s['cta2'] }}</a>
              @else
                <a href="{{ route('services.show', $slug) }}" class="b b-light">{{ $s['cta'] }} @include('site.partials.icon', ['name' => 'arrow'])</a>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="dg rv">
      <div>
        <span class="pill info">Gratis · 2 minutos</span>
        <h3>Mida el riesgo de su organización.</h3>
        <p class="muted">Nueve preguntas, un puntaje de 0 a 100 y sus prioridades en un PDF que puede descargar.</p>
        <div class="acts">
          <a href="{{ route('services.show', 'compliance-penal') }}#herramienta" class="b b-primary">Empezar diagnóstico @include('site.partials.icon', ['name' => 'arrow'])</a>
          <a href="{{ route('capacitaciones') }}" class="b b-ghost">Capacitación</a>
        </div>
      </div>
      <div class="mg" aria-hidden="true"><svg viewBox="0 0 150 150"><circle class="t" cx="75" cy="75" r="64"/><circle class="v" cx="75" cy="75" r="64"/></svg><b>Su<br>puntaje</b></div>
    </div>
  </div>
</section>

<section class="sec sec-dark on-dark">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Cómo trabajamos</div><h2 class="h2 rv">Claridad desde la primera conversación.</h2></div></div>
    <div class="steps4 m-scroll" id="steps4">
      @foreach([['chat', 'Escuchamos', 'Entendemos su caso, sus plazos y lo que está en juego.'], ['shield', 'Diagnosticamos', 'Le decimos dónde está el riesgo y qué opciones tiene.'], ['doc', 'Ejecutamos', 'Documentos, defensas y respuestas con rigor técnico y a tiempo.'], ['check', 'Acompañamos', 'Seguimos a su lado hasta cerrar el caso.']] as $i => [$ic, $t, $d])
        <div class="rv" style="--d:{{ $i * 0.1 }}s"><div class="no">@include('site.partials.icon', ['name' => $ic])</div><h3>{{ $t }}</h3><p>{{ $d }}</p><span class="bar"></span></div>
      @endforeach
    </div>
  </div>
</section>

<section class="sec" style="padding-bottom:clamp(40px,5vw,72px)">
  <div class="wrap">
    <div class="sec-head" style="margin-bottom:28px"><div><div class="kicker rv">Clientes</div><h2 class="h3 rv" style="font-size:clamp(1.35rem,2.6vw,2rem)">Organizaciones que confían en nuestro trabajo.</h2></div></div>
  </div>
  <div class="logos rv">
    <div class="logos-track">
      @for($i = 0; $i < 3; $i++)
        <div><img src="{{ asset('images/clientes/red-digital.svg') }}" alt="Red Digital"></div>
        <div><img src="{{ asset('images/clientes/qr-pay.png') }}" alt="QR Pay"></div>
        <div><span class="txt">GoldLion</span></div>
        <div><img src="{{ asset('images/clientes/san-jorge.png') }}" alt="Créditos San Jorge"></div>
      @endfor
    </div>
  </div>
</section>

<section class="sec" style="padding-top:0" id="director">
  <div class="wrap">
    <div class="dir rv">
      <div class="dir-top">
        <div class="dir-ph"><img src="{{ asset('images/denis-romani.webp') }}" alt="Denis Gabriel Romani Seminario" loading="lazy"></div>
      </div>
      <div>
        <div class="kicker">Dirección</div>
        <h2>Denis Gabriel Romani Seminario</h2>
        <div class="role">Abogado especialista en compliance y ALA/CFT</div>
        <p class="bio">Máster en Derecho Penal (PUCP) y en Cumplimiento Normativo Penal (Universidad de Castilla-La Mancha). Más de quince años en investigación financiera, prevención de lavado de activos y compliance corporativo.</p>
        <div class="chips"><span class="chip">PUCP</span><span class="chip">UCLM</span><span class="chip">ISO 37001:2021</span><span class="chip">Compliance Officer</span></div>
        <div class="contact"><a href="mailto:denis@romanicompliance.com" class="lnk">Escribirle</a><a href="{{ route('equipo') }}" class="lnk">Conocer al equipo @include('site.partials.icon', ['name' => 'arrow'])</a></div>
      </div>
    </div>
  </div>
</section>

@if($featuredCourses->isNotEmpty())
<section class="sec sec-soft">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Formación</div><h2 class="h2 rv">Cursos para equipos que previenen.</h2></div><a href="{{ route('courses.catalog') }}" class="lnk rv">Ver todos @include('site.partials.icon', ['name' => 'arrow'])</a></div>
    <div class="posts m-scroll">
      @foreach($featuredCourses as $course)
        <a href="{{ route('courses.show', $course) }}" class="post rv" style="--d:{{ $loop->index * 0.06 }}s">
          <div class="cv">@if($course->cover_image)<img src="{{ asset('storage/'.$course->cover_image) }}" alt="{{ $course->title }}" loading="lazy">@endif</div>
          <div class="bd">
            <div class="mt">{{ $course->category->name ?? 'Curso' }}@if($course->duration_minutes) · {{ $course->lectiveHours() }} {{ $course->lectiveHours() === 1 ? 'hora' : 'horas' }}@endif</div>
            <h3>{{ $course->title }}</h3>
            <p>{{ $course->description }}</p>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="sec" id="noticias">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Publicaciones</div><h2 class="h2 rv">Análisis y novedades regulatorias.</h2></div><a href="{{ route('blog.index') }}" class="lnk rv">Ver todas @include('site.partials.icon', ['name' => 'arrow'])</a></div>
    @if($recentArticles->isNotEmpty())
      <div class="posts m-scroll">
        @foreach($recentArticles as $article)
          @include('blog._article-card', ['article' => $article])
        @endforeach
      </div>
    @else
      <p class="muted rv">Pronto publicaremos nuestros primeros análisis.</p>
    @endif
  </div>
</section>

<section class="sec" id="contacto">
  <div class="wrap ct">
    <div>
      <div class="kicker rv">Contacto</div>
      <h2 class="h2 rv">Cuéntenos su caso.</h2>
      <p class="lead rv" style="margin-top:18px">Responderemos a la brevedad para coordinar una primera conversación. Todo lo que nos cuente se trata con reserva.</p>
      <div class="ct-ch rv">
        <a href="https://wa.me/{{ \App\Support\ServiceCatalog::WHATSAPP }}" target="_blank" rel="noopener"><span class="icon-tile">@include('site.partials.icon', ['name' => 'chat'])</span><span>+51 969 754 983<small>WhatsApp</small></span></a>
        <a href="mailto:denis@romanicompliance.com"><span class="icon-tile">@include('site.partials.icon', ['name' => 'mail'])</span><span>denis@romanicompliance.com<small>Correo</small></span></a>
        <a href="mailto:dromani@pucp.pe"><span class="icon-tile">@include('site.partials.icon', ['name' => 'mail'])</span><span>dromani@pucp.pe<small>Correo alterno</small></span></a>
      </div>
    </div>
    <div class="form rv">
      <form id="ctForm" data-no-loader novalidate>
        <div class="row2">
          <div class="f"><label for="cNombre">Nombre</label><input id="cNombre" name="nombre" autocomplete="name" required></div>
          <div class="f"><label for="cTel">Teléfono</label><input id="cTel" name="telefono" type="tel" autocomplete="tel" placeholder="+51"></div>
        </div>
        <div class="f"><label for="cEmail">Correo</label><input id="cEmail" name="email" type="email" autocomplete="email" required></div>
        <div class="f"><label for="cServ">Tema</label>
          <select id="cServ" name="servicio">
            @foreach($services as $s)<option>{{ $s['name'] }}</option>@endforeach
            <option>Capacitación</option><option>Otro tema</option>
          </select></div>
        <div class="f"><label for="cMsg">Mensaje</label><textarea id="cMsg" name="mensaje" placeholder="Describa brevemente su situación"></textarea></div>
        <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px">
        <label style="display:flex;gap:10px;align-items:flex-start;font-weight:500;font-size:.9rem;color:var(--muted);margin:-4px 0 18px;cursor:pointer"><input type="checkbox" name="consent" value="1" style="width:18px;height:18px;margin-top:2px;accent-color:var(--blue);flex-shrink:0"> <span>Autorizo a Romani Compliance a contactarme sobre esta consulta y a tratar mis datos con ese fin.</span></label>
        <button type="submit" class="b b-primary b-block" id="ctBtn">Enviar consulta @include('site.partials.icon', ['name' => 'arrow'])</button>
        <p class="note" id="ctErr" style="color:var(--bad);display:none"></p>
      </form>
      <div class="form-ok" id="ctOk"><div class="icon-tile" style="margin:0 auto 16px;background:rgba(14,138,95,.1);color:var(--ok)">@include('site.partials.icon', ['name' => 'check'])</div><h3 class="h3">Recibimos su consulta.</h3><p class="muted" style="margin-top:8px">Le escribiremos a la brevedad.</p></div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
(function () {
  // Titular: las palabras entran una a una
  const h = document.getElementById('heroTitle');
  if (h) {
    let n = 0;
    const wrap = (node) => [...node.childNodes].forEach((c) => {
      if (c.nodeType === 3) {
        const frag = document.createDocumentFragment();
        c.textContent.split(/(\s+)/).forEach((t) => { if (!t) return; if (/^\s+$/.test(t)) { frag.append(t); return; } const sp = document.createElement('span'); sp.className = 'w'; sp.style.animationDelay = (0.06 * n++) + 's'; sp.textContent = t; frag.append(sp); });
        c.replaceWith(frag);
      } else wrap(c);
    });
    wrap(h);
  }
  // Selector de servicios
  const tabs = [...document.querySelectorAll('.svw-tab')];
  tabs.forEach((t) => t.addEventListener('click', () => {
    tabs.forEach((x) => x.setAttribute('aria-selected', x === t));
    document.querySelectorAll('.svw-pane').forEach((p) => { p.hidden = p.id !== 'svp-' + t.dataset.k; });
    if (matchMedia('(max-width: 900px)').matches) t.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'smooth' });
  }));
  // Insignias de la portada: anillos que se llenan
  setTimeout(() => document.querySelectorAll('[data-ring]').forEach((b) => b.classList.add('on')), 1100);
  // Cifras que cuentan al aparecer
  document.querySelectorAll('[data-count]').forEach((el) => {
    new IntersectionObserver((es, o) => es.forEach((e) => { if (!e.isIntersecting) return; o.disconnect(); const end = +el.dataset.count, suf = el.dataset.suffix || ''; let t0; const step = (t) => { t0 = t0 || t; const k = Math.min(1, (t - t0) / 1400); el.textContent = Math.round(end * (1 - Math.pow(1 - k, 3))) + suf; if (k < 1) requestAnimationFrame(step); }; requestAnimationFrame(step); }), { threshold: 0.6 }).observe(el);
  });

  // Línea del método: se dibuja al entrar en pantalla
  const s4 = document.getElementById('steps4');
  new IntersectionObserver((es, o) => es.forEach((e) => { if (e.isIntersecting) { s4.classList.add('in'); o.disconnect(); } }), { threshold: 0.35 }).observe(s4);

  // ?servicio=... preselecciona el tema del formulario
  const pre = new URLSearchParams(location.search).get('servicio');
  if (pre) { const o = [...document.querySelectorAll('#cServ option')].find((x) => x.textContent.toLowerCase().includes(pre.toLowerCase())); if (o) o.selected = true; }

  const form = document.getElementById('ctForm');
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const d = Object.fromEntries(new FormData(form));
    const err = document.getElementById('ctErr');
    if (!d.nombre || !d.email || !/^\S+@\S+\.\S+$/.test(d.email)) { err.textContent = 'Indique su nombre y un correo válido.'; err.style.display = 'block'; return; }
    if (!d.consent) { err.textContent = 'Marque la autorización para que podamos contactarle.'; err.style.display = 'block'; return; }
    err.style.display = 'none';
    const btn = document.getElementById('ctBtn'); btn.disabled = true; btn.firstChild.textContent = 'Enviando ';
    const body = 'Consulta desde romanicompliance.com\n\nNombre: ' + d.nombre + '\nTeléfono: ' + (d.telefono || 'No indicado') + '\nCorreo: ' + d.email + '\nTema: ' + d.servicio + '\nMensaje: ' + (d.mensaje || 'Sin mensaje adicional');
    try {
      // 1) Queda registrada en el panel admin (Solicitudes de clientes)
      const saved = await fetch(@json(route('services.leads.store', 'contacto')), { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
        body: JSON.stringify({ name: d.nombre, email: d.email, phone: d.telefono || null, consent: 1, website: d.website || '', summary: 'Tema: ' + d.servicio + '\nMensaje: ' + (d.mensaje || 'Sin mensaje adicional'), data: { lines: ['Tema: ' + d.servicio, 'Mensaje: ' + (d.mensaje || 'Sin mensaje adicional')], title: 'Consulta desde la web' } }) });
      if (!saved.ok) throw new Error();
      // 2) Aviso por correo al equipo
      fetch('https://formsubmit.co/ajax/omaroliden1@gmail.com', { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, body: JSON.stringify({ name: d.nombre, email: d.email, message: body, _cc: 'dromani@pucp.pe', _subject: 'Consulta web · Romani Compliance' }) }).catch(() => {});   // si el aviso por correo falla, la consulta ya quedó guardada
      form.style.display = 'none'; document.getElementById('ctOk').style.display = 'block';
    } catch (_) {
      btn.disabled = false; btn.firstChild.textContent = 'Enviar consulta ';
      err.innerHTML = 'No se pudo enviar. Escríbanos por <a href="' + RC.wa(body) + '" target="_blank" rel="noopener" style="text-decoration:underline">WhatsApp</a>.'; err.style.display = 'block';
    }
  });
})();
</script>
@endsection
