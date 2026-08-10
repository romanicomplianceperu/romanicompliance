@extends('admin.layout')

@section('title', $project->exists ? 'Editar proyecto' : 'Nuevo proyecto')

@section('content')
<div class="card">
  <form action="{{ $project->exists ? route('admin.proyectos.update', $project) : route('admin.proyectos.store') }}" method="POST">
    @csrf
    @if($project->exists) @method('PUT') @endif

    <div class="form-row">
      <div class="form-group">
        <label>Nombre del proyecto</label>
        <input type="text" name="name" value="{{ old('name', $project->name) }}" required>
      </div>
      <div class="form-group">
        <label>Empresa cliente</label>
        <select name="company_id" required>
          <option value="">Selecciona una empresa</option>
          @foreach($companies as $company)
            <option value="{{ $company->id }}" @selected(old('company_id', $project->company_id) == $company->id)>{{ $company->name }}</option>
          @endforeach
        </select>
        <div class="form-hint">¿No está en la lista? <a href="{{ route('admin.empresas.create') }}" style="color:var(--gold);">Crea la empresa primero</a>.</div>
      </div>
    </div>

    <div class="form-group">
      <label>Descripción</label>
      <textarea name="description">{{ old('description', $project->description) }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Servicio contratado</label>
        <input type="text" name="service" value="{{ old('service', $project->service) }}" placeholder="Ej. Capacitación SPLAFT Integral">
      </div>
      <div class="form-group">
        <label>Curso asociado</label>
        <select name="course_id">
          <option value="">Sin curso asociado</option>
          @foreach($courses as $course)
            <option value="{{ $course->id }}" @selected(old('course_id', $project->course_id) == $course->id)>{{ $course->title }}</option>
          @endforeach
        </select>
        <div class="form-hint">Contenido y certificados del proyecto usarán este curso.</div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Modalidad</label>
        <input type="text" name="modality" value="{{ old('modality', $project->modality) }}" placeholder="Presencial / Virtual">
      </div>
      <div class="form-group">
        <label>Duración (horas)</label>
        <input type="number" step="0.5" min="0" name="duration_hours" value="{{ old('duration_hours', $project->duration_hours) }}">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Fecha de inicio</label>
        <input type="text" name="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}" placeholder="AAAA-MM-DD">
      </div>
      <div class="form-group">
        <label>Fecha de finalización</label>
        <input type="text" name="end_date" value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}" placeholder="AAAA-MM-DD">
      </div>
    </div>

    <div class="form-group">
      <label>Estado</label>
      <select name="status" required>
        @foreach(['draft' => 'Borrador', 'active' => 'Activo', 'completed' => 'Completado', 'cancelled' => 'Cancelado'] as $value => $label)
          <option value="{{ $value }}" @selected(old('status', $project->status ?? 'draft') === $value)>{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Información comercial (precio, condiciones)</label>
      <textarea name="commercial_info" placeholder="Ej. US$ 250 + IGV. Incluye material editable y acompañamiento de 10 días.">{{ old('commercial_info', $project->commercial_info) }}</textarea>
      <div class="form-hint">Este texto se puede mostrar en la página pública del proyecto.</div>
    </div>

    <div class="form-group">
      <label>Observaciones internas</label>
      <textarea name="observations">{{ old('observations', $project->observations) }}</textarea>
    </div>

    <button type="submit" class="btn btn-gold">{{ $project->exists ? 'Guardar cambios' : 'Crear proyecto' }}</button>
    <a href="{{ $project->exists ? route('admin.proyectos.show', $project) : route('admin.proyectos.index') }}" class="btn btn-outline">Cancelar</a>
  </form>
</div>
@endsection
