@extends('soyflojo.layout')
@php
  use App\Http\Controllers\SoyFlojoController as SF;
  $tz = SF::TZ;
  $n = mb_strtolower($course->name);
  [$col, $col50] = str_contains($n, 'inform') ? ['#1F4FD8', '#EEF3FF'] : (str_contains($n, 'mercantil') ? ['#0E8A5F', '#E1F3EC'] : (str_contains($n, 'procesal') || str_contains($n, 'administ') ? ['#7A4FD8', '#F1ECFD'] : ['#C25B12', '#FBEBDD']));
@endphp

@section('title', $course->name)

@section('styles')
:root { --c: {{ $col }}; --c50: {{ $col50 }}; }
.list { display: grid; gap: 14px; }
.act { padding: 0; overflow: hidden; }
.act .hd { display: flex; align-items: center; gap: 10px; padding: 16px 16px 0; }
.act .wk { font-size: .78rem; font-weight: 800; color: var(--c); background: var(--c50); padding: 4px 10px; border-radius: 999px; }
.act .hd .badge { margin-left: auto; }
.act h3 { font-size: 1.05rem; font-weight: 800; letter-spacing: -0.01em; padding: 10px 16px 0; line-height: 1.3; }
.act .due { padding: 12px 16px 0; }
.act .due .lbl { font-size: .74rem; font-weight: 700; color: var(--muted-2); text-transform: uppercase; letter-spacing: .04em; }
.act .due b { display: block; font-size: 1.12rem; font-weight: 800; line-height: 1.3; margin-top: 2px; }
.act .due small { color: var(--muted); font-weight: 600; font-size: .84rem; }
.codebox { margin: 14px 16px 0; display: flex; align-items: center; gap: 10px; background: #F6F8FB; border-radius: 14px; padding: 10px 10px 10px 14px; }
.codebox .lbl { font-size: .74rem; font-weight: 700; color: var(--muted-2); text-transform: uppercase; letter-spacing: .04em; }
.codebox code { flex: 1; min-width: 0; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 1.02rem; font-weight: 700; color: var(--ink); word-break: break-all; }
.copied { background: var(--ok-50) !important; color: var(--ok) !important; border-color: var(--ok-50) !important; }
.acts { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; padding: 14px 16px 16px; }
.acts .btn { padding: 12px; }
.acts .btn-c { background: var(--c); border-color: var(--c); color: #fff; }
.acts .off { grid-column: 1 / -1; }
.acts .btn-off { width: 100%; color: var(--bad); border-color: var(--bad-50); background: #fff; }
.acts .btn-react { border-color: var(--ok); color: var(--ok); background: var(--ok-50); }
.edit { border-top: 1px solid var(--line); padding: 14px 16px 16px; background: #FAFBFD; }
.edit form.f1 { display: flex; gap: 8px; }
.edit input[type=datetime-local] { flex: 1; min-width: 0; padding: 11px 12px; border: 1.5px solid var(--line); border-radius: 12px; background: #fff; font-size: .95rem; }
.edit input[type=datetime-local]:focus { outline: none; border-color: var(--c); }
.chips { display: flex; gap: 6px; margin-top: 10px; flex-wrap: wrap; }
.chips form { display: contents; }
.chips .btn { flex: 1; padding: 9px 8px; font-size: .84rem; border-radius: 999px; }
.hint { font-size: .78rem; color: var(--muted); margin-top: 10px; }
.empty { text-align: center; padding: 40px 16px; color: var(--muted); }
@endsection

@section('top')
<header class="top">
  <a class="back" href="{{ route('soyflojo.index') }}" aria-label="Volver"><svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg></a>
  <div class="t"><b>{{ $course->name }}</b><small>{{ $activities->count() }} actividades</small></div>
</header>
@endsection

@section('content')
<div class="list">
  @forelse($activities as $a)
    @php
      $open = SF::isOpen($a);
      $local = $a->due_at?->copy()->timezone($tz);
      $title = preg_match('/^semana\s*\d+/i', $a->title) ? $a->typeLabel() : $a->title;
      // En una vencida u oculta se sugiere reactivarla una semana más, hasta las 8:00 p. m.
      $suggest = ($local && $a->due_at->isFuture()) ? $local : now()->timezone($tz)->addDays(7)->setTime(20, 0);
    @endphp
    <article class="card act" id="act-{{ $a->id }}">
      <div class="hd">
        <span class="wk">Semana {{ $a->week_number }}</span>
        @if($a->is_hidden)<span class="badge b-gray">Oculta</span>
        @elseif($open)<span class="badge b-ok">● Abierta</span>
        @elseif($a->status === 'proximamente')<span class="badge b-blue">Próximamente</span>
        @elseif($a->status === 'cerrada' && $a->due_at?->isFuture())<span class="badge b-warn">Desactivada</span>
        @else<span class="badge b-gray">Vencida</span>@endif
      </div>
      <h3>{{ $title }}</h3>
      <div class="due">
        <span class="lbl">Vence</span>
        @if($local)<b>{{ ucfirst($local->translatedFormat('l j \d\e F')) }}, {{ $local->format('g:i a') }}</b><small>{{ $a->due_at->isFuture() ? 'Faltan '.$a->due_at->diffForHumans(null, true, false, 2) : 'Venció hace '.$a->due_at->diffForHumans(null, true, false, 1) }}</small>
        @else<b class="muted">Sin fecha límite</b>@endif
      </div>
      @if($a->access_code)
        <div class="codebox"><span class="lbl">Código</span><code>{{ $a->access_code }}</code><button type="button" class="btn btn-s" data-copy="{{ $a->access_code }}">Copiar</button></div>
      @endif
      <div class="acts">
        @if($open)<button type="button" class="btn" data-toggle="edit-{{ $a->id }}">📅 Cambiar fecha</button>
        @else<button type="button" class="btn btn-react" data-toggle="edit-{{ $a->id }}">🔄 Reactivar</button>@endif
        <a class="btn btn-c" href="{{ route('soyflojo.show', $a) }}">Envíos · {{ $a->sent_count }}</a>
        @if($open)
          <form class="off" method="POST" action="{{ route('soyflojo.due', $a) }}" onsubmit="return confirm('¿Desactivar esta actividad? Los alumnos dejarán de poder enviarla hasta que la reactives.')">@csrf<input type="hidden" name="close" value="1"><button class="btn btn-off" type="submit">⏸ Desactivar</button></form>
        @endif
      </div>
      <div class="edit" id="edit-{{ $a->id }}" hidden>
        <form class="f1" method="POST" action="{{ route('soyflojo.due', $a) }}">
          @csrf
          <input type="datetime-local" name="due_at" value="{{ $suggest->format('Y-m-d\TH:i') }}" required aria-label="Nueva fecha límite (hora de Lima)">
          <button class="btn btn-p" type="submit">{{ $open ? 'Guardar' : 'Reactivar' }}</button>
        </form>
        <div class="chips">
          @foreach(['1h' => '+1 hora', '1d' => '+1 día', '7d' => '+1 semana'] as $k => $l)
            <form method="POST" action="{{ route('soyflojo.due', $a) }}">@csrf<input type="hidden" name="shift" value="{{ $k }}"><button class="btn" type="submit">{{ $l }}</button></form>
          @endforeach
        </div>
        <p class="hint">@if($open)Hora de Lima.@else Elige la nueva fecha límite (hora de Lima) y toca «Reactivar»: la actividad vuelve a estar abierta y visible para los alumnos.@endif</p>
      </div>
    </article>
  @empty
    <div class="empty">Este curso todavía no tiene actividades.</div>
  @endforelse
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('click', (e) => {
  const b = e.target.closest('[data-toggle]'); if (!b) return;
  const el = document.getElementById(b.dataset.toggle); el.hidden = !el.hidden;
  b.classList.toggle('btn-p', !el.hidden);
  if (!el.hidden) setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 30);
});
// Tras guardar, mantener a la vista la actividad editada
if (location.hash) { const a = document.querySelector(location.hash); if (a) a.scrollIntoView({ block: 'center' }); }
</script>
@endsection
