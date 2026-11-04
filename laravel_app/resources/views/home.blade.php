@extends('layouts.site')

@php $services = \App\Support\ServiceCatalog::all(); @endphp

@section('styles')
/* Portada */
.hero { position: relative; overflow: hidden; padding: clamp(64px, 9vw, 128px) 0 clamp(56px, 7vw, 96px); }
.hero::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(var(--line) 1px, transparent 1px), linear-gradient(90deg, var(--line) 1px, transparent 1px); background-size: 64px 64px; mask-image: radial-gradient(ellipse 60% 70% at 80% 20%, #000 5%, transparent 70%); -webkit-mask-image: radial-gradient(ellipse 60% 70% at 80% 20%, #000 5%, transparent 70%); }
.hero::after { content: ''; position: absolute; width: 720px; height: 720px; right: -220px; top: -300px; border-radius: 50%; background: radial-gradient(circle, rgba(31,79,216,.18), transparent 62%); animation: drift 16s ease-in-out infinite alternate; }
@keyframes drift { to { transform: translate(-80px, 70px) scale(1.1); } }
.hero .wrap { position: relative; z-index: 1; }
.hero-tag { display: inline-flex; align-items: center; gap: 10px; padding: 8px 16px 8px 10px; border-radius: 999px; background: #fff; border: 1px solid var(--line); font-size: .9rem; font-weight: 600; color: var(--muted); margin-bottom: 30px; }
.hero-tag i { width: 8px; height: 8px; border-radius: 50%; background: var(--ok); box-shadow: 0 0 0 4px rgba(14,138,95,.15); }
.hero h1 { max-width: 1000px; }
.hero h1 em { font-style: normal; background: linear-gradient(90deg, var(--blue), #5B7FFF); -webkit-background-clip: text; background-clip: text; color: transparent; }
.hero .lead { margin: 28px 0 38px; }
.hero-acts { display: flex; gap: 12px; flex-wrap: wrap; }
.facts { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; margin-top: clamp(48px, 7vw, 88px); border-top: 1px solid var(--line); }
.facts div { padding: 26px 26px 0 0; }
.facts b { display: block; font-size: clamp(1.8rem, 3.4vw, 2.6rem); font-weight: 800; letter-spacing: -0.04em; line-height: 1; }
.facts span { color: var(--muted); font-size: .95rem; display: block; margin-top: 8px; max-width: 240px; }
@media (max-width: 720px) { .facts { grid-template-columns: 1fr; } .facts div { padding: 20px 0 0; } }

/* ¿Qué necesita resolver? */
.need { background: var(--ink); color: #fff; border-radius: 30px; padding: clamp(28px, 4vw, 52px); margin-top: clamp(48px, 6vw, 80px); }
.need-top { display: flex; justify-content: space-between; align-items: end; gap: 20px; flex-wrap: wrap; margin-bottom: 26px; }
.need h2 { font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; letter-spacing: -0.03em; }
.need-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
.need a { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 22px 22px; border-radius: 18px; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08); font-weight: 700; font-size: 1.02rem; line-height: 1.35; transition: background .25s, border-color .25s, transform .3s var(--ease); }
.need a:hover { background: rgba(127,163,255,.14); border-color: rgba(127,163,255,.35); transform: translateY(-3px); }
.need a .ic { width: 22px; height: 22px; color: var(--blue-l); transition: transform .25s var(--ease); }
.need a:hover .ic { transform: translateX(4px); }
@media (max-width: 960px) { .need-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 620px) { .need-grid { grid-template-columns: 1fr; } }

/* Estándares */
.std { display: flex; align-items: center; gap: 12px 28px; flex-wrap: wrap; justify-content: center; padding: 30px 0; border-bottom: 1px solid var(--line); }
.std span { font-weight: 700; color: var(--muted-2); font-size: .92rem; }
.std b { font-size: 1.05rem; font-weight: 800; color: var(--ink); letter-spacing: -0.01em; }

/* Servicios */
.svc { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.svc .card { display: flex; flex-direction: column; padding: 32px; }
.svc .card h3 { font-size: 1.45rem; font-weight: 800; letter-spacing: -0.025em; line-height: 1.2; margin: 22px 0 10px; }
.svc .card > p { color: var(--muted); }
.svc .inc { list-style: none; display: grid; gap: 10px; margin: 22px 0 28px; font-size: .95rem; }
.svc .inc li { display: flex; gap: 10px; align-items: flex-start; }
.svc .inc li .ic { width: 18px; height: 18px; color: var(--blue); margin-top: 3px; }
.svc .acts { margin-top: auto; display: flex; gap: 10px; }
.svc .acts .b { flex: 1; }
.svc .card.feat { background: linear-gradient(160deg, var(--navy), var(--ink)); color: #fff; border-color: transparent; }
.svc .card.feat > p { color: rgba(255,255,255,.7); }
.svc .card.feat .icon-tile { background: rgba(127,163,255,.16); color: var(--blue-l); }
.svc .card.feat .inc li .ic { color: var(--blue-l); }
.svc .card.feat .badge { position: absolute; top: 26px; right: 26px; }
@media (max-width: 1020px) { .svc { grid-template-columns: 1fr 1fr; } }
@media (max-width: 680px) { .svc { grid-template-columns: 1fr; } }
.train { margin-top: 16px; display: flex; align-items: center; gap: 22px; justify-content: space-between; flex-wrap: wrap; }
.train .l { display: flex; align-items: center; gap: 18px; }
.train h3 { font-size: 1.2rem; font-weight: 800; }

/* Método */
.steps4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; position: relative; }
.steps4::before { content: ''; position: absolute; left: 0; right: 0; top: 30px; height: 2px; background: rgba(255,255,255,.14); }
.steps4 .ln { position: absolute; left: 0; top: 30px; height: 2px; width: 0; background: var(--blue-l); transition: width 1.8s var(--ease); }
.steps4.in .ln { width: 100%; }
.steps4 > div:not(.ln) { position: relative; padding-right: 28px; }
.steps4 .no { width: 60px; height: 60px; border-radius: 50%; background: var(--ink); border: 2px solid rgba(255,255,255,.18); display: grid; place-items: center; font-weight: 800; font-size: 1.1rem; margin-bottom: 26px; transition: border-color .6s, background .6s; }
.steps4.in .no { border-color: var(--blue-l); }
.steps4 h3 { font-size: 1.35rem; font-weight: 800; margin-bottom: 8px; letter-spacing: -0.02em; }
.steps4 p { color: rgba(255,255,255,.65); }
@media (max-width: 900px) { .steps4 { grid-template-columns: 1fr 1fr; gap: 36px 0; } .steps4::before, .steps4 .ln { display: none; } }
@media (max-width: 560px) { .steps4 { grid-template-columns: 1fr; } }

/* Clientes */
.logos { overflow: hidden; mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent); -webkit-mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent); }
.logos-track { display: flex; gap: 72px; width: max-content; animation: marquee 30s linear infinite; align-items: center; }
.logos-track > * { height: 46px; display: flex; align-items: center; opacity: .7; filter: grayscale(1); transition: opacity .3s, filter .3s; }
.logos-track > *:hover { opacity: 1; filter: none; }
.logos-track img { max-height: 46px; width: auto; }
.logos-track .txt { font-size: 1.6rem; font-weight: 800; letter-spacing: -0.03em; }
@keyframes marquee { to { transform: translateX(-50%); } }

/* Dirección */
.dir { display: grid; grid-template-columns: 0.85fr 1.15fr; gap: clamp(36px, 6vw, 96px); align-items: center; }
.dir-photo { border-radius: 28px; overflow: hidden; background: var(--soft); aspect-ratio: 4 / 5; }
.dir-photo img { width: 100%; height: 100%; object-fit: cover; }
.dir .h2 { margin-bottom: 8px; }
.dir .role { color: var(--blue); font-weight: 700; margin-bottom: 22px; }
.dir .lead { margin-bottom: 26px; }
.dir .contact { display: flex; gap: 10px 24px; flex-wrap: wrap; margin-top: 26px; }
@media (max-width: 860px) { .dir { grid-template-columns: 1fr; } .dir-photo { max-width: 380px; } }

/* Contacto */
.ct { display: grid; grid-template-columns: 0.9fr 1.1fr; gap: clamp(36px, 6vw, 96px); align-items: start; }
.ct-ch { display: grid; gap: 12px; margin-top: 30px; }
.ct-ch a { display: flex; align-items: center; gap: 16px; padding: 18px 20px; border-radius: 16px; border: 1px solid var(--line); background: #fff; font-weight: 700; transition: border-color .25s; }
.ct-ch a:hover { border-color: var(--blue); }
.ct-ch a .icon-tile { width: 44px; height: 44px; font-size: 20px; }
.ct-ch small { display: block; font-weight: 500; color: var(--muted); }
.form { background: #fff; border: 1px solid var(--line); border-radius: 26px; padding: clamp(24px, 4vw, 44px); }
.form .row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.form label { display: block; font-weight: 700; font-size: .92rem; margin-bottom: 8px; }
.form .f { margin-bottom: 18px; }
.form input, .form select, .form textarea { width: 100%; padding: 15px 16px; border-radius: 14px; border: 1.5px solid var(--line); font: inherit; font-size: 1rem; background: #fff; color: var(--ink); transition: border-color .2s; }
.form input:focus, .form select:focus, .form textarea:focus { outline: none; border-color: var(--blue); }
.form textarea { min-height: 130px; resize: vertical; }
.form-ok { display: none; text-align: center; padding: 30px 10px; }
@media (max-width: 860px) { .ct { grid-template-columns: 1fr; } }
@media (max-width: 520px) { .form .row2 { grid-template-columns: 1fr; } }
@endsection

@section('content')
<section class="hero">
  <div class="wrap">
    <div class="hero-tag rv"><i></i> Firma especializada en Lima, Perú</div>
    <h1 class="display rv" style="--d:.05s">Criterio legal para decisiones que <em>no admiten errores.</em></h1>
    <p class="lead rv" style="--d:.12s">Prevención de lavado de activos, compliance penal y defensa penal económica para empresas y personas. Le decimos con claridad dónde está el riesgo y qué hacer con él.</p>
    <div class="hero-acts rv" style="--d:.18s">
      <a href="#necesidad" class="b b-primary">Encontrar mi servicio @include('site.partials.icon', ['name' => 'arrow'])</a>
      <a href="#contacto" class="b b-ghost">Agendar una consulta</a>
    </div>

    <div class="need rv" id="necesidad">
      <div class="need-top"><h2>¿Qué necesita resolver hoy?</h2><span style="color:rgba(255,255,255,.6)">Elija su situación y le llevamos al servicio indicado.</span></div>
      <div class="need-grid">
        @foreach($services as $slug => $s)
          <a href="{{ route('services.show', $slug) }}">{{ $s['situation'] }} @include('site.partials.icon', ['name' => 'arrow'])</a>
        @endforeach
      </div>
    </div>

    <div class="facts">
      <div class="rv"><b>15+</b><span>años de experiencia en investigación financiera y prevención LA/FT</span></div>
      <div class="rv" style="--d:.06s"><b>6</b><span>áreas de práctica, del compliance a la defensa penal</span></div>
      <div class="rv" style="--d:.12s"><b>GAFI</b><span>estándares internacionales aplicados a la normativa peruana</span></div>
    </div>
  </div>
</section>

<div class="wrap"><div class="std rv"><span>Trabajamos con</span><b>Ley 30424</b><b>SBS / UIF</b><b>GAFI</b><b>ISO 37001</b><b>COSO</b></div></div>

<section class="sec" id="servicios">
  <div class="wrap">
    <div class="sec-head">
      <div><div class="kicker rv"><span class="n">01</span> Servicios</div><h2 class="h2 rv">Seis áreas, un mismo estándar de rigor.</h2></div>
      <p class="lead rv" style="max-width:440px">Cada servicio tiene su propia página, con herramientas para entender su caso antes de hablar con nosotros.</p>
    </div>
    <div class="svc">
      @foreach($services as $slug => $s)
        <article class="card card-link rv {{ $slug === 'criptoactivos-psav' ? 'feat' : '' }}" style="--d:{{ ($loop->index % 3) * 0.06 }}s;position:relative">
          @if($slug === 'criptoactivos-psav')<span class="pill info badge" style="background:rgba(127,163,255,.16);color:#fff">Especialidad</span>@endif
          <div class="icon-tile">@include('site.partials.icon', ['name' => $s['icon']])</div>
          <h3>{{ $s['name'] }}</h3>
          <p>{{ $s['card'] }}</p>
          <ul class="inc">@foreach($s['includes'] as $it)<li>@include('site.partials.icon', ['name' => 'check']) <span>{{ $it }}</span></li>@endforeach</ul>
          <div class="acts">
            @if(isset($s['cta2']))
              <a href="{{ route('services.show', $slug) }}#inmobiliario" class="b b-dark b-sm">{{ $s['cta'] }}</a>
              <a href="{{ route('services.show', $slug) }}#notarial" class="b b-ghost b-sm">{{ $s['cta2'] }}</a>
            @else
              <a href="{{ route('services.show', $slug) }}" class="b {{ $slug === 'criptoactivos-psav' ? 'b-light' : 'b-dark' }} b-sm">{{ $s['cta'] }} @include('site.partials.icon', ['name' => 'arrow'])</a>
            @endif
          </div>
        </article>
      @endforeach
    </div>
    <div class="card train rv">
      <div class="l"><div class="icon-tile">@include('site.partials.icon', ['name' => 'cap'])</div><div><h3>Capacitación y certificación</h3><p class="muted">Programas en prevención LA/FT y compliance corporativo para su equipo.</p></div></div>
      <a href="{{ route('capacitaciones') }}" class="b b-ghost">Ver programas @include('site.partials.icon', ['name' => 'arrow'])</a>
    </div>
  </div>
</section>

<section class="sec sec-dark on-dark">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv"><span class="n">02</span> Cómo trabajamos</div><h2 class="h2 rv">Claridad desde la primera conversación.</h2></div></div>
    <div class="steps4" id="steps4">
      <span class="ln"></span>
      @foreach([['Escuchamos', 'Una primera conversación para entender su caso, sus plazos y lo que está en juego.'], ['Diagnosticamos', 'Le decimos con claridad dónde está el riesgo, qué tan urgente es y qué opciones tiene.'], ['Ejecutamos', 'Documentos, defensas y respuestas preparadas con rigor técnico y a tiempo.'], ['Acompañamos', 'Seguimos a su lado hasta cerrar el caso o hasta que su sistema funcione por sí solo.']] as $i => [$t, $d])
        <div class="rv" style="--d:{{ $i * 0.12 }}s"><div class="no">{{ $i + 1 }}</div><h3>{{ $t }}</h3><p>{{ $d }}</p></div>
      @endforeach
    </div>
  </div>
</section>

<section class="sec" style="padding-bottom:clamp(48px,6vw,80px)">
  <div class="wrap">
    <div class="sec-head" style="margin-bottom:36px"><div><div class="kicker rv"><span class="n">03</span> Clientes</div><h2 class="h3 rv" style="font-size:clamp(1.4rem,2.6vw,2rem)">Organizaciones que confían en nuestro trabajo.</h2></div></div>
    <div class="logos rv">
      <div class="logos-track">
        @for($i = 0; $i < 2; $i++)
          <div><img src="{{ asset('images/clientes/red-digital.svg') }}" alt="Red Digital" loading="lazy"></div>
          <div><img src="{{ asset('images/clientes/qr-pay.png') }}" alt="QR Pay" loading="lazy"></div>
          <div class="txt">GoldLion</div>
          <div><img src="{{ asset('images/clientes/san-jorge.png') }}" alt="Créditos San Jorge" loading="lazy"></div>
        @endfor
      </div>
    </div>
  </div>
</section>

<section class="sec sec-soft" id="director">
  <div class="wrap dir">
    <div class="dir-photo rv"><img src="{{ asset('images/imagen.png') }}" alt="Denis Gabriel Romani Seminario" loading="lazy"></div>
    <div>
      <div class="kicker rv"><span class="n">04</span> Dirección</div>
      <h2 class="h2 rv">Denis Gabriel Romani Seminario</h2>
      <div class="role rv">Abogado especialista en compliance corporativo y ALA/CFT</div>
      <p class="lead rv">Máster en Derecho Penal por la Pontificia Universidad Católica del Perú y Máster en Cumplimiento Normativo Penal por la Universidad de Castilla-La Mancha. Más de quince años de experiencia en investigación financiera, prevención de lavado de activos y compliance corporativo.</p>
      <div class="chips rv"><span class="chip">PUCP</span><span class="chip">UCLM</span><span class="chip">ISO 37001:2021</span><span class="chip">Compliance Officer</span></div>
      <div class="contact rv">
        <a href="mailto:denis@romanicompliance.com" class="lnk">denis@romanicompliance.com</a>
        <a href="https://www.denisromani.com" class="lnk" target="_blank" rel="noopener">denisromani.com</a>
        <a href="{{ route('equipo') }}" class="lnk">Conocer al equipo @include('site.partials.icon', ['name' => 'arrow'])</a>
      </div>
    </div>
  </div>
</section>

@if($featuredCourses->isNotEmpty())
<section class="sec">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv"><span class="n">05</span> Formación</div><h2 class="h2 rv">Cursos para equipos que previenen.</h2></div><a href="{{ route('courses.catalog') }}" class="lnk rv">Ver todos los cursos @include('site.partials.icon', ['name' => 'arrow'])</a></div>
    <div class="posts">
      @foreach($featuredCourses as $course)
        <a href="{{ route('courses.show', $course) }}" class="post rv" style="--d:{{ $loop->index * 0.06 }}s">
          <div class="cv">@if($course->cover_image)<img src="{{ asset('storage/'.$course->cover_image) }}" alt="{{ $course->title }}" loading="lazy">@endif</div>
          <div class="bd">
            <div class="mt">{{ $course->category->name ?? 'Curso' }}@if($course->duration_minutes) · {{ $course->lectiveHours() }} {{ $course->lectiveHours() === 1 ? 'hora' : 'horas' }}@endif</div>
            <h3>{{ $course->title }}</h3>
            <p>{{ $course->description }}</p>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="sec {{ $featuredCourses->isNotEmpty() ? 'sec-soft' : '' }}" id="noticias">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Publicaciones</div><h2 class="h2 rv">Análisis y novedades regulatorias.</h2></div><a href="{{ route('blog.index') }}" class="lnk rv">Ver todas @include('site.partials.icon', ['name' => 'arrow'])</a></div>
    @if($recentArticles->isNotEmpty())
      <div class="posts">
        @foreach($recentArticles as $article)
          @include('blog._article-card', ['article' => $article])
        @endforeach
      </div>
    @else
      <p class="muted rv">Pronto publicaremos nuestros primeros análisis.</p>
    @endif
  </div>
</section>

<section class="sec" id="contacto">
  <div class="wrap ct">
    <div>
      <div class="kicker rv">Contacto</div>
      <h2 class="h2 rv">Cuéntenos su caso.</h2>
      <p class="lead rv" style="margin-top:18px">Responderemos a la brevedad para coordinar una primera conversación. Todo lo que nos cuente se trata con reserva.</p>
      <div class="ct-ch rv">
        <a href="https://wa.me/{{ \App\Support\ServiceCatalog::WHATSAPP }}" target="_blank" rel="noopener"><span class="icon-tile">@include('site.partials.icon', ['name' => 'chat'])</span><span>+51 969 754 983<small>WhatsApp</small></span></a>
        <a href="mailto:denis@romanicompliance.com"><span class="icon-tile">@include('site.partials.icon', ['name' => 'mail'])</span><span>denis@romanicompliance.com<small>Correo</small></span></a>
        <a href="mailto:dromani@pucp.pe"><span class="icon-tile">@include('site.partials.icon', ['name' => 'mail'])</span><span>dromani@pucp.pe<small>Correo alterno</small></span></a>
      </div>
    </div>
    <div class="form rv">
      <form id="ctForm" data-no-loader novalidate>
        <div class="row2">
          <div class="f"><label for="cNombre">Nombre</label><input id="cNombre" name="nombre" autocomplete="name" required></div>
          <div class="f"><label for="cTel">Teléfono</label><input id="cTel" name="telefono" type="tel" autocomplete="tel" placeholder="+51"></div>
        </div>
        <div class="f"><label for="cEmail">Correo</label><input id="cEmail" name="email" type="email" autocomplete="email" required></div>
        <div class="f"><label for="cServ">Tema</label>
          <select id="cServ" name="servicio">
            @foreach($services as $s)<option>{{ $s['name'] }}</option>@endforeach
            <option>Capacitación</option><option>Otro tema</option>
          </select></div>
        <div class="f"><label for="cMsg">Mensaje</label><textarea id="cMsg" name="mensaje" placeholder="Describa brevemente su situación"></textarea></div>
        <button type="submit" class="b b-primary b-block" id="ctBtn">Enviar consulta @include('site.partials.icon', ['name' => 'arrow'])</button>
        <p class="note" id="ctErr" style="color:var(--bad);display:none"></p>
      </form>
      <div class="form-ok" id="ctOk"><div class="icon-tile" style="margin:0 auto 16px;background:rgba(14,138,95,.1);color:var(--ok)">@include('site.partials.icon', ['name' => 'check'])</div><h3 class="h3">Recibimos su consulta.</h3><p class="muted" style="margin-top:8px">Le escribiremos a la brevedad.</p></div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
(function () {
  // Línea del método: se dibuja al entrar en pantalla
  const s4 = document.getElementById('steps4');
  new IntersectionObserver((es, o) => es.forEach((e) => { if (e.isIntersecting) { s4.classList.add('in'); o.disconnect(); } }), { threshold: 0.35 }).observe(s4);

  // ?servicio=... preselecciona el tema del formulario
  const pre = new URLSearchParams(location.search).get('servicio');
  if (pre) { const o = [...document.querySelectorAll('#cServ option')].find((x) => x.textContent.toLowerCase().includes(pre.toLowerCase())); if (o) o.selected = true; }

  const form = document.getElementById('ctForm');
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const d = Object.fromEntries(new FormData(form));
    const err = document.getElementById('ctErr');
    if (!d.nombre || !d.email || !/^\S+@\S+\.\S+$/.test(d.email)) { err.textContent = 'Indique su nombre y un correo válido.'; err.style.display = 'block'; return; }
    err.style.display = 'none';
    const btn = document.getElementById('ctBtn'); btn.disabled = true; btn.firstChild.textContent = 'Enviando ';
    const body = 'Consulta desde romanicompliance.com\n\nNombre: ' + d.nombre + '\nTeléfono: ' + (d.telefono || 'No indicado') + '\nCorreo: ' + d.email + '\nTema: ' + d.servicio + '\nMensaje: ' + (d.mensaje || 'Sin mensaje adicional');
    try {
      const r = await fetch('https://formsubmit.co/ajax/omaroliden1@gmail.com', { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, body: JSON.stringify({ name: d.nombre, email: d.email, message: body, _cc: 'dromani@pucp.pe', _subject: 'Consulta web · Romani Compliance' }) });
      if (!r.ok) throw new Error();
      form.style.display = 'none'; document.getElementById('ctOk').style.display = 'block';
    } catch (_) {
      btn.disabled = false; btn.firstChild.textContent = 'Enviar consulta ';
      err.innerHTML = 'No se pudo enviar. Escríbanos por <a href="' + RC.wa(body) + '" target="_blank" rel="noopener" style="text-decoration:underline">WhatsApp</a>.'; err.style.display = 'block';
    }
  });
})();
</script>
@endsection
