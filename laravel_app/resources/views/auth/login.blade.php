@extends('layouts.app')

@section('title', 'Ingresar — Romani Compliance')

@section('styles')
.login-section { min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 5rem 0; background: var(--ivory); }
.login-card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 3rem; max-width: 420px; width: 92%; text-align: center; box-shadow: var(--shadow-m); }
.login-card img.brand { height: 30px; margin: 0 auto 1.5rem; }
.login-card h1 { font-size: 1.5rem; margin-bottom: 0.5rem; }
.login-card p { font-size: 0.85rem; color: var(--slate); margin-bottom: 2rem; line-height: 1.6; }
.btn-google { display: flex; align-items: center; justify-content: center; gap: 12px; width: 100%; padding: 13px; background: var(--white); border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.85rem; font-weight: 600; color: var(--ink); cursor: pointer; transition: border-color 0.3s, box-shadow 0.3s; text-decoration: none; }
.btn-google:hover { border-color: var(--gold); box-shadow: var(--shadow-s); }
.btn-google svg { width: 20px; height: 20px; }
.login-divider { display: flex; align-items: center; gap: 12px; margin: 1.6rem 0; }
.login-divider::before, .login-divider::after { content: ''; flex: 1; height: 1px; background: var(--line); }
.login-divider span { font-size: 0.7rem; color: var(--slate-light); text-transform: uppercase; letter-spacing: 0.06em; }
.password-form { text-align: left; display: flex; flex-direction: column; gap: 14px; }
.password-form label { font-size: 0.72rem; font-weight: 600; color: var(--slate); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; display: block; }
.password-form input { width: 100%; padding: 11px 14px; border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.9rem; }
.password-form input:focus { outline: none; border-color: var(--gold); }
.form-error { font-size: 0.78rem; color: #B3413B; margin-top: -6px; }
.register-note { font-size: 0.8rem; color: var(--slate); margin-top: 1.6rem; }
.register-note a { color: var(--gold); font-weight: 600; }
@endsection

@section('content')
<section class="login-section">
  <div class="login-card reveal">
    <img src="{{ asset('images/logos.png') }}" alt="Romani Compliance" class="brand">
    <h1>Ingresar a la plataforma</h1>
    <p>Accede para inscribirte en cursos, ver tu progreso y descargar tus certificados.</p>

    <a href="{{ route('auth.google.redirect', request('intended') ? ['intended' => request('intended')] : []) }}" class="btn-google">
      <svg viewBox="0 0 48 48"><path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3c-1.6 4.6-6 8-11.3 8-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.1 8 3l6-6C34 5.1 29.3 3 24 3 12.4 3 3 12.4 3 24s9.4 21 21 21 21-9.4 21-21c0-1.4-.1-2.5-.4-3.5z"/><path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 15.9 18.9 13 24 13c3.1 0 5.8 1.1 8 3l6-6C34 5.1 29.3 3 24 3 16.1 3 9.3 7.5 6.3 14.7z"/><path fill="#4CAF50" d="M24 45c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 36.4 26.7 37 24 37c-5.3 0-9.7-3.4-11.3-8.1l-6.5 5C9.2 40.4 16 45 24 45z"/><path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.1-4.1 5.6l6.2 5.2C40.9 36 44 30.5 44 24c0-1.4-.1-2.5-.4-3.5z"/></svg>
      Continuar con Google
    </a>

    <div class="login-divider"><span>o con tu correo</span></div>

    <form class="password-form" method="POST" action="{{ route('login.attempt') }}">
      @csrf
      <input type="hidden" name="intended" value="{{ request('intended') }}">
      <div>
        <label>Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Contraseña</label>
        <input type="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center;margin-top:6px;">Ingresar</button>
    </form>

    <p class="register-note">¿No tienes cuenta? <a href="{{ route('register', request('intended') ? ['intended' => request('intended')] : []) }}">Regístrate aquí</a></p>
  </div>
</section>
@endsection
