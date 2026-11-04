@extends('site.services._base')

@section('page_styles')
.dx-gaps { display: grid; gap: 12px; margin-top: 18px; }
.dx-gap { display: flex; gap: 14px; padding: 16px 18px; border-radius: 14px; background: var(--soft); }
.dx-gap .ic { color: var(--warn); width: 22px; height: 22px; margin-top: 2px; }
.dx-gap b { display: block; }
.dx-gap span { color: var(--muted); font-size: 0.95rem; }
@endsection

@section('tool')
<div class="tool" id="dx">
  <div class="tool-progress" id="dxBar"></div>
  <div id="dxPane"></div>
</div>
@endsection

@section('tool_scripts')
<script>
(function () {
  const Q = [
    { k: 'sector', q: '¿A qué se dedica su organización?', h: 'Nos ayuda a saber qué normas le aplican.', type: 'radio', o: [
      { v: 'obligado', t: 'Es sujeto obligado ante la UIF', s: 'Banca, seguros, PSAV, inmobiliaria, notaría, casa de cambio, entre otros' },
      { v: 'estado', t: 'Contrata con el Estado', s: 'Licitaciones, concesiones u obras públicas' },
      { v: 'otra', t: 'Otra actividad empresarial', s: 'Comercio, servicios, industria' },
    ] },
    { k: 'oficial', w: 15, q: '¿Tienen un oficial de cumplimiento designado?', fix: 'Designar al oficial de cumplimiento y aprobar su plan anual.' },
    { k: 'manual', w: 15, q: '¿Cuentan con un manual SPLAFT o modelo de prevención actualizado en el último año?', fix: 'Actualizar el manual o el modelo de prevención a su operación actual.' },
    { k: 'matriz', w: 15, q: '¿Tienen una matriz de riesgos LA/FT documentada?', fix: 'Elaborar la matriz de riesgos y priorizar los controles.' },
    { k: 'codigo', w: 10, q: '¿Existe un código de conducta y un canal de denuncias que el personal conoce?', fix: 'Aprobar el código de conducta y habilitar un canal de denuncias confiable.' },
    { k: 'ddc', w: 15, q: '¿Aplican debida diligencia a clientes, proveedores y socios?', fix: 'Implementar la debida diligencia con niveles según el riesgo de cada contraparte.' },
    { k: 'capac', w: 10, q: '¿El personal recibe capacitación en prevención al menos una vez al año?', fix: 'Programar la capacitación anual del personal y registrar la asistencia.' },
    { k: 'audit', w: 10, q: '¿Revisan o auditan el sistema de forma periódica?', fix: 'Establecer una revisión periódica independiente del sistema.' },
    { k: 'autoridad', q: '¿Han recibido requerimientos o visitas de la UIF, la SBS u otra autoridad en los últimos dos años?', h: 'No suma puntos: nos dice qué tan urgente es avanzar.', type: 'yn' },
  ];
  const YNP = [{ v: 1, t: 'Sí' }, { v: 0.5, t: 'En parte' }, { v: 0, t: 'No' }];
  const YN = [{ v: 'si', t: 'Sí' }, { v: 'no', t: 'No' }];
  const A = {};
  let i = 0;
  const bar = document.getElementById('dxBar');
  const pane = document.getElementById('dxPane');
  bar.innerHTML = Q.map(() => '<i></i>').join('') + '<i></i>';

  function paintBar() { [...bar.children].forEach((b, n) => b.classList.toggle('on', n <= i)); }

  function render() {
    paintBar();
    if (i >= Q.length) return result();
    const q = Q[i];
    pane.innerHTML = '<div class="tool-pane"><div class="muted" style="font-weight:700;margin-bottom:10px">Pregunta ' + (i + 1) + ' de ' + Q.length + '</div>'
      + '<div class="tool-q">' + q.q + '</div><div class="tool-hint">' + (q.h || 'Responda según lo que existe hoy, aunque no esté completo.') + '</div>'
      + '<div id="dxOpts"></div><div class="tool-nav"><button type="button" class="b b-ghost b-sm" id="dxBack"' + (i ? '' : ' style="visibility:hidden"') + '>Anterior</button><span class="muted" style="font-size:.9rem">Toque una opción para continuar</span></div></div>';
    const list = q.type === 'radio' ? q.o : (q.type === 'yn' ? YN : YNP);
    RCT.options(document.getElementById('dxOpts'), list, { value: A[q.k], onChange: (v) => { A[q.k] = v; setTimeout(() => { i++; render(); }, 260); } });
    document.getElementById('dxBack').onclick = () => { i--; render(); };
  }

  function result() {
    const scored = Q.filter((q) => q.w);
    const total = scored.reduce((s, q) => s + q.w, 0);
    const got = scored.reduce((s, q) => s + q.w * (A[q.k] ?? 0), 0);
    const pct = Math.round((got / total) * 100);
    const lvl = pct >= 75 ? ['ok', 'Sistema sólido', 'Su base es buena. Conviene mantenerla al día y documentar su funcionamiento.', '#0E8A5F']
      : pct >= 45 ? ['warn', 'Brechas importantes', 'Tiene avances, pero hay piezas que una revisión observaría.', '#C25B12']
      : ['bad', 'Exposición alta', 'Faltan los elementos centrales de un sistema de prevención.', '#C0362C'];
    const gaps = scored.filter((q) => (A[q.k] ?? 0) < 1).sort((a, b) => b.w - a.w);
    const urgent = A.autoridad === 'si';
    const sectorTxt = { obligado: 'Como sujeto obligado, la UIF puede supervisar su sistema: estas brechas deben cerrarse primero.', estado: 'Si contrata con el Estado, un modelo de prevención bajo la Ley 30424 protege a la empresa frente a responsabilidades.', otra: 'Un modelo de prevención bajo la Ley 30424 puede atenuar o eximir la responsabilidad de la empresa.' }[A.sector] || '';

    pane.innerHTML = '<div class="tool-pane"><div class="result">'
      + '<div class="gauge" id="dxGauge"><svg viewBox="0 0 200 200"><circle class="track" cx="100" cy="100" r="88" fill="none" stroke-width="14"/><circle class="val" cx="100" cy="100" r="88" fill="none" stroke-width="14"/></svg><div class="num"><div><b>0</b><span>de 100</span></div></div></div>'
      + '<div><span class="pill ' + lvl[0] + '">' + lvl[1] + '</span>' + (urgent ? ' <span class="pill bad">Atención prioritaria</span>' : '')
      + '<p class="h3" style="margin:14px 0 8px">' + lvl[2] + '</p><p class="muted">' + sectorTxt + (urgent ? ' Tuvo contacto reciente con una autoridad: recomendamos revisar el sistema cuanto antes.' : '') + '</p>'
      + (gaps.length ? '<div style="font-weight:800;margin-top:24px">Sus prioridades</div><div class="dx-gaps">' + gaps.slice(0, 4).map((g, n) => '<div class="dx-gap"><svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3.5l9.5 16.5h-19L12 3.5z"/><path d="M12 10v4.5M12 17.5h.01"/></svg><div><b>' + (n + 1) + '. ' + g.fix + '</b><span>' + (A[g.k] === 0.5 ? 'Existe en parte.' : 'No existe todavía.') + '</span></div></div>').join('') + '</div>' : '')
      + '<div class="tool-nav"><button type="button" class="b b-ghost b-sm" id="dxAgain">Volver a empezar</button><a href="#contactar" class="b b-primary">Revisar este resultado con el equipo</a></div>'
      + '<p class="note">Resultado orientativo, basado solo en sus respuestas. No reemplaza una evaluación legal.</p></div></div></div>';
    RC.gauge(document.getElementById('dxGauge'), pct, lvl[3]);
    document.getElementById('dxAgain').onclick = () => { for (const k in A) delete A[k]; i = 0; render(); RCT.summary([]); };
    RCT.summary([
      'Diagnóstico de riesgo: ' + pct + '/100 (' + lvl[1] + ')',
      'Actividad: ' + RCT.label(Q[0].o, A.sector),
      urgent ? 'Tuvimos contacto reciente con una autoridad.' : '',
      gaps.length ? 'Prioridades: ' + gaps.slice(0, 3).map((g) => g.fix.replace(/\.$/, '').toLowerCase()).join('; ') + '.' : '',
    ]);
  }
  render();
})();
</script>
@endsection
