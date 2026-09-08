@extends('layouts.app')

@section('title', 'Código de acceso — '.$course->name.' — Espacio Académico')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
@php $acCrumbExtra = $activity->title; @endphp
@include('academico._course-header')

<div class="ac-shell ac-full">
  <div class="ac-eyebrow">Acceso restringido</div>
  <h1 class="ac-title">{{ $activity->case_title ?? $activity->title }}</h1>
  <p class="ac-subtitle">Tu docente compartió un código de acceso para esta actividad. Ingrésalo para continuar.</p>

  <div class="ac-id-card">
    @if($errors->any())
      <div class="ac-form-error">{{ $errors->first('code') }}</div>
    @endif
    <form method="POST" action="{{ route('academico.activity.unlock', [$university->slug, $course->slug, $activity->slug]) }}">
      @csrf
      <label>Código de acceso</label>
      <input type="text" name="code" required autofocus autocomplete="off" placeholder="Escribe el código que te dio tu docente">
      <button type="submit" class="ac-btn-primary" style="width:100%;justify-content:center;">Ingresar →</button>
    </form>
  </div>
</div>
@endsection
