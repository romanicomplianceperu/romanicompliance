@extends('admin.layout')

@section('title', $activity->title)

@section('content')
<div class="page-head">
  <div>
    <h2 style="font-size:1.15rem">{{ $activity->title }}</h2>
    <div class="form-hint">{{ $activity->course->university->short_name }} — {{ $activity->course->name }} · {{ $activity->case_title }}</div>
  </div>
  <a href="{{ route('admin.academico.index') }}" class="btn btn-outline btn-sm">← Volver</a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@php
  $completedSubmissions = $submissions->filter(fn ($s) => $s->isSubmitted());
  $avgDurationSeconds = $completedSubmissions->isNotEmpty()
    ? (int) round($completedSubmissions->avg(fn ($s) => $s->durationSeconds()))
    : null;
  $avgDurationLabel = $avgDurationSeconds === null
    ? '—'
    : ($avgDurationSeconds < 3600 ? intdiv($avgDurationSeconds, 60).' min' : intdiv($avgDurationSeconds, 3600).'h '.intdiv($avgDurationSeconds % 3600, 60).'min');
@endphp

<div class="aca-stats-row">
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $submissions->count() }}</div>
    <div class="aca-stat-label">Envíos registrados</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $completedSubmissions->count() }}</div>
    <div class="aca-stat-label">Actividades completadas</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value accent">{{ $avgDurationLabel }}</div>
    <div class="aca-stat-label">Tiempo promedio en la actividad</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $visitsCount }}</div>
    <div class="aca-stat-label">Visitas totales</div>
  </div>
</div>

<div class="card">
  <h3 style="font-size:1rem;margin-bottom:1rem;">Configuración de acceso</h3>
  <form action="{{ route('admin.academico.update', $activity) }}" method="POST">
    @csrf @method('PUT')
    <div class="form-group">
      <label>Código de acceso (vacío = sin código)</label>
      <input type="text" name="access_code" value="{{ old('access_code', $activity->access_code) }}">
    </div>
    <div class="form-group">
      <label>Fecha y hora límite</label>
      <input type="datetime-local" name="due_at" value="{{ $activity->due_at ? $activity->due_at->format('Y-m-d\TH:i') : '' }}">
    </div>
    <button type="submit" class="btn btn-gold btn-sm">Guardar</button>
  </form>
</div>

