@extends('layouts.app')

@section('title', 'Publicar en RomaniCompliance')

@section('styles')
.fc-gate-shell { min-height: calc(100vh - 71px); background: var(--ink); display: flex; align-items: center; justify-content: center; padding: 3rem 1.5rem; }
.fc-gate-box { max-width: 440px; width: 100%; background: var(--white); border-radius: 14px; padding: 2.6rem 2.4rem; box-shadow: 0 30px 60px rgba(0,0,0,0.35); text-align: center; }
.fc-gate-eyebrow { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; }
.fc-gate-box h1 { font-size: 1.5rem; color: var(--ink); font-weight: 600; line-height: 1.35; margin-bottom: 0.6rem; }
.fc-gate-box p.fc-sub { font-size: 0.88rem; color: var(--slate); margin-bottom: 1.8rem; }
.fc-gate-form { text-align: left; }
.fc-gate-form label { display: block; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-light); margin-bottom: 6px; }
.fc-gate-form input[type="text"] { width: 100%; box-sizing: border-box; padding: 13px 16px; border: 1px solid var(--line); border-radius: 8px; font-size: 1rem; letter-spacing: 0.05em; transition: border-color 0.2s; }
.fc-gate-form input[type="text"]:focus { outline: none; border-color: var(--gold); }
.fc-gate-hint { font-size: 0.72rem; color: var(--slate-light); margin: 6px 0 1.2rem; }
.fc-gate-error { background: rgba(179,65,59,0.08); border: 1px solid rgba(179,65,59,0.25); color: #B3413B; border-radius: 8px; padding: 10px 14px; font-size: 0.82rem; margin-bottom: 1.1rem; text-align: left; }
.fc-gate-submit { width: 100%; padding: 14px; background: var(--ink); color: var(--white); border: none; border-radius: 8px; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: background 0.25s; }
.fc-gate-submit:hover { background: var(--ink-light); }
.fc-gate-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--gold-pale); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.4rem; color: var(--gold); }
@endsection

@section('content')
<div class="fc-gate-shell">
  <div class="fc-gate-box">
    <div class="fc-gate-icon">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="5" y="11" width="14" height="9" rx="2"></rect><path d="M8 11V7a4 4 0 018 0v4"></path></svg>
    </div>
    <div class="fc-gate-eyebrow">RomaniCompliance — Redacción</div>
    <h1>Hola, Federico Chunga<br>¿Deseas publicar algo en RomaniCompliance?</h1>
    <p class="fc-sub">Ingresa la contraseña que te compartieron para abrir tu espacio de publicación.</p>

    @if ($errors->any())
      <div class="fc-gate-error">{{ $errors->first('password') }}</div>
    @endif

    <form method="POST" action="{{ route('federico.authenticate') }}" class="fc-gate-form">
      @csrf
      <label for="fc-password">Código de acceso</label>
      <input type="text" id="fc-password" name="password" required autofocus autocomplete="off" autocapitalize="off" spellcheck="false">
      <div class="fc-gate-hint">No distingue mayúsculas de minúsculas.</div>
      <button type="submit" class="fc-gate-submit">Ingresar →</button>
    </form>
  </div>
</div>
@endsection
