@extends('layouts.app')

@section('title', 'Nuestro Equipo — Romani Compliance')
@section('description', 'Conozca al equipo de Romani Compliance: profesionales especializados en compliance corporativo, prevención LA/FT, derecho penal y due diligence.')

@section('styles')
.page-hero { background: var(--ink); padding: 4rem 0 3.5rem; position: relative; }
.page-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
.page-hero .hero-eyebrow { font-family: var(--sans); font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.18em; color: var(--gold-light); margin-bottom: 1rem; display: flex; align-items: center; gap: 12px; }
.page-hero .hero-eyebrow::before { content: ''; width: 32px; height: 1px; background: var(--gold); }
.page-hero h1 { font-size: clamp(1.8rem, 4vw, 2.8rem); color: var(--white); font-weight: 400; line-height: 1.15; margin-bottom: 1rem; }
.page-hero p { font-size: 0.95rem; color: rgba(255,255,255,0.45); max-width: 540px; font-weight: 300; line-height: 1.7; }

.team-lead-section { padding: 5rem 0; background: var(--white); }
.team-lead { display: flex; gap: 3rem; align-items: flex-start; }
.team-photo { width: 200px; height: 200px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 3px solid var(--ivory-dim); box-shadow: var(--shadow-m); }
.team-photo img { width: 100%; height: 100%; object-fit: cover; }
.team-info h3 { font-size: 1.7rem; margin-bottom: 2px; }
.team-role { font-size: 0.85rem; color: var(--gold); font-weight: 600; margin-bottom: 1.2rem; }
.team-bio { font-size: 0.9rem; color: var(--slate); line-height: 1.8; margin-bottom: 1.2rem; }
.team-contact { display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.2rem; }
.team-contact a { font-size: 0.78rem; color: var(--slate); transition: color 0.2s; }
.team-contact a:hover { color: var(--gold); }
.team-creds { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 1.2rem; }
.cred-tag { font-size: 0.65rem; font-weight: 600; padding: 4px 10px; background: var(--gold-pale); color: var(--gold); border-radius: 3px; letter-spacing: 0.02em; }

.btn-linkedin { display: inline-flex; align-items: center; gap: 8px; padding: 8px 18px; background: var(--li-blue); color: var(--white); font-family: var(--sans); font-size: 0.75rem; font-weight: 600; border-radius: var(--radius); transition: background 0.3s, transform 0.3s, box-shadow 0.3s; }
.btn-linkedin:hover { background: #004182; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(10,102,194,0.3); }
.btn-linkedin svg { width: 16px; height: 16px; fill: currentColor; flex-shrink: 0; }

.team-associates { padding: 5rem 0; background: var(--ivory); }
.team-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; }
.team-card { display: flex; gap: 1.8rem; align-items: flex-start; padding: 2.2rem; background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); transition: box-shadow 0.5s, transform 0.5s, border-color 0.5s; }
.team-card:hover { box-shadow: var(--shadow-m); transform: translateY(-4px); border-color: var(--gold); }
.tc-photo { width: 110px; height: 110px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 2px solid var(--line); box-shadow: var(--shadow-s); }
.tc-photo img { width: 100%; height: 100%; object-fit: cover; }
.tc-body h4 { font-size: 1.1rem; margin-bottom: 2px; }
.tc-role { font-size: 0.78rem; color: var(--gold); font-weight: 600; margin-bottom: 0.7rem; }
.tc-desc { font-size: 0.82rem; color: var(--slate); line-height: 1.65; margin-bottom: 1rem; }
.tc-links { display: flex; flex-wrap: wrap; align-items: center; gap: 1rem; }
.tc-links .tc-email { font-size: 0.75rem; color: var(--slate-light); transition: color 0.2s; }
.tc-links .tc-email:hover { color: var(--gold); }

.values-section { padding: 5rem 0; background: var(--white); border-top: 1px solid var(--line); }
.values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
.value-card { padding: 1.5rem; }
.value-card h4 { font-size: 1.05rem; margin-bottom: 0.5rem; }
.value-card p { font-size: 0.82rem; color: var(--slate); line-height: 1.65; }
.value-num { font-family: var(--serif); font-size: 2rem; font-weight: 300; color: var(--line); line-height: 1; margin-bottom: 0.8rem; }

.cta-strip { padding: 4rem 0; background: var(--ink); text-align: center; }
.cta-strip h2 { font-size: clamp(1.4rem, 3vw, 1.8rem); color: var(--white); margin-bottom: 0.5rem; }
.cta-strip p { font-size: 0.88rem; color: rgba(255,255,255,0.45); margin-bottom: 2rem; max-width: 480px; margin-left: auto; margin-right: auto; }
.btn-gold-cta { background: var(--gold); color: var(--white); display: inline-flex; align-items: center; gap: 8px; padding: 13px 30px; font-family: var(--sans); font-size: 0.82rem; font-weight: 600; border-radius: var(--radius); border: none; cursor: pointer; transition: all 0.3s; text-decoration: none; }
.btn-gold-cta:hover { background: var(--gold-light); transform: translateY(-1px); }

