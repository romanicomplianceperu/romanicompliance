<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ficha OFAC · {{ $r['name'] }}</title>
<style>
  @page { margin: 0; }
  body { font-family: 'DejaVu Sans', sans-serif; color: #0A1730; font-size: 10px; line-height: 1.5; margin: 0; }
  .hero { background: #0A1730; color: #fff; padding: 22px 40px 22px; }
  .pill { background: #fff; border-radius: 10px; padding: 6px 11px; display: inline-block; }
  .pill img { height: 22px; }
  .ref { float: right; text-align: right; color: #9FB4E0; font-size: 9px; }
  .ref b { color: #fff; font-size: 11px; display: block; }
  .kick { margin-top: 16px; font-size: 9px; letter-spacing: .5px; color: #7FA3FF; font-weight: bold; text-transform: uppercase; }
  .hero h1 { font-size: 20px; margin: 4px 0 8px; line-height: 1.2; }
  .tag { display: inline-block; padding: 3px 9px; border-radius: 9px; font-size: 8.5px; font-weight: bold; margin-right: 4px; background: #1F4FD8; color: #fff; }
  .tag.g { background: #2A3B5C; }
  .bar { height: 5px; background: #1F4FD8; }
  .body { padding: 16px 40px 60px; }
  table { border-collapse: collapse; width: 100%; }
  .meta td { padding: 7px 10px; background: #F4F6FA; border: 2px solid #fff; vertical-align: top; }
  .k { display: block; color: #55647C; font-size: 8px; text-transform: uppercase; letter-spacing: .4px; }
  .v { font-weight: bold; font-size: 10px; }
  .score { font-size: 18px; font-weight: bold; color: #C0362C; }
  h2 { font-size: 11.5px; margin: 16px 0 6px; padding-bottom: 4px; border-bottom: 2px solid #EEF3FF; }
  .rows td { padding: 5px 8px; border-bottom: 1px solid #E2E7F0; vertical-align: top; font-size: 9.5px; }
  .rows td.k2 { width: 150px; color: #55647C; }
  .cols td { vertical-align: top; width: 50%; padding-right: 12px; }
  ul { margin: 0; padding-left: 14px; }
  li { margin-bottom: 3px; }
  .link { margin-top: 14px; background: #EEF3FF; border-radius: 10px; padding: 10px 14px; }
  .link a { color: #1F4FD8; font-weight: bold; text-decoration: none; }
  .note { color: #55647C; font-size: 8.5px; margin-top: 12px; line-height: 1.55; }
  .foot { position: fixed; bottom: 0; left: 0; right: 0; padding: 10px 40px; font-size: 8px; color: #8B97AA; border-top: 1px solid #E2E7F0; }
</style>
</head>
<body>
@php
  $labels = ['DOB' => 'Fecha de nacimiento', 'POB' => 'Lugar de nacimiento', 'nationality' => 'Nacionalidad', 'citizen' => 'Ciudadanía', 'Passport' => 'Pasaporte', 'Gender' => 'Género', 'Cedula No.' => 'Cédula', 'National ID No.' => 'Documento nacional', 'alt. DOB' => 'Otra fecha de nacimiento', 'alt. POB' => 'Otro lugar de nacimiento', 'alt. Passport' => 'Otro pasaporte', 'Website' => 'Sitio web', 'Email Address' => 'Correo', 'Phone Number' => 'Teléfono', 'Organization Established Date' => 'Fecha de constitución', 'Organization Type:' => 'Tipo de organización', 'Registration Number' => 'N.° de registro', 'Tax ID No.' => 'N.° tributario', 'RFC' => 'RFC', 'CURP' => 'CURP', 'NIT #' => 'NIT', 'IMO' => 'IMO', 'Vessel Registration Identification' => 'Registro de la nave', 'Secondary sanctions risk:' => 'Riesgo de sanciones secundarias', 'Linked To:' => 'Vinculado a'];
  $vals = ['Male' => 'Masculino', 'Female' => 'Femenino'];
  $facts = [];
  foreach ($r['facts'] as $f) {
      $done = false;
      foreach ($labels as $k => $l) {
          if (str_starts_with($f, $k.' ')) { $v = trim(substr($f, strlen($k))); $facts[] = [$l, $vals[$v] ?? $v]; $done = true; break; }
      }
      if (! $done) { $facts[] = ['Otros datos', $f]; }
  }
  $pub = !empty($meta['published_at']) ? \Carbon\Carbon::parse($meta['published_at'])->timezone('America/Lima')->translatedFormat('j \d\e F \d\e Y') : 'No disponible';
@endphp
<div class="hero">
  <div class="ref"><b>N.° OFAC {{ $r['id'] }}</b>Código {{ $code }}</div>
  <span class="pill">@if($logo !== 'data:image/png;base64,')<img src="{{ $logo }}" alt="Romani Compliance">@else<b style="color:#0A1730">ROMANI COMPLIANCE</b>@endif</span>
  <div class="kick">Ficha de lista de sanciones · OFAC</div>
  <h1>{{ $r['name'] }}</h1>
  <span class="tag">{{ $r['list'] === 'S' ? 'Lista SDN' : 'Lista consolidada (no SDN)' }}</span><span class="tag g">{{ $r['type_label'] }}</span>@if($r['countries'])<span class="tag g">{{ implode(', ', array_slice($r['countries'], 0, 3)) }}</span>@endif
</div>
<div class="bar"></div>
<div class="body">
  <table class="meta"><tr>
    @if($q)<td style="width:34%"><span class="k">Búsqueda que lo encontró</span><span class="v">{{ $q }}</span>@if($matched && $matched !== $r['name'])<br><span style="color:#55647C">Coincidió con el alias: {{ $matched }}</span>@endif</td>@endif
    @if($score !== null)<td style="width:16%"><span class="k">Similitud</span><span class="score">{{ $score }} %</span></td>@endif
    <td><span class="k">Versión de la lista</span><span class="v">{{ $pub }}</span></td>
    <td><span class="k">Generada</span><span class="v">{{ $now->translatedFormat('j M Y, g:i a') }}</span><br><span style="color:#55647C">hora de Lima</span></td>
  </tr></table>

  <h2>Programas de sanción</h2>
  <table class="rows">@foreach($r['programs'] as $p)<tr><td class="k2">{{ $p['code'] }}</td><td>{{ $p['label'] }}</td></tr>@endforeach</table>

  @if($facts || $r['title'])
    <h2>Datos de identificación</h2>
    <table class="rows">
      @if($r['title'])<tr><td class="k2">Cargo</td><td>{{ $r['title'] }}</td></tr>@endif
      @foreach($facts as [$l, $v])<tr><td class="k2">{{ $l }}</td><td>{{ $v }}</td></tr>@endforeach
    </table>
  @endif

  @if($r['vessel'])
    <h2>Datos de la nave</h2>
    <table class="rows">@foreach($r['vessel'] as $k => $v)<tr><td class="k2">{{ $k }}</td><td>{{ $v }}</td></tr>@endforeach</table>
  @endif

  <table class="cols" style="margin-top:4px"><tr>
    <td>
      <h2>También conocido como ({{ count($r['aliases']) }})</h2>
      @if($r['aliases'])<ul>@foreach($r['aliases'] as $a)<li>{{ $a['name'] }} <span style="color:#8B97AA">({{ $a['kind'] }})</span></li>@endforeach</ul>@else<span style="color:#8B97AA">Sin alias registrados.</span>@endif
    </td>
    <td>
      <h2>Direcciones ({{ count($r['addresses']) }})</h2>
      @if($r['addresses'])<ul>@foreach($r['addresses'] as $a)<li>{{ $a }}</li>@endforeach</ul>@else<span style="color:#8B97AA">Sin direcciones registradas.</span>@endif
    </td>
  </tr></table>

  <div class="link">Ficha oficial: <a href="{{ $r['ofac_url'] }}">{{ $r['ofac_url'] }}</a></div>
  <p class="note">Fuente: archivos públicos de la Oficina de Control de Activos Extranjeros (OFAC) del Departamento del Tesoro de los EE. UU., versión indicada arriba. La similitud indica cuánto se parece el nombre buscado al de la lista; una coincidencia no implica identidad: confírmela con documentos, fecha de nacimiento, nacionalidad o dirección. Este documento no es una certificación de OFAC ni una opinión legal. Romani Compliance no está afiliada a OFAC.</p>
</div>
<div class="foot">Romani Compliance · Buscador OFAC · romanicompliance.com/buscador · N.° OFAC {{ $r['id'] }} · Código {{ $code }}</div>
</body>
</html>
