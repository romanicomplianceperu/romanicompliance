@extends('layouts.app')

@section('title', 'Romani Compliance · Compliance · ALA/CFT · Due Diligence')
@section('description', 'Romani Compliance: servicios especializados en Compliance corporativo, prevención de lavado de activos, derecho penal, Due Diligence e investigación financiera en Perú.')

@section('styles')
/* ── HERO ── */
.hero { background: var(--ink); padding: 7rem 0 6rem; position: relative; overflow: hidden; }
.hero::before { content: ''; position: absolute; top: -50%; right: -20%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(139,115,64,0.06) 0%, transparent 70%); pointer-events: none; }
.hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
.hero-content { max-width: 680px; position: relative; z-index: 1; }
.hero-eyebrow { font-family: var(--sans); font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.18em; color: var(--gold-light); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px; }
.hero-eyebrow::before { content: ''; width: 32px; height: 1px; background: var(--gold); }
.hero h1 { font-size: clamp(2.2rem, 5vw, 3.4rem); color: var(--white); font-weight: 400; line-height: 1.12; margin-bottom: 1.5rem; }
.hero h1 em { font-style: italic; color: var(--gold-light); }
.hero-sub { font-size: 1rem; color: rgba(255,255,255,0.5); line-height: 1.75; max-width: 520px; margin-bottom: 2.5rem; font-weight: 300; }
.hero-actions { display: flex; gap: 16px; flex-wrap: wrap; }

/* ── ABOUT STRIP ── */
.about-strip { background: var(--white); padding: 5rem 0; border-bottom: 1px solid var(--line); }
.about-grid { display: grid; grid-template-columns: 1fr 1px 1fr; gap: 3rem; align-items: start; }
.about-divider { background: var(--line); width: 1px; height: 100%; min-height: 80px; justify-self: center; }
.about-block h3 { font-size: 1.4rem; color: var(--ink); margin-bottom: 0.6rem; }
.about-block h3 span { color: var(--gold); }
.about-block p { font-size: 0.88rem; color: var(--slate); line-height: 1.75; }

/* ── SERVICES ── */
.services { padding: 5rem 0; }
.services-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.service-card { background: var(--white); padding: 2rem; border-radius: var(--radius); border: 1px solid var(--line); transition: box-shadow 0.4s, border-color 0.4s, transform 0.4s; display: flex; flex-direction: column; }
.service-card:hover { box-shadow: var(--shadow-m); border-color: var(--gold); transform: translateY(-4px); }
.service-card.service-card-feature { border-color: rgba(139,115,64,0.3); background: linear-gradient(165deg, var(--white) 60%, var(--gold-pale) 150%); }
.service-icon { width: 52px; height: 52px; border-radius: 12px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; margin-bottom: 1.2rem; flex-shrink: 0; }
.service-icon svg { width: 26px; height: 26px; }
.service-card h4 { font-size: 1.15rem; margin-bottom: 0.6rem; }
.service-card p { font-size: 0.85rem; color: var(--slate); line-height: 1.7; margin-bottom: 1.2rem; }
.service-sublist { list-style: none; display: flex; flex-direction: column; gap: 7px; margin-bottom: 1.6rem; flex: 1; }
.service-sublist li { font-size: 0.8rem; color: var(--ink); font-weight: 500; padding-left: 1.1rem; position: relative; }
.service-sublist li::before { content: ''; position: absolute; left: 0; top: 7px; width: 5px; height: 5px; border-radius: 50%; background: var(--gold); }
.service-link { font-size: 0.78rem; font-weight: 600; color: var(--gold); display: inline-flex; align-items: center; gap: 6px; transition: gap 0.2s; }
.service-link:hover { gap: 10px; }

