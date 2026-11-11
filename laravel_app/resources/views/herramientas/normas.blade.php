@extends('layouts.site')

@section('title', 'Buscador de normas LA/FT del Perú: resoluciones SBS, UIF y leyes · Romani Compliance')
@section('description', 'Busque por número, tema o sujeto obligado las normas peruanas de prevención del lavado de activos y del financiamiento del terrorismo, con enlace directo a la norma original en el Diario Oficial El Peruano.')
@section('og_image', asset('images/og-herramientas.jpg'))

@php
  $tipoCorto = ['Resolución SBS' => 'Res. SBS', 'Decreto Supremo' => 'D. S.', 'Decreto Legislativo' => 'D. Leg.', 'Ley' => 'Ley'];
  $js = $normas->map(fn ($n) => [
      'id' => $n['id'], 'tipo' => $n['tipo'], 'corto' => $tipoCorto[$n['tipo']] ?? $n['tipo'], 'numero' => $n['numero'],
      'emisor' => $n['emisor'] ?? '', 'fecha' => $n['fecha'] ?? '', 'iso' => $n['fecha_iso'] ?? '', 'anio' => $n['anio'] ?? null,
      'titulo' => $n['titulo'], 'resumen' => $n['resumen'], 'ambito' => $n['ambito'], 'temas' => $n['temas'],
      'mod' => $n['modificada_por'], 'rel' => $n['relacionadas'] ?? [], 'url' => $n['enlace'], 'pdf' => $n['pdf'] ?? '',
      'fuente' => $n['fuente'], 'edicion' => $n['edicion'] ?? '',
  ])->values();
@endphp

@section('og_extra')
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'WebApplication',
      'name' => 'Buscador de normas LA/FT',
      'url' => route('herramientas.normas'),
      'applicationCategory' => 'BusinessApplication',
      'operatingSystem' => 'Web',
      'inLanguage' => 'es-PE',
      'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'PEN'],
      'publisher' => ['@type' => 'Organization', 'name' => 'Romani Compliance', 'url' => url('/')],
      'potentialAction' => ['@type' => 'SearchAction', 'target' => route('herramientas.normas').'?q={search_term_string}', 'query-input' => 'required name=search_term_string'],
    ],
    [
      '@type' => 'Dataset',
      'name' => 'Normas peruanas de prevención LA/FT',
      'description' => 'Resoluciones SBS, decretos supremos, decretos legislativos y leyes peruanas de prevención del lavado de activos y del financiamiento del terrorismo, con enlace a la norma original publicada en el Diario Oficial El Peruano.',
      'url' => route('herramientas.normas'),
      'inLanguage' => 'es-PE',
      'creator' => ['@type' => 'Organization', 'name' => 'Romani Compliance', 'url' => url('/')],
      'dateModified' => $updated,
      'hasPart' => $normas->map(fn ($n) => array_filter(['@type' => 'Legislation', 'name' => $n['tipo'].' N.° '.$n['numero'], 'alternateName' => $n['titulo'], 'legislationIdentifier' => $n['tipo'].' '.$n['numero'], 'legislationDate' => $n['fecha_iso'] ?? null, 'url' => $n['enlace'], 'legislationJurisdiction' => 'PE'])) ->values()->all(),
    ],
  ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('styles')
