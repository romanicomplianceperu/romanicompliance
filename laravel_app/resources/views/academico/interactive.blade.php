@extends('layouts.app')

@section('title', $activity->title.' — '.$course->name.' — Espacio Académico')

@section('styles')
@include('academico._styles')
@endsection

@section('content')
@php $acCrumbExtra = $activity->title; @endphp
@include('academico._course-header')

@php $acActiveTab = 'participacion'; @endphp
@include('academico._course-tabs')

<div class="ac-shell">
  <div class="wrap" style="padding:2.2rem 24px;max-width:860px;">

    @if(session('academico_success'))
      <div class="ac-response-sent" style="margin-bottom:1.4rem;">{{ session('academico_success') }}</div>
    @endif
    @if(session('academico_error'))
      <div class="ac-form-error">{{ session('academico_error') }}</div>
    @endif

    <div class="ac-case-toolbar">
      @if($activity->due_at)
        <div class="ac-deadline-badge {{ $activity->isPastDue() ? 'closed' : '' }}">
          ⏱ {{ $activity->isPastDue() ? 'Plazo vencido — ' : 'Fecha límite: ' }}{{ $activity->due_at->timezone('America/Lima')->translatedFormat('d \d\e F, H:i').' h' }}
        </div>
      @endif
      <a href="{{ route('academico.activity.pdf', [$university->slug, $course->slug, $activity->slug]) }}" class="ac-pdf-btn" data-no-loader>📄 Descargar el caso en PDF</a>
    </div>

    @if($submission->mode === 'grupal')
      <div class="ac-group-code-banner">
        <div class="label">Tu código de grupo</div>
        <div class="code">grupo {{ $submission->group_code }}</div>
        <div class="hint">Guárdalo — tu docente lo usará para revisar el avance de tu equipo.</div>
      </div>
    @endif

    <div style="margin-bottom:1.4rem;">
      @foreach($submission->members as $member)
        <span class="ac-team-chip">👤 {{ $member->full_name }}</span>
      @endforeach
    </div>

    <div class="ac-case-card">
      <div class="ac-case-tags">
        <span class="ac-case-tag">Semana {{ $activity->week_number }}</span>
        @if($activity->unit)<span class="ac-case-tag">{{ $activity->unit }}</span>@endif
        @if($activity->modality)<span class="ac-case-tag">{{ $activity->modality }}</span>@endif
      </div>
      <h2>{{ $activity->case_title ?? $activity->title }}</h2>
      @if($activity->case_body)
        <div class="body">
          @foreach($activity->caseBodySections() as $section)
            @if($section['heading'])
              <div class="ac-case-highlight">
                <div class="ac-case-highlight-title">{{ $section['heading'] }}</div>
                <ul>
                  @foreach($section['items'] as $item)
                    <li>{{ $item }}</li>
                  @endforeach
                </ul>
              </div>
            @else
              @foreach($section['items'] as $item)
                <p>{{ $item }}</p>
              @endforeach
            @endif
          @endforeach
        </div>
      @endif
    </div>

    @if(! $canEdit)
      <div class="ac-response-sent" style="margin-bottom:1.6rem;">
        Actividad enviada el {{ $submission->submitted_at?->timezone('America/Lima')->format('d/m/Y H:i') }} h. Ya no se puede editar.
      </div>
    @endif

    @if($grading)
      <div class="ac-score-banner">
        <div class="score-value">{{ $grading['earned_points'] }} / {{ $grading['total_points'] }} <small>puntos</small></div>
        <div class="score-percent">{{ $grading['percent'] }}% de aciertos en los ejercicios autocalificables ({{ $grading['correct'] }} de {{ $grading['total'] }})</div>
        <div class="score-note">La respuesta crítica no forma parte de este puntaje automático; la revisa tu docente directamente.</div>
      </div>
    @endif

    <form method="POST" action="{{ route('academico.activity.save', [$university->slug, $course->slug, $activity->slug]) }}" id="interactiveForm">
      @csrf
      <input type="hidden" name="action" id="actionInput" value="borrador">
      <input type="hidden" name="answers" id="answersInput">

      @if($exercisesData->count() > 0)
        <div class="ac-ex-section">
          <h3>Ejercicios del caso</h3>
          @if(! $grading)
            <p class="ac-ex-intro">Marca, empareja u ordena según corresponda. Tus respuestas se guardan automáticamente; el resultado recién se muestra cuando envíes la actividad.</p>
          @endif
          <div id="exercisesRoot" @if(! $canEdit) style="pointer-events:none;opacity:0.7;" @endif></div>
        </div>
      @endif

      @if($activity->questions->count() > 0)
        <div class="ac-critica-section">
          <div class="ac-critica-head">
            <h3>Respuesta crítica</h3>
            <span class="ac-critica-badge">No cuenta para la nota automática</span>
          </div>
          <p class="ac-ex-intro">Estas son las preguntas del caso que revisa directamente su docente; respondan con argumentos propios.</p>
          @php $savedQuestions = $submission->answers['questions'] ?? []; @endphp
          @foreach($activity->questions as $i => $question)
            <div class="ac-question-card">
              <div class="q-num">Pregunta {{ $i + 1 }}</div>
              <div class="q-text">{{ $question->prompt }}</div>
              <textarea class="js-answer" data-qid="{{ $question->id }}" maxlength="4000" placeholder="Escriban su respuesta…" {{ $canEdit ? '' : 'disabled' }}>{{ $savedQuestions[$question->id] ?? '' }}</textarea>
              <div class="ac-question-footer">
                <span class="ac-char-count">0 / 4000</span>
              </div>
            </div>
          @endforeach
        </div>
      @endif

      @if($canEdit)
        <div class="ac-question-actions" style="margin-top:1rem;">
          <span class="ac-autosave-status" id="autosaveStatus"></span>
          <button type="submit" class="ac-btn-ghost" onclick="return prepareSubmit('borrador');">Guardar avance</button>
          <button type="submit" class="ac-btn-solid" onclick="return prepareSubmit('enviar') && confirm('¿Enviar la actividad? Revisen sus respuestas antes de confirmar.');">Enviar actividad</button>
        </div>
      @endif
    </form>

  </div>
