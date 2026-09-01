@extends('layouts.app')

@section('title', 'Personaliza tu capacitación — '.$course->title)

@php
  $ssIcons = [
    'notaria' => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/><path d="M9 13h6M9 17h6"/>',
    'casino' => '<rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8" cy="8" r="1.4"/><circle cx="16" cy="16" r="1.4"/><circle cx="12" cy="12" r="1.4"/><circle cx="8" cy="16" r="1.4"/><circle cx="16" cy="8" r="1.4"/>',
    'prestamos' => '<ellipse cx="12" cy="6" rx="7" ry="3"/><path d="M5 6v6c0 1.66 3.13 3 7 3s7-1.34 7-3V6"/><path d="M5 12v6c0 1.66 3.13 3 7 3s7-1.34 7-3v-6"/>',
    'casas_cambio' => '<path d="M17 3l4 4-4 4"/><path d="M21 7H9"/><path d="M7 21l-4-4 4-4"/><path d="M3 17h12"/>',
    'inmobiliaria' => '<path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-6h6v6"/>',
    'vehiculos' => '<path d="M3 13l2-5a2 2 0 012-1h10a2 2 0 012 1l2 5"/><path d="M3 13v5a1 1 0 001 1h1a1 1 0 001-1v-1h12v1a1 1 0 001 1h1a1 1 0 001-1v-5"/><circle cx="7.5" cy="16.5" r="1.5"/><circle cx="16.5" cy="16.5" r="1.5"/>',
    'joyas' => '<path d="M6 3h12l4 6-10 12L2 9z"/><path d="M2 9h20M9 3l3 6-3 12M15 3l-3 6 3 12"/>',
    'transferencia_fondos' => '<path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4z"/>',
    'cooperativas' => '<circle cx="9" cy="7" r="4"/><path d="M2 21v-2a4 4 0 014-4h6a4 4 0 014 4v2"/><circle cx="17.5" cy="7.5" r="3"/><path d="M22 21v-2a3.5 3.5 0 00-2.5-3.36"/>',
    'cripto' => '<circle cx="12" cy="12" r="9"/><path d="M9.5 9.5c0-1 1-1.5 2.5-1.5s2.5.5 2.5 1.5-1 1.3-2.5 1.5-2.5.5-2.5 1.5 1 1.5 2.5 1.5 2.5-.5 2.5-1.5"/><path d="M12 6.5v11"/>',
    'construccion' => '<path d="M3 21h18"/><path d="M6 21V10M18 21V6l-6-3-6 4"/><rect x="9" y="13" width="6" height="8"/>',
    'abogados_contadores' => '<path d="M12 3v18"/><path d="M5 7l-3 6a3 3 0 006 0z"/><path d="M19 7l-3 6a3 3 0 006 0z"/><path d="M5 7h14"/><path d="M8 21h8"/>',
    'general' => '<circle cx="12" cy="12" r="10"/><path d="M16.24 7.76l-2.12 6.36-6.36 2.12 2.12-6.36z"/>',
  ];
  $ssSectors = [
    ['value' => 'notaria', 'label' => 'Notaría',
      'sbs' => 'Los notarios son sujetos obligados a informar a la UIF-Perú conforme al artículo 3 de la Ley N.º 29038, en actos como compraventas, constitución de sociedades, poderes y transferencias patrimoniales que autorizan.',
      'adapt' => 'Los casos prácticos usarán compraventas, escrituras públicas, poderes e intervinientes; el simulador y los ejemplos de coincidencias girarán en torno al proceso notarial.'],
    ['value' => 'casino', 'label' => 'Casinos y máquinas tragamonedas',
      'sbs' => 'Las empresas que explotan juegos de casino y máquinas tragamonedas están comprendidas como sujetos obligados en el artículo 3 de la Ley N.º 29038.',
      'adapt' => 'Los casos prácticos usarán compra y canje de fichas, clientes frecuentes y operaciones incompatibles con el perfil del jugador.'],
    ['value' => 'prestamos', 'label' => 'Empresas de préstamos y empeños',
      'sbs' => 'Las empresas dedicadas al otorgamiento de préstamos y/o al empeño están sujetas a la Res. SBS N.º 4463-2016, que regula su gestión de riesgos de LA/FT.',
      'adapt' => 'Los casos prácticos usarán solicitantes de crédito, desembolsos, cancelaciones anticipadas por terceros y beneficiarios finales de empresas prestatarias.'],
    ['value' => 'casas_cambio', 'label' => 'Casas de cambio',
      'sbs' => 'Las casas de cambio de moneda extranjera son sujetos obligados conforme al artículo 3 de la Ley N.º 29038.',
      'adapt' => 'Los casos prácticos usarán operaciones sucesivas de cambio, distintos titulares en un mismo domicilio y fraccionamiento de montos.'],
    ['value' => 'inmobiliaria', 'label' => 'Empresas inmobiliarias / agentes inmobiliarios',
      'sbs' => 'Las empresas inmobiliarias y los agentes inmobiliarios están comprendidos como sujetos obligados en el artículo 3 de la Ley N.º 29038, cuando intervienen en la compraventa de inmuebles.',
      'adapt' => 'Los casos prácticos usarán compradores, vendedores, proyectos inmobiliarios, pagos de terceros y verificación del beneficiario final.'],
    ['value' => 'vehiculos', 'label' => 'Compra y venta de vehículos',
      'sbs' => 'Las empresas dedicadas a la compra y venta de vehículos están comprendidas como sujetos obligados en el artículo 3 de la Ley N.º 29038.',
      'adapt' => 'Los casos prácticos usarán compradores ocasionales, pagos fraccionados y operaciones incompatibles con la actividad declarada del cliente.'],
    ['value' => 'joyas', 'label' => 'Comercio de joyas y metales preciosos',
      'sbs' => 'Las empresas dedicadas al comercio de joyas, metales y piedras preciosas están comprendidas como sujetos obligados en el artículo 3 de la Ley N.º 29038.',
      'adapt' => 'Los casos prácticos usarán compras en efectivo de alto valor, clientes no habituales y reventa inmediata de piezas adquiridas.'],
    ['value' => 'transferencia_fondos', 'label' => 'Empresas de transferencia de fondos',
      'sbs' => 'Las empresas de transferencia de fondos son sujetos obligados conforme al artículo 3 de la Ley N.º 29038 y a la normativa específica de la UIF-Perú para este servicio.',
      'adapt' => 'Los casos prácticos usarán remesas fraccionadas, múltiples remitentes hacia un mismo beneficiario y corredores geográficos de mayor riesgo.'],
    ['value' => 'cooperativas', 'label' => 'Cooperativas de ahorro y crédito',
      'sbs' => 'Las cooperativas de ahorro y crédito no autorizadas a captar recursos del público están comprendidas como sujetos obligados en el artículo 3 de la Ley N.º 29038.',
      'adapt' => 'Los casos prácticos usarán socios aportantes, créditos entre socios y movimientos incompatibles con el perfil económico declarado.'],
    ['value' => 'cripto', 'label' => 'Proveedores de servicios de activos virtuales',
      'sbs' => 'Los Proveedores de Servicios de Activos Virtuales (PSAV) están sujetos a las directrices específicas de la Res. SBS N.º 02648-2024, que exige evaluar Clientes, Productos, Canales y Geografía.',
      'adapt' => 'Los casos prácticos usarán wallets, exchanges, contrapartes de transferencias y alertas de screening sobre direcciones de activos virtuales.'],
    ['value' => 'construccion', 'label' => 'Construcción y comercio exterior',
      'sbs' => 'Las empresas del sector construcción y comercio exterior pueden estar comprendidas como sujetos obligados según el artículo 3 de la Ley N.º 29038, según la actividad específica que realicen.',
      'adapt' => 'Los casos prácticos usarán proveedores internacionales, cadenas de intermediarios y pagos vinculados a comercio exterior.'],
    ['value' => 'abogados_contadores', 'label' => 'Abogados y contadores',
      'sbs' => 'Abogados y contadores pueden quedar comprendidos como sujetos obligados cuando la normativa vigente los incorpore para determinadas operaciones (constitución de sociedades, compraventa de inmuebles, gestión de fondos de clientes).',
      'adapt' => 'Los casos prácticos usarán constitución de sociedades, gestión de fondos de clientes y verificación del beneficiario final en estructuras societarias.'],
    ['value' => 'general', 'label' => 'Otro sujeto obligado / capacitación general',
      'sbs' => 'Si tu actividad no calza exactamente con las anteriores, revisa el artículo 3 de la Ley N.º 29038 y sus normas complementarias para identificar tu categoría específica ante la UIF-Perú.',
      'adapt' => 'Verás el contenido general del curso, aplicable a cualquier sujeto obligado, con casos representativos de varios sectores.'],
  ];
  foreach ($ssSectors as $i => $s) {
    $ssSectors[$i]['iconPath'] = $ssIcons[$s['value']] ?? $ssIcons['general'];
  }
