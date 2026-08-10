@extends('admin.layout')

@section('title', 'Alumnos y usuarios')

@section('content')
<div class="card">
  @if($users->isEmpty())
    <div class="empty-state">Todavía no se ha registrado ningún usuario.</div>
  @else
    <div class="table-wrap">
    <table class="table">
      <thead>
        <tr><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Rol</th><th>Registrado</th><th>Cursos</th><th>Certificados</th></tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone ?? '—' }}</td>
            <td>
              @if($user->isAdmin())
                <span class="badge badge-gold">Admin</span>
              @else
                <span class="badge badge-gray">Alumno</span>
              @endif
            </td>
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
            <td>{{ $user->enrollments_count }}</td>
            <td>{{ $user->certificates_count }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    </div>
  @endif
</div>
@endsection
