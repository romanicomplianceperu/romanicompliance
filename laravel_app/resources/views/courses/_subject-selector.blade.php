@php
  $ssSectors = [
    ['value' => 'notaria', 'label' => 'Notaría', 'icon' => '📜',
      'sbs' => 'Los notarios son sujetos obligados a informar a la UIF-Perú conforme al artículo 3 de la Ley N.º 29038, en actos como compraventas, constitución de sociedades, poderes y transferencias patrimoniales que autorizan.',
      'adapt' => 'Los casos prácticos usarán compraventas, escrituras públicas, poderes e intervinientes; el simulador y los ejemplos de coincidencias girarán en torno al proceso notarial.'],
    ['value' => 'casino', 'label' => 'Casinos y máquinas tragamonedas', 'icon' => '🎰',
      'sbs' => 'Las empresas que explotan juegos de casino y máquinas tragamonedas están comprendidas como sujetos obligados en el artículo 3 de la Ley N.º 29038.',
      'adapt' => 'Los casos prácticos usarán compra y canje de fichas, clientes frecuentes y operaciones incompatibles con el perfil del jugador.'],
    ['value' => 'prestamos', 'label' => 'Empresas de préstamos y empeños', 'icon' => '💳',
      'sbs' => 'Las empresas dedicadas al otorgamiento de préstamos y/o al empeño están sujetas a la Res. SBS N.º 4463-2016, que regula su gestión de riesgos de LA/FT.',
      'adapt' => 'Los casos prácticos usarán solicitantes de crédito, desembolsos, cancelaciones anticipadas por terceros y beneficiarios finales de empresas prestatarias.'],
    ['value' => 'casas_cambio', 'label' => 'Casas de cambio', 'icon' => '💱',
      'sbs' => 'Las casas de cambio de moneda extranjera son sujetos obligados conforme al artículo 3 de la Ley N.º 29038.',
      'adapt' => 'Los casos prácticos usarán operaciones sucesivas de cambio, distintos titulares en un mismo domicilio y fraccionamiento de montos.'],
    ['value' => 'inmobiliaria', 'label' => 'Empresas inmobiliarias / agentes inmobiliarios', 'icon' => '🏗️',
      'sbs' => 'Las empresas inmobiliarias y los agentes inmobiliarios están comprendidos como sujetos obligados en el artículo 3 de la Ley N.º 29038, cuando intervienen en la compraventa de inmuebles.',
      'adapt' => 'Los casos prácticos usarán compradores, vendedores, proyectos inmobiliarios, pagos de terceros y verificación del beneficiario final.'],
    ['value' => 'vehiculos', 'label' => 'Compra y venta de vehículos', 'icon' => '🚗',
      'sbs' => 'Las empresas dedicadas a la compra y venta de vehículos están comprendidas como sujetos obligados en el artículo 3 de la Ley N.º 29038.',
      'adapt' => 'Los casos prácticos usarán compradores ocasionales, pagos fraccionados y operaciones incompatibles con la actividad declarada del cliente.'],
    ['value' => 'joyas', 'label' => 'Comercio de joyas y metales preciosos', 'icon' => '💎',
      'sbs' => 'Las empresas dedicadas al comercio de joyas, metales y piedras preciosas están comprendidas como sujetos obligados en el artículo 3 de la Ley N.º 29038.',
      'adapt' => 'Los casos prácticos usarán compras en efectivo de alto valor, clientes no habituales y reventa inmediata de piezas adquiridas.'],
    ['value' => 'transferencia_fondos', 'label' => 'Empresas de transferencia de fondos', 'icon' => '💸',
      'sbs' => 'Las empresas de transferencia de fondos son sujetos obligados conforme al artículo 3 de la Ley N.º 29038 y a la normativa específica de la UIF-Perú para este servicio.',
      'adapt' => 'Los casos prácticos usarán remesas fraccionadas, múltiples remitentes hacia un mismo beneficiario y corredores geográficos de mayor riesgo.'],
    ['value' => 'cooperativas', 'label' => 'Cooperativas de ahorro y crédito', 'icon' => '🏦',
      'sbs' => 'Las cooperativas de ahorro y crédito no autorizadas a captar recursos del público están comprendidas como sujetos obligados en el artículo 3 de la Ley N.º 29038.',
      'adapt' => 'Los casos prácticos usarán socios aportantes, créditos entre socios y movimientos incompatibles con el perfil económico declarado.'],
    ['value' => 'cripto', 'label' => 'Proveedores de servicios de activos virtuales', 'icon' => '🪙',
      'sbs' => 'Los Proveedores de Servicios de Activos Virtuales (PSAV) están sujetos a las directrices específicas de la Res. SBS N.º 02648-2024, que exige evaluar Clientes, Productos, Canales y Geografía.',
      'adapt' => 'Los casos prácticos usarán wallets, exchanges, contrapartes de transferencias y alertas de screening sobre direcciones de activos virtuales.'],
    ['value' => 'construccion', 'label' => 'Construcción y comercio exterior', 'icon' => '🏢',
      'sbs' => 'Las empresas del sector construcción y comercio exterior pueden estar comprendidas como sujetos obligados según el artículo 3 de la Ley N.º 29038, según la actividad específica que realicen.',
      'adapt' => 'Los casos prácticos usarán proveedores internacionales, cadenas de intermediarios y pagos vinculados a comercio exterior.'],
    ['value' => 'abogados_contadores', 'label' => 'Abogados y contadores', 'icon' => '⚖️',
      'sbs' => 'Abogados y contadores pueden quedar comprendidos como sujetos obligados cuando la normativa vigente los incorpore para determinadas operaciones (constitución de sociedades, compraventa de inmuebles, gestión de fondos de clientes).',
      'adapt' => 'Los casos prácticos usarán constitución de sociedades, gestión de fondos de clientes y verificación del beneficiario final en estructuras societarias.'],
    ['value' => 'general', 'label' => 'Otro sujeto obligado / capacitación general', 'icon' => '🧭',
      'sbs' => 'Si tu actividad no calza exactamente con las anteriores, revisa el artículo 3 de la Ley N.º 29038 y sus normas complementarias para identificar tu categoría específica ante la UIF-Perú.',
      'adapt' => 'Verás el contenido general del curso, aplicable a cualquier sujeto obligado, con casos representativos de varios sectores.'],
  ];
