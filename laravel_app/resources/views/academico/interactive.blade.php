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

  // The floating "Certifícate gratis" and WhatsApp buttons are position:fixed and can sit on
  // top of a drop zone near the bottom/edges of the screen (a real issue on desktop, where the
  // pointer can pass right over them). Suspend their hit-testing for the duration of any drag so
  // elementFromPoint() always finds the drop zone underneath instead of the floating button.
  function suspendFloatingButtons(suspend) {
    document.querySelectorAll('.ac-float-cta, .wa-float').forEach(function (btn) {
      btn.style.pointerEvents = suspend ? 'none' : '';
    });
  }

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

    const tray = el('div', 'ac-match-tray');
    const zonesWrap = el('div', 'ac-match-zones');
    const zoneBoxes = {}, chipEls = {};

    const pairs = Object.assign({}, GRADED ? (ex.student_answer || {}) : (SAVED[ex.id] || {}));
    state.exercises[ex.id] = pairs;

    ex.right.forEach(r => {
      const zone = el('div', 'ac-match-zone');
      zone.dataset.rightId = r.id;
      zone.appendChild(el('div', 'zone-title', r.text));
      const box = el('div', 'zone-chips');
      zone.appendChild(box);
      zoneBoxes[r.id] = box;
      zonesWrap.appendChild(zone);
    });

    function place(chip, rightId) {
      if (rightId && zoneBoxes[rightId]) {
        zoneBoxes[rightId].appendChild(chip);
        chip.classList.add('placed');
      } else {
        tray.appendChild(chip);
        chip.classList.remove('placed');
      }
    }

    function bindDrag(chip) {
      chip.addEventListener('pointerdown', function (e) {
        if (chip.hasAttribute('disabled')) return;
        e.preventDefault();
        const rect = chip.getBoundingClientRect();
        const offsetX = e.clientX - rect.left, offsetY = e.clientY - rect.top;
        chip.setPointerCapture(e.pointerId);
        chip.classList.add('dragging');
        suspendFloatingButtons(true);
        document.body.appendChild(chip);
        Object.assign(chip.style, { position: 'fixed', left: rect.left + 'px', top: rect.top + 'px', width: rect.width + 'px', zIndex: 999, pointerEvents: 'none' });

        function move(ev) {
          chip.style.left = (ev.clientX - offsetX) + 'px';
          chip.style.top = (ev.clientY - offsetY) + 'px';
          zonesWrap.querySelectorAll('.ac-match-zone').forEach(z => z.classList.remove('over'));
          const under = document.elementFromPoint(ev.clientX, ev.clientY);
          const zone = under ? under.closest('.ac-match-zone') : null;
          if (zone) zone.classList.add('over');
        }
        function up(ev) {
          chip.removeEventListener('pointermove', move);
          chip.removeEventListener('pointerup', up);
          chip.classList.remove('dragging');
          suspendFloatingButtons(false);
          chip.style.position = ''; chip.style.left = ''; chip.style.top = ''; chip.style.width = ''; chip.style.zIndex = ''; chip.style.pointerEvents = '';
          zonesWrap.querySelectorAll('.ac-match-zone').forEach(z => z.classList.remove('over'));

          const under = document.elementFromPoint(ev.clientX, ev.clientY);
          const zone = under ? under.closest('.ac-match-zone') : null;
          const rightId = zone ? zone.dataset.rightId : null;

          if (rightId) pairs[chip.dataset.leftId] = rightId;
          else delete pairs[chip.dataset.leftId];

          place(chip, rightId);
          state.exercises[ex.id] = pairs;
          markDirty();
        }
        chip.addEventListener('pointermove', move);
        chip.addEventListener('pointerup', up);
      });
    }

    ex.left.forEach(l => {
      const chip = el('div', 'ac-match-drag-chip', l.text);
      chip.dataset.leftId = l.id;
      chip.style.touchAction = 'none';
      if (! GRADED) bindDrag(chip);
      else chip.setAttribute('disabled', 'disabled');
      chipEls[l.id] = chip;
      place(chip, pairs[l.id]);
    });

    card.appendChild(tray);
    card.appendChild(zonesWrap);
    if (! GRADED) {
      card.appendChild(el('p', 'ac-ex-hint', 'Arrastra cada tarjeta hacia la casilla que le corresponde. Puedes moverla de nuevo si te equivocas.'));
    }

    if (GRADED) {
      const correctPairs = ex.correct_answer || {};
      ex.left.forEach(l => {
        const chosen = (ex.student_answer || {})[l.id];
        const isRight = chosen === correctPairs[l.id];
        chipEls[l.id].classList.add(isRight ? 'answer-correct' : 'answer-wrong');
        if (! isRight) {
          const correctText = (ex.right.find(r => r.id === correctPairs[l.id]) || {}).text || '—';
          chipEls[l.id].appendChild(el('div', 'ac-match-correct-note', 'Correcto: ' + correctText));
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

    function commitOrder(newOrder) {
      order = newOrder;
      state.exercises[ex.id] = order;
      markDirty();
      refresh();
    }

    function bindRowDrag(handle, row) {
      handle.addEventListener('pointerdown', function (e) {
        e.preventDefault();
        handle.setPointerCapture(e.pointerId);
        row.classList.add('dragging');
        suspendFloatingButtons(true);
        row.style.pointerEvents = 'none';

        function move(ev) {
          const under = document.elementFromPoint(ev.clientX, ev.clientY);
          const target = under ? under.closest('.ac-order-row') : null;
          if (! target || target === row) return;
          const rect = target.getBoundingClientRect();
          const before = ev.clientY < rect.top + rect.height / 2;
          list.insertBefore(row, before ? target : target.nextSibling);
        }
        function up() {
          handle.removeEventListener('pointermove', move);
          handle.removeEventListener('pointerup', up);
          row.classList.remove('dragging');
          row.style.pointerEvents = '';
          suspendFloatingButtons(false);
          commitOrder(Array.from(list.children).map(r => r.dataset.id));
        }
        handle.addEventListener('pointermove', move);
        handle.addEventListener('pointerup', up);
      });
    }

    function refresh() {
      list.innerHTML = '';
      order.forEach((id, idx) => {
        const row = el('div', 'ac-order-row');
        row.dataset.id = id;
        if (! GRADED) {
          const handle = el('div', 'ac-order-handle', '⠿');
          handle.style.touchAction = 'none';
          bindRowDrag(handle, row);
          row.appendChild(handle);
        } else {
          row.appendChild(el('span', 'ac-order-num', String(idx + 1)));
        }
        row.appendChild(el('span', 'ac-order-text', itemText(id)));
        if (! GRADED) {
          const controls = el('div', 'ac-order-controls');
          const up = el('button', 'ac-order-btn', '↑');
          const down = el('button', 'ac-order-btn', '↓');
          up.type = 'button'; down.type = 'button';
          up.disabled = idx === 0;
          down.disabled = idx === order.length - 1;
          up.addEventListener('click', () => { const o = order.slice(); const t = o[idx - 1]; o[idx - 1] = o[idx]; o[idx] = t; commitOrder(o); });
          down.addEventListener('click', () => { const o = order.slice(); const t = o[idx + 1]; o[idx + 1] = o[idx]; o[idx] = t; commitOrder(o); });
          controls.append(up, down);
          row.appendChild(controls);
        } else {
          const correctOrder = ex.correct_answer || [];
          row.classList.add(correctOrder[idx] === id ? 'answer-correct' : 'answer-wrong');
        }
        list.appendChild(row);
      });
    }
    refresh();
    card.appendChild(list);
    if (! GRADED) {
      card.appendChild(el('p', 'ac-ex-hint', 'Arrastra la tarjeta desde ⠿ para ordenarla, o usa las flechas.'));
    } else if (! ex.correct) {
      card.appendChild(el('div', 'ac-order-correct-note', 'Orden correcto: ' + (ex.correct_answer || []).map(itemText).join(' → ')));
    }
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
