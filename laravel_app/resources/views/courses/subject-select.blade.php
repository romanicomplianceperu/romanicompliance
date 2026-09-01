@extends('layouts.app')

@section('title', 'Personaliza tu capacitación — '.$course->title)

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

@section('styles')
.ss-full-shell { min-height: calc(100vh - 71px); background: var(--ivory); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2.6rem 1.5rem; }
.ss-full-inner { max-width: 900px; width: 100%; text-align: center; }
.ss-full-eyebrow { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--gold); margin-bottom: 0.7rem; }
.ss-full-title { font-family: var(--serif); font-weight: 600; font-size: clamp(1.6rem, 3.6vw, 2.2rem); color: var(--ink); margin-bottom: 0.6rem; }
.ss-full-lead { font-size: 0.92rem; color: var(--slate); max-width: 560px; margin: 0 auto 2rem; line-height: 1.6; }

.ss-picker { display: grid; grid-template-columns: 1fr 1.3fr; gap: 1.4rem; background: var(--white); border: 1px solid var(--line); border-radius: 14px; overflow: hidden; box-shadow: 0 10px 30px rgba(11,24,41,0.05); text-align: left; }
.ss-picker-list { border-right: 1px solid var(--line); max-height: 420px; overflow-y: auto; padding: 8px; }
.ss-picker-item { width: 100%; display: flex; align-items: center; gap: 10px; padding: 12px 12px; border-radius: 9px; border: none; background: none; text-align: left; cursor: pointer; font-size: 0.85rem; font-weight: 600; color: var(--ink); transition: background 0.15s; }
.ss-picker-item:hover { background: var(--ivory); }
.ss-picker-item.active { background: var(--gold-pale); color: var(--gold); }
.ss-picker-icon { font-size: 1.1rem; flex-shrink: 0; }
.ss-picker-label { flex: 1; line-height: 1.3; }
.ss-picker-chevron { width: 14px; height: 14px; flex-shrink: 0; opacity: 0.4; }
.ss-picker-item.active .ss-picker-chevron { opacity: 1; }
.ss-picker-detail { padding: 2rem 1.8rem; display: flex; align-items: center; }
.ss-picker-empty { text-align: center; color: var(--slate-light); font-size: 0.85rem; margin: 0 auto; max-width: 280px; }
.ss-picker-empty span { font-size: 1.8rem; display: block; margin-bottom: 10px; }
.ss-picker-content { width: 100%; }
.ss-picker-eyebrow { font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gold); margin-bottom: 6px; }
.ss-picker-content h3 { font-family: var(--serif); font-size: 1.15rem; color: var(--ink); margin-bottom: 10px; }
.ss-picker-content p { font-size: 0.86rem; color: var(--slate); line-height: 1.65; }
@media (max-width: 800px) {
  .ss-picker { grid-template-columns: 1fr; }
  .ss-picker-list { border-right: none; border-bottom: 1px solid var(--line); max-height: 240px; }
  .ss-picker-detail { padding: 1.4rem; }
}

.ss-full-cta-row { display: flex; align-items: center; justify-content: center; gap: 14px; margin-top: 1.6rem; flex-wrap: wrap; }
.ss-full-continue { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--ink); font-weight: 700; font-size: 0.9rem; padding: 14px 30px; border-radius: 8px; border: none; cursor: pointer; opacity: 0.4; pointer-events: none; transition: opacity 0.2s ease, transform 0.2s ease; }
.ss-full-continue.enabled { opacity: 1; pointer-events: auto; }
.ss-full-continue:hover.enabled { transform: translateY(-2px); }
.ss-full-skip { font-size: 0.82rem; color: var(--slate-light); font-weight: 600; }
.ss-full-skip:hover { color: var(--slate); }
@endsection

@section('content')
<div class="ss-full-shell">
  <div class="ss-full-inner">
    <div class="ss-full-eyebrow">Personalicemos tu capacitación</div>
    <h1 class="ss-full-title">¿A qué tipo de sujeto obligado perteneces?</h1>
    <p class="ss-full-lead">Selecciona tu sector: los casos prácticos de este curso se destacarán para ti. A la derecha verás qué dice la normativa sobre tu categoría.</p>

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
          <p id="ssPickerAdapt" style="margin-top:10px;color:var(--gold);font-weight:600;"></p>
        </div>
      </div>
    </div>

    <div class="ss-full-cta-row">
      <button type="button" class="ss-full-continue" id="ssContinueBtn">Continuar al curso →</button>
      <a href="{{ $nextUrl }}" class="ss-full-skip">Omitir por ahora</a>
    </div>
  </div>
</div>

<script id="ssData" type="application/json">{!! json_encode($ssSectors) !!}</script>
@endsection

@section('scripts')
<script>
(function () {
  const sectors = JSON.parse(document.getElementById('ssData').textContent || '[]');
  const storageKey = 'rc_subject_{{ $course->id }}';
  const nextUrl = '{{ $nextUrl }}';

  // Already chosen before? Skip straight to the course.
  if (localStorage.getItem(storageKey)) {
    window.location.replace(nextUrl);
    return;
  }

  const items = document.querySelectorAll('#ssPickerList .ss-picker-item');
  const continueBtn = document.getElementById('ssContinueBtn');
  let selectedValue = null;

  function select(index) {
    const s = sectors[index];
    if (!s) return;
    items.forEach((it, i) => it.classList.toggle('active', i === index));
    document.getElementById('ssPickerEmpty').style.display = 'none';
    document.getElementById('ssPickerContent').style.display = 'block';
    document.getElementById('ssPickerTitle').textContent = s.label;
    document.getElementById('ssPickerSbs').textContent = s.sbs;
    document.getElementById('ssPickerAdapt').textContent = '✓ ' + s.adapt;
    selectedValue = s.value;
    continueBtn.classList.add('enabled');
  }

  items.forEach((item, i) => item.addEventListener('click', () => select(i)));

  continueBtn.addEventListener('click', () => {
    if (!selectedValue) return;
    localStorage.setItem(storageKey, selectedValue);
    window.location.href = nextUrl;
  });
})();
</script>
@endsection