@endphp

@section('styles')
.ss-full-shell { min-height: calc(100vh - 71px); background: var(--ivory); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2.6rem 1.5rem; }
.ss-full-inner { max-width: 920px; width: 100%; text-align: center; }
.ss-full-eyebrow { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--gold); margin-bottom: 0.7rem; }
.ss-full-title { font-family: var(--serif); font-weight: 600; font-size: clamp(1.6rem, 3.6vw, 2.2rem); color: var(--ink); margin-bottom: 0.6rem; }
.ss-full-lead { font-size: 0.92rem; color: var(--slate); max-width: 580px; margin: 0 auto 2rem; line-height: 1.6; }

.ss-picker { display: grid; grid-template-columns: 1fr 1.35fr; gap: 1.4rem; background: var(--white); border: 1px solid var(--line); border-radius: 14px; overflow: hidden; box-shadow: 0 10px 30px rgba(11,24,41,0.05); text-align: left; }
.ss-picker-list { border-right: 1px solid var(--line); max-height: 440px; overflow-y: auto; padding: 8px; }
.ss-picker-item { width: 100%; display: flex; align-items: center; gap: 10px; padding: 11px 12px; border-radius: 9px; border: none; background: none; text-align: left; cursor: pointer; font-size: 0.84rem; font-weight: 600; color: var(--ink); transition: background 0.15s; }
.ss-picker-item:hover { background: var(--ivory); }
.ss-picker-item.active { background: var(--gold-pale); color: var(--gold); }
.ss-picker-icon { width: 30px; height: 30px; border-radius: 8px; background: var(--ivory-dim); color: var(--slate); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: background 0.15s, color 0.15s; }
.ss-picker-icon svg { width: 16px; height: 16px; }
.ss-picker-item.active .ss-picker-icon { background: var(--gold); color: var(--white); }
.ss-picker-label { flex: 1; line-height: 1.3; }
.ss-picker-chevron { width: 14px; height: 14px; flex-shrink: 0; opacity: 0.4; }
.ss-picker-item.active .ss-picker-chevron { opacity: 1; }
.ss-picker-detail { padding: 2rem 1.8rem; display: flex; align-items: center; }
.ss-picker-empty { text-align: center; color: var(--slate-light); font-size: 0.85rem; margin: 0 auto; max-width: 300px; }
.ss-picker-empty .ss-empty-icon { width: 44px; height: 44px; margin: 0 auto 12px; color: var(--line); }
.ss-picker-content { width: 100%; }
.ss-picker-content h3 { font-family: var(--serif); font-size: 1.15rem; color: var(--ink); margin-bottom: 12px; }
.ss-norm-box { background: var(--ivory); border-left: 3px solid var(--gold); border-radius: 6px; padding: 14px 16px; margin-bottom: 12px; }
.ss-norm-eyebrow { font-size: 0.64rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gold); margin-bottom: 6px; }
.ss-norm-box p { font-size: 0.88rem; color: var(--ink); line-height: 1.65; font-weight: 500; }
.ss-adapt-row { display: flex; gap: 8px; align-items: flex-start; font-size: 0.83rem; color: var(--slate); line-height: 1.6; }
.ss-adapt-row svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 2px; color: #1F7A4D; }
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
.ss-prior-note { font-size: 0.78rem; color: var(--slate-light); margin-top: 10px; }
@endsection

