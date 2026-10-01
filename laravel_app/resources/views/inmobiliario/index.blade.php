@extends('layouts.app')

@section('title', 'Compliance Inmobiliario — Romani Compliance')
@section('description', 'Due diligence de macrolotes, modelos de prevención Ley N.° 30424 y saneamiento técnico-legal para inmobiliarias, agentes y compradores.')

@section('styles')
.inm-shell { padding: 4.5rem 0 6rem; background: var(--ivory); min-height: calc(100vh - 71px); }
.inm-hero { text-align: center; max-width: 720px; margin: 0 auto 3.2rem; }
.inm-eyebrow { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--gold); margin-bottom: 0.8rem; }
.inm-title { font-family: var(--serif); font-weight: 600; font-size: clamp(1.8rem, 4vw, 2.6rem); color: var(--ink); margin-bottom: 0.7rem; letter-spacing: -0.01em; }
.inm-subtitle { font-size: 0.95rem; color: var(--slate); max-width: 560px; margin: 0 auto; line-height: 1.6; }

.inm-role-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.4rem; max-width: 980px; margin: 0 auto; }
.inm-role-card { background: var(--white); border: 1.5px solid var(--line); border-radius: 16px; padding: 2.2rem 1.8rem; text-align: center; cursor: pointer; transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; font-family: inherit; width: 100%; }
.inm-role-card:hover { border-color: var(--gold); transform: translateY(-4px); box-shadow: 0 16px 40px rgba(11,24,41,0.08); }
.inm-role-card.active { border-color: var(--gold); background: var(--gold-pale); box-shadow: 0 16px 40px rgba(11,24,41,0.08); }
.inm-role-icon { width: 64px; height: 64px; border-radius: 16px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem; transition: background 0.2s ease, color 0.2s ease; }
.inm-role-card.active .inm-role-icon { background: var(--gold); color: var(--white); }
.inm-role-icon svg { width: 30px; height: 30px; }
.inm-role-card h3 { font-family: var(--serif); font-size: 1.15rem; color: var(--ink); margin-bottom: 6px; }
.inm-role-card p { font-size: 0.82rem; color: var(--slate); line-height: 1.5; }

.inm-panels { max-width: 860px; margin: 3rem auto 0; }
.inm-placeholder { text-align: center; padding: 3.4rem 1.5rem; color: var(--slate-light); font-size: 0.92rem; border: 1.5px dashed var(--line); border-radius: 18px; }
.inm-placeholder svg { width: 32px; height: 32px; color: var(--line); margin: 0 auto 1rem; display: block; }

.inm-panel { display: none; background: var(--white); border: 1px solid var(--line); border-radius: 18px; padding: 2.6rem; animation: inmFade 0.4s ease; }
.inm-panel.active { display: block; }
@keyframes inmFade { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.inm-panel-eyebrow { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gold); margin-bottom: 0.6rem; }
.inm-panel h2 { font-family: var(--serif); font-size: 1.55rem; color: var(--ink); margin-bottom: 0.9rem; }
.inm-panel .quote { font-size: 0.95rem; font-style: italic; color: var(--gold); border-left: 3px solid var(--gold); padding-left: 1rem; margin-bottom: 1.3rem; line-height: 1.5; }
.inm-panel > .intro { font-size: 0.9rem; color: var(--slate); line-height: 1.75; margin-bottom: 1.8rem; }

