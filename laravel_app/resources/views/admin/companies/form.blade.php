@extends('admin.layout')

@section('title', $company->exists ? 'Editar empresa' : 'Nueva empresa')

@section('content')
<div class="card">
  <form action="{{ $company->exists ? route('admin.empresas.update', $company) : route('admin.empresas.store') }}" method="POST">
    @csrf
    @if($company->exists) @method('PUT') @endif

    <div class="form-row">
      <div class="form-group">
        <label>Nombre de la empresa</label>
        <input type="text" name="name" value="{{ old('name', $company->name) }}" required>
      </div>
      <div class="form-group">
        <label>RUC</label>
        <input type="text" name="ruc" value="{{ old('ruc', $company->ruc) }}">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Persona de contacto</label>
        <input type="text" name="contact_name" value="{{ old('contact_name', $company->contact_name) }}">
      </div>
      <div class="form-group">
        <label>Teléfono de contacto</label>
        <input type="text" name="contact_phone" value="{{ old('contact_phone', $company->contact_phone) }}">
      </div>
    </div>

    <div class="form-group">
      <label>Correo de contacto</label>
      <input type="text" name="contact_email" value="{{ old('contact_email', $company->contact_email) }}">
    </div>

    <div class="form-group">
      <label>Notas internas</label>
      <textarea name="notes">{{ old('notes', $company->notes) }}</textarea>
    </div>

    <button type="submit" class="btn btn-gold">{{ $company->exists ? 'Guardar cambios' : 'Crear empresa' }}</button>
    <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline">Cancelar</a>
  </form>
</div>
@endsection
