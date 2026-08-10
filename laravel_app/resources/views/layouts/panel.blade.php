<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Mi panel') — Romani Compliance</title>
<link rel="icon" href="{{ asset('images/logos.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --ink: #0B1829; --ink-90: #142236; --ink-light: #1C2E45;
  --ivory: #FAFAF6; --ivory-dim: #F0EFE9;
  --gold: #8B7340; --gold-light: #B89A56; --gold-pale: rgba(139,115,64,0.08);
  --slate: #5A6475; --slate-light: #8A919D; --white: #FFFFFF; --line: #DDD9D0;
  --danger: #B3413B; --danger-pale: rgba(179,65,59,0.08);
  --green: #1F7A4D; --green-wa: #25D366;
  --radius: 4px; --shadow-s: 0 2px 12px rgba(11,24,41,0.06); --shadow-m: 0 8px 32px rgba(11,24,41,0.08);
  --serif: 'Cormorant Garamond', Georgia, serif; --sans: 'Inter', system-ui, sans-serif;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--ivory); color: var(--ink); font-family: var(--sans); font-size: 15px; line-height: 1.6; }
a { color: inherit; text-decoration: none; }
h1, h2, h3 { font-family: var(--serif); font-weight: 600; line-height: 1.2; }
img { max-width: 100%; display: block; }

.panel-layout { display: flex; min-height: 100vh; }
.panel-sidebar { width: 250px; flex-shrink: 0; background: var(--ink); color: var(--white); display: flex; flex-direction: column; }
.panel-sidebar-brand { display: block; padding: 1.6rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
.panel-sidebar-brand img { height: 26px; filter: brightness(0) invert(1); }
.panel-sidebar-label { padding: 1.2rem 1.5rem 0.6rem; font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.3); }
.panel-nav { flex: 1; padding: 0 0.9rem; }
.panel-nav a { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 6px; font-size: 0.86rem; font-weight: 500; color: rgba(255,255,255,0.62); margin-bottom: 3px; transition: background 0.2s, color 0.2s; }
.panel-nav a svg { width: 18px; height: 18px; flex-shrink: 0; }
.panel-nav a:hover { background: rgba(255,255,255,0.05); color: var(--white); }
.panel-nav a.active { background: var(--gold-pale); color: var(--gold-light); font-weight: 600; }
.panel-sidebar-foot { padding: 1rem 1.2rem; border-top: 1px solid rgba(255,255,255,0.08); }
.panel-sidebar-foot a { display: flex; align-items: center; gap: 8px; font-size: 0.78rem; color: rgba(255,255,255,0.4); padding: 8px 0.3rem; transition: color 0.2s; }
.panel-sidebar-foot a:hover { color: var(--gold-light); }
.panel-sidebar-foot svg { width: 15px; height: 15px; }

.panel-main { flex: 1; min-width: 0; }
.panel-topbar { background: var(--white); border-bottom: 1px solid var(--line); padding: 1.1rem 2rem; display: flex; align-items: center; justify-content: space-between; }
.panel-topbar h1 { font-size: 1.35rem; }
.panel-user { display: flex; align-items: center; gap: 12px; }
.panel-user-avatar { position: relative; width: 40px; height: 40px; flex-shrink: 0; }
.panel-user-avatar img, .panel-user-avatar .initials { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
.panel-user-avatar .initials { background: var(--gold); color: var(--white); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; font-family: var(--sans); }
.panel-user-avatar .dot { position: absolute; bottom: 0; right: 0; width: 11px; height: 11px; border-radius: 50%; background: var(--green); border: 2px solid var(--white); }
.panel-user-menu { position: relative; }
.panel-logout-form { display: inline; }
.panel-logout-btn { background: none; border: none; cursor: pointer; font-family: var(--sans); font-size: 0.78rem; font-weight: 600; color: var(--slate); padding: 6px 4px; }
.panel-logout-btn:hover { color: var(--danger); }
.panel-content { padding: 2.2rem; max-width: 1080px; }

.btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 26px; font-family: var(--sans); font-size: 0.82rem; font-weight: 600; border-radius: var(--radius); border: none; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-gold { background: var(--gold); color: var(--white); }
.btn-gold:hover { background: var(--gold-light); }
.btn-outline { background: transparent; border: 1px solid var(--line); color: var(--ink); }
.btn-outline:hover { border-color: var(--gold); color: var(--gold); }
.btn-block { display: flex; justify-content: center; width: 100%; text-align: center; }

.alert { padding: 12px 16px; border-radius: var(--radius); font-size: 0.85rem; margin-bottom: 1.5rem; }
.alert-success { background: rgba(37,150,90,0.08); color: #1F7A4D; border: 1px solid rgba(37,150,90,0.2); }
.alert-info { background: var(--gold-pale); color: var(--gold); border: 1px solid rgba(139,115,64,0.2); }
.alert-danger { background: var(--danger-pale); color: var(--danger); border: 1px solid rgba(179,65,59,0.2); }

.card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 1.6rem; margin-bottom: 1.5rem; }
.empty-state { text-align: center; padding: 3rem 1rem; color: var(--slate); font-size: 0.88rem; border: 1px dashed var(--line); border-radius: 6px; }
.panel-page-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.6rem; flex-wrap: wrap; gap: 0.8rem; }

