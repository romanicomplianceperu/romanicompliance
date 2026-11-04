@extends('site.services._base')

@section('page_styles')
.pmap { margin-top: 34px; }
.pm-track { display: grid; grid-auto-flow: column; grid-auto-columns: 1fr; gap: 0; position: relative; }
.pm-track::before { content: ''; position: absolute; left: 6%; right: 6%; top: 25px; height: 2px; background: var(--line); }
.pm-prog { position: absolute; left: 6%; top: 25px; height: 2px; background: var(--blue); width: 0; transition: width .6s var(--ease); }
.pm-node { position: relative; z-index: 1; background: none; border: 0; cursor: pointer; text-align: center; padding: 0 6px; }
.pm-node .d { width: 52px; height: 52px; margin: 0 auto 12px; border-radius: 50%; border: 2px solid var(--line); background: #fff; display: grid; place-items: center; font-weight: 800; color: var(--muted-2); transition: all .35s var(--ease); }
.pm-node.done .d { border-color: var(--blue); color: var(--blue); }
.pm-node.cur .d { background: var(--blue); border-color: var(--blue); color: #fff; transform: scale(1.12); box-shadow: 0 0 0 8px rgba(31,79,216,.12); }
.pm-node b { display: block; font-size: .92rem; line-height: 1.3; }
.pm-node.cur b { color: var(--blue); }
.pm-panel { margin-top: 34px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.pm-panel .card { padding: 24px; }
.pm-panel h4 { font-size: .95rem; font-weight: 800; margin-bottom: 10px; display: flex; gap: 8px; align-items: center; }
.pm-panel h4 .ic { width: 18px; height: 18px; color: var(--blue); }
.pm-panel .card.err h4 .ic { color: var(--warn); }
.pm-panel p { color: var(--muted); }
@media (max-width: 900px) {
  .pm-track { grid-auto-flow: row; grid-auto-columns: auto; gap: 12px; }
  .pm-track::before { left: 25px; right: auto; top: 10px; bottom: 10px; width: 2px; height: auto; }
  .pm-prog { left: 25px; top: 10px; width: 2px !important; height: 0; transition: height .6s var(--ease); }
  .pm-node { display: grid; grid-template-columns: 52px 1fr; gap: 14px; align-items: center; text-align: left; padding: 0; }
  .pm-node .d { margin: 0; }
  .pm-panel { grid-template-columns: 1fr; }
}
@endsection

@section('tool')
<div class="tool">
  <div class="tool-q" style="font-size:1.2rem">¿Cuál es la materia?</div>
  <div id="dpMat" style="margin-top:12px"></div>
  <div class="pmap">
    <div class="tool-q" style="font-size:1.2rem">¿En qué etapa está? <span class="muted" style="font-weight:600;font-size:1rem">Toque la etapa.</span></div>
    <div class="pm-track" id="dpTrack" style="margin-top:22px"></div>
    <div id="dpPanel"></div>
  </div>
</div>
@endsection

@section('tool_scripts')
<script>
(function () {
  const MAT = [
    { v: 'lavado', t: 'Lavado de activos' },
    { v: 'admin', t: 'Delitos contra la administración pública', s: 'Colusión, cohecho, negociación incompatible' },
    { v: 'pj', t: 'Responsabilidad de la empresa', s: 'Ley 30424' },
    { v: 'otro', t: 'Otro delito económico', s: 'Tributario, aduanero, fraude, estafa' },
    { v: 'ext', t: 'Extinción de dominio', s: 'Proceso sobre bienes' },
  ];
  const PENAL = [
    ['Antes de la investigación', 'Hay un riesgo, una denuncia anunciada o un informe en curso, pero aún no existe citación.', 'Revisamos documentos, preparamos su versión con soporte y evaluamos medidas preventivas.', 'Dar explicaciones por escrito o en medios sin asesoría.'],
    ['Diligencias preliminares', 'La Fiscalía reúne información inicial: citaciones, declaraciones y pedidos de documentos.', 'Le acompañamos en cada declaración, revisamos lo que se entrega y planteamos los primeros argumentos.', 'Acudir solo a declarar o entregar documentos sin revisarlos.'],
    ['Investigación preparatoria', 'La Fiscalía formaliza la investigación y pueden pedirse medidas sobre personas o bienes.', 'Ofrecemos pericias de parte, cuestionamos medidas y pedimos diligencias a su favor.', 'Dejar pasar los plazos para pedir actos de investigación.'],
    ['Etapa intermedia', 'Se controla si la Fiscalía acusa o pide el sobreseimiento y se admiten las pruebas para el juicio.', 'Observamos la acusación, pedimos el sobreseimiento si corresponde y ofrecemos prueba.', 'Llegar sin prueba ofrecida a tiempo.'],
    ['Juicio oral', 'Se actúa la prueba ante el juzgado y se dicta sentencia.', 'Defensa en audiencia, examen de testigos y peritos, y alegatos.', 'Improvisar la teoría del caso.'],
    ['Recursos', 'La sentencia puede apelarse y, en ciertos casos, llevarse en casación.', 'Preparamos la apelación o la casación con los agravios precisos.', 'Apelar sin fundamentar agravios concretos.'],
  ];
  const EXT = [
    ['Indagación patrimonial', 'La Fiscalía investiga el origen o el destino de los bienes.', 'Reunimos la prueba de la licitud de los bienes desde el inicio.', 'Esperar a la demanda para empezar a documentar.'],
    ['Demanda y medidas', 'Se presenta la demanda y pueden dictarse medidas sobre los bienes.', 'Contestamos la demanda y cuestionamos las medidas desproporcionadas.', 'No oponerse a tiempo a las medidas.'],
    ['Audiencias', 'Se actúan los medios probatorios ante el juzgado.', 'Sustentamos la licitud con pericias y documentos.', 'Prueba desordenada o incompleta.'],
    ['Sentencia', 'El juzgado decide si declara o no la extinción de dominio.', 'Alegatos finales sobre el origen lícito de los bienes.', 'Descuidar a los terceros de buena fe involucrados.'],
    ['Apelación', 'La decisión puede ser revisada por la instancia superior.', 'Recurso con los agravios concretos de la sentencia.', 'Apelar sin precisar los errores de la decisión.'],
  ];
  const st = { m: 'lavado', e: null };
  RCT.options(document.getElementById('dpMat'), MAT, { value: 'lavado', onChange: (v) => { st.m = v; st.e = null; build(); } });
  const track = document.getElementById('dpTrack');
  const panel = document.getElementById('dpPanel');
  const ic = (p) => '<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' + p + '</svg>';

  function stages() { return st.m === 'ext' ? EXT : PENAL; }
  function build() {
    const S = stages();
    track.innerHTML = '<span class="pm-prog" id="dpProg"></span>' + S.map((s, n) => '<button type="button" class="pm-node" data-n="' + n + '"><span class="d">' + (n + 1) + '</span><b>' + s[0] + '</b></button>').join('');
    track.querySelectorAll('.pm-node').forEach((b) => b.addEventListener('click', () => { st.e = +b.dataset.n; paint(); }));
    paint();
  }
  function paint() {
    const S = stages();
    track.querySelectorAll('.pm-node').forEach((b, n) => { b.classList.toggle('cur', n === st.e); b.classList.toggle('done', st.e !== null && n < st.e); });
    const prog = document.getElementById('dpProg');
    const frac = st.e === null ? 0 : st.e / (S.length - 1);
    if (matchMedia('(max-width: 900px)').matches) { prog.style.height = 'calc((100% - 20px) * ' + frac + ')'; } else { prog.style.width = 'calc(88% * ' + frac + ')'; }
    if (st.e === null) { panel.innerHTML = '<p class="muted" style="margin-top:26px">Elija la etapa en la que se encuentra para ver qué ocurre en ella.</p>'; RCT.summary(['Materia: ' + RCT.label(MAT, st.m)]); return; }
    const s = S[st.e];
    panel.innerHTML = '<div class="pm-panel tool-pane">'
      + '<div class="card"><h4>' + ic('<circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/>') + 'Qué ocurre</h4><p>' + s[1] + '</p></div>'
      + '<div class="card"><h4>' + ic('<path d="M5 12.5l4.5 4.5L19 7.5"/>') + 'Qué hacemos</h4><p>' + s[2] + '</p></div>'
      + '<div class="card err"><h4>' + ic('<path d="M12 3.5l9.5 16.5h-19L12 3.5z"/><path d="M12 10v4.5M12 17.5h.01"/>') + 'Error frecuente</h4><p>' + s[3] + '</p></div></div>'
      + '<div class="tool-nav"><span class="muted">' + (st.m === 'ext' ? 'La extinción de dominio corre por separado del proceso penal.' : 'Toda persona tiene derecho a ser asistida por un abogado desde la primera diligencia.') + '</span><a href="#contactar" class="b b-primary">Evaluar mi caso con el equipo</a></div>';
    RCT.summary(['Materia: ' + RCT.label(MAT, st.m), 'Etapa: ' + s[0]]);
  }
  addEventListener('resize', paint);
  build();
})();
</script>
@endsection
