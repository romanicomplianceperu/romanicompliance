<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: DejaVu Sans, sans-serif; color: #16233a; font-size: 12px; line-height: 1.6; }
  .tag { display: inline-block; font-size: 9px; text-transform: uppercase; letter-spacing: 0.05em; color: #8B7340; border: 1px solid #B89A56; border-radius: 10px; padding: 3px 9px; margin: 0 6px 6px 0; }
  h1 { font-size: 19px; margin: 14px 0 4px; }
  h2 { font-size: 13px; margin: 18px 0 6px; color: #8B7340; text-transform: uppercase; letter-spacing: 0.04em; }
  p { margin: 0 0 10px; text-align: justify; }
  ul { margin: 0 0 10px; padding-left: 18px; }
  li { margin-bottom: 4px; }
  .meta { font-size: 10px; color: #566; margin-bottom: 14px; }
  .question { margin-bottom: 10px; padding: 8px 10px; border: 1px solid #ddd; border-radius: 6px; }
  .question .num { font-size: 9px; text-transform: uppercase; color: #8B7340; font-weight: bold; }
  .footer { margin-top: 24px; font-size: 9px; color: #999; border-top: 1px solid #ddd; padding-top: 8px; }
</style>
</head>
<body>
  <div>
    <span class="tag">{{ $university->short_name }}</span>
    <span class="tag">{{ $course->name }}</span>
    <span class="tag">Semana {{ $activity->week_number }}</span>
  </div>

  <h1>{{ $activity->case_title ?? $activity->title }}</h1>
  <div class="meta">
    @if($activity->unit) {{ $activity->unit }} — @endif
    @if($activity->modality) {{ $activity->modality }} @endif
    @if($activity->due_at) — Fecha límite: {{ $activity->due_at->timezone('America/Lima')->translatedFormat('d \d\e F, H:i') }} h @endif
  </div>

  @foreach($activity->caseBodySections() as $section)
    @if($section['heading'])
      <h2>{{ $section['heading'] }}</h2>
      <ul>
        @foreach($section['items'] as $item)
          <li>{{ $item }}</li>
        @endforeach
      </ul>
    @else
      @foreach($section['items'] as $item)
        <p>{{ $item }}</p>
      @endforeach
    @endif
  @endforeach

  @if($activity->questions->count() > 0)
    <h2>Preguntas de participación</h2>
    @foreach($activity->questions as $i => $question)
      <div class="question">
        <div class="num">Pregunta {{ $i + 1 }}</div>
        {{ $question->prompt }}
      </div>
    @endforeach
  @endif

  <div class="footer">Descargado de romanicompliance.com — Espacio Académico. Documento de referencia para trabajo en clase.</div>
</body>
</html>
