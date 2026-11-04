@extends('site.services._base')

@section('hero_actions')
  <a href="#inmobiliario" class="b b-primary" data-tab="inmo">Inmobiliario @include('site.partials.icon', ['name' => 'arrow'])</a>
  <a href="#notarial" class="b b-light" data-tab="nota">Notarial @include('site.partials.icon', ['name' => 'arrow'])</a>
@endsection

@section('page_styles')
.tabs { display: inline-flex; padding: 6px; border-radius: 999px; background: var(--soft); margin-bottom: 30px; }
.tabs button { border: 0; background: none; padding: 12px 24px; border-radius: 999px; font-weight: 700; cursor: pointer; color: var(--muted); transition: background .25s, color .25s; }
.tabs button[aria-selected="true"] { background: var(--ink); color: #fff; }
.im-grid { display: grid; grid-template-columns: 1.05fr .95fr; gap: 28px; align-items: start; }
@media (max-width: 960px) { .im-grid { grid-template-columns: 1fr; } }
.im-block + .im-block { margin-top: 28px; }
.im-label { font-weight: 800; font-size: 1.05rem; margin-bottom: 12px; }
.im-amt { font-size: 1.6rem; font-weight: 800; letter-spacing: -0.02em; }
.im-out { position: sticky; top: 110px; border: 1px solid var(--line); border-radius: 22px; padding: 26px; background: #fff; }
@media (max-width: 960px) { .im-out { position: static; } }
.im-out h3 { font-size: 1.2rem; font-weight: 800; }
.flags { display: grid; gap: 10px; margin: 16px 0 22px; }
.flag { display: flex; gap: 12px; padding: 13px 15px; border-radius: 14px; background: rgba(194,91,18,.07); animation: paneIn .4s var(--ease); }
.flag .ic { color: var(--warn); width: 20px; height: 20px; margin-top: 2px; }
.flag.hi { background: rgba(192,54,44,.07); } .flag.hi .ic { color: var(--bad); }
.flag span { font-size: .95rem; }
.ok-box { padding: 14px 16px; border-radius: 14px; background: rgba(14,138,95,.08); color: var(--ok); font-weight: 600; margin: 16px 0 22px; }
.nt-list { display: grid; gap: 12px; }
.nt-row { display: grid; grid-template-columns: 1fr auto; gap: 16px; align-items: center; padding: 16px 18px; border: 1px solid var(--line); border-radius: 16px; }
.nt-row b { font-weight: 700; }
.sw { position: relative; width: 56px; height: 32px; border-radius: 32px; background: var(--line); border: 0; cursor: pointer; transition: background .25s; flex-shrink: 0; }
.sw::after { content: ''; position: absolute; top: 4px; left: 4px; width: 24px; height: 24px; border-radius: 50%; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,.15); transition: transform .3s var(--ease); }
.sw[aria-checked="true"] { background: var(--blue); }
.sw[aria-checked="true"]::after { transform: translateX(24px); }
@endsection

@section('tool')
<div class="tool">
  <div class="tabs" role="tablist">
    <button type="button" role="tab" id="tInmo" aria-selected="true">Operación inmobiliaria</button>
    <button type="button" role="tab" id="tNota" aria-selected="false">Notaría</button>
  </div>
  <div id="pInmo" class="im-grid">
    <div>
      <div class="im-block"><div class="im-label">Tipo de operación</div><div id="imTipo"></div></div>
      <div class="im-block"><div class="im-label">Valor aproximado</div><div class="im-amt" id="imAmtTxt"></div><input type="range" class="range" id="imAmt" min="0" max="5" step="1" value="2" aria-label="Valor de la operación"></div>
      <div class="im-block"><div class="im-label">¿Cómo se pagará?</div><div id="imPago"></div></div>
      <div class="im-block"><div class="im-label">¿Quién es la contraparte?</div><div id="imParte"></div></div>
      <div class="im-block"><div class="im-label">Situación del inmueble <span class="muted" style="font-weight:600;font-size:.9rem">(puede marcar varias)</span></div><div id="imSit"></div></div>
    </div>
    <aside class="im-out" aria-live="polite">
      <h3>Lectura de su operación</h3>
      <div style="margin-top:14px"><span class="pill" id="imLvl"></span></div>
      <div class="meter" style="margin-top:14px"><i id="imMeter"></i></div>
      <div id="imFlags"></div>
      <div style="font-weight:800;margin-bottom:10px">Lo que revisaríamos antes de firmar</div>
      <ul class="ticks" id="imChecks"></ul>
      <a href="#contactar" class="b b-primary b-block" style="margin-top:22px">Revisar esta operación</a>
      <p class="note">Lectura orientativa. Las señales de alerta no implican que exista un ilícito: indican dónde verificar.</p>
    </aside>
  </div>
  <div id="pNota" hidden>
    <div class="result">
      <div class="gauge" id="ntGauge"><svg viewBox="0 0 200 200"><circle class="track" cx="100" cy="100" r="88" fill="none" stroke-width="14"/><circle class="val" cx="100" cy="100" r="88" fill="none" stroke-width="14"/></svg><div class="num"><div><b>0</b><span>de 100</span></div></div></div>
      <div>
        <div class="tool-q">¿Su notaría está al día?</div>
        <p class="tool-hint">Active lo que su notaría ya tiene funcionando.</p>
        <div class="nt-list" id="ntList"></div>
        <div class="tool-nav"><span class="pill" id="ntLvl"></span><a href="#contactar" class="b b-primary">Fortalecer mi notaría</a></div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('tool_scripts')
<script>
(function () {
  // Pestañas, también desde #inmobiliario / #notarial (botones de la portada y de la tarjeta)
  const tI = document.getElementById('tInmo'), tN = document.getElementById('tNota');
  const pI = document.getElementById('pInmo'), pN = document.getElementById('pNota');
  let tab = 'inmo';
  function show(t, scroll) {
    tab = t;
    tI.setAttribute('aria-selected', t === 'inmo'); tN.setAttribute('aria-selected', t === 'nota');
    pI.hidden = t !== 'inmo'; pN.hidden = t !== 'nota';
    t === 'inmo' ? drawI() : drawN();
    if (scroll) document.getElementById('herramienta').scrollIntoView({ behavior: 'smooth' });
  }
  tI.onclick = () => show('inmo'); tN.onclick = () => show('nota');
  document.querySelectorAll('[data-tab]').forEach((a) => a.addEventListener('click', (e) => { e.preventDefault(); history.replaceState(null, '', a.getAttribute('href')); show(a.dataset.tab, true); }));

  // ── Simulador inmobiliario ──
  const TIPO = [{ v: 'compra', t: 'Compra' }, { v: 'venta', t: 'Venta' }, { v: 'planos', t: 'Preventa en planos' }, { v: 'alquiler', t: 'Alquiler de alto valor' }];
  const PAGO = [{ v: 'banco', t: 'Transferencia o crédito bancario' }, { v: 'efectivo', t: 'Efectivo' }, { v: 'mixto', t: 'Parte en banco y parte en efectivo' }, { v: 'cripto', t: 'Activos virtuales' }, { v: 'tercero', t: 'Lo paga un tercero' }];
  const PARTE = [{ v: 'pn', t: 'Persona natural' }, { v: 'emp', t: 'Empresa' }, { v: 'ext', t: 'Persona o empresa extranjera' }, { v: 'nose', t: 'Aún no lo sé' }];
  const SIT = [{ v: 'carga', t: 'Tiene hipoteca u otra carga' }, { v: 'sucesion', t: 'Está en sucesión' }, { v: 'noinsc', t: 'No está inscrito en SUNARP' }, { v: 'obs', t: 'Hay diferencias de área o linderos' }];
  const AMT = ['Hasta USD 50 mil', 'USD 50 a 150 mil', 'USD 150 a 300 mil', 'USD 300 a 600 mil', 'USD 600 mil a 1,5 millones', 'Más de USD 1,5 millones'];
  const s = { tipo: 'compra', pago: null, parte: null, sit: [], amt: 2 };
  RCT.options(document.getElementById('imTipo'), TIPO, { value: 'compra', onChange: (v) => { s.tipo = v; drawI(); } });
  RCT.options(document.getElementById('imPago'), PAGO, { onChange: (v) => { s.pago = v; drawI(); } });
  RCT.options(document.getElementById('imParte'), PARTE, { onChange: (v) => { s.parte = v; drawI(); } });
  RCT.options(document.getElementById('imSit'), SIT, { multi: true, onChange: (v) => { s.sit = v; drawI(); } });
  const amt = document.getElementById('imAmt');
  amt.addEventListener('input', () => { s.amt = +amt.value; drawI(); });
  const WARN = '<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3.5l9.5 16.5h-19L12 3.5z"/><path d="M12 10v4.5M12 17.5h.01"/></svg>';

  function drawI() {
    document.getElementById('imAmtTxt').textContent = AMT[s.amt];
    const f = [];
    if (s.pago === 'efectivo') f.push([3, 'Pago en efectivo: exige acreditar el origen del dinero y su bancarización.']);
    if (s.pago === 'mixto') f.push([2, 'Pago mixto con efectivo: verifique la parte no bancarizada.']);
    if (s.pago === 'cripto') f.push([3, 'Pago con activos virtuales: requiere trazabilidad del origen y del intermediario.']);
    if (s.pago === 'tercero') f.push([3, 'Paga un tercero: identifique quién es y por qué paga.']);
    if (s.amt >= 3) f.push([2, 'Monto alto: corresponde una verificación reforzada del origen de los fondos.']);
    if (s.parte === 'ext') f.push([1, 'Contraparte extranjera: revise listas de sanciones y su país de origen.']);
    if (s.parte === 'emp') f.push([1, 'Contraparte empresa: identifique a su beneficiario final.']);
    if (s.parte === 'nose') f.push([1, 'Contraparte no identificada todavía: no firme sin conocerla.']);
    if (s.tipo === 'planos') f.push([1, 'Preventa en planos: confirme la habilitación del proyecto y la titularidad del terreno.']);
    if (s.sit.includes('carga')) f.push([2, 'Carga o hipoteca vigente: debe levantarse o regularse antes de transferir.']);
    if (s.sit.includes('sucesion')) f.push([2, 'Inmueble en sucesión: todos los herederos deben estar declarados e intervenir.']);
    if (s.sit.includes('noinsc')) f.push([3, 'Inmueble sin inscripción: requiere saneamiento antes de la compraventa.']);
    if (s.sit.includes('obs')) f.push([2, 'Diferencias de área o linderos: conviene sanearlas antes de la firma.']);
    const sc = f.reduce((a, x) => a + x[0], 0);
    const lvl = sc >= 6 ? ['bad', 'Riesgo alto', 100, 'var(--bad)'] : sc >= 3 ? ['warn', 'Riesgo moderado', 60, 'var(--warn)'] : ['ok', 'Riesgo bajo', 22, 'var(--ok)'];
    const pill = document.getElementById('imLvl'); pill.className = 'pill ' + lvl[0]; pill.textContent = lvl[1];
    const m = document.getElementById('imMeter'); m.style.width = lvl[2] + '%'; m.style.background = lvl[3];
    document.getElementById('imFlags').innerHTML = f.length
      ? '<div class="flags">' + f.sort((a, b) => b[0] - a[0]).map((x) => '<div class="flag' + (x[0] >= 3 ? ' hi' : '') + '">' + WARN + '<span>' + x[1] + '</span></div>').join('') + '</div>'
      : '<div class="ok-box">Sin señales de alerta con lo indicado. Aun así, una revisión de títulos evita sorpresas.</div>';
    const ch = ['Estudio de títulos y cadena de propiedad', 'Cargas, gravámenes y situación en SUNARP', 'Identidad de las partes y beneficiario final', 'Origen de los fondos y forma de pago'];
    if (s.sit.length) ch.push('Plan de saneamiento técnico-legal');
    if (s.tipo === 'planos') ch.push('Licencias del proyecto y titularidad del terreno');
    document.getElementById('imChecks').innerHTML = ch.map((x) => '<li>' + RCT.check + ' <span>' + x + '</span></li>').join('');
    RCT.summary(['Operación inmobiliaria: ' + RCT.label(TIPO, s.tipo), 'Valor: ' + AMT[s.amt], s.pago ? 'Pago: ' + RCT.label(PAGO, s.pago) : '', s.parte ? 'Contraparte: ' + RCT.label(PARTE, s.parte) : '', s.sit.length ? 'Inmueble: ' + s.sit.map((v) => RCT.label(SIT, v).toLowerCase()).join(', ') : '', 'Lectura: ' + lvl[1]], { level: lvl[1], title: 'Lectura de su operación inmobiliaria', priorities: f.map((x) => x[1]).concat(ch.map((c) => 'Revisar: ' + c)) });
  }

  // ── Chequeo notarial ──
  const NT = [
    ['oficial', 'Oficial de cumplimiento designado', 20], ['manual', 'Manual SPLAFT notarial actualizado', 20], ['registro', 'Registro de operaciones al día', 15],
    ['ros', 'Procedimiento para reportar operaciones sospechosas', 20], ['bf', 'Identificación del beneficiario final en los actos', 15], ['capac', 'Capacitación anual del personal', 10],
  ];
  const on = new Set();
  const list = document.getElementById('ntList');
  list.innerHTML = NT.map(([k, t]) => '<div class="nt-row"><b>' + t + '</b><button type="button" class="sw" role="switch" aria-checked="false" aria-label="' + t + '" data-k="' + k + '"></button></div>').join('');
  list.querySelectorAll('.sw').forEach((b) => b.addEventListener('click', () => { const k = b.dataset.k; on.has(k) ? on.delete(k) : on.add(k); b.setAttribute('aria-checked', on.has(k)); drawN(); }));
  function drawN() {
    const pct = NT.reduce((a, [k, , w]) => a + (on.has(k) ? w : 0), 0);
    const lvl = pct >= 80 ? ['ok', 'Notaría preparada', '#0E8A5F'] : pct >= 50 ? ['warn', 'Brechas por cerrar', '#C25B12'] : ['bad', 'Exposición alta', '#C0362C'];
    const p = document.getElementById('ntLvl'); p.className = 'pill ' + lvl[0]; p.textContent = lvl[1];
    RC.gauge(document.getElementById('ntGauge'), pct, lvl[2]);
    const miss = NT.filter(([k]) => !on.has(k)).map(([, t]) => t.toLowerCase());
    RCT.summary(['Chequeo notarial: ' + pct + '/100 (' + lvl[1] + ')', miss.length ? 'Pendiente: ' + miss.join('; ') + '.' : 'Todos los elementos están implementados.'], { score: pct, level: lvl[1], title: 'Chequeo de cumplimiento notarial', priorities: NT.filter(([k]) => !on.has(k)).map(([, t]) => 'Implementar: ' + t) });
  }

  show(location.hash === '#notarial' ? 'nota' : 'inmo', location.hash === '#notarial' || location.hash === '#inmobiliario');
})();
</script>
@endsection
