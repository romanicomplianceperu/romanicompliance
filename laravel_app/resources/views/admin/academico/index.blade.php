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

<div class="card">
  @if($activities->isEmpty())
    <div class="empty-state">No hay actividades académicas para este filtro.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead>
        <tr><th>Actividad</th><th>Universidad / Curso</th><th>Vence</th><th>Código</th><th>Envíos</th><th>Último envío</th><th>Visitas</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($activities as $activity)
          <tr>
            <td>{{ $activity->title }}<br><span class="form-hint">{{ $activity->case_title }}</span></td>
            <td>{{ $activity->course->university->short_name }} — {{ $activity->course->name }}</td>
            <td>{{ $activity->due_at ? $activity->due_at->timezone('America/Lima')->format('d/m/Y H:i') : '—' }}</td>
            <td>{{ $activity->access_code ?? '—' }}</td>
            <td>{{ $activity->submissions_count }}</td>
            <td>{{ $activity->submissions_max_created_at ? \Illuminate\Support\Carbon::parse($activity->submissions_max_created_at)->timezone('America/Lima')->format('d/m/Y H:i') : '—' }}</td>
            <td>{{ $activity->visits_count }}</td>
            <td style="text-align:right;"><a href="{{ route('admin.academico.show', $activity) }}" class="btn btn-outline btn-sm">Ver</a></td>
          </tr>
        @endforeach
      </tbody>
    </table></div>
  @endif
</div>
@endsection
