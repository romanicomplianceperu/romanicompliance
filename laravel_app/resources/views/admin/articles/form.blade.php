@extends('admin.layout')

@section('title', $article->exists ? 'Editar artículo' : 'Nuevo artículo')

@section('styles')
.cover-preview { width: 220px; aspect-ratio: 16 / 9; object-fit: cover; border-radius: var(--radius); border: 1px solid var(--line); margin-bottom: 10px; display: block; }
@endsection

@section('content')
<div class="card">
  <form action="{{ $article->exists ? route('admin.articulos.update', $article) : route('admin.articulos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($article->exists) @method('PUT') @endif

    <div class="form-group">
      <label>Título</label>
      <input type="text" name="title" value="{{ old('title', $article->title) }}" required>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Autor</label>
        <select name="author_id" required>
          <option value="">Selecciona un autor</option>
          @foreach($authors as $author)
            <option value="{{ $author->id }}" @selected(old('author_id', $article->author_id) == $author->id)>{{ $author->name }}</option>
          @endforeach
        </select>
        <div class="form-hint">Solo aparecen los integrantes marcados como equipo (página Equipo).</div>
      </div>
      <div class="form-group">
        <label>Categoría</label>
        <select name="article_category_id">
          <option value="">Sin categoría</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected(old('article_category_id', $article->article_category_id) == $cat->id)>{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group">
      <label>Resumen</label>
      <textarea name="excerpt" maxlength="500">{{ old('excerpt', $article->excerpt) }}</textarea>
      <div class="form-hint">Se muestra en las tarjetas y en los resultados de búsqueda.</div>
    </div>

    <div class="form-group">
      <label>Contenido</label>
      <textarea name="content" style="min-height:300px" required>{{ old('content', $article->content) }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Tiempo de lectura (minutos)</label>
        <input type="number" name="reading_minutes" min="1" value="{{ old('reading_minutes', $article->reading_minutes) }}">
      </div>
      <div class="form-group">
        <label>Etiquetas</label>
        <input type="text" name="tags" value="{{ old('tags', $tagNames) }}" placeholder="splaft, compliance, bcrp">
        <div class="form-hint">Sepáralas con comas.</div>
      </div>
    </div>

    <div class="form-group">
      <label>Imagen principal</label>
      @if($article->cover_image)
        <img src="{{ asset('storage/'.$article->cover_image) }}" class="cover-preview" alt="Portada actual">
      @endif
      <input type="file" name="cover_image" accept="image/*">
      <div class="form-hint">Imagen JPG/PNG, máx. 2MB. Recomendado: horizontal, relación 16:9 (ej. 1200×675px) para que se vea completa en todas las secciones.</div>
    </div>

    <button type="submit" name="action" value="draft" class="btn btn-outline">Guardar como borrador</button>
    <button type="submit" name="action" value="publish" class="btn btn-gold">{{ $article->status === 'published' ? 'Guardar cambios' : 'Publicar' }}</button>
    <a href="{{ route('admin.articulos.index') }}" class="btn btn-outline">Cancelar</a>
  </form>
</div>
@endsection
