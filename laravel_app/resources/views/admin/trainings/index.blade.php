@extends('admin.layout')

@section('title', 'Capacitaciones')

@section('content')
<div class="page-head">
  <h2 style="font-size:1.15rem">Capacitaciones externas</h2>
</div>

@if($trainings->isEmpty())
  <div class="card"><div class="empty-state">Todavía no se ha creado ninguna capacitación.</div></div>
@else
  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr><th>Capacitación</th><th>Organiza</th><th>Preguntas</th><th>Evaluaciones enviadas</th><th>Estado</th><th></th></tr>
        </thead>
        <tbody>
          @foreach($trainings as $training)
            <tr>
              <td>
                <strong>{{ $training->title }}</strong><br>
                <span class="form-hint">{{ $training->subtitle }}</span>
              </td>
              <td><span class="form-hint">{{ $training->organizer }}</span></td>
              <td>{{ $training->questions_count }}</td>
              <td>{{ $training->finished_attempts_count }}</td>
              <td>
                @if($training->is_active)
                  <span class="badge" style="background:rgba(31,122,77,0.1);color:#1F7A4D;">Activa</span>
                @else
                  <span class="badge badge-gray">Inactiva</span>
                @endif
              </td>
              <td><a href="{{ route('admin.trainings.show', $training) }}" class="btn btn-outline btn-sm">Ver evaluaciones →</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif
@endsection
