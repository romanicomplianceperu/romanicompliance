@extends('soyflojo.layout')
@php
  use App\Http\Controllers\SoyFlojoController as SF;
  $tz = SF::TZ;
@endphp

@section('title', 'Cursos UNP')

@section('styles')
.hello { padding: 8px 2px 18px; }
.hello h1 { font-size: 1.7rem; font-weight: 800; letter-spacing: -0.03em; line-height: 1.15; }
.hello p { color: var(--muted); margin-top: 4px; }
.courses { display: grid; gap: 14px; }
.course { display: block; padding: 18px; position: relative; overflow: hidden; transition: transform .2s; }
.course:active { transform: scale(.985); }
.course::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: var(--c); }
.course .top-row { display: flex; align-items: center; gap: 14px; }
.course .tile { width: 52px; height: 52px; border-radius: 16px; background: var(--c50); color: var(--c); display: grid; place-items: center; flex-shrink: 0; }
.course .tile .ic { width: 26px; height: 26px; }
.course h2 { flex: 1; font-size: 1.18rem; font-weight: 800; letter-spacing: -0.02em; line-height: 1.2; }
.course .go { width: 34px; height: 34px; border-radius: 50%; background: #F3F5F9; display: grid; place-items: center; color: var(--muted); flex-shrink: 0; }
.course .nums { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 16px; }
.course .nums div { background: #F6F8FB; border-radius: 14px; padding: 10px 10px 9px; }
.course .nums b { display: block; font-size: 1.15rem; font-weight: 800; line-height: 1.15; }
.course .nums span { display: block; font-size: .72rem; color: var(--muted); font-weight: 600; line-height: 1.25; margin-top: 2px; }
.course .nums .due b { font-size: .9rem; line-height: 1.3; }
.empty { text-align: center; padding: 40px 16px; color: var(--muted); }
@endsection

@section('top')
<header class="top">
  <div class="t"><b>Soy flojo</b><small>{{ $university->name ?? 'Universidad Nacional de Piura' }}</small></div>
</header>
@endsection

@section('content')
<div class="hello">
  <h1>Cursos</h1>
  <p>Toca un curso para ver sus actividades, fechas y envíos.</p>
</div>

@if($courses->isEmpty())
  <div class="empty">Todavía no hay cursos cargados.</div>
@else
  <div class="courses">
    @foreach($courses as $c)
      @php
        $n = mb_strtolower($c->name);
        [$col, $col50, $icon] = str_contains($n, 'inform') ? ['#1F4FD8', '#EEF3FF', 'monitor']
          : (str_contains($n, 'mercantil') ? ['#0E8A5F', '#E1F3EC', 'briefcase']
          : (str_contains($n, 'procesal') || str_contains($n, 'administ') ? ['#7A4FD8', '#F1ECFD', 'scale'] : ['#C25B12', '#FBEBDD', 'book']));
      @endphp
      <a class="card course" href="{{ route('soyflojo.course', $c) }}" style="--c:{{ $col }};--c50:{{ $col50 }}">
        <div class="top-row">
          <span class="tile">
            @switch($icon)
              @case('monitor')<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4"/></svg>@break
              @case('briefcase')<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2M3 13h18"/></svg>@break
              @case('scale')<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18M7 21h10M5 7h14M5 7l-3 6a3 3 0 006 0L5 7zM19 7l-3 6a3 3 0 006 0l-3-6z"/></svg>@break
              @default<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5a2 2 0 012-2h13v16H6a2 2 0 00-2 2V5z"/></svg>
            @endswitch
          </span>
          <h2>{{ $c->name }}</h2>
          <span class="go"><svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg></span>
        </div>
        <div class="nums">
          <div><b>{{ $c->open_count }}</b><span>{{ $c->open_count === 1 ? 'abierta' : 'abiertas' }}</span></div>
          <div><b>{{ $c->sent_total }}</b><span>envíos</span></div>
          <div class="due">@if($c->next_due)<b>{{ $c->next_due->timezone($tz)->translatedFormat('D j M') }}</b><span>vence {{ $c->next_due->timezone($tz)->format('g:i a') }}</span>@else<b>—</b><span>sin plazos</span>@endif</div>
        </div>
      </a>
    @endforeach
  </div>
@endif
@endsection
