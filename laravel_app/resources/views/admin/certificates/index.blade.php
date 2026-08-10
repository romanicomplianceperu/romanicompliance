@extends('admin.layout')

@section('title', 'Certificados')

@section('content')
@if($pendingEnrollments->isNotEmpty())
<div class="card">
  <div class="page-head">
    <div>
      <h2 style="font-size:1.05rem;margin-bottom:2px;">Certificaciones pendientes de pago</h2>
      <div class="form-hint">Alumnos que marcaron "Ya hice el pago" para una certificación opcional. Verifica el pago y emite el certificado.</div>
    </div>
  </div>
  <div class="table-wrap"><table class="table">
    <thead>
      <tr><th>Alumno</th><th>Nombre para el certificado</th><th>Curso</th><th>Examen</th><th>Pago reportado</th><th></th></tr>
    </thead>
    <tbody>
      @foreach($pendingEnrollments as $enrollment)
        @php $examPassed = $enrollment->course->hasPassedExamFor($enrollment->user); @endphp
        <tr>
          <td>{{ $enrollment->user->name }}<br><span class="form-hint">{{ $enrollment->user->email }}</span></td>
          <td>{{ $enrollment->certificate_name ?? $enrollment->user->name }}</td>
          <td>{{ $enrollment->course->title }}<br><span class="form-hint">S/ {{ number_format($enrollment->course->certificate_price ?? 0, 2) }}</span></td>
          <td>
            @if($examPassed)
              <span class="badge badge-gold">Aprobado</span>
            @else
              <span class="badge badge-gray">Pendiente</span>
            @endif
          </td>
          <td>{{ $enrollment->certificate_payment_claimed_at->format('d/m/Y H:i') }}</td>
          <td style="text-align:right;white-space:nowrap;">
            <form action="{{ route('admin.certificates.issue-pending', $enrollment) }}" method="POST" onsubmit="return confirm('¿Confirmas que el pago fue recibido y deseas emitir este certificado?');">
              @csrf
              <button type="submit" class="btn btn-gold btn-sm">Emitir certificado</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table></div>
</div>
@endif

<div class="card">
  @if($certificates->isEmpty())
    <div class="empty-state">Todavía no se ha emitido ningún certificado.</div>
  @else
    <div class="table-wrap"><table class="table">
      <thead>
        <tr><th>Código</th><th>Alumno</th><th>Curso</th><th>Emitido</th><th>Estado</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($certificates as $certificate)
          <tr>
            <td>{{ $certificate->code }}</td>
            <td>{{ $certificate->holderDisplayName() }}@if($certificate->isManual()) <span class="badge badge-gray" style="margin-left:4px;">Manual</span>@endif</td>
            <td>{{ $certificate->course->title }}</td>
            <td>{{ $certificate->issued_at->format('d/m/Y') }}</td>
            <td>
              @if($certificate->isRevoked())
                <span class="badge badge-gray">Revocado</span>
              @else
                <span class="badge badge-gold">Vigente</span>
              @endif
            </td>
            <td style="text-align:right;white-space:nowrap;">
              <a href="{{ route('certificates.download', $certificate) }}" class="btn btn-outline btn-sm">Descargar</a>
              @if($certificate->isRevoked())
                <form action="{{ route('admin.certificates.reissue', $certificate) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Reemitir este certificado?');">
                  @csrf
                  <button type="submit" class="btn btn-gold btn-sm">Reemitir</button>
                </form>
              @else
                <form action="{{ route('admin.certificates.revoke', $certificate) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Revocar este certificado? Dejará de ser válido.');">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm">Revocar</button>
                </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table></div>
  @endif
</div>
@endsection
