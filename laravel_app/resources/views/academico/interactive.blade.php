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

    @if($activity->due_at)
      <div class="ac-deadline-badge {{ $activity->isPastDue() ? 'closed' : '' }}">
        ⏱ {{ $activity->isPastDue() ? 'Plazo vencido — ' : 'Fecha límite: ' }}{{ $activity->due_at->timezone('America/Lima')->translatedFormat('d \d\e F, H:i').' h' }}
      </div>
    @endif

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
          @foreach($activity->caseBodyParagraphs() as $p)
            <p>{{ $p }}</p>
          @endforeach
        </div>
      @endif
    </div>

    @if(! $canEdit)
      <div class="ac-response-sent" style="margin-bottom:1.6rem;">
        Actividad enviada el {{ $submission->submitted_at?->timezone('America/Lima')->format('d/m/Y H:i') }} h. Ya no se puede editar.
      </div>
    @endif

    <form method="POST" action="{{ route('academico.activity.save', [$university->slug, $course->slug, $activity->slug]) }}" id="interactiveForm">
      @csrf
      <input type="hidden" name="action" id="actionInput" value="borrador">
      <input type="hidden" name="answers" id="answersInput">

      <div class="ac-game" data-game="game1" @if(! $canEdit) style="pointer-events:none;opacity:0.65;" @endif>
        <h3>Juego 1 — Ubica cada hecho en su criterio</h3>
        <p class="ac-game-hint">La Cas. Lab. 3733-2009 reconoce un «grupo de empresas» cuando concurren estos criterios. Arrastra cada hecho del caso hacia el criterio que sustenta.</p>
        <div class="ac-dnd-chips">
          @php
            $game1Chips = [
              'g1-1' => ['text' => 'Los esposos M. son los dos únicos socios de Distribuidora Norte S.A.C. y controlan también Comercial Norte E.I.R.L.', 'zone' => 'misma-persona'],
              'g1-2' => ['text' => 'La titular de Comercial Norte E.I.R.L. es la esposa de uno de los socios de la S.A.C.', 'zone' => 'vinculos-familiares'],
              'g1-3' => ['text' => 'Ambas empresas operan en el mismo local.', 'zone' => 'mismo-local'],
              'g1-4' => ['text' => 'Ambas empresas trabajan con el mismo personal.', 'zone' => 'mismo-local'],
            ];
            $game1Saved = $submission->answers['game1'] ?? [];
          @endphp
          @foreach($game1Chips as $id => $chip)
            @if(empty($game1Saved[$id]))
              <div class="ac-dnd-chip" draggable="false" data-id="{{ $id }}" data-correct="{{ $chip['zone'] }}">{{ $chip['text'] }}</div>
            @endif
          @endforeach
        </div>
        <div class="ac-dnd-zones">
          @foreach(['misma-persona' => 'Misma persona controladora', 'vinculos-familiares' => 'Vínculos familiares', 'mismo-local' => 'Mismo local / personal'] as $zoneId => $zoneLabel)
            <div class="ac-dnd-zone" data-zone="{{ $zoneId }}">
              <div class="zone-title">{{ $zoneLabel }}</div>
              <div class="zone-chips">
                @foreach($game1Chips as $id => $chip)
                  @if(($game1Saved[$id] ?? null) === $zoneId)
                    <div class="ac-dnd-chip placed" draggable="false" data-id="{{ $id }}" data-correct="{{ $chip['zone'] }}">{{ $chip['text'] }}</div>
                  @endif
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
        <div class="ac-game-feedback" id="game1Feedback"></div>
      </div>

      <div class="ac-game" data-game="game2" @if(! $canEdit) style="pointer-events:none;opacity:0.65;" @endif>
        <h3>Juego 2 — Ubica la norma</h3>
        <p class="ac-game-hint">Arrastra cada referencia normativa hacia la pregunta que te ayuda a responder.</p>
        <div class="ac-dnd-chips">
          @php
            $game2Chips = [
              'g2-1' => ['text' => 'Ley N.° 26887 (LGS), arts. 6 y 11', 'zone' => 'autonomia'],
              'g2-2' => ['text' => 'Código Civil, art. 78', 'zone' => 'autonomia'],
              'g2-3' => ['text' => 'Código Civil, art. II Tít. Preliminar (abuso del derecho)', 'zone' => 'velo'],
              'g2-4' => ['text' => 'Cas. Lab. 3733-2009-Lima', 'zone' => 'velo'],
              'g2-5' => ['text' => 'Exp. 7172-2006-BE(A)', 'zone' => 'velo'],
            ];
            $game2Saved = $submission->answers['game2'] ?? [];
          @endphp
          @foreach($game2Chips as $id => $chip)
            @if(empty($game2Saved[$id]))
              <div class="ac-dnd-chip" draggable="false" data-id="{{ $id }}" data-correct="{{ $chip['zone'] }}">{{ $chip['text'] }}</div>
            @endif
          @endforeach
        </div>
        <div class="ac-dnd-zones">
          @foreach(['autonomia' => 'Autonomía patrimonial y su límite', 'velo' => 'Levantamiento del velo / grupo de empresas'] as $zoneId => $zoneLabel)
            <div class="ac-dnd-zone" data-zone="{{ $zoneId }}">
              <div class="zone-title">{{ $zoneLabel }}</div>
              <div class="zone-chips">
                @foreach($game2Chips as $id => $chip)
                  @if(($game2Saved[$id] ?? null) === $zoneId)
                    <div class="ac-dnd-chip placed" draggable="false" data-id="{{ $id }}" data-correct="{{ $chip['zone'] }}">{{ $chip['text'] }}</div>
                  @endif
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
        <div class="ac-game-feedback" id="game2Feedback"></div>
      </div>

      @if($activity->questions->count() > 0)
        <h3 style="font-size:1rem;color:var(--ink);margin-bottom:1rem;">Preguntas de participación</h3>
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
      @endif

      @if($canEdit)
        <div class="ac-question-actions" style="margin-top:1rem;">
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
<script>
(function () {
  const state = {
    game1: @json($game1Saved ?? []),
    game2: @json($game2Saved ?? []),
  };

  function bindDrag(chip, zoneAttr, feedbackEl) {
    chip.addEventListener('pointerdown', function (e) {
      if (chip.hasAttribute('disabled')) return;
      const rect = chip.getBoundingClientRect();
      const offsetX = e.clientX - rect.left, offsetY = e.clientY - rect.top;
      chip.setPointerCapture(e.pointerId);
      chip.classList.add('dragging');
      const originalParent = chip.parentElement;
      document.body.appendChild(chip);
      Object.assign(chip.style, { position: 'fixed', left: rect.left + 'px', top: rect.top + 'px', width: rect.width + 'px', zIndex: 999 });

      function move(ev) {
        chip.style.left = (ev.clientX - offsetX) + 'px';
        chip.style.top = (ev.clientY - offsetY) + 'px';
        document.querySelectorAll('.ac-dnd-zone').forEach(z => z.classList.remove('over'));
        const under = document.elementFromPoint(ev.clientX, ev.clientY);
        const zone = under ? under.closest('.ac-dnd-zone') : null;
        if (zone) zone.classList.add('over');
      }
      function up(ev) {
        chip.removeEventListener('pointermove', move);
        chip.removeEventListener('pointerup', up);
        chip.classList.remove('dragging');
        chip.style.position = ''; chip.style.left = ''; chip.style.top = ''; chip.style.width = ''; chip.style.zIndex = '';
        document.querySelectorAll('.ac-dnd-zone').forEach(z => z.classList.remove('over'));

        const under = document.elementFromPoint(ev.clientX, ev.clientY);
        const zone = under ? under.closest('.ac-dnd-zone') : null;
        const game = chip.closest('.ac-game') ? chip.closest('.ac-game').dataset.game : originalParent.closest('.ac-game').dataset.game;

        if (zone) {
          zone.querySelector('.zone-chips').appendChild(chip);
          chip.classList.add('placed');
          state[game][chip.dataset.id] = zone.dataset.zone;
          const ok = chip.dataset.correct === zone.dataset.zone;
          feedbackEl.textContent = ok ? 'Bien ubicado.' : 'Revisa ese hecho: quizá encaje mejor en otro criterio.';
          feedbackEl.className = 'ac-game-feedback ' + (ok ? 'ok' : 'warn');
        } else {
          originalParent.appendChild(chip);
          delete state[game][chip.dataset.id];
        }
      }
      chip.addEventListener('pointermove', move);
      chip.addEventListener('pointerup', up);
    });
  }

  document.querySelectorAll('.ac-game').forEach(game => {
    const feedback = game.querySelector('.ac-game-feedback');
    game.querySelectorAll('.ac-dnd-chip').forEach(chip => bindDrag(chip, game.dataset.game, feedback));
  });

  document.querySelectorAll('.js-answer').forEach(t => {
    const counter = t.closest('.ac-question-card').querySelector('.ac-char-count');
    function update() { counter.textContent = t.value.length + ' / 4000'; }
    t.addEventListener('input', update);
    update();
  });

  window.prepareSubmit = function (action) {
    document.getElementById('actionInput').value = action;
    const questions = {};
    document.querySelectorAll('.js-answer').forEach(t => { questions[t.dataset.qid] = t.value; });
    document.getElementById('answersInput').value = JSON.stringify({
      game1: state.game1,
      game2: state.game2,
      questions: questions,
    });
    return true;
  };
})();
</script>
@endsection
