@extends('layouts.app')

@section('title', $course->title.' — Romani Compliance')
@php $company = $course->project->company; @endphp

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

#rdOnboard { position: fixed; inset: 0; z-index: 500; background: radial-gradient(120% 100% at 50% 0%, #16283F 0%, #0B1829 60%); display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.5s ease, visibility 0.5s ease; padding: 1.5rem; }
#rdOnboard.active { opacity: 1; visibility: visible; }
.rd-ob-logo { position: absolute; top: 2rem; left: 50%; transform: translateX(-50%); }
.rd-ob-logo img { height: 24px; filter: brightness(0) invert(1); opacity: 0.6; }
.rd-ob-timer-track { width: 100%; max-width: 200px; height: 3px; background: rgba(255,255,255,0.1); border-radius: 3px; margin: 0 auto 1.6rem; overflow: hidden; }
.rd-ob-timer-fill { height: 100%; background: var(--gold-light); width: 0%; transition: width 5s linear; }
.rd-ob-card { max-width: 640px; width: 100%; padding: 2.6rem 1rem 1rem; }
.rd-ob-progress-label { font-size: 0.68rem; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 1.4rem; text-align: center; }
.rd-ob-slide { display: none; text-align: center; min-height: 260px; }
.rd-ob-slide.active { display: block; animation: rdObFade 0.5s ease; }
@keyframes rdObFade { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
.rd-ob-icon { width: 54px; height: 54px; border-radius: 14px; background: rgba(184,154,86,0.14); color: var(--gold-light); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.3rem; }
.rd-ob-icon svg { width: 27px; height: 27px; }
.rd-ob-slide h2 { font-family: 'Inter', sans-serif; font-weight: 800; font-size: clamp(1.3rem, 3.5vw, 1.7rem); color: var(--white); margin-bottom: 0.7rem; letter-spacing: -0.01em; }
.rd-ob-slide p { font-size: 0.92rem; color: rgba(255,255,255,0.6); line-height: 1.7; max-width: 440px; margin: 0 auto 0.4rem; }
.rd-ob-meta-row { display: flex; gap: 1.6rem; justify-content: center; margin-top: 1.2rem; }
.rd-ob-meta-row div { font-size: 0.78rem; color: rgba(255,255,255,0.5); }
.rd-ob-meta-row strong { display: block; color: var(--white); font-size: 1rem; }
.rd-ob-instructor-photo { width: 76px; height: 76px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(184,154,86,0.3); margin: 0 auto 1rem; display: block; }
.rd-ob-modules { text-align: left; max-width: 360px; margin: 1rem auto 0; }
.rd-ob-modules div { display: flex; align-items: center; gap: 10px; padding: 9px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 0.85rem; color: rgba(255,255,255,0.75); }
.rd-ob-modules span.n { width: 24px; height: 24px; border-radius: 6px; background: rgba(184,154,86,0.14); color: var(--gold-light); font-size: 0.7rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rd-ob-benefits { text-align: left; max-width: 380px; margin: 1.1rem auto 0; list-style: none; }
.rd-ob-benefits li { display: flex; align-items: start; gap: 9px; font-size: 0.86rem; color: rgba(255,255,255,0.7); margin-bottom: 10px; line-height: 1.5; }
.rd-ob-benefits li svg { width: 15px; height: 15px; flex-shrink: 0; color: #6FCF97; margin-top: 3px; }

.rd-ob-dots { display: flex; gap: 7px; justify-content: center; margin-top: 1.8rem; margin-bottom: 1.4rem; }
.rd-ob-dot { width: 22px; height: 4px; border-radius: 4px; background: rgba(255,255,255,0.15); transition: background 0.3s; cursor: pointer; border: none; padding: 0; }
.rd-ob-dot.on { background: var(--gold-light); }
.rd-ob-nav-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.rd-ob-btn-ghost { font-size: 0.82rem; color: rgba(255,255,255,0.55); background: none; border: 1px solid rgba(255,255,255,0.15); padding: 10px 18px; border-radius: 8px; cursor: pointer; }
.rd-ob-btn-ghost:hover { border-color: rgba(255,255,255,0.35); color: var(--white); }
.rd-ob-btn-ghost:disabled { opacity: 0.3; cursor: not-allowed; }
.rd-ob-skip { font-size: 0.76rem; color: rgba(255,255,255,0.3); background: none; border: none; cursor: pointer; text-align: center; display: block; margin: 1.2rem auto 0; }
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
  <div class="rd-ob-card">
    <div class="rd-ob-progress-label" id="rdObLabel">Introducción 1 de 5</div>
    <div class="rd-ob-timer-track"><div class="rd-ob-timer-fill" id="rdObTimerFill"></div></div>

    <div class="rd-ob-slide active" data-slide="0">
      <h2>Hola, {{ explode(' ', auth()->user()->name)[0] }}</h2>
      <p>Gracias por confiar en Romani Compliance.</p>
    </div>

    <div class="rd-ob-slide" data-slide="1">
      <h2>Bienvenido a {{ $course->title }}</h2>
      <p>{{ $company->name }}</p>
      <div class="rd-ob-meta-row">
        <div><strong>{{ $course->modules->count() }}</strong>módulos</div>
        @if($course->duration_minutes)
          <div><strong>{{ $course->lectiveHours() }}h</strong>duración</div>
        @endif
        <div><strong>Sí</strong>certificado</div>
      </div>
    </div>

    @if($course->instructor)
      <div class="rd-ob-slide" data-slide="2">
        <img src="{{ $course->instructor->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $course->instructor->name }}" class="rd-ob-instructor-photo">
        <h2>{{ $course->instructor->name }}</h2>
        <p style="color:var(--gold-light);font-weight:600;font-size:0.85rem;">{{ $course->instructor->title ?? 'Instructor' }}</p>
        <p>{{ \Illuminate\Support\Str::limit($course->instructor->bio, 180) }}</p>
      </div>
    @endif

    <div class="rd-ob-slide" data-slide="2">
      <div class="rd-ob-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L3 7v6c0 5 4 9 9 9s9-4 9-9V7l-9-5z"/></svg></div>
      <h2>¿Por qué es importante?</h2>
      <ul class="rd-ob-benefits">
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg> Cumple con las obligaciones normativas de prevención LA/FT.</li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg> Aprende a identificar señales de alerta y actuar correctamente.</li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg> Obtén un certificado verificable que respalda tu capacitación.</li>
      </ul>
    </div>

    <div class="rd-ob-slide" data-slide="3">
      <div class="rd-ob-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 4v5"/></svg></div>
      <h2>¿Qué aprenderás?</h2>
      <div class="rd-ob-modules">
        @foreach($course->modules as $module)
          <div><span class="n">{{ sprintf('%02d', $loop->iteration) }}</span> {{ $module->title }}</div>
        @endforeach
      </div>
    </div>

    <div class="rd-ob-dots" id="rdObDots"></div>
    <div class="rd-ob-nav-row">
      <button type="button" class="rd-ob-btn-ghost" id="rdObPrev" onclick="rdObPrev()">← Anterior</button>
      <button type="button" class="rd-btn-primary" id="rdObNext" onclick="rdObNext()">Siguiente →</button>
    </div>
    <button type="button" class="rd-ob-skip" onclick="rdOnboardFinish()">Saltar introducción</button>
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

let rdObCurrent = 0;
let rdObSlides = [];
let rdObDots = [];
let rdObAutoTimer = null;

(function rdOnboarding() {
  const overlay = document.getElementById('rdOnboard');
  if (!overlay) return;

  const params = new URLSearchParams(window.location.search);
  const justJoined = params.get('bienvenida') === '1';

  // Se muestra cada vez que la persona entra al curso desde el flujo de
  // inscripción (a propósito, por pedido explícito), no solo una vez.
  if (!justJoined) return;

  rdObSlides = Array.from(overlay.querySelectorAll('.rd-ob-slide'));
  const dotsWrap = document.getElementById('rdObDots');
  rdObSlides.forEach((_, i) => {
    const dot = document.createElement('button');
    dot.type = 'button';
    dot.className = 'rd-ob-dot';
    dot.onclick = () => { rdObCurrent = i; rdObRender(); rdObStopAuto(); };
    dotsWrap.appendChild(dot);
  });
  rdObDots = Array.from(dotsWrap.children);

  overlay.classList.add('active');
  rdObRender();
  rdObStartAuto();

  overlay.addEventListener('mouseenter', rdObStopAuto);
  overlay.addEventListener('touchstart', rdObStopAuto, { passive: true });
})();

function rdObRender() {
  rdObSlides.forEach((s, i) => s.classList.toggle('active', i === rdObCurrent));
  rdObDots.forEach((d, i) => d.classList.toggle('on', i === rdObCurrent));
  document.getElementById('rdObLabel').textContent = 'Introducción ' + (rdObCurrent + 1) + ' de ' + rdObSlides.length;
  document.getElementById('rdObPrev').disabled = rdObCurrent === 0;
  document.getElementById('rdObNext').textContent = rdObCurrent === rdObSlides.length - 1 ? 'Comenzar capacitación' : 'Siguiente →';
}

function rdObTickTimer() {
  const fill = document.getElementById('rdObTimerFill');
  if (!fill) return;
  fill.style.transition = 'none';
  fill.style.width = '0%';
  requestAnimationFrame(() => {
    fill.style.transition = 'width 5s linear';
    fill.style.width = '100%';
  });
}

function rdObStartAuto() {
  rdObTickTimer();
  rdObAutoTimer = setInterval(() => {
    if (rdObCurrent < rdObSlides.length - 1) { rdObCurrent++; rdObRender(); rdObTickTimer(); }
    else rdObStopAuto();
  }, 5000);
}
function rdObStopAuto() {
  clearInterval(rdObAutoTimer);
  const fill = document.getElementById('rdObTimerFill');
  if (fill) fill.style.transition = 'none';
}

function rdObNext() {
  rdObStopAuto();
  if (rdObCurrent < rdObSlides.length - 1) { rdObCurrent++; rdObRender(); }
  else rdOnboardFinish();
}
function rdObPrev() {
  rdObStopAuto();
  if (rdObCurrent > 0) { rdObCurrent--; rdObRender(); }
}

function rdOnboardFinish() {
  localStorage.setItem('rd_onboard_seen_{{ $course->id }}', '1');
  rdObStopAuto();
  @php $firstLesson = $course->modules->flatMap->lessons->first(); @endphp
  @if($firstLesson)
    window.location.href = '{{ route('lessons.show', $firstLesson) }}';
  @else
    document.getElementById('rdOnboard')?.classList.remove('active');
    const url = new URL(window.location.href);
    url.searchParams.delete('bienvenida');
    window.history.replaceState({}, '', url);
  @endif
}
</script>
@endsection