<div class="card">
  <h3 style="font-size:1rem;margin-bottom:1rem;">Envíos ({{ $submissions->count() }})</h3>
  @if($submissions->isEmpty())
    <div class="empty-state">Todavía no hay envíos registrados.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead>
        <tr><th>Modo</th><th>Integrantes</th><th>IP</th><th>Enviado</th><th>Duración</th><th>Puntaje</th><th>Preguntas abiertas</th><th>Estado</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($submissions as $submission)
          @php
            $submissionGrading = $submission->isSubmitted() ? $activity->grade($submission) : null;
            $openTotal = $activity->questions->count();
            $openAnswers = $submission->answers['questions'] ?? [];
            $openAnswered = collect($openAnswers)->filter(fn ($a) => trim((string) $a) !== '')->count();
          @endphp
          <tr>
            <td>
              @if($submission->mode === 'grupal')
                <strong>grupo {{ $submission->group_code }}</strong>
              @else
                Individual
              @endif
            </td>
            <td>
              @foreach($submission->members as $member)
                {{ $member->full_name }} <span class="form-hint">({{ $member->email }}{{ $member->phone ? ' · '.$member->phone : '' }})</span><br>
              @endforeach
            </td>
            <td>{{ $submission->ip_address }}</td>
            <td>
              @if($submission->submitted_at)
                {{ $submission->submitted_at->timezone('America/Lima')->format('d/m/Y H:i') }}
              @else
                <span class="badge badge-gray">Sin enviar</span>
              @endif
            </td>
            <td>
              @if($submission->isSubmitted())
                {{ $submission->durationLabel() }}
              @else
                <span class="badge badge-gray">En curso</span>
              @endif
            </td>
            <td>
              @if($submissionGrading)
                {{ $submissionGrading['earned_points'] }}/{{ $submissionGrading['total_points'] }} <span class="form-hint">({{ $submissionGrading['percent'] }}%)</span>
              @else
                <span class="form-hint">—</span>
              @endif
            </td>
            <td>
              @if($openTotal === 0)
                <span class="form-hint">—</span>
              @elseif($openAnswered === 0)
                <span class="badge badge-gray">0/{{ $openTotal }}</span>
              @elseif($openAnswered === $openTotal)
                <span class="badge badge-success">{{ $openAnswered }}/{{ $openTotal }} ✓</span>
              @else
                <span class="badge badge-warning">{{ $openAnswered }}/{{ $openTotal }}</span>
              @endif
            </td>
            <td>
              <form action="{{ route('admin.academico.submissions.status', $submission) }}" method="POST" style="display:flex;gap:6px;align-items:center;">
                @csrf @method('PATCH')
                <select name="status" onchange="this.form.submit()" style="padding:6px 8px;border:1px solid var(--line);border-radius:6px;font-size:0.78rem;">
                  <option value="pendiente" {{ $submission->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                  <option value="aprobado" {{ $submission->status === 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                  <option value="no_aprobado" {{ $submission->status === 'no_aprobado' ? 'selected' : '' }}>No aprobado</option>
                </select>
              </form>
            </td>
            <td style="text-align:right;">
              <a href="#" class="btn btn-outline btn-sm js-toggle-answers" data-target="answers-{{ $submission->id }}">Ver respuestas</a>
            </td>
          </tr>
          <tr id="answers-{{ $submission->id }}" style="display:none;">
            <td colspan="9">
              <div style="background:var(--ivory-dim);border-radius:8px;padding:14px 18px;font-size:0.82rem;">
                @if($submissionGrading)
                  <div style="font-weight:700;margin-bottom:10px;">Ejercicios autocalificables — {{ $submissionGrading['earned_points'] }}/{{ $submissionGrading['total_points'] }} pts</div>
                  @foreach($activity->exercises as $exercise)
                    @php
                      $item = $submissionGrading['items'][$exercise->id] ?? null;
                      $isCorrect = (bool) ($item['correct'] ?? false);
                      $answerText = $exercise->formatStudentAnswer($item['student_answer'] ?? null);
                      $exLabel = $exercise->type === 'fillblank' ? ($exercise->payload['template'] ?? $exercise->prompt) : $exercise->prompt;
                    @endphp
                    <div style="display:flex;gap:10px;align-items:flex-start;padding:7px 0;border-bottom:1px solid var(--line);">
                      <span style="flex-shrink:0;">{{ $isCorrect ? '✅' : '❌' }}</span>
                      <div style="flex:1;min-width:0;">
                        <div style="color:var(--slate);font-size:0.74rem;margin-bottom:2px;">{{ $exLabel }}</div>
                        <div>{{ $answerText }}</div>
                      </div>
                      <span style="flex-shrink:0;font-size:0.7rem;color:var(--slate-light);white-space:nowrap;">{{ $exercise->points }} pt{{ $exercise->points === 1 ? '' : 's' }}</span>
                    </div>
                  @endforeach
                @elseif($activity->exercises->isNotEmpty())
                  <em>Todavía no envió la actividad — no hay respuestas de ejercicios que mostrar.</em>
                @endif

                @if($activity->questions->isNotEmpty())
                  @php $qs = $submission->answers['questions'] ?? []; @endphp
                  <div style="font-weight:700;margin:14px 0 8px;">Preguntas de reflexión (no puntúan, puntaje adicional)</div>
                  @foreach($activity->questions as $question)
                    <div style="margin-bottom:8px;">
                      <div style="color:var(--slate);font-size:0.74rem;margin-bottom:2px;">{{ $question->prompt }}</div>
                      <div>{{ ($qs[$question->id] ?? '') ?: '(sin responder)' }}</div>
                    </div>
                  @endforeach
                @endif
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table></div>
  @endif
</div>

<div class="card">
  <h3 style="font-size:1rem;margin-bottom:4px;">Visitas</h3>
  <div class="form-hint" style="margin-bottom:1rem;">{{ $visitsCount }} visitas totales · {{ $uniqueIpsCount }} IP únicas</div>
  @if($visits->isEmpty())
    <div class="empty-state">Todavía no se registran visitas.</div>
  @else
    <div class="table-wrap" style="max-height:340px;overflow-y:auto;"><table class="table">
      <thead><tr><th>IP</th><th>Fecha y hora</th><th>Navegador</th></tr></thead>
      <tbody>
        @foreach($visits as $visit)
          <tr>
            <td>{{ $visit->ip_address }}</td>
            <td>{{ $visit->visited_at->timezone('America/Lima')->format('d/m/Y H:i:s') }}</td>
            <td class="form-hint">{{ \Illuminate\Support\Str::limit($visit->user_agent, 60) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table></div>
  @endif
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.js-toggle-answers').forEach(link => {
  link.addEventListener('click', function (e) {
    e.preventDefault();
    const row = document.getElementById(this.dataset.target);
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
  });
});
</script>
@endsection
