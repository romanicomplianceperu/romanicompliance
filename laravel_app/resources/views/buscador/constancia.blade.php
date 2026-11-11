<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Constancia de búsqueda OFAC</title>
<style>
  @page { margin: 0; }
  body { font-family: 'DejaVu Sans', sans-serif; color: #0A1730; font-size: 10px; line-height: 1.5; margin: 0; }
  .hero { background: #0A1730; color: #fff; padding: 22px 40px 24px; }
  .pill { background: #fff; border-radius: 10px; padding: 6px 11px; display: inline-block; }
  .pill img { height: 22px; }
  .hero h1 { font-size: 20px; margin: 16px 0 4px; }
  .hero .sub { color: #C8D3EA; font-size: 10px; }
  .bar { height: 5px; background: #1F4FD8; }
  .body { padding: 16px 40px 60px; }
  table { border-collapse: collapse; width: 100%; }
  .meta td { padding: 7px 10px; background: #F4F6FA; border: 2px solid #fff; vertical-align: top; width: 25%; }
  .meta .k { display: block; color: #55647C; font-size: 8px; text-transform: uppercase; letter-spacing: .4px; }
  .meta .v { font-weight: bold; font-size: 10px; }
  .res { margin-top: 14px; border-radius: 10px; padding: 14px 16px; }
  .res.ok { background: #E1F3EC; color: #0E8A5F; }
  .res.hit { background: #FBEBDD; color: #8A3B0B; }
  .res b { font-size: 14px; display: block; margin-bottom: 2px; }
  h2 { font-size: 12px; margin: 16px 0 6px; }
  .list th { text-align: left; background: #EEF3FF; color: #1F4FD8; font-size: 8.5px; text-transform: uppercase; padding: 6px 8px; }
  .list td { padding: 6px 8px; border-bottom: 1px solid #E2E7F0; vertical-align: top; font-size: 9px; }
  .sc { font-weight: bold; color: #C0362C; }
  .note { color: #55647C; font-size: 8.5px; margin-top: 14px; line-height: 1.55; }
  .foot { position: fixed; bottom: 0; left: 0; right: 0; padding: 10px 40px; font-size: 8px; color: #8B97AA; border-top: 1px solid #E2E7F0; }
</style>
</head>
<body>
@php
  $types = ['i' => 'Personas', 'e' => 'Entidades', 'v' => 'Embarcaciones', 'a' => 'Aeronaves'];
  $filters = array_filter([
    $f['type'] ? 'Tipo: '.$types[$f['type']] : null,
    $f['list'] ? 'Lista: '.($f['list'] === 'S' ? 'SDN' : 'Consolidada (no SDN)') : null,
    $f['program'] ? 'Programa: '.\App\Support\Ofac\OfacPrograms::label($f['program']).' ('.$f['program'].')' : null,
    $f['country'] ? 'País: '.$f['country'] : null,
  ]);
  $min = max(50, min(100, (int) $f['min']));
  $pub = !empty($meta['published_at']) ? \Carbon\Carbon::parse($meta['published_at'])->timezone('America/Lima')->translatedFormat('j \d\e F \d\e Y') : 'No disponible';
@endphp
<div class="hero">
  <span class="pill">@if($logo !== 'data:image/png;base64,')<img src="{{ $logo }}" alt="Romani Compliance">@else<b style="color:#0A1730">ROMANI COMPLIANCE</b>@endif</span>
  <h1>Constancia de búsqueda en listas OFAC</h1>
  <div class="sub">Generada el {{ $now->translatedFormat('j \d\e F \d\e Y, g:i a') }} (hora de Lima) · Código {{ $code }}</div>
</div>
<div class="bar"></div>
<div class="body">
  <table class="meta"><tr>
    <td colspan="2"><span class="k">Nombre buscado</span><span class="v">{{ $q }}</span></td>
    <td><span class="k">Similitud mínima</span><span class="v">{{ $min }} %</span></td>
    <td><span class="k">Versión de la lista</span><span class="v">{{ $pub }}</span></td>
  </tr><tr>
    <td colspan="2"><span class="k">Listas consultadas</span><span class="v">OFAC · Lista SDN y lista consolidada (no SDN) · {{ number_format($meta['entities'] ?? 0, 0, ',', ' ') }} registros</span></td>
    <td colspan="2"><span class="k">Filtros</span><span class="v">{{ $filters ? implode(' · ', $filters) : 'Ninguno' }}</span></td>
  </tr>@if($ref)<tr><td colspan="4"><span class="k">Referencia</span><span class="v">{{ $ref }}</span></td></tr>@endif</table>

  @if(($res['total'] ?? 0) === 0)
    <div class="res ok"><b>Sin coincidencias</b>No se encontraron nombres en las listas de OFAC con al menos {{ $min }} % de similitud con «{{ $q }}».</div>
  @else
    <div class="res hit"><b>{{ $res['total'] }} {{ $res['total'] === 1 ? 'posible coincidencia' : 'posibles coincidencias' }}</b>Revise cada resultado con datos adicionales (documento, fecha de nacimiento, nacionalidad) antes de concluir que se trata de la misma persona o entidad.</div>
    <h2>Resultados{{ $res['total'] > count($res['results']) ? ' (los '.count($res['results']).' más parecidos)' : '' }}</h2>
    <table class="list">
      <tr><th style="width:42px">Similitud</th><th>Nombre en la lista</th><th style="width:70px">Tipo / lista</th><th>Programas</th><th style="width:55px">N.° OFAC</th></tr>
      @foreach($res['results'] as $r)
        <tr>
          <td class="sc">{{ $r['score'] }} %</td>
          <td><b>{{ $r['name'] }}</b>@if($r['matched_alias'])<br><span style="color:#55647C">Alias: {{ $r['matched'] }}</span>@endif
            @php $ids = array_slice(array_values(array_filter($r['facts'], fn ($x) => preg_match('/^(DOB|POB|nationality|Passport)/i', $x))), 0, 3); @endphp
            @if($ids)<br><span style="color:#55647C">{{ implode(' · ', $ids) }}</span>@endif</td>
          <td>{{ $r['type_label'] }}<br>{{ $r['list'] === 'S' ? 'SDN' : 'No SDN' }}</td>
          <td>{{ implode(', ', array_map(fn ($p) => $p['code'], $r['programs'])) }}</td>
          <td>{{ $r['id'] }}</td>
        </tr>
      @endforeach
    </table>
  @endif

  <p class="note">Fuente: archivos públicos de la Oficina de Control de Activos Extranjeros (OFAC) del Departamento del Tesoro de los EE. UU. (sanctionslistservice.ofac.treas.gov), versión indicada arriba. La búsqueda tolera diferencias de tildes, mayúsculas, orden de palabras y errores de tipeo; una coincidencia no implica identidad. Esta constancia documenta la consulta realizada y no constituye una certificación de OFAC ni una opinión legal. Romani Compliance no está afiliada a OFAC. Cada ficha puede verificarse en sanctionssearch.ofac.treas.gov con el número OFAC.</p>
</div>
<div class="foot">Romani Compliance · Buscador OFAC · romanicompliance.com/buscador · Código {{ $code }}</div>
</body>
</html>
