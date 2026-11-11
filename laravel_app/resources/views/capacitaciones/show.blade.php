@extends('layouts.site')

@section('title', $t['name'].' · Capacitación · Romani Compliance')
@section('description', $t['description'])
@if(! empty($t['noindex']))
@section('robots', 'noindex, nofollow')
@endif
@section('og_image', asset('images/og-herramientas.jpg'))

@php
  $totalMin = collect($t['modules'])->sum('min');
  $hours = $totalMin / 60;
  $hoursLabel = (floor($hours) == $hours ? (int) $hours : number_format($hours, 1, ',', '')).' h';
  $pending = fn ($v) => filled($v) ? $v : 'Por confirmar';
@endphp

@section('og_extra')
<script type="application/ld+json">
{!! json_encode(array_filter([
  '@context' => 'https://schema.org',
  '@type' => 'Course',
  'name' => $t['name'],
  'description' => $t['description'],
  'inLanguage' => 'es-PE',
  'provider' => ['@type' => 'Organization', 'name' => 'Romani Compliance', 'url' => url('/')],
  'educationalCredentialAwarded' => 'Certificado de participación',
  'audience' => ['@type' => 'Audience', 'audienceType' => 'Oficiales de cumplimiento'],
  'timeRequired' => 'PT'.(int) $totalMin.'M',
  'hasCourseInstance' => ['@type' => 'CourseInstance', 'courseMode' => 'Online'],
  'url' => route('capacitaciones.show', $slug),
]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('styles')
/* ===== Hero ===== */
.tr-hero { position: relative; background: var(--ink); color: #fff; padding: clamp(36px, 5vw, 68px) 0 clamp(44px, 6vw, 84px); overflow: hidden; }
.tr-hero::before { content: ''; position: absolute; width: 720px; height: 720px; right: -240px; top: -300px; border-radius: 50%; background: radial-gradient(circle, rgba(127,163,255,.28), transparent 62%); pointer-events: none; }
.tr-hero::after { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(127,163,255,.06) 1px, transparent 1px), linear-gradient(90deg, rgba(127,163,255,.06) 1px, transparent 1px); background-size: 52px 52px; mask-image: radial-gradient(ellipse at 80% 30%, #000 0%, transparent 70%); pointer-events: none; }
.tr-hero .wrap { position: relative; z-index: 1; }
.tr-crumb { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; font-size: .88rem; color: rgba(255,255,255,.55); margin-bottom: 26px; }
.tr-crumb a { color: rgba(255,255,255,.75); } .tr-crumb a:hover { color: #fff; }
.tr-hero-grid { display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(0, .95fr); gap: clamp(28px, 5vw, 72px); align-items: center; }
@media (max-width: 960px) { .tr-hero-grid { grid-template-columns: 1fr; } }
.tr-badge { display: inline-flex; align-items: center; gap: 10px; padding: 8px 16px; border-radius: 999px; background: rgba(127,163,255,.14); border: 1px solid rgba(127,163,255,.3); color: var(--blue-l); font-weight: 700; font-size: .9rem; line-height: 1.3; }
.tr-badge i { flex-shrink: 0; width: 7px; height: 7px; border-radius: 50%; background: #3DDC97; box-shadow: 0 0 0 4px rgba(61,220,151,.2); }
.tr-hero h1 { font-size: clamp(1.95rem, 3.7vw, 3.1rem); font-weight: 800; line-height: 1.06; letter-spacing: -0.04em; margin: 20px 0 0; }
.tr-hero h1 em { font-style: normal; color: var(--blue-l); }
.tr-hero .lead { color: rgba(255,255,255,.74); margin: 20px 0 0; }
.tr-facts { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px 22px; margin: clamp(30px, 4vw, 48px) 0 0; padding: 26px 0 0; border-top: 1px solid rgba(255,255,255,.14); list-style: none; }
@media (max-width: 960px) { .tr-facts { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
.tr-facts li { display: flex; gap: 12px; align-items: center; min-width: 0; }
.tr-facts .ic { width: 38px; height: 38px; padding: 9px; border-radius: 12px; background: rgba(255,255,255,.08); color: var(--blue-l); flex-shrink: 0; }
.tr-facts b { display: block; font-size: .98rem; line-height: 1.25; }
.tr-facts span { display: block; font-size: .78rem; color: rgba(255,255,255,.55); text-transform: uppercase; letter-spacing: .06em; font-weight: 700; margin-bottom: 1px; }
.tr-acts { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 30px; }
@media (max-width: 560px) { .tr-acts .b { flex: 1 1 100%; justify-content: center; } .tr-facts { grid-template-columns: 1fr; } }

/* ===== Video de presentación ===== */
.tr-video { position: relative; aspect-ratio: 16 / 9; border-radius: 26px; overflow: hidden; background: linear-gradient(140deg, #16305F 0%, #0C1D40 60%, #0A1730 100%) center / cover no-repeat; border: 1px solid rgba(255,255,255,.14); box-shadow: 0 50px 90px -40px rgba(0,0,0,.8); }
.tr-video::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(127,163,255,.08) 1px, transparent 1px), linear-gradient(90deg, rgba(127,163,255,.08) 1px, transparent 1px); background-size: 34px 34px; mask-image: radial-gradient(ellipse at 50% 50%, #000 10%, transparent 75%); }
.tr-video.has-poster::before { display: none; }
.tr-video.has-poster::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(10,23,48,.1), rgba(10,23,48,.55)); }
.tr-video iframe, .tr-video video { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; background: #000; z-index: 3; }
.tr-play { position: absolute; inset: 0; z-index: 2; width: 100%; border: 0; background: none; cursor: pointer; display: grid; place-content: center; justify-items: center; gap: 16px; color: #fff; font: inherit; }
.tr-play .pb { width: 88px; height: 88px; border-radius: 50%; background: #fff; color: var(--blue); display: grid; place-items: center; box-shadow: 0 0 0 0 rgba(255,255,255,.5); animation: trPulse 2.4s ease-out infinite; transition: transform .3s var(--ease); }
.tr-play:hover .pb { transform: scale(1.08); }
.tr-play .pb svg { width: 34px; height: 34px; margin-left: 4px; }
.tr-play .pt { font-weight: 800; font-size: 1.05rem; letter-spacing: -0.01em; }
.tr-play .ps { font-size: .86rem; color: rgba(255,255,255,.65); margin-top: -10px; }
@keyframes trPulse { 0% { box-shadow: 0 0 0 0 rgba(255,255,255,.45); } 70% { box-shadow: 0 0 0 26px rgba(255,255,255,0); } 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0); } }
.tr-video.empty .tr-play { cursor: default; }
.tr-video.empty .pb { animation: none; background: rgba(255,255,255,.1); color: rgba(255,255,255,.85); border: 1.5px dashed rgba(255,255,255,.35); }
.tr-video.empty:hover .pb { transform: none; }
.tr-soon { position: absolute; top: 16px; left: 16px; z-index: 2; padding: 6px 12px; border-radius: 999px; background: rgba(255,255,255,.12); backdrop-filter: blur(6px); font-size: .76rem; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; }
.tr-video-cap { display: flex; gap: 10px; align-items: center; margin-top: 14px; color: rgba(255,255,255,.6); font-size: .88rem; }
.tr-video-cap .ic { width: 18px; height: 18px; color: var(--blue-l); flex-shrink: 0; }
@media (prefers-reduced-motion: reduce) { .tr-play .pb { animation: none; } }

/* ===== Cifras ===== */
.tr-stats { background: #fff; border-bottom: 1px solid var(--line); }
.tr-stats .wrap { display: grid; grid-template-columns: repeat(4, 1fr); }
.tr-stats .s { padding: 26px 22px; border-right: 1px solid var(--line); }
.tr-stats .s:first-child { padding-left: 0; } .tr-stats .s:last-child { border-right: 0; }
.tr-stats b { display: block; font-size: clamp(1.9rem, 3vw, 2.6rem); font-weight: 800; letter-spacing: -0.04em; line-height: 1; color: var(--ink); }
.tr-stats span { display: block; margin-top: 8px; color: var(--muted); font-size: .92rem; }
@media (max-width: 720px) { .tr-stats .wrap { grid-template-columns: 1fr 1fr; } .tr-stats .s { padding: 18px 14px; border-bottom: 1px solid var(--line); } .tr-stats .s:nth-child(2n) { border-right: 0; } .tr-stats .s:first-child { padding-left: 14px; } .tr-stats .s:nth-last-child(-n+2) { border-bottom: 0; } }

/* ===== Cuerpo con tarjeta de inscripción ===== */
.tr-main { padding: clamp(48px, 7vw, 96px) 0; }
.tr-grid { display: grid; grid-template-columns: minmax(0, 1fr) 380px; gap: clamp(32px, 5vw, 72px); align-items: start; }
@media (max-width: 1060px) { .tr-grid { grid-template-columns: 1fr; } .tr-aside { display: none; } }
.tr-blk { margin-bottom: clamp(48px, 6vw, 80px); }
.tr-blk:last-child { margin-bottom: 0; }
.tr-blk > h2 { font-size: clamp(1.6rem, 2.8vw, 2.3rem); font-weight: 800; letter-spacing: -0.03em; line-height: 1.12; }
.tr-blk > .sub { color: var(--muted); margin-top: 12px; max-width: 640px; }
.tr-blk .kicker { margin-bottom: 12px; }
.tr-aud { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 26px; }
@media (max-width: 760px) { .tr-aud { grid-template-columns: 1fr; gap: 10px; } .tr-aud > div { display: grid; grid-template-columns: 52px 1fr; column-gap: 16px; padding: 18px; } .tr-aud .icon-tile { grid-row: span 2; } .tr-aud h3 { margin: 2px 0 4px; } }
.tr-aud > div { border: 1px solid var(--line); border-radius: 22px; padding: 22px; background: #fff; }
.tr-aud h3 { font-size: 1.05rem; font-weight: 800; margin: 14px 0 6px; letter-spacing: -0.01em; }
.tr-aud p { color: var(--muted); font-size: .94rem; line-height: 1.6; }
.tr-pains { margin-top: 24px; display: grid; gap: 10px; padding: 0; list-style: none; }
.tr-pains li { display: flex; gap: 14px; align-items: flex-start; padding: 16px 18px; border-radius: 16px; background: var(--soft); font-weight: 600; line-height: 1.5; }
.tr-pains li::before { content: '!'; width: 24px; height: 24px; border-radius: 50%; background: #FBEBDD; color: var(--warn); font-weight: 800; display: grid; place-items: center; flex-shrink: 0; font-size: .85rem; margin-top: 1px; }
.tr-learn { margin-top: 26px; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; padding: 0; list-style: none; }
@media (max-width: 760px) { .tr-learn { grid-template-columns: 1fr; } }
.tr-learn li { display: flex; gap: 12px; align-items: flex-start; border: 1px solid var(--line); border-radius: 18px; padding: 16px 18px; background: #fff; line-height: 1.5; font-size: .96rem; }
.tr-learn .ic { width: 22px; height: 22px; color: var(--ok); flex-shrink: 0; margin-top: 1px; }

/* ===== Lo que dice la norma ===== */
.tr-norm { margin-top: 26px; border-radius: 28px; background: var(--ink); color: #fff; padding: clamp(22px, 3.4vw, 40px); position: relative; overflow: hidden; }
.tr-norm::before { content: ''; position: absolute; width: 380px; height: 380px; right: -120px; top: -160px; border-radius: 50%; background: radial-gradient(circle, rgba(127,163,255,.3), transparent 65%); }
.tr-norm > * { position: relative; }
.tr-norm .l { color: rgba(255,255,255,.72); max-width: 560px; }
.tr-ncards { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; margin-top: 22px; }
@media (max-width: 640px) { .tr-ncards { grid-template-columns: 1fr; } }
.tr-ncards > div { border: 1px solid rgba(255,255,255,.14); background: rgba(255,255,255,.05); border-radius: 20px; padding: 18px 20px; }
.tr-ncards .k { font-size: .76rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: var(--blue-l); }
.tr-ncards b { display: block; font-size: 1.7rem; font-weight: 800; letter-spacing: -0.03em; margin: 4px 0 6px; }
.tr-ncards p { color: rgba(255,255,255,.7); font-size: .9rem; line-height: 1.55; }
.tr-src { margin-top: 20px; display: grid; gap: 8px; }
.tr-src a { display: flex; gap: 10px; align-items: center; justify-content: space-between; padding: 12px 16px; border-radius: 14px; background: rgba(255,255,255,.08); font-weight: 700; font-size: .9rem; transition: background .2s; }
.tr-src a:hover { background: rgba(255,255,255,.16); }
.tr-src a span { color: var(--blue-l); white-space: nowrap; }
.tr-nnote { margin-top: 14px; font-size: .84rem; color: rgba(255,255,255,.55); line-height: 1.55; }

/* ===== Programa ===== */
.tr-mods { margin-top: 26px; display: grid; gap: 10px; }
.tr-mod { border: 1px solid var(--line); border-radius: 20px; background: #fff; transition: border-color .25s, box-shadow .25s; }
.tr-mod[open] { border-color: var(--blue); box-shadow: 0 18px 40px -30px rgba(31,79,216,.55); }
.tr-mod summary { list-style: none; cursor: pointer; display: grid; grid-template-columns: 44px 1fr auto 28px; gap: 16px; align-items: center; padding: 18px 20px; }
.tr-mod summary::-webkit-details-marker { display: none; }
.tr-mod .n { width: 44px; height: 44px; border-radius: 14px; background: var(--blue-50); color: var(--blue); font-weight: 800; display: grid; place-items: center; transition: background .25s, color .25s; }
.tr-mod[open] .n { background: var(--blue); color: #fff; }
.tr-mod h3 { font-size: 1.04rem; font-weight: 800; letter-spacing: -0.01em; line-height: 1.3; }
.tr-mod .d { font-size: .84rem; font-weight: 700; color: var(--muted); background: var(--soft); padding: 5px 11px; border-radius: 999px; white-space: nowrap; }
.tr-mod .cv { width: 22px; height: 22px; color: var(--muted-2); transition: transform .3s var(--ease); }
.tr-mod[open] .cv { transform: rotate(180deg); color: var(--blue); }
.tr-mod .bd { padding: 0 20px 20px 80px; color: var(--muted); }
.tr-mod .bd .act { display: flex; gap: 10px; align-items: flex-start; margin-top: 12px; padding: 12px 14px; border-radius: 14px; background: var(--blue-50); color: var(--ink); font-size: .92rem; font-weight: 600; }
.tr-mod .bd .act .ic { width: 18px; height: 18px; color: var(--blue); flex-shrink: 0; margin-top: 2px; }
@media (max-width: 640px) { .tr-mod summary { grid-template-columns: 36px 1fr 22px; gap: 12px; padding: 14px; } .tr-mod .d { display: none; } .tr-mod .n { width: 36px; height: 36px; border-radius: 11px; } .tr-mod .bd { padding: 0 14px 16px 14px; } }
.tr-total { display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-top: 14px; padding: 16px 20px; border-radius: 18px; background: var(--ink); color: #fff; font-weight: 700; }
.tr-total span { color: var(--blue-l); }

/* ===== Entregables ===== */
.tr-del { margin-top: 26px; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
@media (max-width: 640px) { .tr-del { grid-template-columns: 1fr; } }
.tr-del > div { display: flex; gap: 14px; align-items: flex-start; border: 1px solid var(--line); border-radius: 20px; padding: 18px; background: #fff; }
.tr-del .icon-tile { width: 46px; height: 46px; flex-shrink: 0; }
.tr-del h3 { font-size: 1rem; font-weight: 800; letter-spacing: -0.01em; }
.tr-del p { color: var(--muted); font-size: .9rem; margin-top: 3px; line-height: 1.5; }

/* ===== Tarjeta de inscripción (lateral) ===== */
.tr-aside { position: sticky; top: 100px; }
.tr-card { border: 1px solid var(--line); border-radius: 28px; background: #fff; box-shadow: 0 40px 80px -50px rgba(10,23,48,.5); overflow: hidden; }
.tr-card .top { background: var(--ink); color: #fff; padding: 24px 26px; }
.tr-card .top small { display: block; font-size: .76rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: var(--blue-l); }
.tr-card .top b { display: block; font-size: 2rem; font-weight: 800; letter-spacing: -0.04em; margin-top: 6px; line-height: 1.1; }
.tr-card .top p { color: rgba(255,255,255,.62); font-size: .86rem; margin-top: 6px; }
.tr-card .bd { padding: 22px 26px 26px; }
.tr-card dl { display: grid; gap: 14px; margin: 0 0 22px; }
.tr-card dl div { display: flex; justify-content: space-between; gap: 16px; font-size: .94rem; align-items: baseline; }
.tr-card dt { color: var(--muted); } .tr-card dd { margin: 0; font-weight: 700; text-align: right; }
.tr-card dd.tbc { color: var(--muted-2); font-weight: 600; }
.tr-card .seats { display: flex; gap: 10px; align-items: flex-start; padding: 12px 14px; border-radius: 14px; background: #FBEBDD; color: #8A3B0B; font-size: .86rem; font-weight: 600; margin-bottom: 18px; line-height: 1.45; }
.tr-card .seats .ic { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; }
.tr-card .inc { display: grid; gap: 9px; margin: 20px 0 0; padding-top: 20px; border-top: 1px solid var(--line); list-style: none; padding-left: 0; font-size: .9rem; }
.tr-card .inc li { display: flex; gap: 10px; align-items: flex-start; }
.tr-card .inc .ic { width: 18px; height: 18px; color: var(--ok); flex-shrink: 0; margin-top: 2px; }
.tr-card .wa-l { display: block; text-align: center; margin-top: 14px; font-weight: 700; font-size: .92rem; color: var(--blue); }

/* ===== Cronograma (oscuro) ===== */
.tr-tl-split { display: grid; grid-template-columns: .9fr 1.1fr; gap: clamp(36px, 7vw, 110px); align-items: start; }
.tr-tl-split .sticky { position: sticky; top: 120px; }
@media (max-width: 900px) { .tr-tl-split { grid-template-columns: 1fr; gap: 28px; } .tr-tl-split .sticky { position: static; } }
.tr-date { display: inline-block; font-weight: 800; font-size: .82rem; letter-spacing: .06em; text-transform: uppercase; color: var(--blue-l); background: rgba(127,163,255,.12); padding: 4px 10px; border-radius: 999px; }
.tr-tl-note { margin-top: 26px; font-size: .88rem; color: rgba(255,255,255,.55); max-width: 420px; line-height: 1.55; }

/* ===== Beneficios y metodología ===== */
.tr-ben { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 8px; }
@media (max-width: 900px) { .tr-ben { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .tr-ben { grid-template-columns: 1fr; } }
.tr-ben > div { border: 1px solid var(--line); border-radius: 24px; padding: 26px; background: #fff; transition: border-color .3s, transform .35s var(--ease), box-shadow .3s; }
.tr-ben > div:hover { border-color: var(--blue); transform: translateY(-3px); box-shadow: 0 20px 44px -30px rgba(10,23,48,.45); }
.tr-ben .num { font-size: .85rem; font-weight: 800; color: var(--blue); letter-spacing: .04em; }
.tr-ben h3 { font-size: 1.15rem; font-weight: 800; letter-spacing: -0.02em; margin: 10px 0 8px; line-height: 1.25; }
.tr-ben p { color: var(--muted); font-size: .94rem; line-height: 1.6; }
.tr-method { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0; margin-top: clamp(40px, 5vw, 64px); border: 1px solid var(--line); border-radius: 26px; overflow: hidden; background: var(--soft); }
@media (max-width: 900px) { .tr-method { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 520px) { .tr-method { grid-template-columns: 1fr; } }
.tr-method > div { padding: 26px; border-right: 1px solid var(--line); border-bottom: 1px solid var(--line); margin: 0 -1px -1px 0; }
.tr-method h3 { font-size: 1.02rem; font-weight: 800; margin-bottom: 6px; }
.tr-method p { color: var(--muted); font-size: .92rem; line-height: 1.55; }

/* ===== Instructor ===== */
.tr-ins { display: grid; grid-template-columns: 220px 1fr; gap: clamp(24px, 4vw, 52px); align-items: center; border: 1px solid var(--line); border-radius: 30px; padding: clamp(22px, 3.6vw, 40px); background: #fff; }
@media (max-width: 720px) { .tr-ins { grid-template-columns: 1fr; text-align: center; justify-items: center; } }
.tr-ins .ph { width: 220px; height: 220px; border-radius: 50%; overflow: hidden; background: var(--soft); box-shadow: 0 0 0 8px var(--blue-50); }
.tr-ins .ph img { width: 100%; height: 100%; object-fit: cover; object-position: center top; }
@media (max-width: 720px) { .tr-ins .ph { width: 160px; height: 160px; } }
.tr-ins h3 { font-size: 1.6rem; font-weight: 800; letter-spacing: -0.025em; }
.tr-ins .role { color: var(--blue); font-weight: 700; margin-top: 2px; }
.tr-ins p { color: var(--muted); margin-top: 14px; max-width: 620px; }
.tr-ins .chips { margin-top: 18px; }
@media (max-width: 720px) { .tr-ins .chips { justify-content: center; } }

/* ===== Inscripción ===== */
.tr-reg { position: relative; overflow: hidden; color: #fff; background: linear-gradient(150deg, var(--ink) 0%, #10264D 45%, #1F4FD8 150%); }
.tr-reg::before { content: ''; position: absolute; width: 640px; height: 640px; right: -220px; top: -260px; border-radius: 50%; background: radial-gradient(circle, rgba(127,163,255,.3), transparent 62%); pointer-events: none; }
.tr-reg .wrap { position: relative; display: grid; grid-template-columns: 1fr 1.05fr; gap: clamp(32px, 6vw, 96px); align-items: start; }
@media (max-width: 900px) { .tr-reg .wrap { grid-template-columns: 1fr; } }
.tr-reg .lead { color: rgba(255,255,255,.75); }
.tr-reg ul.ticks { margin-top: 28px; color: rgba(255,255,255,.9); }
.tr-reg ul.ticks li .ic { color: var(--blue-l); }
.tr-reg .alt { margin-top: 30px; padding: 20px 22px; border-radius: 20px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.14); }
.tr-reg .alt b { display: block; font-size: 1.02rem; }
.tr-reg .alt p { color: rgba(255,255,255,.7); font-size: .92rem; margin-top: 4px; }
.tr-reg .alt a { display: inline-flex; margin-top: 10px; font-weight: 800; color: var(--blue-l); }
.tr-form { background: #fff; color: var(--ink); border-radius: 28px; padding: clamp(24px, 4vw, 42px); box-shadow: 0 40px 90px -40px rgba(0,0,0,.6); }
.tr-form h3 { font-size: 1.35rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 4px; }
.tr-form .hint { color: var(--muted); font-size: .92rem; margin-bottom: 22px; }
.tr-form .row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
@media (max-width: 560px) { .tr-form .row2 { grid-template-columns: 1fr; gap: 0; } }
.tr-form .f { margin-bottom: 16px; }
.tr-form label.l { display: block; font-weight: 700; font-size: .9rem; margin-bottom: 7px; }
.tr-form input[type=text], .tr-form input[type=email], .tr-form input[type=tel], .tr-form select { width: 100%; padding: 14px 15px; border-radius: 14px; border: 1.5px solid var(--line); font: inherit; font-size: 1rem; background: #fff; color: var(--ink); transition: border-color .2s; }
.tr-form input:focus, .tr-form select:focus { outline: none; border-color: var(--blue); }
.tr-form .consent { display: flex; gap: 10px; align-items: flex-start; font-weight: 500; font-size: .88rem; color: var(--muted); margin: 4px 0 18px; cursor: pointer; }
.tr-form .consent input { width: 18px; height: 18px; margin-top: 2px; accent-color: var(--blue); flex-shrink: 0; }
.tr-form .err { color: var(--bad); font-size: .9rem; margin-top: 12px; display: none; }
.tr-ok { display: none; text-align: center; padding: 26px 6px; }
.tr-ok .icon-tile { margin: 0 auto 18px; background: rgba(14,138,95,.1); color: var(--ok); }
.tr-ok h3 { font-size: 1.5rem; }
.tr-ok p { color: var(--muted); margin-top: 8px; }
.tr-ok .b { margin-top: 20px; }

/* ===== Barra móvil ===== */
.tr-bar { display: none; }
@media (max-width: 1060px) {
  .tr-bar { position: fixed; left: 0; right: 0; bottom: 0; z-index: 80; display: flex; align-items: center; gap: 12px; padding: 12px 88px 12px 16px; background: rgba(255,255,255,.96); backdrop-filter: blur(10px); border-top: 1px solid var(--line); transform: translateY(110%); transition: transform .35s var(--ease); }
  .tr-bar.show { transform: none; }
  .tr-bar .t { flex: 1; min-width: 0; line-height: 1.25; }
  .tr-bar .t b { display: block; font-size: .92rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .tr-bar .t span { font-size: .8rem; color: var(--muted); }
  .tr-bar .b { padding: 12px 18px; flex-shrink: 0; }
  body { padding-bottom: 0; }
}
@endsection

@section('content')
<section class="tr-hero">
  <div class="wrap">
    <nav class="tr-crumb" aria-label="Ruta"><a href="{{ route('capacitaciones') }}">Capacitaciones</a><span>/</span><span>{{ $t['short'] }}</span></nav>
    <div class="tr-hero-grid">
      <div>
        <span class="tr-badge rv"><i></i>{{ $t['badge'] }} · Para oficiales de cumplimiento</span>
        <h1 class="rv">{{ $t['headline'] }}</h1>
        <p class="lead rv">{{ $t['lead'] }}</p>
        <div class="tr-acts rv">
          <a href="#inscripcion" class="b b-primary">Reservar mi cupo @include('site.partials.icon', ['name' => 'arrow'])</a>
          <a href="#programa" class="b b-ghost-dark">Ver el programa</a>
        </div>
      </div>

      <div class="rv" style="--d:.08s">
        {{-- Video de presentación: se activa al completar 'video.url' en App\Support\TrainingCatalog. --}}
        <div class="tr-video {{ $embed ? '' : 'empty' }} {{ ! empty($t['video']['poster']) ? 'has-poster' : '' }}" id="trVideo" @if(! empty($t['video']['poster'])) style="background-image:url('{{ asset(ltrim($t['video']['poster'], '/')) }}')" @endif @if($embed) data-type="{{ $embed['type'] }}" data-src="{{ $embed['src'] }}" @endif>
          @if($embed)
            <button type="button" class="tr-play" id="trPlay" aria-label="Reproducir: {{ $t['video']['title'] ?? 'Presentación del curso' }}">
              <span class="pb"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 4.5v15l13-7.5z"/></svg></span>
              <span class="pt">{{ $t['video']['title'] ?? 'Presentación del curso' }}</span>
            </button>
          @else
            <span class="tr-soon">Próximamente</span>
            <div class="tr-play" role="img" aria-label="Espacio reservado para el video de presentación del curso">
              <span class="pb"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 4.5v15l13-7.5z"/></svg></span>
              <span class="pt">Video de presentación del curso</span>
              <span class="ps">El instructor presentará el programa y sus beneficios</span>
            </div>
          @endif
        </div>
        <div class="tr-video-cap">@include('site.partials.icon', ['name' => 'clock']) <span>{{ $embed ? 'Conozca el curso en un minuto.' : 'Aquí se publicará el video de presentación.' }}</span></div>
      </div>
    </div>
    <ul class="tr-facts rv">
          @foreach($t['facts'] as $f)
            <li>@include('site.partials.icon', ['name' => $f['icon']])<div><span>{{ $f['k'] }}</span><b>{{ $f['v'] }}</b></div></li>
          @endforeach
    </ul>
  </div>
</section>

<section class="tr-stats">
  <div class="wrap">
    @foreach($t['stats'] as $s)<div class="s rv" style="--d:{{ $loop->index * .05 }}s"><b>{{ $s['n'] }}</b><span>{{ $s['l'] }}</span></div>@endforeach
  </div>
</section>

<section class="tr-main">
  <div class="wrap tr-grid">
    <div>
      <div class="tr-blk">
        <div class="kicker rv">Para quién es</div>
        <h2 class="rv">Hecho para quien firma, redacta o aprueba el IAOC.</h2>
        <div class="tr-aud">
          @foreach($t['audience'] as $a)
            <div class="rv" style="--d:{{ $loop->index * .05 }}s"><span class="icon-tile">@include('site.partials.icon', ['name' => $a['icon']])</span><h3>{{ $a['t'] }}</h3><p>{{ $a['p'] }}</p></div>
          @endforeach
        </div>
      </div>

      <div class="tr-blk">
        <div class="kicker rv">El problema</div>
        <h2 class="rv">El informe se complica por lo que pasó durante el año, no por enero.</h2>
        <ul class="tr-pains">
          @foreach($t['pains'] as $p)<li class="rv" style="--d:{{ $loop->index * .04 }}s">{{ $p }}</li>@endforeach
        </ul>
      </div>

      <div class="tr-blk">
        <div class="kicker rv">Qué aprenderá</div>
        <h2 class="rv">Al terminar, usted podrá:</h2>
        <ul class="tr-learn">
          @foreach($t['learn'] as $l)<li class="rv" style="--d:{{ ($loop->index % 2) * .05 }}s">@include('site.partials.icon', ['name' => 'check']) <span>{{ $l }}</span></li>@endforeach
        </ul>
      </div>

      <div class="tr-blk">
        <div class="kicker rv">Marco normativo</div>
        <h2 class="rv">{{ $t['norm']['title'] }}</h2>
        <div class="tr-norm rv">
          <p class="l">{{ $t['norm']['lead'] }}</p>
          <div class="tr-ncards">
            @foreach($t['norm']['cards'] as $c)<div><span class="k">{{ $c['k'] }}</span><b>{{ $c['v'] }}</b><p>{{ $c['p'] }}</p></div>@endforeach
          </div>
          <div class="tr-src">
            @foreach($t['norm']['sources'] as $s)<a href="{{ $s['url'] }}" target="_blank" rel="noopener">{{ $s['label'] }} <span>Norma original ↗</span></a>@endforeach
          </div>
          <p class="tr-nnote">{{ $t['norm']['note'] }}</p>
        </div>
      </div>

      <div class="tr-blk" id="programa">
        <div class="kicker rv">Programa</div>
        <h2 class="rv">{{ count($t['modules']) }} módulos, de la norma al informe enviado.</h2>
        <p class="sub rv">Cada módulo termina con una práctica que usted se lleva lista para su empresa.</p>
        <div class="tr-mods">
          @foreach($t['modules'] as $m)
            <details class="tr-mod rv" @if($loop->first) open @endif>
              <summary>
                <span class="n">{{ $loop->iteration }}</span>
                <h3>{{ $m['t'] }}</h3>
                <span class="d">{{ $m['min'] }} min</span>
                <svg class="cv" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
              </summary>
              <div class="bd">
                <p>{{ $m['p'] }}</p>
                <div class="act">@include('site.partials.icon', ['name' => 'doc']) <span><b>Práctica:</b> {{ $m['act'] }}</span></div>
              </div>
            </details>
          @endforeach
        </div>
        <div class="tr-total rv"><b>Total del programa</b><span>{{ $hoursLabel }} lectivas · {{ count($t['modules']) }} módulos</span></div>
      </div>

      <div class="tr-blk">
        <div class="kicker rv">Qué se lleva</div>
        <h2 class="rv">Material listo para usar el lunes siguiente.</h2>
        <div class="tr-del">
          @foreach($t['deliverables'] as $d)
            <div class="rv" style="--d:{{ ($loop->index % 2) * .05 }}s"><span class="icon-tile">@include('site.partials.icon', ['name' => $d['icon']])</span><div><h3>{{ $d['t'] }}</h3><p>{{ $d['p'] }}</p></div></div>
          @endforeach
        </div>
      </div>
    </div>

    <aside class="tr-aside" aria-label="Inscripción">
      <div class="tr-card rv">
        <div class="top">
          <small>Próxima edición</small>
          <b>{{ $pending($t['next_date']) }}</b>
          <p>{{ $t['price_note'] }}</p>
        </div>
        <div class="bd">
          <dl>
            <div><dt>Inversión</dt><dd class="{{ filled($t['price']) ? '' : 'tbc' }}">{{ $pending($t['price']) }}</dd></div>
            <div><dt>Duración</dt><dd>{{ $hoursLabel }} lectivas</dd></div>
            <div><dt>Modalidad</dt><dd>En vivo online</dd></div>
            <div><dt>Certificado</dt><dd>Incluido</dd></div>
          </dl>
          <div class="seats">@include('site.partials.icon', ['name' => 'alert']) <span>{{ $t['seats'] }}</span></div>
          <a href="#inscripcion" class="b b-primary b-block">Reservar mi cupo @include('site.partials.icon', ['name' => 'arrow'])</a>
          <a href="{{ $wa }}" target="_blank" rel="noopener" class="wa-l">Consultar por WhatsApp</a>
          <ul class="inc">
            <li>@include('site.partials.icon', ['name' => 'check']) <span>Plantillas y checklists editables</span></li>
            <li>@include('site.partials.icon', ['name' => 'check']) <span>Grabación de las sesiones</span></li>
            <li>@include('site.partials.icon', ['name' => 'check']) <span>Certificado verificable</span></li>
          </ul>
        </div>
      </div>
    </aside>
  </div>
</section>

<section class="sec sec-dark on-dark">
  <div class="wrap tr-tl-split">
    <div class="sticky">
      <div class="kicker rv">Calendario del IAOC</div>
      <h2 class="h2 rv">El plazo corre desde el 1 de enero.</h2>
      <p class="lead rv" style="margin-top:18px">Con la fecha de cierre del año y los plazos de la norma, el informe se prepara en semanas, no en días.</p>
      <p class="tr-tl-note rv">Fechas calculadas con el plazo de aprobación (30 días desde el cierre del periodo) y el de envío (15 de febrero), según el texto original de las normas citadas arriba.</p>
    </div>
    <div class="tl">
      <div class="tl-fill"></div>
      @foreach($t['timeline'] as $s)
        <div class="tl-step rv" style="--d:{{ $loop->index * .05 }}s"><div class="tl-dot"></div><div><span class="tr-date">{{ $s['d'] }}</span><h3>{{ $s['t'] }}</h3><p>{{ $s['p'] }}</p></div></div>
      @endforeach
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Beneficios</div><h2 class="h2 rv">Por qué esta capacitación.</h2></div></div>
    <div class="tr-ben">
      @foreach($t['benefits'] as $b)
        <div class="rv" style="--d:{{ ($loop->index % 3) * .05 }}s"><span class="num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><h3>{{ $b['t'] }}</h3><p>{{ $b['p'] }}</p></div>
      @endforeach
    </div>
    <div class="tr-method rv">
      @foreach($t['method'] as $m)<div><h3>{{ $m['t'] }}</h3><p>{{ $m['p'] }}</p></div>@endforeach
    </div>
  </div>
</section>

<section class="sec" style="padding-top:0">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Instructor</div><h2 class="h2 rv">Quién dicta el programa.</h2></div></div>
    <div class="tr-ins rv">
      <div class="ph"><img src="{{ asset($t['instructor']['photo']) }}" alt="{{ $t['instructor']['name'] }}" loading="lazy"></div>
      <div>
        <h3>{{ $t['instructor']['name'] }}</h3>
        <div class="role">{{ $t['instructor']['role'] }}</div>
        <p>{{ $t['instructor']['bio'] }}</p>
        <div class="chips">@foreach($t['instructor']['chips'] as $c)<span class="chip">{{ $c }}</span>@endforeach</div>
      </div>
    </div>
  </div>
</section>

<section class="sec" style="padding-top:0">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Preguntas frecuentes</div><h2 class="h2 rv">Antes de inscribirse.</h2></div></div>
    <div class="faq rv">
      @foreach($t['faq'] as $f)
        <details><summary>{{ $f['q'] }}<span class="pm">@include('site.partials.icon', ['name' => 'plus'])</span></summary><p class="muted" style="padding:0 0 26px;max-width:760px">{{ $f['a'] }}</p></details>
      @endforeach
    </div>
  </div>
</section>

<section class="sec tr-reg" id="inscripcion">
  <div class="wrap">
    <div>
      <div class="kicker rv" style="color:var(--blue-l)">Inscripción</div>
      <h2 class="h2 rv">Reserve su cupo.</h2>
      <p class="lead rv" style="margin-top:18px">Déjenos sus datos y le escribimos con fechas, costo y forma de pago. Reservar no lo compromete.</p>
      <ul class="ticks rv">
        <li>@include('site.partials.icon', ['name' => 'check']) <span>Respuesta en un día hábil</span></li>
        <li>@include('site.partials.icon', ['name' => 'check']) <span>Descuento para equipos de tres o más personas</span></li>
        <li>@include('site.partials.icon', ['name' => 'check']) <span>Sus datos se tratan con reserva</span></li>
      </ul>
      <div class="alt rv">
        <b>¿Prefiere una versión in-company?</b>
        <p>La adaptamos a su empresa, trabajamos con su propio borrador de IAOC y capacitamos a su directorio.</p>
        <a href="{{ $wa }}" target="_blank" rel="noopener">Coordinar por WhatsApp @include('site.partials.icon', ['name' => 'arrow'])</a>
      </div>
    </div>

    <div class="tr-form rv">
      <form id="trForm" data-no-loader novalidate>
        <h3>Solicitud de inscripción</h3>
        <p class="hint">{{ $t['short'] }} · {{ $t['kicker'] }}</p>
        <div class="row2">
          <div class="f"><label class="l" for="trNombre">Nombre completo</label><input type="text" id="trNombre" name="nombre" autocomplete="name" required></div>
          <div class="f"><label class="l" for="trTel">Teléfono / WhatsApp</label><input type="tel" id="trTel" name="telefono" autocomplete="tel" placeholder="+51" required></div>
        </div>
        <div class="f"><label class="l" for="trEmail">Correo</label><input type="email" id="trEmail" name="email" autocomplete="email" required></div>
        <div class="row2">
          <div class="f"><label class="l" for="trOrg">Empresa u organización</label><input type="text" id="trOrg" name="organizacion" autocomplete="organization"></div>
          <div class="f"><label class="l" for="trCargo">Su rol</label>
            <select id="trCargo" name="cargo">
              <option>Oficial de cumplimiento</option><option>Oficial de cumplimiento suplente</option><option>Directorio / gerencia</option><option>Abogado o consultor</option><option>Otro</option>
            </select></div>
        </div>
        <div class="f"><label class="l" for="trMod">¿Qué le interesa?</label>
          <select id="trMod" name="modalidad">
            <option>Curso abierto (individual)</option><option>Equipo de mi empresa (3 o más)</option><option>Versión in-company</option>
          </select></div>
        <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px">
        <label class="consent"><input type="checkbox" name="consent" value="1"> <span>Autorizo a Romani Compliance a contactarme sobre esta capacitación y a tratar mis datos con ese fin.</span></label>
        <button type="submit" class="b b-primary b-block" id="trBtn"><span>Reservar mi cupo</span> @include('site.partials.icon', ['name' => 'arrow'])</button>
        <p class="err" id="trErr"></p>
      </form>
      <div class="tr-ok" id="trOk">
        <div class="icon-tile">@include('site.partials.icon', ['name' => 'check'])</div>
        <h3>¡Recibimos su solicitud!</h3>
        <p>Le escribiremos a la brevedad con fechas, costo y datos de pago.</p>
        <a href="{{ $wa }}" target="_blank" rel="noopener" class="b b-primary">Escribir por WhatsApp @include('site.partials.icon', ['name' => 'chat'])</a>
      </div>
    </div>
  </div>
</section>

<div class="tr-bar" id="trBar">
  <div class="t"><b>{{ $t['short'] }}</b><span>{{ filled($t['next_date']) ? $t['next_date'] : 'Cupos limitados' }}</span></div>
  <a href="#inscripcion" class="b b-primary">Reservar</a>
</div>
@endsection

@section('scripts')
<script>
(function () {
  // Video de presentación: se carga solo al pulsar «reproducir»
  const vid = document.getElementById('trVideo'), play = document.getElementById('trPlay');
  if (vid && play && vid.dataset.src) {
    play.addEventListener('click', () => {
      const el = vid.dataset.type === 'file' ? document.createElement('video') : document.createElement('iframe');
      if (vid.dataset.type === 'file') { el.src = vid.dataset.src; el.controls = true; el.autoplay = true; el.playsInline = true; }
      else { el.src = vid.dataset.src; el.allow = 'autoplay; fullscreen; picture-in-picture'; el.allowFullscreen = true; el.title = 'Video de presentación del curso'; }
      play.remove(); vid.appendChild(el);
    });
  }

  // Barra inferior en móvil: aparece al pasar el hero y se oculta en el formulario
  const bar = document.getElementById('trBar'), hero = document.querySelector('.tr-hero'), reg = document.getElementById('inscripcion');
  if (bar && 'IntersectionObserver' in window) {
    let heroOut = false, regIn = false;
    const upd = () => bar.classList.toggle('show', heroOut && !regIn);
    new IntersectionObserver((es) => { heroOut = !es[0].isIntersecting; upd(); }).observe(hero);
    new IntersectionObserver((es) => { regIn = es[0].isIntersecting; upd(); }, { threshold: 0.1 }).observe(reg);
  }

  // Inscripción
  const form = document.getElementById('trForm');
  const T = @json($t['name']), SLUG = @json($slug);
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const d = Object.fromEntries(new FormData(form));
    const err = document.getElementById('trErr');
    const fail = (m) => { err.textContent = m; err.style.display = 'block'; };
    if (!d.nombre || d.nombre.trim().length < 3) return fail('Indique su nombre completo.');
    if (!d.email || !/^\S+@\S+\.\S+$/.test(d.email)) return fail('Indique un correo válido.');
    if (!d.telefono || d.telefono.replace(/\D/g, '').length < 7) return fail('Indique un teléfono o WhatsApp para coordinar.');
    if (!d.consent) return fail('Marque la autorización para que podamos contactarle.');
    err.style.display = 'none';
    const btn = document.getElementById('trBtn'); btn.disabled = true; btn.querySelector('span').textContent = 'Enviando…';
    const lines = ['Capacitación: ' + T, 'Rol: ' + d.cargo, 'Interés: ' + d.modalidad, 'Empresa: ' + (d.organizacion || 'No indicada')];
    try {
      const saved = await fetch(@json($leadUrl), { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
        body: JSON.stringify({ name: d.nombre, organization: d.organizacion || null, email: d.email, phone: d.telefono, consent: 1, website: d.website || '', summary: lines.join('\n'), data: { lines, title: 'Solicitud de inscripción · ' + T } }) });
      if (!saved.ok) throw new Error();
      // Aviso por correo al equipo (si falla, la solicitud ya quedó guardada en el panel)
      fetch('https://formsubmit.co/ajax/omaroliden1@gmail.com', { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, body: JSON.stringify({ name: d.nombre, email: d.email, message: 'Inscripción desde romanicompliance.com\n\nNombre: ' + d.nombre + '\nTeléfono: ' + d.telefono + '\nCorreo: ' + d.email + '\n' + lines.join('\n'), _cc: 'dromani@pucp.pe', _subject: 'Inscripción · ' + T }) }).catch(() => {});
      form.style.display = 'none'; document.getElementById('trOk').style.display = 'block';
    } catch (_) {
      btn.disabled = false; btn.querySelector('span').textContent = 'Reservar mi cupo';
      err.innerHTML = 'No se pudo enviar. Escríbanos por <a href="' + @json($wa) + '" target="_blank" rel="noopener" style="text-decoration:underline">WhatsApp</a>.'; err.style.display = 'block';
    }
  });
})();
</script>
@endsection
