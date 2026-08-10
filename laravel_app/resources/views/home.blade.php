@extends('layouts.app')

@section('title', 'Romani Compliance — Compliance · ALA/CFT · Due Diligence')
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
.service-card { background: var(--white); padding: 2rem; border-radius: var(--radius); border: 1px solid var(--line); transition: box-shadow 0.4s, border-color 0.4s, transform 0.4s; }
.service-card:hover { box-shadow: var(--shadow-m); border-color: var(--gold); transform: translateY(-4px); }
.service-num { font-family: var(--serif); font-size: 2rem; font-weight: 300; color: var(--line); line-height: 1; margin-bottom: 1rem; }
.service-card h4 { font-size: 1.1rem; margin-bottom: 0.5rem; }
.service-card p { font-size: 0.82rem; color: var(--slate); line-height: 1.65; margin-bottom: 1.2rem; }
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

/* ── MODAL (overlay/box shared in layouts/app.blade.php) ── */
.modal-form { display: flex; flex-direction: column; gap: 12px; }
.modal-form .mf-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.modal-form label { font-size: 0.7rem; font-weight: 600; color: var(--slate); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 3px; display: block; }
.modal-form input, .modal-form textarea, .modal-form select { width: 100%; padding: 10px 12px; border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.85rem; color: var(--ink); transition: border-color 0.3s; }
.modal-form input:focus, .modal-form textarea:focus, .modal-form select:focus { outline: none; border-color: var(--gold); }
.modal-form input::placeholder, .modal-form textarea::placeholder { color: var(--slate-light); }
.modal-form textarea { resize: vertical; min-height: 70px; }
.modal-submit { padding: 12px; background: var(--ink); color: var(--white); border: none; border-radius: var(--radius); font-family: var(--sans); font-size: 0.82rem; font-weight: 600; cursor: pointer; transition: background 0.3s; margin-top: 4px; }
.modal-submit:hover { background: var(--ink-light); }
.modal-msg { display: none; text-align: center; padding: 2rem 1rem; }
.modal-msg h4 { font-size: 1.2rem; color: var(--ink); margin-bottom: 0.5rem; }
.modal-msg p { font-size: 0.85rem; color: var(--slate); }

@media (max-width: 900px) {
  .services-grid, .plans-grid, .blog .article-grid, .courses-online-grid { grid-template-columns: 1fr; max-width: 480px; margin-left: auto; margin-right: auto; }
  .about-grid { grid-template-columns: 1fr; gap: 2rem; }
  .about-divider { display: none; }
  .director-box { flex-direction: column; align-items: center; text-align: center; }
  .director-contact { justify-content: center; }
  .director-creds { justify-content: center; }
  .contact-layout { grid-template-columns: 1fr; }
  .form-row, .mf-row { grid-template-columns: 1fr !important; }
  .hero { padding: 4rem 0 3.5rem; }
}
@endsection

