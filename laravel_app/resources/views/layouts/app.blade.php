<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Romani Compliance')</title>
<meta name="description" content="@yield('description', 'Romani Compliance: servicios especializados en Compliance corporativo, prevención de lavado de activos, derecho penal, Due Diligence e investigación financiera en Perú.')">
<link rel="icon" href="{{ asset('images/logos.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --ink: #0B1829;
  --ink-90: #142236;
  --ink-light: #1C2E45;
  --ivory: #FAFAF6;
  --ivory-dim: #F0EFE9;
  --gold: #8B7340;
  --gold-light: #B89A56;
  --gold-pale: rgba(139,115,64,0.08);
  --slate: #5A6475;
  --slate-light: #8A919D;
  --white: #FFFFFF;
  --line: #DDD9D0;
  --green-wa: #25D366;
  --li-blue: #0A66C2;
  --radius: 4px;
  --shadow-s: 0 2px 12px rgba(11,24,41,0.06);
  --shadow-m: 0 8px 32px rgba(11,24,41,0.08);
  --max: 1120px;
  --serif: 'Cormorant Garamond', Georgia, serif;
  --sans: 'Inter', system-ui, -apple-system, sans-serif;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { background: var(--ivory); color: var(--ink); font-family: var(--sans); font-size: 16px; line-height: 1.65; -webkit-font-smoothing: antialiased; }
img { max-width: 100%; display: block; }
a { color: inherit; text-decoration: none; }
h1, h2, h3, h4 { font-family: var(--serif); font-weight: 500; line-height: 1.2; }
.wrap { max-width: var(--max); margin: 0 auto; padding: 0 24px; }

/* NAV */
.nav-bar { position: sticky; top: 0; z-index: 100; background: rgba(255,255,255,0.92); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid var(--line); transition: box-shadow 0.3s; }
.nav-bar.scrolled { box-shadow: 0 2px 20px rgba(11,24,41,0.08); }
.nav-inner { display: flex; align-items: center; justify-content: space-between; padding: 14px 24px; max-width: var(--max); margin: 0 auto; }
.nav-logo img { height: 32px; }
.nav-links { display: flex; align-items: center; gap: 24px; }
.nav-links a { font-size: 0.78rem; font-weight: 500; letter-spacing: 0.04em; text-transform: uppercase; color: var(--slate); transition: color 0.2s; }
.nav-links a:hover { color: var(--ink); }
.nav-links a.active { color: var(--ink); font-weight: 700; }
.nav-cta { font-size: 0.75rem !important; font-weight: 600 !important; color: var(--white) !important; background: var(--ink); padding: 8px 20px; border-radius: var(--radius); transition: background 0.2s; }
.nav-cta:hover { background: var(--ink-light) !important; }
.nav-avatar { width: 30px; height: 30px; border-radius: 50%; object-fit: cover; border: 1px solid var(--line); }
.nav-toggle { display: none; background: none; border: none; cursor: pointer; padding: 4px; }
.nav-toggle span { display: block; width: 22px; height: 2px; background: var(--ink); margin: 5px 0; transition: 0.3s; }

/* BUTTONS */
.btn { display: inline-flex; align-items: center; gap: 8px; padding: 13px 30px; font-family: var(--sans); font-size: 0.82rem; font-weight: 600; border-radius: var(--radius); border: none; cursor: pointer; transition: all 0.3s; text-decoration: none; }
.btn-gold { background: var(--gold); color: var(--white); }
.btn-gold:hover { background: var(--gold-light); transform: translateY(-1px); }
.btn-ghost { background: transparent; border: 1px solid rgba(255,255,255,0.2); color: var(--white); }
.btn-ghost:hover { border-color: rgba(255,255,255,0.5); }
.btn-ghost-dark { background: transparent; border: 1px solid var(--line); color: var(--ink); }
.btn-ghost-dark:hover { border-color: var(--ink); }

/* SECTION HEADER (shared) */
.section-header { margin-bottom: 3rem; }
.section-header h2 { font-size: clamp(1.5rem, 3vw, 2.2rem); margin-bottom: 0.5rem; }
.section-header p { font-size: 0.9rem; color: var(--slate); max-width: 480px; }
.section-header .gold-line, .gold-line { width: 40px; height: 2px; background: var(--gold); margin-bottom: 1rem; }

/* FOOTER */
footer { background: var(--ink-90); padding: 2.5rem 0; border-top: 1px solid rgba(255,255,255,0.05); }
.footer-inner { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
.footer-brand img { height: 24px; filter: brightness(0) invert(1); opacity: 0.5; }
.footer-links { display: flex; gap: 24px; }
.footer-links a { font-size: 0.72rem; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 0.04em; transition: color 0.2s; }
.footer-links a:hover { color: var(--gold-light); }
.footer-copy { width: 100%; text-align: center; font-size: 0.68rem; color: rgba(255,255,255,0.2); margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.04); }