.form-group { margin-bottom: 1.2rem; }
.form-group label { display: block; font-size: 0.72rem; font-weight: 600; color: var(--slate); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
.form-group input { width: 100%; max-width: 360px; padding: 10px 13px; border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.9rem; color: var(--ink); }
.form-hint { font-size: 0.74rem; color: var(--slate-light); margin-top: 4px; }

@media (max-width: 880px) {
  .panel-layout { flex-direction: column; }
  .panel-sidebar { width: 100%; flex-direction: row; align-items: center; padding: 0.6rem 1rem; }
  .panel-sidebar-brand { padding: 0; border-bottom: none; margin-right: 0.8rem; flex-shrink: 0; }
  .panel-sidebar-brand img { height: 20px; }
  .panel-sidebar-label { display: none; }
  .panel-nav { flex: 1; display: flex; overflow-x: auto; padding: 0; gap: 4px; }
  .panel-nav a { white-space: nowrap; margin-bottom: 0; }
  .panel-nav a span.nav-label { display: none; }
  .panel-sidebar-foot { display: none; }
  .panel-topbar { padding: 0.9rem 1.2rem; flex-wrap: wrap; gap: 0.6rem; }
  .panel-topbar h1 { font-size: 1.1rem; }
  .panel-content { padding: 1.2rem; }
}
@yield('styles')
</style>
</head>
<body>
<div class="panel-layout">
  <aside class="panel-sidebar">
    <a href="{{ route('home') }}" class="panel-sidebar-brand" title="Volver al inicio"><img src="{{ asset('images/logos.png') }}" alt="Romani Compliance"></a>
    <div class="panel-sidebar-label">Mi panel</div>
    <nav class="panel-nav">
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5V6a2 2 0 012-2h8.5L20 8.5V19.5a1.5 1.5 0 01-1.5 1.5h-13A1.5 1.5 0 014 19.5z"/><path d="M14 4v4.5a1.5 1.5 0 001.5 1.5H20"/></svg>
        <span class="nav-label">Mis cursos</span>
      </a>
      <a href="{{ route('panel.certificates') }}" class="{{ request()->routeIs('panel.certificates') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M8.5 12.5L7 21l5-2.5L17 21l-1.5-8.5"/></svg>
        <span class="nav-label">Mis certificados</span>
      </a>
      <a href="{{ route('panel.calendar') }}" class="{{ request()->routeIs('panel.calendar') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3.5" y="5" width="17" height="16" rx="2"/><path d="M8 3v4M16 3v4M3.5 10h17"/></svg>
        <span class="nav-label">Mi calendario</span>
      </a>
      <a href="{{ route('panel.profile') }}" class="{{ request()->routeIs('panel.profile') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c1.2-3.6 4-5.5 7-5.5s5.8 1.9 7 5.5"/></svg>
        <span class="nav-label">Mi perfil</span>
      </a>
    </nav>
    <div class="panel-sidebar-foot">
      <a href="{{ route('home') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        Volver al sitio
      </a>
    </div>
  </aside>

  <div class="panel-main">
    <div class="panel-topbar">
      <h1>@yield('title', 'Mi panel')</h1>
      <div class="panel-user">
        <form action="{{ route('logout') }}" method="POST" class="panel-logout-form">
          @csrf
          <button type="submit" class="panel-logout-btn">Salir</button>
        </form>
        <a href="{{ route('panel.profile') }}" class="panel-user-avatar" title="{{ auth()->user()->name }}">
          @if(auth()->user()->displayPhoto())
            <img src="{{ auth()->user()->displayPhoto() }}" alt="{{ auth()->user()->name }}">
          @else
            <div class="initials">{{ \Illuminate\Support\Str::of(auth()->user()->name)->explode(' ')->map(fn($p) => mb_substr($p, 0, 1))->take(2)->implode('') }}</div>
          @endif
          <span class="dot"></span>
        </a>
      </div>
    </div>
    <div class="panel-content">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger">
          <ul style="margin-left:1rem">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      @yield('content')
    </div>
  </div>
</div>
@yield('scripts')
</body>
</html>
