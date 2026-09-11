@extends('layouts.app')

@section('title', 'Solicitud enviada — Romani Compliance')

@section('styles')
.cv-thanks-shell { min-height: calc(100vh - 71px); display: flex; align-items: center; justify-content: center; background: linear-gradient(150deg, var(--ink) 0%, #16283F 55%, #1D3452 100%); padding: 3rem 1.5rem; text-align: center; }
.cv-thanks-box { max-width: 460px; animation: cvThanksIn 0.5s ease; }
@keyframes cvThanksIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
.cv-thanks-icon { width: 68px; height: 68px; border-radius: 50%; background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--ink); font-size: 1.8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
.cv-thanks-box h1 { font-family: var(--serif); font-size: 1.9rem; color: var(--white); margin-bottom: 1rem; font-weight: 600; }
.cv-thanks-box p { font-size: 0.95rem; color: rgba(255,255,255,0.7); line-height: 1.7; margin-bottom: 0.9rem; }
.cv-thanks-box .whatsapp-note { font-size: 0.82rem; color: var(--gold-light); font-weight: 600; }
.cv-thanks-back { display: inline-flex; margin-top: 1.8rem; color: rgba(255,255,255,0.55); font-size: 0.82rem; font-weight: 600; text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.25); }
@endsection

@section('content')
<div class="cv-thanks-shell">
  <div class="cv-thanks-box">
    <div class="cv-thanks-icon">✓</div>
    <h1>¡Gracias, {{ explode(' ', $name)[0] }}!</h1>
    <p>Recibimos tu solicitud. Revisaremos tu perfil con calma y muy pronto nos pondremos en contacto contigo.</p>
    <p class="whatsapp-note">Te escribiremos por WhatsApp en los próximos días.</p>
    <p>Gracias por tu interés en formar parte de Romani Compliance — para nosotros es muy valioso.</p>
    <a href="{{ route('academico.index') }}" class="cv-thanks-back">← Volver a Académico</a>
  </div>
</div>
@endsection