@section('content')
<section class="hero">
  <div class="wrap">
    <div class="hero-content">
      <div class="hero-eyebrow">Compliance · ALA/CFT · Due Diligence</div>
      <h1>Protegemos su organización con <em>estrategia legal</em> y cumplimiento normativo</h1>
      <p class="hero-sub">Asesoría especializada en compliance corporativo, prevención de lavado de activos, derecho penal y due diligence para empresas que operan bajo estándares rigurosos.</p>
      <div class="hero-actions">
        <button class="btn btn-gold" onclick="abrirModal()">Solicitar asesoría</button>
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
        <p>Brindar asesoría jurídica especializada y de alto nivel en materia de cumplimiento normativo, prevención de lavado de activos y financiamiento del terrorismo, y derecho penal, acompañando a las organizaciones en el diseño, implementación y fortalecimiento de sus sistemas de prevención conforme a las exigencias regulatorias nacionales e internacionales.</p>
      </div>
      <div class="about-divider"></div>
      <div class="about-block reveal-right">
        <h3>Nuestra <span>visión</span></h3>
        <p>Ser el referente peruano en consultoría de compliance corporativo y ALA/CFT, reconocido por la rigurosidad técnica de nuestro equipo, la calidad de nuestros entregables y el compromiso con la cultura de cumplimiento de cada organización que acompañamos.</p>
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
        <div class="service-num">01</div>
        <h4>Compliance corporativo</h4>
        <p>Diseño e implementación de modelos de prevención conforme a la Ley N.° 30424. Programas de cumplimiento que protegen a su organización frente a la responsabilidad penal de la persona jurídica.</p>
        <a href="javascript:void(0)" onclick="abrirModal()" class="service-link">Consultar</a>
      </div>
      <div class="service-card reveal stagger-2">
        <div class="service-num">02</div>
        <h4>Prevención LA/FT</h4>
        <p>Asesoría integral en el Sistema de Prevención de Lavado de Activos y Financiamiento del Terrorismo. Manuales, matrices de riesgo, políticas DDC/KYC y capacitación al Oficial de Cumplimiento.</p>
        <a href="javascript:void(0)" onclick="abrirModal()" class="service-link">Consultar</a>
      </div>
      <div class="service-card reveal stagger-3">
        <div class="service-num">03</div>
        <h4>Asesoría penal</h4>
        <p>Asesoría personalizada en derecho penal para personas naturales y jurídicas. Defensa técnica, estrategia procesal y acompañamiento integral en todas las etapas del proceso penal.</p>
        <a href="javascript:void(0)" onclick="abrirModal()" class="service-link">Consultar</a>
      </div>
      <div class="service-card reveal stagger-4">
        <div class="service-num">04</div>
        <h4>Due Diligence</h4>
        <p>Investigaciones de debida diligencia sobre personas naturales y jurídicas. Verificación de antecedentes, análisis patrimonial y evaluación de riesgos reputacionales para operaciones corporativas.</p>
        <a href="javascript:void(0)" onclick="abrirModal()" class="service-link">Consultar</a>
      </div>
      <div class="service-card reveal stagger-5">
        <div class="service-num">05</div>
        <h4>Capacitaciones</h4>
        <p>Programas de formación especializados en prevención LA/FT, compliance corporativo y gestión de riesgos. Certificaciones para sujetos obligados, oficiales de cumplimiento y colaboradores.</p>
        <a href="{{ route('capacitaciones') }}" class="service-link">Ver programas</a>
      </div>
      <div class="service-card reveal stagger-6">
        <div class="service-num">06</div>
        <h4>Investigación financiera</h4>
        <p>Análisis de operaciones sospechosas, rastreo de flujos financieros y elaboración de informes técnicos para procedimientos regulatorios, administrativos y judiciales.</p>
        <a href="javascript:void(0)" onclick="abrirModal()" class="service-link">Consultar</a>
      </div>
    </div>
  </div>
</section>

@if($featuredCourses->isNotEmpty())
<section class="courses-online" id="cursos-online">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Cursos y capacitaciones online</h2>
      <p>Explore nuestro catálogo de cursos y avance a su propio ritmo. Cree una cuenta gratuita para inscribirse.</p>
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
            <div style="margin-bottom:0.6rem;">@include('courses._certificate-badge')</div>
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

<div class="modal-overlay" id="modalAsesoria">
  <div class="modal-backdrop" onclick="cerrarModal()"></div>
  <div class="modal-box">
    <button class="modal-close" onclick="cerrarModal()">&times;</button>
    <div id="modalFormContent">
      <h3>Solicitar asesoría</h3>
      <p class="modal-sub">Complete el formulario y nos pondremos en contacto con usted a la brevedad.</p>
      <form class="modal-form" onsubmit="return enviarFormulario(event, this, 'modalMsgOk')">
        <div class="mf-row">
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
            <option value="Asesoría penal">Asesoría penal</option>
            <option value="Due Diligence">Due Diligence</option>
            <option value="Capacitación">Capacitación</option>
            <option value="Investigación financiera">Investigación financiera</option>
            <option value="Otro">Otro</option>
          </select>
        </div>
        <div>
          <label>Mensaje</label>
          <textarea name="mensaje" placeholder="Describa brevemente su consulta o necesidad" rows="3"></textarea>
        </div>
        <button type="submit" class="modal-submit">Enviar solicitud</button>
      </form>
    </div>
    <div class="modal-msg" id="modalMsgOk">
      <h4>Solicitud enviada</h4>
      <p>Nos pondremos en contacto con usted a la brevedad. Gracias por confiar en Romani Compliance.</p>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function abrirModal() {
  document.getElementById('modalAsesoria').classList.add('active');
  document.body.style.overflow = 'hidden';
}
function cerrarModal() {
  document.getElementById('modalAsesoria').classList.remove('active');
  document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });

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
        _subject: 'Consulta web — Romani Compliance'
      })
    });
    form.style.display = 'none';
    if (document.getElementById('modalFormContent') && msgId === 'modalMsgOk') {
      document.querySelector('.modal-sub').style.display = 'none';
      document.querySelector('.modal-box h3').style.display = 'none';
    }
    document.getElementById(msgId).style.display = 'block';
  } catch (err) {
    alert('Error al enviar. Intente por WhatsApp al +51 969 754 983.');
  }
  return false;
}
</script>
@endsection
