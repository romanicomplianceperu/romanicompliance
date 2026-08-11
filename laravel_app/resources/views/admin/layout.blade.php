<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Panel administrativo') — Romani Compliance</title>
<link rel="icon" href="{{ asset('images/logos.png') }}">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --ink: #0B1829; --ink-90: #142236; --ink-light: #1C2E45;
  --ivory: #FAFAF6; --ivory-dim: #F0EFE9;
  --gold: #8B7340; --gold-light: #B89A56; --gold-pale: rgba(139,115,64,0.08);
  --slate: #5A6475; --slate-light: #8A919D; --white: #FFFFFF; --line: #DDD9D0;
  --danger: #B3413B; --danger-pale: rgba(179,65,59,0.08);
  --radius: 4px; --shadow-s: 0 2px 12px rgba(11,24,41,0.06); --shadow-m: 0 8px 32px rgba(11,24,41,0.08);
  --serif: 'Cormorant Garamond', Georgia, serif; --sans: 'Inter', system-ui, sans-serif;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--ivory); color: var(--ink); font-family: var(--sans); font-size: 15px; line-height: 1.6; }
a { color: inherit; text-decoration: none; }
h1, h2, h3 { font-family: var(--serif); font-weight: 600; line-height: 1.2; }
img { max-width: 100%; display: block; }

