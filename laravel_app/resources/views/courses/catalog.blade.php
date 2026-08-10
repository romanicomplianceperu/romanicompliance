@extends('layouts.app')

@section('title', 'Cursos — Romani Compliance')

@section('styles')
.catalog-hero { background: var(--ink); padding: 3.5rem 0; position: relative; }
.catalog-hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
.catalog-hero h1 { font-size: clamp(1.6rem, 3.5vw, 2.2rem); color: var(--white); font-weight: 400; }
.catalog-hero p { font-size: 0.88rem; color: rgba(255,255,255,0.45); margin-top: 0.5rem; }

.catalog-section { padding: 3.5rem 0; }
.filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 2rem; }
.filter-tabs a { font-size: 0.78rem; font-weight: 600; padding: 8px 16px; border-radius: 20px; border: 1px solid var(--line); color: var(--slate); }
.filter-tabs a.active, .filter-tabs a:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-pale); }

.course-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.course-card { background: var(--white); border: 1px solid var(--line); border-radius: 6px; overflow: hidden; transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s; display: block; }
.course-card:hover { box-shadow: var(--shadow-m); transform: translateY(-4px); border-color: var(--gold); }
.course-cover { aspect-ratio: 16 / 9; background: var(--ink); position: relative; overflow: hidden; }
.course-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
.course-badge { position: absolute; top: 10px; right: 10px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 20px; background: var(--gold); color: var(--white); }
.course-body { padding: 1.4rem; }
.course-category { font-size: 0.68rem; color: var(--gold); font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
.course-body h4 { font-size: 1.05rem; margin-bottom: 0.5rem; }
.course-meta { font-size: 0.78rem; color: var(--slate-light); margin-top: 0.8rem; }

@media (max-width: 900px) { .course-grid { grid-template-columns: 1fr; } }
@endsection

@section('content')
<section class="catalog-hero">
  <div class="wrap">
    <h1>Catálogo de cursos</h1>
    <p>Explora nuestros programas de capacitación e inscríbete cuando quieras.</p>
  </div>
</section>

<section class="catalog-section">
  <div class="wrap">
    <div class="filter-tabs">
      <a href="{{ route('courses.catalog') }}" class="{{ request('categoria') ? '' : 'active' }}">Todos</a>
      @foreach($categories as $cat)
        <a href="{{ route('courses.catalog', ['categoria' => $cat->slug]) }}" class="{{ request('categoria') === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
      @endforeach
    </div>

    @if($courses->isEmpty())
      <div class="empty-state" style="text-align:center;padding:3rem;color:var(--slate);border:1px dashed var(--line);border-radius:6px;">Todavía no hay cursos publicados en esta categoría.</div>
    @else
      <div class="course-grid">
        @foreach($courses as $course)
          <a href="{{ route('courses.show', $course) }}" class="course-card">
            <div class="course-cover">
              @if($course->cover_image)
                <img src="{{ asset('storage/'.$course->cover_image) }}" alt="{{ $course->title }}">
              @endif
              @if($enrolledCourseIds->contains($course->id))
                <span class="course-badge">Inscrito</span>
              @endif
            </div>
            <div class="course-body">
              @if($course->category)
                <div class="course-category">{{ $course->category->name }}</div>
              @endif
              <h4>{{ $course->title }}</h4>
              <div style="margin-bottom:0.6rem;">@include('courses._certificate-badge')</div>
              <div class="course-meta">
                @if($course->instructor_name) {{ $course->instructor_name }} @endif
                @if($course->duration_minutes) · {{ $course->lectiveHours() }} {{ $course->lectiveHours() === 1 ? 'hora' : 'horas' }} @endif
              </div>
            </div>
          </a>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection
