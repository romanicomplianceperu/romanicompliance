@extends('layouts.app')

@section('title', 'Completa tu perfil — Romani Compliance')

@section('styles')
.profile-section { min-height: 55vh; display: flex; align-items: center; justify-content: center; padding: 4rem 0; background: var(--ivory); }
.profile-card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 3rem; max-width: 420px; width: 92%; text-align: center; box-shadow: var(--shadow-m); }
.profile-card .step-tag { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gold); background: var(--gold-pale); padding: 5px 14px; border-radius: 20px; display: inline-block; margin-bottom: 1.2rem; }
.profile-card h1 { font-size: 1.4rem; margin-bottom: 0.6rem; }
.profile-card p { font-size: 0.85rem; color: var(--slate); margin-bottom: 2rem; line-height: 1.6; }
.profile-card input { width: 100%; padding: 12px 14px; border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.95rem; text-align: center; margin-bottom: 1rem; }
.profile-card input:focus { outline: none; border-color: var(--gold); }
@endsection

@section('content')
<section class="profile-section">
  <div class="profile-card reveal">
    <span class="step-tag">Un último paso</span>
    <h1>Completa tu perfil</h1>
    <p>Solo necesitamos tu número de teléfono para continuar. Te lo pedimos una única vez.</p>
    <form action="{{ route('profile.update', $next ? ['next' => $next] : []) }}" method="POST">
      @csrf
      <input type="tel" name="phone" placeholder="+51 999 999 999" value="{{ old('phone') }}" autofocus required>
      <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center;">Continuar</button>
    </form>
  </div>
</section>
@endsection