.ns-hero { background: var(--ink); color: #fff; padding: clamp(40px, 6vw, 76px) 0 clamp(34px, 5vw, 56px); transition: padding .35s var(--ease); }
.ns-hero.compact { padding: 26px 0 26px; }
.ns-hero .lead { color: rgba(255,255,255,.72); margin: 14px 0 26px; max-width: 700px; }
.ns-hero.compact .kicker, .ns-hero.compact h1, .ns-hero.compact .lead { display: none; }
.ns-box { position: relative; max-width: 860px; }
.ns-field { position: relative; }
.ns-field input { width: 100%; padding: 21px 118px 21px 60px; border-radius: 20px; border: 0; font: inherit; font-size: 1.14rem; font-weight: 600; color: var(--ink); background: #fff; box-shadow: 0 30px 60px -30px rgba(0,0,0,.6); }
.ns-field input::-webkit-search-cancel-button { -webkit-appearance: none; }
.ns-field input:focus { outline: 3px solid var(--blue-l); outline-offset: 2px; }
.ns-field > svg { position: absolute; left: 21px; top: 50%; transform: translateY(-50%); width: 24px; height: 24px; color: var(--muted-2); pointer-events: none; }
.ns-go { position: absolute; right: 9px; top: 50%; transform: translateY(-50%); border: 0; background: var(--blue); color: #fff; font: inherit; font-weight: 800; padding: 12px 18px; border-radius: 14px; cursor: pointer; }
.ns-go:hover { background: #1A43BC; }
.ns-clear { position: absolute; right: 112px; top: 50%; transform: translateY(-50%); border: 0; background: transparent; color: var(--muted-2); font-size: 1.5rem; line-height: 1; padding: 6px 10px; cursor: pointer; }
@media (max-width: 560px) { .ns-field input { padding: 18px 54px 18px 50px; font-size: 1rem; } .ns-go { padding: 10px 12px; font-size: 0; } .ns-go::after { content: '→'; font-size: 1.1rem; } .ns-clear { right: 50px; } .ns-field > svg { left: 16px; } }
.ns-ac { position: absolute; left: 0; right: 0; top: calc(100% + 8px); z-index: 30; background: #fff; color: var(--ink); border-radius: 18px; box-shadow: 0 30px 70px -20px rgba(10,23,48,.55); padding: 6px; max-height: 420px; overflow: auto; }
.ns-ac [role="option"] { display: flex; gap: 12px; align-items: baseline; padding: 10px 12px; border-radius: 12px; cursor: pointer; }
.ns-ac [role="option"][aria-selected="true"], .ns-ac [role="option"]:hover { background: var(--soft); }
.ns-ac .k { flex-shrink: 0; font-weight: 800; font-size: .86rem; color: var(--blue); min-width: 128px; }
.ns-ac .k.t { color: var(--muted); font-weight: 700; }
.ns-ac .v { font-size: .92rem; color: var(--muted); overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; }
.ns-ac .v b, .ns-ac .k b { color: var(--ink); }
.ns-ac .hd { font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--muted-2); padding: 8px 12px 4px; }
@media (max-width: 560px) { .ns-ac .k { min-width: 0; } .ns-ac [role="option"] { flex-direction: column; gap: 2px; } }
.ns-try { margin-top: 16px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; font-size: .86rem; color: rgba(255,255,255,.6); }
.ns-try button { border: 1px solid rgba(255,255,255,.2); background: rgba(255,255,255,.06); color: #fff; font: inherit; font-weight: 600; font-size: .84rem; padding: 6px 12px; border-radius: 999px; cursor: pointer; }
.ns-try button:hover { background: rgba(255,255,255,.14); }
.ns-hero.compact .ns-try { display: none; }

.ns-main { padding: 28px 0 80px; min-height: 40vh; }
.ns-explore h2 { font-size: 1.05rem; font-weight: 800; margin-bottom: 14px; }
.ns-tiles { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
@media (max-width: 900px) { .ns-tiles { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 520px) { .ns-tiles { grid-template-columns: 1fr; } }
.ns-tile { text-align: left; border: 1px solid var(--line); background: #fff; border-radius: 18px; padding: 16px 18px; font: inherit; cursor: pointer; transition: border-color .2s, transform .25s var(--ease), box-shadow .25s; }
.ns-tile:hover { border-color: var(--blue); transform: translateY(-2px); box-shadow: 0 16px 34px -26px rgba(10,23,48,.5); }
.ns-tile b { display: block; font-size: 1rem; font-weight: 800; }
.ns-tile span { display: block; color: var(--muted); font-size: .88rem; margin-top: 3px; }
.ns-recent { margin-top: 34px; }
.ns-recent ol { list-style: none; padding: 0; margin: 0; display: grid; gap: 2px; border-top: 1px solid var(--line); }
.ns-recent li { display: grid; grid-template-columns: 200px 1fr auto; gap: 14px; align-items: baseline; padding: 12px 2px; border-bottom: 1px solid var(--line); }
.ns-recent li b { font-weight: 800; font-size: .92rem; white-space: nowrap; }
.ns-recent li span { color: var(--muted); font-size: .93rem; }
.ns-recent li a { color: var(--blue); font-weight: 700; font-size: .88rem; white-space: nowrap; }
@media (max-width: 640px) { .ns-recent li { grid-template-columns: 1fr; gap: 2px; } }

.ns-bar { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; margin-bottom: 16px; }
.ns-stat { color: var(--muted); font-size: .92rem; font-weight: 600; margin-right: auto; }
.ns-stat b { color: var(--ink); }
.ns-bar button { border: 1px solid var(--line); background: #fff; font: inherit; font-weight: 700; font-size: .84rem; color: var(--muted); padding: 7px 12px; border-radius: 999px; cursor: pointer; }
.ns-bar button[aria-pressed="true"] { background: var(--ink); border-color: var(--ink); color: #fff; }
.ns-bar button .c { opacity: .6; margin-left: 4px; font-weight: 600; }
.ns-bar select { padding: 8px 12px; border: 1px solid var(--line); border-radius: 12px; font: inherit; font-size: .86rem; background: #fff; }
.ns-list { display: grid; gap: 12px; }
.ns-r { border: 1px solid var(--line); border-radius: 22px; background: #fff; padding: 20px 22px; transition: border-color .25s, box-shadow .25s; scroll-margin-top: 110px; }
.ns-r:hover { border-color: #C9D3E6; box-shadow: 0 16px 36px -28px rgba(10,23,48,.45); }
.ns-r.top { border-color: var(--blue); box-shadow: 0 20px 44px -30px rgba(31,79,216,.6); }
.ns-r .hd { display: flex; gap: 8px 12px; flex-wrap: wrap; align-items: center; }
.ns-r .id { font-size: 1.12rem; font-weight: 800; letter-spacing: -0.015em; }
.ns-r .tp { font-size: .74rem; font-weight: 800; color: var(--blue); background: #EEF3FF; padding: 3px 9px; border-radius: 999px; text-transform: uppercase; letter-spacing: .04em; }
.ns-r .dt { color: var(--muted); font-size: .86rem; }
.ns-r .best { font-size: .74rem; font-weight: 800; color: #0E8A5F; background: #E1F3EC; padding: 3px 9px; border-radius: 999px; }
.ns-r h3 { font-size: 1.02rem; font-weight: 700; line-height: 1.45; margin-top: 8px; color: var(--ink); }
.ns-r p { color: var(--muted); font-size: .94rem; margin-top: 6px; line-height: 1.6; }
.ns-r .meta { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 10px; }
.ns-r .meta span, .ns-r .meta button { font: inherit; font-size: .78rem; font-weight: 700; padding: 4px 10px; border-radius: 999px; background: var(--soft); color: var(--muted); border: 0; }
.ns-r .meta button { cursor: pointer; background: #FBEBDD; color: #8A3B0B; }
.ns-r .meta button.rl { background: #EEF3FF; color: var(--blue); }
.ns-r .meta button:hover { filter: brightness(.96); text-decoration: underline; }
.ns-acts { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-top: 14px; }
.ns-acts a.pri { display: inline-flex; align-items: center; gap: 6px; background: var(--ink); color: #fff; font-weight: 800; font-size: .88rem; padding: 9px 14px; border-radius: 12px; }
.ns-acts a.pri:hover { background: var(--blue); }
.ns-acts a.sec, .ns-acts button.sec { display: inline-flex; align-items: center; gap: 6px; border: 1px solid var(--line); background: #fff; color: var(--ink); font: inherit; font-weight: 700; font-size: .86rem; padding: 8px 12px; border-radius: 12px; cursor: pointer; }
.ns-acts a.sec:hover, .ns-acts button.sec:hover { border-color: var(--blue); color: var(--blue); }
.ns-acts small { color: var(--muted-2); font-size: .8rem; margin-left: auto; }
@media (max-width: 640px) { .ns-r { padding: 18px; } .ns-acts small { margin-left: 0; width: 100%; } }
mark { background: #FFF1B8; color: inherit; border-radius: 3px; padding: 0 1px; }
.ns-none { text-align: center; padding: 34px 20px; border: 1px dashed #C9D3E6; border-radius: 22px; background: #fff; color: var(--muted); }
.ns-none b { color: var(--ink); display: block; font-size: 1.05rem; margin-bottom: 6px; }
.ns-ep { margin-top: 28px; }
.ns-ep h2 { font-size: 1rem; font-weight: 800; display: flex; gap: 10px; align-items: center; margin-bottom: 12px; }
.ns-ep h2 small { font-weight: 600; color: var(--muted); font-size: .86rem; }
.ns-ep ul { list-style: none; margin: 0; padding: 0; border: 1px solid var(--line); border-radius: 20px; background: #fff; overflow: hidden; }
.ns-ep li { padding: 14px 18px; border-bottom: 1px solid var(--line); display: grid; grid-template-columns: 1fr auto; gap: 4px 14px; align-items: baseline; }
.ns-ep li:last-child { border-bottom: 0; }
.ns-ep li .n { font-weight: 800; font-size: .94rem; }
.ns-ep li .n em { font-style: normal; font-weight: 600; color: var(--muted); font-size: .84rem; margin-left: 6px; }
.ns-ep li .s { grid-column: 1; color: var(--muted); font-size: .9rem; }
.ns-ep li a { grid-row: 1 / span 2; grid-column: 2; align-self: center; color: var(--blue); font-weight: 800; font-size: .88rem; white-space: nowrap; }
@media (max-width: 560px) { .ns-ep li { grid-template-columns: 1fr; } .ns-ep li a { grid-row: auto; grid-column: 1; } }
.ns-spin { width: 16px; height: 16px; border-radius: 50%; border: 2px solid #C9D3E6; border-top-color: var(--blue); animation: nsspin .8s linear infinite; display: inline-block; }
@keyframes nsspin { to { transform: rotate(360deg); } }
.ns-out { margin-top: 18px; font-size: .9rem; color: var(--muted); }
.ns-out a { color: var(--blue); font-weight: 700; }
.ns-note { margin-top: 34px; padding: 18px 20px; border-radius: 18px; background: var(--soft); color: var(--muted); font-size: .88rem; line-height: 1.6; }
.ns-note a { color: var(--blue); font-weight: 700; }
@endsection

@section('content')
<section class="ns-hero" id="nshero">
  <div class="wrap">
    <div class="kicker rv"><a href="{{ route('herramientas') }}" style="color:inherit">Herramientas</a></div>
    <h1 class="display rv">Buscador de normas LA/FT</h1>
    <p class="lead rv">Escriba un número, un tema o el tipo de empresa. Le llevamos directo a la norma original publicada en el Diario Oficial El Peruano.</p>
    <form class="ns-box" id="nsform" role="search" action="{{ route('herramientas.normas') }}" method="get" autocomplete="off">
      <div class="ns-field">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
        <input id="nq" name="q" type="search" value="{{ $initial }}" placeholder="Ej.: 2660-2015, regla de viaje, inmobiliarias, Ley 30424" aria-label="Buscar normas LA/FT" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="nsac" spellcheck="false">
        <button type="button" class="ns-clear" id="nsclear" aria-label="Borrar búsqueda" hidden>×</button>
        <button type="submit" class="ns-go">Buscar</button>
      </div>
      <div class="ns-ac" id="nsac" role="listbox" hidden></div>
    </form>
    <div class="ns-try">Búsquedas frecuentes: @foreach(['2660-2015', 'oficial de cumplimiento', 'regla de viaje', 'beneficiario final', 'congelamiento', 'Ley 30424'] as $ex)<button type="button" data-q="{{ $ex }}">{{ $ex }}</button>@endforeach</div>
  </div>
</section>

<section class="ns-main">
  <div class="wrap">
    <div id="nsexplore" class="ns-explore">
      <h2>Explore por tipo de sujeto obligado</h2>
      <div class="ns-tiles">
        <button type="button" class="ns-tile" data-q="bancos seguros AFP"><b>Bancos, seguros y AFP</b><span>Gestión de riesgos LA/FT y registro de operaciones</span></button>
        <button type="button" class="ns-tile" data-q="PSAV"><b>Activos virtuales (PSAV)</b><span>Exchanges, billeteras y regla de viaje</span></button>
        <button type="button" class="ns-tile" data-q="casinos apuestas"><b>Casinos y apuestas</b><span>Tragamonedas y apuestas deportivas a distancia</span></button>
        <button type="button" class="ns-tile" data-q="sujetos obligados supervisados UIF"><b>Supervisados por la UIF</b><span>Inmobiliarias, casas de cambio, joyerías y otros</span></button>
        <button type="button" class="ns-tile" data-q="notarios"><b>Notarios</b><span>Norma notarial y OCP LA/FT</span></button>
        <button type="button" class="ns-tile" data-q="modelo de prevención"><b>Personas jurídicas</b><span>Ley 30424 y modelo de prevención</span></button>
      </div>
      <div class="ns-recent">
        <h2>Últimas normas publicadas</h2>
        <ol>
          @foreach($normas->take(5) as $n)
            <li><b>{{ $tipoCorto[$n['tipo']] ?? $n['tipo'] }} N.° {{ $n['numero'] }}</b><span>{{ \Illuminate\Support\Str::limit($n['titulo'], 120) }} · {{ $n['fecha'] ?? '' }}</span><a href="{{ $n['enlace'] }}" target="_blank" rel="noopener">Ver original ↗</a></li>
          @endforeach
        </ol>
      </div>
    </div>

    <div id="nsres" hidden>
      <div class="ns-bar" id="nsbar">
        <span class="ns-stat" id="nsstat"></span>
        <span id="nstipos"></span>
        <select id="nssort" aria-label="Ordenar"><option value="rel">Más relevantes</option><option value="new">Más recientes</option></select>
      </div>
      <div class="ns-list" id="nslist" aria-live="polite"></div>
      <div class="ns-none" id="nsnone" hidden></div>
      <div class="ns-ep" id="nsep" hidden></div>
      <p class="ns-out" id="nsout"></p>
    </div>

    <noscript>
      <div class="ns-list">
        @foreach($normas as $n)<div class="ns-r"><div class="hd"><span class="id">{{ $n['tipo'] }} N.° {{ $n['numero'] }}</span><span class="dt">{{ $n['fecha'] ?? '' }}</span></div><h3>{{ $n['titulo'] }}</h3><div class="ns-acts"><a class="pri" href="{{ $n['enlace'] }}">Ver norma original</a></div></div>@endforeach
      </div>
    </noscript>

    <div class="ns-note"><b>Fuentes oficiales.</b> Cada resultado abre la norma tal como se publicó en el <a href="https://busquedas.elperuano.pe" target="_blank" rel="noopener">Diario Oficial El Peruano</a> (o en la Plataforma del Estado Peruano), con su PDF oficial. El catálogo se revisó el {{ $updated ? \Carbon\Carbon::parse($updated)->translatedFormat('j \d\e F \d\e Y') : '—' }}; las normas posteriores se buscan en vivo en El Peruano cuando escribe un número. Las fichas resumen la norma: antes de aplicarla, confirme su texto vigente y sus modificatorias. ¿Necesita saber cuáles le aplican a su empresa? <a href="{{ \App\Support\ServiceCatalog::whatsapp('Hola, quisiera saber qué normas LA/FT le aplican a mi empresa.') }}" target="_blank" rel="noopener">Consúltenos</a>.</div>
  </div>
</section>
@endsection

@section('scripts')
<script>
(function () {
  const DATA = @json($js);
  const EP_API = @json(route('herramientas.normas.elperuano'));
  const $ = (id) => document.getElementById(id);
  const input = $('nq'), ac = $('nsac'), hero = $('nshero');
  const norm = (s) => String(s || '').normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();
  const esc = (s) => String(s).replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
  const STOP = new Set(['de', 'la', 'el', 'los', 'las', 'y', 'e', 'en', 'para', 'del', 'a', 'por', 'con', 'que', 'al', 'sobre', 'n', 'no', 'nro', 'num', 'numero', 'norma', 'normas', 'aplicable', 'se', 'su', 'sus', 'o', 'u']);
  // Palabras que la gente escribe y cómo aparecen en las normas
  const SYN = { cripto: ['psav', 'criptoactivos'], criptoactivos: ['psav'], criptomonedas: ['psav', 'criptoactivos'], bitcoin: ['psav', 'criptoactivos'], exchange: ['psav'], exchanges: ['psav'], kyc: ['debida', 'diligencia', 'conocimiento'], travel: ['regla', 'viaje'], ros: ['sospechosas'], banco: ['bancos'], aseguradoras: ['seguros'], inmobiliaria: ['inmobiliarias'], notaria: ['notarios'], notarias: ['notarios'], notario: ['notarios'], casino: ['casinos'], apuesta: ['apuestas'], tragamoneda: ['tragamonedas'], compliance: ['compliance', 'modelo', 'prevencion'], sanciones: ['sanciones', 'infracciones'], multas: ['sanciones', 'infracciones'], oc: ['oficial', 'cumplimiento'], uif: ['uif'] };
  const TYPE_ALIAS = [[/\b(res(olucion)?\.?\s*sbs|r\.?\s*sbs)\b/, 'Resolución SBS'], [/\b(decreto\s+supremo|d\.?\s*s\.?)\b/, 'Decreto Supremo'], [/\b(decreto\s+legislativo|d\.?\s*leg(islativo)?\.?|dl)\b/, 'Decreto Legislativo'], [/\bley\b/, 'Ley']];
  const lev = (a, b) => { if (Math.abs(a.length - b.length) > 2) return 9; const d = Array.from({ length: a.length + 1 }, (_, i) => { const r = new Array(b.length + 1).fill(0); r[0] = i; return r; }); for (let j = 0; j <= b.length; j++) d[0][j] = j; for (let i = 1; i <= a.length; i++) for (let j = 1; j <= b.length; j++) { d[i][j] = Math.min(d[i - 1][j] + 1, d[i][j - 1] + 1, d[i - 1][j - 1] + (a[i - 1] === b[j - 1] ? 0 : 1)); if (i > 1 && j > 1 && a[i - 1] === b[j - 2] && a[i - 2] === b[j - 1]) d[i][j] = Math.min(d[i][j], d[i - 2][j - 2] + 1); } return d[a.length][b.length]; };
  const near = (a, w) => a.length >= 5 && w.length >= 5 && Math.min(lev(a, w), lev(a, w.slice(0, a.length))) <= (a.length >= 9 ? 2 : 1);
  const words = (s) => norm(s).split(/[^a-z0-9]+/).filter(Boolean);
  const byId = Object.fromEntries(DATA.map((n) => [n.id, n]));
  const label = (n) => n.corto + ' N.° ' + n.numero;

  // Índice por campo, con peso: número > título > temas > ámbito > resumen
  const IDX = DATA.map((n) => {
    const numParts = norm(n.numero).split(/[^a-z0-9]+/).filter(Boolean);
    return { n, numParts, numFlat: norm(n.numero).replace(/^0+/, ''), f: [
      { w: 9, t: words(n.titulo) }, { w: 8, t: words(n.temas.join(' ')) }, { w: 5, t: words(n.ambito + ' ' + n.emisor) }, { w: 3, t: words(n.resumen) },
      { w: 4, t: words(n.tipo + ' ' + n.corto) },
    ] };
  });

  function parse(raw) {
    const q = norm(raw).trim();
    const nums = [...q.matchAll(/\b(\d{1,6})(?:\s*-\s*(\d{4}))?(?:\s*-\s*([a-z]{2,8}))?\b/g)].map((m) => ({ a: m[1].replace(/^0+/, ''), y: m[2] || null, s: m[3] || null }));
    let tipo = null; for (const [re, t] of TYPE_ALIAS) if (re.test(q)) { tipo = t; break; }
    const rest = q.replace(/\b\d{1,6}(\s*-\s*\d{4})?(\s*-\s*[a-z]{2,8})?\b/g, ' ').replace(/\b(res(olucion)?|sbs|decreto|supremo|legislativo|leg|ds|dl|ley|r|s|d)\b\.?/g, ' ');
    const toks = words(rest).filter((w) => !STOP.has(w) && w.length > 1);
    return { q, nums, tipo, toks };
  }

  function tokenScore(it, tok, isLast) {
    let best = 0;
    const alts = [tok, ...(SYN[tok] || [])];
    for (const f of it.f) for (const w of f.t) for (const a of alts) {
      let s = 0;
      if (w === a) s = f.w;
      else if (w.startsWith(a) && a.length >= 3) s = f.w * (isLast ? 0.9 : 0.75);
      else if (near(a, w)) s = f.w * 0.6;
      if (s > best) best = s;
    }
    return best;
  }

  function search(raw) {
    const P = parse(raw);
    if (!P.q) return { P, list: [] };
    const out = [];
    for (const it of IDX) {
      let s = 0, need = 0, got = 0;
      for (const nm of P.nums) {
        need++;
        const head = it.numParts[0] ? it.numParts[0].replace(/^0+/, '') : '';
        const year = it.numParts[1] || '';
        if (head === nm.a && (!nm.y || year === nm.y)) { s += nm.y ? 120 : 80; got++; }
        else if (!nm.y && nm.a.length >= 3 && (head.startsWith(nm.a) || (year === nm.a && nm.a.length === 4))) { s += nm.a.length === 4 && year === nm.a ? 12 : 30; got++; }
        else if ([it.n.titulo, it.n.resumen].some((t) => norm(t).replace(/\b0+(\d)/g, '$1').includes(nm.a + (nm.y ? '-' + nm.y : '')))) { s += 25; got++; }
      }
      if (P.tipo) { if (it.n.tipo === P.tipo) s += P.nums.length ? 20 : 15; else if (P.nums.length) s -= 40; }
      const last = P.toks.length - 1;
      P.toks.forEach((t, i) => { need++; const v = tokenScore(it, t, i === last); if (v > 0) { s += v; got++; } });
      if (!need && P.tipo) { if (it.n.tipo === P.tipo) out.push({ n: it.n, s: 10 + (it.n.anio || 0) / 1e4, full: true }); continue; }
      if (got === 0) continue;
      const full = got === need;
      // Exige que coincidan todas las palabras; si ninguna norma lo cumple, se muestran las más cercanas
      out.push({ n: it.n, s: s * (full ? 1 : 0.35 * (got / need)), full });
    }
    let list = out.filter((r) => r.full);
    const partial = !list.length;
    if (partial) list = out.filter((r) => r.s >= 6);
    list.sort((a, b) => b.s - a.s || (b.n.iso || '').localeCompare(a.n.iso || ''));
    // Al buscar una norma por su número, se suman las que la modifican, reglamentan o desarrollan
    if (P.nums.length && list.length && list[0].s >= 80) {
      const have = new Set(list.map((r) => r.n.id)), base = list[0].n;
      const rel = [...base.mod, ...base.rel, ...DATA.filter((o) => o.mod.includes(base.id) || o.rel.includes(base.id)).map((o) => o.id)];
      rel.forEach((id) => { if (byId[id] && !have.has(id)) { have.add(id); list.push({ n: byId[id], s: 1, full: true, rel: true }); } });
    }
    return { P, list, partial };
  }

  function hl(text, P) {
    const terms = new Set(P.toks.flatMap((t) => [t, ...(SYN[t] || [])]).filter((t) => t.length >= 2));
    const nums = P.nums.map((x) => x.a);
    return esc(text).replace(/[A-Za-zÀ-ÿ0-9]+(?:-\d{4})?/g, (w) => {
      const n = norm(w);
      const hit = [...terms].some((t) => n.startsWith(t) || near(t, n)) || nums.some((x) => n.replace(/^0+/, '').split('-')[0] === x);
      return hit ? '<mark>' + w + '</mark>' : w;
    });
  }

  const state = { tipo: '', sort: 'rel', last: null };
  const TIPOS = ['Resolución SBS', 'Decreto Supremo', 'Decreto Legislativo', 'Ley'];
  const TIPOS_PL = { 'Resolución SBS': 'Resoluciones SBS', 'Decreto Supremo': 'Decretos supremos', 'Decreto Legislativo': 'Decretos legislativos', 'Ley': 'Leyes' };

  function card(n, P, top) {
    const chips = [], used = new Set([n.id]);
    const add = (id, cls, txt) => { if (byId[id] && !used.has(id)) { used.add(id); chips.push('<button type="button"' + (cls ? ' class="' + cls + '"' : '') + ' data-go="' + esc(id) + '">' + txt + esc(label(byId[id])) + '</button>'); } };
    n.mod.forEach((id) => add(id, '', 'Modificada por '));
    DATA.forEach((o) => { if (o.mod.includes(n.id)) add(o.id, 'rl', 'Modifica la '); });
    n.rel.forEach((id) => add(id, 'rl', 'Ver '));
    return '<article class="ns-r' + (top ? ' top' : '') + '" id="n-' + esc(n.id) + '">'
      + '<div class="hd"><span class="tp">' + esc(n.tipo) + '</span><span class="id">N.° ' + hl(n.numero, P) + '</span><span class="dt">' + esc(n.fecha) + (n.edicion ? ' · ' + esc(n.edicion) : '') + '</span>' + (top ? '<span class="best">Mejor coincidencia</span>' : '') + '</div>'
      + '<h3>' + hl(n.titulo, P) + '</h3>'
      + '<p>' + hl(n.resumen, P) + '</p>'
      + '<div class="meta"><span>' + hl(n.ambito, P) + '</span>' + chips.join('') + '</div>'
      + '<div class="ns-acts"><a class="pri" href="' + esc(n.url) + '" target="_blank" rel="noopener">Ver norma original ↗</a>'
      + (n.pdf ? '<a class="sec" href="' + esc(n.pdf) + '" target="_blank" rel="noopener">PDF oficial ↗</a>' : '')
      + '<button type="button" class="sec" data-copy="' + esc(n.url) + '">Copiar enlace</button>'
      + '<small>' + esc(n.fuente) + '</small></div></article>';
  }

  let epTimer = null, epCtl = null;
  function render(push) {
    const raw = input.value.trim();
    $('nsclear').hidden = !raw;
    if (!raw) {
      $('nsres').hidden = true; $('nsexplore').hidden = false; hero.classList.remove('compact');
      history.replaceState(null, '', location.pathname); return;
    }
    const t0 = performance.now();
    const { P, list, partial } = search(raw);
    const ms = Math.max(1, Math.round(performance.now() - t0));
    state.last = list;
    $('nsexplore').hidden = true; $('nsres').hidden = false; hero.classList.add('compact');

    const counts = {}; list.forEach((r) => { counts[r.n.tipo] = (counts[r.n.tipo] || 0) + 1; });
    if (state.tipo && !counts[state.tipo]) state.tipo = '';
    $('nstipos').innerHTML = list.length && Object.keys(counts).length > 1 ? ['<button type="button" data-tipo="" aria-pressed="' + !state.tipo + '">Todas<span class="c">' + list.length + '</span></button>'].concat(TIPOS.filter((t) => counts[t]).map((t) => '<button type="button" data-tipo="' + esc(t) + '" aria-pressed="' + (state.tipo === t) + '">' + TIPOS_PL[t] + '<span class="c">' + counts[t] + '</span></button>')).join(' ') : '';
    let shown = list.filter((r) => !state.tipo || r.n.tipo === state.tipo);
    if (state.sort === 'new') shown = shown.slice().sort((a, b) => (b.n.iso || '').localeCompare(a.n.iso || ''));
    $('nssort').hidden = shown.length < 2;

    $('nsstat').innerHTML = list.length ? '<b>' + list.length + '</b> ' + (list.length === 1 ? 'norma' : 'normas') + (partial ? ' parecidas' : '') + ' · ' + ms + ' ms' : '';
    const strong = shown.length && state.sort === 'rel' && !state.tipo && (shown.length === 1 || shown[0].s >= 80 || shown[0].s > shown[1].s * 1.6);
    $('nslist').innerHTML = shown.map((r, i) => card(r.n, P, strong && i === 0)).join('');
    const none = $('nsnone');
    none.hidden = list.length > 0;
    if (!list.length) none.innerHTML = '<b>No hay normas en el catálogo para «' + esc(raw) + '».</b>Pruebe con otra palabra, un sinónimo o solo el número (por ejemplo, «2660»).' + (P.nums.length ? ' Abajo buscamos ese número en el Diario Oficial El Peruano.' : '');
    $('nsout').innerHTML = 'Buscar «' + esc(raw) + '» en todo el <a href="https://busquedas.elperuano.pe/?' + new URLSearchParams({ query: raw, start: 0, ci: 'all' }) + '" target="_blank" rel="noopener">Diario Oficial El Peruano ↗</a>';
    if (push) history.replaceState(null, '', '?q=' + encodeURIComponent(raw));

    // Números: además se consulta en vivo El Peruano, por si la norma es nueva o no está en el catálogo
    clearTimeout(epTimer); if (epCtl) epCtl.abort();
    const ep = $('nsep');
    if (!P.nums.some((x) => x.a.length >= 3) || raw.length < 3) { ep.hidden = true; return; }
    ep.hidden = false;
    ep.innerHTML = '<h2><span class="ns-spin"></span> Buscando en el Diario Oficial El Peruano…</h2>';
    epTimer = setTimeout(() => {
      epCtl = new AbortController();
      fetch(EP_API + '?q=' + encodeURIComponent(raw), { signal: epCtl.signal, headers: { Accept: 'application/json' } })
        .then((r) => r.json())
        .then((d) => {
          if (input.value.trim() !== raw) return;
          const known = new Set(DATA.map((n) => n.url.replace(/\/(NL|SE|EX|BO)\//, '/')));
          const rows = (d.results || []).filter((x) => !known.has(x.url.replace(/\/(NL|SE|EX|BO)\//, '/')));
          if (!rows.length && !d.error && !$('nsnone').hidden) { ep.hidden = false; ep.innerHTML = '<h2>Tampoco encontramos ese número en la primera página del Diario Oficial El Peruano. <small><a href="' + esc(d.url) + '" target="_blank" rel="noopener" style="color:var(--blue)">Ver la búsqueda completa allí ↗</a></small></h2>'; return; }
          if (!rows.length) { ep.hidden = !d.error; ep.innerHTML = d.error ? '<h2>El Diario Oficial El Peruano no respondió a tiempo. <small><a href="' + esc(d.url) + '" target="_blank" rel="noopener" style="color:var(--blue)">Abrir la búsqueda allí ↗</a></small></h2>' : ''; return; }
          ep.innerHTML = '<h2>También en el Diario Oficial El Peruano <small>' + rows.length + ' ' + (rows.length === 1 ? 'resultado' : 'resultados') + ' en vivo</small></h2><ul>'
            + rows.map((x) => '<li><span class="n">' + esc(x.tipo) + ' N.° ' + hl(x.numero, P) + '<em>' + esc(x.entidad) + ' · ' + esc(x.fecha) + '</em></span><span class="s">' + hl(x.titulo, P) + '</span><a href="' + esc(x.url) + '" target="_blank" rel="noopener">Ver original ↗</a></li>').join('') + '</ul>';
        })
        .catch((e) => { if (e.name !== 'AbortError') ep.hidden = true; });
    }, 350);
  }

  // Autocompletado
  let acItems = [], acSel = -1;
  function suggest() {
    const raw = input.value.trim();
    if (raw.length < 1) { closeAc(); return; }
    const { P, list } = search(raw);
    const norms = list.slice(0, 6).map((r) => ({ kind: 'n', n: r.n }));
    const lastTok = P.toks[P.toks.length - 1] || '';
    const temas = [];
    if (lastTok.length >= 2) {
      const seen = new Set();
      DATA.forEach((n) => n.temas.forEach((t) => { const k = norm(t); if (!seen.has(k) && k.split(/\s+/).some((w) => w.startsWith(lastTok)) && !norm(raw).includes(k)) { seen.add(k); temas.push({ kind: 't', t }); } }));
    }
    acItems = [...norms, ...temas.slice(0, 4)];
    if (!acItems.length) { closeAc(); return; }
    acSel = -1;
    let html = '', i = 0;
    if (norms.length) { html += '<div class="hd">Normas</div>'; norms.forEach((it) => { html += '<div role="option" id="ac' + i + '" data-i="' + (i++) + '" aria-selected="false"><span class="k">' + hl(label(it.n), P) + '</span><span class="v">' + hl(it.n.titulo, P) + '</span></div>'; }); }
    const tt = acItems.filter((x) => x.kind === 't');
    if (tt.length) { html += '<div class="hd">Temas</div>'; tt.forEach((it) => { html += '<div role="option" id="ac' + i + '" data-i="' + (i++) + '" aria-selected="false"><span class="k t">Tema</span><span class="v"><b>' + hl(it.t, P) + '</b></span></div>'; }); }
    ac.innerHTML = html; ac.hidden = false; input.setAttribute('aria-expanded', 'true');
  }
  function closeAc() { ac.hidden = true; acItems = []; acSel = -1; input.setAttribute('aria-expanded', 'false'); input.removeAttribute('aria-activedescendant'); }
  function pick(i) {
    const it = acItems[i]; if (!it) return;
    closeAc();
    if (it.kind === 'n') { input.value = label(it.n).replace(' N.° ', ' '); render(true); const el = document.getElementById('n-' + it.n.id); if (el) el.scrollIntoView({ block: 'nearest', behavior: 'smooth' }); }
    else { input.value = it.t; render(true); }
  }
  function goTo(id) { const n = byId[id]; if (!n) return; input.value = label(n).replace(' N.° ', ' '); state.tipo = ''; render(true); window.scrollTo({ top: hero.offsetTop, behavior: 'smooth' }); }

  let typing = null;
  input.addEventListener('input', () => { suggest(); clearTimeout(typing); typing = setTimeout(() => render(true), 120); });
  input.addEventListener('focus', () => { if (input.value.trim()) suggest(); });
  input.addEventListener('keydown', (e) => {
    if (ac.hidden) return;
    const opts = ac.querySelectorAll('[role="option"]');
    if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
      e.preventDefault(); acSel = (acSel + (e.key === 'ArrowDown' ? 1 : -1) + opts.length) % opts.length;
      opts.forEach((o, i) => o.setAttribute('aria-selected', i === acSel)); input.setAttribute('aria-activedescendant', 'ac' + acSel); opts[acSel].scrollIntoView({ block: 'nearest' });
    } else if (e.key === 'Enter' && acSel >= 0) { e.preventDefault(); pick(acSel); }
    else if (e.key === 'Escape') closeAc();
  });
  ac.addEventListener('mousedown', (e) => { const o = e.target.closest('[role="option"]'); if (o) { e.preventDefault(); pick(+o.dataset.i); } });
  input.addEventListener('blur', () => setTimeout(closeAc, 120));
  $('nsform').addEventListener('submit', (e) => { e.preventDefault(); closeAc(); render(true); input.blur(); });
  $('nsclear').addEventListener('click', () => { input.value = ''; state.tipo = ''; closeAc(); render(true); input.focus(); });
  document.querySelectorAll('[data-q]').forEach((b) => b.addEventListener('click', () => { input.value = b.dataset.q; state.tipo = ''; render(true); window.scrollTo({ top: 0, behavior: 'smooth' }); }));
  $('nstipos').addEventListener('click', (e) => { const b = e.target.closest('[data-tipo]'); if (b) { state.tipo = b.dataset.tipo; render(false); } });
  $('nssort').addEventListener('change', (e) => { state.sort = e.target.value; render(false); });
  $('nslist').addEventListener('click', (e) => {
    const g = e.target.closest('[data-go]'); if (g) { goTo(g.dataset.go); return; }
    const c = e.target.closest('[data-copy]');
    if (c) { (navigator.clipboard ? navigator.clipboard.writeText(c.dataset.copy) : Promise.reject()).then(() => { c.textContent = 'Enlace copiado ✓'; setTimeout(() => { c.textContent = 'Copiar enlace'; }, 1800); }).catch(() => { prompt('Copie el enlace:', c.dataset.copy); }); }
  });
  if (input.value.trim()) render(false);
})();
</script>
@endsection
