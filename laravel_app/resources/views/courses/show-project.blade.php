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

#rdOnboard { position: fixed; inset: 0; z-index: 500; background: var(--ink); display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.5s ease, visibility 0.5s ease; }
#rdOnboard.active { opacity: 1; visibility: visible; }
.rd-ob-inner { max-width: 560px; width: 90%; text-align: center; padding: 2rem; }
.rd-ob-logo { font-family: Georgia, 'Times New Roman', serif; font-size: 1.4rem; font-weight: bold; color: var(--white); letter-spacing: 2px; margin-bottom: 3rem; opacity: 0; animation: rdObFade 0.8s ease forwards; }
.rd-ob-slide { display: none; }
.rd-ob-slide.active { display: block; animation: rdObFade 0.7s ease; }
.rd-ob-slide h2 { font-family: 'Inter', sans-serif; font-weight: 800; font-size: clamp(1.5rem, 4vw, 2.1rem); color: var(--white); margin-bottom: 1rem; letter-spacing: -0.01em; }
.rd-ob-slide p { font-size: 0.98rem; color: rgba(255,255,255,0.6); line-height: 1.7; max-width: 440px; margin: 0 auto; }
.rd-ob-icon { width: 52px; height: 52px; border-radius: 14px; background: rgba(184,154,86,0.14); color: var(--gold-light); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.4rem; }
.rd-ob-icon svg { width: 26px; height: 26px; }
@keyframes rdObFade { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.rd-ob-dots { display: flex; gap: 7px; justify-content: center; margin-top: 2.4rem; }
.rd-ob-dot { width: 7px; height: 7px; border-radius: 50%; background: rgba(255,255,255,0.15); transition: background 0.3s, transform 0.3s; }
.rd-ob-dot.on { background: var(--gold-light); transform: scale(1.3); }
.rd-ob-actions { margin-top: 2.2rem; display: flex; gap: 12px; justify-content: center; align-items: center; }
.rd-ob-skip { font-size: 0.78rem; color: rgba(255,255,255,0.35); background: none; border: none; cursor: pointer; }
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
  <div class="rd-ob-inner">
    <div class="rd-ob-logo">ROMANI COMPLIANCE</div>

    <div class="rd-ob-slide" data-slide="0">
      <h2>Hola, {{ explode(' ', auth()->user()->name)[0] }}</h2>
    </div>
    <div class="rd-ob-slide" data-slide="1">
      <h2>Gracias por confiar en Romani Compliance</h2>
    </div>
    <div class="rd-ob-slide" data-slide="2">
      <h2>Estás a punto de comenzar una nueva experiencia de aprendizaje</h2>
      <p>Bienvenido a la capacitación {{ \Illuminate\Support\Str::upper($company->name) }}.</p>
    </div>

    <div class="rd-ob-slide" data-slide="3">
      <div class="rd-ob-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 4v5"/></svg></div>
      <h2>Explora los módulos</h2>
      <p>Encontrarás el contenido organizado por módulos y lecciones. Puedes consultar tu progreso en todo momento desde la barra lateral.</p>
    </div>
    <div class="rd-ob-slide" data-slide="4">
      <div class="rd-ob-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></div>
      <h2>Avanza a tu ritmo</h2>
      <p>Usa los botones Anterior y Siguiente para moverte entre los contenidos y completa progresivamente cada módulo.</p>
    </div>
    <div class="rd-ob-slide" data-slide="5">
      <div class="rd-ob-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4M11 11l-7 7"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h11"/></svg></div>
      <h2>Comprueba lo aprendido</h2>
      <p>Al finalizar el contenido podrás realizar una autoevaluación y conocer tu resultado de inmediato.</p>
    </div>
    <div class="rd-ob-slide" data-slide="6">
      <div class="rd-ob-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M8.5 12.5L7 21l5-2.5L17 21l-1.5-8.5"/></svg></div>
      <h2>Obtén tu certificado</h2>
      <p>Cuando completes los requisitos de la capacitación, podrás desbloquear y generar tu certificado, verificable por QR.</p>
    </div>
    <div class="rd-ob-slide" data-slide="7">
      <div class="rd-ob-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg></div>
      <h2>¿Tienes una pregunta?</h2>
      <p>Podrás enviar tus dudas directamente desde tu panel y consultar material adicional cuando esté disponible.</p>
      <div class="rd-ob-actions">
        <button type="button" class="rd-btn-primary" onclick="rdOnboardFinish()">Comenzar capacitación</button>
      </div>
    </div>

    <div class="rd-ob-dots" id="rdObDots"></div>
    <div class="rd-ob-actions" id="rdObSkipRow">
      <button type="button" class="rd-ob-skip" onclick="rdOnboardFinish()">Saltar introducción</button>
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

(function rdOnboarding() {
  const overlay = document.getElementById('rdOnboard');
  if (!overlay) return;

  const courseKey = 'rd_onboard_seen_{{ $course->id }}';
  const params = new URLSearchParams(window.location.search);
  const justJoined = params.get('bienvenida') === '1';

  if (!justJoined || localStorage.getItem(courseKey)) return;

  const slides = Array.from(overlay.querySelectorAll('.rd-ob-slide'));
  const dotsWrap = document.getElementById('rdObDots');
  const skipRow = document.getElementById('rdObSkipRow');
  const AUTO_ADVANCE_UNTIL = 3; // slides 0,1,2 auto-advance; from 3 onward the dots/skip control shows
  let current = 0;

  slides.forEach((_, i) => {
    const dot = document.createElement('span');
    dot.className = 'rd-ob-dot';
    dot.dataset.i = i;
    dotsWrap.appendChild(dot);
  });
  const dots = Array.from(dotsWrap.children);

  function render() {
    slides.forEach((s, i) => s.classList.toggle('active', i === current));
    dots.forEach((d, i) => d.classList.toggle('on', i === current));
    dotsWrap.style.display = current >= AUTO_ADVANCE_UNTIL ? 'flex' : 'none';
    skipRow.style.display = (current >= AUTO_ADVANCE_UNTIL && current < slides.length - 1) ? 'flex' : (current < AUTO_ADVANCE_UNTIL ? 'none' : 'none');
  }

  overlay.classList.add('active');
  render();

  function advance() {
    if (current < AUTO_ADVANCE_UNTIL) {
      current++;
      render();
      if (current < AUTO_ADVANCE_UNTIL) setTimeout(advance, 1700);
    }
  }
  setTimeout(advance, 1400);

  window.rdOnboardNext = function () {
    if (current < slides.length - 1) { current++; render(); }
  };

  overlay.addEventListener('click', (e) => {
    if (current >= AUTO_ADVANCE_UNTIL && current < slides.length - 1 && !e.target.closest('button')) {
      window.rdOnboardNext();
    }
  });
})();

function rdOnboardFinish() {
  localStorage.setItem('rd_onboard_seen_{{ $course->id }}', '1');
  document.getElementById('rdOnboard')?.classList.remove('active');
  const url = new URL(window.location.href);
  url.searchParams.delete('bienvenida');
  window.history.replaceState({}, '', url);
}
</script>
@endsection
