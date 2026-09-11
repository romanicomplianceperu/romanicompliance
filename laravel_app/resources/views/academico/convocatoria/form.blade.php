@extends('layouts.app')

@section('title', 'Postula a prácticas — Romani Compliance')

@section('styles')
.cv-form-shell { padding: 3rem 0 5rem; background: var(--ivory); min-height: calc(100vh - 71px); }
.cv-form-card { max-width: 760px; margin: 0 auto; background: var(--white); border-radius: 18px; border: 1px solid var(--line); box-shadow: var(--shadow-m); overflow: hidden; }
.cv-form-header { background: linear-gradient(135deg, var(--ink), #16283F); padding: 2.2rem 2.4rem; }
.cv-form-header .eyebrow { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gold-light); margin-bottom: 8px; }
.cv-form-header h1 { font-family: var(--serif); color: var(--white); font-size: 1.5rem; margin-bottom: 6px; font-weight: 600; }
.cv-form-header p { color: rgba(255,255,255,0.6); font-size: 0.85rem; margin: 0; }
.cv-form-body { padding: 2rem 2.4rem 2.6rem; }

.cv-error-box { background: rgba(179,65,59,0.08); border: 1px solid rgba(179,65,59,0.25); color: #B3413B; border-radius: 8px; padding: 12px 16px; font-size: 0.84rem; margin-bottom: 1.6rem; }
.cv-error-box ul { margin: 4px 0 0; padding-left: 18px; }

.cv-fieldset { margin-bottom: 2.2rem; }
.cv-fieldset-legend { font-size: 1rem; font-weight: 700; color: var(--ink); margin-bottom: 0.3rem; display: flex; align-items: center; }
.cv-fieldset-num { display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 50%; background: var(--gold-pale); color: var(--gold); font-size: 0.75rem; font-weight: 700; margin-right: 10px; flex-shrink: 0; }
.cv-fieldset-hint { font-size: 0.78rem; color: var(--slate-light); margin: 4px 0 14px 36px; }

.cv-input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-left: 36px; }
.cv-input-group { margin-bottom: 1rem; margin-left: 36px; }
.cv-input-row .cv-input-group { margin-left: 0; }
.cv-input-group.full { margin-left: 36px; }
.cv-input-group label.field-label { display: block; font-size: 0.78rem; font-weight: 600; color: var(--slate); margin-bottom: 6px; }
.cv-input-group input, .cv-input-group select, .cv-input-group textarea { width: 100%; padding: 11px 14px; border: 1.5px solid var(--line); border-radius: 8px; font-size: 0.9rem; font-family: var(--sans); color: var(--ink); background: var(--white); transition: border-color 0.2s ease; }
.cv-input-group input:focus, .cv-input-group select:focus, .cv-input-group textarea:focus { outline: none; border-color: var(--gold); }
.cv-input-group textarea { resize: vertical; min-height: 90px; }
.cv-optional-tag { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: var(--slate-light); background: var(--ivory-dim); padding: 2px 9px; border-radius: 10px; margin-left: 8px; }

.cv-pill-group { display: flex; flex-wrap: wrap; gap: 10px; margin-left: 36px; }
.cv-pill { position: relative; }
.cv-pill input { position: absolute; opacity: 0; inset: 0; width: 100%; height: 100%; margin: 0; cursor: pointer; }
.cv-pill .pill-label { display: inline-flex; align-items: center; gap: 6px; padding: 10px 16px; border: 1.5px solid var(--line); border-radius: 24px; font-size: 0.82rem; color: var(--slate); font-weight: 600; transition: all 0.15s ease; cursor: pointer; user-select: none; }
.cv-pill input:checked + .pill-label { border-color: var(--gold); background: var(--gold-pale); color: var(--ink); }
.cv-pill input:disabled + .pill-label { opacity: 0.4; cursor: not-allowed; }
.cv-pill input:focus-visible + .pill-label { box-shadow: 0 0 0 3px rgba(139,115,64,0.25); }

.cv-skill-counter { margin-left: 36px; font-size: 0.76rem; color: var(--slate-light); margin: -4px 0 10px; }
.cv-skill-counter strong { color: var(--gold); }

.cv-q-block { margin-left: 36px; margin-bottom: 1.2rem; padding-bottom: 1.2rem; border-bottom: 1px dashed var(--line); }
.cv-q-block:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.cv-q-block .q-text { font-size: 0.86rem; color: var(--ink); margin-bottom: 9px; font-weight: 500; }

.cv-submit-btn { width: 100%; background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--ink); font-weight: 700; font-size: 0.95rem; padding: 15px; border: none; border-radius: 8px; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease; font-family: var(--sans); }
.cv-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(201,169,97,0.3); }

