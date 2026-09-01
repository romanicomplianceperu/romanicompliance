@extends('layouts.app')

@section('title', 'Identifícate — Espacio Académico — Romani Compliance')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
<div class="ac-shell ac-full">
  <div class="ac-eyebrow">Un último paso</div>
  <h1 class="ac-title">¿Cómo te llamas?</h1>
  <p class="ac-subtitle">Solo tu nombre — lo usamos para guardar tus participaciones y tu progreso.</p>

  <div class="ac-id-card">
    <form method="POST" action="{{ route('academico.identify.store') }}">
      @csrf
      <input type="hidden" name="intended" value="{{ $intended }}">
      <label>Nombre completo</label>
      <input type="text" name="full_name" required autofocus autocomplete="off">
      <label>Correo electrónico (opcional)</label>
      <input type="email" name="email" autocomplete="off">
      <button type="submit" class="ac-btn-primary" style="width:100%;justify-content:center;">Continuar →</button>
    </form>
  </div>
</div>
@endsection
