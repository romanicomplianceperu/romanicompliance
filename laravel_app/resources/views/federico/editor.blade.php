@extends('layouts.app')

@section('title', 'Nuevo artículo — RomaniCompliance')

@section('styles')
.fc-shell { background: var(--ivory); min-height: calc(100vh - 71px); padding: 2.5rem 0 5rem; }
.fc-topbar { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 1.6rem; flex-wrap: wrap; }
.fc-eyebrow { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--gold); margin-bottom: 0.4rem; }
.fc-topbar h1 { font-size: 1.6rem; color: var(--ink); font-weight: 600; }
.fc-topbar-actions { display: flex; gap: 10px; align-items: center; }
.fc-link-btn { display: inline-flex; align-items: center; padding: 10px 18px; border-radius: 8px; font-size: 0.82rem; font-weight: 600; background: var(--ink); color: var(--white); border: none; cursor: pointer; text-decoration: none; transition: background 0.2s; }
.fc-link-btn:hover { background: var(--ink-light); }
.fc-link-btn-ghost { background: transparent; color: var(--slate); border: 1px solid var(--line); }
.fc-link-btn-ghost:hover { background: var(--white); color: var(--ink); }

.fc-alert { border-radius: 8px; padding: 12px 16px; font-size: 0.85rem; margin-bottom: 1.4rem; }
.fc-alert-success { background: rgba(58,125,68,0.08); border: 1px solid rgba(58,125,68,0.25); color: #2E6B3E; }
.fc-alert-error { background: rgba(179,65,59,0.08); border: 1px solid rgba(179,65,59,0.25); color: #B3413B; }
.fc-alert-error div + div { margin-top: 4px; }

.fc-layout { display: grid; grid-template-columns: 2.4fr 1fr; gap: 1.8rem; align-items: start; }
.fc-card { background: var(--white); border: 1px solid var(--line); border-radius: 12px; padding: 1.8rem; }
.fc-field { margin-bottom: 1.4rem; }
.fc-field label { display: block; font-size: 0.78rem; font-weight: 700; color: var(--ink); margin-bottom: 6px; }
.fc-field label span { font-weight: 400; color: var(--slate-light); text-transform: none; letter-spacing: 0; }
.fc-field input[type="text"], .fc-field textarea { width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1px solid var(--line); border-radius: 8px; font-family: var(--sans); font-size: 0.92rem; color: var(--ink); transition: border-color 0.2s; }
.fc-field input[type="text"]:focus, .fc-field textarea:focus { outline: none; border-color: var(--gold); }
.fc-field textarea { resize: vertical; }
.fc-field input[type="file"] { font-size: 0.84rem; }
.fc-cover-preview { display: block; margin-top: 10px; max-width: 100%; max-height: 220px; border-radius: 8px; object-fit: cover; }

#fc-editor { background: var(--white); min-height: 360px; font-size: 0.95rem; }
.ql-toolbar.ql-snow { border-color: var(--line); border-radius: 8px 8px 0 0; background: var(--ivory-dim); }
.ql-container.ql-snow { border-color: var(--line); border-radius: 0 0 8px 8px; }
.ql-editor.ql-blank::before { color: var(--slate-light); font-style: normal; }

.fc-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 1.6rem; flex-wrap: wrap; }
.fc-btn { padding: 12px 22px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; cursor: pointer; border: none; transition: background 0.2s, transform 0.2s; }
.fc-btn-ghost { background: transparent; border: 1px solid var(--line); color: var(--slate); }
.fc-btn-ghost:hover { background: var(--ivory-dim); }
.fc-btn-secondary { background: var(--ivory-dim); color: var(--ink); border: 1px solid var(--line); }
.fc-btn-secondary:hover { background: var(--line); }
.fc-btn-primary { background: var(--gold); color: var(--white); }
.fc-btn-primary:hover { background: var(--gold-light); transform: translateY(-1px); }

.fc-sidebar { background: var(--white); border: 1px solid var(--line); border-radius: 12px; padding: 1.6rem; }
.fc-sidebar h3 { font-size: 0.95rem; color: var(--ink); margin-bottom: 1.1rem; }
.fc-recent-item { padding: 0.9rem 0; border-top: 1px solid var(--line); }
.fc-recent-item:first-of-type { border-top: none; padding-top: 0; }
.fc-recent-title { font-size: 0.86rem; color: var(--ink); font-weight: 600; line-height: 1.4; margin-bottom: 6px; }
.fc-recent-meta { display: flex; align-items: center; gap: 8px; font-size: 0.7rem; color: var(--slate-light); margin-bottom: 6px; }
.fc-badge { font-size: 0.64rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; padding: 3px 9px; border-radius: 20px; }
.fc-badge-published { background: rgba(58,125,68,0.1); color: #2E6B3E; }
.fc-badge-draft { background: var(--gold-pale); color: var(--gold); }
.fc-recent-item a { font-size: 0.78rem; font-weight: 600; color: var(--gold); }
.fc-empty { font-size: 0.82rem; color: var(--slate-light); }

.fc-preview-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gold); margin-bottom: 0.6rem; }
.fc-preview-title { font-size: 1.5rem; color: var(--ink); font-weight: 600; margin-bottom: 1.2rem; line-height: 1.3; }
.fc-preview-cover-wrap img { width: 100%; max-height: 320px; object-fit: cover; border-radius: 8px; margin-bottom: 1.4rem; display: block; }
.fc-preview-body { font-size: 0.95rem; color: var(--ink); line-height: 1.85; max-height: 55vh; overflow-y: auto; }
.fc-preview-body p { margin-bottom: 1.1rem; }
.fc-preview-body h2, .fc-preview-body h3, .fc-preview-body h4 { color: var(--ink); font-weight: 600; margin: 1.6rem 0 0.8rem; }
.fc-preview-body ul, .fc-preview-body ol { margin: 0 0 1.1rem 1.4rem; }
.fc-preview-body blockquote { margin: 1.2rem 0; padding: 0.2rem 1.2rem; border-left: 3px solid var(--gold); color: var(--slate); font-style: italic; }
.fc-preview-body img { max-width: 100%; border-radius: 6px; margin: 1.2rem 0; }
.fc-preview-body a { color: var(--gold); }

