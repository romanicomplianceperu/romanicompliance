@extends('admin.layout')

@section('title', $course->exists ? 'Editar curso' : 'Nuevo curso')

@section('styles')
.cover-preview { width: 220px; aspect-ratio: 16 / 9; object-fit: cover; border-radius: var(--radius); border: 1px solid var(--line); margin-bottom: 10px; display: block; }
.module-block { border: 1px solid var(--line); border-radius: 6px; padding: 1.2rem; margin-bottom: 1rem; background: var(--ivory); }
.module-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.8rem; flex-wrap: wrap; gap: 0.6rem; }
.module-head h3 { font-size: 1.05rem; }
.lesson-row { display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: var(--white); border: 1px solid var(--line); border-radius: var(--radius); margin-bottom: 6px; font-size: 0.85rem; flex-wrap: wrap; gap: 6px; }
.lesson-type { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; color: var(--gold); background: var(--gold-pale); padding: 2px 8px; border-radius: 10px; margin-left: 8px; }
.inline-form { display: flex; gap: 8px; align-items: flex-end; flex-wrap: wrap; }
.inline-form .form-group { margin-bottom: 0; flex: 1; min-width: 140px; }
details.add-panel { margin-top: 0.8rem; }
details.add-panel summary { cursor: pointer; font-size: 0.8rem; font-weight: 600; color: var(--gold); }
details.add-panel .add-panel-body { margin-top: 0.8rem; padding: 1rem; background: var(--white); border: 1px dashed var(--line); border-radius: var(--radius); }
@endsection

