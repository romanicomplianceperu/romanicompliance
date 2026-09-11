@extends('layouts.app')

@section('title', 'Convocatoria de Pasantías — Romani Compliance')
@section('description', 'Postula al programa de pasantías de Romani Compliance: aprende compliance, ALA/CFT y derecho penal con casos reales y mentoría directa de nuestro equipo.')

@section('styles')
.cv-hero { background: linear-gradient(150deg, var(--ink) 0%, #16283F 55%, #1D3452 100%); padding: 4.5rem 0 4rem; position: relative; overflow: hidden; }
.cv-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
.cv-hero-badge { display: inline-flex; align-items: center; gap: 8px; font-family: var(--sans); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.14em; color: var(--ink); background: linear-gradient(135deg, var(--gold-light), var(--gold)); padding: 6px 16px; border-radius: 20px; margin-bottom: 1.4rem; }
.cv-hero h1 { font-family: var(--serif); font-size: clamp(1.9rem, 4.4vw, 3rem); color: var(--white); font-weight: 600; line-height: 1.2; margin-bottom: 1.1rem; max-width: 720px; }
.cv-hero p { font-size: 1rem; color: rgba(255,255,255,0.68); max-width: 600px; line-height: 1.75; margin-bottom: 2rem; }
.cv-hero-ctas { display: flex; gap: 14px; flex-wrap: wrap; }
.cv-btn-gold { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--ink); font-family: var(--sans); font-weight: 700; font-size: 0.88rem; padding: 14px 30px; border-radius: 8px; text-decoration: none; transition: transform 0.2s ease, box-shadow 0.2s ease; }
.cv-btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 26px rgba(201,169,97,0.3); }
.cv-btn-ghost { display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.85); font-family: var(--sans); font-weight: 600; font-size: 0.85rem; padding: 14px 8px; text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.25); }

.cv-section { padding: 4.5rem 0; }
.cv-section.alt { background: var(--ivory); }

.cv-benefits-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.6rem; }
.cv-benefit-card { background: var(--white); border: 1px solid var(--line); border-radius: 14px; padding: 1.8rem 1.6rem; transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; }
.cv-benefit-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-m); border-color: var(--gold); }
.cv-benefit-icon { width: 46px; height: 46px; border-radius: 12px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; font-size: 1.3rem; }
.cv-benefit-card h4 { font-size: 1rem; margin-bottom: 0.5rem; color: var(--ink); }
.cv-benefit-card p { font-size: 0.85rem; color: var(--slate); line-height: 1.65; }

.cv-team-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.8rem; }
.cv-team-card { display: flex; gap: 1.4rem; align-items: flex-start; background: var(--white); border: 1px solid var(--line); border-radius: 14px; padding: 1.8rem; transition: box-shadow 0.3s ease, transform 0.3s ease, border-color 0.3s ease; }
.cv-team-card:hover { box-shadow: var(--shadow-m); transform: translateY(-4px); border-color: var(--gold); }
.cv-team-photo { width: 84px; height: 84px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 2px solid var(--line); background: var(--ivory-dim); }
.cv-team-photo img { width: 100%; height: 100%; object-fit: cover; }
.cv-team-card h4 { font-size: 1.02rem; margin-bottom: 2px; color: var(--ink); }
.cv-team-role { font-size: 0.76rem; color: var(--gold); font-weight: 600; margin-bottom: 0.6rem; }
.cv-team-desc { font-size: 0.8rem; color: var(--slate); line-height: 1.6; }

.cv-functions-list { display: grid; grid-template-columns: 1fr 1fr; gap: 0.9rem 2rem; max-width: 900px; }
.cv-functions-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 0.88rem; color: var(--ink); line-height: 1.55; }
.cv-functions-list li .num { flex-shrink: 0; width: 24px; height: 24px; border-radius: 50%; background: var(--gold-pale); color: var(--gold); font-size: 0.72rem; font-weight: 700; display: flex; align-items: center; justify-content: center; }

