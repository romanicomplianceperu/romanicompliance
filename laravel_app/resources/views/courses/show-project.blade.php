@extends('layouts.app')

@section('title', $course->title.' — Romani Compliance')
@php
  $company = $course->project->company;

  $rdGreetingWord = 'Bienvenido';
  if (auth()->check()) {
      $rdFirstName = mb_strtolower(trim(explode(' ', trim(auth()->user()->name))[0] ?? ''));
      $rdFemaleNames = ['rosario', 'laura', 'maria', 'ana', 'carmen', 'lucia', 'sofia', 'valentina', 'camila',
          'daniela', 'gabriela', 'alejandra', 'andrea', 'patricia', 'claudia', 'monica', 'sandra',
          'karen', 'diana', 'paola', 'fiorella', 'milagros', 'jazmin', 'katherine', 'melissa', 'carla',
          'natalia', 'veronica', 'silvia', 'teresa', 'rosa', 'elena', 'julia', 'kyra'];
      $rdMaleEndingA = ['joshua', 'noa', 'luca', 'matias', 'elias', 'jonas', 'tobias'];
      if (in_array($rdFirstName, $rdFemaleNames, true) || (str_ends_with($rdFirstName, 'a') && ! in_array($rdFirstName, $rdMaleEndingA, true))) {
          $rdGreetingWord = 'Bienvenida';
      }
  }
@endphp

@section('styles')
@font-face { font-display: swap; }
:root { --rd-accent: #8B7340; }

#rd-loader { position: fixed; inset: 0; z-index: 999; background: var(--ink); display: flex; align-items: center; justify-content: center; transition: opacity 0.5s ease, visibility 0.5s ease; }
#rd-loader.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
#rd-loader .rd-loader-mark { width: 46px; height: 46px; border: 3px solid rgba(184,154,86,0.25); border-top-color: var(--gold-light); border-radius: 50%; animation: rd-spin 0.9s linear infinite; }
@keyframes rd-spin { to { transform: rotate(360deg); } }

.rd-fade-up { animation: rd-fadeUp 0.7s cubic-bezier(0.22,1,0.36,1) both; }
@keyframes rd-fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
.rd-delay-1 { animation-delay: 0.08s; } .rd-delay-2 { animation-delay: 0.16s; } .rd-delay-3 { animation-delay: 0.24s; } .rd-delay-4 { animation-delay: 0.32s; }

.rd-hero { position: relative; background: radial-gradient(120% 100% at 85% 0%, #16283F 0%, #0B1829 55%), var(--ink); padding: 4.5rem 0 4rem; overflow: hidden; }
.rd-hero::after { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(184,154,86,0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(184,154,86,0.06) 1px, transparent 1px); background-size: 42px 42px; mask-image: radial-gradient(ellipse at 75% 20%, black 0%, transparent 65%); pointer-events: none; }
.rd-hero-grid { position: relative; display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 2.5rem; align-items: center; }
.rd-badge-company { display: inline-flex; align-items: center; gap: 8px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--gold-light); background: rgba(184,154,86,0.1); border: 1px solid rgba(184,154,86,0.3); padding: 6px 14px; border-radius: 30px; margin-bottom: 1.2rem; }
.rd-badge-company .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--gold-light); }
.rd-hero h1 { font-family: 'Inter', sans-serif; font-weight: 800; font-size: clamp(1.9rem, 4vw, 2.9rem); line-height: 1.15; color: var(--white); letter-spacing: -0.02em; margin-bottom: 1rem; }
.rd-hero p.rd-sub { font-size: 0.98rem; color: rgba(255,255,255,0.6); line-height: 1.75; max-width: 520px; margin-bottom: 1.8rem; }
.rd-meta-row { display: flex; gap: 1.8rem; flex-wrap: wrap; margin-bottom: 2.2rem; }
.rd-meta-item .k { font-size: 0.65rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px; }
.rd-meta-item .v { font-size: 0.95rem; color: var(--white); font-weight: 600; }
.rd-cta-row { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
.rd-btn-primary { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--ink); font-weight: 700; font-size: 0.92rem; padding: 15px 32px; border-radius: 8px; border: none; cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease; box-shadow: 0 8px 24px rgba(184,154,86,0.25); }
.rd-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(184,154,86,0.35); }
.rd-progress-chip { font-size: 0.78rem; color: rgba(255,255,255,0.55); }

.rd-illustration { position: relative; }
.rd-illustration svg { width: 100%; height: auto; filter: drop-shadow(0 20px 50px rgba(0,0,0,0.35)); }

