@extends('admin.layout')

@section('title', 'Solicitudes de clientes')

@section('content')
<div class="page-head">
  <div>
    <h2 style="font-size:1.15rem">Solicitudes de clientes</h2>
    <div class="form-hint">Diagnósticos, evaluaciones y propuestas que llegan desde las páginas de servicios y el formulario de contacto.</div>
  </div>
</div>


<div class="aca-stats-row">
  <div class="aca-stat-card"><div class="aca-stat-value">{{ $counts->sum() }}</div><div class="aca-stat-label">Total</div></div>
  <div class="aca-stat-card"><div class="aca-stat-value accent">{{ $counts['nuevo'] ?? 0 }}</div><div class="aca-stat-label">Nuevas, sin contactar</div></div>
  <div class="aca-stat-card"><div class="aca-stat-value">{{ ($counts['contactado'] ?? 0) + ($counts['propuesta'] ?? 0) }}</div><div class="aca-stat-label">En conversación</div></div>
  <div class="aca-stat-card"><div class="aca-stat-value">{{ $counts['cliente'] ?? 0 }}</div><div class="aca-stat-label">Clientes</div></div>
</div>

<div class="card">
  <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;margin-bottom:1rem">
    <div class="form-group" style="margin:0;flex:1;min-width:180px"><label>Buscar</label><input type="text" name="q" value="{{ $q }}" placeholder="Nombre, organización, correo o teléfono"></div>
    <div class="form-group" style="margin:0"><label>Estado</label>
      <select name="estado" onchange="this.form.submit()"><option value="">Todos</option>@foreach(\App\Models\ServiceLead::STATUSES as $k => $v)<option value="{{ $k }}" @selected($status === $k)>{{ $v }}</option>@endforeach</select></div>
    <div class="form-group" style="margin:0"><label>Servicio</label>
      <select name="servicio" onchange="this.form.submit()"><option value="">Todos</option>@foreach($services as $k => $v)<option value="{{ $k }}" @selected($service === $k)>{{ $v }}</option>@endforeach</select></div>
    <button type="submit" class="btn btn-outline btn-sm">Filtrar</button>
  </form>

  @if($leads->isEmpty())
    <div class="empty-state">Todavía no hay solicitudes con ese criterio.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead><tr><th>Fecha</th><th>Persona / organización</th><th>Servicio</th><th>Resultado</th><th>Contacto</th><th>Estado</th><th></th></tr></thead>
      <tbody>
        @foreach($leads as $lead)
          @php $badge = ['nuevo' => 'badge-warning', 'contactado' => 'badge-gold', 'propuesta' => 'badge-gold', 'cliente' => 'badge-success', 'descartado' => 'badge-gray'][$lead->status] ?? 'badge-gray'; @endphp
          <tr>
            <td style="white-space:nowrap">{{ $lead->created_at->timezone('America/Lima')->format('d/m/Y H:i') }}</td>
            <td><strong>{{ $lead->name }}</strong>@if($lead->organization && $lead->organization !== $lead->name)<br><span class="form-hint">{{ $lead->organization }}</span>@endif</td>
            <td>{{ $lead->service_name }}</td>
            <td>@if($lead->score !== null)<strong>{{ $lead->score }}/100</strong><br>@endif<span class="form-hint">{{ $lead->level }}</span></td>
            <td style="font-size:.82rem">{{ $lead->email }}@if($lead->email && $lead->phone)<br>@endif{{ $lead->phone }}</td>
            <td><span class="badge {{ $badge }}">{{ $lead->statusLabel() }}</span>@if($lead->follow_up_at)<br><span class="form-hint">Seguir: {{ $lead->follow_up_at->format('d/m') }}</span>@endif</td>
            <td style="text-align:right;white-space:nowrap">
              @if($lead->whatsappUrl())<a href="{{ $lead->whatsappUrl() }}" target="_blank" rel="noopener" class="btn btn-sm" style="background:#25D366;color:#fff">WhatsApp</a>@endif
              <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-outline btn-sm">Ver</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table></div>
    <div style="margin-top:1rem">{{ $leads->links() }}</div>
  @endif
</div>
@endsection
