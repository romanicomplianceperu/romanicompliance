<div class="ac-campus-header">
  <div class="wrap ac-campus-header-row">
    <div class="ac-campus-brand">
      <img src="{{ $university->logo_url }}" alt="Logo {{ $university->short_name }}" style="height:24px;width:auto;">
      Espacio Académico <span class="tag">{{ $university->short_name }}</span>
    </div>
    <div class="ac-campus-nav">
      <a href="{{ route('academico.university', $university->slug) }}">Inicio</a>
      <a href="{{ route('courses.catalog') }}">Cursos</a>
      <a href="{{ route('academico.index') }}">Salir del espacio académico</a>
    </div>
  </div>
</div>

<div class="ac-course-header">
  <div class="wrap">
    <div class="ac-crumbs">
      <a href="{{ route('academico.index') }}">Académico</a>
      <span class="sep">›</span>
      <a href="{{ route('academico.university', $university->slug) }}">{{ $university->short_name }}</a>
      <span class="sep">›</span>
      @if(!empty($acCrumbExtra))
        <a href="{{ route('academico.course', [$university->slug, $course->slug]) }}">{{ $course->name }}</a>
        <span class="sep">›</span>
        <span class="current">{{ $acCrumbExtra }}</span>
      @else
        <span class="current">{{ $course->name }}</span>
      @endif
    </div>
    <h1>{{ $course->name }}</h1>
    <div class="sub">{{ $course->subtitle }}</div>
    <div class="ac-course-meta">
      <span>{{ $university->name }}</span>
      @if($course->period)<span>{{ $course->period }}</span>@endif
    </div>
  </div>
</div>
