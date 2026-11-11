@extends('layouts.site')

@section('title', 'Buscador de normas LA/FT del Perú: resoluciones SBS, UIF y leyes · Romani Compliance')
@section('description', 'Encuentre rápido las normas peruanas de prevención de lavado de activos y financiamiento del terrorismo: resoluciones SBS, decretos supremos y leyes, con resumen, ámbito, modificaciones y enlace a la fuente.')
@section('og_image', asset('images/og-herramientas.jpg'))

@section('og_extra')
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'Dataset',
  'name' => 'Normas peruanas de prevención LA/FT',
  'description' => 'Catálogo de resoluciones SBS, decretos supremos y leyes peruanas de prevención del lavado de activos y del financiamiento del terrorismo, con enlace a la fuente.',
  'url' => route('herramientas.normas'),
  'inLanguage' => 'es-PE',
  'creator' => ['@type' => 'Organization', 'name' => 'Romani Compliance', 'url' => url('/')],
  'dateModified' => $updated,
  'hasPart' => $normas->map(fn ($n) => ['@type' => 'Legislation', 'name' => $n['tipo'].' N.° '.$n['numero'].' · '.$n['titulo'], 'legislationIdentifier' => $n['tipo'].' '.$n['numero'], 'url' => $n['enlace'], 'legislationJurisdiction' => 'PE'])->values()->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('styles')
