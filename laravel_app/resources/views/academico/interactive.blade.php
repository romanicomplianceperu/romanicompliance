@extends('layouts.app')

@section('title', $activity->title.' — '.$course->name.' — Espacio Académico')

@section('styles')
@include('academico._styles')
<style>
/* The site-wide WhatsApp bubble and "Certifícate gratis" CTA are position:fixed at the
   bottom of the screen. On a desktop-width layout they sit in the corners, clear of the
   centered content column — but on a mobile viewport the content fills the full width,
   so these two floating widgets end up directly on top of whatever scrolls underneath
   them (exercise cards, drag-and-drop chips, and the Guardar/Enviar buttons at the end
   of the form), making them untappable. Hide both on mobile widths on this page, since a
   student mid-activity shouldn't have a promo CTA competing for touch targets anyway. */
@media (max-width: 768px) {
  .wa-float, .ac-float-cta { display: none !important; }
}
</style>
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
        @if(count($grading['by_type']) > 1)
          <div class="ac-score-stats">
            @foreach($grading['by_type'] as $type => $stat)
              @php $statPct = $stat['total'] > 0 ? (int) round($stat['correct'] / $stat['total'] * 100) : 0; @endphp
              <div class="ac-score-stat">
                <div class="stat-row">
                  <span class="stat-label">{{ \App\Models\AcademicActivity::exerciseTypeLabel($type) }}</span>
                  <span class="stat-value">{{ $stat['correct'] }}/{{ $stat['total'] }}</span>
                </div>
                <div class="stat-bar"><div class="stat-fill" style="width:{{ $statPct }}%;"></div></div>
              </div>
            @endforeach
          </div>
        @endif
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
  const JUST_SUBMITTED = @json(session('academico_success') === 'Actividad enviada correctamente.');

  const state = { exercises: {} };

  // Small self-contained confetti burst (no external library) shown right after the
  // student submits the activity, on the page they land on after the redirect.
  function fireConfetti() {
    const canvas = document.createElement('canvas');
    canvas.style.cssText = 'position:fixed;inset:0;width:100vw;height:100vh;pointer-events:none;z-index:9999;';
    document.body.appendChild(canvas);
    const ctx = canvas.getContext('2d');

    function resize() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
    resize();
    window.addEventListener('resize', resize);

    const colors = ['#8B7340', '#B89A56', '#0B1829', '#2F6F4F', '#B4483A'];
    const pieces = Array.from({ length: 140 }).map(function () {
      return {
        x: Math.random() * canvas.width,
        y: -20 - Math.random() * canvas.height * 0.6,
        w: 5 + Math.random() * 6,
        h: 8 + Math.random() * 8,
        color: colors[Math.floor(Math.random() * colors.length)],
        speed: 2 + Math.random() * 3,
        drift: (Math.random() - 0.5) * 2.4,
        rot: Math.random() * Math.PI,
        rotSpeed: (Math.random() - 0.5) * 0.25,
      };
    });

    let frame = 0;
    function tick() {
      frame++;
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      let stillFalling = false;
      pieces.forEach(function (p) {
        p.y += p.speed;
        p.x += p.drift;
        p.rot += p.rotSpeed;
        if (p.y < canvas.height + 20) stillFalling = true;
        ctx.save();
        ctx.translate(p.x, p.y);
        ctx.rotate(p.rot);
        ctx.fillStyle = p.color;
        ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
        ctx.restore();
      });
      if (stillFalling && frame < 260) {
        requestAnimationFrame(tick);
      } else {
        window.removeEventListener('resize', resize);
        canvas.remove();
      }
    }
    tick();
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

    // Tap-to-pick / tap-to-place instead of free dragging: tap a card to pick it up (it gets
    // highlighted), then tap the box it belongs in. This needs no continuous pointer-tracking,
    // so — unlike a real drag — it can't get interrupted mid-gesture and leave a card stuck
    // floating on screen, which is exactly what was happening on some mobile browsers.
    let picked = null;

    function clearPicked() {
      if (picked) picked.classList.remove('picked');
      picked = null;
    }

    function place(chip, rightId) {
      if (rightId && zoneBoxes[rightId]) {
        zoneBoxes[rightId].appendChild(chip);
        chip.classList.add('placed');
      } else {
        tray.appendChild(chip);
        chip.classList.remove('placed');
      }
    }

    ex.right.forEach(r => {
      const zone = el('div', 'ac-match-zone');
      zone.dataset.rightId = r.id;
      zone.appendChild(el('div', 'zone-title', r.text));
      const box = el('div', 'zone-chips');
      zone.appendChild(box);
      zoneBoxes[r.id] = box;
      if (! GRADED) {
        zone.addEventListener('click', function () {
          if (! picked) return;
          pairs[picked.dataset.leftId] = r.id;
          place(picked, r.id);
          state.exercises[ex.id] = pairs;
          markDirty();
          clearPicked();
        });
      }
      zonesWrap.appendChild(zone);
    });

    ex.left.forEach(l => {
      const chip = el('div', 'ac-match-drag-chip', l.text);
      chip.dataset.leftId = l.id;
      if (! GRADED) {
        chip.addEventListener('click', function () {
          if (picked === chip) { clearPicked(); return; }
          clearPicked();
          picked = chip;
          chip.classList.add('picked');
        });
      } else {
        chip.setAttribute('disabled', 'disabled');
      }
      chipEls[l.id] = chip;
      place(chip, pairs[l.id]);
    });

    if (! GRADED) {
      // Tapping empty tray space while a card is picked up sends it back to the tray.
      tray.addEventListener('click', function (e) {
        if (e.target === tray && picked) {
          delete pairs[picked.dataset.leftId];
          place(picked, null);
          state.exercises[ex.id] = pairs;
          markDirty();
          clearPicked();
        }
      });
    }

    card.appendChild(tray);
    card.appendChild(zonesWrap);
    if (! GRADED) {
      card.appendChild(el('p', 'ac-ex-hint', 'Toca una tarjeta para elegirla y luego toca la casilla donde va. Toca una tarjeta ya colocada para volver a moverla.'));
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

    function refresh() {
      list.innerHTML = '';
      order.forEach((id, idx) => {
        const row = el('div', 'ac-order-row');
        row.dataset.id = id;
        row.appendChild(el('span', 'ac-order-num', String(idx + 1)));
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
      card.appendChild(el('p', 'ac-ex-hint', 'Usa las flechas ↑ ↓ para ordenar las tarjetas.'));
    } else if (! ex.correct) {
      card.appendChild(el('div', 'ac-order-correct-note', 'Orden correcto: ' + (ex.correct_answer || []).map(itemText).join(' → ')));
    }
    return card;
  }

  function renderMemory(ex) {
    const card = el('div', 'ac-ex-card');
    card.appendChild(exHeader(ex));

    if (GRADED) {
      const grouped = {};
      ex.cards.forEach(c => { (grouped[c.pairId] = grouped[c.pairId] || []).push(c); });
      const found = new Set(ex.student_answer || []);
      const list = el('div', 'ac-memory-review');
      Object.keys(grouped).forEach(pairId => {
        const pair = grouped[pairId];
        const row = el('div', 'ac-memory-review-row ' + (found.has(pairId) ? 'answer-correct' : 'answer-wrong'));
        row.appendChild(el('span', 'ac-memory-review-text', pair[0] ? pair[0].text : ''));
        row.appendChild(el('span', 'ac-memory-review-link', '↔'));
        row.appendChild(el('span', 'ac-memory-review-text', pair[1] ? pair[1].text : ''));
        list.appendChild(row);
      });
      card.appendChild(list);
      if (! ex.correct) {
        card.appendChild(el('p', 'ac-ex-hint', 'Las parejas en rojo no se encontraron antes de enviar la actividad.'));
      }
      return card;
    }

    const grid = el('div', 'ac-memory-grid');
    const matched = new Set(SAVED[ex.id] || []);
    state.exercises[ex.id] = Array.from(matched);

    let flipped = [];
    let busy = false;

    ex.cards.forEach(c => {
      const cardEl = el('div', 'ac-memory-card' + (matched.has(c.pairId) ? ' matched flipped' : ''));
      cardEl.dataset.cardId = c.cardId;
      cardEl.dataset.pairId = c.pairId;
      const inner = el('div', 'ac-memory-card-inner');
      const front = el('div', 'ac-memory-card-front', '🎓');
      const back = el('div', 'ac-memory-card-back', c.text);
      inner.append(front, back);
      cardEl.appendChild(inner);

      if (! matched.has(c.pairId)) {
        cardEl.addEventListener('click', function () {
          if (busy || cardEl.classList.contains('flipped') || cardEl.classList.contains('matched')) return;
          cardEl.classList.add('flipped');
          flipped.push({ pairId: c.pairId, el: cardEl });
          if (flipped.length === 2) {
            busy = true;
            const [a, b] = flipped;
            if (a.pairId === b.pairId) {
              a.el.classList.add('matched');
              b.el.classList.add('matched');
              matched.add(a.pairId);
              state.exercises[ex.id] = Array.from(matched);
              markDirty();
              flipped = [];
              busy = false;
            } else {
              setTimeout(function () {
                a.el.classList.remove('flipped');
                b.el.classList.remove('flipped');
                flipped = [];
                busy = false;
              }, 800);
            }
          }
        });
      }
      grid.appendChild(cardEl);
    });

    card.appendChild(grid);
    card.appendChild(el('p', 'ac-ex-hint', 'Toca dos tarjetas para encontrar su pareja. Si no coinciden, se voltean de nuevo.'));
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
      else if (ex.type === 'memory') card = renderMemory(ex);
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

  if (JUST_SUBMITTED) {
    fireConfetti();
  }
})();
</script>
@endsection
