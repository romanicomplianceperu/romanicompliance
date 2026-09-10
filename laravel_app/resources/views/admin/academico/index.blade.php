@extends('admin.layout')

@section('title', 'Académico')

@section('content')
<div class="page-head">
  <h2 style="font-size:1.15rem">Espacio Académico — actividades</h2>
</div>

<div class="card" style="margin-bottom:1.2rem;">
  <form method="GET" action="{{ route('admin.academico.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
    <div>
      <label class="form-hint" style="display:block;margin-bottom:4px;">Universidad</label>
      <select name="university" onchange="this.form.submit()">
        <option value="">Todas</option>
        @foreach($universities as $uni)
          <option value="{{ $uni->id }}" @selected($universityId == $uni->id)>{{ $uni->short_name }}</option>
        @endforeach
      </select>
    </div>
    @if($universityId)
      <div>
        <label class="form-hint" style="display:block;margin-bottom:4px;">Curso</label>
        <select name="course" onchange="this.form.submit()">
          <option value="">Todos</option>
          @foreach($courses as $c)
            <option value="{{ $c->id }}" @selected($courseId == $c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
    @endif
    <div>
      <label class="form-hint" style="display:block;margin-bottom:4px;">Ordenar por</label>
      <select name="sort" onchange="this.form.submit()">
        <option value="recent" @selected($sort === 'recent')>Últimos envíos</option>
        <option value="due" @selected($sort === 'due')>Fecha límite</option>
        <option value="activity" @selected($sort === 'activity')>Actividad más reciente</option>
      </select>
    </div>
    @if($universityId || $courseId)
      <a href="{{ route('admin.academico.index') }}" class="btn btn-outline btn-sm">Quitar filtros</a>
    @endif
  </form>
</div>

@php
  $totalSubmissions = $activities->sum('submissions_count');
  $totalVisits = $activities->sum('visits_count');
  $overallConversion = $totalVisits > 0 ? (int) round($totalSubmissions / $totalVisits * 100) : 0;
@endphp

<div class="aca-stats-row">
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $activities->count() }}</div>
    <div class="aca-stat-label">Actividades</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $totalSubmissions }}</div>
    <div class="aca-stat-label">Envíos totales</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value">{{ $totalVisits }}</div>
    <div class="aca-stat-label">Visitas totales</div>
  </div>
  <div class="aca-stat-card">
    <div class="aca-stat-value accent">{{ $overallConversion }}%</div>
    <div class="aca-stat-label">Conversión visita → envío</div>
  </div>
</div>

@if($activities->isEmpty())
  <div class="card"><div class="empty-state">No hay actividades académicas para este filtro.</div></div>
@else
  <div class="aca-activities-grid">
    @foreach($activities as $activity)
      @php
        $conversion = $activity->visits_count > 0 ? (int) round($activity->submissions_count / $activity->visits_count * 100) : 0;
        $dueBadge = null;
        if ($activity->due_at) {
          $dueBadge = $activity->due_at->isPast()
            ? ['class' => 'badge-danger', 'label' => 'Vencido']
            : ($activity->due_at->diffInHours(now()) <= 48
                ? ['class' => 'badge-warning', 'label' => 'Vence pronto']
                : ['class' => 'badge-gray', 'label' => $activity->due_at->timezone('America/Lima')->format('d/m/Y H:i')]);
        }
      @endphp
      <a href="{{ route('admin.academico.show', $activity) }}" class="aca-activity-card">
        <div class="aca-activity-head">
          <div>
            <div class="aca-activity-title">{{ $activity->title }}</div>
            <div class="aca-activity-sub">{{ $activity->course->university->short_name }} — {{ $activity->course->name }}</div>
          </div>
          @if($dueBadge)
            <span class="badge {{ $dueBadge['class'] }}">{{ $dueBadge['label'] }}</span>
          @else
            <span class="badge badge-gray">Sin fecha límite</span>
          @endif
        </div>

        <div class="aca-activity-numbers">
          <div class="n"><span class="v">{{ $activity->submissions_count }}</span><span class="l">Envíos</span></div>
          <div class="n"><span class="v">{{ $activity->visits_count }}</span><span class="l">Visitas</span></div>
          <div class="n"><span class="v">{{ $conversion }}%</span><span class="l">Conversión</span></div>
        </div>
        <div class="aca-conv-track"><div class="aca-conv-fill" style="width:{{ $conversion }}%;"></div></div>

        <div class="aca-activity-foot">
          <span class="form-hint">
            Código: {{ $activity->access_code ?? '—' }} ·
            Último envío: {{ $activity->submissions_max_created_at ? \Illuminate\Support\Carbon::parse($activity->submissions_max_created_at)->timezone('America/Lima')->format('d/m/Y H:i') : '—' }}
          </span>
          <span class="btn btn-outline btn-sm">Ver →</span>
        </div>
      </a>
    @endforeach
  </div>
@endif
@endsection
