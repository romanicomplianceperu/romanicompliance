@extends('site.services._base')

@section('page_styles')
.caf-urg { display: flex; gap: 6px; margin: 14px 0 6px; }
.caf-urg i { flex: 1; height: 12px; border-radius: 6px; background: var(--soft); transition: background .5s var(--ease); }
.caf-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-top: 26px; }
.caf-cols .card { padding: 24px; }
.caf-cols h4 { font-size: 1.05rem; font-weight: 800; margin-bottom: 14px; }
.caf-cols ol { list-style: none; counter-reset: n; display: grid; gap: 12px; }
.caf-cols ol li { counter-increment: n; display: grid; grid-template-columns: 30px 1fr; gap: 10px; color: var(--muted); }
.caf-cols ol li::before { content: counter(n); width: 26px; height: 26px; border-radius: 50%; background: var(--blue-50); color: var(--blue); font-weight: 800; font-size: .85rem; display: grid; place-items: center; }
@media (max-width: 760px) { .caf-cols { grid-template-columns: 1fr; } }
@endsection

@section('tool')
<div class="tool" id="caf">
  <div class="tool-progress" id="cafBar"><i></i><i></i><i></i><i></i><i></i></div>
  <div id="cafPane"></div>
</div>
@endsection

@section('tool_scripts')
<script>
(function () {
  const S = [
    { k: 'quien', q: '¿Quién está afectado?', o: [{ v: 'persona', t: 'Una persona natural' }, { v: 'empresa', t: 'Una empresa' }, { v: 'ambos', t: 'La empresa y sus socios o directivos' }] },
    { k: 'que', q: '¿Qué ocurrió?', o: [
      { v: 'inmov', t: 'El banco me informó que mis fondos están inmovilizados', w: 3 },
      { v: 'resol', t: 'Recibí una notificación o una resolución', w: 3 },
      { v: 'docs', t: 'Me piden documentos o información', s: 'La UIF, el banco u otra entidad', w: 2 },
      { v: 'prev', t: 'Todavía nada, pero quiero prepararme', w: 0 },
    ] },
    { k: 'cuando', q: '¿Cuándo ocurrió?', o: [{ v: 'hoy', t: 'Hoy o ayer', w: 3 }, { v: 'semana', t: 'Esta semana', w: 2 }, { v: 'antes', t: 'Hace más de una semana', w: 1 }, { v: 'na', t: 'No aplica', w: 0 }] },
    { k: 'docs', q: '¿Tiene documentos que acrediten el origen de los fondos?', o: [{ v: 'si', t: 'Sí, completos', s: 'Contratos, facturas, estados de cuenta', w: 0 }, { v: 'parcial', t: 'Algunos', w: 1 }, { v: 'no', t: 'No o no sé cuáles', w: 2 }] },
  ];
  const A = {};
  let i = 0;
  const bar = document.getElementById('cafBar');
  const pane = document.getElementById('cafPane');
  const paint = () => [...bar.children].forEach((b, n) => b.classList.toggle('on', n <= i));
  const w = (k) => (S.find((s) => s.k === k).o.find((o) => o.v === A[k]) || {}).w || 0;

  function render() {
    paint();
    if (i >= S.length) return result();
    const s = S[i];
    pane.innerHTML = '<div class="tool-pane"><div class="muted" style="font-weight:700;margin-bottom:10px">Paso ' + (i + 1) + ' de ' + S.length + '</div><div class="tool-q">' + s.q + '</div><div class="tool-hint">Elija la opción que más se parece a su situación.</div><div id="cafOpts"></div>'
      + '<div class="tool-nav"><button type="button" class="b b-ghost b-sm" id="cafBack"' + (i ? '' : ' style="visibility:hidden"') + '>Anterior</button></div></div>';
    RCT.options(document.getElementById('cafOpts'), s.o, { value: A[s.k], onChange: (v) => { A[s.k] = v; setTimeout(() => { i++; render(); }, 260); } });
    document.getElementById('cafBack').onclick = () => { i--; render(); };
  }

  function result() {
    const score = w('que') + (A.que === 'prev' ? 0 : w('cuando')) + w('docs');
    const lvl = score >= 6 ? ['bad', 'Urgencia alta', 5, '#C0362C'] : score >= 3 ? ['warn', 'Urgencia media', 3, '#C25B12'] : ['info', 'Preventivo', 1, '#1F4FD8'];
    const now = A.que === 'prev'
      ? ['Ordene los documentos que acreditan el origen de sus fondos: contratos, facturas, declaraciones y estados de cuenta.', 'Identifique qué cuentas y operaciones podrían generar preguntas por su monto o frecuencia.', 'Converse con nosotros para preparar un expediente de respaldo antes de que lo pidan.']
      : ['Conserve la notificación o el mensaje del banco tal como lo recibió, con fecha y hora.', 'No entregue explicaciones informales ni firme declaraciones antes de revisar la medida con un abogado.', 'Reúna todo documento que acredite el origen de los fondos, aunque esté incompleto.', 'Contáctenos hoy: revisaremos la resolución y los plazos que corren.'];
    const we = ['Leemos la medida y su base legal en la Ley 27693.', A.docs === 'si' ? 'Organizamos su documentación en un expediente de origen de fondos.' : 'Reconstruimos el origen de los fondos y le decimos qué documentos faltan.', 'Preparamos las respuestas a la UIF y a las entidades involucradas.', 'Coordinamos con la defensa penal ante una eventual investigación.'];
    pane.innerHTML = '<div class="tool-pane"><span class="pill ' + lvl[0] + '">' + lvl[1] + '</span>'
      + '<div class="caf-urg" id="cafUrg">' + '<i></i>'.repeat(5) + '</div>'
      + '<p class="h3" style="margin-top:14px">' + (A.que === 'prev' ? 'Prepararse a tiempo hace la diferencia.' : 'Lo importante ahora es actuar con orden y sin improvisar.') + '</p>'
      + '<div class="caf-cols"><div class="card"><h4>Qué hacer ahora</h4><ol>' + now.map((x) => '<li>' + x + '</li>').join('') + '</ol></div>'
      + '<div class="card"><h4>Lo que haremos</h4><ol>' + we.map((x) => '<li>' + x + '</li>').join('') + '</ol></div></div>'
      + '<div class="tool-nav"><button type="button" class="b b-ghost b-sm" id="cafAgain">Volver a empezar</button><a href="#contactar" class="b b-primary">Revisar mi caso con el equipo</a></div>'
      + '<p class="note">Orientación general basada en sus respuestas. Cada medida debe revisarse con el documento a la vista.</p></div>';
    setTimeout(() => document.querySelectorAll('#cafUrg i').forEach((b, n) => { if (n < lvl[2]) b.style.background = lvl[3]; }), 80);
    document.getElementById('cafAgain').onclick = () => { for (const k in A) delete A[k]; i = 0; render(); RCT.summary([]); };
    RCT.summary(['Evaluación CAF: ' + lvl[1], 'Afectado: ' + RCT.label(S[0].o, A.quien), 'Situación: ' + RCT.label(S[1].o, A.que), 'Cuándo: ' + RCT.label(S[2].o, A.cuando), 'Documentos de origen: ' + RCT.label(S[3].o, A.docs)], { level: lvl[1], title: 'Evaluación de su caso de congelamiento', priorities: now });
  }
  render();
})();
</script>
@endsection
