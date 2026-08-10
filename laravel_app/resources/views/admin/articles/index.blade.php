@extends('admin.layout')

@section('title', 'Artículos')

@section('content')
<div class="page-head">
  <div></div>
  <a href="{{ route('admin.articulos.create') }}" class="btn btn-gold">+ Nuevo artículo</a>
</div>

<div class="card">
  @if($articles->isEmpty())
    <div class="empty-state">Todavía no has creado ningún artículo.</div>
  @else
    <div class="table-wrap">
    <table class="table">
      <thead>
        <tr><th>Título</th><th>Autor</th><th>Categoría</th><th>Estado</th><th>Vistas</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($articles as $article)
          <tr>
            <td>{{ $article->title }}</td>
            <td>{{ $article->author->name }}</td>
            <td>{{ $article->category->name ?? '—' }}</td>
            <td>
              @if($article->status === 'published')
                <span class="badge badge-gold">Publicado</span>
              @else
                <span class="badge badge-gray">Borrador</span>
              @endif
            </td>
            <td>{{ $article->views_count }}</td>
            <td style="text-align:right">
              <a href="{{ route('admin.articulos.edit', $article) }}" class="btn btn-outline btn-sm">Editar</a>
              <form action="{{ route('admin.articulos.destroy', $article) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este artículo?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    </div>
  @endif
</div>
@endsection
