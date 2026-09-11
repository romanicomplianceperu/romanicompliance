<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Nueva postulación de pasantía</title>
</head>
<body style="margin:0;padding:0;background:#F4F1EA;font-family:Arial,Helvetica,sans-serif;color:#0B1829;">
  <div style="max-width:560px;margin:0 auto;padding:28px 20px;">
    <div style="background:#0B1829;border-radius:10px 10px 0 0;padding:22px 26px;">
      <div style="font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:#C9A961;font-weight:700;margin-bottom:4px;">Romani Compliance — Espacio Académico</div>
      <h1 style="font-size:19px;color:#fff;margin:0;font-weight:600;">Nueva postulación de pasantía</h1>
    </div>
    <div style="background:#fff;border:1px solid #E7E1D3;border-top:none;border-radius:0 0 10px 10px;padding:26px;">
      <p style="font-size:14px;line-height:1.6;margin:0 0 18px;"><strong>{{ $application->full_name }}</strong> acaba de postular al programa de pasantías. Estos son los datos que envió:</p>

      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:13.5px;line-height:1.6;border-collapse:collapse;">
        <tr><td style="padding:6px 0;color:#6B7280;width:170px;vertical-align:top;">Teléfono</td><td style="padding:6px 0;">{{ $application->phone }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">Correo</td><td style="padding:6px 0;">{{ $application->email }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">Área de interés</td><td style="padding:6px 0;">{{ $application->interestAreaLabel() }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">Situación actual</td><td style="padding:6px 0;">{{ $application->occupationStatusLabel() }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">Disponibilidad horaria</td><td style="padding:6px 0;">{{ implode(', ', $application->scheduleAvailabilityLabels()) }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">Horas por semana</td><td style="padding:6px 0;">{{ $application->weeklyHoursLabel() }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">Ciclo académico</td><td style="padding:6px 0;">{{ $application->academicCycleLabel() }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">Habilidades</td><td style="padding:6px 0;">{{ implode(', ', $application->skillLabels()) }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">Word</td><td style="padding:6px 0;">{{ $application->officeWordLevelLabel() }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">Excel</td><td style="padding:6px 0;">{{ $application->officeExcelLevelLabel() }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">Herramientas de IA</td><td style="padding:6px 0;">{{ implode(', ', $application->aiToolsLabels()) }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">¿Versión paga/Plus?</td><td style="padding:6px 0;">{{ $application->aiToolsPaidLabel() }}</td></tr>
        <tr><td style="padding:6px 0;color:#6B7280;vertical-align:top;">CV</td><td style="padding:6px 0;">@if($application->cvUrl())<a href="{{ $application->cvUrl() }}">Descargar CV</a>@else No adjuntó CV @endif</td></tr>
      </table>

      <div style="margin:20px 0 8px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#8B7340;">Conocimiento previo</div>
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;line-height:1.6;border-collapse:collapse;">
        @foreach($application->specializedAnswerPairs() as $pair)
          <tr><td style="padding:4px 0;color:#374151;vertical-align:top;">{{ $pair['question'] }}</td><td style="padding:4px 0 4px 10px;font-weight:600;white-space:nowrap;">{{ $pair['answer'] }}</td></tr>
        @endforeach
      </table>

      @if($application->motivation)
        <div style="margin:20px 0 8px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#8B7340;">¿Por qué le interesa el estudio?</div>
        <p style="font-size:13.5px;line-height:1.7;background:#FAF8F3;border-radius:6px;padding:12px 14px;margin:0;white-space:pre-line;">{{ $application->motivation }}</p>
      @endif

      <p style="font-size:12px;color:#9CA3AF;margin:22px 0 0;">Recibido el {{ $application->created_at->timezone('America/Lima')->format('d/m/Y H:i') }} · Ya está registrado en el panel admin, en Solicitudes de pasantía.</p>
    </div>
  </div>
</body>
</html>
