@extends('layouts.app')

@section('title', $course->title.' — Romani Compliance')

@section('styles')
.course-hero { background: var(--ink); padding: 3.5rem 0; position: relative; }
.course-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
.course-hero-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; align-items: start; }
.course-hero-category { font-size: 0.7rem; color: var(--gold-light); font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.6rem; }
.course-hero h1 { font-size: clamp(1.6rem, 3.5vw, 2.3rem); color: var(--white); font-weight: 400; margin-bottom: 0.8rem; }
.course-hero p { font-size: 0.9rem; color: rgba(255,255,255,0.5); line-height: 1.7; }
.course-meta-list { display: flex; gap: 1.5rem; margin-top: 1.2rem; flex-wrap: wrap; }
.course-meta-list span { font-size: 0.8rem; color: rgba(255,255,255,0.6); }
.instructor-link { color: var(--gold-light); font-weight: 600; text-decoration: underline; text-underline-offset: 2px; transition: color 0.2s; }
.instructor-link:hover { color: var(--white); }
.course-cert-clarify { background: rgba(184,154,86,0.1); border: 1px solid rgba(184,154,86,0.3); border-radius: 6px; padding: 10px 14px; font-size: 0.82rem !important; color: rgba(255,255,255,0.75) !important; margin-bottom: 1rem; }
.course-cert-clarify strong { color: var(--gold-light); }
.course-hero-card { background: var(--white); border-radius: 8px; overflow: hidden; box-shadow: var(--shadow-m); }
.course-hero-card img { width: 100%; aspect-ratio: 16 / 9; height: auto; object-fit: cover; display: block; }
.course-hero-card-body { padding: 1.5rem; }
.progress-track { background: var(--ivory-dim); border-radius: 20px; height: 8px; overflow: hidden; margin-bottom: 0.5rem; }
.progress-fill { background: var(--gold); height: 100%; }
.progress-label { font-size: 0.72rem; color: var(--slate); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 1rem; }
.btn-block { display: block; text-align: center; width: 100%; }
.btn-cert { border: 1px solid var(--gold); color: var(--gold); background: transparent; margin-top: 10px; }
.btn-cert:hover { background: var(--gold-pale); }
.btn-cert-locked { border: 1px solid var(--line); color: var(--slate-light); background: transparent; cursor: not-allowed; }
.btn-cert-locked:hover { background: transparent; }

.login-cta-note { font-size: 0.72rem; color: var(--slate-light); text-align: center; margin-top: 8px; }

.content-section { padding: 3.5rem 0; }
.accordion-item { border: 1px solid var(--line); border-radius: 8px; margin-bottom: 1rem; overflow: hidden; background: var(--white); transition: border-color 0.3s, box-shadow 0.3s; }
.accordion-item.open { border-color: var(--gold); box-shadow: var(--shadow-s); }
.accordion-head { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 1.1rem 1.4rem; cursor: pointer; background: var(--white); user-select: none; }
.accordion-head:hover { background: var(--ivory); }
.accordion-head-left { display: flex; align-items: center; gap: 12px; }
.accordion-num { font-family: var(--serif); font-size: 1.3rem; font-weight: 300; color: var(--line); }
.accordion-item.open .accordion-num { color: var(--gold); }
.accordion-title h3 { font-size: 1.08rem; font-weight: 600; margin-bottom: 2px; color: var(--ink); }
.accordion-meta { font-size: 0.76rem; color: var(--slate); font-weight: 500; }
.accordion-chevron { width: 18px; height: 18px; flex-shrink: 0; transition: transform 0.35s cubic-bezier(0.22,1,0.36,1); color: var(--slate-light); }
.accordion-item.open .accordion-chevron { transform: rotate(180deg); color: var(--gold); }
.accordion-panel { max-height: 0; overflow: hidden; transition: max-height 0.4s cubic-bezier(0.22,1,0.36,1); }
.accordion-panel-inner { padding: 0 1.4rem 1.2rem; }