/* WHATSAPP */
.wa-float { position: fixed; bottom: 28px; right: 28px; z-index: 90; width: 56px; height: 56px; background: var(--green-wa); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(37,211,102,0.35); transition: transform 0.3s, box-shadow 0.3s; }
.wa-float:hover { transform: scale(1.1); box-shadow: 0 6px 24px rgba(37,211,102,0.45); }
.wa-float svg { width: 28px; height: 28px; fill: #fff; }

/* REVEAL ANIMATIONS */
.reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.7s cubic-bezier(0.22,1,0.36,1), transform 0.7s cubic-bezier(0.22,1,0.36,1); }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-left { opacity: 0; transform: translateX(-40px); transition: opacity 0.7s cubic-bezier(0.22,1,0.36,1), transform 0.7s cubic-bezier(0.22,1,0.36,1); }
.reveal-left.visible { opacity: 1; transform: translateX(0); }
.reveal-right { opacity: 0; transform: translateX(40px); transition: opacity 0.7s cubic-bezier(0.22,1,0.36,1), transform 0.7s cubic-bezier(0.22,1,0.36,1); }
.reveal-right.visible { opacity: 1; transform: translateX(0); }
.reveal-scale { opacity: 0; transform: scale(0.92); transition: opacity 0.7s cubic-bezier(0.22,1,0.36,1), transform 0.7s cubic-bezier(0.22,1,0.36,1); }
.reveal-scale.visible { opacity: 1; transform: scale(1); }
.stagger-1, .s1 { transition-delay: 0.06s; }
.stagger-2, .s2 { transition-delay: 0.14s; }
.stagger-3, .s3 { transition-delay: 0.22s; }
.stagger-4, .s4 { transition-delay: 0.3s; }
.stagger-5 { transition-delay: 0.33s; }
.stagger-6 { transition-delay: 0.4s; }

@media (max-width: 680px) {
  .nav-links { display: none; flex-direction: column; position: absolute; top: 100%; left: 0; right: 0; background: var(--white); border-bottom: 1px solid var(--line); padding: 1rem 24px; gap: 16px; }
  .nav-links.open { display: flex; }
  .nav-toggle { display: block; }
  .footer-inner { flex-direction: column; text-align: center; }
  .footer-links { flex-wrap: wrap; justify-content: center; }
}
@media (prefers-reduced-motion: reduce) {
  .reveal, .reveal-left, .reveal-right, .reveal-scale { opacity: 1; transform: none; transition: none; }
}