.inm-service-list { display: flex; flex-direction: column; gap: 1.4rem; margin-bottom: 1.8rem; }
.inm-service-item { display: flex; gap: 1rem; }
.inm-service-dot { width: 36px; height: 36px; border-radius: 10px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.inm-service-dot svg { width: 18px; height: 18px; }
.inm-service-item h4 { font-size: 0.98rem; color: var(--ink); margin-bottom: 4px; }
.inm-service-item p { font-size: 0.85rem; color: var(--slate); line-height: 1.65; }
.inm-sublist { list-style: none; margin-top: 0.7rem; padding-left: 0; display: flex; flex-direction: column; gap: 7px; }
.inm-sublist li { font-size: 0.82rem; color: var(--slate); padding-left: 1rem; position: relative; line-height: 1.55; }
.inm-sublist li::before { content: ''; position: absolute; left: 0; top: 8px; width: 5px; height: 5px; border-radius: 50%; background: var(--gold); }
.inm-sublist li strong { color: var(--ink); }

.inm-options-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.8rem; }
.inm-option-card { border: 1px solid var(--line); border-radius: 12px; padding: 1.4rem 1.5rem; background: var(--ivory); }
.inm-option-tag { font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gold); margin-bottom: 0.5rem; }
.inm-option-card h4 { font-size: 0.95rem; color: var(--ink); margin-bottom: 4px; }
.inm-option-card p { font-size: 0.83rem; color: var(--slate); line-height: 1.6; }

.inm-panel-cta { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; padding-top: 1.5rem; border-top: 1px solid var(--line); }
.inm-btn-wa { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--white); font-weight: 700; font-size: 0.85rem; padding: 12px 26px; border-radius: 8px; transition: transform 0.2s ease, box-shadow 0.2s ease; }
.inm-btn-wa:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(184,154,86,0.35); }
.inm-btn-secondary { font-size: 0.82rem; font-weight: 600; color: var(--slate); }
.inm-btn-secondary:hover { color: var(--gold); }

@media (max-width: 860px) {
  .inm-role-grid { grid-template-columns: 1fr; }
  .inm-options-grid { grid-template-columns: 1fr; }
  .inm-panel { padding: 1.9rem 1.6rem; }
}
@endsection