@section('content')
<div class="card">
  <form action="{{ $course->exists ? route('admin.courses.update', $course) : route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($course->exists) @method('PUT') @endif

    <div class="form-row">
      <div class="form-group">
        <label>Título del curso</label>
        <input type="text" name="title" value="{{ old('title', $course->title) }}" required>
      </div>
      <div class="form-group">
        <label>Categoría</label>
        <select name="category_id">
          <option value="">Sin categoría</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected(old('category_id', $course->category_id) == $cat->id)>{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group">
      <label>Descripción</label>
      <textarea name="description">{{ old('description', $course->description) }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Instructor</label>
        <select name="instructor_id">
          <option value="">Sin instructor asignado</option>
          @foreach($instructors as $member)
            <option value="{{ $member->id }}" @selected(old('instructor_id', $course->instructor_id) == $member->id)>{{ $member->name }}</option>
          @endforeach
        </select>
        <div class="form-hint">Se muestra en la página del curso, enlazado a su perfil en Equipo.</div>
      </div>
      <div class="form-group">
        <label>Duración (horas)</label>
        <input type="number" step="0.5" min="0" name="duration_hours" value="{{ old('duration_hours', $course->duration_minutes ? rtrim(rtrim(number_format($course->duration_minutes / 60, 1), '0'), '.') : '') }}">
        <div class="form-hint">Horas lectivas totales del curso. Se muestra también en el certificado.</div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Certificación</label>
        <select name="certificate_type" id="certificateType" onchange="togglePriceField(this)" required>
          <option value="gratuita" @selected(old('certificate_type', $course->certificate_type ?? 'gratuita') === 'gratuita')>Certificación gratuita</option>
          <option value="opcional" @selected(old('certificate_type', $course->certificate_type ?? 'gratuita') === 'opcional')>Certificación opcional</option>
        </select>
        <div class="form-hint">Se muestra como etiqueta visible en el catálogo del curso.</div>
      </div>
      <div class="form-group" id="priceField" style="{{ old('certificate_type', $course->certificate_type ?? 'gratuita') === 'opcional' ? '' : 'display:none' }}">
        <label>Precio de la certificación (S/)</label>
        <input type="number" step="0.01" min="0" name="certificate_price" value="{{ old('certificate_price', $course->certificate_price) }}">
        <div class="form-hint">Se muestra al alumno junto al botón de compra por WhatsApp.</div>
      </div>
    </div>

    <div class="form-group">
      <label>Portada</label>
      @if($course->cover_image)
        <img src="{{ asset('storage/'.$course->cover_image) }}" class="cover-preview" alt="Portada actual">
      @endif
      <input type="file" name="cover_image" accept="image/*">
      <div class="form-hint">Imagen JPG/PNG, máx. 2MB. Recomendado: horizontal, relación 16:9 (ej. 1200×675px) para que se vea completa en todas las secciones.</div>
    </div>

    <div class="form-group form-check">
      <input type="checkbox" name="is_published" id="is_published" value="1" @checked(old('is_published', $course->is_published))>
      <label for="is_published" style="margin-bottom:0;text-transform:none;font-weight:500;">Publicar curso (visible para alumnos)</label>
    </div>

    <button type="submit" class="btn btn-gold">{{ $course->exists ? 'Guardar cambios' : 'Crear curso' }}</button>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline">Cancelar</a>
  </form>
</div>

@if($course->exists)
<div class="card">
  <div class="page-head">
    <h2 style="font-size:1.15rem">Contenido del curso</h2>
  </div>

  @forelse($course->modules as $module)
    <div class="module-block">
      <div class="module-head">
        <h3>{{ $module->title }}</h3>
        <div>
          <form action="{{ route('admin.modules.destroy', $module) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este módulo y sus lecciones?');">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Eliminar módulo</button>
          </form>
        </div>
      </div>

      @forelse($module->lessons as $lesson)
        <details class="add-panel" style="margin-bottom:6px;">
          <summary style="list-style:none;cursor:pointer;">
            <div class="lesson-row" style="margin-bottom:0;">
              <span>{{ $lesson->title }} <span class="lesson-type">{{ $lesson->typeLabel() }}</span></span>
              <span class="form-hint" style="text-transform:none;">Editar ▾</span>
            </div>
          </summary>
          <div class="add-panel-body">
            <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data">
              @csrf @method('PUT')
              <div class="form-row">
                <div class="form-group">
                  <label>Título</label>
                  <input type="text" name="title" value="{{ $lesson->title }}" required>
                </div>
                <div class="form-group">
                  <label>Tipo</label>
                  <select name="type" onchange="toggleLessonFields(this)">
                    <option value="text" @selected($lesson->type === 'text')>Contenido teórico</option>
                    <option value="video" @selected($lesson->type === 'video')>Video</option>
                    <option value="pdf" @selected($lesson->type === 'pdf')>Documento PDF</option>
                    <option value="file" @selected($lesson->type === 'file')>Diapositiva</option>
                  </select>
                </div>
              </div>
              <div class="form-group lf-video" style="display:{{ $lesson->type === 'video' ? 'block' : 'none' }}">
                <label>URL del video (YouTube, Vimeo, etc.)</label>
                <input type="url" name="video_url" value="{{ $lesson->video_url }}" placeholder="https://...">
              </div>
              <div class="form-group lf-file" style="display:{{ in_array($lesson->type, ['pdf', 'file']) ? 'block' : 'none' }}">
                <label>Archivo (PDF o diapositiva)</label>
                @if($lesson->file_path)
                  <div class="form-hint">Archivo actual: <a href="{{ asset('storage/'.$lesson->file_path) }}" target="_blank">ver</a></div>
                @endif
                <input type="file" name="upload">
              </div>
              <div class="form-group lf-text" style="display:{{ $lesson->type === 'text' ? 'block' : 'none' }}">
                <label>Contenido</label>
                <textarea name="content">{{ $lesson->content }}</textarea>
              </div>
              <div class="form-group">
                <label>Duración (minutos)</label>
                <input type="number" name="duration_minutes" min="0" value="{{ $lesson->duration_minutes }}" style="max-width:140px">
              </div>
              <button type="submit" class="btn btn-gold btn-sm">Guardar cambios</button>
            </form>
            <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" onsubmit="return confirm('¿Eliminar esta lección?');" style="margin-top:8px;">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Eliminar lección</button>
            </form>
          </div>
        </details>
      @empty
        <p class="form-hint">Sin lecciones todavía.</p>
      @endforelse

      <details class="add-panel">
        <summary>+ Agregar lección</summary>
        <div class="add-panel-body">
          <form action="{{ route('admin.lessons.store', $module) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
              <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" required>
              </div>
              <div class="form-group">
                <label>Tipo</label>
                <select name="type" onchange="toggleLessonFields(this)">
                  <option value="text">Contenido teórico</option>
                  <option value="video">Video</option>
                  <option value="pdf">Documento PDF</option>
                  <option value="file">Diapositiva</option>
                </select>
              </div>
            </div>
            <div class="form-group lf-video" style="display:none">
              <label>URL del video (YouTube, Vimeo, etc.)</label>
              <input type="url" name="video_url" placeholder="https://...">
            </div>
            <div class="form-group lf-file" style="display:none">
              <label>Archivo (PDF o diapositiva)</label>
              <input type="file" name="upload">
            </div>
            <div class="form-group lf-text">
              <label>Contenido</label>
              <textarea name="content"></textarea>
            </div>
            <div class="form-group">
              <label>Duración (minutos)</label>
              <input type="number" name="duration_minutes" min="0" style="max-width:140px">
            </div>
            <button type="submit" class="btn btn-gold btn-sm">Agregar lección</button>
          </form>
        </div>
      </details>
    </div>
  @empty
    <div class="empty-state">Todavía no has agregado módulos a este curso.</div>
  @endforelse

  <details class="add-panel">
    <summary>+ Agregar módulo</summary>
    <div class="add-panel-body">
      <form action="{{ route('admin.modules.store', $course) }}" method="POST" class="inline-form">
        @csrf
        <div class="form-group">
          <label>Título del módulo</label>
          <input type="text" name="title" required>
        </div>
        <button type="submit" class="btn btn-gold btn-sm">Agregar</button>
      </form>
    </div>
  </details>
</div>

<div class="card">
  <div class="page-head">
    <h2 style="font-size:1.15rem">Examen</h2>
  </div>

  <form action="{{ route('admin.exams.store', $course) }}" method="POST" class="form-row" style="align-items:end;margin-bottom:1.5rem;">
    @csrf
    <div class="form-group">
      <label>Título del examen</label>
      <input type="text" name="title" value="{{ old('title', $course->exam->title ?? 'Examen final de '.$course->title) }}" required>
    </div>
    <div class="form-group">
      <label>Nota mínima (%)</label>
      <input type="number" name="passing_score" min="1" max="100" value="{{ old('passing_score', $course->exam->passing_score ?? 70) }}" required>
    </div>
    <div class="form-group">
      <label>Intentos máximos</label>
      <input type="number" name="max_attempts" min="1" max="20" value="{{ old('max_attempts', $course->exam->max_attempts ?? 3) }}" required>
    </div>
    <div class="form-group">
      <label>Tiempo límite (min)</label>
      <input type="number" name="time_limit_minutes" min="1" value="{{ old('time_limit_minutes', $course->exam->time_limit_minutes ?? '') }}">
    </div>
    <div class="form-group" style="flex:0">
      <button type="submit" class="btn btn-gold">{{ $course->exam ? 'Guardar' : 'Crear examen' }}</button>
    </div>
  </form>

  @if($course->exam)
    @forelse($course->exam->questions as $question)
      <div class="module-block">
        <div class="module-head">
          <h3 style="font-size:0.92rem">{{ $loop->iteration }}. {{ $question->question_text }}</h3>
          <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('¿Eliminar esta pregunta?');">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
          </form>
        </div>
        <ul style="list-style:none;font-size:0.82rem;">
          @foreach($question->options as $option)
            <li style="padding:4px 0;{{ $option->is_correct ? 'color:#1F7A4D;font-weight:600;' : 'color:var(--slate);' }}">
              {{ $option->is_correct ? '✓' : '—' }} {{ $option->option_text }}
            </li>
          @endforeach
        </ul>
      </div>
    @empty
      <div class="empty-state">Este examen todavía no tiene preguntas.</div>
    @endforelse

    <details class="add-panel">
      <summary>+ Agregar pregunta</summary>
      <div class="add-panel-body">
        <form action="{{ route('admin.questions.store', $course->exam) }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Pregunta</label>
            <textarea name="question_text" required></textarea>
          </div>
          @foreach(range(0, 3) as $i)
            <div class="form-group" style="display:flex;align-items:center;gap:10px;">
              <input type="radio" name="correct" value="{{ $i }}" {{ $i === 0 ? 'required' : '' }} style="width:auto;">
              <input type="text" name="options[]" placeholder="Opción {{ $i + 1 }}{{ $i < 2 ? ' (obligatoria)' : ' (opcional)' }}" {{ $i < 2 ? 'required' : '' }} style="flex:1;padding:10px 12px;border:1px solid var(--line);border-radius:4px;">
            </div>
          @endforeach
          <div class="form-hint" style="margin-bottom:0.8rem;">Marca con el círculo cuál opción es la correcta.</div>
          <button type="submit" class="btn btn-gold btn-sm">Agregar pregunta</button>
        </form>
      </div>
    </details>
  @else
    <div class="empty-state">Primero crea el examen para poder agregar preguntas.</div>
  @endif
</div>
@endif
@endsection

@section('scripts')
<script>
function togglePriceField(select) {
  document.getElementById('priceField').style.display = select.value === 'opcional' ? 'block' : 'none';
}
function toggleLessonFields(select) {
  const row = select.closest('form');
  row.querySelector('.lf-video').style.display = select.value === 'video' ? 'block' : 'none';
  row.querySelector('.lf-file').style.display = (select.value === 'pdf' || select.value === 'file') ? 'block' : 'none';
  row.querySelector('.lf-text').style.display = select.value === 'text' ? 'block' : 'none';
}
</script>
@endsection