.admin-layout { display: flex; min-height: 100vh; }
.sidebar { width: 240px; flex-shrink: 0; background: var(--ink); color: var(--white); display: flex; flex-direction: column; }
.sidebar-brand { display: block; padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
.sidebar-brand img { height: 26px; filter: brightness(0) invert(1); }
.sidebar-nav { flex: 1; padding: 1.2rem 0.8rem; }
.sidebar-nav a { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: var(--radius); font-size: 0.85rem; font-weight: 500; color: rgba(255,255,255,0.6); margin-bottom: 2px; transition: background 0.2s, color 0.2s; }
.sidebar-nav a:hover { background: rgba(255,255,255,0.05); color: var(--white); }
.sidebar-nav a.active { background: var(--gold-pale); color: var(--gold-light); font-weight: 600; }
.sidebar-foot { padding: 1rem 1.2rem; border-top: 1px solid rgba(255,255,255,0.08); font-size: 0.78rem; color: rgba(255,255,255,0.35); }
.sidebar-foot a { color: var(--gold-light); }

.main { flex: 1; min-width: 0; }
.topbar { background: var(--white); border-bottom: 1px solid var(--line); padding: 1rem 2rem; display: flex; align-items: center; justify-content: space-between; }
.topbar h1 { font-size: 1.3rem; }
.topbar-user { display: flex; align-items: center; gap: 12px; font-size: 0.82rem; color: var(--slate); }
.topbar-user img { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
.content { padding: 2rem; max-width: 1100px; }

.btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; font-family: var(--sans); font-size: 0.82rem; font-weight: 600; border-radius: var(--radius); border: none; cursor: pointer; transition: all 0.2s; text-decoration: none; }
.btn-gold { background: var(--gold); color: var(--white); }
.btn-gold:hover { background: var(--gold-light); }
.btn-outline { background: transparent; border: 1px solid var(--line); color: var(--ink); }
.btn-outline:hover { border-color: var(--gold); color: var(--gold); }
.btn-danger { background: transparent; border: 1px solid var(--danger); color: var(--danger); }
.btn-danger:hover { background: var(--danger); color: var(--white); }
.btn-sm { padding: 6px 12px; font-size: 0.75rem; }

.card { background: var(--white); border: 1px solid var(--line); border-radius: 6px; padding: 1.5rem; margin-bottom: 1.5rem; }
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { text-align: left; padding: 12px 10px; font-size: 0.85rem; border-bottom: 1px solid var(--line); }
.table th { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.04em; color: var(--slate-light); font-weight: 600; }
.table tr:last-child td { border-bottom: none; }
.badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
.badge-gold { background: var(--gold-pale); color: var(--gold); }
.badge-gray { background: var(--ivory-dim); color: var(--slate); }

.form-group { margin-bottom: 1.2rem; }
.form-group label { display: block; font-size: 0.75rem; font-weight: 600; color: var(--slate); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
.form-group input[type=text], .form-group input[type=number], .form-group input[type=url], .form-group input[type=file], .form-group textarea, .form-group select {
  width: 100%; padding: 10px 12px; border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.88rem; color: var(--ink);
}
.form-group textarea { resize: vertical; min-height: 90px; }
.form-hint { font-size: 0.72rem; color: var(--slate-light); margin-top: 4px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
.form-check { display: flex; align-items: center; gap: 8px; }
.form-check input { width: auto; }

.alert { padding: 12px 16px; border-radius: var(--radius); font-size: 0.85rem; margin-bottom: 1.5rem; }
.alert-success { background: rgba(37,150,90,0.08); color: #1F7A4D; border: 1px solid rgba(37,150,90,0.2); }
.alert-danger { background: var(--danger-pale); color: var(--danger); border: 1px solid rgba(179,65,59,0.2); }

.empty-state { text-align: center; padding: 3rem 1rem; color: var(--slate); font-size: 0.88rem; border: 1px dashed var(--line); border-radius: 6px; }
.page-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.8rem; }
.table-wrap { overflow-x: auto; }

@media (max-width: 880px) {
  .admin-layout { flex-direction: column; }
  .sidebar { width: 100%; flex-direction: row; align-items: center; padding: 0.7rem 1rem; }
  .sidebar-brand { padding: 0; border-bottom: none; margin-right: 1rem; flex-shrink: 0; }
  .sidebar-brand img { height: 20px; }
  .sidebar-nav { flex: 1; display: flex; overflow-x: auto; padding: 0; gap: 4px; }
  .sidebar-nav a { white-space: nowrap; margin-bottom: 0; }
  .sidebar-foot { display: none; }
  .topbar { padding: 0.9rem 1.2rem; flex-wrap: wrap; gap: 0.6rem; }
  .topbar h1 { font-size: 1.1rem; }
  .content { padding: 1.2rem; }
  .form-row { grid-template-columns: 1fr; }
}
@media (max-width: 480px) {
  .topbar-user span { display: none; }
}
@yield('styles')
</style>
</head>
<body>
<div class="admin-layout">
  <aside class="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand"><img src="{{ asset('images/logos.png') }}" alt="Romani Compliance"></a>
    <nav class="sidebar-nav">
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Panel</a>
      <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Categorías</a>
      <a href="{{ route('admin.courses.index') }}" class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">Cursos</a>
      <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Alumnos</a>
      <a href="{{ route('admin.certificates.index') }}" class="{{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">Certificados</a>
      <a href="{{ route('admin.proyectos.index') }}" class="{{ request()->routeIs('admin.proyectos.*') ? 'active' : '' }}">Proyectos</a>
      <a href="{{ route('admin.empresas.index') }}" class="{{ request()->routeIs('admin.empresas.*') ? 'active' : '' }}">Empresas</a>
      <a href="{{ route('admin.articulos.index') }}" class="{{ request()->routeIs('admin.articulos.*') ? 'active' : '' }}">Artículos</a>
      <a href="{{ route('admin.administradores.index') }}" class="{{ request()->routeIs('admin.administradores.*') ? 'active' : '' }}">Administradores</a>
      <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Personalización</a>
      <a href="{{ route('admin.questions-support.index') }}" class="{{ request()->routeIs('admin.questions-support.*') ? 'active' : '' }}">Preguntas de alumnos</a>
    </nav>
    <div class="sidebar-foot">
      <a href="{{ route('home') }}">← Volver al sitio</a>
    </div>
  </aside>
  <div class="main">
    <div class="topbar">
      <h1>@yield('title', 'Panel administrativo')</h1>
      <div class="topbar-user">
        <span>{{ auth()->user()->name }}</span>
        @if(auth()->user()->displayPhoto())
          <img src="{{ auth()->user()->displayPhoto() }}" alt="{{ auth()->user()->name }}">
        @else
          <span style="width:32px;height:32px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:var(--gold);color:var(--white);font-size:0.72rem;font-weight:700;">{{ \Illuminate\Support\Str::of(auth()->user()->name)->explode(' ')->map(fn($p) => mb_substr($p, 0, 1))->take(2)->implode('') }}</span>
        @endif
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-outline btn-sm">Salir</button>
        </form>
      </div>
    </div>
    <div class="content">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