@section('content')
<div class="inm-shell">
  <div class="wrap">
    <div class="inm-hero reveal">
      <div class="inm-eyebrow">Compliance Inmobiliario</div>
      <h1 class="inm-title">¿Qué perfil le describe mejor?</h1>
      <p class="inm-subtitle">Seleccione una opción y le mostraremos los servicios de compliance y saneamiento legal diseñados específicamente para su situación.</p>
    </div>

    <div class="inm-role-grid reveal">
      <button type="button" class="inm-role-card" data-role="inmobiliaria">
        <span class="inm-role-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M4 21V6l7-3 7 3v15"/><path d="M4 21h16"/><path d="M9 21v-5h4v5"/><path d="M8 9h1M8 13h1M14 9h1M14 13h1"/></svg>
        </span>
        <h3>Soy Inmobiliaria</h3>
        <p>Empresas desarrolladoras de proyectos, lotizaciones y macrolotes.</p>
      </button>
      <button type="button" class="inm-role-card" data-role="agente">
        <span class="inm-role-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l4-4 4 3 3-3 4 4"/><path d="M3 11v7a1 1 0 001 1h3v-5h2v5h6v-5h2v5h3a1 1 0 001-1v-7"/></svg>
        </span>
        <h3>Soy Agente Inmobiliario</h3>
        <p>Corredores independientes y agencias que necesitan operar con seguridad.</p>
      </button>
      <button type="button" class="inm-role-card" data-role="cliente">
        <span class="inm-role-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="9" r="4.2"/><path d="M12.2 11.8L20 19.6"/><path d="M17 17l2-2M19.5 19.5l2-2"/></svg>
        </span>
        <h3>Soy Cliente</h3>
        <p>Compradores y propietarios que buscan comprar o sanear un inmueble.</p>
      </button>
    </div>

    <div class="inm-panels reveal">

      <div class="inm-placeholder" id="inmPlaceholder">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
        Elija una de las opciones de arriba para ver los servicios disponibles.
      </div>

      <div class="inm-panel" id="inmPanel-inmobiliaria">
        <div class="inm-panel-eyebrow">Soy Inmobiliaria</div>
        <h2>Due diligence y saneamiento para su proyecto</h2>
        <p class="intro">Auditoría legal y técnica integral para desarrolladores inmobiliarios, desde la verificación del terreno hasta la implementación del modelo de prevención de delitos de su empresa.</p>

        <div class="inm-service-list">
          <div class="inm-service-item">
            <span class="inm-service-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="6.5"/><path d="M20 20l-4.3-4.3"/></svg></span>
            <div>
              <h4>Due Diligence Integral de Macrolotes</h4>
              <p>Auditoría legal exhaustiva de la propiedad: historial en SUNARP, cargas, gravámenes, superposición de áreas y riesgos con comunidades campesinas o particulares.</p>
            </div>
          </div>
          <div class="inm-service-item">
            <span class="inm-service-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.5l8 3.3v5.4c0 5-3.4 8.8-8 10.3-4.6-1.5-8-5.3-8-10.3V5.8l8-3.3z"/><path d="M9 12l2 2 4-4.5"/></svg></span>
            <div>
              <h4>Modelo de Prevención de Delitos (Ley N.° 30424)</h4>
              <p>Implementación de sistemas de compliance para eximir a la empresa de responsabilidad penal corporativa por delitos de corrupción, soborno o lavado de activos.</p>
            </div>
          </div>
          <div class="inm-service-item">
            <span class="inm-service-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3.5" y="3.5" width="17" height="17" rx="2"/><path d="M8 3.5v17M3.5 10h17"/></svg></span>
            <div>
              <h4>Saneamiento Técnico-Legal Integrado</h4>
              <p>Alianza estratégica con CMAI S.A.C.: unimos el rigor del compliance y la seguridad jurídica con su sólida experiencia técnica en un solo servicio.</p>
              <ul class="inm-sublist">
                <li><strong>Ingeniería y Diseño</strong> — levantamientos topográficos, habilitaciones urbanas y proyectos de arquitectura e ingeniería.</li>
                <li><strong>Ejecución Técnica</strong> — independizaciones de lotes o departamentos y compatibilidad de zonificación.</li>
                <li><strong>Gestión Legal y Municipal</strong> — trámites ante las municipalidades de Piura, Castilla, Veintiséis de Octubre, Catacaos y los Registros Públicos (SUNARP).</li>
              </ul>
            </div>
          </div>
          <div class="inm-service-item">
            <span class="inm-service-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v2"/><path d="M5 6l14-1.2"/><path d="M5 6L2.5 11a2.5 2.5 0 005 0L5 6z"/><path d="M19 4.8L16.5 10a2.5 2.5 0 005 0L19 4.8z"/><path d="M5 21h14"/><path d="M12 5v16"/></svg></span>
            <div>
              <h4>Protocolos PLAFT para Desarrolladores</h4>
              <p>Establecimiento de políticas internas para la prevención de lavado de activos y financiamiento del terrorismo.</p>
            </div>
          </div>
        </div>

        <div class="inm-panel-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20somos%20una%20inmobiliaria%20y%20quisi%C3%A9ramos%20informaci%C3%B3n%20sobre%20sus%20servicios%20de%20Compliance%20Inmobiliario." class="inm-btn-wa" target="_blank">Solicitar asesoría</a>
          <button type="button" class="inm-btn-secondary" onclick="inmReset()">Elegir otro perfil</button>
        </div>
      </div>

      <div class="inm-panel" id="inmPanel-agente">
        <div class="inm-panel-eyebrow">Soy Agente Inmobiliario</div>
        <h2>Protege tu reputación y cierra ventas con tranquilidad</h2>
        <p class="quote">"Protege tu reputación, cumple con la normativa de la UIF y cierra ventas con total tranquilidad."</p>
        <p class="intro">Diseñado para corredores independientes y agencias pequeñas que necesitan operar con total seguridad y evitar sanciones.</p>

        <div class="inm-service-list">
          <div class="inm-service-item">
            <span class="inm-service-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.5l8 3.3v5.4c0 5-3.4 8.8-8 10.3-4.6-1.5-8-5.3-8-10.3V5.8l8-3.3z"/><path d="M9 12l2 2 4-4.5"/></svg></span>
            <div>
              <h4>Adecuación y Capacitación PLAFT</h4>
              <p>Implementación rápida de los requisitos obligatorios exigidos por la SBS / Unidad de Inteligencia Financiera para agentes inmobiliarios formales.</p>
            </div>
          </div>
          <div class="inm-service-item">
            <span class="inm-service-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="6.5"/><path d="M20 20l-4.3-4.3"/></svg></span>
            <div>
              <h4>Kits de Debida Diligencia para Agentes</h4>
              <p>Herramientas y procedimientos sencillos para verificar el origen lícito de los fondos del comprador y la identidad real del propietario.</p>
            </div>
          </div>
          <div class="inm-service-item">
            <span class="inm-service-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="1.5"/><path d="M8 8h8M8 12h8M8 16h5"/></svg></span>
            <div>
              <h4>Minutas y Contratos Blindados</h4>
              <p>Plantillas contractuales seguras (arras, promesa de venta, intermediación) revisadas bajo estándares legales para evitar futuros juicios.</p>
            </div>
          </div>
          <div class="inm-service-item">
            <span class="inm-service-dot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z"/></svg></span>
            <div>
              <h4>Auditoría Express de Inmuebles a Captar</h4>
              <p>Un servicio rápido para verificar que la propiedad que vas a ofrecer a tus clientes no tenga "vicios ocultos" legales.</p>
            </div>
          </div>
        </div>

        <div class="inm-panel-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20soy%20agente%20inmobiliario%20y%20quisiera%20informaci%C3%B3n%20sobre%20sus%20servicios%20PLAFT%20para%20agentes." class="inm-btn-wa" target="_blank">Solicitar asesoría</a>
          <button type="button" class="inm-btn-secondary" onclick="inmReset()">Elegir otro perfil</button>
        </div>
      </div>

      <div class="inm-panel" id="inmPanel-cliente">
        <div class="inm-panel-eyebrow">Soy Cliente — Compradores y propietarios</div>
        <h2>Compre o sanee su propiedad con tranquilidad</h2>
        <p class="intro">Dirigido a la persona que va a comprar el lote de sus sueños, una casa, o busca ordenar la propiedad heredada de su familia.</p>

        <div class="inm-options-grid">
          <div class="inm-option-card">
            <div class="inm-option-tag">Opción A</div>
            <h4>Voy a comprar un inmueble (lote, casa o depa)</h4>
            <p><strong>Servicio "Compra Segura"</strong> (Consumer Due Diligence): revisamos la partida registral, los antecedentes del vendedor, si el terreno está sobre un área protegida o tiene hipotecas ocultas antes de que entregue un pago de adelanto.</p>
          </div>
          <div class="inm-option-card">
            <div class="inm-option-tag">Opción B</div>
            <h4>Soy propietario / heredero</h4>
            <p><strong>Saneamiento Técnico-Legal Familiar:</strong> regularización de predios, sucesiones intestadas, rectificación de áreas y linderos, y levantamiento de cargas antiguas.</p>
          </div>
        </div>

        <div class="inm-panel-cta">
          <a href="https://wa.me/51969754983?text=Hola%2C%20quisiera%20informaci%C3%B3n%20sobre%20sus%20servicios%20para%20compradores%20o%20propietarios%20de%20inmuebles." class="inm-btn-wa" target="_blank">Solicitar asesoría</a>
          <button type="button" class="inm-btn-secondary" onclick="inmReset()">Elegir otro perfil</button>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
  var cards = document.querySelectorAll('.inm-role-card');
  var panels = document.querySelectorAll('.inm-panel');
  var placeholder = document.getElementById('inmPlaceholder');

  cards.forEach(function (card) {
    card.addEventListener('click', function () {
      var role = card.getAttribute('data-role');
      cards.forEach(function (c) { c.classList.toggle('active', c === card); });
      panels.forEach(function (p) { p.classList.toggle('active', p.id === 'inmPanel-' + role); });
      placeholder.style.display = 'none';
      var activePanel = document.getElementById('inmPanel-' + role);
      if (activePanel && window.innerWidth < 860) {
        window.setTimeout(function () {
          activePanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 80);
      }
    });
  });

  window.inmReset = function () {
    cards.forEach(function (c) { c.classList.remove('active'); });
    panels.forEach(function (p) { p.classList.remove('active'); });
    placeholder.style.display = 'block';
    placeholder.scrollIntoView({ behavior: 'smooth', block: 'center' });
  };
})();
</script>
@endsection
