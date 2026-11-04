@extends('site.services._base')

@section('page_styles')
.ap-out { margin-top: 30px; display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.ap-out .card { padding: 26px; }
.ap-out h4 { font-size: 1.05rem; font-weight: 800; margin-bottom: 14px; }
@media (max-width: 760px) { .ap-out { grid-template-columns: 1fr; } }
.vs { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.vs .card { padding: 34px; }
.vs .card.now { border-color: var(--blue); box-shadow: 0 24px 60px -34px rgba(31,79,216,.45); }
.vs h3 { font-size: 1.4rem; font-weight: 800; letter-spacing: -0.02em; margin: 14px 0 18px; }
.vs .bar { height: 8px; border-radius: 8px; background: var(--soft); overflow: hidden; margin-top: 6px; }
.vs .bar i { display: block; height: 100%; width: 0; border-radius: 8px; transition: width 1.4s var(--ease); }
.vs .row { margin-top: 16px; font-weight: 600; font-size: .95rem; }
.vs .row span { color: var(--muted); font-weight: 500; float: right; }
@media (max-width: 760px) { .vs { grid-template-columns: 1fr; } }
@endsection

@section('tool')
<div class="tool">
  <div id="apDec"></div>
  <div style="margin-top:26px"><div class="tool-q" style="font-size:1.2rem">¿Con qué plazo cuenta?</div><div id="apWhen" style="margin-top:12px"></div></div>
  <div id="apOut"></div>
</div>
@endsection

@section('extra')
<section class="sec">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">El momento importa</div><h2 class="h2 rv">Consultar antes cuesta menos.</h2></div><p class="lead rv" style="max-width:460px">La misma pregunta tiene respuestas muy distintas según se haga antes o después de firmar.</p></div>
    <div class="vs" id="vs">
      <div class="card now rv"><span class="pill info">Antes de decidir</span><h3>Todavía puede ajustar la operación.</h3>
        <div class="row">Margen para negociar <span>Amplio</span></div><div class="bar"><i data-w="92" style="background:var(--blue)"></i></div>
        <div class="row">Costo de corregir <span>Bajo</span></div><div class="bar"><i data-w="18" style="background:var(--blue)"></i></div>
        <div class="row">Exposición penal y regulatoria <span>Controlada</span></div><div class="bar"><i data-w="22" style="background:var(--blue)"></i></div></div>
      <div class="card rv" style="--d:.08s"><span class="pill bad">Después del problema</span><h3>Solo queda defenderse.</h3>
        <div class="row">Margen para negociar <span>Escaso</span></div><div class="bar"><i data-w="16" style="background:var(--bad)"></i></div>
        <div class="row">Costo de corregir <span>Alto</span></div><div class="bar"><i data-w="88" style="background:var(--bad)"></i></div>
        <div class="row">Exposición penal y regulatoria <span>Abierta</span></div><div class="bar"><i data-w="84" style="background:var(--bad)"></i></div></div>
    </div>
  </div>
</section>
@endsection

@section('tool_scripts')
<script>
(function () {
  const DEC = [
    { v: 'contrato', t: 'Firmar un contrato con un tercero nuevo', review: ['Quién es realmente la contraparte y su beneficiario final', 'Antecedentes, listas y noticias relevantes', 'Cláusulas de pago, intermediarios y comisiones'], get: ['Opinión sobre la contraparte', 'Cláusulas anticorrupción y LA/FT para el contrato'] },
    { v: 'estado', t: 'Contratar o negociar con el Estado', review: ['Contactos con funcionarios y registro de reuniones', 'Intermediarios, consultores y pagos asociados', 'Riesgos de delitos contra la administración pública'], get: ['Protocolo de relación con funcionarios', 'Mapa de contingencias penales'] },
    { v: 'operacion', t: 'Una operación de alto valor', s: 'Compra, venta, inversión o préstamo', review: ['Origen y destino de los fondos', 'Estructura de la operación y vehículos usados', 'Señales de alerta LA/FT'], get: ['Opinión previa sobre la operación', 'Recomendaciones de estructura y documentación'] },
    { v: 'socio', t: 'Incorporar un socio o adquirir una empresa', review: ['Debida diligencia de la empresa y sus socios', 'Contingencias penales, tributarias y regulatorias', 'Historial de cumplimiento del objetivo'], get: ['Informe de due diligence', 'Cláusulas de declaraciones y garantías'] },
    { v: 'autoridad', t: 'Responder a un requerimiento de una autoridad', s: 'UIF, SBS, Fiscalía, SUNAT u otra', review: ['Qué pide exactamente y con qué base legal', 'Qué información entregar y cómo presentarla', 'Riesgo de autoincriminación de la empresa o sus directivos'], get: ['Proyecto de respuesta', 'Estrategia de comunicación con la autoridad'] },
    { v: 'interno', t: 'Una denuncia o un hallazgo interno', review: ['Hechos, personas involucradas y evidencia disponible', 'Obligaciones de reporte y plazos', 'Medidas inmediatas para preservar la evidencia'], get: ['Plan de investigación interna', 'Recomendaciones sobre reporte y sanciones'] },
  ];
  const WHEN = [{ v: 'urgente', t: 'Esta semana' }, { v: 'mes', t: 'Este mes' }, { v: 'abierto', t: 'Sin fecha definida' }];
  const st = { d: null, w: null };
  RCT.options(document.getElementById('apDec'), DEC, { onChange: (v) => { st.d = v; draw(); } });
  RCT.options(document.getElementById('apWhen'), WHEN, { onChange: (v) => { st.w = v; draw(); } });
  const LI = (x) => '<li>' + RCT.check + ' <span>' + x + '</span></li>';

  function draw() {
    const d = DEC.find((x) => x.v === st.d);
    const out = document.getElementById('apOut');
    if (!d) { out.innerHTML = ''; RCT.summary([]); return; }
    const pr = { urgente: ['bad', 'Priorizamos su revisión'], mes: ['warn', 'Revisión planificada'], abierto: ['info', 'Revisión con calma'] }[st.w] || null;
    out.innerHTML = '<div class="tool-pane">' + (pr ? '<div style="margin-top:28px"><span class="pill ' + pr[0] + '">' + pr[1] + '</span></div>' : '')
      + '<div class="ap-out"><div class="card"><h4>Lo que revisaríamos</h4><ul class="ticks">' + d.review.map(LI).join('') + '</ul></div>'
      + '<div class="card"><h4>Lo que recibiría</h4><ul class="ticks">' + d.get.map(LI).join('') + LI('Una opinión escrita con medidas concretas') + '</ul></div></div>'
      + '<div class="tool-nav"><span class="muted">Le confirmamos el plazo de entrega en la primera conversación.</span><a href="#contactar" class="b b-primary">Consultar esta decisión</a></div></div>';
    out.querySelectorAll('.ticks .ic').forEach((i) => i.setAttribute('stroke-width', '2'));
    RCT.summary(['Decisión: ' + d.t, st.w ? 'Plazo: ' + RCT.label(WHEN, st.w) : '']);
  }

  // Barras de la comparación: se llenan al entrar en pantalla
  const vs = document.getElementById('vs');
  new IntersectionObserver((es, o) => es.forEach((e) => { if (e.isIntersecting) { vs.querySelectorAll('.bar i').forEach((b) => (b.style.width = b.dataset.w + '%')); o.disconnect(); } }), { threshold: 0.3 }).observe(vs);
})();
</script>
@endsection