@media (max-width: 900px) {
  .team-lead { flex-direction: column; align-items: center; text-align: center; }
  .team-contact { justify-content: center; }
  .team-creds { justify-content: center; }
  .team-grid { grid-template-columns: 1fr; }
  .team-card { flex-direction: column; align-items: center; text-align: center; }
  .tc-links { justify-content: center; }
  .values-grid { grid-template-columns: 1fr; }
}
@endsection

@section('content')
<section class="page-hero">
  <div class="wrap">
    <div class="hero-eyebrow">Romani Compliance</div>
    <h1>Nuestro equipo</h1>
    <p>Profesionales comprometidos con la excelencia en el cumplimiento normativo, la prevención del lavado de activos y la asesoría penal especializada.</p>
  </div>
</section>

@if($director)
<section class="team-lead-section">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Dirección</h2>
    </div>
    <div class="team-lead">
      <div class="team-photo reveal-left">
        <img src="{{ $director->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $director->name }}">
      </div>
      <div class="team-info reveal-right">
        <h3><a href="{{ route('blog.author', $director) }}" style="color:inherit">{{ $director->name }}</a></h3>
        <div class="team-role">{{ $director->title }}</div>
        @foreach(explode("\n\n", $director->bio ?? '') as $paragraph)
          <p class="team-bio">{{ $paragraph }}</p>
        @endforeach
        <div class="team-contact">
          <a href="mailto:{{ $director->email }}">{{ $director->email }}</a>
        </div>
        @if($director->credentialsList())
          <div class="team-creds">
            @foreach($director->credentialsList() as $cred)
              <span class="cred-tag">{{ $cred }}</span>
            @endforeach
          </div>
        @endif
        <div style="margin-top:1rem;display:flex;gap:10px;flex-wrap:wrap;">
          @if($director->linkedin_url)
            <a href="{{ $director->linkedin_url }}" target="_blank" class="btn-linkedin">
              <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
              Ver perfil en LinkedIn
            </a>
          @endif
          <a href="{{ route('blog.author', $director) }}" class="btn-linkedin" style="background:var(--gold);">Ver artículos publicados</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

@if($associates->isNotEmpty())
<section class="team-associates">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Equipo legal</h2>
      <p>Nuestros asistentes contribuyen al desarrollo de cada proyecto con rigor y dedicación</p>
    </div>
    <div class="team-grid">
      @foreach($associates as $member)
        <div class="team-card reveal stagger-{{ $loop->iteration }}">
          <div class="tc-photo">
            <img src="{{ $member->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $member->name }}">
          </div>
          <div class="tc-body">
            <h4><a href="{{ route('blog.author', $member) }}" style="color:inherit">{{ $member->name }}</a></h4>
            <div class="tc-role">{{ $member->title }}</div>
            <p class="tc-desc">{{ $member->bio }}</p>
            <div class="tc-links">
              <a href="mailto:{{ $member->email }}" class="tc-email">{{ $member->email }}</a>
              @if($member->linkedin_url)
                <a href="{{ $member->linkedin_url }}" target="_blank" class="btn-linkedin">
                  <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                  LinkedIn
                </a>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="values-section">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Nuestros valores</h2>
    </div>
    <div class="values-grid">
      <div class="value-card reveal stagger-1">
        <div class="value-num">I</div>
        <h4>Rigurosidad técnica</h4>
        <p>Cada análisis, informe y recomendación se fundamenta en un estudio exhaustivo de la normativa vigente y las mejores prácticas internacionales en materia de compliance.</p>
      </div>
      <div class="value-card reveal stagger-2">
        <div class="value-num">II</div>
        <h4>Confidencialidad</h4>
        <p>La información de nuestros clientes es tratada con el más alto estándar de reserva y protección, garantizando la confianza que depositan en nuestro equipo.</p>
      </div>
      <div class="value-card reveal stagger-3">
        <div class="value-num">III</div>
        <h4>Compromiso con el resultado</h4>
        <p>Trabajamos con orientación al cumplimiento efectivo de los objetivos de cada cliente, acompañándolo desde el diagnóstico hasta la implementación y seguimiento.</p>
      </div>
    </div>
  </div>
</section>

<section class="cta-strip">
  <div class="wrap reveal">
    <h2>Trabajemos juntos</h2>
    <p>Contáctenos para coordinar una asesoría o conocer cómo podemos fortalecer el cumplimiento normativo de su organización.</p>
    <a href="{{ route('home') }}#contacto" class="btn-gold-cta">Contactar al equipo</a>
  </div>
</section>
@endsection
