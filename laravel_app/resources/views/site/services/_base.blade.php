{{-- Plantilla común de cada landing de servicio. Cada servicio define @section('tool') (su
     herramienta interactiva) y, si quiere, @section('extra') y @section('tool_scripts'). --}}
@extends('layouts.site')

@section('title', $service['name'].' · Romani Compliance')
@section('description', $service['card'])

@section('styles')
.sv-hero { position: relative; overflow: hidden; background: var(--ink); color: #fff; padding: clamp(44px, 6vw, 80px) 0 clamp(48px, 6vw, 80px); }
@keyframes gridMove { to { background-position: 56px 56px, 56px 56px; } }
@keyframes drift { to { transform: translate(-60px, 50px) scale(1.08); } }
.sv-hero .wrap { position: relative; z-index: 1; display: grid; grid-template-columns: 1.35fr 1fr; gap: 56px; align-items: end; }
.sv-crumb { display: flex; gap: 8px; align-items: center; font-size: 0.9rem; font-weight: 600; color: rgba(255,255,255,.6); margin-bottom: 28px; }
.sv-crumb a:hover { color: #fff; }
.sv-hero .lead { color: rgba(255,255,255,.72); }
.sv-side { color: var(--ink); box-shadow: 0 30px 80px -30px rgba(0,0,0,.6); }
.sv-hero .lead { margin: 24px 0 36px; }
.sv-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.sv-side { background: #fff; border: 1px solid var(--line); border-radius: 24px; padding: 28px; }
.sv-side .icon-tile { margin-bottom: 18px; }
.sv-side h2 { font-size: 1.05rem; font-weight: 800; margin-bottom: 14px; }
@media (max-width: 900px) { .sv-hero .wrap { grid-template-columns: 1fr; gap: 36px; } }
.sv-tool-head { max-width: 760px; margin-bottom: 36px; }
.sv-split { display: grid; grid-template-columns: 0.9fr 1.1fr; gap: clamp(40px, 7vw, 110px); align-items: start; }
.sv-split .sticky { position: sticky; top: 120px; }
@media (max-width: 900px) { .sv-split { grid-template-columns: 1fr; } .sv-split .sticky { position: static; } }
.deliv { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 14px; }
.deliv .card { padding: 24px; display: flex; gap: 14px; align-items: center; font-weight: 700; }
.deliv .card .ic { width: 22px; height: 22px; color: var(--blue); }
.cta-box { overflow: clip; background: var(--ink); color: #fff; border-radius: 30px; padding: clamp(36px, 6vw, 80px); display: grid; grid-template-columns: 1.3fr 1fr; gap: 40px; align-items: center; position: relative; }
.cta-box::after { content: ''; position: absolute; width: 480px; height: 480px; right: -140px; bottom: -220px; border-radius: 50%; background: radial-gradient(circle, rgba(127,163,255,.28), transparent 65%); }
.cta-box > * { position: relative; z-index: 1; min-width: 0; }
.cta-box .lead { color: rgba(255,255,255,.7); margin-top: 16px; }
.cta-sum { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12); border-radius: 18px; margin: 22px 0 6px; overflow: hidden; }
.cta-sum summary { list-style: none; cursor: pointer; display: flex; align-items: center; gap: 12px; padding: 14px 16px; }
.cta-sum summary::-webkit-details-marker { display: none; }
.cta-sum .si { width: 38px; height: 38px; border-radius: 12px; background: rgba(127,163,255,.18); color: var(--blue-l); display: grid; place-items: center; flex-shrink: 0; }
.cta-sum .si .ic { width: 20px; height: 20px; }
.cta-sum .st { flex: 1; min-width: 0; }
.cta-sum .st b { display: block; font-size: .95rem; }
.cta-sum .st small { display: block; color: rgba(255,255,255,.62); font-size: .85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cta-sum .chev { width: 9px; height: 9px; border-right: 2px solid rgba(255,255,255,.6); border-bottom: 2px solid rgba(255,255,255,.6); transform: rotate(45deg); margin: 0 6px 4px 0; transition: transform .3s var(--ease); flex-shrink: 0; }
.cta-sum[open] .chev { transform: rotate(-135deg); margin-bottom: -2px; }
.cta-sum ul { list-style: none; margin: 0; padding: 2px 16px 14px; display: grid; gap: 8px; border-top: 1px solid rgba(255,255,255,.08); padding-top: 12px; }
.cta-sum li { display: flex; gap: 10px; align-items: flex-start; font-size: .9rem; color: rgba(255,255,255,.8); line-height: 1.45; }
.cta-sum li::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--blue-l); margin-top: 8px; flex-shrink: 0; }
.cta-acts { display: grid; gap: 10px; }
@media (max-width: 900px) { .cta-box { grid-template-columns: 1fr; gap: 26px; } }
@media (max-width: 560px) {
  #contactar .wrap { padding: 0 12px; }
  .cta-box { border-radius: 24px; padding: 30px 20px 24px; }
  .cta-box .h2 { font-size: 1.75rem; }
  .cta-box .lead { font-size: 1rem; margin-top: 10px; }
  .cta-box .lead-f { background: none; border: 0; padding: 0; border-radius: 0; }
  .cta-box .lf-row { margin-bottom: 12px; }
  .cta-box .lf-row input { padding: 13px 14px; }
  .cta-box .lf-ck { font-size: .84rem; }
  .cta-box .lead-ok { padding: 24px 8px; }
}
.others { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.others .card { display: flex; flex-direction: column; gap: 14px; }
.others .card h3 { font-size: 1.15rem; font-weight: 800; letter-spacing: -0.015em; }
@media (max-width: 900px) { .others { grid-template-columns: 1fr; } }

.lead-f { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12); border-radius: 22px; padding: 24px; position: relative; }
.lf-row { margin-bottom: 14px; }
.lf-row label { display: block; font-weight: 700; font-size: .9rem; margin-bottom: 7px; color: #fff; }
.lf-row label span { font-weight: 500; color: rgba(255,255,255,.55); }
.lf-row input { width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid rgba(255,255,255,.16); background: rgba(255,255,255,.06); color: #fff; font: inherit; font-size: 1rem; transition: border-color .2s, background .2s; }
.lf-row input::placeholder { color: rgba(255,255,255,.4); }
.lf-row input:focus { outline: none; border-color: var(--blue-l); background: rgba(255,255,255,.1); }
.lf-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
@media (max-width: 520px) { .lf-2 { grid-template-columns: 1fr; gap: 0; } }
.lf-ck { display: flex; gap: 10px; align-items: flex-start; font-size: .88rem; color: rgba(255,255,255,.75); margin: 4px 0 18px; cursor: pointer; }
.lf-ck input { width: 18px; height: 18px; margin-top: 2px; accent-color: var(--blue-l); flex-shrink: 0; }
.lf-err { color: #FFB4AB; font-size: .9rem; margin-top: 10px; display: none; }
.lead-ok { text-align: center; padding: 30px 20px; background: rgba(255,255,255,.06); border-radius: 22px; animation: paneIn .5s var(--ease); }
.lead-ok .okc { width: 64px; height: 64px; border-radius: 50%; background: rgba(14,138,95,.25); color: #7CE0B5; display: grid; place-items: center; margin: 0 auto 16px; font-size: 30px; animation: pop .6s var(--ease); }
@keyframes pop { 0% { transform: scale(.4); opacity: 0; } 70% { transform: scale(1.12); } 100% { transform: scale(1); opacity: 1; } }
.lead-ok h3 { font-size: 1.4rem; font-weight: 800; margin-bottom: 8px; }
.lead-ok p { color: rgba(255,255,255,.7); margin-bottom: 18px; }
@media (max-width: 900px) { .sv-side { display: none; } .sv-hero { padding: 44px 0 52px; } .sv-hero .lead { margin: 16px 0 26px; } }
@media (max-width: 720px) { .sv-actions .b { flex: 1 1 100%; justify-content: center; } .deliv .card { padding: 18px; } .faq summary { font-size: 1.02rem; padding: 20px 0; } .sv-tool-head { margin-bottom: 24px; } }
.pdf-m { position: fixed; inset: 0; z-index: 120; display: grid; place-items: center; padding: 16px; }
.pdf-bg { position: absolute; inset: 0; background: rgba(10,23,48,.55); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); animation: fadeIn .25s ease; }
.pdf-box { position: relative; width: 100%; max-width: 430px; background: #fff; border-radius: 24px; padding: 30px 28px 26px; box-shadow: 0 40px 90px -30px rgba(10,23,48,.6); animation: paneIn .35s var(--ease); }
.pdf-box h3 { font-size: 1.35rem; font-weight: 800; letter-spacing: -0.02em; margin: 16px 0 6px; }
.pdf-box > form > p.muted { margin-bottom: 18px; font-size: .95rem; }
.pdf-x { position: absolute; top: 14px; right: 14px; width: 36px; height: 36px; border-radius: 50%; border: 0; background: var(--soft); font-size: 1.3rem; cursor: pointer; color: var(--muted); }
.pf-row { margin-bottom: 12px; }
.pf-row label { display: block; font-weight: 700; font-size: .9rem; margin-bottom: 6px; }
.pf-row input { width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid var(--line); font: inherit; font-size: 1rem; }
.pf-row input:focus { outline: none; border-color: var(--blue); }
.pf-ck { display: flex; gap: 10px; align-items: flex-start; font-size: .82rem; color: var(--muted); margin: 4px 0 16px; cursor: pointer; }
.pf-ck input { width: 17px; height: 17px; margin-top: 2px; accent-color: var(--blue); flex-shrink: 0; }
.pf-err { color: #C0362C; font-size: .9rem; margin-top: 10px; display: none; }
.pf-ok { text-align: center; padding: 10px 0 0; }
.pf-ok .okc { width: 60px; height: 60px; border-radius: 50%; background: #E1F3EC; color: #0E8A5F; display: grid; place-items: center; margin: 0 auto; animation: pop .6s var(--ease); }
.pf-ok .okc .ic { width: 28px; height: 28px; }
.pf-ok p { margin-bottom: 16px; }
@keyframes fadeIn { from { opacity: 0; } }
@media (max-width: 560px) { .pdf-m { place-items: end center; padding: 0; } .pdf-box { border-radius: 24px 24px 0 0; max-width: none; padding-bottom: calc(26px + env(safe-area-inset-bottom)); animation: sheetUp .4s var(--ease); } }
@keyframes sheetUp { from { transform: translateY(100%); } }
@yield('page_styles')
@endsection

@section('content')
<section class="sv-hero">
  <div class="wrap">
    <div>
      <div class="sv-crumb rv"><a href="{{ route('home') }}#servicios">Servicios</a><span>/</span><span>{{ $service['short'] ?? $service['name'] }}</span></div>
      <h1 class="display rv" style="--d:.05s">{{ $service['hero_title'] }}</h1>
      <p class="lead rv" style="--d:.12s">{{ $service['hero_sub'] }}</p>
      <div class="sv-actions rv" style="--d:.18s">
        @hasSection('hero_actions')
          @yield('hero_actions')
        @else
          <a href="#herramienta" class="b b-primary">{{ $service['cta'] }} @include('site.partials.icon', ['name' => 'arrow'])</a>
        @endif
        <a href="{{ \App\Support\ServiceCatalog::whatsapp('Hola, quisiera conversar sobre '.$service['name'].'.') }}" class="b b-ghost-dark" target="_blank" rel="noopener">Hablar con el equipo</a>
      </div>
    </div>
    <aside class="sv-side rv" style="--d:.2s">
      <div class="icon-tile">@include('site.partials.icon', ['name' => $service['icon']])</div>
      <h2>{{ $service['name'] }}</h2>
      <ul class="ticks">
        @foreach($service['includes'] as $item)<li>@include('site.partials.icon', ['name' => 'check']) <span>{{ $item }}</span></li>@endforeach
      </ul>
    </aside>
  </div>
</section>

<section class="sec sec-soft" id="herramienta">
  <div class="wrap">
    <div class="sv-tool-head">
      <div class="kicker rv">Herramienta</div>
      <h2 class="h2 rv">{{ $service['tool_title'] }}</h2>
      <p class="lead rv" style="margin-top:16px">{{ $service['tool_sub'] }}</p>
    </div>
    <div class="rv">@yield('tool')</div>
  </div>
</section>

@yield('extra')

<section class="sec sec-dark on-dark">
  <div class="wrap sv-split">
    <div class="sticky">
      <div class="kicker rv">Cómo trabajamos</div>
      <h2 class="h2 rv">Un método claro, de principio a fin.</h2>
      <p class="lead rv" style="margin-top:18px">Sabrá en todo momento en qué etapa está su caso, qué estamos haciendo y qué sigue.</p>
    </div>
    <div class="tl">
      <div class="tl-fill"></div>
      @foreach($service['steps'] as $i => [$title, $text])
        <div class="tl-step rv" style="--d:{{ $i * 0.05 }}s"><div class="tl-dot"></div><div><h3>{{ $title }}</h3><p>{{ $text }}</p></div></div>
      @endforeach
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <div class="sec-head">
      <div><div class="kicker rv">Lo que recibe</div><h2 class="h2 rv">Entregables concretos.</h2></div>
    </div>
    <div class="deliv m-scroll">
      @foreach($service['deliverables'] as $i => $d)
        <div class="card rv" style="--d:{{ $i * 0.04 }}s">@include('site.partials.icon', ['name' => 'check']) {{ $d }}</div>
      @endforeach
    </div>
  </div>
</section>

<section class="sec sec-soft">
  <div class="wrap sv-split">
    <div class="sticky"><div class="kicker rv">Preguntas frecuentes</div><h2 class="h2 rv">Lo que suelen preguntarnos.</h2></div>
    <div class="faq rv">
      @foreach($service['faqs'] as [$q, $a])
        <details><summary>{{ $q }} <span class="pm">@include('site.partials.icon', ['name' => 'plus'])</span></summary><p>{{ $a }}</p></details>
      @endforeach
    </div>
  </div>
</section>

<section class="sec" id="contactar">
  <div class="wrap">
    <div class="cta-box rv">
      <div>
        <h2 class="h2">¿Prefiere que le contactemos?</h2>
        <p class="lead">Déjenos sus datos y un abogado del equipo le contactará para revisar su caso con usted, con total reserva.</p>
        <details class="cta-sum" id="ctaSum" hidden></details>
      </div>
      <div>
        <form class="lead-f" id="leadForm" novalidate data-no-loader>
          <div class="lf-row"><label for="lfName">Nombre</label><input id="lfName" name="name" autocomplete="name" required></div>
          <div class="lf-row"><label for="lfOrg">Organización <span>(opcional)</span></label><input id="lfOrg" name="organization" autocomplete="organization"></div>
          <div class="lf-2">
            <div class="lf-row"><label for="lfMail">Correo</label><input id="lfMail" name="email" type="email" autocomplete="email"></div>
            <div class="lf-row"><label for="lfTel">Teléfono / WhatsApp</label><input id="lfTel" name="phone" type="tel" autocomplete="tel" placeholder="+51"></div>
          </div>
          <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px">
          <label class="lf-ck"><input type="checkbox" name="consent" value="1"> <span>Autorizo a Romani Compliance a contactarme sobre esta solicitud y a tratar mis datos con ese fin.</span></label>
          <button type="submit" class="b b-light b-block" id="lfBtn">Enviar solicitud @include('site.partials.icon', ['name' => 'arrow'])</button>
          <p class="lf-err" id="lfErr"></p>
        </form>
        <div class="lead-ok" id="leadOk" hidden>
          <div class="okc">@include('site.partials.icon', ['name' => 'check'])</div>
          <h3>Recibimos su solicitud.</h3>
          <p>Un abogado del equipo le contactará a la brevedad.</p>
        </div>
      </div>
    </div>
  </div>
</section>


{{-- Descarga del informe: se piden organización y teléfono solo en este momento --}}
<div class="pdf-m" id="pdfM" hidden role="dialog" aria-modal="true" aria-labelledby="pdfT">
  <div class="pdf-bg" data-close></div>
  <div class="pdf-box">
    <button type="button" class="pdf-x" data-close aria-label="Cerrar">×</button>
    <form id="pdfForm" novalidate data-no-loader>
      <div class="icon-tile">@include('site.partials.icon', ['name' => 'doc'])</div>
      <h3 id="pdfT">Descargue su informe en PDF</h3>
      <p class="muted">Indique su organización y un teléfono de contacto. El informe se descarga al instante.</p>
      <div class="pf-row"><label for="pfOrg">Organización</label><input id="pfOrg" name="organization" autocomplete="organization" placeholder="Nombre de la empresa o entidad" required></div>
      <div class="pf-row"><label for="pfTel">Teléfono</label><input id="pfTel" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="+51 999 999 999" required></div>
      <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px">
      <label class="pf-ck"><input type="checkbox" name="consent" value="1" checked> <span>Acepto que Romani Compliance guarde estos datos para dar seguimiento a mi consulta.</span></label>
      <button type="submit" class="b b-primary b-block" id="pfBtn">Descargar PDF @include('site.partials.icon', ['name' => 'arrow'])</button>
      <p class="pf-err" id="pfErr"></p>
    </form>
    <div class="pf-ok" id="pfOk" hidden>
      <div class="okc">@include('site.partials.icon', ['name' => 'check'])</div>
      <h3>Su PDF se está descargando.</h3>
      <p class="muted">Si no empieza en unos segundos, use el botón.</p>
      <a href="#" class="b b-primary b-block" id="pfAgain" data-no-loader download>Descargar otra vez</a>
    </div>
  </div>
</div>

<section class="sec sec-soft" style="padding-top:0;background:#fff">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Otros servicios</div><h2 class="h3 rv" style="font-size:1.6rem">También podemos ayudarle con</h2></div><a href="{{ route('home') }}#servicios" class="lnk rv">Ver todos @include('site.partials.icon', ['name' => 'arrow'])</a></div>
    <div class="others m-scroll">
      @foreach($others as $slug => $o)
        <a href="{{ route('services.show', $slug) }}" class="card card-link rv" style="--d:{{ $loop->index * 0.06 }}s">
          <div class="icon-tile">@include('site.partials.icon', ['name' => $o['icon']])</div>
          <h3>{{ $o['name'] }}</h3>
          <p class="muted">{{ $o['card'] }}</p>
          <span class="lnk">{{ $o['cta'] }} @include('site.partials.icon', ['name' => 'arrow'])</span>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
// Ayudas para las herramientas interactivas de cada servicio.
window.RCT = (function () {
  const SERVICE = @json($service['name']);
  const check = '<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>';
  const sum = document.getElementById('ctaSum');

  // Resumen de lo que el cliente eligió: viaja en la solicitud, el PDF y el WhatsApp.
  let state = { lines: [], extra: {} };
  function summary(lines, extra) {
    state = { lines: lines.filter(Boolean), extra: extra || {} };
    const esc = (t) => String(t).replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
    const L = state.lines;
    sum.hidden = !L.length;
    if (L.length) {
      sum.innerHTML = '<summary><span class="si">' + @json(view('site.partials.icon', ['name' => 'doc'])->render()) + '</span><span class="st"><b>Su resumen</b><small>' + esc(L[0]) + '</small></span><span class="chev"></span></summary>'
        + '<ul>' + L.map((l) => '<li>' + esc(l) + '</li>').join('') + '</ul>';
      sum.open = matchMedia('(min-width: 901px)').matches;
    }
  }
  summary([]);

  // Formulario de solicitud: guarda en el panel admin y devuelve el PDF firmado.
  const form = document.getElementById('leadForm');
  const err = document.getElementById('lfErr');
  const org = document.getElementById('lfOrg');
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const f = Object.fromEntries(new FormData(form));
    const fail = (m) => { err.textContent = m; err.style.display = 'block'; };
    if (!f.name || f.name.trim().length < 2) return fail('Indique su nombre.');
    if (!f.email && !f.phone) return fail('Indique un correo o un teléfono para contactarle.');
    if (f.email && !/^\S+@\S+\.\S+$/.test(f.email)) return fail('El correo no es válido.');
    if (!f.consent) return fail('Marque la autorización para que podamos contactarle.');
    err.style.display = 'none';
    const btn = document.getElementById('lfBtn'); btn.disabled = true; btn.firstChild.textContent = 'Enviando ';
    const lines = state.lines.length ? state.lines : ['Consulta sobre ' + SERVICE + ' (sin usar la herramienta).'];
    const payload = { name: f.name, organization: f.organization || null, email: f.email || null, phone: f.phone || null, consent: 1, website: f.website || '',
      summary: lines.join('\n'), score: state.extra.score ?? null, level: state.extra.level || null,
      data: { lines, priorities: state.extra.priorities || [], title: state.extra.title || null } };
    try {
      const r = await fetch(@json(route('services.leads.store', $service['slug'])), { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }, body: JSON.stringify(payload) });
      const j = await r.json().catch(() => ({}));
      if (!r.ok) { const m = j.errors ? Object.values(j.errors)[0][0] : (r.status === 429 ? 'Demasiados intentos. Espere un minuto.' : 'No se pudo enviar. Escríbanos por WhatsApp.'); throw new Error(m); }
      form.hidden = true; const ok = document.getElementById('leadOk'); ok.hidden = false; form.closest('.cta-box').scrollTop = 0;
      // aviso por correo al equipo (mismo servicio que el formulario de contacto)
      fetch('https://formsubmit.co/ajax/omaroliden1@gmail.com', { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, body: JSON.stringify({ name: f.name, email: f.email || 'sin-correo@romanicompliance.com', message: 'Nueva solicitud: ' + SERVICE + '\n\nNombre: ' + f.name + '\nOrganización: ' + (f.organization || '-') + '\nCorreo: ' + (f.email || '-') + '\nTeléfono: ' + (f.phone || '-') + '\n\n' + payload.summary, _cc: 'dromani@pucp.pe', _subject: 'Nueva solicitud web · ' + SERVICE }) }).catch(() => {});
    } catch (x) {
      btn.disabled = false; btn.firstChild.textContent = 'Enviar solicitud '; fail(x.message);
    }
  });

  // Ventana de descarga del PDF
  const pm = document.getElementById('pdfM'), pf = document.getElementById('pdfForm'), pErr = document.getElementById('pfErr'), pOk = document.getElementById('pfOk');
  function pdf() {
    pf.hidden = false; pOk.hidden = true; pErr.style.display = 'none';
    const b = document.getElementById('pfBtn'); b.disabled = false; b.firstChild.textContent = 'Descargar PDF ';
    pm.hidden = false; document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('pfOrg').focus(), 250);
  }
  const closePdf = () => { pm.hidden = true; document.body.style.overflow = ''; };
  pm.querySelectorAll('[data-close]').forEach((x) => x.addEventListener('click', closePdf));
  pf.addEventListener('input', () => { pErr.style.display = 'none'; });
  addEventListener('keydown', (e) => { if (e.key === 'Escape' && !pm.hidden) closePdf(); });
  document.addEventListener('click', (e) => { const t = e.target.closest('[data-pdf]'); if (t) { e.preventDefault(); pdf(); } });
  pf.addEventListener('submit', async (e) => {
    e.preventDefault();
    const f = Object.fromEntries(new FormData(pf));
    const fail = (m) => { pErr.textContent = m; pErr.style.display = 'block'; };
    if (!f.organization || f.organization.trim().length < 2) return fail('Indique el nombre de su organización.');
    if ((f.phone || '').replace(/\D/g, '').length < 6) return fail('Indique un teléfono válido.');
    if (!f.consent) return fail('Marque la casilla para continuar.');
    pErr.style.display = 'none';
    const b = document.getElementById('pfBtn'); b.disabled = true; b.firstChild.textContent = 'Preparando su PDF ';
    const lines = state.lines.length ? state.lines : ['Consulta sobre ' + SERVICE + '.'];
    const payload = { organization: f.organization.trim(), phone: f.phone.trim(), consent: 1, website: f.website || '',
      summary: lines.join('\n'), score: state.extra.score ?? null, level: state.extra.level || null,
      data: { lines, priorities: state.extra.priorities || [], title: state.extra.title || null } };
    try {
      payload.download = 1;
      const r = await fetch(@json(route('services.leads.store', $service['slug'])), { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/json', Accept: 'application/pdf, application/json', 'X-CSRF-TOKEN': (document.querySelector('meta[name=csrf-token]') || {}).content || '' }, body: JSON.stringify(payload) });
      const type = r.headers.get('content-type') || '';
      if (!r.ok || !type.includes('pdf')) {
        const j = await r.json().catch(() => ({}));
        throw new Error(j.errors ? Object.values(j.errors)[0][0] : (r.status === 429 ? 'Demasiados intentos. Espere un minuto.' : 'No se pudo generar el PDF. Intente nuevamente.'));
      }
      const blob = await r.blob();
      const name = ((r.headers.get('content-disposition') || '').match(/filename="?([^";]+)"?/) || [])[1] || 'informe-romani-compliance.pdf';
      const url = URL.createObjectURL(blob);
      pf.hidden = true; pOk.hidden = false;
      const again = document.getElementById('pfAgain'); again.href = url; again.setAttribute('download', name);
      const a = document.createElement('a'); a.href = url; a.download = name; a.setAttribute('data-no-loader', ''); document.body.appendChild(a); a.click(); a.remove();
      fetch('https://formsubmit.co/ajax/omaroliden1@gmail.com', { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, body: JSON.stringify({ name: payload.organization, email: 'sin-correo@romanicompliance.com', message: 'Descarga de informe: ' + SERVICE + '\n\nOrganización: ' + payload.organization + '\nTeléfono: ' + payload.phone + '\n\n' + payload.summary, _cc: 'dromani@pucp.pe', _subject: 'Nueva descarga de informe · ' + SERVICE }) }).catch(() => {});
    } catch (x) { b.disabled = false; b.firstChild.textContent = 'Descargar PDF '; fail(x.message); }
  });

  // Ir al formulario de contacto
  function toForm() { document.getElementById('contactar').scrollIntoView({ behavior: 'smooth' }); setTimeout(() => document.getElementById(document.getElementById('lfName').value ? 'lfMail' : 'lfName').focus({ preventScroll: true }), 600); }
  function setOrg(v) { if (v && !org.value) org.value = v; }

  // Pinta opciones seleccionables. list: [{v, t, s?}]. Devuelve {get()}.
  function options(el, list, opts = {}) {
    const multi = !!opts.multi;
    let value = multi ? new Set(opts.value || []) : (opts.value ?? null);
    el.innerHTML = '';
    el.classList.add('opts');
    list.forEach((o) => {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'opt' + (multi ? '' : ' radio');
      b.innerHTML = '<span class="box">' + check + '</span><span>' + o.t + (o.s ? '<small>' + o.s + '</small>' : '') + '</span>';
      const on = () => (multi ? value.has(o.v) : value === o.v);
      const paint = () => el.querySelectorAll('.opt').forEach((x, i) => x.setAttribute('aria-pressed', multi ? value.has(list[i].v) : value === list[i].v));
      b.setAttribute('aria-pressed', on());
      b.addEventListener('click', () => {
        if (multi) { value.has(o.v) ? value.delete(o.v) : value.add(o.v); } else { value = o.v; }
        paint();
        opts.onChange && opts.onChange(multi ? [...value] : value);
      });
      el.appendChild(b);
    });
    return { get: () => (multi ? [...value] : value) };
  }

  const label = (list, v) => (list.find((o) => o.v === v) || {}).t || '';
  return { summary, options, label, check, toForm, setOrg, pdf };
})();
</script>
@yield('tool_scripts')
@endsection
