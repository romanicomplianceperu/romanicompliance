@extends('admin.layout')

@section('title', 'Participantes · '.$course->title)

@section('content')
<div class="page-head">
  <h2 style="font-size:1.15rem">{{ $course->title }} — participantes</h2>
  <a href="{{ route('courses.show', $course) }}" target="_blank" class="btn btn-outline btn-sm">Ver página pública →</a>
</div>

<div class="card">
  @if($course->enrollments->isEmpty())
    <div class="empty-state">Todavía no hay personas inscritas en este curso.</div>
  @else
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr><th>Participante</th><th>Correo</th><th>Cargo</th><th>Progreso</th><th>Examen</th><th>Nota</th><th>Inscrito</th></tr>
        </thead>
        <tbody>
          @foreach($course->enrollments as $enrollment)
            @php
              $attempts = $attemptsByUser->get($enrollment->user_id, collect());
              $bestAttempt = $attempts->sortByDesc('score')->first();
            @endphp
            <tr>
              <td><strong>{{ $enrollment->user->name }}</strong></td>
              <td><span class="form-hint">{{ $enrollment->user->email }}</span></td>
              <td>{{ $enrollment->user->title ?? '—' }}</td>
              <td>{{ $enrollment->progress_percent }}%</td>
              <td>
                @if($bestAttempt)
                  @if($bestAttempt->status === 'passed')
                    <span class="badge" style="background:rgba(31,122,77,0.1);color:#1F7A4D;">Aprobado</span>
                  @elseif($bestAttempt->status === 'failed')
                    <span class="badge" style="background:rgba(179,65,59,0.08);color:#B3413B;">No aprobado</span>
                  @else
                    <span class="badge" style="background:rgba(184,148,46,0.12);color:#8A6D1E;">En curso</span>
                  @endif
                @else
                  <span class="form-hint">Sin intentos</span>
                @endif
              </td>
              <td>{{ $bestAttempt && $bestAttempt->score !== null ? number_format($bestAttempt->score, 1) : '—' }}</td>
              <td>{{ $enrollment->created_at->timezone('America/Lima')->format('d/m/Y H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
