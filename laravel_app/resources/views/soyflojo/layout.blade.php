<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#000000">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Soy flojo') · Romani</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
<style>
:root { --ink: #0A1730; --accent: #1F4FD8; --accent-50: #EEF3FF; --blue: #1F4FD8; --blue-l: #7FA3FF; --blue-50: #EEF3FF; --bg: #F4F6FA; --card: #fff; --line: #E2E7F0; --muted: #55647C; --muted-2: #8B97AA; --ok: #0E8A5F; --ok-50: #E1F3EC; --warn: #C25B12; --warn-50: #FBEBDD; --bad: #C0362C; --bad-50: #F8E1DF; }
* { box-sizing: border-box; margin: 0; padding: 0; }
[hidden] { display: none !important; }
html { -webkit-text-size-adjust: 100%; }
body { font-family: 'Manrope', system-ui, sans-serif; background: #F3F5F9; color: var(--ink); font-size: 15px; line-height: 1.5; -webkit-font-smoothing: antialiased; padding-bottom: calc(24px + env(safe-area-inset-bottom)); }
a { color: inherit; text-decoration: none; }
button, input, select { font: inherit; color: inherit; }
.top { position: sticky; top: 0; z-index: 20; background: var(--ink); color: #fff; padding: calc(12px + env(safe-area-inset-top)) 16px 12px; display: flex; align-items: center; gap: 12px; }
.top .back { width: 36px; height: 36px; border-radius: 50%; display: grid; place-items: center; background: rgba(255,255,255,.1); flex-shrink: 0; }
.top .t { flex: 1; min-width: 0; }
.top .t b { display: block; font-size: 1.02rem; font-weight: 800; letter-spacing: -0.01em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.top .t small { color: rgba(255,255,255,.6); font-size: .78rem; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.top .ic-btn { width: 36px; height: 36px; border-radius: 50%; display: grid; place-items: center; background: rgba(255,255,255,.1); border: 0; cursor: pointer; flex-shrink: 0; }
.wrap { max-width: 640px; margin: 0 auto; padding: 16px 16px 0; }
.flash { margin: 12px 14px 0; background: var(--ok-50); color: var(--ok); border-radius: 14px; padding: 11px 14px; font-weight: 700; font-size: .9rem; max-width: 732px; }
@media (min-width: 790px) { .flash { margin: 12px auto 0; } }
.card { background: var(--card); border: 0; border-radius: 22px; padding: 16px; box-shadow: 0 1px 2px rgba(10,23,48,.05), 0 10px 30px -18px rgba(10,23,48,.25); }
.badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 999px; font-size: .74rem; font-weight: 800; white-space: nowrap; }
.b-ok { background: var(--ok-50); color: var(--ok); } .b-gray { background: #EEF0F4; color: var(--muted); } .b-warn { background: var(--warn-50); color: var(--warn); } .b-bad { background: var(--bad-50); color: var(--bad); } .b-blue { background: var(--blue-50); color: var(--blue); }
.btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 10px 14px; border-radius: 12px; border: 1px solid var(--line); background: #fff; font-weight: 700; font-size: .88rem; cursor: pointer; white-space: nowrap; }
.btn:active { transform: scale(.98); }
.btn-p { background: var(--blue); border-color: var(--blue); color: #fff; }
.btn-s { padding: 7px 11px; font-size: .82rem; border-radius: 10px; }
.muted { color: var(--muted); }
.ic { width: 18px; height: 18px; flex-shrink: 0; }
@yield('styles')
</style>
</head>
<body>
@yield('top')
@if(session('ok'))<div class="flash">{{ session('ok') }}</div>@endif
@if($errors->any())<div class="flash" style="background:var(--bad-50);color:var(--bad)">{{ $errors->first() }}</div>@endif
<main class="wrap">@yield('content')</main>
<script>
// Copiar el código de acceso con un toque
document.addEventListener('click', (e) => {
  const b = e.target.closest('[data-copy]'); if (!b) return;
  const t = b.getAttribute('data-copy');
  const done = () => { const o = b.innerHTML; b.classList.add('copied'); b.innerHTML = '✓ Copiado'; setTimeout(() => { b.innerHTML = o; b.classList.remove('copied'); }, 1400); };
  (navigator.clipboard ? navigator.clipboard.writeText(t) : Promise.reject()).then(done).catch(() => { const i = document.createElement('input'); i.value = t; document.body.appendChild(i); i.select(); try { document.execCommand('copy'); done(); } catch (_) {} i.remove(); });
});
</script>
@yield('scripts')
</body>
</html>
