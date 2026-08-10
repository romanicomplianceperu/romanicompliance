@extends('layouts.app')

@section('title', 'Acceso administradores — Romani Compliance')

@section('styles')
.login-section { min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 5rem 0; background: var(--ivory); }
.login-card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 3rem; max-width: 420px; width: 92%; text-align: center; box-shadow: var(--shadow-m); }
.login-card img.brand { height: 30px; margin: 0 auto 1.5rem; }
.login-card h1 { font-size: 1.5rem; margin-bottom: 0.5rem; }
.login-card p { font-size: 0.85rem; color: var(--slate); margin-bottom: 2rem; line-height: 1.6; }
.admin-login-form { text-align: left; display: flex; flex-direction: column; gap: 14px; }
.admin-login-form label { font-size: 0.72rem; font-weight: 600; color: var(--slate); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; display: block; }
.admin-login-form input { width: 100%; padding: 11px 14px; border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.9rem; }
.admin-login-form input:focus { outline: none; border-color: var(--gold); }
.admin-login-error { font-size: 0.78rem; color: #B3413B; margin-top: -6px; }
@endsection

@section('content')
<section class="login-section">
  <div class="login-card reveal">
    <img src="{{ asset('images/logos.png') }}" alt="Romani Compliance" class="brand">
    <h1>Acceso administradores</h1>
    <p>Ingresa con tu usuario y contraseña de administrador. Este acceso es independiente del inicio de sesión con Google de los alumnos.</p>
    <form class="admin-login-form" method="POST" action="{{ route('admin.login.attempt') }}">
      @csrf
      <div>
        <label>Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')<div class="admin-login-error">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Contraseña</label>
        <input type="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center;margin-top:6px;">Ingresar</button>
    </form>
  </div>
</section>
@endsection
