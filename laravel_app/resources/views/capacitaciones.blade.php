@extends('layouts.app')

@section('title', 'Capacitaciones — Romani Compliance')
@section('description', 'Programas de capacitación especializados en prevención LA/FT, compliance corporativo y gestión de riesgos para oficiales de cumplimiento y sujetos obligados.')

@section('styles')
.page-hero{background:var(--ink);padding:5rem 0 4.5rem;position:relative;overflow:hidden}
.page-hero::before{content:'';position:absolute;top:-40%;right:-15%;width:500px;height:500px;background:radial-gradient(circle,rgba(139,115,64,.06) 0%,transparent 70%);pointer-events:none}
.page-hero::after{content:'';position:absolute;bottom:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--gold),transparent)}
.hero-eyebrow{font-family:var(--sans);font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.18em;color:var(--gold-light);margin-bottom:1rem;display:flex;align-items:center;gap:12px}
.hero-eyebrow::before{content:'';width:32px;height:1px;background:var(--gold)}
.page-hero h1{font-size:clamp(1.8rem,4.5vw,3rem);color:var(--white);font-weight:400;line-height:1.15;margin-bottom:1rem;max-width:640px}
.page-hero h1 em{font-style:italic;color:var(--gold-light)}
.page-hero>div>p{font-size:.95rem;color:rgba(255,255,255,.45);max-width:520px;font-weight:300;line-height:1.7}

.counters{background:var(--white);border-bottom:1px solid var(--line);padding:3rem 0}
.counters-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:2rem;text-align:center}
.counter-item{position:relative}
.counter-item:not(:last-child)::after{content:'';position:absolute;right:0;top:15%;height:70%;width:1px;background:var(--line)}
.counter-num{font-family:var(--serif);font-size:clamp(2rem,4vw,3rem);font-weight:600;color:var(--ink);line-height:1;margin-bottom:.3rem}
.counter-num .plus{color:var(--gold)}
.counter-label{font-size:.75rem;color:var(--slate);font-weight:500;text-transform:uppercase;letter-spacing:.06em}

.audience-section{padding:5rem 0}
.audience-section.alt{background:var(--white)}
.audience-header{display:flex;align-items:flex-start;gap:2rem;margin-bottom:2.5rem}
.audience-tag{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--gold);background:var(--gold-pale);padding:6px 14px;border-radius:3px;white-space:nowrap;flex-shrink:0;margin-top:6px}
.audience-header h2{font-size:clamp(1.4rem,3vw,1.9rem);margin-bottom:.4rem}
.audience-header p{font-size:.88rem;color:var(--slate);line-height:1.7;max-width:600px}

.programs-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.5rem}
.program-card{background:var(--white);border:1px solid var(--line);border-radius:var(--radius);padding:2rem;transition:box-shadow .5s,transform .5s,border-color .5s;display:flex;flex-direction:column}
.audience-section.alt .program-card{background:var(--ivory)}
.program-card:hover{box-shadow:var(--shadow-m);transform:translateY(-4px);border-color:var(--gold)}
.program-num{font-family:var(--serif);font-size:1.6rem;font-weight:300;color:var(--line);margin-bottom:.8rem;line-height:1}
.program-card h4{font-size:1.1rem;margin-bottom:.4rem}
.program-card .program-duration{font-size:.7rem;color:var(--gold);font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.8rem}
.program-card p{font-size:.82rem;color:var(--slate);line-height:1.65;flex:1}
.program-topics{list-style:none;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--line)}
.program-topics li{font-size:.78rem;color:var(--slate);padding:4px 0;padding-left:16px;position:relative;line-height:1.5}
.program-topics li::before{content:'';position:absolute;left:0;top:10px;width:6px;height:6px;border-radius:50%;border:1.5px solid var(--gold)}
.program-cta{margin-top:1.2rem}
.program-cta a{font-size:.78rem;font-weight:600;color:var(--gold);display:inline-flex;align-items:center;gap:6px;transition:gap .2s}
.program-cta a:hover{gap:10px}

.methodology{padding:5rem 0;background:var(--ink)}
.methodology .section-header h2{color:var(--white)}
.methodology .section-header p{color:rgba(255,255,255,.45)}
.methodology .gold-line{background:var(--gold-light)}
.method-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem}
.method-step{position:relative;padding:1.5rem;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:var(--radius);transition:border-color .4s,background .4s}
.method-step:hover{border-color:var(--gold);background:rgba(255,255,255,.06)}
.method-step .step-num{font-family:var(--serif);font-size:2.4rem;font-weight:300;color:rgba(255,255,255,.08);line-height:1;margin-bottom:.8rem}
.method-step h4{font-family:var(--sans);font-size:.85rem;font-weight:600;color:var(--white);margin-bottom:.4rem}
.method-step p{font-size:.78rem;color:rgba(255,255,255,.45);line-height:1.6}

