@extends('layouts.app')

@section('title', $project->name.' — '.$project->company->name.' — Romani Compliance')
@section('description', $project->description ?: $project->service)

@section('styles')
.proj-hero { background: var(--ink); padding: 4rem 0 3.5rem; position: relative; }
.proj-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
.proj-hero-tag { font-size: 0.72rem; color: var(--gold-light); font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.8rem; }
.proj-hero h1 { font-size: clamp(1.8rem, 4vw, 2.6rem); color: var(--white); font-weight: 500; margin-bottom: 1rem; max-width: 720px; }
.proj-hero p { font-size: 0.95rem; color: rgba(255,255,255,0.55); max-width: 620px; line-height: 1.7; margin-bottom: 1.8rem; }
.proj-meta-row { display: flex; gap: 2rem; flex-wrap: wrap; margin-bottom: 2rem; }
.proj-meta-item .k { font-size: 0.68rem; color: var(--gold-light); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
.proj-meta-item .v { font-size: 0.95rem; color: var(--white); font-weight: 500; }

.proj-modules { padding: 3.5rem 0; }
.proj-module-card { border: 1px solid var(--line); border-radius: 8px; padding: 1.6rem 1.8rem; margin-bottom: 1.2rem; background: var(--white); }
.proj-module-card .num { font-family: var(--serif); font-size: 1.6rem; color: var(--gold); font-weight: 500; }
.proj-module-card h3 { font-size: 1.15rem; margin: 0.3rem 0 0.8rem; }
.proj-lesson-tag { display: inline-block; font-size: 0.76rem; color: var(--slate); padding: 3px 0; }

.proj-cta-band { background: var(--gold-pale); border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); padding: 2.8rem 0; text-align: center; }
.proj-cta-band p { color: var(--slate); font-size: 0.9rem; margin-bottom: 1.2rem; }

.proj-commercial { padding: 3rem 0; }
.proj-commercial .card-box { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 1.8rem 2rem; white-space: pre-line; font-size: 0.9rem; color: var(--slate); line-height: 1.7; }
@endsection

@section('content')
<section class="proj-hero">
  <div class="wrap">
    <div class="proj-hero-tag">Capacitación empresarial &middot; {{ $project->company->name }}</div>
    <h1>{{ $project->name }}</h1>
    @if($project->description)
      <p>{{ $project->description }}</p>
    @endif
    <div class="proj-meta-row">
      @if($project->modality)
        <div class="proj-meta-item"><div class="k">Modalidad</div><div class="v">{{ $project->modality }}</div></div>
      @endif
      @if($project->duration_hours)
        <div class="proj-meta-item"><div class="k">Duración</div><div class="v">{{ rtrim(rtrim(number_format($project->duration_hours, 1), '0'), '.') }} horas</div></div>
      @endif
      <div class="proj-meta-item"><div class="k">Certificación</div><div class="v">Gratuita y verificable por QR</div></div>
    </div>
    <a href="{{ route('courses.show', $project->course) }}" class="btn btn-gold">Iniciar curso</a>
  </div>
</section>

<section class="proj-modules">
  <div class="wrap">
    <div class="section-header">
      <div class="gold-line"></div>
      <h2>Temario</h2>
      <p>Contenido del programa preparado para {{ $project->company->name }}.</p>
    </div>

    @forelse($project->course->modules as $module)
      <div class="proj-module-card">
        <div class="num">{{ sprintf('%02d', $loop->iteration) }}</div>
        <h3>{{ $module->title }}</h3>
        @forelse($module->lessons as $lesson)
          <div class="proj-lesson-tag">&middot; {{ $lesson->title }}</div>
        @empty
          <div class="proj-lesson-tag" style="color:var(--slate-light);">Contenido en preparación.</div>
        @endforelse
      </div>
    @empty
      <div class="empty-state" style="text-align:center;padding:2rem;color:var(--slate);border:1px dashed var(--line);border-radius:6px;">El temario se publicará próximamente.</div>
    @endforelse
  </div>
</section>

<section class="proj-cta-band">
  <div class="wrap">
    <p>Accede al curso completo, avanza a tu propio ritmo y obtén tu certificado verificable al finalizar.</p>
    <a href="{{ route('courses.show', $project->course) }}" class="btn btn-gold">Iniciar curso</a>
  </div>
</section>

@if($project->commercial_info)
<section class="proj-commercial">
  <div class="wrap">
    <div class="section-header">
      <div class="gold-line"></div>
      <h2>Información del servicio</h2>
    </div>
    <div class="card-box">{{ $project->commercial_info }}</div>
  </div>
</section>
@endif
@endsection
