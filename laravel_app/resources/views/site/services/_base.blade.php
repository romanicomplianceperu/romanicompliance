{{-- Plantilla común de cada landing de servicio. Cada servicio define @section('tool') (su
     herramienta interactiva) y, si quiere, @section('extra') y @section('tool_scripts'). --}}
@extends('layouts.site')

@section('title', $service['name'].' · Romani Compliance')
@section('description', $service['card'])

@section('styles')
.sv-hero { position: relative; overflow: hidden; padding: clamp(56px, 8vw, 110px) 0 clamp(64px, 8vw, 104px); }
.sv-hero::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(var(--line) 1px, transparent 1px), linear-gradient(90deg, var(--line) 1px, transparent 1px); background-size: 56px 56px; mask-image: radial-gradient(ellipse 70% 60% at 75% 30%, #000 10%, transparent 75%); -webkit-mask-image: radial-gradient(ellipse 70% 60% at 75% 30%, #000 10%, transparent 75%); opacity: .7; }
.sv-hero::after { content: ''; position: absolute; width: 560px; height: 560px; right: -160px; top: -200px; border-radius: 50%; background: radial-gradient(circle, rgba(31,79,216,.16), transparent 65%); animation: drift 14s ease-in-out infinite alternate; }
@keyframes drift { to { transform: translate(-60px, 50px) scale(1.08); } }
.sv-hero .wrap { position: relative; z-index: 1; display: grid; grid-template-columns: 1.35fr 1fr; gap: 56px; align-items: end; }
.sv-crumb { display: flex; gap: 8px; align-items: center; font-size: 0.9rem; font-weight: 600; color: var(--muted); margin-bottom: 28px; }
.sv-crumb a:hover { color: var(--ink); }
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
.cta-box { background: var(--ink); color: #fff; border-radius: 30px; padding: clamp(36px, 6vw, 80px); display: grid; grid-template-columns: 1.3fr 1fr; gap: 40px; align-items: center; position: relative; overflow: hidden; }
.cta-box::after { content: ''; position: absolute; width: 480px; height: 480px; right: -140px; bottom: -220px; border-radius: 50%; background: radial-gradient(circle, rgba(127,163,255,.28), transparent 65%); }
.cta-box > * { position: relative; z-index: 1; }
.cta-box .lead { color: rgba(255,255,255,.7); margin-top: 16px; }
.cta-sum { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12); border-radius: 18px; padding: 20px; font-size: 0.95rem; color: rgba(255,255,255,.8); white-space: pre-line; margin-bottom: 16px; display: none; }
.cta-acts { display: grid; gap: 10px; }
@media (max-width: 900px) { .cta-box { grid-template-columns: 1fr; } }
.others { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.others .card { display: flex; flex-direction: column; gap: 14px; }
.others .card h3 { font-size: 1.15rem; font-weight: 800; letter-spacing: -0.015em; }
@media (max-width: 900px) { .others { grid-template-columns: 1fr; } }
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
        <a href="{{ \App\Support\ServiceCatalog::whatsapp('Hola, quisiera conversar sobre '.$service['name'].'.') }}" class="b b-ghost" target="_blank" rel="noopener">Hablar con el equipo</a>
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
      <div class="kicker rv"><span class="n">01</span> Herramienta</div>
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
      <div class="kicker rv"><span class="n">02</span> Cómo trabajamos</div>
      <h2 class="h2 rv">Un método claro, de principio a fin.</h2>
      <p class="lead rv" style="margin-top:18px">Sabrá en todo momento en qué etapa está su caso, qué estamos haciendo y qué sigue.</p>
    </div>
    <div class="tl">
      <div class="tl-fill"></div>
      @foreach($service['steps'] as $i => [$title, $text])
        <div class="tl-step rv" style="--d:{{ $i * 0.05 }}s"><div class="tl-dot">{{ $i + 1 }}</div><div><h3>{{ $title }}</h3><p>{{ $text }}</p></div></div>
      @endforeach
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <div class="sec-head">
      <div><div class="kicker rv"><span class="n">03</span> Lo que recibe</div><h2 class="h2 rv">Entregables concretos.</h2></div>
    </div>
    <div class="deliv">
      @foreach($service['deliverables'] as $i => $d)
        <div class="card rv" style="--d:{{ $i * 0.04 }}s">@include('site.partials.icon', ['name' => 'check']) {{ $d }}</div>
      @endforeach
    </div>
  </div>
</section>

<section class="sec sec-soft">
  <div class="wrap sv-split">
    <div class="sticky"><div class="kicker rv"><span class="n">04</span> Preguntas frecuentes</div><h2 class="h2 rv">Lo que suelen preguntarnos.</h2></div>
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
        <h2 class="h2">¿Conversamos sobre su caso?</h2>
        <p class="lead">Escríbanos y un abogado del equipo revisará su situación. La primera conversación sirve para entender el caso y decirle con claridad qué recomendamos.</p>
      </div>
      <div>
        <div class="cta-sum" id="ctaSum"></div>
        <div class="cta-acts">
          <a href="#" class="b b-light" id="ctaWa" target="_blank" rel="noopener">Enviar por WhatsApp @include('site.partials.icon', ['name' => 'arrow'])</a>
          <a href="mailto:denis@romanicompliance.com?subject={{ rawurlencode('Consulta: '.$service['name']) }}" class="b b-ghost-dark" id="ctaMail">Escribir un correo</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="sec sec-soft" style="padding-top:0;background:#fff">
  <div class="wrap">
    <div class="sec-head"><div><div class="kicker rv">Otros servicios</div><h2 class="h3 rv" style="font-size:1.6rem">También podemos ayudarle con</h2></div><a href="{{ route('home') }}#servicios" class="lnk rv">Ver todos @include('site.partials.icon', ['name' => 'arrow'])</a></div>
    <div class="others">
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
  const wa = document.getElementById('ctaWa');
  const mail = document.getElementById('ctaMail');

  // Resumen de lo que el cliente eligió: viaja en el WhatsApp y el correo finales.
  function summary(lines) {
    const text = lines.filter(Boolean).join('\n');
    sum.style.display = text ? 'block' : 'none';
    sum.textContent = text ? 'Su resumen\n' + text : '';
    const msg = 'Hola, quisiera conversar sobre ' + SERVICE + '.' + (text ? '\n\n' + text : '');
    wa.href = RC.wa(msg);
    mail.href = 'mailto:denis@romanicompliance.com?subject=' + encodeURIComponent('Consulta: ' + SERVICE) + '&body=' + encodeURIComponent(msg);
  }
  summary([]);

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
  return { summary, options, label, check };
})();
</script>
@yield('tool_scripts')
@endsection