.cert-section{padding:4rem 0;background:var(--white);border-bottom:1px solid var(--line)}
.cert-content{display:flex;align-items:center;gap:3rem;max-width:800px;margin:0 auto}
.cert-badge-big{width:120px;height:120px;flex-shrink:0;border:2px solid var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-direction:column}
.cert-badge-big .cert-icon{font-family:var(--serif);font-size:2rem;color:var(--gold);line-height:1}
.cert-badge-big .cert-sub{font-size:.55rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:var(--gold);margin-top:4px}
.cert-text h3{font-size:1.3rem;margin-bottom:.5rem}
.cert-text p{font-size:.88rem;color:var(--slate);line-height:1.7}

.cta-strip{padding:4rem 0;background:var(--ivory);text-align:center}
.cta-strip h2{font-size:clamp(1.4rem,3vw,1.8rem);margin-bottom:.5rem}
.cta-strip>div>p{font-size:.88rem;color:var(--slate);margin-bottom:2rem;max-width:480px;margin-left:auto;margin-right:auto}
.cta-actions{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}

@media(max-width:900px){
  .counters-grid{grid-template-columns:repeat(2,1fr);gap:1.5rem}
  .counter-item:not(:last-child)::after{display:none}
  .programs-grid{grid-template-columns:1fr}
  .method-grid{grid-template-columns:1fr 1fr}
  .audience-header{flex-direction:column}
  .cert-content{flex-direction:column;text-align:center}
}
@media(max-width:680px){
  .method-grid{grid-template-columns:1fr}
  .counters-grid{grid-template-columns:1fr 1fr}
}
@endsection

@section('content')
<section class="page-hero">
  <div class="wrap">
    <div class="hero-eyebrow">Formación especializada</div>
    <h1>Capacitaciones en <em>compliance</em> y prevención LA/FT</h1>
    <p>Programas de formación diseñados para fortalecer la cultura de cumplimiento normativo en su organización, dirigidos por especialistas con experiencia regulatoria.</p>
  </div>
</section>

<section class="counters">
  <div class="wrap">
    <div class="counters-grid">
      <div class="counter-item reveal-scale s1">
        <div class="counter-num"><span class="count" data-target="129">0</span><span class="plus">+</span></div>
        <div class="counter-label">Capacitaciones brindadas</div>
      </div>
      <div class="counter-item reveal-scale s2">
        <div class="counter-num"><span class="count" data-target="45">0</span><span class="plus">+</span></div>
        <div class="counter-label">Empresas capacitadas</div>
      </div>
      <div class="counter-item reveal-scale s3">
        <div class="counter-num"><span class="count" data-target="1200">0</span><span class="plus">+</span></div>
        <div class="counter-label">Profesionales formados</div>
      </div>
      <div class="counter-item reveal-scale s4">
        <div class="counter-num"><span class="count" data-target="12">0</span></div>
        <div class="counter-label">Sectores económicos atendidos</div>
      </div>
    </div>
  </div>
</section>

