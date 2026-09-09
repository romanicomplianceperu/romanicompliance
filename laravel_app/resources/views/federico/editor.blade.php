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
.fc-field input[type="text"], .fc-field textarea, .fc-field select { width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1px solid var(--line); border-radius: 8px; font-family: var(--sans); font-size: 0.92rem; color: var(--ink); transition: border-color 0.2s; background: var(--white); }
.fc-field input[type="text"]:focus, .fc-field textarea:focus, .fc-field select:focus { outline: none; border-color: var(--gold); }
.fc-field textarea { resize: vertical; }
.fc-field input[type="file"] { font-size: 0.84rem; }
.fc-cover-preview { display: block; margin-top: 10px; max-width: 100%; max-height: 220px; border-radius: 8px; object-fit: cover; }
.fc-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
@media (max-width: 560px) { .fc-field-row { grid-template-columns: 1fr; } }

.fc-dropzone { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; text-align: center; padding: 1.6rem 1rem; border: 2px dashed var(--line); border-radius: 10px; background: var(--ivory-dim); cursor: pointer; transition: border-color 0.2s, background 0.2s; }
.fc-dropzone:hover, .fc-dropzone:focus-visible { border-color: var(--gold); background: var(--gold-pale); outline: none; }
.fc-dropzone.fc-dragging { border-color: var(--gold); background: var(--gold-pale); }
.fc-dropzone svg { width: 26px; height: 26px; color: var(--gold); }
.fc-dropzone-text { font-size: 0.82rem; color: var(--slate); }
.fc-dropzone-text strong { color: var(--ink); }
.fc-materials-list { margin-top: 10px; display: flex; flex-direction: column; gap: 8px; }
.fc-material-chip { display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: var(--white); border: 1px solid var(--line); border-radius: 8px; font-size: 0.82rem; }
.fc-material-chip svg { width: 18px; height: 18px; color: var(--gold); flex-shrink: 0; }
.fc-material-chip .fc-material-name { flex: 1; color: var(--ink); font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.fc-material-chip .fc-material-size { color: var(--slate-light); font-size: 0.74rem; }
.fc-material-chip button { background: none; border: none; color: var(--slate-light); cursor: pointer; font-size: 1.1rem; line-height: 1; padding: 2px 4px; }
.fc-material-chip button:hover { color: #B3413B; }

.fc-page-wrap { position: relative; background: var(--ivory-dim); border: 1px solid var(--line); border-radius: 10px; padding: 1.4rem; }
.ql-toolbar.ql-snow { border: 1px solid var(--line); border-radius: 8px; background: var(--white); margin-bottom: 1.1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04); padding: 10px 12px; }
.ql-toolbar.ql-snow .ql-picker.ql-expanded .ql-picker-options { z-index: 30; }
.ql-container.ql-snow { border: none; }
#fc-editor { background: var(--white); min-height: 520px; font-size: 1rem; border-radius: 6px; box-shadow: 0 2px 10px rgba(11,24,41,0.08), 0 12px 32px rgba(11,24,41,0.06); max-width: 800px; margin: 0 auto; }
#fc-editor .ql-editor { padding: 3rem 3.5rem; line-height: 1.8; min-height: 520px; }
.ql-editor.ql-blank::before { top: 3rem; left: 3.5rem; right: 3.5rem; color: var(--slate-light); font-style: normal; }
.ql-editor h2 { font-size: 1.5rem; }
.ql-editor h3 { font-size: 1.25rem; }
.ql-editor h4 { font-size: 1.1rem; }
.ql-editor blockquote { border-left: 3px solid var(--gold); color: var(--slate); }
.ql-editor pre { background: var(--ivory-dim); border: 1px solid var(--line); border-radius: 6px; padding: 12px 14px; }
@media (max-width: 700px) {
  #fc-editor .ql-editor { padding: 1.5rem 1.4rem; }
  .ql-editor.ql-blank::before { top: 1.5rem; left: 1.4rem; right: 1.4rem; }
}

.fc-fs-toggle { position: absolute; top: 26px; right: 26px; z-index: 25; width: 36px; height: 36px; border-radius: 6px; border: 1px solid var(--line); background: var(--white); display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--slate); transition: background 0.2s, color 0.2s; padding: 0; }
.fc-fs-toggle:hover { background: var(--ivory-dim); color: var(--ink); }
.fc-fs-toggle svg { width: 16px; height: 16px; }
.fc-page-wrap.fc-fullscreen { position: fixed; inset: 0; z-index: 4000; margin: 0; border-radius: 0; padding: 2rem 1.5rem 2.5rem; overflow-y: auto; border: none; }
.fc-page-wrap.fc-fullscreen #fc-editor,
.fc-page-wrap.fc-fullscreen .ql-toolbar.ql-snow { max-width: 860px; margin-left: auto; margin-right: auto; }
.fc-page-wrap.fc-fullscreen .ql-toolbar.ql-snow { position: sticky; top: 0; }
.fc-page-wrap.fc-fullscreen .fc-fs-toggle { position: fixed; top: 22px; right: 32px; }
body.fc-fullscreen-active { overflow: hidden; }
#fc-preview-modal.active { z-index: 4500; }