@media (max-width: 900px) {
  .fc-layout { grid-template-columns: 1fr; }
}
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset("vendor/quill/quill.snow.css") }}">

<div class="fc-shell">
  <div class="wrap">
    <div class="fc-topbar">
      <div>
        <div class="fc-eyebrow">RomaniCompliance — Redacción</div>
        <h1>Hola, Federico</h1>
      </div>
      <div class="fc-topbar-actions">
        <a href="{{ route('blog.index') }}" target="_blank" class="fc-link-btn fc-link-btn-ghost">Ver blog</a>
        <form method="POST" action="{{ route('federico.logout') }}">
          @csrf
          <button type="submit" class="fc-link-btn fc-link-btn-ghost">Salir</button>
        </form>
      </div>
    </div>

    @if (! $author)
      <div class="fc-alert fc-alert-error">No se encontró la cuenta de Federico Chunga en el sistema, así que aún no podrás publicar. Contacta al administrador del sitio para que la revise.</div>
    @endif

    @if (session('federico_success'))
      <div class="fc-alert fc-alert-success">{{ session('federico_success') }}</div>
    @endif

    @if ($errors->any())
      <div class="fc-alert fc-alert-error">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <div class="fc-layout">
      <div class="fc-card">
        <form method="POST" action="{{ route('federico.store') }}" enctype="multipart/form-data" id="fc-form" novalidate>
          @csrf

          <div class="fc-field">
            <label for="fc-title">Título del artículo</label>
            <input type="text" name="title" id="fc-title" required maxlength="255" value="{{ old('title') }}" placeholder="Escribe un título claro y directo">
          </div>

          <div class="fc-field">
            <label for="fc-excerpt">Extracto <span>(opcional — resumen corto para las vistas previas del blog)</span></label>
            <textarea name="excerpt" id="fc-excerpt" maxlength="500" rows="2" placeholder="Si lo dejas vacío, se genera automáticamente a partir del contenido">{{ old('excerpt') }}</textarea>
          </div>

          <div class="fc-field">
            <label for="fc-cover">Imagen de portada <span>(opcional)</span></label>
            <input type="file" name="cover_image" id="fc-cover" accept="image/*">
            <img id="fc-cover-preview" class="fc-cover-preview" hidden>
          </div>

          <div class="fc-field">
            <label>Contenido</label>
            <div id="fc-editor"></div>
            <textarea name="content" id="fc-content" hidden>{{ old('content') }}</textarea>
          </div>

          <div class="fc-actions">
            <button type="button" class="fc-btn fc-btn-ghost" id="fc-preview-btn">Vista previa</button>
            <button type="submit" name="action" value="draft" class="fc-btn fc-btn-secondary">Guardar borrador</button>
            <button type="submit" name="action" value="publish" class="fc-btn fc-btn-primary">Publicar</button>
          </div>
        </form>
      </div>

      <aside class="fc-sidebar">
        <h3>Tus publicaciones</h3>
        @forelse ($recent as $item)
          <div class="fc-recent-item">
            <div class="fc-recent-title">{{ $item->title }}</div>
            <div class="fc-recent-meta">
              <span class="fc-badge {{ $item->isPublished() ? 'fc-badge-published' : 'fc-badge-draft' }}">{{ $item->isPublished() ? 'Publicado' : 'Borrador' }}</span>
              <span>{{ $item->created_at->format('d/m/Y') }}</span>
            </div>
            @if ($item->isPublished())
              <a href="{{ route('blog.show', $item->slug) }}" target="_blank">Ver artículo →</a>
            @endif
          </div>
        @empty
          <p class="fc-empty">Aún no has publicado nada. Tu primer artículo aparecerá aquí.</p>
        @endforelse
      </aside>
    </div>
  </div>