/* ── CURSOS ONLINE ── */
.courses-online { padding: 5rem 0; background: var(--white); border-bottom: 1px solid var(--line); }
.courses-online-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 2rem; }
.course-preview-card { background: var(--ivory); border: 1px solid var(--line); border-radius: 6px; overflow: hidden; display: block; transition: box-shadow 0.4s, transform 0.4s, border-color 0.4s; }
.course-preview-card:hover { box-shadow: var(--shadow-m); transform: translateY(-4px); border-color: var(--gold); }
.course-preview-cover { aspect-ratio: 16 / 9; background: var(--ink); overflow: hidden; }
.course-preview-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
.course-preview-body { padding: 1.4rem; }
.course-preview-category { font-size: 0.66rem; color: var(--gold); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
.course-preview-body h4 { font-size: 1.02rem; margin-bottom: 0.5rem; line-height: 1.3; }
.course-preview-body p { font-size: 0.8rem; color: var(--slate); line-height: 1.6; margin-bottom: 0.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.course-preview-meta { font-size: 0.72rem; color: var(--slate-light); }
.courses-online-more { display: flex; justify-content: center; margin-top: 2.2rem; }

/* ── PLANS ── */
.plans { padding: 5rem 0; background: var(--ink); }
.plans .section-header h2 { color: var(--white); }
.plans .section-header p { color: rgba(255,255,255,0.5); }
.plans .section-header .gold-line { background: var(--gold-light); }
.plans-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 2rem; }
.plan-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: var(--radius); padding: 2rem; display: flex; flex-direction: column; transition: border-color 0.4s, background 0.4s, transform 0.4s; }
.plan-card:hover { border-color: var(--gold); background: rgba(255,255,255,0.06); transform: translateY(-4px); }
.plan-card.highlight { border-color: var(--gold); background: rgba(139,115,64,0.08); }
.plan-tag { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: var(--gold-light); margin-bottom: 0.8rem; }
.plan-card h4 { font-size: 1.15rem; color: var(--white); margin-bottom: 0.4rem; }
.plan-desc { font-size: 0.8rem; color: rgba(255,255,255,0.4); margin-bottom: 1.5rem; min-height: 44px; }
.plan-features { list-style: none; flex: 1; }
.plan-features li { font-size: 0.8rem; color: rgba(255,255,255,0.65); padding: 6px 0; display: flex; align-items: flex-start; gap: 10px; line-height: 1.5; }
.plan-features li::before { content: '\2014'; color: var(--gold-light); flex-shrink: 0; }
.plan-cta { margin-top: 1.5rem; }
.btn-plan-cta { display: block; text-align: center; padding: 11px; font-size: 0.8rem; font-weight: 600; border-radius: var(--radius); border: 1px solid var(--gold); color: var(--gold-light); background: transparent; cursor: pointer; font-family: var(--sans); transition: all 0.3s; width: 100%; }
.btn-plan-cta:hover { background: var(--gold); color: var(--white); }
.plan-card.highlight .btn-plan-cta { background: var(--gold); color: var(--white); }
.plan-card.highlight .btn-plan-cta:hover { background: var(--gold-light); }

/* ── DIRECTOR ── */
.director { padding: 5rem 0; background: var(--white); }
.director-box { display: flex; gap: 3rem; align-items: flex-start; }
.director-photo { width: 180px; height: 180px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 3px solid var(--ivory-dim); box-shadow: var(--shadow-s); }
.director-photo img { width: 100%; height: 100%; object-fit: cover; }
.director-info h3 { font-size: 1.6rem; margin-bottom: 2px; }
.director-title { font-size: 0.82rem; color: var(--gold); font-weight: 600; margin-bottom: 1rem; }
.director-bio { font-size: 0.88rem; color: var(--slate); line-height: 1.75; margin-bottom: 1rem; }
.director-contact { display: flex; flex-wrap: wrap; gap: 1.2rem; margin-bottom: 1rem; }
.director-contact a { font-size: 0.78rem; color: var(--slate); display: flex; align-items: center; gap: 6px; transition: color 0.2s; }
.director-contact a:hover { color: var(--gold); }
.director-creds { display: flex; flex-wrap: wrap; gap: 6px; }
.cred-tag { font-size: 0.65rem; font-weight: 600; padding: 4px 10px; background: var(--gold-pale); color: var(--gold); border-radius: 3px; letter-spacing: 0.02em; }

/* ── BLOG ── */
.blog { padding: 5rem 0; }
.blog .article-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 2rem; }
.blog-more { display: flex; justify-content: center; margin-top: 2rem; }