@section('content')
<div class="ss-full-shell">
  <div class="ss-full-inner">
    <div class="ss-full-eyebrow">Personalicemos tu capacitación</div>
    <h1 class="ss-full-title">¿A qué tipo de sujeto obligado perteneces?</h1>
    <p class="ss-full-lead">Selecciona tu sector: los casos prácticos de este curso se destacarán para ti, priorizando la normativa aplicable a tu categoría.</p>

    <div class="ss-picker">
      <div class="ss-picker-list" id="ssPickerList">
        @foreach($ssSectors as $i => $s)
          <button type="button" class="ss-picker-item" data-index="{{ $i }}">
            <span class="ss-picker-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">{!! $s['iconPath'] !!}</svg></span>
            <span class="ss-picker-label">{{ $s['label'] }}</span>
            <svg class="ss-picker-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 6l6 6-6 6"/></svg>
          </button>
        @endforeach
      </div>
      <div class="ss-picker-detail" id="ssPickerDetail">
        <div class="ss-picker-empty" id="ssPickerEmpty">
          <svg class="ss-empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
          <p>Elige tu sector en la lista para ver qué dice la normativa sobre tu categoría.</p>
        </div>
        <div class="ss-picker-content" id="ssPickerContent" style="display:none;">
          <h3 id="ssPickerTitle"></h3>
          <div class="ss-norm-box">
            <div class="ss-norm-eyebrow">Normativa aplicable — SBS / UIF-Perú</div>
            <p id="ssPickerSbs"></p>
          </div>
          <div class="ss-adapt-row">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 13l4 4L19 7"/></svg>
            <span id="ssPickerAdapt"></span>
          </div>
        </div>
      </div>
    </div>

    <div class="ss-full-cta-row">
      <button type="button" class="ss-full-continue" id="ssContinueBtn">Continuar al curso →</button>
      <a href="{{ $nextUrl }}" class="ss-full-skip">Omitir por ahora</a>
    </div>
    <div class="ss-prior-note" id="ssPriorNote" style="display:none;"></div>
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

  const items = document.querySelectorAll('#ssPickerList .ss-picker-item');
  const continueBtn = document.getElementById('ssContinueBtn');
  let selectedValue = null;

  function select(index, silent) {
    const s = sectors[index];
    if (!s) return;
    items.forEach((it, i) => it.classList.toggle('active', i === index));
    document.getElementById('ssPickerEmpty').style.display = 'none';
    document.getElementById('ssPickerContent').style.display = 'block';
    document.getElementById('ssPickerTitle').textContent = s.label;
    document.getElementById('ssPickerSbs').textContent = s.sbs;
    document.getElementById('ssPickerAdapt').textContent = s.adapt;
    selectedValue = s.value;
    continueBtn.classList.add('enabled');
    if (!silent) items[index].scrollIntoView({ block: 'nearest' });
  }

  items.forEach((item, i) => item.addEventListener('click', () => select(i)));

  continueBtn.addEventListener('click', () => {
    if (!selectedValue) return;
    localStorage.setItem(storageKey, selectedValue);
    window.location.href = nextUrl;
  });

  // If they picked a sector before, pre-select it as a starting point —
  // but never navigate away automatically. They choose when to continue.
  const prior = localStorage.getItem(storageKey);
  if (prior) {
    const idx = sectors.findIndex(s => s.value === prior);
    if (idx >= 0) {
      select(idx, true);
      const note = document.getElementById('ssPriorNote');
      note.style.display = 'block';
      note.textContent = 'Ya habías elegido "' + sectors[idx].label + '". Puedes continuar así o elegir otro sector.';
    }
  }
})();
</script>
@endsection