.lesson-item { display: flex; align-items: center; justify-content: space-between; padding: 13px 16px; background: var(--ivory); border: 1px solid var(--line); border-radius: var(--radius); margin-bottom: 8px; font-size: 0.9rem; font-weight: 500; color: var(--ink); transition: border-color 0.2s, transform 0.2s; }
.lesson-item:last-child { margin-bottom: 0; }
.lesson-item.locked { opacity: 0.6; }
.lesson-item.clickable:hover { border-color: var(--gold); transform: translateX(2px); }
.lesson-item-title { display: flex; align-items: center; gap: 10px; }
.lesson-icon { width: 15px; height: 15px; flex-shrink: 0; color: var(--slate-light); }
.lesson-type-tag { font-size: 0.62rem; font-weight: 700; text-transform: uppercase; color: var(--gold); background: var(--gold-pale); padding: 2px 8px; border-radius: 10px; }
.lesson-check { color: #1F7A4D; display: inline-flex; }
.lesson-check svg { width: 14px; height: 14px; }
.lesson-lock { color: var(--slate-light); display: inline-flex; }
.lesson-lock svg { width: 13px; height: 13px; }

@media (max-width: 900px) {
  .course-hero-layout { grid-template-columns: 1fr; }
  .accordion-head { padding: 1rem; }
  .accordion-panel-inner { padding: 0 1rem 1rem; }
}
@endsection

@section('content')
@if($enrollment && in_array($certificateStage ?? 'none', ['awaiting_payment', 'processing'], true))
  <div class="wrap" style="padding-top:2rem;">
    @include('courses._certificate-payment-banner', ['course' => $course, 'stage' => $certificateStage, 'enrollment' => $enrollment])
  </div>
@endif
<section class="course-hero">
  <div class="wrap course-hero-layout">
    <div>
      @if($course->category)
        <div class="course-hero-category">{{ $course->category->name }}</div>
      @endif
      <h1>{{ $course->title }}</h1>
      <div style="margin-bottom:1rem;display:flex;gap:6px;flex-wrap:wrap;">@include('courses._certificate-badge') @include('courses._exclusive-badge')</div>
      @if(($course->certificate_type ?? 'gratuita') === 'opcional')
        <p class="course-cert-clarify">Este curso es <strong>gratuito</strong>. Solo la certificación oficial tiene un costo de <strong>S/ {{ number_format($course->certificate_price ?? 0, 2) }}</strong>, y es completamente opcional.</p>
      @endif
      <p>{{ $course->description }}</p>
      <div class="course-meta-list">
        @if($course->instructor)
          <span>Instructor: <a href="{{ route('blog.author', $course->instructor) }}" class="instructor-link">{{ $course->instructor->name }}</a></span>
        @elseif($course->instructor_name)
          <span>Instructor: {{ $course->instructor_name }}</span>
        @endif
        @if($course->duration_minutes)<span>Duración: {{ $course->lectiveHours() }} {{ $course->lectiveHours() === 1 ? 'hora' : 'horas' }}</span>@endif
      </div>
    </div>
    <div class="course-hero-card">
      @if($course->cover_image)
        <img src="{{ asset('storage/'.$course->cover_image) }}" alt="{{ $course->title }}">
      @endif
      <div class="course-hero-card-body">
        @if($enrollment)
          <div class="progress-track"><div class="progress-fill" style="width:{{ $enrollment->progress_percent }}%"></div></div>
          <div class="progress-label">{{ $enrollment->progress_percent }}% completado</div>
          @php $next = $course->nextLessonFor(auth()->user()); @endphp
          @if($next)
            <a href="{{ route('lessons.show', $next) }}" class="btn btn-gold btn-block">{{ $enrollment->progress_percent > 0 ? 'Continuar curso' : 'Comenzar curso' }}</a>
          @else
            <div class="btn btn-block" style="background:var(--gold-pale);color:var(--gold);">Curso completado</div>
          @endif

          @if($course->exam)
            @if($certificate)
              <a href="{{ route('certificates.download', $certificate) }}" class="btn btn-gold btn-block" style="margin-top:10px;">Descargar certificado</a>
            @elseif($pendingCertificate)
              <div class="btn btn-cert-locked btn-block" style="margin-top:10px;cursor:default;">Certificado en proceso</div>
              <div class="login-cta-note">Aprobaste el examen. Se emitirá al confirmar tu pago.</div>
            @elseif(!$next)
              @if(($course->certificate_type ?? 'gratuita') === 'opcional')
                <button type="button" class="btn btn-cert btn-block" onclick="abrirModalCompra()">Conseguir certificación</button>
              @else
                <a href="{{ route('exams.show', $course) }}" class="btn btn-cert btn-block">Conseguir certificación</a>
              @endif
            @else
              <button type="button" class="btn btn-cert btn-cert-locked btn-block" onclick="abrirModalBloqueo()">Conseguir certificación</button>
            @endif
          @endif
        @elseif(auth()->check())
          <form action="{{ route('courses.enroll', $course) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-gold btn-block">Inscribirme</button>
          </form>
        @else
          <a href="{{ route('login', ['intended' => route('courses.show', $course)]) }}" class="btn btn-gold btn-block">Inicia sesión para inscribirte</a>
          <div class="login-cta-note">Ingresa con tu cuenta de Google, es gratis y toma un minuto.</div>
        @endif
      </div>
    </div>
  </div>
</section>

<section class="content-section">
  <div class="wrap">
    <div class="section-header reveal">
      <div class="gold-line"></div>
      <h2>Contenido del curso</h2>
    </div>

    @forelse($course->modules as $module)
      <div class="accordion-item {{ $loop->first ? 'open' : '' }}">
        <div class="accordion-head" onclick="toggleAccordion(this)">
          <div class="accordion-head-left">
            <span class="accordion-num">{{ sprintf('%02d', $loop->iteration) }}</span>
            <div class="accordion-title">
              <h3>{{ $module->title }}</h3>
              <div class="accordion-meta">{{ $module->lessons->count() }} {{ $module->lessons->count() === 1 ? 'lección' : 'lecciones' }}</div>
            </div>
          </div>
          <svg class="accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </div>
        <div class="accordion-panel">
          <div class="accordion-panel-inner">
            @forelse($module->lessons as $lesson)
              <div class="lesson-item {{ $enrollment ? 'clickable' : 'locked' }}" @if($enrollment) onclick="window.location='{{ route('lessons.show', $lesson) }}'" @endif>
                <div class="lesson-item-title">
                  @if($completedLessonIds->contains($lesson->id))
                    <span class="lesson-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></span>
                  @elseif(!$enrollment)
                    <span class="lesson-lock"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="11" width="14" height="9" rx="1.5"/><path d="M8 11V8a4 4 0 018 0v3"/></svg></span>
                  @endif
                  <span>{{ $lesson->title }}</span>
                  <span class="lesson-type-tag">{{ $lesson->typeLabel() }}</span>
                </div>
                @if($enrollment)
                  <span style="font-size:0.75rem;color:var(--gold);font-weight:600;">Ver →</span>
                @endif
              </div>
            @empty
              <p class="form-hint">Sin lecciones todavía.</p>
            @endforelse
          </div>
        </div>
      </div>
    @empty
      <div class="empty-state" style="text-align:center;padding:2rem;color:var(--slate);border:1px dashed var(--line);border-radius:6px;">Este curso todavía no tiene contenido cargado.</div>
    @endforelse
  </div>
</section>

<div class="modal-overlay" id="modalBloqueo">
  <div class="modal-backdrop" onclick="cerrarModalesCurso()"></div>
  <div class="modal-box" style="max-width:420px;text-align:center;">
    <button class="modal-close" onclick="cerrarModalesCurso()">&times;</button>
    <h3>Completa el curso primero</h3>
    <p class="modal-text">Debes finalizar todas las lecciones del curso para poder acceder a tu certificación.</p>
  </div>
</div>

@if(($course->certificate_type ?? 'gratuita') === 'opcional')
<div class="modal-overlay" id="modalCompra">
  <div class="modal-backdrop" onclick="cerrarModalesCurso()"></div>
  <div class="modal-box" style="max-width:440px;text-align:center;">
    <button class="modal-close" onclick="cerrarModalesCurso()">&times;</button>
    <h3>Certificación opcional</h3>
    <p class="modal-sub">{{ $course->title }}</p>
    <div class="modal-price">S/ {{ number_format($course->certificate_price ?? 0, 2) }} <span>/ certificado</span></div>
    <p class="modal-text">Esta certificación tiene un costo adicional. Coordina tu pago escribiéndonos por WhatsApp y te habilitaremos el examen para obtenerla.</p>
    <a href="https://wa.me/51969754983?text={{ urlencode('Hola, deseo adquirir la certificación opcional del curso "'.$course->title.'".') }}" target="_blank" class="btn-whatsapp">
      <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      Comprar a través de WhatsApp
    </a>
    <a href="{{ route('exams.show', $course) }}" class="modal-text" style="display:block;margin-top:14px;color:var(--gold);font-weight:600;text-decoration:underline;">Ya realicé el pago, continuar con el examen</a>
  </div>
</div>
@endif
@endsection

@section('scripts')
<script>
function toggleAccordion(headEl) {
  const item = headEl.closest('.accordion-item');
  const panel = item.querySelector('.accordion-panel');
  const isOpen = item.classList.contains('open');
  if (isOpen) {
    panel.style.maxHeight = null;
    item.classList.remove('open');
  } else {
    item.classList.add('open');
    panel.style.maxHeight = panel.scrollHeight + 'px';
  }
}
document.querySelectorAll('.accordion-item.open .accordion-panel').forEach(panel => {
  panel.style.maxHeight = panel.scrollHeight + 'px';
});

function abrirModalCompra() { document.getElementById('modalCompra')?.classList.add('active'); }
function abrirModalBloqueo() { document.getElementById('modalBloqueo')?.classList.add('active'); }
function cerrarModalesCurso() { document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active')); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModalesCurso(); });
</script>
@endsection