/* ── CONTACT SECTION ── */
.contact-section { padding: 5rem 0; background: var(--ink); }
.contact-section .section-header h2 { color: var(--white); }
.contact-section .section-header p { color: rgba(255,255,255,0.5); }
.contact-section .section-header .gold-line { background: var(--gold-light); }
.contact-layout { display: grid; grid-template-columns: 1fr 1.2fr; gap: 3rem; margin-top: 2rem; }
.contact-info h3 { font-size: 1.2rem; color: var(--white); margin-bottom: 1rem; }
.contact-info p { font-size: 0.85rem; color: rgba(255,255,255,0.5); line-height: 1.75; margin-bottom: 1.5rem; }
.contact-detail { display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; }
.contact-detail a { color: var(--gold-light); font-size: 0.82rem; transition: color 0.2s; }
.contact-detail a:hover { color: var(--white); }
.cd-label { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(255,255,255,0.3); min-width: 56px; }

.contact-form { display: flex; flex-direction: column; gap: 14px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.contact-form label { font-size: 0.72rem; font-weight: 600; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; display: block; }
.contact-form input, .contact-form textarea, .contact-form select { width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius); color: var(--white); font-family: var(--sans); font-size: 0.85rem; transition: border-color 0.3s, background 0.3s; }
.contact-form input::placeholder, .contact-form textarea::placeholder { color: rgba(255,255,255,0.2); }
.contact-form input:focus, .contact-form textarea:focus, .contact-form select:focus { outline: none; border-color: var(--gold); background: rgba(255,255,255,0.08); }
.contact-form textarea { resize: vertical; min-height: 80px; }
.contact-form select option { background: var(--ink); color: var(--white); }
.btn-submit { padding: 12px 28px; background: var(--gold); color: var(--white); border: none; border-radius: var(--radius); font-family: var(--sans); font-size: 0.82rem; font-weight: 600; cursor: pointer; transition: background 0.3s, transform 0.3s; align-self: flex-start; }
.btn-submit:hover { background: var(--gold-light); transform: translateY(-1px); }
.form-msg { display: none; padding: 2rem; text-align: center; color: var(--gold-light); font-size: 0.9rem; font-weight: 500; }

/* ── CLIENTES (trust carousel) ── */
.clients-strip { background: var(--ink); padding: 4rem 0; overflow: hidden; position: relative; }
.clients-strip .section-header h2 { color: var(--white); }
.clients-strip .section-header p { color: rgba(255,255,255,0.5); }
.clients-strip .section-header .gold-line { background: var(--gold-light); }
.clients-track-wrap { position: relative; margin-top: 2.5rem; -webkit-mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent); mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent); }
.clients-track { display: flex; align-items: center; gap: 4.5rem; width: max-content; animation: clients-scroll 28s linear infinite; }
.clients-track:hover { animation-play-state: paused; }
.client-item { display: flex; align-items: center; justify-content: center; height: 64px; flex-shrink: 0; }
.client-item img { height: 46px; width: auto; max-width: 180px; object-fit: contain; opacity: 0.92; transition: opacity 0.3s, transform 0.3s; }
.client-item:hover img { opacity: 1; transform: translateY(-2px); }
.client-item-framed { height: 96px; width: 96px; border-radius: 50%; background: rgba(255,255,255,0.96); border: 2px solid var(--gold-light); box-shadow: 0 6px 18px rgba(0,0,0,0.25); padding: 10px; box-sizing: border-box; }
.client-item-framed img { height: 100%; width: 100%; max-width: none; opacity: 1; }
.client-item-framed:hover img { transform: none; }
.client-item-framed:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(0,0,0,0.3); }
.client-item.client-text-logo { font-family: var(--serif); font-size: 1.7rem; letter-spacing: 0.02em; color: var(--gold-light); font-weight: 500; white-space: nowrap; transition: transform 0.3s; }
.client-item.client-text-logo span { font-weight: 300; font-style: italic; color: rgba(255,255,255,0.55); }
.client-item.client-text-logo:hover { transform: translateY(-2px); }
@keyframes clients-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
@media (prefers-reduced-motion: reduce) { .clients-track { animation: none; flex-wrap: wrap; justify-content: center; width: auto; } }

@media (max-width: 900px) {
  .services-grid, .plans-grid, .blog .article-grid, .courses-online-grid { grid-template-columns: 1fr; max-width: 480px; margin-left: auto; margin-right: auto; }
  .about-grid { grid-template-columns: 1fr; gap: 2rem; }
  .about-divider { display: none; }
  .director-box { flex-direction: column; align-items: center; text-align: center; }
  .director-contact { justify-content: center; }
  .director-creds { justify-content: center; }
  .contact-layout { grid-template-columns: 1fr; }
  .form-row { grid-template-columns: 1fr !important; }
  .hero { padding: 4rem 0 3.5rem; }
  .clients-strip { padding: 3rem 0; }
}
@endsection