.fc-page-wrap.fc-dragging { outline: 3px dashed var(--gold); outline-offset: -3px; }
.fc-page-wrap.fc-dragging::after { content: 'Suelta la imagen aquí para insertarla'; position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.9); font-size: 1rem; font-weight: 700; color: var(--gold); z-index: 30; pointer-events: none; border-radius: 10px; }
.fc-editor-hint { font-size: 0.74rem; color: var(--slate-light); margin-top: 0.6rem; display: flex; align-items: center; gap: 6px; }
.fc-editor-hint svg { width: 14px; height: 14px; flex-shrink: 0; }

.fc-editor-area { display: grid; grid-template-columns: 1fr; gap: 1.4rem; align-items: start; }
.fc-editor-area.fc-live-active { grid-template-columns: 1fr 1fr; }
.fc-live-preview { background: var(--white); border: 1px solid var(--line); border-radius: 12px; padding: 1.6rem; max-height: 700px; overflow-y: auto; }
@media (max-width: 1100px) {
  .fc-editor-area.fc-live-active { grid-template-columns: 1fr; }
}
.fc-btn-active { background: var(--ink); color: var(--white); border-color: var(--ink); }

.fc-uploading-blot { display: inline-flex; align-items: center; gap: 6px; background: var(--gold-pale); color: var(--gold); border-radius: 6px; padding: 2px 10px 2px 6px; font-size: 0.85em; font-style: italic; user-select: none; cursor: default; }
.fc-uploading-spinner { width: 11px; height: 11px; border: 2px solid rgba(184,145,64,0.3); border-top-color: var(--gold); border-radius: 50%; display: inline-block; animation: fcSpin 0.7s linear infinite; }
@keyframes fcSpin { to { transform: rotate(360deg); } }

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
.fc-preview-excerpt { font-size: 0.9rem; color: var(--slate); font-style: italic; line-height: 1.6; margin: -0.6rem 0 1.2rem; padding-bottom: 1rem; border-bottom: 1px solid var(--line); }
.fc-preview-cover-wrap img { width: 100%; max-height: 320px; object-fit: cover; border-radius: 8px; margin-bottom: 1.4rem; display: block; }
.fc-preview-body { font-size: 0.95rem; color: var(--ink); line-height: 1.85; max-height: 55vh; overflow-y: auto; }
.fc-preview-body p { margin-bottom: 1.1rem; }
.fc-preview-body h2, .fc-preview-body h3, .fc-preview-body h4 { color: var(--ink); font-weight: 600; margin: 1.6rem 0 0.8rem; }
.fc-preview-body ul, .fc-preview-body ol { margin: 0 0 1.1rem 1.4rem; }
.fc-preview-body blockquote { margin: 1.2rem 0; padding: 0.2rem 1.2rem; border-left: 3px solid var(--gold); color: var(--slate); font-style: italic; }
.fc-preview-body img { max-width: 100%; border-radius: 6px; margin: 1.2rem 0; }
.fc-preview-body a { color: var(--gold); }
.fc-preview-body pre { background: var(--ivory-dim); border: 1px solid var(--line); border-radius: 6px; padding: 12px 14px; overflow-x: auto; font-family: monospace; margin-bottom: 1.1rem; }
.fc-preview-body code { font-family: monospace; }
.fc-preview-body sub { vertical-align: sub; font-size: smaller; }
.fc-preview-body sup { vertical-align: super; font-size: smaller; }
.fc-preview-body .ql-size-small { font-size: 0.75em; }
.fc-preview-body .ql-size-large { font-size: 1.5em; }
.fc-preview-body .ql-size-huge { font-size: 2.5em; }
.fc-preview-body .ql-font-serif { font-family: Georgia, 'Times New Roman', serif; }
.fc-preview-body .ql-font-monospace { font-family: Monaco, 'Courier New', monospace; }
.fc-preview-body .ql-indent-1 { padding-left: 3em; }
.fc-preview-body .ql-indent-2 { padding-left: 6em; }
.fc-preview-body .ql-indent-3 { padding-left: 9em; }
.fc-preview-body .ql-indent-4 { padding-left: 12em; }
.fc-preview-body .ql-indent-5 { padding-left: 15em; }
.fc-preview-body .ql-indent-6 { padding-left: 18em; }
.fc-preview-body .ql-indent-7 { padding-left: 21em; }
.fc-preview-body .ql-indent-8 { padding-left: 24em; }

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

          <div class="fc-field-row">
            <div class="fc-field">
              <label for="fc-category">Categoría <span>(opcional)</span></label>
              <select name="article_category_id" id="fc-category">
                <option value="">Sin categoría</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" @selected(old('article_category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="fc-field">
              <label for="fc-tags">Etiquetas <span>(opcional, sepáralas con comas)</span></label>
              <input type="text" name="tags" id="fc-tags" value="{{ old('tags') }}" placeholder="derechos humanos, compliance, ética">
            </div>
          </div>

          <div class="fc-field">
            <label for="fc-cover">Imagen de portada <span>(opcional)</span></label>
            <input type="file" name="cover_image" id="fc-cover" accept="image/*">
            <img id="fc-cover-preview" class="fc-cover-preview" hidden>
          </div>

          <div class="fc-field">
            <label>Material adicional <span>(opcional — PDFs descargables para los lectores, máx. 10MB cada uno)</span></label>
            <div class="fc-dropzone" id="fc-materials-dropzone" tabindex="0" role="button" aria-label="Agregar archivos PDF">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path><path d="M14 2v6h6"></path></svg>
              <div class="fc-dropzone-text"><strong>Arrastra tus PDFs aquí</strong> o haz clic para elegirlos</div>
            </div>
            <input type="file" name="materials[]" id="fc-materials-input" accept="application/pdf" multiple hidden>
            <div id="fc-materials-list" class="fc-materials-list"></div>
          </div>

          <div class="fc-field">
            <label>Contenido</label>
            <div class="fc-editor-area" id="fc-editor-area">
              <div class="fc-page-wrap" id="fc-page-wrap">
                <button type="button" class="fc-fs-toggle" id="fc-fullscreen-btn" title="Pantalla completa" aria-label="Pantalla completa">
                  <svg id="fc-fs-icon-expand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 00-2 2v3M16 3h3a2 2 0 012 2v3M8 21H5a2 2 0 01-2-2v-3M16 21h3a2 2 0 002-2v-3"></path></svg>
                  <svg id="fc-fs-icon-collapse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" hidden><path d="M9 3v3a2 2 0 01-2 2H4M15 3v3a2 2 0 002 2h3M9 21v-3a2 2 0 00-2-2H4M15 21v-3a2 2 0 012-2h3"></path></svg>
                </button>
                <div id="fc-editor"></div>
              </div>
              <div class="fc-live-preview" id="fc-live-preview" hidden>
                <div class="fc-preview-label">Vista previa en vivo</div>
                <h2 id="fc-live-preview-title" class="fc-preview-title"></h2>
                <p id="fc-live-preview-excerpt" class="fc-preview-excerpt" hidden></p>
                <div id="fc-live-preview-cover-wrap" class="fc-preview-cover-wrap" hidden><img id="fc-live-preview-cover" alt=""></div>
                <div id="fc-live-preview-body" class="fc-preview-body"></div>
              </div>
            </div>
            <div class="fc-editor-hint">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg>
              Puedes arrastrar y soltar una imagen directamente sobre el editor, o usar el ícono de imagen en la barra de herramientas.
            </div>
            <textarea name="content" id="fc-content" hidden>{{ old('content') }}</textarea>
          </div>

          <div class="fc-actions">
            <button type="button" class="fc-btn fc-btn-ghost" id="fc-live-preview-btn">Vista en vivo</button>
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
    <p id="fc-preview-excerpt" class="fc-preview-excerpt" hidden></p>
    <div id="fc-preview-cover-wrap" class="fc-preview-cover-wrap" hidden><img id="fc-preview-cover" alt=""></div>
    <div id="fc-preview-body" class="fc-preview-body"></div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset("vendor/quill/quill.min.js") }}"></script>