<section class="audience-section" id="oficial">
  <div class="wrap">
    <div class="audience-header reveal">
      <span class="audience-tag">Oficial de Cumplimiento</span>
      <div>
        <h2>Capacitaciones para el Oficial de Cumplimiento</h2>
        <p>Programas enfocados en las funciones, responsabilidades legales y herramientas operativas que todo OC debe dominar para el cumplimiento efectivo de su rol.</p>
      </div>
    </div>
    <div class="programs-grid">
      <div class="program-card reveal s1">
        <div class="program-num">01</div>
        <h4>Funciones y responsabilidades del Oficial de Cumplimiento</h4>
        <div class="program-duration">4 horas</div>
        <p>Formación integral sobre el marco legal, requisitos de designación, inscripción ante la UIF-Perú y las responsabilidades administrativas y penales del Oficial de Cumplimiento.</p>
        <ul class="program-topics">
          <li>Designación, requisitos e inscripción ante la UIF</li>
          <li>Funciones legales y operativas del OC</li>
          <li>Régimen sancionador aplicable</li>
          <li>Responsabilidad penal y administrativa del OC</li>
          <li>Casos prácticos y análisis de resoluciones SBS</li>
        </ul>
        <div class="program-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20de%20Funciones%20del%20Oficial%20de%20Cumplimiento." target="_blank">Solicitar información &#8594;</a>
        </div>
      </div>
      <div class="program-card reveal s2">
        <div class="program-num">02</div>
        <h4>Diseño del Sistema de Prevención LA/FT</h4>
        <div class="program-duration">6 horas</div>
        <p>Capacitación práctica para que el OC elabore los documentos normativos exigidos por la UIF: Manual de Prevención, Código de Conducta, Matriz de Riesgos y políticas de DDC/KYC.</p>
        <ul class="program-topics">
          <li>Elaboración del Manual de Prevención SPLAFT</li>
          <li>Diseño del Código de Conducta institucional</li>
          <li>Construcción de la Matriz de Riesgos LA/FT</li>
          <li>Políticas de debida diligencia del cliente (DDC/KYC)</li>
          <li>Procedimiento de detección, análisis y reporte (ROS/RO)</li>
          <li>Entrega de plantillas editables</li>
        </ul>
        <div class="program-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20de%20Dise%C3%B1o%20del%20Sistema%20SPLAFT." target="_blank">Solicitar información &#8594;</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="audience-section alt" id="sujetos">
  <div class="wrap">
    <div class="audience-header reveal">
      <span class="audience-tag">Sujetos Obligados</span>
      <div>
        <h2>Capacitaciones para sujetos obligados</h2>
        <p>Programas dirigidos a empresas y entidades sujetas al régimen de prevención LA/FT, enfocados en el cumplimiento de sus obligaciones legales y la formación de sus colaboradores.</p>
      </div>
    </div>
    <div class="programs-grid">
      <div class="program-card reveal s1">
        <div class="program-num">03</div>
        <h4>Prevención LA/FT para colaboradores</h4>
        <div class="program-duration">2 horas</div>
        <p>Capacitación obligatoria para el personal operativo y directivo del sujeto obligado. Cubre el marco normativo, las señales de alerta, las tipologías del sector y el procedimiento interno de reporte.</p>
        <ul class="program-topics">
          <li>Marco normativo SPLAFT aplicable al sector</li>
          <li>Tipologías LA/FT específicas del giro de negocio</li>
          <li>Señales de alerta y detección de operaciones inusuales</li>
          <li>Obligaciones del personal frente al sistema de prevención</li>
          <li>Consecuencias legales del incumplimiento</li>
        </ul>
        <div class="program-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20de%20Prevenci%C3%B3n%20LA%2FFT%20para%20colaboradores." target="_blank">Solicitar información &#8594;</a>
        </div>
      </div>
      <div class="program-card reveal s2">
        <div class="program-num">04</div>
        <h4>Debida diligencia del cliente (DDC/KYC)</h4>
        <div class="program-duration">3 horas</div>
        <p>Formación especializada en los procedimientos de conocimiento del cliente, verificación de identidad, identificación del beneficiario final y monitoreo continuo de la relación comercial.</p>
        <ul class="program-topics">
          <li>DDC simplificada, estándar y reforzada</li>
          <li>Identificación del beneficiario final</li>
          <li>Personas expuestas políticamente (PEP)</li>
          <li>Listas restrictivas y herramientas de consulta</li>
          <li>Monitoreo transaccional y actualización de expedientes</li>
        </ul>
        <div class="program-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20en%20Debida%20Diligencia%20DDC%2FKYC." target="_blank">Solicitar información &#8594;</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="audience-section" id="transversales">
  <div class="wrap">
    <div class="audience-header reveal">
      <span class="audience-tag">Programas transversales</span>
      <div>
        <h2>Formación complementaria</h2>
        <p>Capacitaciones dirigidas a directorios, gerencias y equipos legales que necesitan comprender el alcance del compliance corporativo y su responsabilidad frente al marco regulatorio.</p>
      </div>
    </div>
    <div class="programs-grid">
      <div class="program-card reveal s1">
        <div class="program-num">05</div>
        <h4>Compliance corporativo y responsabilidad penal de la persona jurídica</h4>
        <div class="program-duration">3 horas</div>
        <p>Análisis de la Ley N.° 30424 y su reglamento. Diseño de modelos de prevención, responsabilidad del directorio y la alta gerencia, y criterios de exoneración de responsabilidad administrativa.</p>
        <ul class="program-topics">
          <li>Alcances de la Ley N.° 30424 y modificatorias</li>
          <li>Elementos del modelo de prevención</li>
          <li>Rol del encargado de prevención</li>
          <li>Autonomía e independencia del programa</li>
          <li>Criterios de exoneración y atenuación</li>
        </ul>
        <div class="program-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20en%20Compliance%20Corporativo%20y%20Ley%2030424." target="_blank">Solicitar información &#8594;</a>
        </div>
      </div>
      <div class="program-card reveal s2">
        <div class="program-num">06</div>
        <h4>Auditoría interna del sistema de prevención LA/FT</h4>
        <div class="program-duration">4 horas</div>
        <p>Metodología para evaluar la efectividad del sistema SPLAFT implementado: revisión documental, testeo de controles, identificación de brechas y elaboración del informe de auditoría.</p>
        <ul class="program-topics">
          <li>Planificación de la auditoría interna</li>
          <li>Evaluación del Manual, Código y Matriz de Riesgos</li>
          <li>Verificación de registros (RO) y reportes (ROS)</li>
          <li>Testeo de controles DDC/KYC</li>
          <li>Informe de hallazgos y plan de mejora</li>
        </ul>
        <div class="program-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20en%20Auditor%C3%ADa%20Interna%20SPLAFT." target="_blank">Solicitar información &#8594;</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="methodology">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Nuestra metodología</h2>
      <p>Un enfoque práctico orientado a resultados concretos para su organización</p>
    </div>
    <div class="method-grid">
      <div class="method-step reveal s1">
        <div class="step-num">01</div>
        <h4>Diagnóstico</h4>
        <p>Evaluamos el nivel de madurez del sistema de prevención y las necesidades específicas de capacitación de su equipo.</p>
      </div>
      <div class="method-step reveal s2">
        <div class="step-num">02</div>
        <h4>Personalización</h4>
        <p>Adaptamos el contenido al sector económico, modelo de negocio y perfil de riesgo de su organización.</p>
      </div>
      <div class="method-step reveal s3">
        <div class="step-num">03</div>
        <h4>Capacitación</h4>
        <p>Sesiones presenciales o virtuales con casos prácticos reales, material editable y evaluación de conocimientos.</p>
      </div>
      <div class="method-step reveal s4">
        <div class="step-num">04</div>
        <h4>Acompañamiento</h4>
        <p>Seguimiento posterior para resolver consultas, revisar implementación y asegurar el cumplimiento efectivo.</p>
      </div>
    </div>
  </div>