@section('content')
<section class="hero">
  <div class="wrap">
    <div class="hero-content">
      <div class="hero-eyebrow">{{ \App\Models\SiteSetting::get('home_hero_eyebrow', 'Compliance · ALA/CFT · Due Diligence') }}</div>
      <h1>{!! \App\Models\SiteSetting::get('home_hero_title', 'Protegemos su organización con <em>estrategia legal</em> y cumplimiento normativo') !!}</h1>
      <p class="hero-sub">{{ \App\Models\SiteSetting::get('home_hero_subtitle', 'Asesoría especializada en compliance corporativo, prevención de lavado de activos, derecho penal y due diligence para empresas que operan bajo estándares rigurosos.') }}</p>
      <div class="hero-actions">
        <button class="btn btn-gold" onclick="irAContacto()">Solicitar asesoría</button>
        <a href="#servicios" class="btn btn-ghost">Conocer servicios</a>
      </div>
    </div>
  </div>
</section>

<section class="about-strip" id="nosotros">
  <div class="wrap">
    <div class="about-grid">
      <div class="about-block reveal-left">
        <h3>Nuestra <span>misión</span></h3>
        <p>{{ \App\Models\SiteSetting::get('home_mission', 'Brindar asesoría jurídica especializada y de alto nivel en materia de cumplimiento normativo, prevención de lavado de activos y financiamiento del terrorismo, y derecho penal, acompañando a las organizaciones en el diseño, implementación y fortalecimiento de sus sistemas de prevención conforme a las exigencias regulatorias nacionales e internacionales.') }}</p>
      </div>
      <div class="about-divider"></div>
      <div class="about-block reveal-right">
        <h3>Nuestra <span>visión</span></h3>
        <p>{{ \App\Models\SiteSetting::get('home_vision', 'Ser el referente peruano en consultoría de compliance corporativo y ALA/CFT, reconocido por la rigurosidad técnica de nuestro equipo, la calidad de nuestros entregables y el compromiso con la cultura de cumplimiento de cada organización que acompañamos.') }}</p>
      </div>
    </div>
  </div>
</section>

<section class="clients-strip" id="clientes">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Clientes que confiaron en nosotros</h2>
      <p>Organizaciones que respaldan nuestro trabajo en compliance y cumplimiento normativo</p>
    </div>
    <div class="clients-track-wrap reveal">
      <div class="clients-track">
        @for ($i = 0; $i < 2; $i++)
          <div class="client-item">
            <img src="{{ asset('images/clientes/red-digital.svg') }}" alt="Red Digital" loading="lazy">
          </div>
          <div class="client-item">
            <img src="{{ asset('images/clientes/qr-pay.png') }}" alt="QR Pay" loading="lazy">
          </div>
          <div class="client-item client-text-logo">Gold<span>Lion</span></div>
          <div class="client-item client-item-framed">
            <img src="{{ asset('images/clientes/san-jorge.png') }}" alt="Créditos San Jorge" loading="lazy">
          </div>
        @endfor
      </div>
    </div>
  </div>
</section>