.cv-cert-strip { background: linear-gradient(135deg, #16283F, var(--ink)); border-radius: 18px; padding: 2.6rem 2.4rem; display: flex; align-items: center; gap: 2.2rem; }
.cv-cert-icon { width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--ink); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; flex-shrink: 0; }
.cv-cert-strip h3 { font-family: var(--serif); color: var(--white); font-size: 1.3rem; margin-bottom: 0.5rem; }
.cv-cert-strip p { color: rgba(255,255,255,0.68); font-size: 0.88rem; line-height: 1.6; margin: 0; }

.cv-final-cta { padding: 4.5rem 0; background: var(--ink); text-align: center; }
.cv-final-cta h2 { font-family: var(--serif); font-size: clamp(1.5rem, 3.2vw, 2rem); color: var(--white); margin-bottom: 0.7rem; }
.cv-final-cta p { color: rgba(255,255,255,0.55); font-size: 0.9rem; margin-bottom: 2rem; max-width: 480px; margin-left: auto; margin-right: auto; }

@media (max-width: 900px) {
  .cv-benefits-grid { grid-template-columns: 1fr 1fr; }
  .cv-team-grid { grid-template-columns: 1fr; }
  .cv-functions-list { grid-template-columns: 1fr; }
  .cv-cert-strip { flex-direction: column; text-align: center; }
}
@media (max-width: 560px) {
  .cv-benefits-grid { grid-template-columns: 1fr; }
}
@endsection

@section('content')
<section class="cv-hero">
  <div class="wrap">
    <div class="cv-hero-badge">{{ $applicationsOpen ? 'Convocatoria abierta · Cierra el '.$deadlineLabel : 'Convocatoria cerrada' }}</div>
    <h1>¿Te gustaría formar parte del equipo de Romani Compliance?</h1>
    <p>Buscamos estudiantes de derecho para realizar una pasantía en nuestro estudio: acompañarás casos reales de compliance corporativo, prevención de lavado de activos y derecho penal, con mentoría directa de nuestro equipo de abogados.</p>
    <div class="cv-hero-ctas">
      @if($applicationsOpen)
        <a href="{{ route('academico.convocatoria.form') }}" class="cv-btn-gold">Quiero postular →</a>
      @else
        <span class="cv-btn-gold" style="opacity:0.5;cursor:not-allowed;">Convocatoria cerrada</span>
      @endif
      <a href="{{ route('academico.index') }}" class="cv-btn-ghost">Volver a Académico</a>
    </div>
  </div>
</section>

<section class="cv-section">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Lo que ganas en tu pasantía con nosotros</h2>
      <p>Un programa de pasantías pensado para dejarte experiencia real, no solo horas firmadas.</p>
    </div>
    <div class="cv-benefits-grid">
      <div class="cv-benefit-card reveal stagger-1">
        <div class="cv-benefit-icon">⚖️</div>
        <h4>Aprendizaje en SPLAFT</h4>
        <p>Elaborarás documentación especializada, matrices de riesgo y análisis de normativa de la SBS, además de apoyar procesos de Due Diligence, con clientes y casos reales.</p>
      </div>
      <div class="cv-benefit-card reveal stagger-2">
        <div class="cv-benefit-icon">🎓</div>
        <h4>Mentoría directa</h4>
        <p>Acompañamiento cercano del equipo de abogados de Romani Compliance en cada tarea que asumas, en calidad de pasante en asistencia legal.</p>
      </div>
      <div class="cv-benefit-card reveal stagger-3">
        <div class="cv-benefit-icon">📜</div>
        <h4>Certificación verificable</h4>
        <p>Certificados por horas de pasantía, en papel membretado y versión digital con código QR verificable.</p>
      </div>
      <div class="cv-benefit-card reveal stagger-1">
        <div class="cv-benefit-icon">📚</div>
        <h4>Acceso a cursos</h4>
        <p>Cursos propios de Romani Compliance y cursos externos, para seguir formándote mientras haces tu pasantía.</p>
      </div>
      <div class="cv-benefit-card reveal stagger-2">
        <div class="cv-benefit-icon">📈</div>
        <h4>Crecimiento dentro del estudio</h4>
        <p>Posibilidad real de asumir mayores responsabilidades con el tiempo, dentro del estudio jurídico.</p>
      </div>
      <div class="cv-benefit-card reveal stagger-3">
        <div class="cv-benefit-icon">🤝</div>
        <h4>Posibilidad de contratación</h4>
        <p>Los mejores pasantes tienen la puerta abierta a continuar como colaboradores del estudio al finalizar su pasantía.</p>
      </div>
    </div>
  </div>
</section>

@if($team->isNotEmpty())
<section class="cv-section alt">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Aprenderás directamente de</h2>
      <p>Participarás en calidad de pasante en asistencia legal, con acompañamiento directo de nuestro equipo.</p>
    </div>
    <div class="cv-team-grid">
      @foreach($team as $member)
        <div class="cv-team-card reveal stagger-{{ $loop->iteration }}">
          <div class="cv-team-photo">
            <img src="{{ $member->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $member->name }}">
          </div>
          <div>
            <h4>{{ $member->name }}</h4>
            <div class="cv-team-role">{{ $member->title }}</div>
            <p class="cv-team-desc">{{ \Illuminate\Support\Str::limit($member->bio, 170) }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="cv-section">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Tus funciones como pasante</h2>
      <p>Estas son algunas de las tareas en las que apoyarás, según el área en la que te desempeñes.</p>
    </div>
    <ul class="cv-functions-list">
      <li class="reveal"><span class="num">1</span> Apoyo en la elaboración y revisión de documentos legales</li>
      <li class="reveal"><span class="num">2</span> Comparación y análisis de normativa aplicable</li>
      <li class="reveal"><span class="num">3</span> Envío y seguimiento de borradores de informes</li>
      <li class="reveal"><span class="num">4</span> Elaboración de memorias y ayudas memoria</li>
      <li class="reveal"><span class="num">5</span> Organización y ordenamiento de expedientes</li>
      <li class="reveal"><span class="num">6</span> Apoyo en la revisión de carpetas fiscales sobre lavado de activos y delitos conexos, para la defensa</li>
      <li class="reveal"><span class="num">7</span> Apoyo en representación legal en procesos de lavado de activos</li>
      <li class="reveal"><span class="num">8</span> Apoyo en la elaboración de matrices de riesgo y manuales de prevención LA/FT</li>
    </ul>
  </div>
</section>

<section class="cv-section alt">
  <div class="wrap">
    <div class="cv-cert-strip reveal">
      <div class="cv-cert-icon">🔗</div>
      <div>
        <h3>Certificado con QR verificable</h3>
        <p>Al finalizar tus horas de pasantía recibes un certificado en papel membretado con carta de recomendación, además de su versión digital con un código QR verificable que valida su autenticidad.</p>
      </div>
    </div>
  </div>
</section>

<section class="cv-final-cta">
  <div class="wrap reveal">
    @if($applicationsOpen)
      <h2>¿Listo para postular?</h2>
      <p>El formulario te toma solo unos minutos. Cuéntanos sobre ti y nos pondremos en contacto contigo por WhatsApp. Postulaciones abiertas hasta el {{ $deadlineLabel }}.</p>
      <a href="{{ route('academico.convocatoria.form') }}" class="cv-btn-gold">Quiero inscribirme →</a>
    @else
      <h2>La convocatoria ha finalizado</h2>
      <p>Cerramos la recepción de postulaciones el {{ $deadlineLabel }}. Gracias por tu interés — mantente atento a nuestras próximas convocatorias.</p>
    @endif
  </div>
</section>
@endsection