@media (max-width: 900px) {
  .rd-hero-grid { grid-template-columns: 1fr; }
  .rd-illustration { max-width: 320px; margin: 0 auto; order: -1; }
}

.rd-section { padding: 4rem 0; }
.rd-section-alt { background: var(--ivory-dim); }
.rd-eyebrow { font-size: 0.7rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.6rem; }
.rd-section h2 { font-family: 'Inter', sans-serif; font-weight: 800; font-size: clamp(1.4rem, 3vw, 1.9rem); letter-spacing: -0.01em; margin-bottom: 0.6rem; }

.rd-modules { display: grid; gap: 1rem; margin-top: 2rem; }
.rd-module-card { display: grid; grid-template-columns: auto 1fr; gap: 1.2rem; background: var(--white); border: 1px solid var(--line); border-radius: 12px; padding: 1.6rem 1.8rem; transition: border-color 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease; }
.rd-module-card:hover { border-color: var(--gold); transform: translateY(-3px); box-shadow: 0 12px 30px rgba(11,24,41,0.08); }
.rd-module-num { width: 42px; height: 42px; border-radius: 10px; background: var(--gold-pale); color: var(--gold); font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rd-module-card h3 { font-size: 1.05rem; margin-bottom: 0.5rem; }
.rd-lesson-chip { display: inline-block; font-size: 0.78rem; color: var(--slate); padding: 3px 0; }

.rd-instructor-card { display: flex; gap: 1.6rem; align-items: center; background: var(--white); border: 1px solid var(--line); border-radius: 14px; padding: 1.8rem; box-shadow: var(--shadow-s); }
.rd-instructor-card img { width: 96px; height: 96px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold-pale); flex-shrink: 0; }
.rd-instructor-card h3 { font-size: 1.1rem; margin-bottom: 2px; }
.rd-instructor-role { font-size: 0.8rem; color: var(--gold); font-weight: 600; margin-bottom: 8px; }
.rd-instructor-bio { font-size: 0.85rem; color: var(--slate); line-height: 1.6; }
@media (max-width: 560px) { .rd-instructor-card { flex-direction: column; text-align: center; } }

.rd-cta-band { background: linear-gradient(135deg, var(--ink), var(--ink-90)); border-radius: 16px; padding: 3rem 2rem; text-align: center; color: var(--white); }
.rd-cta-band p { color: rgba(255,255,255,0.6); font-size: 0.9rem; margin-bottom: 1.4rem; max-width: 480px; margin-left: auto; margin-right: auto; }

