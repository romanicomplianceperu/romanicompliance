@extends('layouts.panel')

@section('title', 'Mis cursos')

@section('styles')
.enroll-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.enroll-card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; overflow: hidden; transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s; }
.enroll-card:hover { box-shadow: var(--shadow-m); transform: translateY(-3px); border-color: var(--gold); }
.enroll-cover { aspect-ratio: 16 / 9; background: var(--ink); position: relative; overflow: hidden; }
.enroll-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
.enroll-body { padding: 1.3rem; }
.enroll-category { display: inline-block; font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; background: var(--gold-pale); color: var(--gold); padding: 4px 10px; border-radius: 20px; margin-bottom: 0.7rem; }
.enroll-body h4 { font-size: 1rem; margin-bottom: 0.4rem; line-height: 1.35; }
.enroll-modality { font-size: 0.76rem; color: var(--slate-light); margin-bottom: 1rem; }
.progress-track { background: var(--ivory-dim); border-radius: 20px; height: 7px; overflow: hidden; margin-bottom: 0.4rem; }
.progress-fill { background: var(--gold); height: 100%; }
.progress-label { font-size: 0.7rem; color: var(--slate); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 1rem; }
.btn-continue { display: block; text-align: center; padding: 10px; background: var(--gold); color: var(--white); border-radius: var(--radius); font-size: 0.8rem; font-weight: 600; }
.btn-continue:hover { background: var(--gold-light); }
@media (max-width: 900px) { .enroll-grid { grid-template-columns: 1fr; } }
@endsection

@section('content')
@foreach($certificateNotices as $notice)
  @include('courses._certificate-payment-banner', ['course' => $notice['course'], 'stage' => $notice['stage'], 'enrollment' => $notice['course']->enrollmentFor(auth()->user())])
@endforeach

<div class="panel-page-head">
  <p style="color:var(--slate);font-size:0.9rem;">Tienes {{ $enrollments->count() }} {{ $enrollments->count() === 1 ? 'curso' : 'cursos' }} en total.</p>
  <a href="{{ route('courses.catalog') }}" class="btn btn-outline">Ver catálogo</a>
</div>

@if($enrollments->isEmpty())
  <div class="empty-state">Todavía no estás inscrito en ningún curso. <a href="{{ route('courses.catalog') }}" style="color:var(--gold);font-weight:600;">Explora el catálogo</a> para comenzar.</div>
@else
  <div class="enroll-grid">
    @foreach($enrollments as $enrollment)
      @php $course = $enrollment->course; @endphp
      <div class="enroll-card">
        <div class="enroll-cover">
          @if($course->cover_image)
            <img src="{{ asset('storage/'.$course->cover_image) }}" alt="{{ $course->title }}">
          @endif
        </div>
        <div class="enroll-body">
          @if($course->category)<span class="enroll-category">{{ $course->category->name }}</span>@endif
          <h4>{{ $course->title }}</h4>
          <div class="enroll-modality">Modalidad virtual</div>
          <div class="progress-track"><div class="progress-fill" style="width:{{ $enrollment->progress_percent }}%"></div></div>
          <div class="progress-label">{{ $enrollment->progress_percent }}% completado</div>
          @php $next = $course->nextLessonFor(auth()->user()); @endphp
          @if($next)
            <a href="{{ route('lessons.show', $next) }}" class="btn-continue">{{ $enrollment->progress_percent > 0 ? 'Continuar' : 'Comenzar' }}</a>
          @else
            <a href="{{ route('courses.show', $course) }}" class="btn-continue">Ver curso</a>
          @endif
        </div>
      </div>
    @endforeach
  </div>
@endif
@endsection
