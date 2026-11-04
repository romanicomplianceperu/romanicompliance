<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Romani Compliance · Compliance, prevención LA/FT y defensa penal económica')</title>
<meta name="description" content="@yield('description', 'Compliance penal, prevención de lavado de activos, criptoactivos y PSAV, y defensa penal económica para empresas y personas en el Perú.')">
<meta name="theme-color" content="#0A1730">
<link rel="icon" href="{{ asset('images/logos.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@php $rcServices = \App\Support\ServiceCatalog::all(); @endphp
<style>
/* ── Romani Compliance · sistema de diseño 2026 ─────────────────────────────── */
:root {
  --ink: #0A1730;        /* azul noche: texto y fondos oscuros */
  --navy: #10264D;
  --blue: #1F4FD8;       /* azul de acción */
  --blue-d: #173DAE;
  --blue-l: #7FA3FF;     /* azul sobre fondos oscuros */
  --blue-50: #EEF3FF;
  --blue-100: #DCE6FF;
  --bg: #FFFFFF;
  --soft: #F4F6FA;
  --line: #E2E7F0;
  --muted: #55647C;
  --muted-2: #8B97AA;
  --ok: #0E8A5F;
  --warn: #C25B12;
  --bad: #C0362C;
  --r: 18px;
  --r-s: 12px;
  --max: 1240px;
  --font: 'Manrope', system-ui, -apple-system, 'Segoe UI', sans-serif;
  --ease: cubic-bezier(.22,1,.36,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; overflow-x: hidden; }
body { font-family: var(--font); color: var(--ink); background: var(--bg); font-size: 17px; line-height: 1.6; -webkit-font-smoothing: antialiased; overflow-x: hidden; }
img { max-width: 100%; display: block; }
a { color: inherit; text-decoration: none; }
button { font: inherit; color: inherit; }
.ic { width: 1em; height: 1em; flex-shrink: 0; }
[hidden] { display: none !important; }
.wrap { max-width: var(--max); margin: 0 auto; padding: 0 32px; }
@media (max-width: 720px) { .wrap { padding: 0 20px; } body { font-size: 16px; } }

/* Tipografía */
.display { font-size: clamp(2.5rem, 6.4vw, 5.6rem); font-weight: 800; line-height: 1.02; letter-spacing: -0.045em; }
.h2 { font-size: clamp(2rem, 4.2vw, 3.4rem); font-weight: 800; line-height: 1.06; letter-spacing: -0.035em; }
.h3 { font-size: clamp(1.25rem, 2vw, 1.5rem); font-weight: 700; line-height: 1.25; letter-spacing: -0.02em; }
.lead { font-size: clamp(1.08rem, 1.6vw, 1.3rem); color: var(--muted); line-height: 1.6; max-width: 640px; }
.kicker { display: inline-flex; align-items: center; gap: 10px; font-size: 0.92rem; font-weight: 700; color: var(--blue); margin-bottom: 18px; }
.kicker .n { font-variant-numeric: tabular-nums; color: var(--muted-2); font-weight: 600; }
.on-dark .kicker { color: var(--blue-l); }
.muted { color: var(--muted); }
.text-blue { color: var(--blue); }

/* Botones */
.b { display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 15px 26px; border-radius: 999px; font-weight: 700; font-size: 0.98rem; border: 1.5px solid transparent; cursor: pointer; transition: background .25s var(--ease), color .25s, border-color .25s, transform .25s var(--ease); white-space: nowrap; }
.b .ic { width: 18px; height: 18px; transition: transform .25s var(--ease); }
.b:hover .ic { transform: translateX(3px); }
.b-primary { background: var(--blue); color: #fff; }
.b-primary:hover { background: var(--blue-d); }
.b-dark { background: var(--ink); color: #fff; }
.b-dark:hover { background: var(--navy); }
.b-ghost { border-color: var(--line); background: #fff; }
.b-ghost:hover { border-color: var(--ink); }
.b-light { background: #fff; color: var(--ink); }
.b-light:hover { background: var(--blue-50); }
.b-ghost-dark { border-color: rgba(255,255,255,.25); color: #fff; }
.b-ghost-dark:hover { border-color: #fff; }
.b-sm { padding: 10px 18px; font-size: 0.9rem; }
.b-block { width: 100%; }
.lnk { display: inline-flex; align-items: center; gap: 8px; font-weight: 700; color: var(--blue); }
.lnk .ic { width: 18px; height: 18px; transition: transform .25s var(--ease); }
.lnk:hover .ic { transform: translateX(4px); }

/* Navegación */
.nav { position: sticky; top: 0; z-index: 100; background: rgba(255,255,255,.86); backdrop-filter: saturate(160%) blur(14px); -webkit-backdrop-filter: saturate(160%) blur(14px); border-bottom: 1px solid transparent; transition: border-color .3s; }
.nav.scrolled { border-bottom-color: var(--line); }
.nav-in { max-width: var(--max); margin: 0 auto; padding: 0 32px; height: 76px; display: flex; align-items: center; gap: 28px; }
.nav-logo img { height: 34px; }
.nav-links { display: flex; align-items: center; gap: 4px; margin-left: auto; }
.nav-links > a, .nav-drop > button { padding: 10px 14px; border-radius: 999px; font-size: 0.95rem; font-weight: 600; color: var(--muted); background: none; border: 0; cursor: pointer; transition: color .2s, background .2s; display: inline-flex; align-items: center; gap: 6px; }
.nav-links > a:hover, .nav-drop > button:hover, .nav-links > a.on { color: var(--ink); background: var(--soft); }
.nav-drop { position: relative; }
.nav-drop > button .chev { width: 14px; height: 14px; transition: transform .2s; }
.nav-drop.open > button .chev { transform: rotate(180deg); }
.nav-mega { position: absolute; top: calc(100% + 10px); left: 50%; transform: translateX(-50%) translateY(6px); width: min(720px, 92vw); background: #fff; border: 1px solid var(--line); border-radius: 22px; padding: 14px; box-shadow: 0 30px 80px -20px rgba(10,23,48,.25); display: grid; grid-template-columns: 1fr 1fr; gap: 4px; opacity: 0; visibility: hidden; transition: opacity .2s, transform .2s var(--ease), visibility .2s; }
.nav-drop.open .nav-mega { opacity: 1; visibility: visible; transform: translateX(-50%) translateY(0); }
.nav-mega a { display: flex; gap: 14px; padding: 14px; border-radius: 14px; transition: background .2s; }
.nav-mega a:hover { background: var(--soft); }
.nav-mega .mi { width: 40px; height: 40px; border-radius: 12px; background: var(--blue-50); color: var(--blue); display: grid; place-items: center; flex-shrink: 0; font-size: 20px; }
.nav-mega strong { display: block; font-size: 0.95rem; font-weight: 700; color: var(--ink); line-height: 1.3; }
.nav-mega span.t { display: block; font-size: 0.82rem; color: var(--muted); line-height: 1.4; margin-top: 2px; }
.nav-actions { display: flex; align-items: center; gap: 8px; }
.nav-burger { display: none; margin-left: auto; width: 44px; height: 44px; border-radius: 50%; border: 1px solid var(--line); background: #fff; cursor: pointer; align-items: center; justify-content: center; }
.nav-burger span { display: block; width: 18px; height: 2px; background: var(--ink); position: relative; transition: background .2s; }
.nav-burger span::before, .nav-burger span::after { content: ''; position: absolute; left: 0; width: 18px; height: 2px; background: var(--ink); transition: transform .3s var(--ease); }
.nav-burger span::before { top: -6px; } .nav-burger span::after { top: 6px; }
body.menu-open .nav-burger span { background: transparent; }
body.menu-open .nav-burger span::before { transform: translateY(6px) rotate(45deg); }
body.menu-open .nav-burger span::after { transform: translateY(-6px) rotate(-45deg); }
.m-menu { position: fixed; inset: 76px 0 0; z-index: 99; background: #fff; padding: 20px 20px 40px; overflow-y: auto; opacity: 0; visibility: hidden; transform: translateY(-8px); transition: opacity .25s, transform .3s var(--ease), visibility .25s; }
body.menu-open .m-menu { opacity: 1; visibility: visible; transform: none; }
.m-menu .m-group { font-size: 0.82rem; font-weight: 700; color: var(--muted-2); margin: 18px 0 6px; }
.m-menu a.m-l { display: flex; align-items: center; justify-content: space-between; padding: 14px 0; font-size: 1.15rem; font-weight: 700; border-bottom: 1px solid var(--line); }
.m-menu a.m-s { display: flex; align-items: center; gap: 12px; padding: 12px 0; font-weight: 600; border-bottom: 1px solid var(--line); }
.m-menu a.m-s .ic { color: var(--blue); width: 20px; height: 20px; }
@media (max-width: 1080px) { .nav-links, .nav-actions { display: none; } .nav-burger { display: inline-flex; } }
@media (max-width: 720px) { .nav-in { padding: 0 20px; height: 68px; } .m-menu { inset: 68px 0 0; } .nav-logo img { height: 30px; } }

/* Secciones */
.sec { padding: clamp(72px, 10vw, 132px) 0; }
.sec-soft { background: var(--soft); }
.sec-dark { background: var(--ink); color: #fff; }
.sec-dark .lead, .sec-dark .muted { color: rgba(255,255,255,.68); }
.sec-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 32px; margin-bottom: clamp(36px, 5vw, 64px); flex-wrap: wrap; }
.sec-head .lead { margin-top: 18px; }

/* Tarjetas */
.card { background: #fff; border: 1px solid var(--line); border-radius: var(--r); padding: 30px; transition: border-color .3s, transform .35s var(--ease), box-shadow .35s; }
.card-link:hover { border-color: var(--blue); transform: translateY(-4px); box-shadow: 0 24px 60px -28px rgba(31,79,216,.35); }
.icon-tile { width: 52px; height: 52px; border-radius: 14px; background: var(--blue-50); color: var(--blue); display: grid; place-items: center; font-size: 24px; }
.chips { display: flex; flex-wrap: wrap; gap: 8px; }
.chip { display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 999px; background: var(--soft); font-size: 0.88rem; font-weight: 600; color: var(--ink); }
.chip .ic { color: var(--blue); width: 16px; height: 16px; }
.sec-dark .chip { background: rgba(255,255,255,.08); color: #fff; }

/* Lista con marcas (sin guiones) */
.ticks { list-style: none; display: grid; gap: 12px; }
.ticks li { display: flex; gap: 12px; align-items: flex-start; }
.ticks li .ic { color: var(--blue); width: 20px; height: 20px; margin-top: 2px; }

/* Línea de tiempo animada */
.tl { position: relative; display: grid; gap: 0; }
.tl::before { content: ''; position: absolute; left: 23px; top: 8px; bottom: 8px; width: 2px; background: var(--line); }
.tl-fill { position: absolute; left: 23px; top: 8px; width: 2px; height: 0; background: var(--blue); transition: height .15s linear; }
.tl-step { position: relative; display: grid; grid-template-columns: 48px 1fr; gap: 24px; padding: 0 0 44px; }
.tl-step:last-child { padding-bottom: 0; }
.tl-dot { width: 48px; height: 48px; border-radius: 50%; border: 2px solid var(--line); background: #fff; display: grid; place-items: center; font-weight: 800; font-size: 0.95rem; color: var(--muted-2); position: relative; z-index: 1; transition: border-color .4s, color .4s, background .4s; }
.tl-step.lit .tl-dot { border-color: var(--blue); background: var(--blue); color: #fff; }
.tl-step h3 { font-size: 1.3rem; font-weight: 800; letter-spacing: -0.02em; margin: 9px 0 6px; }
.tl-step p { color: var(--muted); max-width: 560px; }
.sec-dark .tl::before { background: rgba(255,255,255,.14); }
.sec-dark .tl-dot { background: var(--ink); border-color: rgba(255,255,255,.2); }
.sec-dark .tl-step p { color: rgba(255,255,255,.66); }

/* Preguntas frecuentes */
.faq { border-top: 1px solid var(--line); }
.faq details { border-bottom: 1px solid var(--line); }
.faq summary { list-style: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: 20px; padding: 26px 0; font-size: 1.15rem; font-weight: 700; letter-spacing: -0.01em; }
.faq summary::-webkit-details-marker { display: none; }
.faq summary .pm { width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--line); display: grid; place-items: center; flex-shrink: 0; transition: transform .3s var(--ease), background .2s; }
.faq details[open] summary .pm { transform: rotate(45deg); background: var(--blue-50); border-color: var(--blue-100); }
.faq details p { color: var(--muted); padding: 0 56px 26px 0; max-width: 820px; }

/* Herramientas interactivas */
.tool { background: #fff; border: 1px solid var(--line); border-radius: 26px; padding: clamp(22px, 4vw, 48px); box-shadow: 0 40px 100px -60px rgba(10,23,48,.35); }
.tool-progress { display: flex; gap: 6px; margin-bottom: 28px; }
.tool-progress i { flex: 1; height: 4px; border-radius: 4px; background: var(--line); transition: background .3s; }
.tool-progress i.on { background: var(--blue); }
.tool-q { font-size: clamp(1.25rem, 2.4vw, 1.7rem); font-weight: 800; letter-spacing: -0.025em; line-height: 1.25; margin-bottom: 6px; }
.tool-hint { color: var(--muted); margin-bottom: 22px; }
.opts { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; }
.opt { text-align: left; border: 1.5px solid var(--line); background: #fff; border-radius: 16px; padding: 18px 20px; cursor: pointer; font-weight: 600; line-height: 1.4; display: flex; gap: 14px; align-items: flex-start; transition: border-color .2s, background .2s, transform .2s var(--ease); }
.opt:hover { border-color: var(--blue-100); transform: translateY(-2px); }
.opt[aria-pressed="true"] { border-color: var(--blue); background: var(--blue-50); }
.opt .box { width: 22px; height: 22px; border-radius: 7px; border: 1.5px solid var(--muted-2); flex-shrink: 0; display: grid; place-items: center; color: #fff; margin-top: 1px; transition: background .2s, border-color .2s; }
.opt.radio .box { border-radius: 50%; }
.opt[aria-pressed="true"] .box { background: var(--blue); border-color: var(--blue); }
.opt .box .ic { width: 14px; height: 14px; opacity: 0; }
.opt[aria-pressed="true"] .box .ic { opacity: 1; }
.opt small { display: block; font-weight: 500; color: var(--muted); font-size: 0.86rem; margin-top: 3px; }
.yn { display: flex; gap: 10px; }
.yn .opt { flex: 1; justify-content: center; }
.tool-nav { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-top: 30px; flex-wrap: wrap; }
.tool-pane { animation: paneIn .45s var(--ease); }
@keyframes paneIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
.range { width: 100%; accent-color: var(--blue); height: 32px; }
.result { display: grid; grid-template-columns: 220px 1fr; gap: 40px; align-items: center; }
@media (max-width: 760px) { .result { grid-template-columns: 1fr; gap: 24px; } }
.gauge { position: relative; width: 200px; height: 200px; margin: 0 auto; }
.gauge svg { width: 100%; height: 100%; transform: rotate(-90deg); }
.gauge .track { stroke: var(--soft); }
.gauge .val { stroke: var(--blue); stroke-linecap: round; transition: stroke-dashoffset 1.4s var(--ease), stroke .4s; }
.gauge .num { position: absolute; inset: 0; display: grid; place-items: center; text-align: center; }
.gauge .num b { display: block; font-size: 3rem; font-weight: 800; letter-spacing: -0.04em; line-height: 1; }
.gauge .num span { font-size: 0.85rem; color: var(--muted); font-weight: 600; }
.pill { display: inline-flex; align-items: center; gap: 8px; padding: 7px 14px; border-radius: 999px; font-weight: 700; font-size: 0.88rem; }
.pill.ok { background: rgba(14,138,95,.1); color: var(--ok); }
.pill.warn { background: rgba(194,91,18,.1); color: var(--warn); }
.pill.bad { background: rgba(192,54,44,.1); color: var(--bad); }
.pill.info { background: var(--blue-50); color: var(--blue); }
.note { font-size: 0.85rem; color: var(--muted-2); margin-top: 22px; }
.meter { height: 10px; border-radius: 10px; background: var(--soft); overflow: hidden; }
.meter i { display: block; height: 100%; width: 0; border-radius: 10px; background: var(--blue); transition: width 1.2s var(--ease), background .3s; }

/* Tarjetas de publicación y curso (inicio, publicaciones, autor) */
.posts { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.post { display: flex; flex-direction: column; border-radius: var(--r); overflow: hidden; border: 1px solid var(--line); background: #fff; transition: transform .35s var(--ease), border-color .3s; }
.post:hover { transform: translateY(-4px); border-color: var(--blue); }
.post .cv { aspect-ratio: 16 / 10; background: var(--soft); overflow: hidden; }
.post .cv img { width: 100%; height: 100%; object-fit: cover; }
.post .bd { padding: 24px; display: flex; flex-direction: column; gap: 10px; flex: 1; }
.post .mt { font-size: .85rem; color: var(--muted-2); font-weight: 600; }
.post h3 { font-size: 1.15rem; font-weight: 800; letter-spacing: -0.015em; line-height: 1.3; }
.post p { color: var(--muted); font-size: .95rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
@media (max-width: 900px) { .posts { grid-template-columns: 1fr; } }


/* Animación de entrada */
.rv { opacity: 0; transform: translateY(26px); transition: opacity .8s var(--ease), transform .8s var(--ease); transition-delay: var(--d, 0s); }
.rv.in { opacity: 1; transform: none; }
@media (prefers-reduced-motion: reduce) { .rv { opacity: 1; transform: none; transition: none; } .tool-pane { animation: none; } html { scroll-behavior: auto; } }

/* Pie de página */
.foot { background: var(--ink); color: rgba(255,255,255,.7); padding: 88px 0 36px; }
.foot-top { display: grid; grid-template-columns: 1.4fr 1fr 1fr 1fr; gap: 40px; }
.foot h4 { color: #fff; font-size: 0.95rem; font-weight: 700; margin-bottom: 16px; }
.foot a { display: block; padding: 5px 0; font-size: 0.95rem; transition: color .2s; }
.foot a:hover { color: #fff; }
.foot-brand img { height: 34px; filter: brightness(0) invert(1); margin-bottom: 18px; }
.foot-brand p { max-width: 320px; font-size: 0.95rem; }
.foot-bot { margin-top: 64px; padding-top: 28px; border-top: 1px solid rgba(255,255,255,.1); display: flex; justify-content: space-between; gap: 16px; flex-wrap: wrap; font-size: 0.85rem; color: rgba(255,255,255,.45); }
.foot-bot a { display: inline; padding: 0; color: rgba(255,255,255,.65); }
@media (max-width: 900px) { .foot-top { grid-template-columns: 1fr 1fr; } .foot-brand { grid-column: 1 / -1; } }

/* WhatsApp flotante */
.wa { position: fixed; right: 22px; bottom: 22px; z-index: 90; width: 58px; height: 58px; border-radius: 50%; background: #25D366; display: grid; place-items: center; box-shadow: 0 14px 34px -10px rgba(37,211,102,.6); transition: transform .3s var(--ease); }
.wa:hover { transform: scale(1.06); }
.wa svg { width: 28px; height: 28px; fill: #fff; }

/* Mensajes y cargador */
.flash { padding: 14px 24px; text-align: center; font-weight: 600; font-size: 0.95rem; }
.flash.success { background: rgba(14,138,95,.1); color: var(--ok); }
.flash.info { background: var(--blue-50); color: var(--blue); }
.flash.error { background: rgba(192,54,44,.08); color: var(--bad); }
.loader { position: fixed; inset: 0; z-index: 500; display: none; place-items: center; background: rgba(255,255,255,.7); backdrop-filter: blur(2px); }
.loader.active { display: grid; }
.loader i { width: 44px; height: 44px; border-radius: 50%; border: 3px solid var(--line); border-top-color: var(--blue); animation: spin .8s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

@yield('styles')
</style>
</head>
<body>
<div class="loader" id="loader" aria-hidden="true"><i></i></div>

<header class="nav" id="nav">
  <div class="nav-in">
    <a href="{{ route('home') }}" class="nav-logo" aria-label="Romani Compliance, inicio"><img src="{{ asset('images/logos.png') }}" alt="Romani Compliance"></a>
    <nav class="nav-links" aria-label="Principal">
      <div class="nav-drop" id="navDrop">
        <button type="button" aria-expanded="false" aria-controls="navMega">Servicios <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg></button>
        <div class="nav-mega" id="navMega">
          @foreach($rcServices as $slug => $s)
            <a href="{{ route('services.show', $slug) }}">
              <span class="mi">@include('site.partials.icon', ['name' => $s['icon']])</span>
              <span><strong>{{ $s['short'] ?? $s['name'] }}</strong><span class="t">{{ $s['card'] }}</span></span>
            </a>
          @endforeach
        </div>
      </div>
      <a href="{{ route('capacitaciones') }}">Capacitación</a>
      <a href="{{ route('courses.catalog') }}">Cursos</a>
      <a href="{{ route('equipo') }}" class="{{ request()->routeIs('equipo') ? 'on' : '' }}">Equipo</a>
      <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'on' : '' }}">Publicaciones</a>
      <a href="{{ route('aprendizaje.index') }}">Aprendizaje</a>
    </nav>
    <div class="nav-actions">
      @auth
        <a href="{{ route('dashboard') }}" class="b b-ghost b-sm">Mi panel</a>
      @else
        <a href="{{ route('login') }}" class="b b-ghost b-sm">Ingresar</a>
      @endauth
      <a href="{{ route('home') }}#contacto" class="b b-dark b-sm">Agendar consulta</a>
    </div>
    <button class="nav-burger" type="button" aria-label="Abrir menú" aria-expanded="false" id="burger"><span></span></button>
  </div>
</header>

<div class="m-menu" id="mMenu">
  <div class="m-group">Servicios</div>
  @foreach($rcServices as $slug => $s)
    <a class="m-s" href="{{ route('services.show', $slug) }}">@include('site.partials.icon', ['name' => $s['icon']]) {{ $s['short'] ?? $s['name'] }}</a>
  @endforeach
  <div class="m-group">Firma</div>
  <a class="m-l" href="{{ route('capacitaciones') }}">Capacitación @include('site.partials.icon', ['name' => 'arrow'])</a>
  <a class="m-l" href="{{ route('courses.catalog') }}">Cursos @include('site.partials.icon', ['name' => 'arrow'])</a>
  <a class="m-l" href="{{ route('equipo') }}">Equipo @include('site.partials.icon', ['name' => 'arrow'])</a>
  <a class="m-l" href="{{ route('blog.index') }}">Publicaciones @include('site.partials.icon', ['name' => 'arrow'])</a>
  <a class="m-l" href="{{ route('aprendizaje.index') }}">Aprendizaje @include('site.partials.icon', ['name' => 'arrow'])</a>
  <div style="display:grid;gap:10px;margin-top:26px;">
    <a href="{{ route('home') }}#contacto" class="b b-dark">Agendar consulta</a>
    @auth<a href="{{ route('dashboard') }}" class="b b-ghost">Mi panel</a>@else<a href="{{ route('login') }}" class="b b-ghost">Ingresar</a>@endauth
  </div>
</div>

@foreach(['success', 'info', 'error'] as $flash)
  @if(session($flash))<div class="flash {{ $flash }}">{{ session($flash) }}</div>@endif
@endforeach

<main>@yield('content')</main>

<footer class="foot">
  <div class="wrap">
    <div class="foot-top">
      <div class="foot-brand">
        <img src="{{ asset('images/logos.png') }}" alt="Romani Compliance">
        <p>Compliance penal, prevención de lavado de activos y defensa penal económica. Lima, Perú.</p>
      </div>
      <div>
        <h4>Servicios</h4>
        @foreach($rcServices as $slug => $s)<a href="{{ route('services.show', $slug) }}">{{ $s['short'] ?? $s['name'] }}</a>@endforeach
      </div>
      <div>
        <h4>Firma</h4>
        <a href="{{ route('equipo') }}">Equipo</a>
        <a href="{{ route('blog.index') }}">Publicaciones</a>
        <a href="{{ route('capacitaciones') }}">Capacitación</a>
        <a href="{{ route('courses.catalog') }}">Cursos</a>
        <a href="{{ route('certificates.verify.form') }}">Verificar certificado</a>
      </div>
      <div>
        <h4>Contacto</h4>
        <a href="mailto:denis@romanicompliance.com">denis@romanicompliance.com</a>
        <a href="mailto:dromani@pucp.pe">dromani@pucp.pe</a>
        <a href="https://wa.me/{{ \App\Support\ServiceCatalog::WHATSAPP }}" target="_blank" rel="noopener">+51 969 754 983</a>
      </div>
    </div>
    <div class="foot-bot">
      <span>© {{ date('Y') }} Romani Compliance. Todos los derechos reservados.</span>
      <span>Programado y desarrollado por <a href="https://www.linkedin.com/in/angel-omar-oliden-pacherrez-086b12187/" target="_blank" rel="noopener noreferrer">Angel Oliden</a>.</span>
    </div>
  </div>
</footer>

<a href="https://wa.me/{{ \App\Support\ServiceCatalog::WHATSAPP }}?text={{ rawurlencode('Hola, quisiera hacer una consulta a Romani Compliance.') }}" class="wa" target="_blank" rel="noopener" aria-label="Escribir por WhatsApp">
  <svg viewBox="0 0 24 24"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.26-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.07c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35zM12.05 21.8h-.01a9.87 9.87 0 01-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 01-1.51-5.26C2.16 6.46 6.6 2.03 12.05 2.03c2.64 0 5.12 1.03 6.99 2.9a9.82 9.82 0 012.89 7c0 5.45-4.44 9.88-9.88 9.88zm8.41-18.3A11.82 11.82 0 0012.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 005.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.89 0-3.18-1.24-6.17-3.48-8.41z"/></svg>
</a>

<script>
// Utilidades del sitio (navegación, animaciones, líneas de tiempo, WhatsApp).
window.RC = (function () {
  const WA = @json(\App\Support\ServiceCatalog::WHATSAPP);
  const nav = document.getElementById('nav');
  addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 8), { passive: true });

  // Menú de servicios (escritorio) y menú móvil
  const drop = document.getElementById('navDrop');
  if (drop) {
    const btn = drop.querySelector('button');
    const set = (o) => { drop.classList.toggle('open', o); btn.setAttribute('aria-expanded', o); };
    btn.addEventListener('click', (e) => { e.stopPropagation(); set(!drop.classList.contains('open')); });
    drop.addEventListener('mouseenter', () => matchMedia('(hover:hover)').matches && set(true));
    drop.addEventListener('mouseleave', () => matchMedia('(hover:hover)').matches && set(false));
    document.addEventListener('click', () => set(false));
    document.addEventListener('keydown', (e) => e.key === 'Escape' && set(false));
  }
  const burger = document.getElementById('burger');
  burger.addEventListener('click', () => {
    const o = !document.body.classList.contains('menu-open');
    document.body.classList.toggle('menu-open', o);
    burger.setAttribute('aria-expanded', o);
    document.body.style.overflow = o ? 'hidden' : '';
  });
  document.querySelectorAll('#mMenu a').forEach((a) => a.addEventListener('click', () => { document.body.classList.remove('menu-open'); document.body.style.overflow = ''; }));

  // Aparición al hacer scroll
  const io = new IntersectionObserver((es) => es.forEach((e) => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } }), { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  const observe = (root) => (root || document).querySelectorAll('.rv:not(.in)').forEach((el) => io.observe(el));
  observe();

  // Líneas de tiempo: la barra azul avanza con el scroll y enciende cada paso
  const timelines = [...document.querySelectorAll('.tl')];
  function paintTimelines() {
    const mid = innerHeight * 0.62;
    timelines.forEach((tl) => {
      const r = tl.getBoundingClientRect();
      const h = Math.max(0, Math.min(r.height - 16, mid - r.top));
      const fill = tl.querySelector('.tl-fill');
      if (fill) fill.style.height = h + 'px';
      tl.querySelectorAll('.tl-step').forEach((s) => s.classList.toggle('lit', s.getBoundingClientRect().top + 24 < mid));
    });
  }
  if (timelines.length) { addEventListener('scroll', paintTimelines, { passive: true }); addEventListener('resize', paintTimelines); paintTimelines(); }

  // Cargador al navegar dentro del sitio
  const loader = document.getElementById('loader');
  document.addEventListener('click', (e) => {
    if (e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey) return;
    const a = e.target.closest('a[href]');
    if (!a || a.target === '_blank' || a.hasAttribute('data-no-loader')) return;
    const href = a.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
    let u; try { u = new URL(href, location.href); } catch (_) { return; }
    if (u.origin !== location.origin || (u.pathname === location.pathname && u.hash)) return;
    loader.classList.add('active');
  }, true);
  addEventListener('pageshow', () => loader.classList.remove('active'));

  return {
    observe,
    wa: (text) => 'https://wa.me/' + WA + '?text=' + encodeURIComponent(text),
    // Anima un indicador circular (.gauge) hasta un porcentaje
    gauge(el, pct, color) {
      const c = el.querySelector('.val'); const len = 2 * Math.PI * 88;
      c.style.strokeDasharray = len; c.style.strokeDashoffset = len;
      if (color) c.style.stroke = color;
      requestAnimationFrame(() => requestAnimationFrame(() => { c.style.strokeDashoffset = len * (1 - pct / 100); }));
      const b = el.querySelector('.num b'); let t0 = null;
      const step = (t) => { t0 = t0 || t; const k = Math.min(1, (t - t0) / 1200); b.textContent = Math.round(pct * (1 - Math.pow(1 - k, 3))); if (k < 1) requestAnimationFrame(step); };
      requestAnimationFrame(step);
    },
  };
})();
</script>
@yield('scripts')
</body>
</html>
