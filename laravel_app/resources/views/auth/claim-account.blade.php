@extends('layouts.app')

@section('title', 'Guarda tu certificado — Romani Compliance')

@section('content')
<section style="padding:4rem 0;min-height:60vh;display:flex;align-items:center;">
  <div class="wrap" style="max-width:440px;">
    <div style="background:var(--white);border:1px solid var(--line);border-radius:8px;padding:2.2rem;box-shadow:var(--shadow-m);">
      <div style="font-size:0.72rem;color:var(--gold);font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.5rem;">Un último paso</div>
      <h1 style="font-size:1.4rem;margin-bottom:0.6rem;">Guarda tu certificado y tu progreso</h1>
      <p style="font-size:0.88rem;color:var(--slate);margin-bottom:1.6rem;">Crea una contraseña para poder volver a entrar cuando quieras y ver tu certificado, tu curso y tu progreso desde cualquier dispositivo.</p>

      <form action="{{ route('claim-account.store') }}" method="POST">
        @csrf
        <div class="form-group" style="margin-bottom:1rem;">
          <label style="display:block;font-size:0.75rem;font-weight:600;color:var(--slate);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:6px;">Correo electrónico</label>
          <input type="email" name="email" value="{{ old('email', str_ends_with($user->email, '@guest.romanicompliance.com') ? '' : $user->email) }}" required style="width:100%;padding:11px 14px;border:1px solid var(--line);border-radius:4px;font-size:0.9rem;">
        </div>
        <div class="form-group" style="margin-bottom:1rem;">
          <label style="display:block;font-size:0.75rem;font-weight:600;color:var(--slate);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:6px;">Contraseña</label>
          <input type="password" name="password" required minlength="8" style="width:100%;padding:11px 14px;border:1px solid var(--line);border-radius:4px;font-size:0.9rem;">
        </div>
        <div class="form-group" style="margin-bottom:1.4rem;">
          <label style="display:block;font-size:0.75rem;font-weight:600;color:var(--slate);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:6px;">Confirmar contraseña</label>
          <input type="password" name="password_confirmation" required minlength="8" style="width:100%;padding:11px 14px;border:1px solid var(--line);border-radius:4px;font-size:0.9rem;">
        </div>
        <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center;">Guardar mi cuenta</button>
      </form>
      <a href="{{ route('dashboard') }}" style="display:block;text-align:center;margin-top:14px;font-size:0.8rem;color:var(--slate-light);">Ahora no, continuar</a>
    </div>
  </div>
</section>
@endsection
