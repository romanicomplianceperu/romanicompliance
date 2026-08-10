@extends('admin.layout')

@section('title', 'Administradores')

@section('content')
<div class="page-head">
  <div class="form-hint" style="max-width:520px;">Los administradores pueden crear/editar cursos, artículos y gestionar autores. Este acceso es independiente del inicio de sesión con Google.</div>
  <a href="{{ route('admin.administradores.create') }}" class="btn btn-gold">+ Nuevo administrador</a>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr><th>Nombre</th><th>Correo</th><th>Acceso</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($administrators as $admin)
          <tr>
            <td>{{ $admin->name }}</td>
            <td>{{ $admin->email }}</td>
            <td>
              @if($admin->google_id)
                <span class="badge badge-gold">Google</span>
              @endif
              @if($admin->password)
                <span class="badge badge-gray">Usuario y contraseña</span>
              @endif
            </td>
            <td style="text-align:right">
              @if($admin->id !== auth()->id())
                <form action="{{ route('admin.administradores.destroy', $admin) }}" method="POST" onsubmit="return confirm('¿Eliminar a este administrador?');">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
              @else
                <span class="form-hint">Tu cuenta</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
