<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>{{ $lead->documentTitle() }} · Romani Compliance</title>
<style>
  @page { margin: 0; }
  * { box-sizing: border-box; }
  body { font-family: 'DejaVu Sans', sans-serif; color: #0A1730; font-size: 10.5px; line-height: 1.5; margin: 0; }
  a { text-decoration: none; }
  table { border-collapse: collapse; }

  /* Portada */
  .hero { background: #0A1730; color: #fff; padding: 20px 40px 22px; position: relative; }
  .hero .glow { position: absolute; right: -90px; top: -120px; width: 330px; height: 330px; border-radius: 165px; background: #1F4FD8; opacity: .35; }
  .hero .glow2 { position: absolute; right: 60px; top: 70px; width: 160px; height: 160px; border-radius: 80px; background: #7FA3FF; opacity: .12; }
  .logo-pill { background: #fff; border-radius: 10px; padding: 7px 12px; display: inline-block; }
  .logo-pill img { height: 24px; }
  .ref { text-align: right; color: #9FB4E0; font-size: 9.5px; }
  .ref b { color: #fff; font-size: 11px; display: block; }
  .tag { display: inline-block; margin-top: 14px; padding: 4px 10px; border-radius: 10px; background: #1F4FD8; color: #fff; font-size: 9px; font-weight: bold; letter-spacing: .5px; }
  .hero h1 { font-size: 23px; line-height: 1.15; margin: 8px 0 4px; font-weight: bold; }
  .hero .sub { color: #C8D3EA; font-size: 10.5px; }
  .bar { height: 5px; background: #1F4FD8; }
  .bar span { display: block; height: 5px; width: 35%; background: #7FA3FF; }

  .body { padding: 14px 40px 0; }
  h2 { font-size: 12px; margin: 12px 0 5px; color: #0A1730; }
  h2 i { display: inline-block; width: 4px; height: 12px; background: #1F4FD8; border-radius: 2px; margin-right: 7px; vertical-align: -1px; }

  /* Datos */
  .meta { width: 100%; background: #F4F6FA; border-radius: 10px; }
  .meta td { padding: 7px 12px; vertical-align: top; width: 25%; }
  .meta .k { color: #55647C; font-size: 8.5px; text-transform: uppercase; letter-spacing: .4px; display: block; }
  .meta .v { font-weight: bold; font-size: 10.5px; }

  /* Puntaje */
  .score { width: 100%; margin-top: 10px; border: 1px solid #E2E7F0; border-radius: 12px; }
  .score td { vertical-align: middle; padding: 10px 14px; }
  .ring { width: 86px; height: 86px; border-radius: 43px; border: 8px solid #1F4FD8; text-align: center; overflow: hidden; }
  .ring b { display: block; font-size: 26px; line-height: 26px; padding-top: 14px; }
  .ring span { color: #55647C; font-size: 8px; line-height: 10px; display: block; }
  .lvl { display: inline-block; padding: 4px 11px; border-radius: 10px; font-weight: bold; font-size: 10px; }
  .meter { width: 100%; margin-top: 12px; }
  .meter td { height: 9px; padding: 0; }
  .meter .z1 { background: #F3C9C4; } .meter .z2 { background: #F6D9BF; } .meter .z3 { background: #BFE6D6; }
  .marks { width: 100%; font-size: 8px; color: #8B97AA; }
  .marks td { padding: 3px 0 0; }

  /* Listas */
  .list { width: 100%; }
  .list td { padding: 4px 8px; border-bottom: 1px solid #EDF0F6; vertical-align: top; }
  .list td.n { width: 20px; }
  .ok { display: inline-block; width: 13px; height: 13px; border-radius: 7px; background: #EEF3FF; color: #1F4FD8; font-size: 8px; text-align: center; line-height: 13px; font-weight: bold; }
  .prio { width: 100%; }
  .prio td { padding: 0 0 4px; }
  .prio .card { border-left: 4px solid #1F4FD8; background: #F4F7FF; border-radius: 6px; padding: 5px 12px; }
  .prio .card b { color: #1F4FD8; margin-right: 6px; }

  /* Próximos pasos */
  .steps { width: 100%; margin-top: 2px; }
  .steps td { width: 33.3%; vertical-align: top; padding-right: 10px; }
  .steps .st { border: 1px solid #E2E7F0; border-radius: 10px; padding: 8px 11px; }
  .steps .dot { display: inline-block; width: 9px; height: 9px; border-radius: 5px; background: #1F4FD8; margin-right: 6px; }
  .steps b { font-size: 10.5px; }
  .steps p { margin: 4px 0 0; color: #55647C; font-size: 9.5px; }

  /* Llamado a la acción */
  .cta { margin-top: 12px; background: #0A1730; border-radius: 14px; padding: 14px 18px; color: #fff; page-break-inside: avoid; }
  .cta h3 { font-size: 15px; margin: 0 0 4px; }
  .cta p { margin: 0; color: #C8D3EA; font-size: 10px; }
  .btns { margin-top: 10px; }
  .btns td { padding-right: 8px; }
  .btn { display: block; padding: 9px 16px; border-radius: 18px; font-weight: bold; font-size: 10.5px; text-align: center; }
  .btn-wa { background: #25D366; color: #fff; }
  .btn-web { background: #1F4FD8; color: #fff; }
  .btn-out { background: #fff; color: #0A1730; }
  .cta .small { margin-top: 10px; font-size: 9px; color: #9FB4E0; }
  .cta .small a { color: #fff; }

  .note { color: #8B97AA; font-size: 8px; margin-top: 8px; }
  .foot { position: fixed; bottom: 0; left: 0; right: 0; padding: 11px 40px; font-size: 8.5px; color: #8B97AA; border-top: 1px solid #E2E7F0; background: #fff; }
  .foot a { color: #1F4FD8; }
</style>
</head>
<body>
@php
  $lines = $lead->data['lines'] ?? array_filter(explode("\n", (string) $lead->summary));
  $priorities = $lead->data['priorities'] ?? [];
  if ($priorities) { $lines = array_values(array_filter($lines, fn ($l) => ! str_starts_with($l, 'Prioridades:'))); }
  $lines = array_slice(array_values($lines), 0, 9);
  $priorities = array_slice($priorities, 0, 4);
  [$lvlBg, $lvlFg, $ringColor] = match (true) {
    $lead->score === null => ['#EEF3FF', '#1F4FD8', '#1F4FD8'],
    $lead->score >= 75 => ['#E1F3EC', '#0E8A5F', '#0E8A5F'],
    $lead->score >= 45 => ['#FBEBDD', '#C25B12', '#E07A2E'],
    default => ['#F8E1DF', '#C0362C', '#C0362C'],
  };
  // Anillo del puntaje como SVG (dompdf dibuja mal los bordes gruesos redondeados)
  $ringSvg = null;
  if ($lead->score !== null) {
    $pct = max(0, min(100, (int) $lead->score)); $r = 40; $c = 50;
    $ang = deg2rad(-90 + 360 * min($pct, 99.9) / 100);
    $x = round($c + $r * cos($ang), 2); $y = round($c + $r * sin($ang), 2);
    $large = $pct > 50 ? 1 : 0;
    $arc = $pct > 0 ? '<path d="M '.$c.' '.($c - $r).' A '.$r.' '.$r.' 0 '.$large.' 1 '.$x.' '.$y.'" fill="none" stroke="'.$ringColor.'" stroke-width="10" stroke-linecap="round"/>' : '';
    $ringSvg = 'data:image/svg+xml;base64,'.base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="#E8EDF6" stroke-width="10"/>'.$arc.'</svg>');
  }
  $half = (int) ceil(count($lines) / 2);
  $cols = count($lines) > 3 ? [array_slice($lines, 0, $half), array_slice($lines, $half)] : [$lines];
  $date = ($lead->created_at ?? now())->timezone('America/Lima')->translatedFormat('d \d\e F \d\e Y');
@endphp

<div class="hero">
  <div class="glow"></div><div class="glow2"></div>
  <table style="width:100%;position:relative"><tr>
    <td><span class="logo-pill">@if($logo !== 'data:image/png;base64,')<img src="{{ $logo }}" alt="Romani Compliance">@else<b style="color:#0A1730">ROMANI COMPLIANCE</b>@endif</span></td>
    <td class="ref">@if($lead->id)<b>{{ $ref }}</b>N.° de solicitud @else<b>{{ $date }}</b>@endif</td>
  </tr></table>
  <div style="position:relative">
    <span class="tag">{{ mb_strtoupper($lead->service_name) }}</span>
    <h1>{{ $lead->data['title'] ?? $lead->documentTitle() }}</h1>
    <div class="sub">Preparado para <b style="color:#fff">{{ $lead->organization ?: $lead->name }}</b> · {{ $date }}</div>
  </div>
</div>
<div class="bar"><span></span></div>

<div class="body">
  <table class="meta"><tr>
    <td><span class="k">Organización</span><span class="v">{{ $lead->organization ?: $lead->name }}</span></td>
    @if($lead->phone)<td><span class="k">Teléfono</span><span class="v">{{ $lead->phone }}</span></td>@endif
    <td><span class="k">Servicio</span><span class="v">{{ $lead->service_name }}</span></td>
    <td><span class="k">Fecha</span><span class="v">{{ $date }}</span></td>
  </tr></table>

  @if($lead->score !== null)
    <table class="score"><tr>
      <td style="width:112px"><div style="position:relative;width:92px;height:92px"><img src="{{ $ringSvg }}" style="width:92px;height:92px;position:absolute;left:0;top:0"><div style="position:absolute;left:0;top:26px;width:92px;text-align:center"><b style="font-size:26px;line-height:26px;color:{{ $ringColor }}">{{ $lead->score }}</b><br><span style="color:#55647C;font-size:8px">de 100</span></div></div></td>
      <td>
        @if($lead->level)<span class="lvl" style="background:{{ $lvlBg }};color:{{ $lvlFg }}">{{ $lead->level }}</span>@endif
        <p style="margin:8px 0 0;color:#55647C">El puntaje mide qué tan preparado está su sistema de prevención según sus respuestas. Un puntaje alto indica una base sólida; uno bajo, que faltan elementos centrales.</p>
        <table class="meter"><tr><td class="z1" style="width:45%;border-radius:5px 0 0 5px"></td><td class="z2" style="width:30%"></td><td class="z3" style="width:25%;border-radius:0 5px 5px 0"></td></tr></table>
        <table style="width:100%;margin-top:-9px"><tr><td style="width:{{ max(1, min(99, $lead->score)) }}%;padding:0"></td><td style="padding:0"><div style="width:4px;height:15px;background:#0A1730;border-radius:2px;margin-top:-3px"></div></td></tr></table>
        <table class="marks"><tr><td style="width:45%">Exposición alta</td><td style="width:30%">Brechas</td><td style="text-align:right">Sistema sólido</td></tr></table>
      </td>
    </tr></table>
  @elseif($lead->level)
    <p style="margin-top:14px"><span class="lvl" style="background:{{ $lvlBg }};color:{{ $lvlFg }}">{{ $lead->level }}</span></p>
  @endif

  <h2><i></i>Lo que nos indicó</h2>
  <table style="width:100%"><tr>@foreach($cols as $ci => $col)<td style="width:{{ count($cols) > 1 ? 50 : 100 }}%;vertical-align:top;{{ $ci ? 'padding-left:10px' : '' }}"><table class="list">@foreach($col as $l)<tr><td class="n"><span class="ok">✓</span></td><td>{{ $l }}</td></tr>@endforeach</table></td>@endforeach</tr></table>

  @if($priorities)
    <h2><i></i>Sus prioridades</h2>
    <table class="prio">@foreach($priorities as $i => $p)<tr><td><div class="card"><b>{{ $i + 1 }}</b>{{ $p }}</div></td></tr>@endforeach</table>
  @endif

  <h2><i></i>Cómo seguimos</h2>
  <table class="steps"><tr>
    <td><div class="st"><span class="dot"></span><b>Revisión</b><p>Un abogado del equipo revisa este informe.</p></div></td>
    <td><div class="st"><span class="dot"></span><b>Conversación</b><p>Precisamos el alcance, los plazos y su contexto.</p></div></td>
    <td style="padding-right:0"><div class="st"><span class="dot"></span><b>Propuesta</b><p>Plan de trabajo con entregables y fechas.</p></div></td>
  </tr></table>

  <div class="cta">
    <h3>¿Conversamos sobre su resultado?</h3>
    <p>Respondemos el mismo día hábil. Toda la información se maneja con reserva.</p>
    <table class="btns"><tr>
      <td><a href="{{ $wa }}" class="btn btn-wa">Escribir por WhatsApp</a></td>
      <td><a href="{{ $web }}/#contacto" class="btn btn-web">Agendar una consulta</a></td>
      <td style="padding-right:0"><a href="{{ $web }}" class="btn btn-out">romanicompliance.com</a></td>
    </tr></table>
    <div class="small">WhatsApp <a href="{{ $wa }}">+51 969 754 983</a> · Correo <a href="mailto:denis@romanicompliance.com">denis@romanicompliance.com</a></div>
  </div>

</div>
<div class="foot"><div style="margin-bottom:3px">Documento orientativo generado a partir de las respuestas ingresadas en romanicompliance.com. No constituye una opinión legal ni reemplaza una evaluación profesional del caso.</div>Romani Compliance · Compliance penal, prevención LA/FT y defensa penal económica · Lima, Perú · <a href="{{ $web }}">romanicompliance.com</a></div>
</body>
</html>
