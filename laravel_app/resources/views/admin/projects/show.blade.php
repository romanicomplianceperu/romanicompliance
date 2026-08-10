@extends('admin.layout')

@section('title', $project->name)

@section('content')
<div class="page-head">
  <div>
    <h2 style="font-size:1.15rem">{{ $project->name }}</h2>
    <div class="form-hint" style="margin-top:4px;">{{ $project->company->name }}</div>
  </div>
  <div>
    @if($project->course)
      <a href="{{ route('projects.show', $project) }}" class="btn btn-outline" target="_blank">Ver página pública</a>
    @endif
    <a href="{{ route('admin.proyectos.edit', $project) }}" class="btn btn-outline">Editar información</a>
  </div>
</div>

<div class="card">
  <div class="form-row">
    <div>
      <div class="form-hint">SERVICIO</div>
      <p>{{ $project->service ?: '—' }}</p>
    </div>
    <div>
      <div class="form-hint">CURSO ASOCIADO</div>
      <p>{{ $project->course->title ?? 'Ninguno' }}</p>
    </div>
  </div>
  <div class="form-row" style="margin-top:1rem;">
    <div>
      <div class="form-hint">MODALIDAD / DURACIÓN</div>
      <p>{{ $project->modality ?: '—' }}@if($project->duration_hours) &middot; {{ rtrim(rtrim(number_format($project->duration_hours, 1), '0'), '.') }} horas @endif</p>
    </div>
    <div>
      <div class="form-hint">ESTADO</div>
      <p><span class="badge badge-gold">{{ $project->statusLabel() }}</span></p>
    </div>
  </div>
  @if($project->description)
    <div style="margin-top:1rem;">
      <div class="form-hint">DESCRIPCIÓN</div>
      <p>{{ $project->description }}</p>
    </div>
  @endif
</div>

<div class="card">
  <div class="page-head">
    <h2 style="font-size:1.05rem">Participantes</h2>
  </div>

  @if($project->participants->isEmpty())
    <div class="empty-state">Todavía no hay participantes registrados.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead><tr><th>Nombre</th><th>Cargo</th><th>Correo</th><th></th></tr></thead>
      <tbody>
        @foreach($project->participants as $participant)
          <tr>
            <td>{{ $participant->full_name }}</td>
            <td>{{ $participant->position ?: '—' }}</td>
            <td>{{ $participant->email ?: '—' }}</td>
            <td style="text-align:right;white-space:nowrap;">
              <form action="{{ route('admin.projects.participants.destroy', [$project, $participant]) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este participante?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table></div>
  @endif

  <details class="add-panel" style="margin-top:1rem;">
    <summary style="cursor:pointer;font-size:0.8rem;font-weight:600;color:var(--gold);">+ Agregar participante</summary>
    <div style="margin-top:0.8rem;padding:1rem;background:var(--ivory);border:1px dashed var(--line);border-radius:4px;">
      <form action="{{ route('admin.projects.participants.store', $project) }}" method="POST" class="form-row" style="align-items:end;">
        @csrf
        <div class="form-group">
          <label>Nombre completo</label>
          <input type="text" name="full_name" required>
        </div>
        <div class="form-group">
          <label>Cargo</label>
          <input type="text" name="position">
        </div>
        <div class="form-group">
          <label>Correo (opcional)</label>
          <input type="text" name="email">
        </div>
        <div class="form-group" style="flex:0;">
          <button type="submit" class="btn btn-gold btn-sm">Agregar</button>
        </div>
      </form>
    </div>
  </details>
</div>

<div class="card">
  <div class="page-head">
    <h2 style="font-size:1.05rem">Certificados</h2>
  </div>

  @if(!$project->course)
    <div class="empty-state">Para emitir certificados, primero asigna un curso asociado a este proyecto (botón "Editar información").</div>
  @else
    @if($project->certificates->isEmpty())
      <div class="empty-state">Todavía no se ha emitido ningún certificado para este proyecto.</div>
    @else
      <div class="table-wrap"><table class="table">
        <thead><tr><th>Código</th><th>Nombre</th><th>Emitido</th><th></th></tr></thead>
        <tbody>
          @foreach($project->certificates as $certificate)
            <tr>
              <td>{{ $certificate->code }}</td>
              <td>{{ $certificate->holderDisplayName() }}</td>
              <td>{{ $certificate->issued_at->format('d/m/Y') }}</td>
              <td style="text-align:right;white-space:nowrap;">
                <a href="{{ route('certificates.verify', $certificate->code) }}" target="_blank" class="btn btn-outline btn-sm">Verificar</a>
                <a href="{{ route('certificates.download', $certificate) }}" class="btn btn-outline btn-sm">Descargar</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table></div>
    @endif

    <details class="add-panel" style="margin-top:1rem;">
      <summary style="cursor:pointer;font-size:0.8rem;font-weight:600;color:var(--gold);">+ Generar certificado</summary>
      <div style="margin-top:0.8rem;padding:1rem;background:var(--ivory);border:1px dashed var(--line);border-radius:4px;">
        <form action="{{ route('admin.projects.certificates.store', $project) }}" method="POST" class="form-row" style="align-items:end;">
          @csrf
          <div class="form-group">
            <label>Participante registrado</label>
            <select name="participant_id" onchange="document.getElementById('manualNameField').style.display = this.value ? 'none' : 'block'">
              <option value="">— Escribir nombre manualmente —</option>
              @foreach($project->participants as $participant)
                <option value="{{ $participant->id }}">{{ $participant->full_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group" id="manualNameField">
            <label>Nombre completo</label>
            <input type="text" name="holder_name">
          </div>
          <div class="form-group" style="flex:0;">
            <button type="submit" class="btn btn-gold btn-sm">Generar certificado</button>
          </div>
        </form>
        <div class="form-hint" style="margin-top:8px;">El certificado usa el curso asociado ({{ $project->course->title }}), y el mismo diseño, numeración, QR y verificación pública que los certificados de cursos normales.</div>
      </div>
    </details>
  @endif
</div>
@endsection