</section>

<section class="cert-section">
  <div class="wrap">
    <div class="cert-content reveal">
      <div class="cert-badge-big">
        <div class="cert-icon">RC</div>
        <div class="cert-sub">Certificado</div>
      </div>
      <div class="cert-text">
        <h3>Certificación incluida</h3>
        <p>Todos nuestros programas de capacitación incluyen certificado de participación emitido por Romani Compliance, con registro del temario impartido y las horas lectivas completadas. Documentación válida para acreditar ante la SBS y la UIF el cumplimiento de la obligación de capacitación periódica del sujeto obligado y su personal.</p>
      </div>
    </div>
  </div>
</section>

<section class="cta-strip">
  <div class="wrap reveal">
    <h2>Coordine su capacitación</h2>
    <p>Contáctenos para diseñar un programa adaptado a las necesidades de su organización.</p>
    <div class="cta-actions">
      <a href="https://wa.me/51969754983?text=Hola%2C%20deseo%20coordinar%20una%20capacitaci%C3%B3n%20con%20Romani%20Compliance." class="btn btn-gold" target="_blank">Escribir por WhatsApp</a>
      <a href="{{ route('home') }}#contacto" class="btn btn-ghost-dark">Formulario de contacto</a>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
const counterObs=new IntersectionObserver(entries=>{
  entries.forEach(entry=>{
    if(entry.isIntersecting){
      document.querySelectorAll('.count').forEach(counter=>{
        const target=+counter.dataset.target;
        const duration=1800;
        const start=performance.now();
        function update(now){
          const elapsed=now-start;
          const progress=Math.min(elapsed/duration,1);
          const ease=1-Math.pow(1-progress,3);
          counter.textContent=Math.floor(ease*target);
          if(progress<1)requestAnimationFrame(update);
          else counter.textContent=target;
        }
        requestAnimationFrame(update);
      });
      counterObs.unobserve(entry.target);
    }
  });
},{threshold:.3});
const countersEl=document.querySelector('.counters');
if(countersEl)counterObs.observe(countersEl);
</script>
@endsection