.rd-welcome-modal .rd-welcome-img { width: 100%; border-radius: 10px; margin-bottom: 1.2rem; overflow: hidden; }
.rd-welcome-modal .rd-welcome-img svg { width: 100%; display: block; }
.rd-welcome-modal ul { list-style: none; margin: 1rem 0 1.4rem; }
.rd-welcome-modal ul li { display: flex; align-items: start; gap: 8px; font-size: 0.85rem; color: var(--slate); margin-bottom: 8px; }
.rd-welcome-modal ul li svg { width: 15px; height: 15px; flex-shrink: 0; color: #1F7A4D; margin-top: 2px; }
.rd-step { display: none; }
.rd-step.active { display: block; }
.rd-form-group { margin-bottom: 1rem; }
.rd-form-group label { display: block; font-size: 0.75rem; font-weight: 600; color: var(--slate); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
.rd-form-group input { width: 100%; padding: 12px 14px; border: 1px solid var(--line); border-radius: 6px; font-size: 0.9rem; }
.rd-form-hint { font-size: 0.76rem; color: var(--slate-light); margin-top: 4px; }

#rdOnboard { position: fixed; inset: 0; z-index: 500; background: radial-gradient(120% 100% at 50% 0%, #16283F 0%, #0B1829 60%); display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.6s ease, visibility 0.6s ease; padding: 1.5rem; overflow: hidden; }
#rdOnboard.active { opacity: 1; visibility: visible; }
#rdOnboard.leaving { opacity: 0; }
.rd-ob-logo { position: absolute; top: 1.6rem; left: 50%; transform: translateX(-50%); z-index: 2; }
.rd-ob-logo img { height: 22px; filter: brightness(0) invert(1); opacity: 0.55; }
.rd-ob-skip { position: absolute; top: 1.7rem; right: 1.8rem; z-index: 3; font-size: 0.72rem; color: rgba(255,255,255,0.32); background: none; border: none; cursor: pointer; letter-spacing: 0.02em; }
.rd-ob-skip:hover { color: rgba(255,255,255,0.6); }

/* Nombre: hero centrado -> se desliza arriba y permanece fijo, a la vez
   que aparecen las tarjetas (movimiento sincronizado, no secuencial) */
.rd-ob-name { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) scale(1); text-align: center; transition: top 1.1s cubic-bezier(0.16,0.84,0.3,1), transform 1.1s cubic-bezier(0.16,0.84,0.3,1); z-index: 2; }
.rd-ob-name.docked { top: 2.6rem; transform: translate(-50%, 0) scale(0.4); }
.rd-ob-name h1 { font-family: var(--serif); font-weight: 600; font-size: clamp(2rem, 6vw, 3.4rem); color: var(--white); letter-spacing: 0.01em; white-space: nowrap; min-height: 1.2em; }
.rd-ob-name.docked .rd-ob-subtext { opacity: 0 !important; }
.rd-ob-subtext { margin-top: 1rem; font-size: 0.92rem; color: rgba(255,255,255,0.45); opacity: 0; transition: opacity 0.7s ease; min-height: 1.4em; }
.rd-ob-subtext.show { opacity: 1; }
.rd-ob-cursor { display: inline-block; width: 2px; background: var(--gold-light); margin-left: 2px; animation: rdObBlink 0.9s steps(1) infinite; }
@keyframes rdObBlink { 50% { opacity: 0; } }

/* Barra única de progreso de toda la bienvenida */
.rd-ob-master-track { position: absolute; bottom: 2.2rem; left: 50%; transform: translateX(-50%); width: min(280px, 70%); height: 2px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden; z-index: 2; }
.rd-ob-master-fill { height: 100%; width: 0%; background: var(--gold-light); }

/* Carrusel automático — tarjetas claras, tipo la referencia enviada */
.rd-ob-carousel { position: relative; width: 100%; max-width: 560px; min-height: 340px; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.9s ease; margin-top: 5rem; }
.rd-ob-carousel.show { opacity: 1; visibility: visible; }
.rd-ob-track { position: relative; width: 100%; flex: 1; min-height: 300px; }
.rd-ob-card { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 2.4rem 2.2rem; opacity: 0; visibility: hidden; filter: blur(6px); transition: opacity 0.6s ease, filter 0.6s ease; background: rgba(250,250,246,0.88); backdrop-filter: blur(22px); -webkit-backdrop-filter: blur(22px); border: 1px solid rgba(255,255,255,0.6); border-radius: 18px; box-shadow: 0 24px 60px rgba(0,0,0,0.3); overflow-y: auto; }
.rd-ob-card.active { opacity: 1; visibility: visible; filter: blur(0); }
.rd-ob-card.leaving { opacity: 0; filter: blur(6px); }
.rd-ob-eyebrow { font-size: 0.66rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: 0.14em; margin-bottom: 0.9rem; }
.rd-ob-icon { width: 52px; height: 52px; border-radius: 14px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem; }
.rd-ob-icon svg { width: 26px; height: 26px; }
.rd-ob-card h2 { font-family: var(--serif); font-weight: 600; font-size: clamp(1.3rem, 3.4vw, 1.7rem); color: var(--ink); margin-bottom: 0.7rem; letter-spacing: 0; min-height: 1.3em; }
.rd-ob-card p { font-size: 0.88rem; color: var(--slate); line-height: 1.65; max-width: 400px; margin: 0 auto; }
.rd-ob-final-btn { font-size: 1rem !important; padding: 18px 40px !important; }

.rd-ob-loading { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); display: flex; flex-direction: column; align-items: center; gap: 14px; opacity: 1; transition: opacity 0.5s ease; z-index: 2; }
.rd-ob-loading.hide { opacity: 0; visibility: hidden; pointer-events: none; }
.rd-ob-spinner { width: 26px; height: 26px; border: 2.5px solid rgba(184,154,86,0.25); border-top-color: var(--gold-light); border-radius: 50%; animation: rd-spin 0.8s linear infinite; }
.rd-ob-loading span { font-size: 0.85rem; color: rgba(255,255,255,0.55); letter-spacing: 0.02em; }
.rd-ob-tags { display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; margin-top: 1rem; }
.rd-ob-tags span { font-size: 0.7rem; font-weight: 700; color: var(--gold); background: var(--gold-pale); border: 1px solid rgba(139,115,64,0.25); padding: 5px 11px; border-radius: 20px; letter-spacing: 0.04em; }
.rd-ob-meta-row { display: flex; gap: 1.6rem; justify-content: center; margin-top: 1.2rem; }
.rd-ob-meta-row div { font-size: 0.78rem; color: var(--slate); }
.rd-ob-meta-row strong { display: block; color: var(--ink); font-size: 1rem; font-family: var(--serif); }
.rd-ob-instructor-photo { width: 84px; height: 84px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold-pale); margin: 0 auto 1rem; display: block; }
.rd-ob-modules, .rd-ob-route { text-align: left; max-width: 360px; margin: 1rem auto 0; }
.rd-ob-modules div { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid var(--line); font-size: 0.84rem; color: var(--ink); }
.rd-ob-modules span.n { width: 22px; height: 22px; border-radius: 6px; background: var(--gold-pale); color: var(--gold); font-size: 0.68rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rd-ob-route { display: flex; flex-direction: column; align-items: center; gap: 2px; max-width: 320px; }
.rd-ob-route .step { font-size: 0.82rem; font-weight: 600; color: var(--ink); }
.rd-ob-route .step .n { color: var(--gold); font-weight: 700; font-size: 0.7rem; letter-spacing: 0.06em; display: block; }
.rd-ob-route .step.cert { color: var(--gold); }
.rd-ob-route .down { color: var(--slate-light); font-size: 0.75rem; }
.rd-ob-benefits { text-align: left; max-width: 380px; margin: 1rem auto 0; list-style: none; }
.rd-ob-benefits li { display: flex; align-items: start; gap: 9px; font-size: 0.85rem; color: var(--ink); margin-bottom: 8px; line-height: 1.5; }
.rd-ob-benefits li .n { font-family: var(--serif); color: var(--gold); font-weight: 700; font-size: 0.9rem; flex-shrink: 0; }
.rd-ob-cert-badge { display: flex; align-items: center; gap: 12px; background: var(--gold-pale); border: 1px solid rgba(139,115,64,0.25); border-radius: 12px; padding: 0.9rem 1.3rem; margin-top: 1rem; }
.rd-ob-cert-badge svg { width: 30px; height: 30px; color: var(--gold); flex-shrink: 0; }
.rd-ob-cert-badge div { text-align: left; font-size: 0.72rem; font-weight: 700; color: var(--gold); letter-spacing: 0.04em; line-height: 1.5; }

.rd-ob-cta { margin-top: 1.6rem; }

/* Confeti discreto */
.rd-ob-confetti { position: fixed; inset: 0; pointer-events: none; z-index: 600; overflow: hidden; }
.rd-ob-confetti span { position: absolute; top: -10px; width: 6px; height: 10px; opacity: 0.9; animation: rdConfettiFall 1.3s ease-in forwards; }
@keyframes rdConfettiFall { to { transform: translateY(105vh) rotate(200deg); opacity: 0; } }
@endsection

@section('content')
<div id="rd-loader"><div class="rd-loader-mark"></div></div>

<section class="rd-hero">
  <div class="wrap rd-hero-grid">
    <div class="rd-fade-up">
      <div class="rd-badge-company"><span class="dot"></span>Capacitación empresarial &middot; {{ $company->name }}</div>
      <h1>{{ $course->title }}</h1>
      <p class="rd-sub">{{ $course->description }}</p>
      <div class="rd-meta-row">
        @if($course->project->modality)
          <div class="rd-meta-item"><div class="k">Modalidad</div><div class="v">{{ $course->project->modality }}</div></div>
        @endif
        @if($course->duration_minutes)
          <div class="rd-meta-item"><div class="k">Duración</div><div class="v">{{ $course->lectiveHours() }} {{ $course->lectiveHours() === 1 ? 'hora' : 'horas' }}</div></div>
        @endif
        <div class="rd-meta-item"><div class="k">Módulos</div><div class="v">{{ $course->modules->count() }}</div></div>
        <div class="rd-meta-item"><div class="k">Certificación</div><div class="v">Gratuita, verificable por QR</div></div>
      </div>
      <div class="rd-cta-row">
        @if($enrollment)
          @php $next = $course->nextLessonFor(auth()->user()); @endphp
          <a href="{{ $next ? route('lessons.show', $next) : route('courses.show', $course) }}" class="rd-btn-primary">
            {{ $enrollment->progress_percent > 0 ? 'Continuar curso' : 'Comenzar curso' }}
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </a>
          <span class="rd-progress-chip">{{ $enrollment->progress_percent }}% completado</span>
        @else
          <button type="button" class="rd-btn-primary" onclick="rdOpenWelcome()">
            Inscribirme
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </button>
        @endif
      </div>
    </div>

    <div class="rd-illustration rd-fade-up rd-delay-2">
      <svg viewBox="0 0 480 460" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <radialGradient id="rdGlow" cx="50%" cy="35%" r="65%">
            <stop offset="0%" stop-color="#8B7340" stop-opacity="0.35"/>
            <stop offset="100%" stop-color="#8B7340" stop-opacity="0"/>
          </radialGradient>
          <linearGradient id="rdLine" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#B89A56"/>
            <stop offset="100%" stop-color="#8B7340" stop-opacity="0.2"/>
          </linearGradient>
        </defs>
        <circle cx="240" cy="210" r="190" fill="url(#rdGlow)"/>
        <circle cx="240" cy="210" r="150" fill="none" stroke="#1C2E45" stroke-width="1.2" stroke-dasharray="3 7"/>
        <g stroke="url(#rdLine)" stroke-width="1.6" fill="none" opacity="0.85">
          <line x1="240" y1="210" x2="120" y2="120"/>
          <line x1="240" y1="210" x2="360" y2="120"/>
          <line x1="240" y1="210" x2="110" y2="280"/>
          <line x1="240" y1="210" x2="370" y2="290"/>
          <line x1="240" y1="210" x2="240" y2="70"/>
        </g>
        <g>
          <circle cx="120" cy="120" r="8" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
          <circle cx="360" cy="120" r="6" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
          <circle cx="110" cy="280" r="6" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
          <circle cx="370" cy="290" r="8" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
          <circle cx="240" cy="70" r="6" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
        </g>
        <g transform="translate(240,210)">
          <circle r="58" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
          <path d="M0 -30 L26 -18 L26 6 C26 26 14 40 0 46 C-14 40 -26 26 -26 6 L-26 -18 Z" fill="none" stroke="#FAFAF6" stroke-width="2.2"/>
          <path d="M-11 0 L-3 9 L13 -10" fill="none" stroke="#B89A56" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </g>
        <text x="240" y="430" font-family="Arial, sans-serif" font-size="13" fill="#8A919D" text-anchor="middle" letter-spacing="2">TRANSFORMACIÓN DIGITAL &amp; CUMPLIMIENTO</text>
      </svg>
    </div>
  </div>
</section>

<section class="rd-section">
  <div class="wrap">
    <div class="rd-eyebrow">Temario</div>
    <h2>Lo que vas a aprender</h2>
    <p style="color:var(--slate);font-size:0.9rem;max-width:560px;">Programa preparado a medida para {{ $company->name }}, estructurado en {{ $course->modules->count() }} módulos.</p>
    <div class="rd-modules">
      @foreach($course->modules as $module)
        <div class="rd-module-card rd-fade-up rd-delay-{{ min($loop->iteration, 4) }}">
          <div class="rd-module-num">{{ sprintf('%02d', $loop->iteration) }}</div>
          <div>
            <h3>{{ $module->title }}</h3>
            @forelse($module->lessons as $lesson)
              <span class="rd-lesson-chip">&middot; {{ $lesson->title }}</span><br>
            @empty
              <span class="rd-lesson-chip" style="color:var(--slate-light);">Contenido en preparación.</span>
            @endforelse
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

@if($course->instructor)
<section class="rd-section rd-section-alt">
  <div class="wrap" style="max-width:720px;">
    <div class="rd-eyebrow">Instructor</div>
    <h2 style="margin-bottom:1.6rem;">Tu guía en esta capacitación</h2>
    <div class="rd-instructor-card">
      <img src="{{ $course->instructor->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $course->instructor->name }}">
      <div>
        <h3>{{ $course->instructor->name }}</h3>
        <div class="rd-instructor-role">{{ $course->instructor->title ?? 'Instructor' }}</div>
        <p class="rd-instructor-bio">{{ \Illuminate\Support\Str::limit($course->instructor->bio, 220) }}</p>
      </div>
    </div>
  </div>
</section>
@endif

<section class="rd-section rd-section-alt" id="material-extra">
  <div class="wrap" style="max-width:720px;">
    <div class="rd-eyebrow">Material extra</div>
    <h2>Recursos complementarios</h2>
    <div style="background:var(--white);border:1px dashed var(--line);border-radius:12px;padding:2rem;margin-top:1.4rem;">
      <p style="font-weight:600;margin-bottom:6px;">Próximamente</p>
      <p style="font-size:0.88rem;color:var(--slate);">Estamos preparando material adicional para complementar esta capacitación. Se publicará durante los próximos 10 días.</p>
    </div>
  </div>
</section>

<section class="rd-section">
  <div class="wrap" style="max-width:900px;">
    <div class="rd-cta-band rd-fade-up">
      <h2 style="color:var(--white);">¿Listo para comenzar?</h2>
      <p>Avanza a tu propio ritmo, autoevalúate al finalizar y obtén tu certificado verificable por QR.</p>
      @if($enrollment)
        @php $next2 = $course->nextLessonFor(auth()->user()); @endphp
        <a href="{{ $next2 ? route('lessons.show', $next2) : route('courses.show', $course) }}" class="rd-btn-primary">Continuar curso</a>
      @else
        <button type="button" class="rd-btn-primary" onclick="rdOpenWelcome()">Inscribirme</button>
      @endif
    </div>
  </div>
</section>
@endsection

@section('scripts')
@auth
<div id="rdOnboard">
  <div class="rd-ob-logo"><img src="{{ asset('images/logos.png') }}" alt="Romani Compliance"></div>

  <button type="button" class="rd-ob-skip" onclick="rdOnboardFinish()">Omitir →</button>

  <div class="rd-ob-loading" id="rdObLoading">
    <div class="rd-ob-spinner"></div>
    <span>Cargando tu experiencia...</span>
  </div>

  <div class="rd-ob-name" id="rdObName">
    <h1 id="rdObNameText"></h1>
    <div class="rd-ob-subtext" id="rdObSubtext"></div>
  </div>

  <div class="rd-ob-master-track"><div class="rd-ob-master-fill" id="rdObMasterFill"></div></div>
  <div class="rd-ob-confetti" id="rdObConfetti"></div>

  <div class="rd-ob-carousel" id="rdObCarousel">
    <div class="rd-ob-track" id="rdObTrack">

      <div class="rd-ob-card" data-card="0">
        <div class="rd-ob-eyebrow">El propósito</div>
        <h2>Comprender es prevenir.</h2>
        <p>El sistema de prevención LA/FT te permite identificar riesgos, reconocer señales de alerta y actuar antes de que una operación se convierta en un problema.</p>
        <ul class="rd-ob-benefits" style="margin-top:0.9rem;">
          <li><span class="n">01</span> Comprenderás el marco normativo aplicable.</li>
          <li><span class="n">02</span> Reconocerás señales de alerta en la práctica.</li>
        </ul>
      </div>

      @if($course->instructor)
        <div class="rd-ob-card" data-card="1" data-duration="long">
          <div class="rd-ob-eyebrow">Aprende de un especialista</div>
          <img src="{{ $course->instructor->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $course->instructor->name }}" class="rd-ob-instructor-photo">
          <h2>{{ $course->instructor->name }}</h2>
          <p style="color:var(--gold);font-weight:600;font-size:0.85rem;margin-bottom:0.5rem;">{{ $course->instructor->title ?? 'Instructor' }}</p>
          <p>{{ \Illuminate\Support\Str::limit($course->instructor->bio, 150) }}</p>
        </div>
      @endif

      <div class="rd-ob-card" data-card="2">
        <div class="rd-ob-eyebrow">Certificación</div>
        <h2>Tu aprendizaje deja una constancia.</h2>
        <div class="rd-ob-cert-badge">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><rect x="6" y="6" width="4" height="4"/><rect x="14" y="6" width="4" height="4"/><rect x="6" y="14" width="4" height="4"/><path d="M14 14h2v2h-2zM18 14h2v2h-2zM14 18h2v2h-2zM18 18h2v2h-2z"/></svg>
          <div>CERTIFICACIÓN DIGITAL<br>VERIFICABLE POR QR</div>
        </div>
      </div>

      <div class="rd-ob-card" data-card="3">
        <h2>Todo listo.</h2>
        <p>{{ $course->modules->count() }} módulos &middot; {{ $course->modules->sum(fn($m) => $m->lessons->count()) }} contenidos @if($course->duration_minutes) &middot; {{ $course->lectiveHours() }}h @endif</p>
        <div class="rd-ob-cta">
          <button type="button" class="rd-btn-primary rd-ob-final-btn" onclick="rdOnboardFinish()">Comenzar capacitación →</button>
        </div>
      </div>

    </div>
  </div>
</div>
@endauth

@if(!$enrollment)
<div class="modal-overlay" id="rdWelcomeModal">
  <div class="modal-backdrop" onclick="rdCloseWelcome()"></div>
  <div class="modal-box rd-welcome-modal" style="max-width:480px;">
    <button class="modal-close" onclick="rdCloseWelcome()">&times;</button>

    <div class="rd-step active" id="rdStep1">
      <div class="rd-welcome-img">
        <svg viewBox="0 0 400 160" xmlns="http://www.w3.org/2000/svg">
          <rect width="400" height="160" fill="#0B1829"/>
          <circle cx="330" cy="30" r="70" fill="#8B7340" opacity="0.25"/>
          <text x="30" y="70" font-family="Arial, sans-serif" font-weight="bold" font-size="20" fill="#FAFAF6">Bienvenido a</text>
          <text x="30" y="98" font-family="Arial, sans-serif" font-weight="bold" font-size="20" fill="#B89A56">{{ \Illuminate\Support\Str::limit($course->title, 30) }}</text>
        </svg>
      </div>
      <h3>Antes de empezar</h3>
      <p class="modal-sub">Una capacitación práctica preparada especialmente para {{ $company->name }}, con módulos breves, autoevaluación y certificado al finalizar.</p>
      <ul>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg> {{ $course->modules->count() }} módulos con contenido práctico</li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg> Autoevaluación al finalizar</li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg> Certificado gratuito verificable por QR</li>
      </ul>
      <button type="button" class="btn btn-gold btn-block" style="width:100%;justify-content:center;" onclick="rdGoStep2()">Ver contenido</button>
    </div>

    <div class="rd-step" id="rdStep2">
      <h3>¿Cómo te llamas?</h3>
      <p class="modal-sub">Solo necesitamos tu nombre para guardar tu avance.</p>
      <form action="{{ route('courses.guest-start', $course) }}" method="POST">
        @csrf
        <div class="rd-form-group">
          <label>Nombre completo</label>
          <input type="text" name="full_name" required autofocus>
        </div>
        <div class="rd-form-group">
          <label>Correo electrónico (opcional)</label>
          <input type="email" name="email">
          <div class="rd-form-hint">Opcional. Lo usaremos solo para enviarte novedades, actualizaciones y material adicional del curso.</div>
        </div>
        <button type="submit" class="btn btn-gold btn-block" style="width:100%;justify-content:center;">Entrar al curso</button>
      </form>
      <p class="rd-form-hint" style="text-align:center;margin-top:12px;">¿Ya tienes cuenta? <a href="{{ route('login', ['intended' => route('courses.show', $course)]) }}" style="color:var(--gold);font-weight:600;">Inicia sesión</a></p>
    </div>
  </div>
</div>
@endif

<script>
window.addEventListener('load', () => { document.getElementById('rd-loader')?.classList.add('hidden'); });
setTimeout(() => document.getElementById('rd-loader')?.classList.add('hidden'), 1200);

function rdOpenWelcome() { document.getElementById('rdWelcomeModal')?.classList.add('active'); }
function rdCloseWelcome() { document.getElementById('rdWelcomeModal')?.classList.remove('active'); }
function rdGoStep2() {
  document.getElementById('rdStep1').classList.remove('active');
  document.getElementById('rdStep2').classList.add('active');
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') rdCloseWelcome(); });

let rdObCards = [];
let rdObIndex = 0;
let rdObAutoTimer = null;
let rdObDurations = [];
let rdObTotalMs = 0;
let rdObMasterRaf = null;
const RD_OB_NAME = "{{ $rdGreetingWord }}, {{ addslashes(explode(' ', auth()->user()?->name ?? '')[0]) }}.";
const RD_OB_NORMAL_MS = 4200; // un poco más rápido
const RD_OB_INSTRUCTOR_MS = 6200;
const RD_OB_NAME_DOCK_DELAY = 5500; // escritura del saludo + 2 frases de transición

function rdTypewrite(el, text, speed, onDone) {
  el.textContent = '';
  const cursor = document.createElement('span');
  cursor.className = 'rd-ob-cursor';
  let i = 0;
  (function step() {
    el.textContent = text.slice(0, i);
    el.appendChild(cursor);
    i++;
    if (i <= text.length) {
      setTimeout(step, speed);
    } else {
      cursor.remove();
      if (onDone) onDone();
    }
  })();
}

(function rdOnboarding() {
  const overlay = document.getElementById('rdOnboard');
  if (!overlay) return;

  const params = new URLSearchParams(window.location.search);
  const justJoined = params.get('bienvenida') === '1';

  // Se muestra cada vez que la persona entra al curso desde el flujo de
  // inscripción (a propósito, por pedido explícito), no solo una vez.
  if (!justJoined) return;

  // Precargar todo el DOM del carrusel ANTES de mostrar nada, para que
  // la primera tarjeta nunca aparezca vacía.
  rdObCards = Array.from(document.querySelectorAll('#rdObTrack .rd-ob-card'));
  rdObDurations = rdObCards.map(c => c.dataset.duration === 'long' ? RD_OB_INSTRUCTOR_MS : RD_OB_NORMAL_MS);
  rdObTotalMs = RD_OB_NAME_DOCK_DELAY + rdObDurations.reduce((a, b) => a + b, 0);
  rdObCards[0].classList.add('active');

  overlay.classList.add('active');
  rdObStartMasterProgress();

  // Indicador breve de carga para que el usuario sepa que algo está
  // pasando, antes de que empiece a escribirse el saludo.
  const loadingEl = document.getElementById('rdObLoading');
  const nameEl = document.getElementById('rdObName');

  setTimeout(() => {
    loadingEl.classList.add('hide');

    // El saludo se escribe con máquina de escribir (lento); después
    // aparecen dos frases breves de transición, y luego el nombre sube
    // y queda fijo MIENTRAS aparecen las tarjetas (sincronizado).
    const subtext = document.getElementById('rdObSubtext');
    rdTypewrite(document.getElementById('rdObNameText'), RD_OB_NAME, 55, () => {
      setTimeout(() => {
        subtext.textContent = 'Gracias por confiar en Romani Compliance.';
        subtext.classList.add('show');
      }, 300);
      setTimeout(() => {
        subtext.classList.remove('show');
        setTimeout(() => {
          subtext.textContent = 'Estamos preparando el contenido para ti.';
          subtext.classList.add('show');
        }, 400);
      }, 1900);
      setTimeout(() => {
        nameEl.classList.add('docked');
        document.getElementById('rdObCarousel').classList.add('show');
        rdObStartAuto();
      }, 3800);
    });
  }, 700);
})();

function rdObStartMasterProgress() {
  const fill = document.getElementById('rdObMasterFill');
  const start = performance.now();
  function tick(now) {
    const pct = Math.min(100, ((now - start) / rdObTotalMs) * 100);
    fill.style.width = pct + '%';
    if (pct < 100) rdObMasterRaf = requestAnimationFrame(tick);
  }
  rdObMasterRaf = requestAnimationFrame(tick);
}

function rdObTypewriteCardTitle(card) {
  const h2 = card.querySelector('h2');
  if (!h2 || h2.dataset.typed) return;
  h2.dataset.typed = '1';
  const text = h2.textContent;
  rdTypewrite(h2, text, 16);
}

function rdObStartAuto() {
  rdObTypewriteCardTitle(rdObCards[0]);
  const advance = () => {
    if (rdObIndex < rdObCards.length - 1) {
      rdObCards[rdObIndex].classList.remove('active');
      rdObCards[rdObIndex].classList.add('leaving');
      rdObIndex++;
      rdObCards[rdObIndex].classList.add('active');
      rdObTypewriteCardTitle(rdObCards[rdObIndex]);
      setTimeout(() => rdObCards[rdObIndex - 1]?.classList.remove('leaving'), 750);
      rdObAutoTimer = setTimeout(advance, rdObDurations[rdObIndex]);
    }
  };
  rdObAutoTimer = setTimeout(advance, rdObDurations[rdObIndex]);
}

function rdObFireConfetti() {
  const wrap = document.getElementById('rdObConfetti');
  const colors = ['#B89A56', '#8B7340', '#FAFAF6', '#6FCF97'];
  for (let i = 0; i < 26; i++) {
    const s = document.createElement('span');
    s.style.left = (Math.random() * 100) + 'vw';
    s.style.background = colors[i % colors.length];
    s.style.animationDelay = (Math.random() * 0.3) + 's';
    s.style.animationDuration = (1 + Math.random() * 0.6) + 's';
    s.style.transform = 'rotate(' + (Math.random() * 360) + 'deg)';
    wrap.appendChild(s);
  }
  setTimeout(() => { wrap.innerHTML = ''; }, 2200);
}

function rdOnboardFinish() {
  clearTimeout(rdObAutoTimer);
  cancelAnimationFrame(rdObMasterRaf);
  rdObFireConfetti();
  const overlay = document.getElementById('rdOnboard');
  setTimeout(() => overlay.classList.add('leaving'), 500);
  setTimeout(() => {
    @php $firstLesson = $course->modules->flatMap->lessons->first(); @endphp
    @if($firstLesson)
      window.location.href = '{{ route('lessons.show', $firstLesson) }}';
    @else
      overlay.classList.remove('active');
      const url = new URL(window.location.href);
      url.searchParams.delete('bienvenida');
      window.history.replaceState({}, '', url);
    @endif
  }, 950);
}
</script>
@endsection
