@extends('layouts.app')

@section('title', 'Crear cuenta — Romani Compliance')

@section('styles')
.login-section { min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 5rem 0; background: var(--ivory); }
.login-card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 3rem; max-width: 460px; width: 92%; text-align: center; box-shadow: var(--shadow-m); }
.login-card img.brand { height: 30px; margin: 0 auto 1.5rem; }
.login-card h1 { font-size: 1.5rem; margin-bottom: 0.5rem; }
.login-card p { font-size: 0.85rem; color: var(--slate); margin-bottom: 2rem; line-height: 1.6; }
.password-form { text-align: left; display: flex; flex-direction: column; gap: 14px; }
.password-form label { font-size: 0.72rem; font-weight: 600; color: var(--slate); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; display: block; }
.password-form input { width: 100%; padding: 11px 14px; border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.9rem; }
.password-form input:focus { outline: none; border-color: var(--gold); }
.form-error { font-size: 0.78rem; color: #B3413B; margin-top: -6px; }
.form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.cert-name-hint { display: flex; gap: 8px; align-items: flex-start; background: var(--gold-pale); color: var(--gold); font-size: 0.76rem; line-height: 1.5; padding: 10px 12px; border-radius: var(--radius); margin-top: -4px; }
.cert-name-hint svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 2px; }
.register-note { font-size: 0.8rem; color: var(--slate); margin-top: 1.6rem; }
.register-note a { color: var(--gold); font-weight: 600; }
@media (max-width: 480px) { .form-row-2 { grid-template-columns: 1fr; } }
@endsection

@section('content')
<section class="login-section">
  <div class="login-card reveal">
    <img src="{{ asset('images/logos.png') }}" alt="Romani Compliance" class="brand">
    <h1>Crear una cuenta</h1>
    <p>Regístrate con tu correo para inscribirte en cursos y obtener tus certificados.</p>

    <form class="password-form" method="POST" action="{{ route('register.store', request('intended') ? ['intended' => request('intended')] : []) }}">
      @csrf
      <input type="hidden" name="intended" value="{{ request('intended') }}">
      <div>
        <label>Nombre completo</label>
        <input type="text" name="name" value="{{ old('name') }}" required autofocus>
        <div class="cert-name-hint">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg>
          <span>Este nombre aparecerá en tus certificados. Escríbelo tal como quieres que se vea (podrás ajustarlo antes de cada certificado si lo necesitas).</span>
        </div>
        @error('name')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div>
        <label>Número de celular</label>
        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+51 999 999 999" required>
        @error('phone')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-row-2">
        <div>
          <label>Contraseña</label>
          <input type="password" name="password" required>
          @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div>
          <label>Confirmar contraseña</label>
          <input type="password" name="password_confirmation" required>
        </div>
      </div>
      <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center;margin-top:6px;">Crear cuenta</button>
    </form>

    <p class="register-note">¿Ya tienes cuenta? <a href="{{ route('login', request('intended') ? ['intended' => request('intended')] : []) }}">Inicia sesión</a></p>
  </div>
</section>
@endsection
