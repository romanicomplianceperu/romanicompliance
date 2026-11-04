@extends('admin.layout')

@section('title', 'Solicitud de '.$lead->name)

@section('content')
<div class="page-head">
  <div>
    <h2 style="font-size:1.15rem">{{ $lead->name }}@if($lead->organization && $lead->organization !== $lead->name) · {{ $lead->organization }}@endif</h2>
    <div class="form-hint">RC-{{ str_pad($lead->id, 5, '0', STR_PAD_LEFT) }} · {{ $lead->service_name }} · recibida el {{ $lead->created_at->timezone('America/Lima')->format('d/m/Y H:i') }}</div>
  </div>
  <a href="{{ route('admin.leads.index') }}" class="btn btn-outline btn-sm">← Volver</a>
</div>

@if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>@endif

<div style="display:grid;grid-template-columns:minmax(0,1.2fr) minmax(0,1fr);gap:1.2rem;align-items:start" class="lead-grid">
  <div>
    <div class="card">
      <h3 style="font-size:1rem;margin-bottom:.8rem">Contactar</h3>
      <div style="display:flex;gap:8px;flex-wrap:wrap">
        @if($lead->whatsappUrl())<a href="{{ $lead->whatsappUrl() }}" target="_blank" rel="noopener" class="btn btn-sm" style="background:#25D366;color:#fff">Escribir por WhatsApp</a>@endif
        @if($lead->phone)<a href="tel:{{ preg_replace('/[^\d+]/', '', $lead->phone) }}" class="btn btn-outline btn-sm">Llamar · {{ $lead->phone }}</a>@endif
        @if($lead->email)<a href="mailto:{{ $lead->email }}?subject={{ rawurlencode('Romani Compliance · su solicitud sobre '.$lead->service_name) }}&body={{ rawurlencode('Hola '.$lead->firstName().",\n\nGracias por escribirnos sobre ".$lead->service_name.'. ') }}" class="btn btn-outline btn-sm">Correo · {{ $lead->email }}</a>@endif
        <a href="{{ route('admin.leads.pdf', $lead) }}" class="btn btn-outline btn-sm">Descargar PDF</a>
      </div>
      @if($lead->contacted_at)<div class="form-hint" style="margin-top:.6rem">Primer contacto registrado el {{ $lead->contacted_at->timezone('America/Lima')->format('d/m/Y H:i') }}.</div>@endif
    </div>

    <div class="card">
      <h3 style="font-size:1rem;margin-bottom:.8rem">Lo que indicó @if($lead->score !== null)<span class="badge badge-gold" style="margin-left:6px">{{ $lead->score }}/100</span>@endif @if($lead->level)<span class="badge badge-gray">{{ $lead->level }}</span>@endif</h3>
      <div style="white-space:pre-line;font-size:.88rem;line-height:1.7">{{ $lead->summary }}</div>
      @if(!empty($lead->data['priorities']))
        <h4 style="font-size:.9rem;margin:1rem 0 .5rem">Prioridades detectadas</h4>
        <ol style="padding-left:1.2rem;font-size:.88rem;line-height:1.7">@foreach($lead->data['priorities'] as $p)<li>{{ $p }}</li>@endforeach</ol>
      @endif
      <div class="form-hint" style="margin-top:1rem">IP {{ $lead->ip_address }}</div>
    </div>
  </div>

  <div class="card">
    <h3 style="font-size:1rem;margin-bottom:.8rem">Seguimiento interno</h3>
    <form method="POST" action="{{ route('admin.leads.update', $lead) }}">
      @csrf @method('PUT')
      <div class="form-group"><label>Estado</label>
        <select name="status">@foreach(\App\Models\ServiceLead::STATUSES as $k => $v)<option value="{{ $k }}" @selected($lead->status === $k)>{{ $v }}</option>@endforeach</select></div>
      <div style="display:grid;grid-template-columns:1fr 110px;gap:8px">
        <div class="form-group"><label>Monto cotizado</label><input type="number" step="0.01" min="0" name="quote_amount" value="{{ old('quote_amount', $lead->quote_amount) }}" placeholder="0.00"></div>
        <div class="form-group"><label>Moneda</label><select name="quote_currency"><option value="PEN" @selected($lead->quote_currency === 'PEN')>S/ (PEN)</option><option value="USD" @selected($lead->quote_currency === 'USD')>US$ (USD)</option></select></div>
      </div>
      <div class="form-group"><label>Próximo seguimiento</label><input type="date" name="follow_up_at" value="{{ old('follow_up_at', $lead->follow_up_at?->format('Y-m-d')) }}"></div>
      <div class="form-group"><label>Organización</label><input type="text" name="organization" value="{{ old('organization', $lead->organization) }}"></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
        <div class="form-group"><label>Teléfono</label><input type="text" name="phone" value="{{ old('phone', $lead->phone) }}"></div>
        <div class="form-group"><label>Correo</label><input type="text" inputmode="email" name="email" value="{{ old('email', $lead->email) }}"></div>
      </div>
      <div class="form-group"><label>Notas internas</label><textarea name="admin_notes" rows="7" placeholder="Qué se conversó, qué se ofreció, próximos pasos…">{{ old('admin_notes', $lead->admin_notes) }}</textarea><div class="form-hint">Solo las ve el equipo; no aparecen en el PDF del cliente.</div></div>
      <button type="submit" class="btn btn-gold">Guardar</button>
    </form>
  </div>
</div>
<style>@media (max-width: 900px) { .lead-grid { grid-template-columns: 1fr !important; } }</style>
@endsection
