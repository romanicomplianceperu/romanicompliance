@extends('layouts.site')

@section('title', 'Buscador OFAC · Romani Compliance')
@section('description', 'Busque gratis en las listas de sanciones de OFAC (SDN y consolidada): personas, empresas, embarcaciones y aeronaves, con tolerancia a errores de tipeo y constancia en PDF.')

@php
  $published = !empty($meta['published_at']) ? \Carbon\Carbon::parse($meta['published_at'])->timezone('America/Lima') : null;
  $built = !empty($meta['built_at']) ? \Carbon\Carbon::parse($meta['built_at'])->timezone('America/Lima') : null;
@endphp

@section('styles')
.bz-hero { background: var(--ink); color: #fff; padding: clamp(40px, 6vw, 72px) 0 clamp(30px, 4vw, 44px); }
.bz-hero .kicker { color: var(--blue-l); }
.bz-hero h1 { font-size: clamp(2.1rem, 4.4vw, 3.6rem); }
.bz-hero .lead { color: rgba(255,255,255,.72); margin: 14px 0 26px; max-width: 720px; }
.bz-box { position: relative; max-width: 860px; }
.bz-box input { width: 100%; padding: 22px 140px 22px 60px; border-radius: 20px; border: 0; font: inherit; font-size: 1.15rem; font-weight: 600; color: var(--ink); background: #fff; box-shadow: 0 30px 60px -30px rgba(0,0,0,.6); }
.bz-box input::-webkit-search-cancel-button { -webkit-appearance: none; display: none; }
.bz-box input:focus { outline: 3px solid var(--blue-l); outline-offset: 2px; }
.bz-box .ic-s { position: absolute; left: 22px; top: 50%; transform: translateY(-50%); width: 24px; height: 24px; color: var(--muted-2); }
.bz-box .clr { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); border: 0; background: var(--soft); color: var(--muted); font: inherit; font-weight: 700; font-size: .85rem; padding: 8px 12px; border-radius: 12px; cursor: pointer; }
.bz-ac { position: absolute; left: 0; right: 0; top: calc(100% + 8px); z-index: 40; background: #fff; color: var(--ink); border-radius: 18px; box-shadow: 0 30px 70px -24px rgba(0,0,0,.55); padding: 6px; max-height: 380px; overflow-y: auto; }
.bz-ac button { display: flex; width: 100%; align-items: center; gap: 12px; text-align: left; border: 0; background: none; font: inherit; padding: 10px 12px; border-radius: 12px; cursor: pointer; color: var(--ink); }
.bz-ac button.on, .bz-ac button:hover { background: var(--soft); }
.bz-ac .ti { width: 34px; height: 34px; border-radius: 10px; background: var(--blue-50); color: var(--blue); display: grid; place-items: center; font-weight: 800; font-size: .78rem; flex-shrink: 0; }
.bz-ac .nm { flex: 1; min-width: 0; }
.bz-ac .nm b { display: block; font-weight: 700; font-size: .96rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.bz-ac .nm b mark { background: none; color: var(--blue); font-weight: 800; }
.bz-ac .nm small { display: block; color: var(--muted); font-size: .8rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.bz-ac .hint { padding: 8px 12px 6px; font-size: .78rem; color: var(--muted-2); }
.bz-meta { display: flex; gap: 8px 18px; flex-wrap: wrap; margin-top: 16px; font-size: .88rem; color: rgba(255,255,255,.66); }
.bz-meta b { color: #fff; }
.bz-meta .dot { width: 8px; height: 8px; border-radius: 50%; background: #3DDC97; display: inline-block; margin-right: 6px; vertical-align: 1px; box-shadow: 0 0 0 4px rgba(61,220,151,.18); }
.bz-try { margin-top: 14px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; font-size: .86rem; color: rgba(255,255,255,.6); }
.bz-try button { border: 1px solid rgba(255,255,255,.2); background: rgba(255,255,255,.06); color: #fff; font: inherit; font-weight: 600; font-size: .84rem; padding: 6px 12px; border-radius: 999px; cursor: pointer; }
.bz-try button:hover { background: rgba(255,255,255,.14); }
.bz-modes { display: inline-flex; gap: 4px; background: rgba(255,255,255,.08); padding: 4px; border-radius: 14px; margin-bottom: 14px; }
.bz-modes button { border: 0; background: none; color: rgba(255,255,255,.7); font: inherit; font-weight: 700; font-size: .9rem; padding: 8px 14px; border-radius: 10px; cursor: pointer; }
.bz-modes button[aria-selected="true"] { background: #fff; color: var(--ink); }
.bz-batch textarea { width: 100%; max-width: 860px; min-height: 150px; padding: 18px 20px; border-radius: 20px; border: 0; font: inherit; font-size: 1rem; color: var(--ink); resize: vertical; }
.bz-batch .acts { display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap; align-items: center; }
.bz-batch .acts span { color: rgba(255,255,255,.6); font-size: .86rem; }

.bz-main { padding: 28px 0 72px; }
.bz-filters { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; padding: 14px; border: 1px solid var(--line); border-radius: 20px; background: #fff; }
.bz-chips { display: flex; gap: 6px; flex-wrap: wrap; }
.bz-chips button { border: 1px solid var(--line); background: #fff; font: inherit; font-weight: 700; font-size: .86rem; color: var(--muted); padding: 8px 12px; border-radius: 999px; cursor: pointer; }
.bz-chips button[aria-pressed="true"] { background: var(--ink); border-color: var(--ink); color: #fff; }
.bz-filters select { padding: 9px 12px; border: 1px solid var(--line); border-radius: 12px; font: inherit; font-size: .88rem; background: #fff; color: var(--ink); max-width: 230px; }
.bz-sim { display: flex; align-items: center; gap: 8px; font-size: .86rem; font-weight: 700; color: var(--muted); margin-left: auto; }
.bz-sim input { accent-color: var(--blue); width: 130px; }
.bz-sim output { min-width: 42px; color: var(--ink); }
.bz-ftoggle { display: none; }
@media (max-width: 860px) {
  .bz-box input { padding: 18px 92px 18px 52px; font-size: 1.02rem; border-radius: 16px; }
  .bz-box .ic-s { left: 18px; }
  .bz-ftoggle { display: flex; width: 100%; justify-content: space-between; align-items: center; border: 0; background: none; font: inherit; font-weight: 800; color: var(--ink); padding: 2px; cursor: pointer; }
  .bz-filters:not(.open) > :not(.bz-ftoggle) { display: none; }
  .bz-filters select { max-width: none; flex: 1 1 45%; }
  .bz-sim { margin-left: 0; width: 100%; } .bz-sim input { flex: 1; }
}

.bz-head { display: flex; gap: 10px; align-items: center; justify-content: space-between; flex-wrap: wrap; margin: 22px 0 14px; }
.bz-head h2 { font-size: 1.15rem; font-weight: 800; }
.bz-head .muted { font-size: .9rem; }
.bz-list { display: grid; gap: 12px; }
.bz-card { border: 1px solid var(--line); border-radius: 22px; background: #fff; overflow: hidden; transition: border-color .25s, box-shadow .25s; }
.bz-card:hover { border-color: #C9D3E6; box-shadow: 0 16px 36px -28px rgba(10,23,48,.45); }
.bz-card .top { display: grid; grid-template-columns: 68px 1fr; gap: 16px; padding: 18px 18px 14px; align-items: start; cursor: pointer; }
.bz-ring { width: 64px; height: 64px; border-radius: 50%; display: grid; place-items: center; font-weight: 800; font-size: 1.05rem; background: conic-gradient(var(--c) calc(var(--v) * 1%), #EEF1F6 0); position: relative; }
.bz-ring::before { content: ''; position: absolute; inset: 6px; border-radius: 50%; background: #fff; }
.bz-ring span { position: relative; color: var(--c); }
.bz-card h3 { font-size: 1.08rem; font-weight: 800; line-height: 1.3; letter-spacing: -0.01em; word-break: break-word; }
.bz-card .via { font-size: .86rem; color: var(--muted); margin-top: 3px; }
.bz-card .via b { color: var(--ink); }
.bz-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 10px; }
.bz-tag { font-size: .76rem; font-weight: 700; padding: 4px 9px; border-radius: 999px; background: var(--soft); color: var(--muted); }
.bz-tag.lv { color: #fff; }
.bz-tag.pg { background: var(--blue-50); color: var(--blue); }
.bz-facts { font-size: .88rem; color: var(--muted); margin-top: 8px; line-height: 1.5; }
.bz-more { border-top: 1px solid var(--line); background: #FAFBFD; padding: 16px 18px 18px; display: grid; gap: 14px; font-size: .92rem; }
.bz-more h4 { font-size: .78rem; font-weight: 800; text-transform: uppercase; letter-spacing: .05em; color: var(--muted-2); margin-bottom: 6px; }
.bz-more ul { list-style: none; display: grid; gap: 4px; }
.bz-more li { line-height: 1.45; }
.bz-more .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
@media (max-width: 640px) { .bz-more .grid2 { grid-template-columns: 1fr; } .bz-card .top { grid-template-columns: 54px 1fr; gap: 12px; padding: 16px 14px 12px; } .bz-ring { width: 52px; height: 52px; font-size: .92rem; } }
.bz-actions { display: flex; border-top: 1px solid var(--line); }
.bz-toggle { display: flex; flex: 1; justify-content: space-between; align-items: center; border: 0; background: #fff; font: inherit; font-weight: 700; font-size: .88rem; color: var(--blue); padding: 11px 18px; cursor: pointer; }
.bz-pdf { display: inline-flex; align-items: center; gap: 6px; padding: 11px 18px; border-left: 1px solid var(--line); font-weight: 700; font-size: .88rem; color: var(--ink); white-space: nowrap; }
.bz-pdf:hover { background: var(--soft); color: var(--blue); }
.bz-pdf svg { width: 16px; height: 16px; }
.bz-empty { text-align: center; padding: 44px 20px; border: 1px dashed #C9D3E6; border-radius: 22px; background: #fff; }
.bz-empty .ok { width: 64px; height: 64px; border-radius: 50%; display: grid; place-items: center; margin: 0 auto 14px; background: var(--ok-50, #E1F3EC); color: #0E8A5F; font-size: 30px; }
.bz-empty h3 { font-size: 1.25rem; font-weight: 800; }
.bz-empty p { color: var(--muted); margin-top: 6px; max-width: 520px; margin-left: auto; margin-right: auto; }
.bz-intro { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 8px; }
.bz-intro .card { padding: 22px; }
.bz-intro h3 { font-size: 1.05rem; font-weight: 800; margin: 12px 0 6px; }
.bz-intro p { color: var(--muted); font-size: .94rem; }
@media (max-width: 860px) { .bz-intro { grid-template-columns: 1fr; } }
.bz-table { width: 100%; border-collapse: collapse; background: #fff; border: 1px solid var(--line); border-radius: 18px; overflow: hidden; font-size: .92rem; }
.bz-table th, .bz-table td { padding: 12px 14px; text-align: left; border-bottom: 1px solid var(--line); vertical-align: top; }
.bz-table th { background: var(--soft); font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; color: var(--muted); }
.bz-table tr:last-child td { border-bottom: 0; }
.bz-table a { color: var(--blue); font-weight: 700; cursor: pointer; }
.bz-ok { color: #0E8A5F; font-weight: 800; } .bz-hit { color: #C0362C; font-weight: 800; }
.bz-note { margin-top: 34px; padding: 18px 20px; border-radius: 18px; background: var(--soft); color: var(--muted); font-size: .88rem; line-height: 1.6; }
.bz-cta { margin-top: 18px; background: var(--ink); color: #fff; border-radius: 24px; padding: clamp(22px, 4vw, 34px); display: flex; gap: 18px; align-items: center; justify-content: space-between; flex-wrap: wrap; }
.bz-cta h3 { font-size: 1.3rem; font-weight: 800; }
.bz-cta p { color: rgba(255,255,255,.7); margin-top: 4px; }
.bz-loading { height: 3px; background: linear-gradient(90deg, transparent, var(--blue), transparent); background-size: 200% 100%; animation: bzload 1s linear infinite; border-radius: 2px; margin-top: 10px; visibility: hidden; }
.bz-loading.on { visibility: visible; }
@keyframes bzload { from { background-position: 200% 0; } to { background-position: -200% 0; } }
@endsection

@section('content')
<section class="bz-hero">
  <div class="wrap">
    <div class="kicker rv">Herramienta gratuita</div>
    <h1 class="display rv">Buscador OFAC</h1>
    <p class="lead rv">Verifique en segundos si una persona, empresa, embarcación o aeronave figura en las listas de sanciones del Departamento del Tesoro de EE. UU. Escriba el nombre como lo tenga: no importan las tildes, el orden de las palabras ni los errores de tipeo.</p>

    <div class="bz-modes" role="tablist">
      <button type="button" role="tab" aria-selected="true" data-mode="one">Un nombre</button>
      <button type="button" role="tab" aria-selected="false" data-mode="many">Varios nombres</button>
    </div>

    <div id="modeOne">
      <div class="bz-box">
        <svg class="ic-s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
        <input id="q" type="search" autocomplete="off" spellcheck="false" role="combobox" aria-autocomplete="list" aria-controls="ac" aria-expanded="false" placeholder="Nombre de la persona, empresa o embarcación" value="{{ $initial }}" aria-label="Nombre a buscar">
        <button type="button" class="clr" id="clr" hidden>Borrar</button>
        <div class="bz-ac" id="ac" role="listbox" hidden></div>
      </div>
      <div class="bz-loading" id="loading"></div>
      <div class="bz-try">Pruebe con: @foreach(['Nicolás Maduro', 'Banco Nacional de Cuba', 'Rosneft', 'Joaquín Guzmán'] as $ex)<button type="button" data-ex="{{ $ex }}">{{ $ex }}</button>@endforeach</div>
    </div>

    <div id="modeMany" class="bz-batch" hidden>
      <textarea id="names" placeholder="Pegue un nombre por línea (hasta 50)&#10;Ejemplo:&#10;Nicolás Maduro&#10;Inversiones Andinas SAC&#10;Rosneft"></textarea>
      <div class="acts"><button type="button" class="b b-light" id="runBatch">Revisar nombres @include('site.partials.icon', ['name' => 'arrow'])</button><span>Útil para revisar a todos los accionistas, proveedores o clientes de una vez.</span></div>
    </div>

    <div class="bz-meta">
      @if($published)<span><i class="dot"></i>Lista OFAC al <b>{{ $published->translatedFormat('j \d\e F \d\e Y') }}</b></span>@endif
      @if(!empty($meta['entities']))<span><b>{{ number_format($meta['entities'], 0, ',', ' ') }}</b> registros · <b>{{ number_format($meta['names'], 0, ',', ' ') }}</b> nombres y alias</span>@endif
      <span>Lista SDN + lista consolidada (no SDN)</span>
    </div>
  </div>
</section>

<section class="bz-main">
  <div class="wrap">
    <div class="bz-filters" id="filters">
      <button type="button" class="bz-ftoggle" id="ftoggle"><span>Filtros</span><span id="fcount" class="muted" style="font-weight:600;font-size:.86rem"></span></button>
      <div class="bz-chips" id="types">
        <button type="button" data-t="" aria-pressed="true">Todos</button>
        <button type="button" data-t="i" aria-pressed="false">Personas</button>
        <button type="button" data-t="e" aria-pressed="false">Entidades</button>
        <button type="button" data-t="v" aria-pressed="false">Embarcaciones</button>
        <button type="button" data-t="a" aria-pressed="false">Aeronaves</button>
      </div>
      <select id="lista" aria-label="Lista"><option value="">Todas las listas</option><option value="S">Lista SDN</option><option value="C">Lista consolidada (no SDN)</option></select>
      <select id="programa" aria-label="Programa"><option value="">Todos los programas</option>@foreach($programs as $p)<option value="{{ $p['code'] }}">{{ $p['label'] }}{{ $p['label'] !== $p['code'] ? ' · '.$p['code'] : '' }}</option>@endforeach</select>
      <select id="pais" aria-label="País"><option value="">Todos los países</option>@foreach($countries as $c)<option value="{{ $c }}">{{ $c }}</option>@endforeach</select>
      <label class="bz-sim" title="Qué tan parecido debe ser el nombre. OFAC usa 85 % por defecto.">Similitud mínima <input type="range" id="min" min="70" max="100" step="1" value="85"><output id="minOut">85 %</output></label>
    </div>

    <div id="out">
      <div class="bz-intro">
        <div class="card"><span class="icon-tile">@include('site.partials.icon', ['name' => 'shield'])</span><h3>Búsqueda inteligente</h3><p>Encuentra el nombre aunque esté escrito distinto, en otro orden o con un error de tipeo, y también por sus alias.</p></div>
        <div class="card"><span class="icon-tile">@include('site.partials.icon', ['name' => 'doc'])</span><h3>Constancia en PDF</h3><p>Descargue la constancia de cada búsqueda con fecha, hora y versión de la lista, para su expediente de debida diligencia.</p></div>
        <div class="card"><span class="icon-tile">@include('site.partials.icon', ['name' => 'clock'])</span><h3>Siempre al día</h3><p>La información se toma de los archivos oficiales de OFAC y se actualiza automáticamente varias veces al día.</p></div>
      </div>
    </div>

    <div class="bz-note">
      <b>Importante:</b> esta herramienta consulta los archivos públicos de la Oficina de Control de Activos Extranjeros (OFAC) del Tesoro de EE. UU. Una coincidencia no confirma por sí sola que se trate de la misma persona: verifique con otros datos (documento, fecha de nacimiento, nacionalidad, dirección) y consulte la ficha oficial. Romani Compliance no está afiliada a OFAC.
    </div>
    <div class="bz-cta">
      <div><h3>¿Encontró una coincidencia?</h3><p>Le ayudamos a confirmarla, documentarla y a actuar a tiempo: congelamiento, reporte y defensa.</p></div>
      <a class="b b-light" href="{{ \App\Support\ServiceCatalog::whatsapp('Hola, encontré una posible coincidencia en el buscador OFAC y quisiera orientación.') }}" target="_blank" rel="noopener">Hablar con un especialista</a>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
(function () {
  const API = @json(route('buscador.api')), LOTE = @json(route('buscador.lote')), PDF = @json(route('buscador.constancia'));
  const SUG = @json(route('buscador.sugerencias')), FICHA = @json(route('buscador.ficha', ['id' => '__ID__']));
  const $ = (s) => document.querySelector(s), out = $('#out'), q = $('#q'), loading = $('#loading');
  const state = { tipo: '', lista: '', programa: '', pais: '', min: 85 };
  const introHtml = out.innerHTML;
  let mode = 'one';
  const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  const color = (s) => s >= 95 ? '#C0362C' : s >= 90 ? '#E07A2E' : '#C9971C';
  const level = (s) => s >= 95 ? 'Coincidencia muy alta' : s >= 90 ? 'Coincidencia alta' : 'Coincidencia posible';
  const params = (extra) => new URLSearchParams(Object.assign({}, Object.fromEntries(Object.entries(state).filter(([, v]) => v !== '' && v !== null)), extra)).toString();
  const KEY = /^(DOB|POB|nationality|citizen|Passport|Cedula|National ID|Gender|Identification Number|RFC|CURP|NIT|Tax ID|Registration Number|IMO|Vessel Registration)/i;
  const FACT = { 'DOB': 'Nacimiento', 'POB': 'Lugar de nacimiento', 'nationality': 'Nacionalidad', 'citizen': 'Ciudadanía', 'Passport': 'Pasaporte', 'Gender': 'Género', 'Cedula No.': 'Cédula', 'National ID No.': 'Documento nacional' };
  const VAL = { Male: 'Masculino', Female: 'Femenino' };
  const tr = (f) => { for (const k in FACT) { if (f.startsWith(k + ' ')) { const v = f.slice(k.length + 1); return '<b>' + FACT[k] + ':</b> ' + esc(VAL[v] || v); } } return esc(f); };

  function card(r, term) {
    const fichaUrl = FICHA.replace('__ID__', r.id) + '?' + new URLSearchParams({ q: term, score: r.score, via: r.matched }).toString();
    const facts = r.facts.filter((f) => KEY.test(f)).slice(0, 3).map(tr).join(' · ');
    const lv = r.list === 'S' ? '<span class="bz-tag lv" style="background:#0A1730">SDN</span>' : '<span class="bz-tag lv" style="background:#55647C">No SDN</span>';
    const progs = r.programs.slice(0, 3).map((p) => '<span class="bz-tag pg" title="' + esc(p.code) + '">' + esc(p.label) + '</span>').join('');
    const aliases = r.aliases.length ? '<div><h4>También conocido como</h4><ul>' + r.aliases.map((a) => '<li>' + esc(a.name) + ' <span class="muted">(' + esc(a.kind) + ')</span></li>').join('') + '</ul></div>' : '';
    const addr = r.addresses.length ? '<div><h4>Direcciones</h4><ul>' + r.addresses.map((a) => '<li>' + esc(a) + '</li>').join('') + '</ul></div>' : '';
    const allFacts = r.facts.length ? '<div><h4>Datos de identificación</h4><ul>' + r.facts.map((f) => '<li>' + tr(f) + '</li>').join('') + '</ul></div>' : '';
    const vessel = Object.keys(r.vessel || {}).length ? '<div><h4>Datos de la nave</h4><ul>' + Object.entries(r.vessel).map(([k, v]) => '<li><b>' + esc(k) + ':</b> ' + esc(v) + '</li>').join('') + '</ul></div>' : '';
    const progsAll = '<div><h4>Programas de sanción</h4><ul>' + r.programs.map((p) => '<li>' + esc(p.label) + ' <span class="muted">(' + esc(p.code) + ')</span></li>').join('') + '</ul></div>';
    return '<article class="bz-card"><div class="top" data-open>'
      + '<div class="bz-ring" style="--c:' + color(r.score) + ';--v:' + r.score + '" title="' + level(r.score) + '"><span>' + r.score + '%</span></div>'
      + '<div><h3>' + esc(r.name) + '</h3>'
      + (r.matched_alias ? '<div class="via">Coincide con el alias <b>' + esc(r.matched) + '</b></div>' : '')
      + '<div class="bz-tags">' + lv + '<span class="bz-tag">' + esc(r.type_label) + '</span>' + progs + (r.countries[0] ? '<span class="bz-tag">' + esc(r.countries.slice(0, 2).join(', ')) + '</span>' : '') + '</div>'
      + (facts ? '<div class="bz-facts">' + facts + '</div>' : '') + '</div></div>'
      + '<div class="bz-more" hidden><div class="grid2">' + progsAll + allFacts + '</div><div class="grid2">' + aliases + addr + '</div>' + vessel
      + '<div><a class="b b-primary" style="padding:10px 16px" href="' + esc(r.ofac_url) + '" target="_blank" rel="noopener">Ver ficha oficial en OFAC ↗</a></div></div>'
      + '<div class="bz-actions"><button type="button" class="bz-toggle" data-open><span>Ver ficha completa</span><span>▾</span></button>'
      + '<a class="bz-pdf" href="' + esc(fichaUrl) + '" data-no-loader title="Descargar la ficha de este resultado en PDF"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v11M7 10l5 5 5-5M5 20h14"/></svg>Ficha PDF</a></div></article>';
  }

  let timer, seq = 0, last = '';
  function run() {
    const term = q.value.trim(); $('#clr').hidden = !term;
    history.replaceState(null, '', term ? '?q=' + encodeURIComponent(term) : location.pathname);
    if (term.length < 2) { if (last) { seq++; last = ''; out.innerHTML = introHtml; loading.classList.remove('on'); } return; }
    last = term; const my = ++seq; loading.classList.add('on');
    fetch(API + '?' + params({ q: term }), { headers: { Accept: 'application/json' } }).then((r) => r.json()).then((d) => {
      if (my !== seq) return; loading.classList.remove('on');
      const pdf = PDF + '?' + params({ q: term });
      const btn = '<a class="b b-ghost" style="padding:10px 16px" href="' + pdf + '" data-no-loader>Descargar constancia (PDF)</a>';
      if (!d.total) {
        out.innerHTML = '<div class="bz-head"><h2>Resultado para «' + esc(term) + '»</h2>' + btn + '</div><div class="bz-empty"><div class="ok">✓</div><h3>Sin coincidencias</h3><p>No hay nombres en las listas de OFAC con al menos ' + state.min + ' % de similitud con «' + esc(term) + '». Si quiere ser más exhaustivo, baje la similitud mínima.</p></div>';
        return;
      }
      out.innerHTML = '<div class="bz-head"><div><h2>' + d.total + (d.total === 1 ? ' coincidencia' : ' coincidencias') + ' para «' + esc(term) + '»</h2>'
        + (d.total > d.results.length ? '<div class="muted">Se muestran las ' + d.results.length + ' más parecidas. Use los filtros para acotar.</div>' : '') + '</div>' + btn + '</div>'
        + '<div class="bz-list">' + d.results.map((r) => card(r, term)).join('') + '</div>';
    }).catch(() => { loading.classList.remove('on'); out.innerHTML = '<div class="bz-empty"><h3>No se pudo buscar</h3><p>Revise su conexión e intente de nuevo.</p></div>'; });
  }
  const go = () => { clearTimeout(timer); timer = setTimeout(run, 250); };

  // Autocompletado: nombres de la lista que empiezan como lo que se escribe
  const ac = $('#ac'); let acItems = [], acOn = -1, acTimer, acSeq = 0;
  const closeAc = () => { ac.hidden = true; acOn = -1; q.setAttribute('aria-expanded', 'false'); };
  const mark = (name, term) => {
    const words = term.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().split(/\s+/).filter((w) => w.length > 1);
    return esc(name).replace(/[A-Za-zÀ-ÿ0-9]+/g, (w) => { const n = w.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase(); const hit = words.find((x) => n.startsWith(x)); return hit ? '<mark>' + w.slice(0, hit.length) + '</mark>' + w.slice(hit.length) : w; });
  };
  function paintAc() { ac.querySelectorAll('button').forEach((b, i) => b.classList.toggle('on', i === acOn)); }
  function suggest() {
    const term = q.value.trim(); const my = ++acSeq;
    if (term.length < 2 || document.activeElement !== q) { closeAc(); return; }
    fetch(SUG + '?q=' + encodeURIComponent(term), { headers: { Accept: 'application/json' } }).then((r) => r.json()).then((list) => {
      if (my !== acSeq || document.activeElement !== q) return;
      acItems = list; acOn = -1;
      if (!list.length) { closeAc(); return; }
      ac.innerHTML = '<div class="hint">' + (list[0].fuzzy ? 'Nombres parecidos en la lista' : 'Nombres en la lista de OFAC') + '</div>' + list.map((s, i) => '<button type="button" role="option" data-i="' + i + '"><span class="ti">' + esc((s.type || '?').slice(0, 2).toUpperCase()) + '</span><span class="nm"><b>' + mark(s.name, term) + '</b><small>' + esc(s.type) + ' · ' + esc(s.list) + (s.of ? ' · alias de ' + esc(s.of) : '') + '</small></span></button>').join('');
      ac.hidden = false; q.setAttribute('aria-expanded', 'true');
    }).catch(closeAc);
  }
  function pick(i) { const s = acItems[i]; if (!s) return; q.value = s.name; closeAc(); clearTimeout(timer); run(); }
  ac.addEventListener('mousedown', (e) => e.preventDefault());
  ac.addEventListener('click', (e) => { const b = e.target.closest('button[data-i]'); if (b) pick(+b.dataset.i); });
  q.addEventListener('input', () => { go(); clearTimeout(acTimer); acTimer = setTimeout(suggest, 120); });
  q.addEventListener('focus', () => { if (q.value.trim().length >= 2) suggest(); });
  q.addEventListener('blur', () => setTimeout(closeAc, 120));
  q.addEventListener('keydown', (e) => {
    if (!ac.hidden && acItems.length && (e.key === 'ArrowDown' || e.key === 'ArrowUp')) { e.preventDefault(); acOn = (acOn + (e.key === 'ArrowDown' ? 1 : -1) + acItems.length) % acItems.length; paintAc(); return; }
    if (e.key === 'Escape') { closeAc(); return; }
    if (e.key === 'Enter') { e.preventDefault(); if (!ac.hidden && acOn >= 0) { pick(acOn); return; } closeAc(); clearTimeout(timer); run(); }
  });
  $('#clr').addEventListener('click', () => { q.value = ''; q.focus(); run(); });
  document.querySelectorAll('[data-ex]').forEach((b) => b.addEventListener('click', () => { q.value = b.dataset.ex; run(); }));
  out.addEventListener('click', (e) => {
    const t = e.target.closest('[data-open]'); if (!t) { const a = e.target.closest('[data-search]'); if (a) { switchMode('one'); q.value = a.dataset.search; run(); scrollTo({ top: 0, behavior: 'smooth' }); } return; }
    const c = t.closest('.bz-card'), m = c.querySelector('.bz-more'); m.hidden = !m.hidden;
    c.querySelector('.bz-toggle span').textContent = m.hidden ? 'Ver ficha completa' : 'Ocultar ficha';
  });

  // Filtros
  const refresh = () => { const n = ['tipo', 'lista', 'programa', 'pais'].filter((k) => state[k]).length + (state.min != 85 ? 1 : 0); $('#fcount').textContent = n ? n + ' activo' + (n > 1 ? 's' : '') : 'Tipo, lista, programa, país y similitud'; mode === 'one' ? (q.value.trim().length >= 2 && run()) : ($('#names').value.trim() && runBatch()); };
  document.querySelectorAll('#types button').forEach((b) => b.addEventListener('click', () => { document.querySelectorAll('#types button').forEach((x) => x.setAttribute('aria-pressed', x === b)); state.tipo = b.dataset.t; refresh(); }));
  ['lista', 'programa', 'pais'].forEach((k) => $('#' + k).addEventListener('change', (e) => { state[k] = e.target.value; refresh(); }));
  $('#min').addEventListener('input', (e) => { state.min = +e.target.value; $('#minOut').textContent = state.min + ' %'; });
  $('#min').addEventListener('change', refresh);
  $('#ftoggle').addEventListener('click', () => $('#filters').classList.toggle('open'));
  refresh();

  // Varios nombres
  function switchMode(m) { mode = m; document.querySelectorAll('.bz-modes button').forEach((b) => b.setAttribute('aria-selected', b.dataset.mode === m)); $('#modeOne').hidden = m !== 'one'; $('#modeMany').hidden = m !== 'many'; }
  document.querySelectorAll('.bz-modes button').forEach((b) => b.addEventListener('click', () => switchMode(b.dataset.mode)));
  function runBatch() {
    const names = $('#names').value.trim(); if (!names) return;
    const btn = $('#runBatch'); btn.disabled = true; loading.classList.add('on');
    fetch(LOTE + '?' + params({}), { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }, body: JSON.stringify({ names }) })
      .then((r) => r.json()).then((d) => {
        btn.disabled = false; loading.classList.remove('on');
        const rows = d.rows || [], hits = rows.filter((r) => r.total).length;
        out.innerHTML = '<div class="bz-head"><div><h2>' + rows.length + ' nombres revisados</h2><div class="muted">' + (hits ? hits + ' con posibles coincidencias · ' : '') + (rows.length - hits) + ' sin coincidencias (similitud mínima ' + state.min + ' %)</div></div></div>'
          + '<div style="overflow-x:auto"><table class="bz-table"><thead><tr><th>Nombre revisado</th><th>Resultado</th><th>Coincidencia más parecida</th></tr></thead><tbody>'
          + rows.map((r) => '<tr><td><b>' + esc(r.query) + '</b></td><td>' + (r.total ? '<span class="bz-hit">⚠ ' + r.total + (r.total === 1 ? ' coincidencia' : ' coincidencias') + '</span>' : '<span class="bz-ok">✓ Sin coincidencias</span>') + '</td><td>'
            + (r.total ? esc(r.results[0].name) + ' <span class="muted">(' + r.results[0].score + ' %)</span><br><a data-search="' + esc(r.query) + '">Ver detalle y constancia</a>' : '<span class="muted">—</span>') + '</td></tr>').join('')
          + '</tbody></table></div>';
      }).catch(() => { btn.disabled = false; loading.classList.remove('on'); });
  }
  $('#runBatch').addEventListener('click', runBatch);
  if (q.value.trim()) run();
})();
</script>
@endsection
