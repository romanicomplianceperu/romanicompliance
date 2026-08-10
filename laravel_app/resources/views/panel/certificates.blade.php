@extends('layouts.panel')

@section('title', 'Mis certificados')

@section('styles')
.cert-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.cert-card { background: var(--white); border: 1px solid var(--line); border-radius: var(--radius); padding: 1.5rem; transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s; }
.cert-card:hover { box-shadow: var(--shadow-m); transform: translateY(-3px); border-color: var(--gold); }
.cert-card h4 { font-size: 1rem; margin-bottom: 0.6rem; }
.cert-meta { font-size: 0.72rem; color: var(--slate); text-transform: uppercase; letter-spacing: 0.04em; }
.cert-code { font-size: 0.7rem; color: var(--slate-light); margin: 0.4rem 0 1rem; }
.btn-continue { display: block; text-align: center; padding: 9px; background: var(--gold); color: var(--white); border-radius: var(--radius); font-size: 0.78rem; font-weight: 600; }
.btn-continue:hover { background: var(--gold-light); }
@media (max-width: 900px) { .cert-grid { grid-template-columns: 1fr; } }
@endsection

@section('content')
@foreach($certificateNotices as $notice)
  @include('courses._certificate-payment-banner', ['course' => $notice['course'], 'stage' => $notice['stage'], 'enrollment' => $notice['course']->enrollmentFor(auth()->user())])
@endforeach

@if($certificates->isEmpty() && $certificateNotices->isEmpty())
  <div class="empty-state">Aún no tienes certificados emitidos. Aparecerán aquí automáticamente cuando apruebes un curso.</div>
@elseif($certificates->isNotEmpty())
  <div class="cert-grid">
    @foreach($certificates as $certificate)
      <div class="cert-card">
        <h4>{{ $certificate->course->title }}</h4>
        <div class="cert-meta">Emitido: {{ $certificate->issued_at->format('d/m/Y') }}</div>
        <div class="cert-code">Código: {{ $certificate->code }}</div>
        <a href="{{ route('certificates.download', $certificate) }}" class="btn-continue">Descargar PDF</a>
      </div>
    @endforeach
  </div>
@endif
@endsection