<script>
// A genuine non-editable placeholder blot for "uploading image…", used
// instead of inserting real, clickable/editable text. A plain inserted
// string can be clicked into and edited like normal content, which then
// breaks the later deleteText/insertEmbed swap — this atomic embed can't
// be typed into, so it always behaves like a real placeholder.
var Embed = Quill.import('blots/embed');
class FcUploadingBlot extends Embed {
  static create() {
    var node = super.create();
    node.setAttribute('contenteditable', 'false');
    node.classList.add('fc-uploading-blot');
    node.innerHTML = '<span class="fc-uploading-spinner"></span>Subiendo imagen…';
    return node;
  }
  static value() { return true; }
}
FcUploadingBlot.blotName = 'fc-uploading';
FcUploadingBlot.tagName = 'span';
Quill.register(FcUploadingBlot);

var quill = new Quill('#fc-editor', {
  theme: 'snow',
  placeholder: 'Escribe el contenido de tu artículo aquí…',
  modules: {
    toolbar: [
      [{ header: 2 }, { header: 3 }, { header: 4 }, { font: [] }],
      [{ size: ['small', false, 'large', 'huge'] }],
      ['bold', 'italic', 'underline', 'strike'],
      [{ color: [] }, { background: [] }],
      [{ script: 'sub' }, { script: 'super' }],
      [{ align: '' }, { align: 'center' }, { align: 'justify' }, { align: 'right' }],
      [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
      ['blockquote', 'code-block'],
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

// Shared image upload: sends the file to the server and embeds the returned
// URL, instead of inlining a base64 blob into the article content. Used by
// both the toolbar image button and drag-and-drop.
function fcUploadAndInsertImage(file) {
  if (!file || !file.type || file.type.indexOf('image/') !== 0) return;

  var range = quill.getSelection(true) || { index: quill.getLength() };
  quill.insertEmbed(range.index, 'fc-uploading', true, 'user');
  quill.setSelection(range.index + 1);

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
      quill.deleteText(range.index, 1);
      quill.insertEmbed(range.index, 'image', data.location, 'user');
      quill.setSelection(range.index + 1);
    })
    .catch(function () {
      quill.deleteText(range.index, 1);
      alert('No se pudo subir la imagen. Verifica tu conexión e inténtalo de nuevo.');
    });
}

quill.getModule('toolbar').addHandler('image', function () {
  var input = document.createElement('input');
  input.setAttribute('type', 'file');
  input.setAttribute('accept', 'image/*');
  input.click();

  input.onchange = function () {
    fcUploadAndInsertImage(input.files[0]);
  };
});

// Drag-and-drop: drop an image file anywhere on the editor page to insert it.
(function setupDragAndDrop() {
  var dropTarget = document.getElementById('fc-page-wrap');
  var dragCounter = 0;

  dropTarget.addEventListener('dragenter', function (e) {
    e.preventDefault();
    dragCounter++;
    dropTarget.classList.add('fc-dragging');
  });
  dropTarget.addEventListener('dragover', function (e) {
    e.preventDefault();
  });
  dropTarget.addEventListener('dragleave', function (e) {
    e.preventDefault();
    dragCounter = Math.max(0, dragCounter - 1);
    if (dragCounter === 0) dropTarget.classList.remove('fc-dragging');
  });
  dropTarget.addEventListener('drop', function (e) {
    e.preventDefault();
    dragCounter = 0;
    dropTarget.classList.remove('fc-dragging');

    var files = e.dataTransfer && e.dataTransfer.files;
    if (!files || !files.length) return;

    for (var i = 0; i < files.length; i++) {
      fcUploadAndInsertImage(files[i]);
    }
  });
})();

// Material adicional (PDFs): click-to-pick or drag-and-drop, kept in a
// DataTransfer so the real file input carries every file (from either
// source) when the form submits.
(function setupMaterials() {
  var dropzone = document.getElementById('fc-materials-dropzone');
  var input = document.getElementById('fc-materials-input');
  var list = document.getElementById('fc-materials-list');
  var files = [];
  var MAX_BYTES = 10 * 1024 * 1024;

  function humanSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return Math.round(bytes / 1024) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
  }

  function syncInput() {
    var dt = new DataTransfer();
    files.forEach(function (f) { dt.items.add(f); });
    input.files = dt.files;
  }

  function render() {
    list.innerHTML = '';
    files.forEach(function (f, i) {
      var chip = document.createElement('div');
      chip.className = 'fc-material-chip';
      chip.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path><path d="M14 2v6h6"></path></svg>'
        + '<span class="fc-material-name"></span>'
        + '<span class="fc-material-size"></span>'
        + '<button type="button" aria-label="Quitar">&times;</button>';
      chip.querySelector('.fc-material-name').textContent = f.name;
      chip.querySelector('.fc-material-size').textContent = humanSize(f.size);
      chip.querySelector('button').addEventListener('click', function () {
        files.splice(i, 1);
        syncInput();
        render();
      });
      list.appendChild(chip);
    });
  }

  function addFiles(fileList) {
    for (var i = 0; i < fileList.length; i++) {
      var f = fileList[i];
      if (f.type !== 'application/pdf') {
        alert('"' + f.name + '" no es un PDF. Solo se aceptan archivos PDF como material adicional.');
        continue;
      }
      if (f.size > MAX_BYTES) {
        alert('"' + f.name + '" supera los 10MB permitidos.');
        continue;
      }
      files.push(f);
    }
    syncInput();
    render();
  }

  dropzone.addEventListener('click', function () { input.click(); });
  dropzone.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); input.click(); }
  });
  input.addEventListener('change', function () {
    // The picked files already sit in a real FileList from the OS dialog;
    // add them to our tracked array, then resync via DataTransfer.
    addFiles(input.files);
  });

  var dragCounter = 0;
  dropzone.addEventListener('dragenter', function (e) { e.preventDefault(); dragCounter++; dropzone.classList.add('fc-dragging'); });
  dropzone.addEventListener('dragover', function (e) { e.preventDefault(); });
  dropzone.addEventListener('dragleave', function (e) {
    e.preventDefault();
    dragCounter = Math.max(0, dragCounter - 1);
    if (dragCounter === 0) dropzone.classList.remove('fc-dragging');
  });
  dropzone.addEventListener('drop', function (e) {
    e.preventDefault();
    dragCounter = 0;
    dropzone.classList.remove('fc-dragging');
    var dropped = e.dataTransfer && e.dataTransfer.files;
    if (dropped && dropped.length) addFiles(dropped);
  });
})();

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

  var excerpt = document.getElementById('fc-excerpt').value.trim();
  var excerptEl = document.getElementById('fc-preview-excerpt');
  excerptEl.textContent = excerpt;
  excerptEl.hidden = !excerpt;

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