<section class="services" id="servicios">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Nuestros servicios</h2>
      <p>Soluciones jurídicas especializadas para el cumplimiento normativo de su organización</p>
    </div>
    <div class="services-grid">
      <div class="service-card reveal stagger-1">
        <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.5l8 3.3v5.4c0 5-3.4 8.8-8 10.3-4.6-1.5-8-5.3-8-10.3V5.8l8-3.3z"/><path d="M9 12l2 2 4-4.5"/></svg></div>
        <h4>Compliance &amp; Prevención LA/FT</h4>
        <p>Diseño e implementación de modelos de prevención conforme a la Ley N.° 30424 y sistemas SPLAFT completos: manuales, matrices de riesgo, due diligence e investigación financiera para empresas de cualquier sector.</p>
        <ul class="service-sublist">
          <li>Compliance corporativo (Ley N.° 30424)</li>
          <li>Prevención LA/FT (SPLAFT)</li>
          <li>Due Diligence</li>
          <li>Investigación financiera</li>
        </ul>
        <a href="javascript:void(0)" onclick="irAContacto('Compliance corporativo')" class="service-link">Consultar →</a>
      </div>
      <div class="service-card service-card-feature reveal stagger-2">
        <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V9.5l7-5 7 5V21"/><path d="M9 21v-6h6v6"/><path d="M9 12h.01M15 12h.01M12 9h.01"/></svg></div>
        <h4>Compliance Sectorial</h4>
        <p>Programas de cumplimiento a medida para sectores con riesgos propios: sistemas SPLAF para notarías y due diligence, saneamiento técnico-legal y modelos de prevención para inmobiliarias, agentes y compradores.</p>
        <ul class="service-sublist">
          <li>Compliance Notarial</li>
          <li>Compliance Inmobiliario</li>
        </ul>
        <div style="display:flex;flex-wrap:wrap;gap:16px;">
          <a href="{{ route('inmobiliario') }}" class="service-link">Ver Compliance Inmobiliario →</a>
          <a href="javascript:void(0)" onclick="irAContacto('Compliance Notarial')" class="service-link">Consultar Notarial →</a>
        </div>
      </div>
      <div class="service-card reveal stagger-3">
        <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="1.5"/><path d="M8 8h8M8 12h8M8 16h5"/></svg></div>
        <h4>Asesoría Penal &amp; Capacitaciones</h4>
        <p>Defensa técnica especializada en derecho penal y programas de formación en prevención LA/FT y compliance corporativo, con certificaciones para sujetos obligados, oficiales de cumplimiento y colaboradores.</p>
        <ul class="service-sublist">
          <li>Asesoría penal</li>
          <li>Capacitaciones y certificaciones</li>
        </ul>
        <div style="display:flex;flex-wrap:wrap;gap:16px;">
          <a href="{{ route('capacitaciones') }}" class="service-link">Ver programas →</a>
          <a href="javascript:void(0)" onclick="irAContacto('Asesoría penal')" class="service-link">Consultar penal →</a>
        </div>
      </div>
    </div>
  </div>
</section>

@if($featuredCourses->isNotEmpty())
<section class="courses-online" id="cursos-online">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>{{ \App\Models\SiteSetting::get('home_courses_title', 'Cursos y capacitaciones online') }}</h2>
      <p>{{ \App\Models\SiteSetting::get('home_courses_subtitle', 'Explore nuestro catálogo de cursos y avance a su propio ritmo. Cree una cuenta gratuita para inscribirse.') }}</p>
    </div>
    <div class="courses-online-grid">
      @foreach($featuredCourses as $course)
        <a href="{{ route('courses.show', $course) }}" class="course-preview-card reveal stagger-{{ $loop->iteration }}">
          <div class="course-preview-cover">
            @if($course->cover_image)
              <img src="{{ asset('storage/'.$course->cover_image) }}" alt="{{ $course->title }}">
            @endif
          </div>
          <div class="course-preview-body">
            @if($course->category)
              <div class="course-preview-category">{{ $course->category->name }}</div>
            @endif
            <h4>{{ $course->title }}</h4>
            <div style="margin-bottom:0.6rem;display:flex;gap:6px;flex-wrap:wrap;">@include('courses._certificate-badge') @include('courses._exclusive-badge')</div>
            <p>{{ $course->description }}</p>
            <div class="course-preview-meta">
              @if($course->instructor_name){{ $course->instructor_name }}@endif
              @if($course->duration_minutes) · {{ $course->lectiveHours() }} {{ $course->lectiveHours() === 1 ? 'hora' : 'horas' }} @endif
            </div>
          </div>
        </a>
      @endforeach
    </div>
    <div class="courses-online-more">
      <a href="{{ route('courses.catalog') }}" class="btn btn-gold">Ver todos los cursos</a>
    </div>
  </div>
</section>
@endif