.nm-hero { background: var(--ink); color: #fff; padding: clamp(40px, 6vw, 72px) 0 clamp(30px, 4vw, 44px); }
.nm-hero .lead { color: rgba(255,255,255,.72); margin: 14px 0 24px; max-width: 720px; }
.nm-box { position: relative; max-width: 860px; }
.nm-box input { width: 100%; padding: 20px 20px 20px 58px; border-radius: 20px; border: 0; font: inherit; font-size: 1.12rem; font-weight: 600; color: var(--ink); box-shadow: 0 30px 60px -30px rgba(0,0,0,.6); }
.nm-box input::-webkit-search-cancel-button { -webkit-appearance: none; }
.nm-box input:focus { outline: 3px solid var(--blue-l); outline-offset: 2px; }
.nm-box svg { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); width: 24px; height: 24px; color: var(--muted-2); }
.nm-try { margin-top: 14px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; font-size: .86rem; color: rgba(255,255,255,.6); }
.nm-try button { border: 1px solid rgba(255,255,255,.2); background: rgba(255,255,255,.06); color: #fff; font: inherit; font-weight: 600; font-size: .84rem; padding: 6px 12px; border-radius: 999px; cursor: pointer; }
.nm-main { padding: 24px 0 72px; }
.nm-filters { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; margin-bottom: 18px; }
.nm-filters button { border: 1px solid var(--line); background: #fff; font: inherit; font-weight: 700; font-size: .86rem; color: var(--muted); padding: 8px 12px; border-radius: 999px; cursor: pointer; }
.nm-filters button[aria-pressed="true"] { background: var(--ink); border-color: var(--ink); color: #fff; }
.nm-filters select { padding: 9px 12px; border: 1px solid var(--line); border-radius: 12px; font: inherit; font-size: .88rem; background: #fff; }
.nm-count { margin-left: auto; color: var(--muted); font-size: .9rem; font-weight: 600; }
@media (max-width: 640px) { .nm-count { margin-left: 0; width: 100%; } }
.nm-list { display: grid; gap: 12px; }
.nm-card { border: 1px solid var(--line); border-radius: 22px; background: #fff; padding: 20px 22px; display: grid; grid-template-columns: 180px 1fr; gap: 18px; transition: border-color .25s, box-shadow .25s; }
.nm-card:hover { border-color: #C9D3E6; box-shadow: 0 16px 36px -28px rgba(10,23,48,.45); }
.nm-id .t { font-size: .78rem; font-weight: 800; color: var(--blue); text-transform: uppercase; letter-spacing: .04em; }
.nm-id .n { font-size: 1.2rem; font-weight: 800; letter-spacing: -0.02em; line-height: 1.15; margin-top: 2px; white-space: nowrap; }
.nm-id .d { color: var(--muted); font-size: .84rem; margin-top: 6px; }
.nm-card h2 { font-size: 1.08rem; font-weight: 800; line-height: 1.35; letter-spacing: -0.01em; }
.nm-card p { color: var(--muted); font-size: .95rem; margin-top: 6px; }
.nm-meta { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 10px; }
.nm-meta span { font-size: .78rem; font-weight: 700; padding: 4px 10px; border-radius: 999px; background: var(--soft); color: var(--muted); }
.nm-meta span.mod { background: #FBEBDD; color: #8A3B0B; }
.nm-acts { display: flex; gap: 14px; flex-wrap: wrap; margin-top: 12px; font-size: .9rem; }
.nm-acts a { color: var(--blue); font-weight: 700; }
.nm-acts small { color: var(--muted-2); align-self: center; }
mark { background: #FFF1B8; color: inherit; border-radius: 3px; padding: 0 1px; }
@media (max-width: 640px) { .nm-card { grid-template-columns: 1fr; gap: 8px; padding: 18px; } .nm-id { display: flex; gap: 10px; align-items: baseline; flex-wrap: wrap; } .nm-id .n { font-size: 1.15rem; } .nm-id .d { margin-top: 0; } }
.nm-empty { text-align: center; padding: 40px 20px; border: 1px dashed #C9D3E6; border-radius: 22px; background: #fff; color: var(--muted); }
.nm-note { margin-top: 30px; padding: 18px 20px; border-radius: 18px; background: var(--soft); color: var(--muted); font-size: .88rem; line-height: 1.6; }
.nm-note a { color: var(--blue); font-weight: 700; }
@endsection

@section('content')
<section class="nm-hero">
  <div class="wrap">
    <div class="kicker rv"><a href="{{ route('herramientas') }}" style="color:inherit">Herramientas y recursos</a></div>
    <h1 class="display rv">Normas LA/FT</h1>
    <p class="lead rv">Resoluciones SBS, decretos supremos y leyes de prevención del lavado de activos y del financiamiento del terrorismo. Busque por número, tema o a quién aplica.</p>
    <div class="nm-box">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
      <input id="nq" type="search" autocomplete="off" placeholder="Ej.: 789-2018, PSAV, inmobiliarias, oficial de cumplimiento" aria-label="Buscar normas">
    </div>
    <div class="nm-try">Pruebe con: @foreach(['2660-2015', 'activos virtuales', 'casas de cambio', 'congelamiento', 'Ley 30424'] as $ex)<button type="button" data-ex="{{ $ex }}">{{ $ex }}</button>@endforeach</div>
  </div>
</section>

<section class="nm-main">
  <div class="wrap">
    <div class="nm-filters">
      <button type="button" data-tipo="" aria-pressed="true">Todas</button>
      @foreach($tipos as $t)<button type="button" data-tipo="{{ $t }}" aria-pressed="false">{{ $t === 'Resolución SBS' ? 'Resoluciones SBS' : ($t === 'Ley' ? 'Leyes' : ($t === 'Decreto Supremo' ? 'Decretos supremos' : 'Decretos legislativos')) }}</button>@endforeach
      <select id="nanio" aria-label="Año"><option value="">Todos los años</option>@foreach($anios as $a)<option value="{{ $a }}">{{ $a }}</option>@endforeach</select>
      <span class="nm-count" id="ncount">{{ $normas->count() }} normas</span>
    </div>

    <div class="nm-list" id="nlist">
      @foreach($normas as $n)
        <article class="nm-card" id="{{ $n['id'] }}" data-tipo="{{ $n['tipo'] }}" data-anio="{{ $n['anio'] }}" data-text="{{ $n['tipo'] }} {{ $n['numero'] }} {{ $n['titulo'] }} {{ $n['resumen'] }} {{ $n['ambito'] }} {{ implode(' ', $n['temas']) }} {{ implode(' ', $n['modificada_por']) }}">
          <div class="nm-id"><div class="t">{{ $n['tipo'] }}</div><div class="n">N.° {{ $n['numero'] }}</div><div class="d">{{ $n['fecha'] }}</div></div>
          <div>
            <h2 data-hl>{{ $n['titulo'] }}</h2>
            <p data-hl>{{ $n['resumen'] }}</p>
            <div class="nm-meta"><span data-hl>{{ $n['ambito'] }}</span>@foreach($n['modificada_por'] as $m)<span class="mod">Modificada por {{ $m }}</span>@endforeach</div>
            <div class="nm-acts"><a href="{{ $n['enlace'] }}" target="_blank" rel="noopener">Ver la norma ↗</a><small>Fuente: {{ $n['fuente'] }}</small></div>
          </div>
        </article>
      @endforeach
    </div>
    <div class="nm-empty" id="nempty" hidden>No encontramos normas con ese criterio en el catálogo. Pruebe con otra palabra o búsquela en el <a href="https://www.sbs.gob.pe/app/pp/INT_CN/Paginas/Busqueda/BusquedaPortalUIF.aspx" target="_blank" rel="noopener" style="color:var(--blue);font-weight:700">buscador oficial de la SBS ↗</a>.</div>

    <div class="nm-note"><b>Cómo usar este catálogo:</b> reúne las normas clave de prevención LA/FT del Perú, actualizado al {{ $updated ? \Carbon\Carbon::parse($updated)->translatedFormat('j \d\e F \d\e Y') : '—' }}. Cada ficha enlaza a su fuente; antes de aplicar una norma, confirme su texto vigente en la <a href="https://www.sbs.gob.pe/app/pp/INT_CN/Paginas/Busqueda/BusquedaPortalUIF.aspx" target="_blank" rel="noopener">SBS</a> o en <a href="https://busquedas.elperuano.pe" target="_blank" rel="noopener">El Peruano</a>. ¿Necesita saber cuáles le aplican a su empresa? <a href="{{ \App\Support\ServiceCatalog::whatsapp('Hola, quisiera saber qué normas LA/FT le aplican a mi empresa.') }}" target="_blank" rel="noopener">Consúltenos</a>.</div>
  </div>
</section>
@endsection

@section('scripts')
<script>
(function () {
  const cards = [...document.querySelectorAll('.nm-card')], input = document.getElementById('nq');
  const state = { tipo: '', anio: '' };
  const norm = (s) => s.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();
  const STOP = new Set(['de', 'la', 'el', 'los', 'las', 'y', 'en', 'para', 'del', 'a', 'por', 'con', 'que', 'al', 'sobre', 'n', 'no', 'nro']);
  // Distancia de edición pequeña para tolerar errores de tipeo
  const lev = (a, b) => { if (Math.abs(a.length - b.length) > 2) return 9; const d = Array.from({ length: a.length + 1 }, (_, i) => [i]); for (let j = 1; j <= b.length; j++) d[0][j] = j; for (let i = 1; i <= a.length; i++) for (let j = 1; j <= b.length; j++) d[i][j] = Math.min(d[i - 1][j] + 1, d[i][j - 1] + 1, d[i - 1][j - 1] + (a[i - 1] === b[j - 1] ? 0 : 1)); return d[a.length][b.length]; };
  const index = cards.map((c) => { const t = norm(c.dataset.text); return { c, t, words: t.split(/[^a-z0-9]+/).filter(Boolean), digits: t.replace(/[^0-9 ]+/g, ' ') }; });
  const originals = new Map(); document.querySelectorAll('[data-hl]').forEach((el) => originals.set(el, el.textContent));
  function matches(it, q) {
    if (!q.length) return true;
    return q.every((w) => {
      if (/^\d+$/.test(w)) return it.digits.split(/\s+/).some((d) => d === w || d.replace(/^0+/, '') === w.replace(/^0+/, '') || d.startsWith(w));
      return it.words.some((x) => x.startsWith(w) || (w.length >= 5 && x.length >= 5 && lev(w, x.slice(0, Math.max(w.length, Math.min(x.length, w.length + 2)))) <= 1));
    });
  }
  function highlight(el, q) {
    const txt = originals.get(el); if (!q.length) { el.textContent = txt; return; }
    const esc = (s) => s.replace(/[&<>]/g, (ch) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[ch]));
    el.innerHTML = esc(txt).replace(/[A-Za-zÀ-ÿ0-9]+/g, (w) => { const n = norm(w); const hit = q.find((x) => !/^\d+$/.test(x) && n.startsWith(x)) || q.find((x) => /^\d+$/.test(x) && n.replace(/^0+/, '') === x.replace(/^0+/, '')); return hit ? '<mark>' + w + '</mark>' : w; });
  }
  function run() {
    const raw = norm(input.value).replace(/(\d+)\s*-\s*(\d+)/g, '$1 $2');
    const q = raw.split(/[^a-z0-9]+/).filter((w) => w && !STOP.has(w));
    let n = 0;
    index.forEach((it) => {
      const ok = matches(it, q) && (!state.tipo || it.c.dataset.tipo === state.tipo) && (!state.anio || it.c.dataset.anio === state.anio);
      it.c.hidden = !ok; if (ok) { n++; it.c.querySelectorAll('[data-hl]').forEach((el) => highlight(el, q)); }
    });
    document.getElementById('ncount').textContent = n + (n === 1 ? ' norma' : ' normas');
    document.getElementById('nempty').hidden = n > 0;
    history.replaceState(null, '', input.value.trim() ? '?q=' + encodeURIComponent(input.value.trim()) : location.pathname);
  }
  input.addEventListener('input', run);
  document.querySelectorAll('[data-ex]').forEach((b) => b.addEventListener('click', () => { input.value = b.dataset.ex; run(); }));
  document.querySelectorAll('[data-tipo]').forEach((b) => b.addEventListener('click', () => { document.querySelectorAll('[data-tipo]').forEach((x) => x.setAttribute('aria-pressed', x === b)); state.tipo = b.dataset.tipo; run(); }));
  document.getElementById('nanio').addEventListener('change', (e) => { state.anio = e.target.value; run(); });
  const init = new URLSearchParams(location.search).get('q'); if (init) { input.value = init; run(); }
})();
</script>
@endsection
