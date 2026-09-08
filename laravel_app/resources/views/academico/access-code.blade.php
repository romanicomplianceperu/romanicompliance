@extends('layouts.app')

@section('title', 'Código de acceso — '.$course->name.' — Espacio Académico')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
@include('academico._course-header')

<div class="ac-shell" style="min-height: calc(100vh - 71px);"></div>

<div class="modal-overlay active">
  <div class="modal-backdrop"></div>
  <div class="modal-box ac-gate-box">
    <div class="ac-eyebrow">Acceso restringido</div>
    <h3>{{ $activity->case_title ?? $activity->title }}</h3>
    <p class="modal-sub">Tu docente compartió un código de acceso para esta actividad. Ingrésalo para continuar.</p>

    @if($errors->any())
      <div class="ac-form-error">{{ $errors->first('code') }}</div>
    @endif

    <form method="POST" action="{{ $formAction }}" class="ac-gate-form">
      @csrf
      <label>Código de acceso</label>
      <input type="text" name="code" required autofocus autocomplete="off" placeholder="Escribe el código que te dio tu docente">
      <button type="submit" class="ac-btn-primary" style="width:100%;justify-content:center;">Ingresar →</button>
    </form>
  </div>
</div>
@endsection
