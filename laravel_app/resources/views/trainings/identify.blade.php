@extends('layouts.app')

@section('title', 'Identificación · '.$training->title)

@section('styles')
@include('trainings._styles')
.tr-form-shell { max-width: 520px; margin: 3.5rem auto; }
.tr-form-card { background: var(--white); border: 1px solid var(--line); border-radius: 16px; padding: 2.4rem 2.2rem; box-shadow: var(--shadow-m); }
.tr-form-eyebrow { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gold); margin-bottom: 0.6rem; }
.tr-form-card h1 { font-family: var(--serif); font-size: 1.5rem; color: var(--ink); margin-bottom: 0.5rem; }
.tr-form-card > p { font-size: 0.86rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.8rem; }
.tr-field { margin-bottom: 1.3rem; }
.tr-field label { display: block; font-size: 0.75rem; font-weight: 700; color: var(--ink); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
.tr-field input[type="text"], .tr-field select { width: 100%; padding: 12px 14px; border: 1.5px solid var(--line); border-radius: 8px; font-family: var(--sans); font-size: 0.92rem; color: var(--ink); transition: border-color 0.2s ease; }
.tr-field input[type="text"]:focus, .tr-field select:focus { outline: none; border-color: var(--gold); }
.tr-error { color: #B3413B; font-size: 0.78rem; margin-top: 6px; }
.tr-position-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
.tr-position-option { position: relative; }
.tr-position-option input { position: absolute; opacity: 0; }
.tr-position-option label { display: flex; align-items: center; justify-content: center; padding: 12px 8px; border: 1.5px solid var(--line); border-radius: 8px; font-size: 0.85rem; font-weight: 600; color: var(--slate); cursor: pointer; text-transform: none; margin: 0; transition: all 0.15s ease; text-align: center; }
.tr-position-option input:checked + label { border-color: var(--gold); background: var(--gold-pale); color: var(--ink); }
@endsection

@section('content')
<div class="tr-shell">
  <div class="wrap">
    <div class="tr-form-shell">
      <div class="tr-form-card">
        <div class="tr-form-eyebrow">{{ $training->title }}</div>
        <h1>Antes de empezar</h1>
        <p>Complete sus datos para iniciar la evaluación. Su nombre, cargo y nota quedarán registrados.</p>

        @if($errors->any())
          <div class="tr-error" style="margin-bottom:1rem;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('capacitacion.identify.store', $training) }}">
          @csrf
          <div class="tr-field">
            <label for="full_name">Nombre completo</label>
            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="Ej. Juan Carlos Pérez Gómez" required>
          </div>

          <div class="tr-field">
            <label>Cargo</label>
            <div class="tr-position-grid">
              <div class="tr-position-option">
                <input type="radio" id="pos_juez" name="position" value="juez" {{ old('position') === 'juez' ? 'checked' : '' }} onchange="trToggleOther()">
                <label for="pos_juez">Juez</label>
              </div>
              <div class="tr-position-option">
                <input type="radio" id="pos_fiscal" name="position" value="fiscal" {{ old('position') === 'fiscal' ? 'checked' : '' }} onchange="trToggleOther()">
                <label for="pos_fiscal">Fiscal</label>
              </div>
              <div class="tr-position-option">
                <input type="radio" id="pos_otro" name="position" value="otro" {{ old('position') === 'otro' ? 'checked' : '' }} onchange="trToggleOther()">
                <label for="pos_otro">Otro</label>
              </div>
            </div>
          </div>

          <div class="tr-field" id="trPositionOtherField" style="display:{{ old('position') === 'otro' ? 'block' : 'none' }};">
            <label for="position_other">Especifique su cargo</label>
            <input type="text" id="position_other" name="position_other" value="{{ old('position_other') }}" placeholder="Ej. Asistente de función fiscal">
          </div>

          <button type="submit" class="tr-btn tr-btn-solid tr-btn-block">Comenzar evaluación ({{ $training->time_limit_minutes }} min) →</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function trToggleOther() {
  const otro = document.getElementById('pos_otro');
  document.getElementById('trPositionOtherField').style.display = otro.checked ? 'block' : 'none';
}
</script>
@endsection
