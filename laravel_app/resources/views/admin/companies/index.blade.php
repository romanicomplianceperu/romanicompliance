@extends('admin.layout')

@section('title', 'Empresas')

@section('content')
<div class="page-head">
  <h2 style="font-size:1.15rem">Empresas clientes</h2>
  <a href="{{ route('admin.empresas.create') }}" class="btn btn-gold">+ Nueva empresa</a>
</div>

<div class="card">
  @if($companies->isEmpty())
    <div class="empty-state">Todavía no hay empresas registradas.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead>
        <tr><th>Empresa</th><th>RUC</th><th>Contacto</th><th>Proyectos</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($companies as $company)
          <tr>
            <td>{{ $company->name }}</td>
            <td>{{ $company->ruc ?: '—' }}</td>
            <td>{{ $company->contact_name ?: '—' }}@if($company->contact_email) <br><span class="form-hint">{{ $company->contact_email }}</span>@endif</td>
            <td>{{ $company->projects_count }}</td>
            <td style="text-align:right;white-space:nowrap;">
              <a href="{{ route('admin.empresas.edit', $company) }}" class="btn btn-outline btn-sm">Editar</a>
              <form action="{{ route('admin.empresas.destroy', $company) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta empresa?');">
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
