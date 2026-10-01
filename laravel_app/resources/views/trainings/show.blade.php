@extends('layouts.app')

@section('title', $training->title.' · Romani Compliance')
@section('description', $training->subtitle)

@section('styles')
@include('trainings._styles')
@endsection

@section('content')
<div class="tr-shell">

  <section class="tr-hero">
    <div class="wrap">
      <div class="tr-hero-badge">{{ $training->organizer }}</div>
      <h1 class="tr-hero-title">{{ $training->title }}</h1>
      <p class="tr-hero-sub">{{ $training->subtitle }}</p>
      <div class="tr-hero-meta">
        <div class="tr-hero-meta-item">
          <span class="tr-hero-meta-label">Expositor</span>
          <span class="tr-hero-meta-value">{{ $training->speaker_name }}</span>
        </div>
        <div class="tr-hero-meta-item">
          <span class="tr-hero-meta-label">Especialidad</span>
          <span class="tr-hero-meta-value">{{ $training->speaker_title }}</span>
        </div>
        <div class="tr-hero-meta-item">
          <span class="tr-hero-meta-label">Evaluación</span>
          <span class="tr-hero-meta-value">{{ $training->time_limit_minutes }} min · {{ $training->questions()->count() }} preguntas</span>
        </div>
      </div>
    </div>
  </section>

  <div class="wrap tr-body">

    <div class="tr-main">
      <div class="tr-card">
        <h2 class="tr-card-title">Sobre el taller</h2>
        <p class="tr-intro">{{ $training->intro }}</p>
      </div>

      <div class="tr-card">
        <h2 class="tr-card-title">Material de apoyo</h2>
        <p class="tr-card-sub">Descargue los documentos de la sesión para repasar antes o después de la evaluación.</p>
        <div class="tr-materials">
          @foreach($training->materials as $material)
            <a href="{{ asset('storage/'.$material->file_path) }}" class="tr-material-card" download target="_blank" rel="noopener">
              <span class="tr-material-icon tr-material-icon-{{ $material->file_type }}">
                @if($material->file_type === 'pdf')
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/></svg>
                @elseif($material->file_type === 'docx')
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8M8 17h5"/></svg>
                @else
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="4" width="18" height="13" rx="1.5"/><path d="M8 21h8M12 17v4"/></svg>
                @endif
              </span>
              <span class="tr-material-body">
                <span class="tr-material-label">{{ $material->label }}</span>
                <span class="tr-material-type">{{ strtoupper($material->file_type) }} · Descargar</span>
              </span>
            </a>
          @endforeach
        </div>
      </div>

      <div class="tr-card tr-card-glossary">
        <div class="tr-glossary-row">
          <div>
            <h2 class="tr-card-title">Glosario visual</h2>
            <p class="tr-card-sub">Términos clave de IIF, ROS/RO, prueba indiciaria y activos virtuales, con ejemplos prácticos.</p>
          </div>
          <button type="button" class="tr-btn tr-btn-outline" onclick="trOpenGlossary()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
            Abrir glosario
          </button>
        </div>
      </div>
    </div>

    <aside class="tr-side">
      <div class="tr-cta-card">
        <div class="tr-cta-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M3.5 10h17"/><path d="M8 3v4M16 3v4"/></svg>
        </div>
        <h3>Evaluación final</h3>
        <p>{{ $training->questions()->count() }} preguntas de opción múltiple sobre el caso, el marco normativo y los activos virtuales. Tiempo máximo: <strong>{{ $training->time_limit_minutes }} minutos</strong>.</p>
        <p class="tr-cta-note">Se le pedirá su nombre completo y cargo (Juez, Fiscal u Otro). Su nota quedará registrada.</p>
        <a href="{{ route('capacitacion.identify', $training) }}" class="tr-btn tr-btn-solid tr-btn-block">Iniciar evaluación →</a>
      </div>
    </aside>

  </div>
</div>

<div class="tr-glossary-overlay" id="trGlossaryOverlay" onclick="if(event.target===this) trCloseGlossary()">
  <div class="tr-glossary-modal">
    <div class="tr-glossary-header">
      <h3>Glosario visual</h3>
      <button type="button" class="tr-glossary-close" onclick="trCloseGlossary()" aria-label="Cerrar">&times;</button>
    </div>
    <div class="tr-glossary-search">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
      <input type="text" id="trGlossarySearch" placeholder="Buscar término (p. ej. ROS, blockchain, decomiso)..." oninput="trFilterGlossary()" autocomplete="off">
    </div>
    <div class="tr-glossary-list" id="trGlossaryList">
      @foreach($training->glossaryTerms as $term)
        <div class="tr-glossary-item" data-search="{{ \Illuminate\Support\Str::lower($term->term.' '.$term->definition) }}">
          <h4>{{ $term->term }}</h4>
          <p>{{ $term->definition }}</p>
          @if($term->example)
            <p class="tr-glossary-example"><strong>Ejemplo:</strong> {{ $term->example }}</p>
          @endif
        </div>
      @endforeach
      <div class="tr-glossary-empty" id="trGlossaryEmpty" style="display:none;">No se encontraron términos para su búsqueda.</div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function trOpenGlossary() {
  document.getElementById('trGlossaryOverlay').classList.add('active');
  document.body.style.overflow = 'hidden';
  window.setTimeout(() => document.getElementById('trGlossarySearch').focus(), 50);
}
function trCloseGlossary() {
  document.getElementById('trGlossaryOverlay').classList.remove('active');
  document.body.style.overflow = '';
}
function trFilterGlossary() {
  const q = document.getElementById('trGlossarySearch').value.trim().toLowerCase();
  const items = document.querySelectorAll('.tr-glossary-item');
  let visible = 0;
  items.forEach(item => {
    const match = !q || item.dataset.search.includes(q);
    item.style.display = match ? '' : 'none';
    if (match) visible++;
  });
  document.getElementById('trGlossaryEmpty').style.display = visible === 0 ? 'block' : 'none';
}
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') trCloseGlossary();
});
</script>
@endsection
