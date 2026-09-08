@extends('admin.layout')

@section('title', 'Académico')

@section('content')
<div class="page-head">
  <h2 style="font-size:1.15rem">Espacio Académico — actividades</h2>
</div>

<div class="card">
  @if($activities->isEmpty())
    <div class="empty-state">Todavía no hay actividades académicas.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead>
        <tr><th>Actividad</th><th>Universidad / Curso</th><th>Vence</th><th>Código</th><th>Envíos</th><th>Visitas</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($activities as $activity)
          <tr>
            <td>{{ $activity->title }}<br><span class="form-hint">{{ $activity->case_title }}</span></td>
            <td>{{ $activity->course->university->short_name }} — {{ $activity->course->name }}</td>
            <td>{{ $activity->due_at ? $activity->due_at->timezone('America/Lima')->format('d/m/Y H:i') : '—' }}</td>
            <td>{{ $activity->access_code ?? '—' }}</td>
            <td>{{ $activity->submissions_count }}</td>
            <td>{{ $activity->visits_count }}</td>
            <td style="text-align:right;"><a href="{{ route('admin.academico.show', $activity) }}" class="btn btn-outline btn-sm">Ver</a></td>
          </tr>
        @endforeach
      </tbody>
    </table></div>
  @endif
</div>
@endsection
