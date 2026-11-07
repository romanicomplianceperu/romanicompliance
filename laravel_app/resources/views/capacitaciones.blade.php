@extends('layouts.site')

@section('title', 'Capacitaciones · Romani Compliance')
@section('description', 'Programas de capacitación especializados en prevención LA/FT, compliance corporativo y gestión de riesgos para oficiales de cumplimiento y sujetos obligados.')

@section('styles')
.cp-hero { background: var(--ink); color: #fff; padding: clamp(44px, 6vw, 80px) 0 clamp(40px, 5vw, 64px); }
.cp-hero h1 { max-width: 820px; }
.cp-hero h1 em { font-style: normal; color: var(--blue-l); }
.cp-hero .lead { color: rgba(255,255,255,.72); margin: 20px 0 28px; max-width: 640px; }
.cp-hero .acts { display: flex; gap: 12px; flex-wrap: wrap; }
.cp-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: clamp(32px, 4.5vw, 52px); max-width: 980px; }
.cp-stats div { border-top: 1px solid rgba(255,255,255,.18); padding-top: 18px; }
.cp-stats b { display: block; font-size: clamp(1.8rem, 3.2vw, 2.5rem); font-weight: 800; letter-spacing: -0.04em; line-height: 1; }
.cp-stats span { display: block; color: rgba(255,255,255,.65); font-size: .92rem; margin-top: 8px; }
@media (max-width: 720px) { .cp-stats { grid-template-columns: 1fr 1fr; gap: 10px; } .cp-stats div { border: 1px solid rgba(255,255,255,.12); border-radius: 16px; padding: 14px; background: rgba(255,255,255,.05); } .cp-hero .acts .b { flex: 1 1 100%; justify-content: center; } }
.cp-tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 28px; }
.cp-tab { display: inline-flex; align-items: center; gap: 10px; padding: 10px 16px 10px 10px; border-radius: 999px; border: 1px solid var(--line); background: #fff; font: inherit; font-weight: 700; color: var(--muted); cursor: pointer; transition: all .25s; }
.cp-tab .ti { width: 32px; height: 32px; border-radius: 50%; background: var(--soft); display: grid; place-items: center; }
.cp-tab .ti .ic { width: 17px; height: 17px; }
.cp-tab[aria-selected="true"] { color: var(--ink); border-color: var(--ink); }
.cp-tab[aria-selected="true"] .ti { background: var(--blue); color: #fff; }
@media (max-width: 720px) { .cp-tabs { flex-wrap: nowrap; overflow-x: auto; margin: 0 -20px 22px; padding: 0 20px 4px; scrollbar-width: none; } .cp-tabs::-webkit-scrollbar { display: none; } .cp-tab { flex: 0 0 auto; } }
.cp-pane { animation: paneIn .45s var(--ease); }
.cp-intro { max-width: 720px; margin-bottom: 22px; }
.cp-intro h3 { font-size: clamp(1.4rem, 2.4vw, 1.9rem); font-weight: 800; letter-spacing: -0.025em; line-height: 1.2; }
.cp-intro p { color: var(--muted); margin-top: 8px; }
.cp-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
@media (max-width: 860px) { .cp-grid { grid-template-columns: 1fr; } }
.cp-card { border: 1px solid var(--line); border-radius: 24px; background: #fff; padding: clamp(22px, 3vw, 32px); display: flex; flex-direction: column; gap: 14px; transition: border-color .3s, box-shadow .3s, transform .35s var(--ease); }
.cp-card:hover { border-color: var(--blue); box-shadow: 0 20px 44px -30px rgba(10,23,48,.45); transform: translateY(-3px); }
.cp-dur { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 999px; background: var(--blue-50); color: var(--blue); font-weight: 700; font-size: .86rem; }
.cp-dur .ic { width: 16px; height: 16px; }
.cp-card h3 { font-size: 1.3rem; font-weight: 800; letter-spacing: -0.02em; line-height: 1.25; }
.cp-card > p { color: var(--muted); }
.cp-card .ticks { margin: 4px 0 8px; font-size: .96rem; }
.cp-card .b-block { margin-top: auto; justify-content: center; }
.cp-cert { display: grid; grid-template-columns: auto 1fr; gap: clamp(22px, 4vw, 44px); align-items: center; background: var(--soft); border-radius: 28px; padding: clamp(24px, 4vw, 44px); }
.cp-seal { width: 132px; height: 132px; border-radius: 50%; background: var(--ink); color: #fff; display: grid; place-items: center; text-align: center; box-shadow: 0 0 0 8px #fff, 0 20px 40px -20px rgba(10,23,48,.6); }
.cp-seal b { display: block; font-size: 2rem; font-weight: 800; letter-spacing: -0.03em; line-height: 1; }
.cp-seal span { display: block; font-size: .78rem; color: var(--blue-l); font-weight: 700; margin-top: 4px; letter-spacing: .04em; text-transform: uppercase; }
.cp-cert h3 { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 8px; }
.cp-cert p { color: var(--muted); }
@media (max-width: 640px) { .cp-cert { grid-template-columns: 1fr; text-align: center; justify-items: center; } .cp-seal { width: 110px; height: 110px; } }
.cp-cta { background: var(--ink); color: #fff; border-radius: 30px; padding: clamp(32px, 5vw, 64px); display: flex; gap: 24px; align-items: center; justify-content: space-between; flex-wrap: wrap; }
.cp-cta h2 { font-size: clamp(1.6rem, 3vw, 2.3rem); font-weight: 800; letter-spacing: -0.03em; }
.cp-cta p { color: rgba(255,255,255,.7); margin-top: 6px; }
.cp-cta .acts { display: flex; gap: 10px; flex-wrap: wrap; }
@media (max-width: 640px) { .cp-cta .acts { width: 100%; } .cp-cta .acts .b { flex: 1 1 100%; justify-content: center; } }
.hm-split { display: grid; grid-template-columns: 0.9fr 1.1fr; gap: clamp(40px, 7vw, 110px); align-items: start; }
.hm-split .sticky { position: sticky; top: 120px; }
@media (max-width: 900px) { .hm-split { grid-template-columns: 1fr; gap: 28px; } .hm-split .sticky { position: static; } }
@endsection

@section('content')
<section class="cp-hero">
  <div class="wrap">
    <div class="kicker rv">Formación especializada</div>
    <h1 class="display rv">Capacitaciones en <em>compliance</em> y prevención LA/FT</h1>
    <p class="lead rv">Programas de formación diseñados para fortalecer la cultura de cumplimiento normativo en su organización, dirigidos por especialistas con experiencia regulatoria.</p>
    <div class="acts rv">
      <a href="#programas" class="b b-primary">Ver programas @include('site.partials.icon', ['name' => 'arrow'])</a>
      <a href="https://wa.me/51969754983?text=Hola%2C%20deseo%20coordinar%20una%20capacitaci%C3%B3n%20con%20Romani%20Compliance." target="_blank" rel="noopener" class="b b-ghost-dark">Coordinar por WhatsApp</a>
    </div>
    <div class="cp-stats">
      <div class="rv"><b data-count="129" data-suffix="+">129+</b><span>Capacitaciones brindadas</span></div>
      <div class="rv" style="--d:.05s"><b data-count="45" data-suffix="+">45+</b><span>Empresas capacitadas</span></div>
      <div class="rv" style="--d:.1s"><b data-count="1200" data-suffix="+">1200+</b><span>Profesionales formados</span></div>
      <div class="rv" style="--d:.15s"><b data-count="12">12</b><span>Sectores económicos atendidos</span></div>
    </div>
  </div>
</section>

<section class="sec" id="programas">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Programas</div><h2 class="h2 rv">Elija para quién es la capacitación.</h2></div></div>
    <div class="cp-tabs rv" role="tablist"><button type="button" class="cp-tab" role="tab" data-g="oficial" aria-selected="true"><span class="ti">@include('site.partials.icon', ['name' => 'shield'])</span>Oficial de Cumplimiento</button><button type="button" class="cp-tab" role="tab" data-g="sujetos" aria-selected="false"><span class="ti">@include('site.partials.icon', ['name' => 'check'])</span>Sujetos Obligados</button><button type="button" class="cp-tab" role="tab" data-g="transversales" aria-selected="false"><span class="ti">@include('site.partials.icon', ['name' => 'scale'])</span>Programas transversales</button></div>
    
      <div class="cp-pane" id="cp-oficial" role="tabpanel" @if(false) hidden @endif>
        <div class="cp-intro"><h3>Capacitaciones para el Oficial de Cumplimiento</h3><p>Programas enfocados en las funciones, responsabilidades legales y herramientas operativas que todo OC debe dominar para el cumplimiento efectivo de su rol.</p></div>
        <div class="cp-grid">
          <article class="cp-card">
            <div class="cp-head"><span class="cp-dur">@include('site.partials.icon', ['name' => 'clock']) 4 horas</span></div>
            <h3>Funciones y responsabilidades del Oficial de Cumplimiento</h3>
            <p>Formación integral sobre el marco legal, requisitos de designación, inscripción ante la UIF-Perú y las responsabilidades administrativas y penales del Oficial de Cumplimiento.</p>
            <ul class="ticks"><li>@include('site.partials.icon', ['name' => 'check']) <span>Designación, requisitos e inscripción ante la UIF</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Funciones legales y operativas del OC</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Régimen sancionador aplicable</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Responsabilidad penal y administrativa del OC</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Casos prácticos y análisis de resoluciones SBS</span></li></ul>
            <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20de%20Funciones%20del%20Oficial%20de%20Cumplimiento." target="_blank" rel="noopener" class="b b-primary b-block">Solicitar información @include('site.partials.icon', ['name' => 'arrow'])</a>
          </article>
          <article class="cp-card">
            <div class="cp-head"><span class="cp-dur">@include('site.partials.icon', ['name' => 'clock']) 6 horas</span></div>
            <h3>Diseño del Sistema de Prevención LA/FT</h3>
            <p>Capacitación práctica para que el OC elabore los documentos normativos exigidos por la UIF: Manual de Prevención, Código de Conducta, Matriz de Riesgos y políticas de DDC/KYC.</p>
            <ul class="ticks"><li>@include('site.partials.icon', ['name' => 'check']) <span>Elaboración del Manual de Prevención SPLAFT</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Diseño del Código de Conducta institucional</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Construcción de la Matriz de Riesgos LA/FT</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Políticas de debida diligencia del cliente (DDC/KYC)</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Procedimiento de detección, análisis y reporte (ROS/RO)</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Entrega de plantillas editables</span></li></ul>
            <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20de%20Dise%C3%B1o%20del%20Sistema%20SPLAFT." target="_blank" rel="noopener" class="b b-primary b-block">Solicitar información @include('site.partials.icon', ['name' => 'arrow'])</a>
          </article>
        </div>
      </div>
      <div class="cp-pane" id="cp-sujetos" role="tabpanel" @if(true) hidden @endif>
        <div class="cp-intro"><h3>Capacitaciones para sujetos obligados</h3><p>Programas dirigidos a empresas y entidades sujetas al régimen de prevención LA/FT, enfocados en el cumplimiento de sus obligaciones legales y la formación de sus colaboradores.</p></div>
        <div class="cp-grid">
          <article class="cp-card">
            <div class="cp-head"><span class="cp-dur">@include('site.partials.icon', ['name' => 'clock']) 2 horas</span></div>
            <h3>Prevención LA/FT para colaboradores</h3>
            <p>Capacitación obligatoria para el personal operativo y directivo del sujeto obligado. Cubre el marco normativo, las señales de alerta, las tipologías del sector y el procedimiento interno de reporte.</p>
            <ul class="ticks"><li>@include('site.partials.icon', ['name' => 'check']) <span>Marco normativo SPLAFT aplicable al sector</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Tipologías LA/FT específicas del giro de negocio</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Señales de alerta y detección de operaciones inusuales</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Obligaciones del personal frente al sistema de prevención</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Consecuencias legales del incumplimiento</span></li></ul>
            <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20de%20Prevenci%C3%B3n%20LA%2FFT%20para%20colaboradores." target="_blank" rel="noopener" class="b b-primary b-block">Solicitar información @include('site.partials.icon', ['name' => 'arrow'])</a>
          </article>
          <article class="cp-card">
            <div class="cp-head"><span class="cp-dur">@include('site.partials.icon', ['name' => 'clock']) 3 horas</span></div>
            <h3>Debida diligencia del cliente (DDC/KYC)</h3>
            <p>Formación especializada en los procedimientos de conocimiento del cliente, verificación de identidad, identificación del beneficiario final y monitoreo continuo de la relación comercial.</p>
            <ul class="ticks"><li>@include('site.partials.icon', ['name' => 'check']) <span>DDC simplificada, estándar y reforzada</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Identificación del beneficiario final</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Personas expuestas políticamente (PEP)</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Listas restrictivas y herramientas de consulta</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Monitoreo transaccional y actualización de expedientes</span></li></ul>
            <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20en%20Debida%20Diligencia%20DDC%2FKYC." target="_blank" rel="noopener" class="b b-primary b-block">Solicitar información @include('site.partials.icon', ['name' => 'arrow'])</a>
          </article>
        </div>
      </div>
      <div class="cp-pane" id="cp-transversales" role="tabpanel" @if(true) hidden @endif>
        <div class="cp-intro"><h3>Formación complementaria</h3><p>Capacitaciones dirigidas a directorios, gerencias y equipos legales que necesitan comprender el alcance del compliance corporativo y su responsabilidad frente al marco regulatorio.</p></div>
        <div class="cp-grid">
          <article class="cp-card">
            <div class="cp-head"><span class="cp-dur">@include('site.partials.icon', ['name' => 'clock']) 3 horas</span></div>
            <h3>Compliance corporativo y responsabilidad penal de la persona jurídica</h3>
            <p>Análisis de la Ley N.° 30424 y su reglamento. Diseño de modelos de prevención, responsabilidad del directorio y la alta gerencia, y criterios de exoneración de responsabilidad administrativa.</p>
            <ul class="ticks"><li>@include('site.partials.icon', ['name' => 'check']) <span>Alcances de la Ley N.° 30424 y modificatorias</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Elementos del modelo de prevención</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Rol del encargado de prevención</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Autonomía e independencia del programa</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Criterios de exoneración y atenuación</span></li></ul>
            <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20en%20Compliance%20Corporativo%20y%20Ley%2030424." target="_blank" rel="noopener" class="b b-primary b-block">Solicitar información @include('site.partials.icon', ['name' => 'arrow'])</a>
          </article>
          <article class="cp-card">
            <div class="cp-head"><span class="cp-dur">@include('site.partials.icon', ['name' => 'clock']) 4 horas</span></div>
            <h3>Auditoría interna del sistema de prevención LA/FT</h3>
            <p>Metodología para evaluar la efectividad del sistema SPLAFT implementado: revisión documental, testeo de controles, identificación de brechas y elaboración del informe de auditoría.</p>
            <ul class="ticks"><li>@include('site.partials.icon', ['name' => 'check']) <span>Planificación de la auditoría interna</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Evaluación del Manual, Código y Matriz de Riesgos</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Verificación de registros (RO) y reportes (ROS)</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Testeo de controles DDC/KYC</span></li><li>@include('site.partials.icon', ['name' => 'check']) <span>Informe de hallazgos y plan de mejora</span></li></ul>
            <a href="https://wa.me/51969754983?text=Hola%2C%20solicito%20informaci%C3%B3n%20sobre%20la%20capacitaci%C3%B3n%20en%20Auditor%C3%ADa%20Interna%20SPLAFT." target="_blank" rel="noopener" class="b b-primary b-block">Solicitar información @include('site.partials.icon', ['name' => 'arrow'])</a>
          </article>
        </div>
      </div>
  </div>
</section>

<section class="sec sec-dark on-dark">
  <div class="wrap hm-split">
    <div class="sticky">
      <div class="kicker rv">Metodología</div>
      <h2 class="h2 rv">Nuestra metodología</h2>
      <p class="lead rv" style="margin-top:18px">Un enfoque práctico orientado a resultados concretos para su organización</p>
    </div>
    <div class="tl">
      <div class="tl-fill"></div>
      <div class="tl-step rv"><div class="tl-dot"></div><div><h3>Diagnóstico</h3><p>Evaluamos el nivel de madurez del sistema de prevención y las necesidades específicas de capacitación de su equipo.</p></div></div>
      <div class="tl-step rv" style="--d:.05s"><div class="tl-dot"></div><div><h3>Personalización</h3><p>Adaptamos el contenido al sector económico, modelo de negocio y perfil de riesgo de su organización.</p></div></div>
      <div class="tl-step rv" style="--d:.1s"><div class="tl-dot"></div><div><h3>Capacitación</h3><p>Sesiones presenciales o virtuales con casos prácticos reales, material editable y evaluación de conocimientos.</p></div></div>
      <div class="tl-step rv" style="--d:.15s"><div class="tl-dot"></div><div><h3>Acompañamiento</h3><p>Seguimiento posterior para resolver consultas, revisar implementación y asegurar el cumplimiento efectivo.</p></div></div>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <div class="cp-cert rv">
      <div class="cp-seal"><div><b>RC</b><span>Certificado</span></div></div>
      <div>
        <h3>Certificación incluida</h3>
        <p>Todos nuestros programas de capacitación incluyen certificado de participación emitido por Romani Compliance, con registro del temario impartido y las horas lectivas completadas. Documentación válida para acreditar ante la SBS y la UIF el cumplimiento de la obligación de capacitación periódica del sujeto obligado y su personal.</p>
        <a href="{{ route('certificates.verify.form') }}" class="lnk" style="margin-top:14px;display:inline-flex">Verificar un certificado @include('site.partials.icon', ['name' => 'arrow'])</a>
      </div>
    </div>
  </div>
</section>

<section class="sec" style="padding-top:0">
  <div class="wrap">
    <div class="cp-cta rv">
      <div><h2>Coordine su capacitación</h2><p>Contáctenos para diseñar un programa adaptado a las necesidades de su organización.</p></div>
      <div class="acts">
        <a href="https://wa.me/51969754983?text=Hola%2C%20deseo%20coordinar%20una%20capacitaci%C3%B3n%20con%20Romani%20Compliance." target="_blank" rel="noopener" class="b b-light">Escribir por WhatsApp</a>
        <a href="{{ route('home') }}#contacto" class="b b-ghost-dark">Formulario de contacto</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
(function () {
  // Pestañas de programas
  const tabs = [...document.querySelectorAll('.cp-tab')];
  tabs.forEach((t) => t.addEventListener('click', () => {
    tabs.forEach((x) => x.setAttribute('aria-selected', x === t));
    document.querySelectorAll('.cp-pane').forEach((p) => { p.hidden = p.id !== 'cp-' + t.dataset.g; });
  }));
  // Cifras que cuentan al aparecer
  document.querySelectorAll('[data-count]').forEach((el) => {
    new IntersectionObserver((es, o) => es.forEach((e) => {
      if (!e.isIntersecting) return; o.disconnect();
      const end = +el.dataset.count, suf = el.dataset.suffix || ''; let t0;
      const step = (t) => { t0 = t0 || t; const k = Math.min(1, (t - t0) / 1400); el.textContent = Math.round(end * (1 - Math.pow(1 - k, 3))) + suf; if (k < 1) requestAnimationFrame(step); };
      requestAnimationFrame(step);
    }), { threshold: 0.5 }).observe(el);
  });
})();
</script>
@endsection
