@extends('admin.layout')

@section('title', 'Solicitudes de pasantía')

@section('content')
<div class="page-head">
  <h2 style="font-size:1.15rem">Solicitudes de pasantía</h2>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@php
  $pendientes = $applications->where('status', 'pendiente')->count();
  $contactados = $applications->where('status', 'contactado')->count();
  $aceptados = $applications->where('status', 'aceptado')->count();
@endphp

<div class="aca-stats-row">
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $applications->count() }}</div>
    <div class="aca-stat-label">Solicitudes totales</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value accent">{{ $pendientes }}</div>
    <div class="aca-stat-label">Pendientes de revisar</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $contactados }}</div>
    <div class="aca-stat-label">Contactados</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $aceptados }}</div>
    <div class="aca-stat-label">Aceptados</div>
  </div>
</div>

<div class="card">
  @if($applications->isEmpty())
    <div class="empty-state">Todavía no hay solicitudes de pasantía.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead>
        <tr><th>Nombre</th><th>Contacto</th><th>Área de interés</th><th>Ciclo</th><th>Recibido</th><th>Estado</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($applications as $application)
          <tr>
            <td><strong>{{ $application->full_name }}</strong></td>
            <td class="form-hint">{{ $application->phone }}<br>{{ $application->email }}</td>
            <td>{{ $application->interestAreaLabel() }}</td>
            <td>{{ $application->academicCycleLabel() }}</td>
            <td>{{ $application->created_at->timezone('America/Lima')->format('d/m/Y H:i') }}</td>
            <td>
              <form action="{{ route('admin.internships.status', $application) }}" method="POST" style="display:flex;gap:6px;align-items:center;">
                @csrf @method('PATCH')
                <select name="status" onchange="this.form.submit()" style="padding:6px 8px;border:1px solid var(--line);border-radius:6px;font-size:0.78rem;">
                  @foreach(\App\Models\InternshipApplication::STATUSES as $key => $label)
                    <option value="{{ $key }}" {{ $application->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                  @endforeach
                </select>
              </form>
            </td>
            <td style="text-align:right;">
              <a href="{{ route('admin.internships.show', $application) }}" class="btn btn-outline btn-sm">Ver →</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table></div>
  @endif
</div>
@endsection
