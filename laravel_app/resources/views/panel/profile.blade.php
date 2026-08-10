@extends('layouts.panel')

@section('title', 'Mi perfil')

@section('styles')
.profile-header { display: flex; align-items: center; gap: 1.2rem; margin-bottom: 1.8rem; }
.profile-avatar { width: 64px; height: 64px; border-radius: 50%; object-fit: cover; }
.profile-avatar.initials { background: var(--gold); color: var(--white); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 700; }
.profile-header h3 { font-size: 1.15rem; margin-bottom: 2px; }
.profile-header p { font-size: 0.82rem; color: var(--slate); }
.google-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 0.72rem; color: var(--slate); background: var(--ivory); border: 1px solid var(--line); padding: 4px 10px; border-radius: 20px; margin-top: 6px; }
.google-badge svg { width: 13px; height: 13px; }
@endsection

@section('content')
<div class="card">
  <div class="profile-header">
    @if($user->displayPhoto())
      <img src="{{ $user->displayPhoto() }}" alt="{{ $user->name }}" class="profile-avatar">
    @else
      <div class="profile-avatar initials">{{ \Illuminate\Support\Str::of($user->name)->explode(' ')->map(fn($p) => mb_substr($p, 0, 1))->take(2)->implode('') }}</div>
    @endif
    <div>
      <h3>{{ $user->name }}</h3>
      <p>{{ $user->email }}</p>
      @if($user->google_id)
        <span class="google-badge">
          <svg viewBox="0 0 48 48"><path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3c-1.6 4.6-6 8-11.3 8-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.1 8 3l6-6C34 5.1 29.3 3 24 3 12.4 3 3 12.4 3 24s9.4 21 21 21 21-9.4 21-21c0-1.4-.1-2.5-.4-3.5z"/><path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 15.9 18.9 13 24 13c3.1 0 5.8 1.1 8 3l6-6C34 5.1 29.3 3 24 3 16.1 3 9.3 7.5 6.3 14.7z"/><path fill="#4CAF50" d="M24 45c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 36.4 26.7 37 24 37c-5.3 0-9.7-3.4-11.3-8.1l-6.5 5C9.2 40.4 16 45 24 45z"/><path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.1-4.1 5.6l6.2 5.2C40.9 36 44 30.5 44 24c0-1.4-.1-2.5-.4-3.5z"/></svg>
          Cuenta de Google
        </span>
      @endif
    </div>
  </div>

  <form action="{{ route('panel.profile.update') }}" method="POST">
    @csrf

    @if(! $user->google_id)
      <div class="form-group">
        <label>Nombre completo</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        <div class="form-hint">Este nombre se usa como valor por defecto para tus certificados.</div>
      </div>
    @endif

    <div class="form-group">
      <label>Número de celular</label>
      <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+51 999 999 999" required>
    </div>

    @if(! $user->google_id)
      <div class="form-group">
        <label>Nueva contraseña</label>
        <input type="password" name="password">
        <div class="form-hint">Déjalo en blanco si no quieres cambiarla.</div>
      </div>
      <div class="form-group">
        <label>Confirmar nueva contraseña</label>
        <input type="password" name="password_confirmation">
      </div>
    @else
      <p class="form-hint" style="margin-bottom:1.2rem;">Tu nombre y contraseña se gestionan desde tu cuenta de Google.</p>
    @endif

    <button type="submit" class="btn btn-gold">Guardar cambios</button>
  </form>
</div>
@endsection
