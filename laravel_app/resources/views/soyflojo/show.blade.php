@extends('soyflojo.layout')
@php
  use App\Http\Controllers\SoyFlojoController as SF;
  $tz = SF::TZ;
  $qTotal = $activity->questions->count();
@endphp

@section('title', 'Envíos · '.$activity->title)

@section('styles')
.tabs { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; background: #E7EBF2; padding: 4px; border-radius: 14px; }
.tabs a { text-align: center; padding: 9px; border-radius: 11px; font-weight: 800; font-size: .88rem; color: var(--muted); }
.tabs a.on { background: #fff; color: var(--ink); box-shadow: 0 6px 16px -10px rgba(10,23,48,.4); }
.bar { display: flex; gap: 8px; align-items: center; margin: 12px 0; flex-wrap: wrap; }
.bar .info { flex: 1; min-width: 0; font-size: .86rem; color: var(--muted); }
.sub { padding: 0; overflow: hidden; margin-bottom: 10px; }
.sub .hd { padding: 13px 14px; display: flex; gap: 12px; align-items: flex-start; }
.sub .who { flex: 1; min-width: 0; }
.sub .who b { display: block; font-weight: 800; line-height: 1.3; }
.sub .who small { display: block; color: var(--muted); font-size: .8rem; margin-top: 2px; }
.score { text-align: right; flex-shrink: 0; }
.score b { font-size: 1.25rem; font-weight: 800; display: block; line-height: 1.1; }
.score small { color: var(--muted-2); font-size: .74rem; font-weight: 700; }
.people { padding: 0 14px 10px; display: grid; gap: 6px; }
.person { display: flex; align-items: center; gap: 8px; font-size: .86rem; }
.person span { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.person a { color: var(--blue); font-weight: 700; font-size: .8rem; white-space: nowrap; }
.meta { display: flex; gap: 6px; flex-wrap: wrap; padding: 0 14px 12px; }
.ft { display: flex; gap: 8px; align-items: center; padding: 10px 14px; border-top: 1px solid var(--line); background: #FAFBFD; }
.ft select { flex: 1; min-width: 0; padding: 8px 10px; border: 1.5px solid var(--line); border-radius: 10px; background: #fff; font-weight: 700; font-size: .86rem; }
details.ans { border-top: 1px solid var(--line); }
details.ans > summary { list-style: none; cursor: pointer; padding: 10px 14px; font-weight: 700; font-size: .86rem; color: var(--blue); }
details.ans > summary::-webkit-details-marker { display: none; }
details.ans .in { padding: 0 14px 14px; font-size: .86rem; display: grid; gap: 8px; }
.ex { display: flex; gap: 8px; align-items: flex-start; padding-bottom: 8px; border-bottom: 1px solid var(--line); }
.ex div { flex: 1; min-width: 0; }
.ex small { display: block; color: var(--muted); font-size: .76rem; }
.txt { white-space: pre-line; background: var(--bg); border-radius: 10px; padding: 10px; }
.empty { text-align: center; padding: 40px 16px; color: var(--muted); }
@endsection

@section('top')
<header class="top">
  <a class="back" href="{{ route('soyflojo.course', $activity->course) }}#act-{{ $activity->id }}" aria-label="Volver"><svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg></a>
  <div class="t"><b>{{ $activity->course->name }} · Semana {{ $activity->week_number }}</b><small>{{ $activity->title }}</small></div>
</header>
@endsection

@section('content')
<nav class="tabs">
  <a href="?ver=enviados" class="{{ $tab === 'enviados' ? 'on' : '' }}">Enviados ({{ $sent->count() }})</a>
  <a href="?ver=en-curso" class="{{ $tab === 'en-curso' ? 'on' : '' }}">En curso ({{ $drafts->count() }})</a>
</nav>
<div class="bar">
  <div class="info">
    @if($activity->due_at)Vence {{ $activity->due_at->timezone($tz)->translatedFormat('D j M, g:i a') }} @endif
    @if($activity->access_code)· código <b style="color:var(--ink)">{{ $activity->access_code }}</b>@endif
  </div>
  @if($sent->isNotEmpty())<a class="btn btn-s" href="{{ route('soyflojo.csv', $activity) }}">Descargar notas (Excel)</a>@endif
</div>

@forelse($list as $s)
  @php
    $g = $s->isSubmitted() ? $activity->grade($s) : null;
    $qa = collect($s->answers['questions'] ?? [])->filter(fn ($x) => trim((string) $x) !== '')->count();
  @endphp
  <article class="card sub">
    <div class="hd">
      <div class="who">
        <b>{{ $s->mode === 'grupal' ? 'Grupo '.$s->group_code : ($s->members->first()->full_name ?? 'Sin nombre') }}</b>
        <small>{{ $s->isSubmitted() ? 'Enviado '.$s->submitted_at->timezone($tz)->translatedFormat('D j M, g:i a').(($s->durationSeconds() ?? -1) >= 0 ? ' · '.$s->durationLabel() : '') : 'Empezó '.$s->created_at->timezone($tz)->translatedFormat('D j M, g:i a') }}</small>
      </div>
      @if($g)
        <div class="score"><b>{{ rtrim(rtrim(number_format($g['earned_points'], 1), '0'), '.') }}<span style="font-size:.8rem;color:var(--muted-2)">/{{ $g['total_points'] }}</span></b><small>{{ $g['percent'] }}%@if($g['bonus_points'] > 0) · +{{ $g['bonus_points'] }}@endif</small></div>
      @endif
    </div>
    <div class="people">
      @foreach($s->members as $m)
        <div class="person"><span>{{ $s->mode === 'grupal' ? $m->full_name : $m->email }}</span>
          @if($m->phone)<a href="https://wa.me/{{ preg_replace('/\D/', '', strlen(preg_replace('/\D/', '', $m->phone)) === 9 ? '51'.$m->phone : $m->phone) }}" target="_blank" rel="noopener">WhatsApp</a>@endif
          @if($m->email)<a href="mailto:{{ $m->email }}">Correo</a>@endif
        </div>
      @endforeach
    </div>
    <div class="meta">
      @if($activity->hasUpload())
        @if($s->hasFile())<a class="badge b-blue" href="{{ $s->fileUrl() }}" target="_blank" rel="noopener">📎 {{ \Illuminate\Support\Str::limit($s->file_name ?: 'Archivo', 28) }}</a>
        @else<span class="badge {{ $activity->upload_required ? 'b-warn' : 'b-gray' }}">Sin archivo</span>@endif
      @endif
      @if($qTotal)<span class="badge {{ $qa === $qTotal ? 'b-ok' : ($qa ? 'b-warn' : 'b-gray') }}">Preguntas {{ $qa }}/{{ $qTotal }}</span>@endif
    </div>
    @if($s->isSubmitted())
      <form class="ft" method="POST" action="{{ route('soyflojo.submission', $s) }}">
        @csrf
        <select name="status" onchange="this.form.submit()" aria-label="Estado del envío">
          <option value="pendiente" @selected($s->status === 'pendiente')>⏳ Pendiente de revisar</option>
          <option value="aprobado" @selected($s->status === 'aprobado')>✅ Aprobado</option>
          <option value="no_aprobado" @selected($s->status === 'no_aprobado')>❌ No aprobado</option>
        </select>
      </form>
    @endif
    @if($g || $s->bonusText() !== '' || $qa)
      <details class="ans">
        <summary>Ver respuestas</summary>
        <div class="in">
          @if($g)
            @foreach($activity->exercises as $ex)
              @php $it = $g['items'][$ex->id] ?? null; $sc = $ex->score($it['student_answer'] ?? null); @endphp
              <div class="ex"><span>{{ ($it['correct'] ?? false) ? '✅' : ($sc > 0 ? '🟡' : '❌') }}</span><div><small>{{ \Illuminate\Support\Str::limit(strip_tags($ex->type === 'fillblank' ? ($ex->payload['template'] ?? $ex->prompt) : $ex->prompt), 90) }}</small>{{ \Illuminate\Support\Str::limit($ex->formatStudentAnswer($it['student_answer'] ?? null), 220) }}</div></div>
            @endforeach
          @endif
          @if($s->bonusText() !== '')<div><b>Respuesta escrita</b><div class="txt">{{ $s->bonusText() }}</div></div>@endif
          @foreach($activity->questions as $i => $q)
            @php $resp = trim((string) (($s->answers['questions'] ?? [])[$q->id] ?? '')); @endphp
            @if($resp !== '')<div><b style="font-size:.8rem">{{ $q->prompt }}</b><div class="txt">{{ $resp }}</div></div>@endif
          @endforeach
        </div>
      </details>
    @endif
  </article>
@empty
  <div class="empty">{{ $tab === 'enviados' ? 'Todavía no hay envíos.' : 'Nadie tiene la actividad a medias.' }}</div>
@endforelse
@endsection