</div>

@include('academico._floating-cta')
@endsection

@section('scripts')
@php
  $saveUrl = route('academico.activity.save', [$university->slug, $course->slug, $activity->slug]);
@endphp
<script>
(function () {
  const EXERCISES = @json($exercisesData);
  const GRADED = @json((bool) $grading);
  const SAVED = @json($submission->answers['exercises'] ?? []);
  const CAN_EDIT = @json($canEdit);
  const SAVE_URL = @json($saveUrl);
  const CSRF_TOKEN = @json(csrf_token());

  const state = { exercises: {} };

  function el(tag, className, text) {
    const e = document.createElement(tag);
    if (className) e.className = className;
    if (text !== undefined) e.textContent = text;
    return e;
  }

  function exHeader(ex) {
    const wrap = el('div', 'ac-ex-header');
    wrap.appendChild(el('span', 'ac-ex-points', ex.points + (ex.points === 1 ? ' pt' : ' pts')));
    wrap.appendChild(el('div', 'ac-ex-prompt', ex.prompt));
    return wrap;
  }

  function renderVF(ex) {
    const card = el('div', 'ac-ex-card');
    card.appendChild(exHeader(ex));
    card.appendChild(el('div', 'ac-ex-statement', ex.statement));
    const row = el('div', 'ac-vf-row');
    const trueBtn = el('button', 'ac-vf-btn', 'Verdadero');
    const falseBtn = el('button', 'ac-vf-btn', 'Falso');
    trueBtn.type = 'button'; falseBtn.type = 'button';

    let current = GRADED ? ex.student_answer : (SAVED[ex.id] ?? null);
    if (current === 'true') current = true;
    if (current === 'false') current = false;
    state.exercises[ex.id] = current;

    function refresh() {
      trueBtn.classList.toggle('selected', current === true);
      falseBtn.classList.toggle('selected', current === false);
    }
    refresh();

    if (GRADED) {
      trueBtn.disabled = true; falseBtn.disabled = true;
      [[trueBtn, true], [falseBtn, false]].forEach(([btn, val]) => {
        if (val === ex.correct_answer) btn.classList.add('answer-correct');
        else if (val === current && ! ex.correct) btn.classList.add('answer-wrong');
      });
    } else {
      trueBtn.addEventListener('click', () => { current = true; state.exercises[ex.id] = true; refresh(); markDirty(); });
      falseBtn.addEventListener('click', () => { current = false; state.exercises[ex.id] = false; refresh(); markDirty(); });
    }
    row.append(trueBtn, falseBtn);
    card.appendChild(row);
    return card;
  }

  function renderMCQ(ex) {
    const card = el('div', 'ac-ex-card');
    card.appendChild(exHeader(ex));
    const list = el('div', 'ac-mcq-list');
    let current = GRADED ? ex.student_answer : (SAVED[ex.id] ?? null);
    if (current !== null && current !== undefined) current = parseInt(current, 10);
    state.exercises[ex.id] = current;

    const buttons = [];
    ex.options.forEach((opt, idx) => {
      const btn = el('button', 'ac-mcq-opt', opt);
      btn.type = 'button';
      buttons.push(btn);
      function refresh() { btn.classList.toggle('selected', current === idx); }
      refresh();
      if (GRADED) {
        btn.disabled = true;
        if (idx === ex.correct_answer) btn.classList.add('answer-correct');
        else if (idx === current && ! ex.correct) btn.classList.add('answer-wrong');
      } else {
        btn.addEventListener('click', () => {
          current = idx;
          state.exercises[ex.id] = idx;
          buttons.forEach(b => b.classList.remove('selected'));
          btn.classList.add('selected');
          markDirty();
        });
      }
      list.appendChild(btn);
    });
    card.appendChild(list);
    return card;
  }

  function renderMatching(ex) {
    const card = el('div', 'ac-ex-card');
    card.appendChild(exHeader(ex));
    const wrap = el('div', 'ac-match-wrap');
    const leftCol = el('div', 'ac-match-col');
    const rightCol = el('div', 'ac-match-col');
    const colors = ['c1', 'c2', 'c3', 'c4', 'c5', 'c6'];
    const leftEls = {}, rightEls = {};
    let armed = null;

    const pairs = Object.assign({}, GRADED ? (ex.student_answer || {}) : (SAVED[ex.id] || {}));
    state.exercises[ex.id] = pairs;

    function colorFor(leftId) {
      const idx = ex.left.findIndex(l => l.id === leftId);
      return colors[idx % colors.length];
    }

    function refresh() {
      ex.left.forEach(l => {
        const chip = leftEls[l.id];
        chip.className = 'ac-match-chip';
        if (pairs[l.id]) chip.classList.add('paired', colorFor(l.id));
        if (armed === l.id) chip.classList.add('armed');
      });
      ex.right.forEach(r => {
        const chip = rightEls[r.id];
        chip.className = 'ac-match-chip';
        const pairedLeft = Object.keys(pairs).find(lid => pairs[lid] === r.id);
        if (pairedLeft) chip.classList.add('paired', colorFor(pairedLeft));
      });
    }

    ex.left.forEach(l => {
      const chip = el('div', 'ac-match-chip', l.text);
      if (! GRADED) {
        chip.addEventListener('click', () => {
          if (pairs[l.id]) { delete pairs[l.id]; armed = null; }
          else { armed = (armed === l.id) ? null : l.id; }
          state.exercises[ex.id] = pairs;
          refresh(); markDirty();
        });
      }
      leftEls[l.id] = chip;
      leftCol.appendChild(chip);
    });
    ex.right.forEach(r => {
      const chip = el('div', 'ac-match-chip', r.text);
      if (! GRADED) {
        chip.addEventListener('click', () => {
          if (armed) {
            Object.keys(pairs).forEach(lid => { if (pairs[lid] === r.id) delete pairs[lid]; });
            pairs[armed] = r.id;
            armed = null;
          } else {
            const lid = Object.keys(pairs).find(k => pairs[k] === r.id);
            if (lid) delete pairs[lid];
          }
          state.exercises[ex.id] = pairs;
          refresh(); markDirty();
        });
      }
      rightEls[r.id] = chip;
      rightCol.appendChild(chip);
    });

    refresh();
    wrap.append(leftCol, rightCol);
    card.appendChild(wrap);
    if (! GRADED) {
      card.appendChild(el('p', 'ac-ex-hint', 'Toca un elemento de la izquierda y luego su pareja a la derecha. Vuelve a tocarlo para deshacer.'));
    }

    if (GRADED) {
      const correctPairs = ex.correct_answer || {};
      ex.left.forEach(l => {
        const chosen = (ex.student_answer || {})[l.id];
        const isRight = chosen === correctPairs[l.id];
        leftEls[l.id].classList.add(isRight ? 'answer-correct' : 'answer-wrong');
        if (! isRight) {
          const correctText = (ex.right.find(r => r.id === correctPairs[l.id]) || {}).text || '—';
          leftEls[l.id].appendChild(el('div', 'ac-match-correct-note', 'Correcto: ' + correctText));
        }
      });
    }

    return card;
  }

  function renderOrdering(ex) {
    const card = el('div', 'ac-ex-card');
    card.appendChild(exHeader(ex));
    const saved = GRADED ? ex.student_answer : SAVED[ex.id];
    let order = (Array.isArray(saved) && saved.length === ex.items.length) ? saved.slice() : ex.items.map(i => i.id);
    state.exercises[ex.id] = order;

    function itemText(id) { return (ex.items.find(i => i.id === id) || {}).text || ''; }

    const list = el('div', 'ac-order-list');

    function refresh() {
      list.innerHTML = '';
      order.forEach((id, idx) => {
        const row = el('div', 'ac-order-row');
        row.appendChild(el('span', 'ac-order-num', String(idx + 1)));
        row.appendChild(el('span', 'ac-order-text', itemText(id)));
        if (! GRADED) {
          const controls = el('div', 'ac-order-controls');
          const up = el('button', 'ac-order-btn', '↑');
          const down = el('button', 'ac-order-btn', '↓');
          up.type = 'button'; down.type = 'button';
          up.disabled = idx === 0;
          down.disabled = idx === order.length - 1;
          up.addEventListener('click', () => { const t = order[idx - 1]; order[idx - 1] = order[idx]; order[idx] = t; state.exercises[ex.id] = order; refresh(); markDirty(); });
          down.addEventListener('click', () => { const t = order[idx + 1]; order[idx + 1] = order[idx]; order[idx] = t; state.exercises[ex.id] = order; refresh(); markDirty(); });
          controls.append(up, down);
          row.appendChild(controls);
        } else {
          const correctOrder = ex.correct_answer || [];
          row.classList.add(correctOrder[idx] === id ? 'answer-correct' : 'answer-wrong');
        }
        list.appendChild(row);
      });
      if (GRADED && ! ex.correct) {
        list.appendChild(el('div', 'ac-order-correct-note', 'Orden correcto: ' + (ex.correct_answer || []).map(itemText).join(' → ')));
      }
    }
    refresh();
    card.appendChild(list);
    return card;
  }

  const root = document.getElementById('exercisesRoot');
  if (root) {
    EXERCISES.forEach(ex => {
      let card;
      if (ex.type === 'vf') card = renderVF(ex);
      else if (ex.type === 'mcq') card = renderMCQ(ex);
      else if (ex.type === 'matching') card = renderMatching(ex);
      else if (ex.type === 'ordering') card = renderOrdering(ex);
      if (card) root.appendChild(card);
    });
  }

  document.querySelectorAll('.js-answer').forEach(t => {
    const counter = t.closest('.ac-question-card').querySelector('.ac-char-count');
    function update() { counter.textContent = t.value.length + ' / 4000'; }
    t.addEventListener('input', function () { update(); markDirty(); });
    update();
  });

  function collectAnswers() {
    const questions = {};
    document.querySelectorAll('.js-answer').forEach(t => { questions[t.dataset.qid] = t.value; });
    return { exercises: state.exercises, questions: questions };
  }

  window.prepareSubmit = function (action) {
    document.getElementById('actionInput').value = action;
    document.getElementById('answersInput').value = JSON.stringify(collectAnswers());
    return true;
  };

  // ── Autosave ──
  const statusEl = document.getElementById('autosaveStatus');
  let dirty = false;
  let saveTimer = null;
  let saving = false;

  function markDirty() {
    dirty = true;
    if (statusEl) statusEl.textContent = 'Cambios sin guardar…';
    clearTimeout(saveTimer);
    saveTimer = setTimeout(doAutosave, 2500);
  }

  function doAutosave() {
    if (! CAN_EDIT || saving) return;
    saving = true;
    fetch(SAVE_URL, {
      method: 'POST',
      keepalive: true,
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN,
      },
      body: new URLSearchParams({ action: 'borrador', answers: JSON.stringify(collectAnswers()) }),
    }).then(r => r.json()).then(data => {
      saving = false;
      dirty = false;
      if (statusEl) statusEl.textContent = data.ok ? ('Guardado automáticamente · ' + data.saved_at) : 'No se pudo guardar.';
    }).catch(() => {
      saving = false;
      if (statusEl) statusEl.textContent = 'Sin conexión — reintentando…';
    });
  }

  if (CAN_EDIT) {
    setInterval(function () { if (dirty) doAutosave(); }, 20000);
    document.addEventListener('visibilitychange', function () { if (document.hidden && dirty) doAutosave(); });
    window.addEventListener('pagehide', function () { if (dirty) doAutosave(); });
  }
})();
</script>
@endsection
