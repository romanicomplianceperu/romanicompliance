@extends('layouts.app')

@section('title', 'Capacitaciones · Romani Compliance')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
<div class="ac-shell ac-full">
  <a href="{{ route('aprendizaje.index') }}" class="ac-back-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
    Volver
  </a>
  <div class="ac-eyebrow">Aprendizaje</div>
  <h1 class="ac-title">Capacitaciones</h1>
  <p class="ac-subtitle">Estamos preparando esta sección. Muy pronto encontrará aquí nuestros programas de formación.</p>
</div>
@endsection
