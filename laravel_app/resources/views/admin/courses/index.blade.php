@extends('admin.layout')

@section('title', 'Cursos')

@section('content')
<div class="page-head">
  <div></div>
  <a href="{{ route('admin.courses.create') }}" class="btn btn-gold">+ Nuevo curso</a>
</div>

<div class="card">
  @if($courses->isEmpty())
    <div class="empty-state">Todavía no has creado ningún curso.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead>
        <tr><th>Curso</th><th>Categoría</th><th>Certificación</th><th>Inscritos</th><th>Estado</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($courses as $course)
          <tr>
            <td>{{ $course->title }}</td>
            <td>{{ $course->category->name ?? '—' }}</td>
            <td>
              @if($course->certificate_type === 'gratuita')
                <span class="badge badge-gold">Gratuita</span>
              @else
                <span class="badge badge-gray">Opcional</span>
              @endif
            </td>
            <td>{{ $course->enrollments_count }}</td>
            <td>
              @if($course->is_published)
                <span class="badge badge-gold">Publicado</span>
              @else
                <span class="badge badge-gray">Borrador</span>
              @endif
            </td>
            <td style="text-align:right">
              <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline btn-sm">Editar</a>
              <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este curso y todo su contenido?');">
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
