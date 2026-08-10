@extends('admin.layout')

@section('title', 'Proyectos')

@section('content')
<div class="page-head">
  <h2 style="font-size:1.15rem">Proyectos empresariales</h2>
  <a href="{{ route('admin.proyectos.create') }}" class="btn btn-gold">+ Nuevo proyecto</a>
</div>

<div class="card">
  @if($projects->isEmpty())
    <div class="empty-state">Todavía no hay proyectos registrados.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead>
        <tr><th>Proyecto</th><th>Empresa</th><th>Estado</th><th>Participantes</th><th>Certificados</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($projects as $project)
          <tr>
            <td><a href="{{ route('admin.proyectos.show', $project) }}" style="font-weight:600;color:var(--ink);">{{ $project->name }}</a></td>
            <td>{{ $project->company->name }}</td>
            <td>
              @php $badge = ['active' => 'badge-gold', 'completed' => 'badge-gray', 'cancelled' => 'badge-gray'][$project->status] ?? 'badge-gray'; @endphp
              <span class="badge {{ $badge }}">{{ $project->statusLabel() }}</span>
            </td>
            <td>{{ $project->participants_count }}</td>
            <td>{{ $project->certificates_count }}</td>
            <td style="text-align:right;white-space:nowrap;">
              <a href="{{ route('admin.proyectos.show', $project) }}" class="btn btn-outline btn-sm">Gestionar</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table></div>
  @endif
</div>
@endsection