// Live preview: a side-by-side panel that updates as you type, instead of
// requiring a click to see how the article will look.
var fcEditorArea = document.getElementById('fc-editor-area');
var fcLivePreview = document.getElementById('fc-live-preview');
var fcLiveBtn = document.getElementById('fc-live-preview-btn');
var fcLiveActive = false;

function fcUpdateLivePreview() {
  if (!fcLiveActive) return;

  var title = document.getElementById('fc-title').value.trim();
  document.getElementById('fc-live-preview-title').textContent = title || 'Sin título todavía';

  var excerpt = document.getElementById('fc-excerpt').value.trim();
  var liveExcerptEl = document.getElementById('fc-live-preview-excerpt');
  liveExcerptEl.textContent = excerpt;
  liveExcerptEl.hidden = !excerpt;

  document.getElementById('fc-live-preview-body').innerHTML = quill.root.innerHTML;

  var coverInput = document.getElementById('fc-cover');
  var coverWrap = document.getElementById('fc-live-preview-cover-wrap');
  var coverImg = document.getElementById('fc-live-preview-cover');
  if (coverInput.files && coverInput.files[0]) {
    coverImg.src = URL.createObjectURL(coverInput.files[0]);
    coverWrap.hidden = false;
  } else {
    coverWrap.hidden = true;
  }
}

