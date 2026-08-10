@extends('admin.layout')

@section('title', 'Categorías')

@section('content')
<div class="page-head">
  <div></div>
  <a href="{{ route('admin.categories.create') }}" class="btn btn-gold">+ Nueva categoría</a>
</div>

<div class="card">
  @if($categories->isEmpty())
    <div class="empty-state">Todavía no has creado ninguna categoría.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead>
        <tr><th>Nombre</th><th>Cursos</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
          <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->courses_count }}</td>
            <td style="text-align:right">
              <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline btn-sm">Editar</a>
              <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta categoría?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table></div>
  @endif
</div>
@endsection
