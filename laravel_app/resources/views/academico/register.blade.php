@extends('layouts.app')

@section('title', 'Registro — '.$course->name.' — Espacio Académico')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
@php $acCrumbExtra = $activity->title; @endphp
@include('academico._course-header')

<div class="ac-shell">
  <div class="wrap" style="padding:2.2rem 24px;max-width:620px;">
    <div class="ac-eyebrow">Antes de comenzar</div>
    <h1 class="ac-title" style="text-align:left;font-size:1.6rem;">{{ $activity->case_title ?? $activity->title }}</h1>
    <p class="ac-subtitle" style="text-align:left;margin:0 0 1.6rem;">Indícanos si trabajarás solo o en grupo. Con esto sabremos a quién corresponde tu participación.</p>

    @if($errors->any())
      <div class="ac-form-error">
        @foreach($errors->all() as $error){{ $error }}<br>@endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('academico.activity.register', [$university->slug, $course->slug, $activity->slug]) }}" id="registerForm">
      @csrf
      <input type="hidden" name="mode" id="modeInput" value="individual">

      <div class="ac-mode-toggle">
        <div class="ac-mode-btn active" data-mode="individual">
          Individual
          <small>Solo tú</small>
        </div>
        <div class="ac-mode-btn" data-mode="grupal">
          Grupal
          <small>5 a 6 integrantes</small>
        </div>
      </div>

      <div id="individualFields" class="ac-id-card" style="max-width:none;padding:1.6rem;">
        <label>Nombre completo</label>
        <input type="text" name="full_name" autocomplete="off">
        <label>Correo institucional</label>
        <input type="email" name="email" autocomplete="off" placeholder="nombre@unp.edu.pe">
      </div>

      <div id="groupFields" class="ac-id-card" style="max-width:none;padding:1.6rem;display:none;">
        <label style="margin-bottom:10px;">Integrantes del grupo</label>
        <div id="memberRows"></div>
        <button type="button" class="ac-member-add" id="addMemberBtn">+ Agregar integrante</button>
        <p style="font-size:0.74rem;color:var(--slate-light);margin-top:10px;">Al enviar, se generará automáticamente un código de grupo para su seguimiento.</p>
      </div>

      <button type="submit" class="ac-btn-primary" style="width:100%;justify-content:center;margin-top:1.2rem;">Continuar a la actividad →</button>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
  const modeInput = document.getElementById('modeInput');
  const modeBtns = document.querySelectorAll('.ac-mode-btn');
  const individualFields = document.getElementById('individualFields');
  const groupFields = document.getElementById('groupFields');
  const memberRows = document.getElementById('memberRows');
  const addMemberBtn = document.getElementById('addMemberBtn');

  function setMode(mode) {
    modeInput.value = mode;
    modeBtns.forEach(b => b.classList.toggle('active', b.dataset.mode === mode));
    individualFields.style.display = mode === 'individual' ? 'block' : 'none';
    groupFields.style.display = mode === 'grupal' ? 'block' : 'none';
    document.querySelectorAll('#individualFields input').forEach(i => i.required = mode === 'individual');
    if (mode === 'grupal' && memberRows.children.length === 0) {
      addRow(); addRow();
    }
  }

  modeBtns.forEach(btn => btn.addEventListener('click', () => setMode(btn.dataset.mode)));

  let rowIndex = 0;
  function addRow() {
    const i = rowIndex++;
    const row = document.createElement('div');
    row.className = 'ac-member-row';
    row.innerHTML = `
      <input type="text" name="members[${i}][full_name]" placeholder="Nombre completo" required>
      <input type="email" name="members[${i}][email]" placeholder="Correo institucional" required>
      <button type="button" class="ac-member-remove" title="Quitar">✕</button>
    `;
    row.querySelector('.ac-member-remove').addEventListener('click', () => row.remove());
    memberRows.appendChild(row);
  }

  addMemberBtn.addEventListener('click', addRow);
  setMode('individual');
})();
</script>
@endsection
