@extends('admin.layout')

@section('title', $training->title)

@section('content')
<div class="page-head">
  <h2 style="font-size:1.15rem">{{ $training->title }}</h2>
  <a href="{{ route('capacitacion.show', $training) }}" target="_blank" class="btn btn-outline btn-sm">Ver página pública →</a>
</div>

<div class="aca-stats-row" style="margin-bottom:1.2rem;">
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $attempts->count() }}</div>
    <div class="aca-stat-label">Registros iniciados</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $attempts->whereNotNull('finished_at')->count() }}</div>
    <div class="aca-stat-label">Evaluaciones completadas</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value accent">{{ $avgScore !== null ? number_format($avgScore, 1) : '—' }}</div>
    <div class="aca-stat-label">Nota promedio</div>
  </div>
</div>

<div class="card">
  @if($attempts->isEmpty())
    <div class="empty-state">Todavía no hay participantes registrados en esta capacitación.</div>
  @else
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr><th>Participante</th><th>Cargo</th><th>Nota</th><th>Correctas</th><th>Inicio</th><th>Estado</th></tr>
        </thead>
        <tbody>
          @foreach($attempts as $attempt)
            <tr>
              <td><strong>{{ $attempt->full_name }}</strong></td>
              <td>{{ $attempt->positionLabel() }}</td>
              <td>
                @if($attempt->finished_at)
                  <strong>{{ number_format($attempt->score_percent, 1) }}</strong>
                @else
                  <span class="form-hint">—</span>
                @endif
              </td>
              <td>{{ $attempt->finished_at ? $attempt->correct_count.' / '.$attempt->total_questions : '—' }}</td>
              <td>{{ $attempt->started_at->timezone('America/Lima')->format('d/m/Y H:i') }}</td>
              <td>
                @if($attempt->finished_at)
                  <span class="badge" style="background:rgba(31,122,77,0.1);color:#1F7A4D;">Completada</span>
                @elseif($attempt->isExpired())
                  <span class="badge badge-gray">Tiempo vencido</span>
                @else
                  <span class="badge" style="background:rgba(184,148,46,0.12);color:#8A6D1E;">En curso</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
