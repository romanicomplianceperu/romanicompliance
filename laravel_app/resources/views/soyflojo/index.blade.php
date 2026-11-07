@extends('soyflojo.layout')
@php
  use App\Http\Controllers\SoyFlojoController as SF;
  $tz = SF::TZ;
@endphp

@section('title', 'Cursos '.($university->short_name ?? 'UNP'))

@section('styles')
.stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
.stat { background: var(--ink); color: #fff; border-radius: 16px; padding: 12px; }
.stat b { display: block; font-size: 1.45rem; font-weight: 800; line-height: 1.1; letter-spacing: -0.02em; }
.stat span { font-size: .74rem; color: rgba(255,255,255,.66); line-height: 1.25; display: block; margin-top: 3px; }
.stat.next b { font-size: .98rem; line-height: 1.25; }
.course { margin-top: 18px; }
.course > summary { list-style: none; cursor: pointer; display: flex; align-items: center; gap: 10px; padding: 4px 2px 10px; }
.course > summary::-webkit-details-marker { display: none; }
.course > summary h2 { flex: 1; font-size: 1.08rem; font-weight: 800; letter-spacing: -0.015em; }
.course > summary .chev { width: 9px; height: 9px; border-right: 2px solid var(--muted-2); border-bottom: 2px solid var(--muted-2); transform: rotate(45deg); transition: transform .25s; margin: 0 6px 4px 0; }
.course[open] > summary .chev { transform: rotate(-135deg); margin-bottom: -2px; }
.acts { display: grid; gap: 10px; }
.act { padding: 0; overflow: hidden; }
.act .hd { padding: 13px 14px 10px; }
.act .wk { font-size: .76rem; font-weight: 800; color: var(--blue); text-transform: uppercase; letter-spacing: .04em; display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
.act h3 { font-size: 1rem; font-weight: 800; line-height: 1.3; margin-top: 4px; }
.rows { border-top: 1px solid var(--line); }
.row { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-bottom: 1px solid var(--line); }
.row:last-child { border-bottom: 0; }
.row .k { width: 74px; flex-shrink: 0; font-size: .76rem; font-weight: 700; color: var(--muted-2); text-transform: uppercase; letter-spacing: .03em; }
.row .v { flex: 1; min-width: 0; font-weight: 700; }
.row .v small { display: block; font-weight: 600; color: var(--muted); font-size: .8rem; }
.code { font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: .98rem; background: var(--blue-50); color: var(--blue); padding: 4px 9px; border-radius: 8px; letter-spacing: .02em; word-break: break-all; }
.copied { background: var(--ok-50) !important; color: var(--ok) !important; border-color: var(--ok-50) !important; }
.de { border-top: 1px solid var(--line); background: #FAFBFD; }
.de > summary { list-style: none; cursor: pointer; display: flex; align-items: center; justify-content: space-between; padding: 11px 14px; font-weight: 700; font-size: .88rem; color: var(--blue); }
.de > summary::-webkit-details-marker { display: none; }
.de > summary .chev { width: 8px; height: 8px; border-right: 2px solid var(--blue); border-bottom: 2px solid var(--blue); transform: rotate(45deg); transition: transform .25s; margin-bottom: 3px; }
.de[open] > summary .chev { transform: rotate(-135deg); margin-bottom: -3px; }
.due-edit { padding: 0 14px 14px; }
.due-edit form.f1 { display: flex; gap: 8px; }
.due-edit input[type=datetime-local] { flex: 1; min-width: 0; padding: 9px 10px; border: 1.5px solid var(--line); border-radius: 12px; background: #fff; font-size: .92rem; }
.due-edit input[type=datetime-local]:focus { outline: none; border-color: var(--blue); }
.quick { display: flex; gap: 6px; margin-top: 8px; flex-wrap: wrap; }
.quick form { display: contents; }
.quick .btn { flex: 1; }
.subs { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 12px 14px; border-top: 1px solid var(--line); background: #fff; }
.subs b { font-size: 1.1rem; }
.empty { text-align: center; padding: 40px 16px; color: var(--muted); }
@media (min-width: 560px) { .stat b { font-size: 1.7rem; } }
@endsection

@section('top')
<header class="top">
  <div class="t"><b>Soy flojo · {{ $university->short_name ?? $university->name ?? 'UNP' }}</b><small>Fechas, códigos y envíos</small></div>
  <a class="ic-btn" href="{{ route('admin.academico.index') }}" title="Panel completo" aria-label="Panel completo"><svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg></a>
</header>
@endsection

@section('content')
@if(! $university || $courses->isEmpty())
  <div class="empty">Todavía no hay cursos de la UNP cargados.</div>
@else
  <div class="stats">
    <div class="stat"><b>{{ $stats['open'] }}</b><span>actividades abiertas</span></div>
    <div class="stat"><b>{{ $stats['sent'] }}</b><span>envíos recibidos</span></div>
    <div class="stat next">
      @if($stats['next'])<b>{{ $stats['next']->due_at->timezone($tz)->translatedFormat('D j M, g:i a') }}</b><span>próximo vencimiento</span>
      @else<b>—</b><span>sin vencimientos pendientes</span>@endif
    </div>
  </div>

  @foreach($courses as $course)
    <details class="course" open>
      <summary><h2>{{ $course->name }}</h2><span class="badge b-gray">{{ $course->activities->count() }}</span><span class="chev"></span></summary>
      <div class="acts">
        @forelse($course->activities as $a)
          @php
            $open = SF::isOpen($a);
            $local = $a->due_at?->copy()->timezone($tz);
          @endphp
          <article class="card act" id="act-{{ $a->id }}">
            <div class="hd">
              <div class="wk">Semana {{ $a->week_number }} · {{ $a->typeLabel() }}
                @if($a->is_hidden)<span class="badge b-gray">Oculta</span>
                @elseif($open)<span class="badge b-ok">Abierta</span>
                @elseif($a->status === 'proximamente')<span class="badge b-blue">Próximamente</span>
                @else<span class="badge b-gray">Vencida</span>@endif
              </div>
              <h3>{{ $a->title }}</h3>
            </div>
            <div class="rows">
              <div class="row">
                <span class="k">Vence</span>
                <span class="v">
                  @if($local){{ $local->translatedFormat('l j \d\e F, g:i a') }}<small>{{ $a->due_at->isFuture() ? 'faltan '.$a->due_at->diffForHumans(null, true, false, 2) : 'venció hace '.$a->due_at->diffForHumans(null, true, false, 1) }}</small>
                  @else<span class="muted">Sin fecha límite</span>@endif
                </span>
              </div>
              <div class="row">
                <span class="k">Código</span>
                <span class="v">@if($a->access_code)<span class="code">{{ $a->access_code }}</span>@else<span class="muted">Sin código</span>@endif</span>
                @if($a->access_code)<button type="button" class="btn btn-s" data-copy="{{ $a->access_code }}">Copiar</button>@endif
              </div>
            </div>
            <details class="de" @if($open) open @endif>
              <summary><span>Cambiar fecha</span><span class="chev"></span></summary>
            <div class="due-edit">
              <form class="f1" method="POST" action="{{ route('soyflojo.due', $a) }}">
                @csrf
                <input type="datetime-local" name="due_at" value="{{ $local?->format('Y-m-d\TH:i') }}" aria-label="Nueva fecha límite (hora de Lima)">
                <button class="btn btn-p" type="submit">Guardar</button>
              </form>
              <div class="quick">
                @foreach(['1h' => '+1 hora', '1d' => '+1 día', '7d' => '+1 semana'] as $k => $l)
                  <form method="POST" action="{{ route('soyflojo.due', $a) }}">@csrf<input type="hidden" name="shift" value="{{ $k }}"><button class="btn btn-s" type="submit">{{ $l }}</button></form>
                @endforeach
                @if($open)
                  <form method="POST" action="{{ route('soyflojo.due', $a) }}" onsubmit="return confirm('¿Cerrar ahora esta actividad? Ya no recibirá envíos.')">@csrf<input type="hidden" name="close" value="1"><button class="btn btn-s" type="submit" style="color:var(--bad)">Cerrar ya</button></form>
                @endif
              </div>
            </div>
            </details>
            <a class="subs" href="{{ route('soyflojo.show', $a) }}">
              <span><b>{{ $a->sent_count }}</b> <span class="muted">enviados</span>@if($a->draft_count) <span class="muted">· {{ $a->draft_count }} en curso</span>@endif</span>
              <span class="btn btn-s">Ver envíos →</span>
            </a>
          </article>
        @empty
          <div class="card muted">Sin actividades.</div>
        @endforelse
      </div>
    </details>
  @endforeach
  <p class="muted" style="text-align:center;font-size:.8rem;margin-top:20px">Las horas están en hora de Lima. Si mueves la fecha al futuro, la actividad vuelve a recibir envíos.</p>
@endif
@endsection