<section class="plans" id="planes">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Programas de capacitación</h2>
      <p>Formación adaptada a las necesidades de cumplimiento de su organización</p>
    </div>
    <div class="plans-grid">
      <div class="plan-card reveal stagger-1">
        <div class="plan-tag">Esencial</div>
        <h4>Capacitación SPLAFT</h4>
        <p class="plan-desc">Fundamentos normativos y operativos del sistema de prevención LA/FT</p>
        <ul class="plan-features">
          <li>Capacitación presencial o virtual (2 horas)</li>
          <li>Marco normativo SPLAFT aplicable al sector</li>
          <li>Tipologías LA/FT y señales de alerta</li>
          <li>Obligaciones del sujeto obligado</li>
          <li>Material de apoyo digital</li>
          <li>Acompañamiento posterior de 5 días</li>
        </ul>
        <div class="plan-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20el%20Plan%20Esencial%20de%20capacitaci%C3%B3n%20SPLAFT." class="btn-plan-cta" target="_blank">Solicitar información</a>
        </div>
      </div>
      <div class="plan-card highlight reveal stagger-2">
        <div class="plan-tag">Recomendado</div>
        <h4>Capacitación SPLAFT Integral</h4>
        <p class="plan-desc">Formación completa con módulo dedicado al Oficial de Cumplimiento</p>
        <ul class="plan-features">
          <li>Todo lo incluido en el Plan Esencial</li>
          <li>Guía para documentación exigida por la UIF</li>
          <li>Manual de Prevención, Código de Conducta y Matriz de Riesgos</li>
          <li>Módulo: El Oficial de Cumplimiento</li>
          <li>Debida diligencia del cliente (DDC/KYC)</li>
          <li>Material editable y certificado</li>
          <li>Acompañamiento posterior de 10 días</li>
        </ul>
        <div class="plan-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20el%20Plan%20Avanzado%20de%20capacitaci%C3%B3n%20SPLAFT%20Integral." class="btn-plan-cta" target="_blank">Solicitar información</a>
        </div>
      </div>
      <div class="plan-card reveal stagger-3">
        <div class="plan-tag">Integral</div>
        <h4>Programa Blindaje 360</h4>
        <p class="plan-desc">Diseño e implementación completa del sistema SPLAFT de su organización</p>
        <ul class="plan-features">
          <li>Todo lo incluido en el Plan Avanzado</li>
          <li>Manual SPLAFT personalizado</li>
          <li>Políticas DDC/KYC a medida</li>
          <li>Procedimiento interno de ROS y RO</li>
          <li>Programa de capacitación anual</li>
          <li>Asesoría continua al Oficial de Cumplimiento</li>
          <li>Auditoría interna del sistema</li>
          <li>Soporte de 30 días</li>
        </ul>
        <div class="plan-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20el%20Programa%20Blindaje%20360." class="btn-plan-cta" target="_blank">Solicitar información</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="director" id="director">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Dirección</h2>
    </div>
    <div class="director-box">
      <div class="director-photo reveal-left">
        <img src="{{ asset('images/imagen.png') }}" alt="Denis Gabriel Romani Seminario">
      </div>
      <div class="director-info reveal-right">
        <h3>Denis Gabriel Romani Seminario</h3>
        <div class="director-title">Abogado especialista en Compliance corporativo y ALA/CFT</div>
        <p class="director-bio">Máster en Derecho Penal por la Pontificia Universidad Católica del Perú (PUCP). Máster en Cumplimiento Normativo Penal por la Universidad de Castilla-La Mancha (UCLM), España. Más de 15 años de experiencia en investigación financiera, prevención LA/FT y compliance corporativo.</p>
        <div class="director-contact">
          <a href="mailto:denis@romanicompliance.com">denis@romanicompliance.com</a>
          <a href="mailto:dromani@pucp.pe">dromani@pucp.pe</a>
          <a href="https://www.denisromani.com" target="_blank">www.denisromani.com</a>
        </div>
        <div class="director-creds">
          <span class="cred-tag">PUCP</span>
          <span class="cred-tag">UCLM</span>
          <span class="cred-tag">ISO 37001:2021</span>
          <span class="cred-tag">Compliance Officer</span>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="blog" id="noticias">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Noticias y publicaciones</h2>
      <p>Análisis jurídico, novedades regulatorias y contenido de interés</p>
    </div>
    @if($recentArticles->isNotEmpty())
      <div class="article-grid">
        @foreach($recentArticles as $article)
          @include('blog._article-card', ['article' => $article])
        @endforeach
      </div>
    @else
      <div class="empty-state" style="text-align:center;padding:2rem;color:var(--slate);border:1px dashed var(--line);border-radius:6px;">Próximamente publicaremos nuestros primeros artículos.</div>
    @endif
    <div class="blog-more">
      <a href="{{ route('blog.index') }}" class="btn btn-ghost" style="border-color:var(--line);color:var(--ink);">Ver todas las publicaciones</a>
    </div>
  </div>
