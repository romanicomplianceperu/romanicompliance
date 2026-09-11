@extends('admin.layout')

@section('title', $application->full_name)

@section('content')
<div class="page-head">
  <div>
    <h2 style="font-size:1.15rem">{{ $application->full_name }}</h2>
    <div class="form-hint">Solicitud de pasantía · {{ $application->created_at->timezone('America/Lima')->format('d/m/Y H:i') }}</div>
  </div>
  <a href="{{ route('admin.internships.index') }}" class="btn btn-outline btn-sm">← Volver</a>
</div>

<div class="card">
  <h3 style="font-size:1rem;margin-bottom:1rem;">Estado</h3>
  <form action="{{ route('admin.internships.status', $application) }}" method="POST" style="display:flex;gap:10px;align-items:center;">
    @csrf @method('PATCH')
    <select name="status" style="padding:8px 10px;border:1px solid var(--line);border-radius:6px;font-size:0.85rem;">
      @foreach(\App\Models\InternshipApplication::STATUSES as $key => $label)
        <option value="{{ $key }}" {{ $application->status === $key ? 'selected' : '' }}>{{ $label }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn btn-gold btn-sm">Guardar</button>
  </form>
</div>

<div class="card">
  <h3 style="font-size:1rem;margin-bottom:1rem;">Datos de contacto</h3>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem;font-size:0.88rem;">
    <div><div class="form-hint" style="margin-bottom:2px;">Teléfono</div><a href="tel:{{ $application->phone }}">{{ $application->phone }}</a></div>
    <div><div class="form-hint" style="margin-bottom:2px;">Correo</div><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></div>
    <div><div class="form-hint" style="margin-bottom:2px;">IP de envío</div>{{ $application->ip_address ?? '—' }}</div>
    <div>
      <div class="form-hint" style="margin-bottom:2px;">CV</div>
      @if($application->cvUrl())
        <a href="{{ $application->cvUrl() }}" target="_blank" rel="noopener">Descargar CV →</a>
      @else
        <span style="color:var(--slate-light);">No adjuntó CV</span>
      @endif
    </div>
  </div>
</div>

<div class="card">
  <h3 style="font-size:1rem;margin-bottom:1rem;">Perfil</h3>
  <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.2rem 2rem;font-size:0.88rem;margin-bottom:1.2rem;">
    <div><div class="form-hint" style="margin-bottom:2px;">Universidad</div>{{ $application->universityLabel() }}</div>
    <div><div class="form-hint" style="margin-bottom:2px;">Área de interés</div>{{ $application->interestAreaLabel() }}</div>
    <div><div class="form-hint" style="margin-bottom:2px;">Ciclo académico</div>{{ $application->academicCycleLabel() }}</div>
    <div><div class="form-hint" style="margin-bottom:2px;">Situación actual</div>{{ $application->occupationStatusLabel() }}</div>
    <div><div class="form-hint" style="margin-bottom:2px;">Horas por semana</div>{{ $application->weeklyHoursLabel() }}</div>
    <div style="grid-column:span 2;"><div class="form-hint" style="margin-bottom:2px;">Disponibilidad horaria</div>{{ implode(', ', $application->scheduleAvailabilityLabels()) ?: '—' }}</div>
    <div style="grid-column:span 2;"><div class="form-hint" style="margin-bottom:2px;">Habilidades</div>{{ implode(', ', $application->skillLabels()) ?: '—' }}</div>
  </div>
</div>

<div class="card">
  <h3 style="font-size:1rem;margin-bottom:1rem;">Ofimática e inteligencia artificial</h3>
  <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.2rem 2rem;font-size:0.88rem;">
    <div><div class="form-hint" style="margin-bottom:2px;">Word</div>{{ $application->officeWordLevelLabel() }}</div>
    <div><div class="form-hint" style="margin-bottom:2px;">Excel</div>{{ $application->officeExcelLevelLabel() }}</div>
    <div><div class="form-hint" style="margin-bottom:2px;">Herramientas de IA que usa</div>{{ implode(', ', $application->aiToolsLabels()) ?: '—' }}</div>
    <div><div class="form-hint" style="margin-bottom:2px;">¿Versión paga/Plus?</div>{{ $application->aiToolsPaidLabel() }}</div>
  </div>
</div>

<div class="card">
  <h3 style="font-size:1rem;margin-bottom:1rem;">Conocimiento previo</h3>
  <div style="font-size:0.85rem;">
    @foreach($application->specializedAnswerPairs() as $pair)
      <div style="display:flex;justify-content:space-between;gap:1rem;padding:8px 0;border-bottom:1px solid var(--line);">
        <span style="color:var(--slate);">{{ $pair['question'] }}</span>
        <span style="font-weight:700;white-space:nowrap;">{{ $pair['answer'] }}</span>
      </div>
    @endforeach
  </div>
</div>

@if($application->motivation)
<div class="card">
  <h3 style="font-size:1rem;margin-bottom:1rem;">¿Por qué le interesa el estudio?</h3>
  <p style="font-size:0.88rem;line-height:1.7;white-space:pre-line;">{{ $application->motivation }}</p>
</div>
@endif
@endsection
