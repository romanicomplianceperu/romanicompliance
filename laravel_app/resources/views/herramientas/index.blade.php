@extends('layouts.site')

@section('title', 'Herramientas y recursos de compliance gratuitos · Romani Compliance')
@section('description', 'Herramientas gratuitas para oficiales de cumplimiento en el Perú: buscador OFAC, buscador de normas LA/FT de la SBS y la UIF-Perú, y diagnóstico de riesgo de compliance.')
@section('og_image', asset('images/og-herramientas.jpg'))

@section('og_extra')
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'CollectionPage',
  'name' => 'Herramientas y recursos de compliance',
  'url' => route('herramientas'),
  'inLanguage' => 'es-PE',
  'publisher' => ['@type' => 'Organization', 'name' => 'Romani Compliance', 'url' => url('/')],
  'hasPart' => [
    ['@type' => 'WebApplication', 'name' => 'Buscador OFAC', 'url' => route('buscador'), 'applicationCategory' => 'BusinessApplication', 'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'PEN']],
    ['@type' => 'WebApplication', 'name' => 'Buscador de normas LA/FT', 'url' => route('herramientas.normas'), 'applicationCategory' => 'BusinessApplication', 'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'PEN']],
  ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('styles')
.hr-hero { background: var(--ink); color: #fff; padding: clamp(44px, 6vw, 80px) 0 clamp(36px, 5vw, 56px); }
.hr-hero .lead { color: rgba(255,255,255,.72); margin-top: 16px; max-width: 680px; }
.hr-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
@media (max-width: 980px) { .hr-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 640px) { .hr-grid { grid-template-columns: 1fr; } }
.hr-card { position: relative; display: flex; flex-direction: column; gap: 12px; padding: 26px; border: 1px solid var(--line); border-radius: 24px; background: #fff; transition: transform .35s var(--ease), border-color .3s, box-shadow .3s; }
a.hr-card:hover { transform: translateY(-4px); border-color: var(--blue); box-shadow: 0 24px 50px -32px rgba(10,23,48,.5); }
.hr-card.feat { background: var(--ink); color: #fff; border-color: transparent; grid-column: span 2; }
@media (max-width: 640px) { .hr-card.feat { grid-column: auto; } }
.hr-card.feat p { color: rgba(255,255,255,.72); }
.hr-card.feat .icon-tile { background: rgba(127,163,255,.16); color: var(--blue-l); }
.hr-card.feat .lnk { color: var(--blue-l); }
.hr-card h2 { font-size: 1.3rem; font-weight: 800; letter-spacing: -0.02em; line-height: 1.25; }
.hr-card p { color: var(--muted); }
.hr-card .lnk { margin-top: auto; padding-top: 4px; }
.hr-badge { position: absolute; top: 22px; right: 22px; font-size: .74rem; font-weight: 800; padding: 4px 10px; border-radius: 999px; background: #E1F3EC; color: #0E8A5F; }
.hr-card.feat .hr-badge { background: rgba(61,220,151,.16); color: #7CE0B5; }
.hr-card.soon { background: var(--soft); border-style: dashed; }
.hr-card.soon .hr-badge { background: #EEF0F4; color: var(--muted); }
.hr-stats { display: flex; gap: 10px 22px; flex-wrap: wrap; font-size: .9rem; color: rgba(255,255,255,.7); }
.hr-stats b { color: #fff; }
@endsection

@section('content')
<section class="hr-hero">
  <div class="wrap">
    <div class="kicker rv">Herramientas y recursos</div>
    <h1 class="display rv">Busque rápido. Decida con datos.</h1>
    <p class="lead rv">Herramientas gratuitas para oficiales de cumplimiento, abogados y equipos de riesgo: listas de sanciones, normativa de prevención LA/FT y diagnósticos, en un solo lugar y sin registrarse.</p>
  </div>
</section>

<section class="sec">
  <div class="wrap hr-grid">
    <a href="{{ route('buscador') }}" class="hr-card feat rv">
      <span class="hr-badge">Disponible</span>
      <span class="icon-tile">@include('site.partials.icon', ['name' => 'search'])</span>
      <h2>Buscador de listas OFAC</h2>
      <p>Verifique en segundos si una persona, empresa, embarcación o aeronave figura en la lista SDN o en la lista consolidada del Tesoro de EE. UU. Tolera errores de tipeo, sugiere nombres mientras escribe y entrega constancia en PDF.</p>
      <div class="hr-stats"><span><b>Actualización automática</b> desde los archivos oficiales</span><span><b>Varios nombres</b> a la vez</span></div>
      <span class="lnk">Abrir el buscador @include('site.partials.icon', ['name' => 'arrow'])</span>
    </a>
    <a href="{{ route('herramientas.normas') }}" class="hr-card rv" style="--d:.05s">
      <span class="hr-badge">Disponible</span>
      <span class="icon-tile">@include('site.partials.icon', ['name' => 'book'])</span>
      <h2>Buscador de normas LA/FT</h2>
      <p>Busque por número, tema o sujeto obligado entre {{ $normasCount }} resoluciones SBS, decretos y leyes de prevención LA/FT, y abra la norma original publicada en El Peruano.</p>
      <span class="lnk">Buscar normas @include('site.partials.icon', ['name' => 'arrow'])</span>
    </a>
    <a href="{{ route('services.show', 'compliance-penal') }}#herramienta" class="hr-card rv">
      <span class="hr-badge">Disponible</span>
      <span class="icon-tile">@include('site.partials.icon', ['name' => 'shield'])</span>
      <h2>Diagnóstico de riesgo</h2>
      <p>Nueve preguntas para medir qué tan preparado está su sistema de prevención (Ley 30424 y SPLAFT), con un puntaje de 0 a 100 e informe en PDF.</p>
      <span class="lnk">Hacer el diagnóstico @include('site.partials.icon', ['name' => 'arrow'])</span>
    </a>
    <a href="{{ route('services.show', 'criptoactivos-psav') }}#herramienta" class="hr-card rv" style="--d:.05s">
      <span class="hr-badge">Disponible</span>
      <span class="icon-tile">@include('site.partials.icon', ['name' => 'coin'])</span>
      <h2>Programa PSAV a medida</h2>
      <p>Configure el programa de cumplimiento que necesita su exchange, billetera o mesa OTC según su modelo y volumen.</p>
      <span class="lnk">Configurar @include('site.partials.icon', ['name' => 'arrow'])</span>
    </a>
    <a href="{{ route('certificates.verify.form') }}" class="hr-card rv" style="--d:.1s">
      <span class="hr-badge">Disponible</span>
      <span class="icon-tile">@include('site.partials.icon', ['name' => 'check'])</span>
      <h2>Verificar certificado</h2>
      <p>Compruebe la validez de un certificado de capacitación emitido por Romani Compliance con su código.</p>
      <span class="lnk">Verificar @include('site.partials.icon', ['name' => 'arrow'])</span>
    </a>
    <div class="hr-card soon rv">
      <span class="hr-badge">Próximamente</span>
      <span class="icon-tile">@include('site.partials.icon', ['name' => 'alert'])</span>
      <h2>Listas ONU y GAFI</h2>
      <p>Lista consolidada del Consejo de Seguridad de la ONU y jurisdicciones de alto riesgo del GAFI, con la misma búsqueda rápida.</p>
    </div>
  </div>
</section>
@endsection