/* ── FLASH MESSAGES ── */
.flash-banner { padding: 12px 24px; text-align: center; font-size: 0.85rem; font-weight: 500; }
.flash-banner.success { background: rgba(37,150,90,0.1); color: #1F7A4D; }
.flash-banner.info { background: var(--gold-pale); color: var(--gold); }
.flash-banner.error { background: rgba(179,65,59,0.08); color: #B3413B; }

/* ── CERTIFICATE TYPE BADGE (shared: home, catalog, course show, admin) ── */
.cert-type-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; padding: 4px 10px; border-radius: 20px; }
.cert-type-badge.free { background: rgba(37,150,90,0.12); color: #1F7A4D; }
.cert-type-badge.optional { background: var(--gold-pale); color: var(--gold); }

/* ── MODAL OVERLAY (shared: contact, purchase, course gating) ── */
.modal-overlay { display: none; position: fixed; inset: 0; z-index: 200; align-items: center; justify-content: center; }
.modal-overlay.active { display: flex; }
.modal-backdrop { position: absolute; inset: 0; background: rgba(11,24,41,0.5); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); animation: fadeIn 0.3s ease; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { opacity: 0; transform: translateY(32px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
.modal-box { position: relative; z-index: 1; background: var(--white); border-radius: 8px; max-width: 520px; width: 92%; padding: 2.5rem; box-shadow: 0 24px 80px rgba(11,24,41,0.25); animation: slideUp 0.4s ease; max-height: 90vh; overflow-y: auto; }
.modal-box h3 { font-size: 1.4rem; margin-bottom: 0.3rem; }
.modal-box .modal-sub { font-size: 0.82rem; color: var(--slate); margin-bottom: 1.5rem; }
.modal-box p.modal-text { font-size: 0.88rem; color: var(--slate); line-height: 1.7; margin-bottom: 1.5rem; }
.modal-close { position: absolute; top: 16px; right: 20px; background: none; border: none; font-size: 1.4rem; cursor: pointer; color: var(--slate-light); transition: color 0.2s; line-height: 1; }
.modal-close:hover { color: var(--ink); }
.modal-price { font-family: var(--serif); font-size: 2.1rem; font-weight: 600; color: var(--ink); margin-bottom: 1.5rem; }
.modal-price span { font-size: 0.85rem; color: var(--slate); font-family: var(--sans); font-weight: 500; }
.btn-whatsapp { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: var(--green-wa); color: var(--white); border-radius: var(--radius); font-family: var(--sans); font-size: 0.85rem; font-weight: 600; width: 100%; justify-content: center; }
.btn-whatsapp:hover { background: #1fb955; }
.btn-whatsapp svg { width: 18px; height: 18px; fill: currentColor; }
@media (max-width: 680px) {
  .modal-box { padding: 1.5rem; }
}

/* ── ARTICLE CARD (shared: blog index, author page, related) ── */
.article-card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; overflow: hidden; display: block; transition: box-shadow 0.4s, transform 0.4s, border-color 0.4s; }
.article-card:hover { box-shadow: var(--shadow-m); transform: translateY(-4px); border-color: var(--gold); }
.article-card-cover { aspect-ratio: 16 / 9; background: var(--ink); position: relative; overflow: hidden; }
.article-card-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
.article-card-category { position: absolute; top: 12px; left: 12px; font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; background: var(--gold); color: var(--white); padding: 4px 10px; border-radius: 20px; }
.article-card-body { padding: 1.4rem; }
.article-card-meta { font-size: 0.7rem; color: var(--slate-light); margin-bottom: 0.6rem; }
.article-card-body h3 { font-size: 1.02rem; margin-bottom: 0.6rem; line-height: 1.35; }
.article-card-body p { font-size: 0.82rem; color: var(--slate); line-height: 1.6; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.article-card-author { display: flex; align-items: center; gap: 8px; padding-top: 0.9rem; border-top: 1px solid var(--line); }
.article-card-author img { width: 26px; height: 26px; border-radius: 50%; object-fit: cover; }
.article-card-author span { font-size: 0.76rem; color: var(--slate); font-weight: 600; }

@yield('styles')
</style>
</head>
<body>

<nav class="nav-bar" id="navBar">
  <div class="nav-inner">
    <a href="{{ route('home') }}" class="nav-logo"><img src="{{ asset('images/logos.png') }}" alt="Romani Compliance"></a>
    <button class="nav-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')" aria-label="Menú">
      <span></span><span></span><span></span>
    </button>
    <div class="nav-links">
      <a href="{{ route('home') }}#servicios">Servicios</a>
      <a href="{{ route('capacitaciones') }}" class="{{ request()->routeIs('capacitaciones') ? 'active' : '' }}">Capacitaciones</a>
      <a href="{{ route('home') }}#nosotros">Sobre nosotros</a>
      <a href="{{ route('equipo') }}" class="{{ request()->routeIs('equipo') ? 'active' : '' }}">Equipo</a>
      <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Noticias</a>
      <a href="{{ route('home') }}#contacto">Contacto</a>
      <a href="{{ route('courses.catalog') }}" class="{{ request()->routeIs('courses.*', 'lessons.*') ? 'active' : '' }}">Cursos</a>
      @auth
        <a href="{{ route('dashboard') }}" title="Mi panel"><img src="{{ auth()->user()->avatar ?? asset('images/logos.png') }}" alt="{{ auth()->user()->name }}" class="nav-avatar"></a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
          @csrf
          <button type="submit" class="nav-cta" style="border:none;cursor:pointer;">Salir</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="nav-cta">Ingresar</a>
      @endauth
    </div>
  </div>
</nav>

@if(session('success'))
  <div class="flash-banner success">{{ session('success') }}</div>
@endif
@if(session('info'))
  <div class="flash-banner info">{{ session('info') }}</div>
@endif
@if(session('error'))
  <div class="flash-banner error">{{ session('error') }}</div>
@endif

@yield('content')

<footer>
  <div class="wrap">
    <div class="footer-inner">
      <a href="{{ route('home') }}" class="footer-brand"><img src="{{ asset('images/logos.png') }}" alt="Romani Compliance"></a>
      <div class="footer-links">
        <a href="{{ route('home') }}#servicios">Servicios</a>
        <a href="{{ route('capacitaciones') }}">Capacitaciones</a>
        <a href="{{ route('equipo') }}">Equipo</a>
        <a href="{{ route('blog.index') }}">Noticias</a>
        <a href="{{ route('home') }}#contacto">Contacto</a>
      </div>
    </div>
    <div class="footer-copy">
      2026 Romani Compliance. Compliance · ALA/CFT · Due Diligence · Investigación Financiera. Todos los derechos reservados.
    </div>
  </div>
</footer>

<a href="https://wa.me/51969754983?text=Hola%2C%20deseo%20consultar%20sobre%20los%20servicios%20de%20Romani%20Compliance." class="wa-float" target="_blank" aria-label="WhatsApp">
  <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<script>
window.addEventListener('scroll', () => {
  document.getElementById('navBar').classList.toggle('scrolled', window.scrollY > 20);
});
const obs = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach(el => obs.observe(el));
</script>
@yield('scripts')
</body>
</html>
