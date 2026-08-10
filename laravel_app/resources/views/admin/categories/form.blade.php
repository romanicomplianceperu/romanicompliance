@extends('admin.layout')

@section('title', $category->exists ? 'Editar categoría' : 'Nueva categoría')

@section('content')
<div class="card" style="max-width:560px">
  <form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
    @csrf
    @if($category->exists) @method('PUT') @endif

    <div class="form-group">
      <label>Nombre</label>
      <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
    </div>
    <div class="form-group">
      <label>Descripción</label>
      <textarea name="description">{{ old('description', $category->description) }}</textarea>
    </div>

    <button type="submit" class="btn btn-gold">{{ $category->exists ? 'Guardar cambios' : 'Crear categoría' }}</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Cancelar</a>
  </form>
</div>
@endsection