@media (max-width: 640px) {
  .cv-form-header { padding: 1.8rem 1.5rem; }
  .cv-form-body { padding: 1.6rem 1.5rem 2rem; }
  .cv-input-row { grid-template-columns: 1fr; margin-left: 0; gap: 0; }
  .cv-input-group { margin-left: 0; }
  .cv-fieldset-hint, .cv-pill-group, .cv-skill-counter, .cv-q-block { margin-left: 0; }
}
@endsection

@section('content')
<div class="cv-form-shell">
  <div class="wrap">
    <div class="cv-form-card">
      <div class="cv-form-header">
        <div class="eyebrow">Convocatoria de practicantes</div>
        <h1>Cuéntanos sobre ti</h1>
        <p>Toma solo unos minutos. Revisaremos tu perfil y te contactaremos por WhatsApp.</p>
      </div>

      <div class="cv-form-body">
        @if($errors->any())
          <div class="cv-error-box">
            Revisa lo siguiente antes de continuar:
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('academico.convocatoria.store') }}" id="cvForm">
          @csrf

          <div class="cv-fieldset">
            <div class="cv-fieldset-legend"><span class="cv-fieldset-num">1</span> Tus datos</div>
            <div class="cv-input-row">
              <div class="cv-input-group">
                <label class="field-label">Nombre completo</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" required maxlength="255">
              </div>
              <div class="cv-input-group">
                <label class="field-label">Número de celular</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" required maxlength="30" placeholder="9XXXXXXXX">
              </div>
            </div>
            <div class="cv-input-group full">
              <label class="field-label">Correo electrónico (institucional o personal)</label>
              <input type="email" name="email" value="{{ old('email') }}" required maxlength="255">
            </div>
          </div>

          <div class="cv-fieldset">
            <div class="cv-fieldset-legend"><span class="cv-fieldset-num">2</span> Área de interés</div>
            <div class="cv-fieldset-hint">¿En qué área te gustaría apoyar?</div>
            <div class="cv-pill-group">
              @foreach($interestAreas as $key => $label)
                <label class="cv-pill">
                  <input type="radio" name="interest_area" value="{{ $key }}" {{ old('interest_area') === $key ? 'checked' : '' }} required>
                  <span class="pill-label">{{ $label }}</span>
                </label>
              @endforeach
            </div>
          </div>

          <div class="cv-fieldset">
            <div class="cv-fieldset-legend"><span class="cv-fieldset-num">3</span> Disponibilidad</div>
            <div class="cv-fieldset-hint">Tu situación actual</div>
            <div class="cv-pill-group" style="margin-bottom:1.1rem;">
              @foreach($occupationStatuses as $key => $label)
                <label class="cv-pill">
                  <input type="radio" name="occupation_status" value="{{ $key }}" {{ old('occupation_status') === $key ? 'checked' : '' }} required>
                  <span class="pill-label">{{ $label }}</span>
                </label>
              @endforeach
            </div>
            <div class="cv-fieldset-hint">Horario en el que tienes más disponibilidad (marca uno o más)</div>
            <div class="cv-pill-group" style="margin-bottom:1.1rem;">
              @php $oldSchedule = old('schedule_availability', []); @endphp
              @foreach($scheduleBlocks as $key => $label)
                <label class="cv-pill">
                  <input type="checkbox" name="schedule_availability[]" value="{{ $key }}" {{ in_array($key, $oldSchedule) ? 'checked' : '' }}>
                  <span class="pill-label">{{ $label }}</span>
                </label>
              @endforeach
            </div>
            <div class="cv-fieldset-hint">¿Cuántas horas a la semana puedes dedicar?</div>
            <div class="cv-pill-group">
              @foreach($weeklyHours as $key => $label)
                <label class="cv-pill">
                  <input type="radio" name="weekly_hours" value="{{ $key }}" {{ old('weekly_hours') === $key ? 'checked' : '' }} required>
                  <span class="pill-label">{{ $label }}</span>
                </label>
              @endforeach
            </div>
          </div>

          <div class="cv-fieldset">
            <div class="cv-fieldset-legend"><span class="cv-fieldset-num">4</span> Ofimática e inteligencia artificial</div>
            <div class="cv-q-block">
              <div class="q-text">Manejo de Word</div>
              <div class="cv-pill-group" style="margin-left:0;">
                @foreach($officeLevels as $key => $label)
                  <label class="cv-pill">
                    <input type="radio" name="office_word_level" value="{{ $key }}" {{ old('office_word_level') === $key ? 'checked' : '' }} required>
                    <span class="pill-label">{{ $label }}</span>
                  </label>
                @endforeach
              </div>
            </div>
            <div class="cv-q-block">
              <div class="q-text">Manejo de Excel</div>
              <div class="cv-pill-group" style="margin-left:0;">
                @foreach($officeLevels as $key => $label)
                  <label class="cv-pill">
                    <input type="radio" name="office_excel_level" value="{{ $key }}" {{ old('office_excel_level') === $key ? 'checked' : '' }} required>
                    <span class="pill-label">{{ $label }}</span>
                  </label>
                @endforeach
              </div>
            </div>
            <div class="cv-q-block">
              <div class="q-text">¿Cuáles de estas herramientas de inteligencia artificial usas?</div>
              <div class="cv-pill-group" style="margin-left:0;">
                @php $oldAiTools = old('ai_tools', []); @endphp
                @foreach($aiTools as $key => $label)
                  <label class="cv-pill">
                    <input type="checkbox" name="ai_tools[]" value="{{ $key }}" {{ in_array($key, $oldAiTools) ? 'checked' : '' }}>
                    <span class="pill-label">{{ $label }}</span>
                  </label>
                @endforeach
              </div>
            </div>
            <div class="cv-q-block">
              <div class="q-text">¿Tienes alguno de estos servicios de IA en su versión paga o Plus?</div>
              <div class="cv-pill-group" style="margin-left:0;">
                @foreach($yesNo as $key => $label)
                  <label class="cv-pill">
                    <input type="radio" name="ai_tools_paid" value="{{ $key }}" {{ old('ai_tools_paid') === $key ? 'checked' : '' }} required>
                    <span class="pill-label">{{ $label }}</span>
                  </label>
                @endforeach
              </div>
            </div>
          </div>

          <div class="cv-fieldset">
            <div class="cv-fieldset-legend"><span class="cv-fieldset-num">5</span> Tus habilidades</div>
            <div class="cv-fieldset-hint">Marca hasta {{ $maxSkills }} habilidades en las que te sientas más fuerte</div>
            <div class="cv-skill-counter"><strong id="cvSkillCount">0</strong>/{{ $maxSkills }} seleccionadas</div>
            <div class="cv-pill-group">
              @php $oldSkills = old('skills', []); @endphp
              @foreach($skills as $key => $label)
                <label class="cv-pill">
                  <input type="checkbox" name="skills[]" value="{{ $key }}" class="cv-skill-input" {{ in_array($key, $oldSkills) ? 'checked' : '' }}>
                  <span class="pill-label">{{ $label }}</span>
                </label>
              @endforeach
            </div>
          </div>

          <div class="cv-fieldset">
            <div class="cv-fieldset-legend"><span class="cv-fieldset-num">6</span> ¿En qué ciclo te encuentras?</div>
            <div class="cv-pill-group">
              @foreach($academicCycles as $key => $label)
                <label class="cv-pill">
                  <input type="radio" name="academic_cycle" value="{{ $key }}" {{ old('academic_cycle') === $key ? 'checked' : '' }} required>
                  <span class="pill-label">{{ $label }}</span>
                </label>
              @endforeach
            </div>
          </div>

          <div class="cv-fieldset">
            <div class="cv-fieldset-legend"><span class="cv-fieldset-num">7</span> Un poco de lo que ya conoces</div>
            <div class="cv-fieldset-hint">No hay respuestas correctas o incorrectas, solo queremos ubicar de dónde partes</div>
            @php $oldAnswers = old('specialized_answers', []); @endphp
            @foreach($specializedQuestions as $qKey => $question)
              <div class="cv-q-block">
                <div class="q-text">{{ $question }}</div>
                <div class="cv-pill-group" style="margin-left:0;">
                  @foreach($answerOptions as $aKey => $aLabel)
                    <label class="cv-pill">
                      <input type="radio" name="specialized_answers[{{ $qKey }}]" value="{{ $aKey }}" {{ ($oldAnswers[$qKey] ?? null) === $aKey ? 'checked' : '' }} required>
                      <span class="pill-label">{{ $aLabel }}</span>
                    </label>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>

          <div class="cv-fieldset">
            <div class="cv-fieldset-legend"><span class="cv-fieldset-num">8</span> ¿Por qué te interesa Romani Compliance? <span class="cv-optional-tag">Opcional</span></div>
            <div class="cv-input-group full">
              <textarea name="motivation" maxlength="2000" placeholder="Cuéntanos brevemente qué te motiva a postular (no es obligatorio)">{{ old('motivation') }}</textarea>
            </div>
          </div>

          <button type="submit" class="cv-submit-btn">Enviar mi solicitud</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  var maxSkills = {{ $maxSkills }};
  var inputs = Array.prototype.slice.call(document.querySelectorAll('.cv-skill-input'));
  var counter = document.getElementById('cvSkillCount');

  function refresh() {
    var checked = inputs.filter(function (i) { return i.checked; });
    counter.textContent = checked.length;
    inputs.forEach(function (i) {
      i.disabled = checked.length >= maxSkills && ! i.checked;
    });
  }

  inputs.forEach(function (i) { i.addEventListener('change', refresh); });
  refresh();
})();
</script>
@endsection