</section>

<section class="contact-section" id="contacto">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Contacto</h2>
      <p>Coordine una reunión o envíenos su consulta</p>
    </div>
    <div class="contact-layout">
      <div class="contact-info reveal-left">
        <h3>Romani Compliance</h3>
        <p>Contáctenos para coordinar una asesoría, solicitar una cotización o resolver cualquier consulta sobre nuestros servicios.</p>
        <div class="contact-detail">
          <span class="cd-label">Email</span>
          <a href="mailto:denis@romanicompliance.com">denis@romanicompliance.com</a>
        </div>
        <div class="contact-detail">
          <span class="cd-label">Email</span>
          <a href="mailto:dromani@pucp.pe">dromani@pucp.pe</a>
        </div>
        <div class="contact-detail">
          <span class="cd-label">Tel</span>
          <a href="https://wa.me/51969754983" target="_blank">+51 969 754 983</a>
        </div>
        <div class="contact-detail">
          <span class="cd-label">Web</span>
          <a href="https://www.denisromani.com" target="_blank">www.denisromani.com</a>
        </div>
      </div>
      <div class="reveal-right" id="contactFormWrap">
        <form class="contact-form" id="contactFormInline" onsubmit="return enviarFormulario(event, this, 'contactMsgInline')">
          <div class="form-row">
            <div>
              <label>Nombre completo</label>
              <input type="text" name="nombre" placeholder="Su nombre" required>
            </div>
            <div>
              <label>Teléfono</label>
              <input type="tel" name="telefono" placeholder="+51 ...">
            </div>
          </div>
          <div>
            <label>Correo electrónico</label>
            <input type="email" name="email" placeholder="correo@empresa.com" required>
          </div>
          <div>
            <label>Servicio de interés</label>
            <select name="servicio">
              <option value="Compliance corporativo">Compliance corporativo</option>
              <option value="Prevención LA/FT (SPLAFT)">Prevención LA/FT (SPLAFT)</option>
              <option value="Compliance Notarial">Compliance Notarial</option>
              <option value="Compliance Inmobiliario">Compliance Inmobiliario</option>
              <option value="Asesoría penal">Asesoría penal</option>
              <option value="Due Diligence">Due Diligence</option>
              <option value="Capacitación">Capacitación</option>
              <option value="Investigación financiera">Investigación financiera</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div>
            <label>Mensaje</label>
            <textarea name="mensaje" placeholder="Describa brevemente su consulta" rows="4"></textarea>
          </div>
          <button type="submit" class="btn-submit">Enviar consulta</button>
        </form>
        <div class="form-msg" id="contactMsgInline">Mensaje enviado correctamente. Nos pondremos en contacto a la brevedad.</div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
function irAContacto(servicio) {
  const seccion = document.getElementById('contacto');
  if (!seccion) return;
  seccion.scrollIntoView({ behavior: 'smooth', block: 'start' });
  const select = document.querySelector('#contactFormInline select[name="servicio"]');
  if (servicio && select) select.value = servicio;
  window.setTimeout(() => {
    const nombre = document.querySelector('#contactFormInline input[name="nombre"]');
    if (nombre) nombre.focus({ preventScroll: true });
  }, 500);
}

async function enviarFormulario(e, form, msgId) {
  e.preventDefault();
  const data = Object.fromEntries(new FormData(form));
  if (!data.nombre || !data.email) { alert('Complete nombre y correo.'); return false; }
  const body = `Consulta desde romanicompliance.com\n\nNombre: ${data.nombre}\nTeléfono: ${data.telefono || 'No indicado'}\nCorreo: ${data.email}\nServicio: ${data.servicio}\nMensaje: ${data.mensaje || 'Sin mensaje adicional'}`;
  try {
    await fetch('https://formsubmit.co/ajax/omaroliden1@gmail.com', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({
        name: data.nombre,
        email: data.email,
        message: body,
        _cc: 'dromani@pucp.pe',
        _subject: 'Consulta web · Romani Compliance'
      })
    });
    form.style.display = 'none';
    document.getElementById(msgId).style.display = 'block';
  } catch (err) {
    alert('Error al enviar. Intente por WhatsApp al +51 969 754 983.');
  }
  return false;
}
</script>
@endsection