</div>

<div class="modal-overlay" id="fc-preview-modal">
  <div class="modal-backdrop" onclick="fcClosePreview()"></div>
  <div class="modal-box" style="max-width:760px;">
    <button class="modal-close" type="button" onclick="fcClosePreview()">&times;</button>
    <div class="fc-preview-label">Vista previa — así se verá publicado</div>
    <h2 id="fc-preview-title" class="fc-preview-title"></h2>
    <div id="fc-preview-cover-wrap" class="fc-preview-cover-wrap" hidden><img id="fc-preview-cover" alt=""></div>
    <div id="fc-preview-body" class="fc-preview-body"></div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset("vendor/quill/quill.min.js") }}"></script>
<script>
var quill = new Quill('#fc-editor', {
  theme: 'snow',
  placeholder: 'Escribe el contenido de tu artículo aquí…',
  modules: {
    toolbar: [
      ['bold', 'italic', 'underline', 'strike'],
      [{ header: 2 }, { header: 3 }, { header: 4 }],
      [{ align: '' }, { align: 'center' }, { align: 'justify' }, { align: 'right' }],
      [{ list: 'ordered' }, { list: 'bullet' }],
      ['blockquote'],
      ['link', 'image'],
      ['clean']
    ]
  }
});

// Restore content kept from a previous submit that failed validation.
(function restoreContent() {
  var stored = document.getElementById('fc-content').value;
  if (stored && stored.trim() !== '') {
    quill.root.innerHTML = stored;
  }
})();

// Custom image handler: upload to the server and embed the returned URL,
// instead of inlining a base64 blob into the article content.
quill.getModule('toolbar').addHandler('image', function () {
  var input = document.createElement('input');
  input.setAttribute('type', 'file');
  input.setAttribute('accept', 'image/*');
  input.click();

  input.onchange = function () {
    var file = input.files[0];
    if (!file) return;

    var range = quill.getSelection(true) || { index: quill.getLength() };
    var placeholder = '…subiendo imagen…';
    quill.insertText(range.index, placeholder, { italic: true });
    quill.setSelection(range.index + placeholder.length);

    var formData = new FormData();
    formData.append('image', file);

    fetch('{{ route('federico.upload-image') }}', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: formData
    })
      .then(function (res) {
        if (!res.ok) throw new Error('upload-failed');
        return res.json();
      })
      .then(function (data) {
        quill.deleteText(range.index, placeholder.length);
        quill.insertEmbed(range.index, 'image', data.location, 'user');
        quill.setSelection(range.index + 1);
      })
      .catch(function () {
        quill.deleteText(range.index, placeholder.length);
        alert('No se pudo subir la imagen. Verifica tu conexión e inténtalo de nuevo.');
      });
  };
});

// Cover image preview.
document.getElementById('fc-cover').addEventListener('change', function (e) {
  var file = e.target.files[0];
  var img = document.getElementById('fc-cover-preview');
  if (!file) { img.hidden = true; return; }
  img.src = URL.createObjectURL(file);
  img.hidden = false;
});

// Keep the hidden textarea in sync before every submit.
document.getElementById('fc-form').addEventListener('submit', function (e) {
  document.getElementById('fc-content').value = quill.root.innerHTML;

  var title = document.getElementById('fc-title').value.trim();
  var contentText = quill.getText().trim();

  if (!title) {
    e.preventDefault();
    alert('Escribe un título para el artículo.');
    document.getElementById('fc-title').focus();
    return;
  }

  if (!contentText) {
    e.preventDefault();
    alert('Escribe el contenido del artículo antes de continuar.');
  }
});

// Preview modal.
function fcOpenPreview() {
  document.getElementById('fc-content').value = quill.root.innerHTML;

  var title = document.getElementById('fc-title').value.trim();
  document.getElementById('fc-preview-title').textContent = title || 'Sin título todavía';
  document.getElementById('fc-preview-body').innerHTML = quill.root.innerHTML;

  var coverInput = document.getElementById('fc-cover');
  var coverWrap = document.getElementById('fc-preview-cover-wrap');
  var coverImg = document.getElementById('fc-preview-cover');
  if (coverInput.files && coverInput.files[0]) {
    coverImg.src = URL.createObjectURL(coverInput.files[0]);
    coverWrap.hidden = false;
  } else {
    coverWrap.hidden = true;
  }

  document.getElementById('fc-preview-modal').classList.add('active');
  document.body.style.overflow = 'hidden';
}
function fcClosePreview() {
  document.getElementById('fc-preview-modal').classList.remove('active');
  document.body.style.overflow = '';
}
document.getElementById('fc-preview-btn').addEventListener('click', fcOpenPreview);
document.addEventListener('keydown', function (e) { if (e.key === 'Escape') fcClosePreview(); });
</script>
@endsection
