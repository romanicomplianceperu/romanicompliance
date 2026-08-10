@extends('layouts.app')

@section('title', 'Validar certificado — Romani Compliance')

@section('styles')
.verify-section { min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 5rem 0; background: var(--ivory); }
.verify-card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 3rem; max-width: 460px; width: 92%; box-shadow: var(--shadow-m); }
.verify-card h1 { font-size: 1.5rem; margin-bottom: 0.5rem; text-align: center; }
.verify-card p { font-size: 0.85rem; color: var(--slate); margin-bottom: 1.5rem; text-align: center; line-height: 1.6; }
.verify-form { display: flex; gap: 10px; }
.verify-form input { flex: 1; padding: 12px 14px; border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.9rem; text-transform: uppercase; }
.verify-form input:focus { outline: none; border-color: var(--gold); }
@endsection

@section('content')
<section class="verify-section">
  <div class="verify-card reveal">
    <h1>Validar certificado</h1>
    <p>Ingrese el código único impreso en el certificado, o escanee el código QR directamente con su celular.</p>
    <form class="verify-form" action="{{ url('/verificar') }}" method="GET" onsubmit="event.preventDefault(); window.location.href='{{ url('/verificar') }}/' + encodeURIComponent(this.code.value.trim());">
      <input type="text" name="code" placeholder="RC-2026-XXXXXX" required>
      <button type="submit" class="btn btn-gold">Validar</button>
    </form>
  </div>
</section>
@endsection
