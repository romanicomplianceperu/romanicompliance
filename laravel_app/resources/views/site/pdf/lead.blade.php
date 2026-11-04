<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>{{ $lead->documentTitle() }} · Romani Compliance</title>
<style>
  @page { margin: 0; }
  body { font-family: 'DejaVu Sans', sans-serif; color: #0A1730; font-size: 11px; line-height: 1.55; margin: 0; }
  .top { background: #0A1730; color: #fff; padding: 22px 40px 24px; }
  .top img { height: 30px; }
  .top .brand { font-size: 11px; color: #7FA3FF; margin-top: 18px; }
  .top h1 { font-size: 24px; margin: 6px 0 4px; font-weight: bold; }
  .top .sub { color: #C8D3EA; font-size: 11px; }
  .bar { height: 5px; background: #1F4FD8; }
  .body { padding: 18px 40px 50px; }
  .meta td { padding: 3px 14px 3px 0; font-size: 10.5px; vertical-align: top; }
  .meta .k { color: #55647C; }
  h2 { font-size: 13.5px; margin: 16px 0 6px; color: #0A1730; }
  .score { width: 100%; border-collapse: collapse; margin-top: 12px; }
  .score td { vertical-align: middle; }
  .score .num { width: 130px; text-align: center; background: #EEF3FF; border-radius: 10px; padding: 16px 0; }
  .score .num b { font-size: 38px; color: #1F4FD8; display: block; line-height: 1; }
  .score .num span { color: #55647C; font-size: 10px; }
  .score .txt { padding-left: 20px; }
  .lvl { display: inline-block; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 10.5px; }
  .lvl.ok { background: #E1F3EC; color: #0E8A5F; } .lvl.warn { background: #FBEBDD; color: #C25B12; } .lvl.bad { background: #F8E1DF; color: #C0362C; } .lvl.info { background: #EEF3FF; color: #1F4FD8; }
  .list { width: 100%; border-collapse: collapse; }
  .list td { padding: 5px 10px; border-bottom: 1px solid #E2E7F0; vertical-align: top; }
  .list td.n { width: 22px; color: #1F4FD8; font-weight: bold; }
  .steps td { padding: 4px 0; vertical-align: middle; }
  .steps .n { width: 26px; }
  .steps .n span { display: inline-block; width: 18px; height: 18px; line-height: 18px; text-align: center; border-radius: 9px; background: #1F4FD8; color: #fff; font-size: 9.5px; font-weight: bold; }
  .contact { margin-top: 16px; background: #F4F6FA; border-radius: 10px; padding: 14px 16px; }
  .contact td { padding: 2px 16px 2px 0; font-size: 10.5px; }
  .note { color: #8B97AA; font-size: 9px; margin-top: 16px; }
  .foot { position: fixed; bottom: 0; left: 0; right: 0; padding: 12px 40px; font-size: 9px; color: #8B97AA; border-top: 1px solid #E2E7F0; }
</style>
</head>
<body>
@php
  $lines = $lead->data['lines'] ?? array_filter(explode("\n", $lead->summary));
  $priorities = $lead->data['priorities'] ?? [];
  if ($priorities) { $lines = array_values(array_filter($lines, fn ($l) => ! str_starts_with($l, 'Prioridades:'))); }
  $lvlClass = match (true) { $lead->score === null => 'info', $lead->score >= 75 => 'ok', $lead->score >= 45 => 'warn', default => 'bad' };
@endphp
<div style="padding:20px 40px 16px"><table style="width:100%"><tr><td>@if($logo !== 'data:image/png;base64,')<img src="{{ $logo }}" alt="Romani Compliance" style="height:30px">@else<b>ROMANI COMPLIANCE</b>@endif</td><td style="text-align:right;color:#55647C;font-size:10px">Solicitud RC-{{ str_pad($lead->id, 5, '0', STR_PAD_LEFT) }}</td></tr></table></div>
<div class="top">
  <div class="brand" style="margin-top:0">ROMANI COMPLIANCE · {{ $lead->service_name }}</div>
  <h1>{{ $lead->data['title'] ?? $lead->documentTitle() }}</h1>
  <div class="sub">Preparado para {{ $lead->organization ?: $lead->name }} · {{ $lead->created_at->timezone('America/Lima')->translatedFormat('d \d\e F \d\e Y') }}</div>
</div>
<div class="bar"></div>
<div class="body">
  <table class="meta">
    <tr>@if($lead->name !== $lead->organization)<td class="k">Solicitante</td><td>{{ $lead->name }}</td>@endif @if($lead->organization)<td class="k">Organización</td><td>{{ $lead->organization }}</td>@endif @if($lead->phone)<td class="k">Teléfono</td><td>{{ $lead->phone }}</td>@endif</tr>
    <tr><td class="k">Servicio</td><td>{{ $lead->service_name }}</td><td class="k">N.° de solicitud</td><td>RC-{{ str_pad($lead->id, 5, '0', STR_PAD_LEFT) }}</td></tr>
  </table>

  @if($lead->score !== null)
    <table class="score"><tr>
      <td class="num"><b>{{ $lead->score }}</b><span>de 100</span></td>
      <td class="txt">@if($lead->level)<span class="lvl {{ $lvlClass }}">{{ $lead->level }}</span>@endif
        <p style="margin-top:8px;color:#55647C">Este puntaje mide qué tan preparado está su sistema de prevención según sus respuestas. Un puntaje alto indica una base sólida; uno bajo, que faltan elementos centrales.</p></td>
    </tr></table>
  @elseif($lead->level)
    <p style="margin-top:16px"><span class="lvl info">{{ $lead->level }}</span></p>
  @endif

  <h2>Lo que nos indicó</h2>
  <table class="list">@foreach($lines as $l)<tr><td class="n">·</td><td>{{ $l }}</td></tr>@endforeach</table>

  @if($priorities)
    <h2>Sus prioridades</h2>
    <table class="list">@foreach($priorities as $i => $p)<tr><td class="n">{{ $i + 1 }}</td><td>{{ $p }}</td></tr>@endforeach</table>
  @endif

  <h2>Próximos pasos</h2>
  <table class="steps">
    <tr><td class="n"><span>1</span></td><td>Un abogado del equipo revisa este resumen y le contacta para entender el contexto.</td></tr>
    <tr><td class="n"><span>2</span></td><td>Coordinamos una primera conversación para precisar el alcance y los plazos.</td></tr>
    <tr><td class="n"><span>3</span></td><td>Le enviamos una propuesta de trabajo concreta, con entregables y fechas.</td></tr>
  </table>

  <div class="contact">
    <b>¿Conversamos?</b>
    <table><tr><td>WhatsApp: +51 969 754 983</td><td>Correo: denis@romanicompliance.com</td><td>Web: romanicompliance.com</td></tr></table>
  </div>
  <p class="note">Documento orientativo generado a partir de las respuestas ingresadas en romanicompliance.com. No constituye una opinión legal ni reemplaza una evaluación profesional del caso.</p>
</div>
<div class="foot">Romani Compliance · Compliance penal, prevención LA/FT y defensa penal económica · Lima, Perú</div>
</body>
</html>
