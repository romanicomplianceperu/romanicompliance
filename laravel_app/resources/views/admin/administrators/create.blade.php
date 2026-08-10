@extends('admin.layout')

@section('title', 'Nuevo administrador')

@section('content')
<div class="card" style="max-width:520px">
  <form action="{{ route('admin.administradores.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label>Nombre completo</label>
      <input type="text" name="name" value="{{ old('name') }}" required>
    </div>
    <div class="form-group">
      <label>Correo electrónico</label>
      <input type="text" name="email" value="{{ old('email') }}" required>
      <div class="form-hint">Se usará para iniciar sesión en {{ route('admin.login') }}</div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Contraseña</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-group">
        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirmation" required>
      </div>
    </div>

    <button type="submit" class="btn btn-gold">Crear administrador</button>
    <a href="{{ route('admin.administradores.index') }}" class="btn btn-outline">Cancelar</a>
  </form>
</div>
@endsection
