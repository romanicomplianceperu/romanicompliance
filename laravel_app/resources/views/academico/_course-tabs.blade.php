@php
  $acTabs = [
    ['key' => 'inicio', 'label' => 'Inicio', 'route' => route('academico.course', [$university->slug, $course->slug])],
    ['key' => 'participacion', 'label' => 'Participación', 'route' => route('academico.participacion.index', [$university->slug, $course->slug])],
    ['key' => 'tareas', 'label' => 'Tareas', 'route' => null],
    ['key' => 'cuestionarios', 'label' => 'Cuestionarios', 'route' => null],
    ['key' => 'materiales', 'label' => 'Materiales', 'route' => null],
    ['key' => 'calificaciones', 'label' => 'Calificaciones', 'route' => null],
  ];
@endphp
<div class="ac-tabs-wrap">
  <div class="ac-tabs">
    @foreach($acTabs as $t)
      @if($t['route'])
        <a href="{{ $t['route'] }}" class="ac-tab {{ ($acActiveTab ?? '') === $t['key'] ? 'active' : '' }}">{{ $t['label'] }}</a>
      @else
        <span class="ac-tab disabled">{{ $t['label'] }} <span class="soon-dot"></span></span>
      @endif
    @endforeach
  </div>
</div>
<div class="ac-mobile-nav">
  @foreach($acTabs as $t)
    @if($t['route'])
      <a href="{{ $t['route'] }}" class="{{ ($acActiveTab ?? '') === $t['key'] ? 'active' : '' }}">{{ $t['label'] }}</a>
    @else
      <span>{{ $t['label'] }}</span>
    @endif
  @endforeach
</div>