function fcSetLivePreview(on) {
  fcLiveActive = on;
  fcEditorArea.classList.toggle('fc-live-active', on);
  fcLivePreview.hidden = !on;
  fcLiveBtn.classList.toggle('fc-btn-active', on);
  fcLiveBtn.textContent = on ? 'Ocultar vista en vivo' : 'Vista en vivo';
  if (on) fcUpdateLivePreview();
}

fcLiveBtn.addEventListener('click', function () { fcSetLivePreview(!fcLiveActive); });
quill.on('text-change', fcUpdateLivePreview);
document.getElementById('fc-title').addEventListener('input', fcUpdateLivePreview);
document.getElementById('fc-excerpt').addEventListener('input', fcUpdateLivePreview);
document.getElementById('fc-cover').addEventListener('change', fcUpdateLivePreview);

// Fullscreen editor mode.
var fcPageWrap = document.getElementById('fc-page-wrap');
var fcFsBtn = document.getElementById('fc-fullscreen-btn');
var fcFsIconExpand = document.getElementById('fc-fs-icon-expand');
var fcFsIconCollapse = document.getElementById('fc-fs-icon-collapse');

function fcSetFullscreen(on) {
  fcPageWrap.classList.toggle('fc-fullscreen', on);
  document.body.classList.toggle('fc-fullscreen-active', on);
  fcFsIconExpand.hidden = on;
  fcFsIconCollapse.hidden = !on;
  fcFsBtn.title = on ? 'Salir de pantalla completa' : 'Pantalla completa';
  fcFsBtn.setAttribute('aria-label', fcFsBtn.title);
}
function fcIsFullscreen() {
  return fcPageWrap.classList.contains('fc-fullscreen');
}
fcFsBtn.addEventListener('click', function () { fcSetFullscreen(!fcIsFullscreen()); });

document.addEventListener('keydown', function (e) {
  if (e.key !== 'Escape') return;

  var previewOpen = document.getElementById('fc-preview-modal').classList.contains('active');
  if (previewOpen) {
    fcClosePreview();
  } else if (fcIsFullscreen()) {
    fcSetFullscreen(false);
  }
});
</script>
@endsection
