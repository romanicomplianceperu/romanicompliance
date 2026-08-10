@extends('layouts.app')

@section('title', 'Validación de certificado — Romani Compliance')

@section('styles')
.verify-section { min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 5rem 0; background: var(--ivory); }
.verify-result-card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 3rem; max-width: 520px; width: 92%; box-shadow: var(--shadow-m); text-align: center; }
.verify-icon { width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem; }
.verify-icon svg { width: 28px; height: 28px; }
.verify-icon.valid { background: rgba(37,150,90,0.12); color: #1F7A4D; }
.verify-icon.invalid { background: rgba(179,65,59,0.1); color: #B3413B; }
.verify-result-card h1 { font-size: 1.4rem; margin-bottom: 1.5rem; }
.verify-details { text-align: left; background: var(--ivory); border-radius: var(--radius); padding: 1.2rem 1.5rem; margin-top: 1rem; }
.verify-details .row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 0.85rem; border-bottom: 1px solid var(--line); }
.verify-details .row:last-child { border-bottom: none; }
.verify-details .row .label { color: var(--slate-light); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.04em; }
.verify-details .row .value { font-weight: 600; color: var(--ink); }
.verify-back { margin-top: 1.5rem; }
@endsection

@section('content')
<section class="verify-section">
  <div class="verify-result-card reveal">
    @if($certificate && !$certificate->isRevoked())
      <div class="verify-icon valid"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 13l4 4L19 7"/></svg></div>
      <h1>Certificado válido</h1>
      <div class="verify-details">
        <div class="row"><span class="label">Nombre</span><span class="value">{{ $certificate->holderDisplayName() }}</span></div>
        <div class="row"><span class="label">Curso</span><span class="value">{{ $certificate->course->title }}</span></div>
        <div class="row"><span class="label">Emitido</span><span class="value">{{ $certificate->issued_at->format('d/m/Y') }}</span></div>
        <div class="row"><span class="label">Código</span><span class="value">{{ $certificate->code }}</span></div>
      </div>
    @elseif($certificate && $certificate->isRevoked())
      <div class="verify-icon invalid"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 6l12 12M18 6L6 18"/></svg></div>
      <h1>Certificado revocado</h1>
      <p style="color:var(--slate);font-size:0.85rem;">Este certificado fue revocado por Romani Compliance y ya no es válido.</p>
    @else
      <div class="verify-icon invalid"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 6l12 12M18 6L6 18"/></svg></div>
      <h1>Certificado no encontrado</h1>
      <p style="color:var(--slate);font-size:0.85rem;">El código <strong>{{ $code }}</strong> no corresponde a ningún certificado emitido por Romani Compliance.</p>
    @endif
    <div class="verify-back">
      <a href="{{ route('certificates.verify.form') }}" class="btn btn-ghost-dark" style="border:1px solid var(--line);color:var(--ink);">Validar otro certificado</a>
    </div>
  </div>
</section>
@endsection
