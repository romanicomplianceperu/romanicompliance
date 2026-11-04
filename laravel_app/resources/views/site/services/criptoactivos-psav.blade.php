@extends('site.services._base')

@section('page_styles')
.ps-grid { display: grid; grid-template-columns: 1.05fr 0.95fr; gap: 28px; align-items: start; }
@media (max-width: 960px) { .ps-grid { grid-template-columns: 1fr; } }
.ps-block + .ps-block { margin-top: 30px; }
.ps-label { font-weight: 800; font-size: 1.05rem; margin-bottom: 12px; }
.ps-vol { font-size: 1.6rem; font-weight: 800; letter-spacing: -0.02em; }
.ps-out { position: sticky; top: 110px; background: var(--ink); color: #fff; border-radius: 22px; padding: 28px; }
.ps-out h3 { font-size: 1.25rem; font-weight: 800; margin-bottom: 4px; }
.ps-out .muted { color: rgba(255,255,255,.6); }
.ps-mods { display: grid; gap: 10px; margin: 22px 0; }
.ps-mod { display: flex; gap: 12px; align-items: flex-start; padding: 14px 16px; border-radius: 14px; background: rgba(255,255,255,.06); animation: paneIn .45s var(--ease); }
.ps-mod .ic { color: var(--blue-l); width: 20px; height: 20px; margin-top: 2px; }
.ps-mod b { display: block; font-size: .98rem; }
.ps-mod span { font-size: .88rem; color: rgba(255,255,255,.62); }
.ps-out .meter { background: rgba(255,255,255,.12); }
.ps-out .meter i { background: var(--blue-l); }
.ps-meta { display: flex; justify-content: space-between; font-size: .9rem; color: rgba(255,255,255,.7); margin: 8px 0 22px; }
@media (max-width: 960px) { .ps-out { position: static; } }
.ob { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.ob .card h3 { font-size: 1.15rem; font-weight: 800; margin: 16px 0 8px; letter-spacing: -0.015em; }
@media (max-width: 900px) { .ob { grid-template-columns: 1fr; } }
.flow { display: grid; grid-template-columns: repeat(5, 1fr); gap: 0; position: relative; margin-top: 10px; }
.flow::before { content: ''; position: absolute; left: 10%; right: 10%; top: 31px; height: 2px; background: var(--line); }
.flow .pulse { position: absolute; top: 27px; left: 10%; width: 10px; height: 10px; border-radius: 50%; background: var(--blue); box-shadow: 0 0 0 6px rgba(31,79,216,.15); animation: travel 6s var(--ease) infinite; }
@keyframes travel { 0% { left: 10%; } 100% { left: calc(90% - 10px); } }
.flow .node { text-align: center; padding: 0 10px; position: relative; }
.flow .node .dot { width: 62px; height: 62px; margin: 0 auto 16px; border-radius: 18px; background: #fff; border: 1.5px solid var(--line); display: grid; place-items: center; color: var(--blue); font-weight: 800; font-size: 1.1rem; position: relative; z-index: 1; }
.flow .node b { display: block; font-weight: 800; margin-bottom: 4px; }
.flow .node span { font-size: .9rem; color: var(--muted); }
@media (max-width: 860px) {
  .flow { grid-template-columns: 1fr; gap: 18px; }
  .flow::before { left: 30px; right: auto; top: 10px; bottom: 10px; width: 2px; height: auto; }
  .flow .pulse { left: 26px !important; animation: travelV 6s var(--ease) infinite; }
  @keyframes travelV { 0% { top: 10px; } 100% { top: calc(100% - 20px); } }
  .flow .node { display: grid; grid-template-columns: 62px 1fr; gap: 16px; text-align: left; align-items: center; padding: 0; }
  .flow .node .dot { margin: 0; }
}
@endsection

@section('tool')
<div class="tool">
  <div class="ps-grid">
    <div>
      <div class="ps-block"><div class="ps-label">¿Qué servicios ofrece o va a ofrecer?</div><div id="psAct"></div></div>
      <div class="ps-block"><div class="ps-label">¿En qué etapa está?</div><div id="psStage"></div></div>
      <div class="ps-block"><div class="ps-label">¿Dónde tiene clientes?</div><div id="psGeo"></div></div>
      <div class="ps-block">
        <div class="ps-label">Volumen mensual aproximado</div>
        <div class="ps-vol" id="psVolTxt"></div>
        <input type="range" class="range" id="psVol" min="0" max="4" step="1" value="1" aria-label="Volumen mensual">
        <div class="muted" style="display:flex;justify-content:space-between;font-size:.85rem"><span>Inicial</span><span>Alto</span></div>
      </div>
    </div>
    <aside class="ps-out" aria-live="polite">
      <h3>Su programa de cumplimiento</h3>
      <p class="muted" id="psIntro">Elija al menos un servicio para ver la propuesta.</p>
      <div class="ps-mods" id="psMods"></div>
      <div style="font-weight:700;font-size:.95rem">Alcance del programa</div>
      <div class="meter" style="margin-top:10px"><i id="psMeter"></i></div>
      <div class="ps-meta"><span id="psCount">0 módulos</span><span id="psScope"></span></div>
      <a href="#contactar" class="b b-light b-block">Solicitar esta propuesta</a>
      <p class="note" style="color:rgba(255,255,255,.45)">Propuesta orientativa. La definimos con usted después de entender su operación.</p>
    </aside>
  </div>
</div>
@endsection

@section('extra')
<section class="sec">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Lo que se espera hoy de un PSAV</div><h2 class="h2 rv">Seis frentes que un supervisor revisa.</h2></div>
      <p class="lead rv" style="max-width:460px">Los estándares del GAFI para activos virtuales y la normativa peruana de prevención LA/FT convergen en estas exigencias.</p></div>
    <div class="ob">
      @foreach([
        ['shield', 'Enfoque basado en riesgo', 'La Recomendación 15 del GAFI pide identificar, evaluar y mitigar los riesgos de sus productos, clientes, canales y países.'],
        ['check', 'Conocimiento del cliente', 'Identificación y verificación de identidad, beneficiario final, perfil transaccional y monitoreo continuo.'],
        ['arrow', 'Regla de viaje', 'La Recomendación 16 del GAFI exige que los datos del originador y del beneficiario acompañen las transferencias de activos virtuales.'],
        ['alert', 'Operaciones sospechosas', 'Un procedimiento interno para detectar, analizar y reportar a la UIF-Perú, con la debida reserva.'],
        ['doc', 'Registro y supervisión', 'Inscripción en el registro que corresponda, oficial de cumplimiento y atención de la supervisión.'],
        ['coin', 'Trazabilidad on-chain', 'Herramientas de análisis de cadena para conocer el origen y el destino de los fondos.'],
      ] as $i => [$ic, $t, $d])
        <div class="card rv" style="--d:{{ $i * 0.05 }}s"><div class="icon-tile">@include('site.partials.icon', ['name' => $ic])</div><h3>{{ $t }}</h3><p class="muted">{{ $d }}</p></div>
      @endforeach
    </div>
  </div>
</section>
<section class="sec sec-soft">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Una operación bajo control</div><h2 class="h2 rv">Del depósito al reporte, sin puntos ciegos.</h2></div></div>
    <div class="flow rv">
      <span class="pulse" aria-hidden="true"></span>
      @foreach([['Alta del cliente', 'Identidad, beneficiario final y nivel de riesgo.'], ['Depósito', 'Origen de los fondos según el perfil.'], ['Monitoreo', 'Alertas por monto, frecuencia y contrapartes.'], ['Transferencia', 'Regla de viaje y análisis on-chain.'], ['Reporte', 'Análisis y comunicación a la UIF cuando corresponde.']] as $n => [$t, $d])
        <div class="node"><div class="dot">{{ $n + 1 }}</div><div><b>{{ $t }}</b><span>{{ $d }}</span></div></div>
      @endforeach
    </div>
  </div>
</section>
@endsection

@section('tool_scripts')
<script>
(function () {
  const ACT = [
    { v: 'fiat', t: 'Compra y venta de cripto por dinero', s: 'On-ramp y off-ramp' },
    { v: 'swap', t: 'Intercambio entre activos virtuales' },
    { v: 'custodia', t: 'Custodia o billetera' },
    { v: 'p2p', t: 'Plataforma P2P' },
    { v: 'otc', t: 'Mesa OTC' },
    { v: 'pagos', t: 'Pagos o pasarela con cripto' },
    { v: 'stable', t: 'Emisión o uso de stablecoins y tokens' },
  ];
  const STAGE = [{ v: 'idea', t: 'Por lanzar' }, { v: 'opera', t: 'Operando, sin programa formal' }, { v: 'mejora', t: 'Operando, con programa por mejorar' }];
  const GEO = [{ v: 'pe', t: 'Solo en Perú' }, { v: 'multi', t: 'En Perú y otros países' }];
  const VOL = ['Hasta USD 50 mil', 'USD 50 mil a 250 mil', 'USD 250 mil a 1 millón', 'USD 1 a 5 millones', 'Más de USD 5 millones'];
  const st = { act: [], stage: null, geo: null, vol: 1 };

  const act = RCT.options(document.getElementById('psAct'), ACT, { multi: true, onChange: (v) => { st.act = v; draw(); } });
  RCT.options(document.getElementById('psStage'), STAGE, { onChange: (v) => { st.stage = v; draw(); } });
  RCT.options(document.getElementById('psGeo'), GEO, { onChange: (v) => { st.geo = v; draw(); } });
  const vol = document.getElementById('psVol');
  vol.addEventListener('input', () => { st.vol = +vol.value; draw(); });

  const ICON = '<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>';
  function modules() {
    const a = new Set(st.act), m = [];
    if (!a.size) return m;
    m.push(['Evaluación de riesgos PSAV', 'Riesgos por servicio, cliente, canal y país.']);
    m.push(['Manual SPLAFT para PSAV', 'Políticas, procedimientos y funciones del oficial de cumplimiento.']);
    m.push(['Conocimiento del cliente', 'Onboarding, verificación de identidad y beneficiario final.']);
    if (st.stage !== 'mejora') m.push(['Registro y obligaciones ante la UIF', 'Inscripción que corresponda y calendario de obligaciones.']);
    if (a.has('fiat') || a.has('pagos') || a.has('otc') || st.vol >= 2) m.push(['Monitoreo de operaciones', 'Reglas y alertas según montos y frecuencia.']);
    if (a.has('swap') || a.has('custodia') || a.has('p2p') || a.has('fiat')) m.push(['Regla de viaje y análisis on-chain', 'Datos del originador y beneficiario, y trazabilidad en cadena.']);
    if (a.has('p2p')) m.push(['Controles para P2P', 'Reglas para contrapartes y prevención de cuentas puente.']);
    if (a.has('otc')) m.push(['Debida diligencia reforzada OTC', 'Clientes de alto monto y origen de fondos documentado.']);
    if (a.has('stable')) m.push(['Opinión legal sobre stablecoins y tokens', 'Estructura, riesgos y controles antes de salir al mercado.']);
    if (st.geo === 'multi') m.push(['Operación transfronteriza', 'Países de riesgo, sanciones y contrapartes extranjeras.']);
    if (st.stage === 'mejora') m.push(['Revisión independiente', 'Prueba del programa actual y plan de cierre de brechas.']);
    m.push(['Capacitación del equipo', 'Formación práctica según el rol de cada área.']);
    return m;
  }

  function draw() {
    document.getElementById('psVolTxt').textContent = VOL[st.vol];
    const m = modules();
    document.getElementById('psIntro').textContent = m.length ? 'Estos módulos responden a lo que usted describió.' : 'Elija al menos un servicio para ver la propuesta.';
    document.getElementById('psMods').innerHTML = m.map(([t, d]) => '<div class="ps-mod">' + ICON + '<div><b>' + t + '</b><span>' + d + '</span></div></div>').join('');
    const pct = Math.min(100, Math.round((m.length / 11) * 100));
    document.getElementById('psMeter').style.width = pct + '%';
    document.getElementById('psCount').textContent = m.length + (m.length === 1 ? ' módulo' : ' módulos');
    document.getElementById('psScope').textContent = !m.length ? '' : pct < 55 ? 'Programa esencial' : pct < 80 ? 'Programa intermedio' : 'Programa integral';
    RCT.summary(m.length ? [
      'Servicios: ' + st.act.map((v) => RCT.label(ACT, v)).join(', '),
      st.stage ? 'Etapa: ' + RCT.label(STAGE, st.stage) : '',
      st.geo ? 'Clientes: ' + RCT.label(GEO, st.geo) : '',
      'Volumen mensual: ' + VOL[st.vol],
      'Módulos sugeridos: ' + m.map((x) => x[0]).join('; '),
    ] : [], m.length ? { level: document.getElementById('psScope').textContent, title: 'Propuesta de programa de cumplimiento PSAV', priorities: m.map((x) => x[0] + ': ' + x[1]) } : {});
  }
  draw();
})();
</script>
@endsection