@endphp

<section class="rd-section" id="rdSubjectSelector">
  <div class="wrap">
    <div class="rd-eyebrow">Personalización</div>
    <h2>¿A qué tipo de sujeto obligado perteneces?</h2>
    <p class="rd-section-lead">Selecciona tu sector: los casos prácticos de este curso se destacarán para ti. A la derecha verás qué dice la normativa sobre tu categoría.</p>

    <div class="ss-picker">
      <div class="ss-picker-list" id="ssPickerList">
        @foreach($ssSectors as $i => $s)
          <button type="button" class="ss-picker-item" data-index="{{ $i }}">
            <span class="ss-picker-icon">{{ $s['icon'] }}</span>
            <span class="ss-picker-label">{{ $s['label'] }}</span>
            <svg class="ss-picker-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 6l6 6-6 6"/></svg>
          </button>
        @endforeach
      </div>
      <div class="ss-picker-detail" id="ssPickerDetail">
        <div class="ss-picker-empty" id="ssPickerEmpty">
          <span>👈</span>
          <p>Elige tu sector en la lista para ver qué dice la normativa sobre tu categoría.</p>
        </div>
        <div class="ss-picker-content" id="ssPickerContent" style="display:none;">
          <div class="ss-picker-eyebrow">Según la SBS / UIF-Perú</div>
          <h3 id="ssPickerTitle"></h3>
          <p id="ssPickerSbs"></p>
        </div>
      </div>
    </div>

    <div class="ss-adapt" id="ssAdapt" style="display:none;">
      <span class="ss-adapt-icon">✓</span>
      <div>
        <strong>Así se ajustará tu curso</strong>
        <p id="ssAdaptText"></p>
      </div>
    </div>
  </div>
</section>

<script id="ssData" type="application/json">{!! json_encode($ssSectors) !!}</script>
<script>
(function () {
  const dataEl = document.getElementById('ssData');
  if (!dataEl) return;
  const sectors = JSON.parse(dataEl.textContent || '[]');
  const storageKey = 'rc_subject_{{ $course->id }}';
  const items = document.querySelectorAll('#ssPickerList .ss-picker-item');

  function select(index, save) {
    const s = sectors[index];
    if (!s) return;
    items.forEach((it, i) => it.classList.toggle('active', i === index));
    document.getElementById('ssPickerEmpty').style.display = 'none';
    document.getElementById('ssPickerContent').style.display = 'block';
    document.getElementById('ssPickerTitle').textContent = s.label;
    document.getElementById('ssPickerSbs').textContent = s.sbs;
    document.getElementById('ssAdaptText').textContent = s.adapt;
    document.getElementById('ssAdapt').style.display = 'flex';
    if (save) localStorage.setItem(storageKey, s.value);
  }

  items.forEach((item, i) => item.addEventListener('click', () => select(i, true)));

  const saved = localStorage.getItem(storageKey);
  if (saved) {
    const idx = sectors.findIndex(s => s.value === saved);
    if (idx >= 0) select(idx, false);
  }
})();
</script>
