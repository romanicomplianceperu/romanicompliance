@extends('layouts.app')

@section('title', $lesson->title.' — '.$course->title)

@section('styles')
.lesson-layout { display: grid; grid-template-columns: 2.2fr 1fr; gap: 2rem; padding: 2.5rem 0; align-items: start; }
.lesson-main h1 { font-size: 1.4rem; margin-bottom: 1.2rem; }
.lesson-video { position: relative; width: 100%; padding-top: 56.25%; background: var(--ink); border-radius: 6px; overflow: hidden; margin-bottom: 1.5rem; }
.lesson-video iframe, .lesson-video video { position: absolute; inset: 0; width: 100%; height: 100%; border: none; }
.lesson-pdf { width: 100%; height: 70vh; border: 1px solid var(--line); border-radius: 6px; margin-bottom: 1.5rem; }
.lesson-progress-line { position: sticky; top: 71px; z-index: 90; height: 4px; background: var(--ivory-dim); }
.lesson-progress-fill { height: 100%; background: linear-gradient(90deg, var(--gold), var(--gold-light)); transition: width 1s cubic-bezier(0.22,1,0.36,1); }
.doc-badge-row { margin-bottom: 10px; }
.doc-badge { display: inline-block; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; padding: 4px 12px; border-radius: 20px; }
.doc-badge.pdf, .doc-badge.doc, .doc-badge.docx { background: rgba(179,65,59,0.1); color: #B3413B; }
.doc-badge.doc, .doc-badge.docx { background: rgba(41,84,168,0.1); color: #2954A8; }
.doc-badge.xls, .doc-badge.xlsx { background: rgba(31,122,77,0.1); color: #1F7A4D; }
.doc-badge.ppt, .doc-badge.pptx { background: rgba(184,94,42,0.1); color: #B85E2A; }
.lesson-file-link { display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px; background: var(--white); border: 1px solid var(--line); border-radius: var(--radius); font-size: 0.85rem; font-weight: 600; color: var(--ink); margin-bottom: 1.5rem; }
.lesson-file-link:hover { border-color: var(--gold); color: var(--gold); }
.lesson-text-content { background: var(--white); border: 1px solid var(--line); border-radius: 6px; padding: 1.8rem; font-size: 0.9rem; line-height: 1.8; color: var(--ink); margin-bottom: 1.5rem; white-space: pre-line; }
.lesson-nav { display: flex; justify-content: space-between; gap: 1rem; margin-top: 1.5rem; }
.lesson-nav a, .lesson-nav button { font-size: 0.82rem; }

.lesson-sidebar { background: var(--white); border: 1px solid var(--line); border-radius: 10px; padding: 0; position: sticky; top: 90px; overflow: hidden; }
.rdp-panel-head { padding: 1.2rem 1.2rem 1rem; border-bottom: 1px solid var(--line); }
.rdp-sh-title { font-size: 0.9rem; font-weight: 700; color: var(--ink); line-height: 1.3; margin-bottom: 4px; }
.rdp-sh-stat { font-size: 0.72rem; color: var(--slate-light); margin-bottom: 1rem; }
.rdp-progress-label { display: flex; justify-content: space-between; font-size: 0.68rem; color: var(--slate); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; font-weight: 600; }
.rdp-progress-track { background: var(--ivory-dim); border-radius: 20px; height: 8px; overflow: hidden; margin-bottom: 6px; }
.rdp-progress-fill { background: linear-gradient(90deg, var(--gold), var(--gold-light)); height: 100%; transition: width 0.6s cubic-bezier(0.22,1,0.36,1); }
.rdp-progress-sub { font-size: 0.72rem; color: var(--slate-light); }

.rdp-tabs { display: flex; gap: 4px; background: var(--ivory-dim); border-radius: 9px; padding: 4px; margin: 1rem 1.2rem 0; }
.rdp-tab { flex: 1; text-align: center; padding: 9px 4px; border-radius: 6px; font-size: 0.74rem; font-weight: 700; color: var(--slate); cursor: pointer; border: none; background: none; transition: background 0.2s, color 0.2s; }
.rdp-tab.active { background: var(--ink); color: var(--white); }
.rdp-tabpanel { display: none; padding: 1rem 1.2rem 1.4rem; max-height: 480px; overflow-y: auto; }
.rdp-tabpanel.active { display: block; }

.rdp-module { border: 1px solid var(--line); border-radius: 10px; margin-bottom: 8px; overflow: hidden; }
.rdp-module[open] { border-color: var(--gold); box-shadow: 0 4px 16px rgba(11,24,41,0.06); }
.rdp-module summary { list-style: none; cursor: pointer; display: flex; align-items: center; gap: 10px; padding: 12px 12px; user-select: none; background: var(--ivory); }
.rdp-module summary::-webkit-details-marker { display: none; }
.rdp-module-icon { width: 30px; height: 30px; border-radius: 7px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rdp-module-icon svg { width: 15px; height: 15px; }
.rdp-module-head-text { flex: 1; min-width: 0; }
.rdp-module-head-text .t { font-size: 0.82rem; font-weight: 700; color: var(--ink); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.rdp-module-head-text .c { font-size: 0.68rem; color: var(--slate-light); }
.rdp-module-chevron { width: 14px; height: 14px; color: var(--slate-light); transition: transform 0.25s ease; flex-shrink: 0; }
.rdp-module[open] .rdp-module-chevron { transform: rotate(180deg); }
.rdp-module-body { padding: 8px; background: var(--white); }

.rdp-lesson-link { display: flex; align-items: center; gap: 10px; padding: 9px 9px; border-radius: 8px; font-size: 0.82rem; color: var(--ink); border: 1px solid transparent; margin-bottom: 3px; transition: background 0.15s, border-color 0.15s, transform 0.15s; }
.rdp-lesson-link:hover { background: var(--ivory); transform: translateX(2px); }
.rdp-lesson-link.current { background: var(--gold-pale); border-color: var(--gold); font-weight: 700; }
.rdp-lesson-link.done .rdp-lesson-title { color: var(--slate); }
.rdp-lesson-icon { width: 34px; height: 34px; border-radius: 6px; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center; color: var(--slate-light); background: var(--ivory-dim); }
.rdp-lesson-icon svg { width: 15px; height: 15px; }
.rdp-lesson-link.done .rdp-lesson-icon { color: #1F7A4D; background: rgba(37,150,90,0.1); }
.rdp-lesson-body { flex: 1; min-width: 0; }
.rdp-lesson-title { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block; }
.rdp-lesson-sub { font-size: 0.68rem; color: var(--slate-light); }

.rdp-block-title { display: flex; align-items: center; gap: 8px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--slate-light); margin: 1.2rem 0 0.6rem; }
.rdp-extra-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 9px; font-size: 0.82rem; color: var(--ink); border: 1px solid var(--line); margin-bottom: 6px; font-weight: 600; }
.rdp-extra-link:hover { border-color: var(--gold); background: var(--gold-pale); }
.rdp-extra-link svg { width: 16px; height: 16px; flex-shrink: 0; color: var(--gold); }

.rdp-resource-card { display: flex; align-items: center; gap: 10px; padding: 11px 12px; border-radius: 10px; border: 1px solid var(--line); margin-bottom: 8px; transition: box-shadow 0.2s, border-color 0.2s; }
.rdp-resource-card:hover { border-color: var(--gold); box-shadow: 0 4px 16px rgba(11,24,41,0.06); }
.rdp-resource-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rdp-resource-icon svg { width: 17px; height: 17px; }
.rdp-resource-info { flex: 1; min-width: 0; }
.rdp-resource-info .t { font-size: 0.8rem; font-weight: 700; color: var(--ink); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.rdp-resource-info .m { font-size: 0.68rem; color: var(--slate-light); text-transform: uppercase; }
.rdp-resource-dl { width: 30px; height: 30px; border-radius: 7px; background: var(--ivory-dim); color: var(--ink); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rdp-resource-dl:hover { background: var(--gold); color: var(--white); }
.rdp-resource-dl svg { width: 15px; height: 15px; }
.rdp-resource-empty { font-size: 0.8rem; color: var(--slate-light); padding: 1rem 0; }

.rdp-notes-title { font-size: 0.8rem; font-weight: 700; color: var(--ink); margin-bottom: 8px; }
.rdp-notes-toolbar { display: flex; gap: 4px; margin-bottom: 6px; }
.rdp-notes-toolbar button { width: 27px; height: 27px; border-radius: 5px; background: var(--ivory-dim); border: 1px solid var(--line); color: var(--slate); font-size: 0.78rem; cursor: pointer; }
.rdp-notes-toolbar button:hover { border-color: var(--gold); color: var(--gold); }
.rdp-notes-box { min-height: 150px; background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 10px 12px; font-size: 0.83rem; color: var(--ink); line-height: 1.6; outline: none; }
.rdp-notes-box:focus { border-color: var(--gold); }
.rdp-notes-box:empty::before { content: attr(data-placeholder); color: var(--slate-light); }
.rdp-notes-status { font-size: 0.68rem; color: var(--slate-light); margin-top: 6px; }

.rdp-cert-box { margin: 0 1.2rem 1.4rem; padding-top: 1.2rem; border-top: 1px solid var(--line); }
.rdp-cert-status { display: flex; align-items: center; gap: 10px; padding: 13px 14px; border-radius: 10px; font-size: 0.82rem; font-weight: 700; }
.rdp-cert-status svg { width: 17px; height: 17px; flex-shrink: 0; }
.rdp-cert-locked { background: var(--ivory-dim); color: var(--slate-light); cursor: default; }
.rdp-cert-ready { background: rgba(37,150,90,0.12); color: #1F7A4D; cursor: pointer; font-weight: 800; border: 1px solid rgba(37,150,90,0.3); }
.rdp-cert-ready:hover { background: #1F7A4D; color: var(--white); }
.rdp-cert-done { background: rgba(37,150,90,0.1); color: #1F7A4D; }

.lesson-drawer-toggle { display: none; }
.lesson-drawer-backdrop { display: none; }

@media (max-width: 960px) {
  .lesson-layout { grid-template-columns: 1fr; padding: 1.5rem 0; gap: 1.2rem; }
  .lesson-main { order: 1; }
  .lesson-pdf { height: 55vh; }
  .lesson-nav { flex-wrap: wrap; }

  .lesson-sidebar { position: fixed; top: 0; right: 0; bottom: 0; width: 90%; max-width: 380px; max-height: 100vh; z-index: 150; transform: translateX(100%); transition: transform 0.3s ease; box-shadow: -8px 0 30px rgba(0,0,0,0.2); border-radius: 0; border-left: none; display: flex; flex-direction: column; overflow-y: auto; }
  .lesson-sidebar.open { transform: translateX(0); }

  .lesson-drawer-backdrop { display: none; position: fixed; inset: 0; background: rgba(11,24,41,0.5); z-index: 140; }
  .lesson-drawer-backdrop.open { display: block; }

  .lesson-drawer-toggle { display: flex; align-items: center; gap: 8px; padding: 10px 16px; margin: 0 0 1rem auto; background: var(--ink); color: var(--white); border: none; border-radius: 30px; font-size: 0.8rem; font-weight: 600; cursor: pointer; }
  .lesson-drawer-toggle svg { width: 16px; height: 16px; }
}

/* ---- Interactive lesson types: cards / formulas / matrix builder / balance / glossary / memory ---- */
.ix-intro { font-size: 0.9rem; color: var(--slate); line-height: 1.75; margin-bottom: 1.4rem; }
.ix-card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 14px; margin-bottom: 1.5rem; }
.ix-card { background: var(--white); border: 1px solid var(--line); border-radius: 10px; padding: 1.3rem; transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s; }
.ix-card:hover { transform: translateY(-3px); box-shadow: 0 10px 26px rgba(11,24,41,0.08); border-color: var(--gold); }
.ix-card .icon { display: block; margin-bottom: 10px; }
.ix-card .icon svg { width: 22px; height: 22px; color: var(--gold); }
.ix-card .icon.icon-emoji { font-size: 1.7rem; line-height: 1; }
.ix-card .tag { display: inline-block; font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; padding: 3px 9px; border-radius: 20px; margin-bottom: 8px; }
.ix-card .tag.gold { background: var(--gold-pale); color: var(--gold); }
.ix-card .tag.green { background: rgba(31,122,77,0.1); color: #1F7A4D; }
.ix-card .tag.red { background: rgba(179,65,59,0.1); color: #B3413B; }
.ix-card .tag.ink { background: rgba(11,24,41,0.06); color: var(--ink); }
.ix-card h4 { font-size: 0.95rem; margin-bottom: 6px; color: var(--ink); }
.ix-card p { font-size: 0.82rem; color: var(--slate); line-height: 1.6; }

.ix-formula-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-bottom: 1.6rem; }
.ix-formula-box { background: linear-gradient(160deg, var(--ink) 0%, var(--ink-light) 100%); border-radius: 12px; padding: 1.6rem; text-align: center; color: var(--white); box-shadow: 0 12px 30px rgba(11,24,41,0.18); }
.ix-formula-box .lbl { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gold-light); margin-bottom: 10px; }
.ix-formula-box .eq { font-family: var(--serif); font-size: 1.9rem; font-weight: 700; margin-bottom: 10px; }
.ix-formula-box .note { font-size: 0.76rem; color: rgba(255,255,255,0.6); line-height: 1.6; }

.ix-table-wrap { overflow-x: auto; margin-bottom: 1.6rem; border-radius: 10px; border: 1px solid var(--line); }
.ix-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.ix-table th { background: var(--ink); color: var(--white); text-align: left; padding: 10px 14px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.04em; }
.ix-table td { padding: 10px 14px; border-top: 1px solid var(--line); }
.ix-table tr.level-bajo td:first-child, .ix-table tr.level-bajo .lvl-pill { color: #1F7A4D; }
.ix-table tr.level-medio .lvl-pill { color: #8A6D1E; }
.ix-table tr.level-alto .lvl-pill { color: #B3413B; }
.ix-table .lvl-pill { font-weight: 700; }
.ix-table tr.level-bajo { background: rgba(31,122,77,0.05); }
.ix-table tr.level-medio { background: rgba(184,148,46,0.07); }
.ix-table tr.level-alto { background: rgba(179,65,59,0.06); }

.ix-example { background: var(--white); border: 1px solid var(--line); border-radius: 10px; padding: 1.4rem; margin-bottom: 1.6rem; }
.ix-example h4 { font-size: 0.85rem; margin-bottom: 12px; color: var(--gold); text-transform: uppercase; letter-spacing: 0.04em; font-size: 0.72rem; font-weight: 700; }
.ix-step { display: flex; align-items: center; gap: 12px; padding: 9px 0; border-bottom: 1px dashed var(--line); font-size: 0.85rem; }
.ix-step:last-child { border-bottom: none; }
.ix-step .num { width: 24px; height: 24px; border-radius: 50%; background: var(--ink); color: var(--white); font-size: 0.72rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ix-step .txt { flex: 1; color: var(--ink); }
.ix-step .val { font-weight: 700; color: var(--gold); white-space: nowrap; }

.ix-bars { display: flex; flex-direction: column; gap: 12px; margin-bottom: 1.4rem; }
.ix-bar-row { display: grid; grid-template-columns: 90px 1fr 50px; align-items: center; gap: 10px; font-size: 0.82rem; }
.ix-bar-label { font-weight: 700; }
.ix-bar-track { background: var(--ivory-dim); border-radius: 20px; height: 22px; overflow: hidden; }
.ix-bar-fill { height: 100%; border-radius: 20px; display: flex; align-items: center; justify-content: flex-end; padding-right: 8px; color: var(--white); font-size: 0.7rem; font-weight: 700; transition: width 1s cubic-bezier(0.22,1,0.36,1); }
.ix-bar-fill.red { background: #B3413B; }
.ix-bar-fill.amber { background: #B8942E; }
.ix-bar-fill.green { background: #1F7A4D; }

/* Glossary */
.gl-search { width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: var(--radius); font-size: 0.85rem; margin-bottom: 1.2rem; }
.gl-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; }
.gl-term-card { background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 14px 12px; text-align: center; cursor: pointer; transition: transform 0.15s, border-color 0.15s, box-shadow 0.15s; }
.gl-term-card:hover { transform: translateY(-2px); border-color: var(--gold); box-shadow: 0 8px 20px rgba(11,24,41,0.08); }
.gl-term-card .icon { display: block; font-size: 1.3rem; margin-bottom: 4px; }
.gl-term-card .t { font-family: var(--serif); font-size: 1.05rem; font-weight: 700; color: var(--ink); }
.gl-term-card .s { font-size: 0.68rem; color: var(--slate-light); margin-top: 2px; }
.gl-confuse { background: var(--gold-pale); border-radius: 8px; padding: 12px 14px; font-size: 0.82rem; color: var(--ink); }
.gl-confuse strong { color: var(--gold); }

/* Floating glossary window */
.gl-float { position: fixed; right: 24px; bottom: 24px; width: 350px; max-width: calc(100vw - 32px); background: var(--white); border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 24px 60px rgba(11,24,41,0.22); z-index: 200; opacity: 0; transform: translateY(24px) scale(0.97); pointer-events: none; transition: opacity 0.22s ease, transform 0.22s ease; }
.gl-float.active { opacity: 1; transform: none; pointer-events: auto; }
.gl-float-header { display: flex; align-items: flex-start; gap: 10px; padding: 14px 14px 12px; border-bottom: 1px solid var(--line); cursor: grab; background: var(--ivory); border-radius: 14px 14px 0 0; user-select: none; }
.gl-float-header:active { cursor: grabbing; }
.gl-float-icon { font-size: 1.4rem; flex-shrink: 0; }
.gl-float-titles { flex: 1; min-width: 0; }
.gl-float-titles h3 { font-family: var(--serif); font-size: 1.05rem; color: var(--ink); margin: 0; }
.gl-float-titles p { font-size: 0.72rem; color: var(--slate-light); margin: 2px 0 0; }
.gl-float-close { flex-shrink: 0; width: 24px; height: 24px; border-radius: 50%; border: none; background: var(--ivory-dim); color: var(--slate); font-size: 1rem; line-height: 1; cursor: pointer; }
.gl-float-close:hover { background: var(--gold); color: var(--white); }
.gl-float-body { padding: 14px 16px 16px; max-height: 50vh; overflow-y: auto; }
.gl-float-body p { font-size: 0.85rem; color: var(--slate); line-height: 1.65; margin: 0 0 0.9rem; }
@media (max-width: 560px) { .gl-float { left: 16px; right: 16px; bottom: 16px; width: auto; } }

/* Interactive slide (word-reveal + citations) */
.sl-deck { background: var(--white); border: 1px solid var(--line); border-radius: 12px; padding: 1.7rem; margin-bottom: 1.5rem; }
.sl-progress { height: 4px; background: var(--ivory-dim); border-radius: 20px; overflow: hidden; margin-bottom: 1.5rem; }
.sl-progress-fill { height: 100%; width: 0%; background: linear-gradient(90deg, var(--gold), var(--gold-light)); transition: width 0.4s ease; }
.sl-viewport { position: relative; min-height: 190px; }
.sl-slide { display: none; }
.sl-slide.active { display: block; }
.sl-num { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gold); margin-bottom: 8px; }
.sl-heading { font-family: var(--serif); font-size: 1.25rem; color: var(--ink); margin-bottom: 14px; }
.sl-text { font-size: 1.02rem; line-height: 2; color: var(--ink); }
.sl-word { display: inline-block; opacity: 0; transform: translateY(6px); animation: slWordIn 0.4s ease forwards; }
.sl-word.hi { color: var(--gold); font-weight: 700; }
@keyframes slWordIn { to { opacity: 1; transform: none; } }
.sl-citation { display: flex; gap: 10px; align-items: flex-start; margin-top: 1.3rem; padding: 12px 14px; background: var(--gold-pale); border-radius: 8px; font-size: 0.82rem; color: var(--ink); line-height: 1.55; }
.sl-citation-icon { font-size: 1.05rem; flex-shrink: 0; }
.sl-nav { display: flex; align-items: center; justify-content: space-between; margin-top: 1.5rem; gap: 10px; }
.sl-btn { padding: 9px 16px; border-radius: 20px; border: 1px solid var(--line); background: var(--white); font-size: 0.8rem; font-weight: 600; color: var(--ink); cursor: pointer; }
.sl-btn:disabled { opacity: 0.35; cursor: not-allowed; }
.sl-btn.primary { background: var(--ink); color: var(--white); border-color: var(--ink); }
.sl-dots { display: flex; gap: 6px; }
.sl-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--line); cursor: pointer; border: none; padding: 0; }
.sl-dot.active { background: var(--gold); width: 20px; border-radius: 5px; }
.sl-sources { margin-top: 0.3rem; }
.sl-source-row { display: flex; gap: 10px; padding: 10px 0; border-bottom: 1px dashed var(--line); font-size: 0.82rem; color: var(--slate); line-height: 1.5; }
.sl-source-row:last-child { border-bottom: none; }
.sl-source-icon { flex-shrink: 0; }

/* Memory game */
.mg-status { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; font-size: 0.8rem; color: var(--slate); }
.mg-status button { font-size: 0.76rem; font-weight: 600; color: var(--gold); background: none; border: 1px solid var(--gold); border-radius: 20px; padding: 6px 14px; cursor: pointer; }
.mg-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
@media (max-width: 560px) { .mg-grid { grid-template-columns: repeat(3, 1fr); } }
.mg-card { aspect-ratio: 4/3; perspective: 800px; cursor: pointer; }
.mg-card-inner { position: relative; width: 100%; height: 100%; transition: transform 0.5s; transform-style: preserve-3d; }
.mg-card.flipped .mg-card-inner, .mg-card.matched .mg-card-inner { transform: rotateY(180deg); }
.mg-face { position: absolute; inset: 0; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 6px; backface-visibility: hidden; font-size: 0.72rem; font-weight: 600; line-height: 1.3; }
.mg-front { background: var(--ink); color: var(--gold-light); font-size: 1.3rem; }
.mg-back { background: var(--white); border: 1.5px solid var(--gold); color: var(--ink); transform: rotateY(180deg); flex-direction: column; gap: 4px; }
.mg-icon { font-size: 1.3rem; line-height: 1; }
.mg-card.matched .mg-back { background: rgba(31,122,77,0.1); border-color: #1F7A4D; color: #1F7A4D; }
.mg-win { text-align: center; padding: 1.4rem; background: rgba(31,122,77,0.08); border: 1px solid rgba(31,122,77,0.3); border-radius: 10px; margin-top: 1rem; display: none; }
.mg-win.show { display: block; }
.mg-win h4 { color: #1F7A4D; font-size: 1rem; margin-bottom: 4px; }
.mg-win p { font-size: 0.82rem; color: var(--slate); }

/* Drag & drop matrix builder */
.dd-instructions { background: var(--gold-pale); border-radius: 8px; padding: 12px 16px; font-size: 0.82rem; color: var(--ink); margin-bottom: 1.2rem; }
.dd-pool { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 1.6rem; min-height: 46px; padding: 12px; border: 1.5px dashed var(--line); border-radius: 10px; }
.dd-chip { background: var(--white); border: 1.5px solid var(--ink); border-radius: 20px; padding: 8px 16px; font-size: 0.8rem; font-weight: 600; color: var(--ink); cursor: grab; user-select: none; transition: opacity 0.15s, transform 0.15s; }
.dd-chip:active { cursor: grabbing; }
.dd-chip.placed-correct { border-color: #1F7A4D; color: #1F7A4D; background: rgba(31,122,77,0.08); cursor: default; }
.dd-chip.placed-wrong { border-color: #B3413B; color: #B3413B; background: rgba(179,65,59,0.08); }
.dd-zones { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; }
.dd-zone { border: 1.5px dashed var(--line); border-radius: 10px; padding: 12px; min-height: 100px; background: var(--white); transition: border-color 0.15s, background 0.15s; }
.dd-zone.dragover { border-color: var(--gold); background: var(--gold-pale); }
.dd-zone h5 { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em; color: var(--slate); margin-bottom: 8px; }
.dd-zone .dd-chip { display: block; margin-bottom: 6px; text-align: center; }
.dd-feedback { margin-top: 1rem; font-size: 0.82rem; color: var(--slate); text-align: center; }
.dd-reset { margin-top: 12px; font-size: 0.76rem; font-weight: 600; color: var(--gold); background: none; border: 1px solid var(--gold); border-radius: 20px; padding: 6px 14px; cursor: pointer; display: block; margin-left: auto; }
@endsection

@section('content')
<div class="lesson-progress-line"><div class="lesson-progress-fill" id="lessonProgressFill" style="width:0%" data-pct="{{ $progressPercent }}"></div></div>
<div class="lesson-drawer-backdrop" id="lessonDrawerBackdrop" onclick="lessonToggleDrawer()"></div>
<div class="wrap lesson-layout">
  <div class="lesson-main">
    <button type="button" class="lesson-drawer-toggle" onclick="lessonToggleDrawer()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
      Contenido del curso
    </button>
    <div class="course-hero-category" style="color:var(--gold)">{{ $course->title }}</div>
    <h1>{{ $lesson->title }}</h1>

    @if($lesson->type === 'video' && $lesson->embedUrl())
      <div class="lesson-video">
        <iframe src="{{ $lesson->embedUrl() }}" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
      </div>
    @elseif($lesson->type === 'pdf' && $lesson->file_path)
      <div class="doc-badge-row"><span class="doc-badge pdf">Documento PDF · vista previa</span></div>
      <iframe src="{{ asset('storage/'.$lesson->file_path) }}" class="lesson-pdf"></iframe>
      <a href="{{ asset('storage/'.$lesson->file_path) }}" target="_blank" class="lesson-file-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;"><path d="M12 4v11m0 0l4-4m-4 4l-4-4M5 19h14"/></svg>
        Descargar PDF
      </a>
    @elseif($lesson->type === 'file' && $lesson->file_path)
      @php
        $ext = strtolower(pathinfo($lesson->file_path, PATHINFO_EXTENSION));
        $docLabels = ['docx' => 'Documento Word', 'doc' => 'Documento Word', 'xlsx' => 'Hoja de cálculo Excel', 'xls' => 'Hoja de cálculo Excel', 'pptx' => 'Presentación PowerPoint', 'ppt' => 'Presentación PowerPoint', 'pdf' => 'Documento PDF'];
        $docLabel = $docLabels[$ext] ?? 'Archivo descargable';
        $officePreviewable = in_array($ext, ['docx', 'doc', 'xlsx', 'xls', 'pptx', 'ppt']);
        $fileUrl = asset('storage/'.$lesson->file_path);
      @endphp
      <div class="doc-badge-row"><span class="doc-badge {{ $ext }}">{{ $docLabel }} · vista previa</span></div>
      @if($officePreviewable)
        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}" class="lesson-pdf" loading="lazy"></iframe>
      @else
        <div class="lesson-pdf" style="display:flex;align-items:center;justify-content:center;color:var(--slate);font-size:0.85rem;">Vista previa no disponible para este tipo de archivo.</div>
      @endif
      <a href="{{ $fileUrl }}" target="_blank" class="lesson-file-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;"><path d="M12 4v11m0 0l4-4m-4 4l-4-4M5 19h14"/></svg>
        Descargar {{ $docLabel }}
      </a>
    @elseif($lesson->type === 'text')
      <div class="lesson-text-content">{{ $lesson->content }}</div>
    @elseif(in_array($lesson->type, ['interactive', 'glossary', 'memory']) && $lesson->content)
      @php $ix = json_decode($lesson->content, true) ?: []; @endphp

      @if($lesson->type === 'interactive' && ($ix['kind'] ?? null) === 'cards')
        @if(!empty($ix['intro']))<p class="ix-intro">{{ $ix['intro'] }}</p>@endif
        <div class="ix-card-grid">
          @foreach($ix['cards'] ?? [] as $c)
            <div class="ix-card">
              <span class="icon icon-emoji">{{ $c['icon'] ?? '📌' }}</span>
              @if(!empty($c['tag']))<span class="tag {{ $c['color'] ?? 'gold' }}">{{ $c['tag'] }}</span>@endif
              <h4>{{ $c['title'] ?? '' }}</h4>
              <p>{{ $c['body'] ?? '' }}</p>
            </div>
          @endforeach
        </div>

      @elseif($lesson->type === 'interactive' && ($ix['kind'] ?? null) === 'formulas')
        @if(!empty($ix['intro']))<p class="ix-intro">{{ $ix['intro'] }}</p>@endif
        <div class="ix-formula-row">
          @foreach($ix['formulas'] ?? [] as $f)
            <div class="ix-formula-box">
              <div class="lbl">{{ $f['label'] ?? '' }}</div>
              <div class="eq">{{ $f['eq'] ?? '' }}</div>
              <div class="note">{{ $f['note'] ?? '' }}</div>
            </div>
          @endforeach
        </div>
        @if(!empty($ix['escala']))
          <div class="ix-table-wrap">
            <table class="ix-table">
              <thead><tr><th>Nivel</th><th>Punt.</th><th>Probabilidad (P)</th><th>Impacto (I)</th><th>Eficacia de Controles (EC)</th></tr></thead>
              <tbody>
                @foreach($ix['escala'] as $row)
                  <tr class="level-{{ \Illuminate\Support\Str::slug($row['nivel'] ?? '') }}"><td class="lvl-pill">{{ $row['nivel'] ?? '' }}</td><td>{{ $row['punt'] ?? '' }}</td><td>{{ $row['p'] ?? '' }}</td><td>{{ $row['i'] ?? '' }}</td><td>{{ $row['ec'] ?? '' }}</td></tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
        @if(!empty($ix['rangos']))
          <div class="ix-table-wrap">
            <table class="ix-table">
              <thead><tr><th>Rango de RR</th><th>Nivel</th><th>Plan de acción</th></tr></thead>
              <tbody>
                @foreach($ix['rangos'] as $row)
                  <tr class="level-{{ \Illuminate\Support\Str::slug($row['nivel'] ?? '') }}"><td>{{ $row['rango'] ?? '' }}</td><td class="lvl-pill">{{ $row['nivel'] ?? '' }}</td><td>{{ $row['plan'] ?? '' }}</td></tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
        @if(!empty($ix['ejemplo']['pasos']))
          <div class="ix-example">
            <h4>{{ $ix['ejemplo']['titulo'] ?? 'Ejemplo de cálculo' }}</h4>
            @foreach($ix['ejemplo']['pasos'] as $i => $step)
              <div class="ix-step"><span class="num">{{ $i + 1 }}</span><span class="txt">{{ $step['txt'] ?? '' }}</span><span class="val">{{ $step['val'] ?? '' }}</span></div>
            @endforeach
          </div>
        @endif

      @elseif($lesson->type === 'interactive' && ($ix['kind'] ?? null) === 'slide')
        @if(!empty($ix['intro']))<p class="ix-intro">{{ $ix['intro'] }}</p>@endif
        <div class="sl-deck" id="slDeck">
          <div class="sl-progress"><div class="sl-progress-fill" id="slProgressFill"></div></div>
          <div class="sl-viewport" id="slViewport">
            @foreach($ix['slides'] ?? [] as $i => $s)
              <div class="sl-slide {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
                <div class="sl-num">{{ $i + 1 }} / {{ count($ix['slides']) }}</div>
                @if(!empty($s['heading']))<h3 class="sl-heading">{{ $s['heading'] }}</h3>@endif
                <p class="sl-text" data-words="{{ $s['text'] ?? '' }}" data-highlight='{{ json_encode($s['highlight'] ?? []) }}'></p>
                @if(!empty($s['citation']))
                  <div class="sl-citation">
                    <span class="sl-citation-icon">📜</span>
                    <div><strong>{{ $s['citation']['label'] ?? '' }}</strong><br>{{ $s['citation']['note'] ?? '' }}</div>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
          <div class="sl-nav">
            <button type="button" id="slPrev" class="sl-btn" disabled>← Anterior</button>
            <div class="sl-dots" id="slDots">
              @foreach($ix['slides'] ?? [] as $i => $s)<button type="button" class="sl-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></button>@endforeach
            </div>
            <button type="button" id="slNext" class="sl-btn primary">Siguiente →</button>
          </div>
        </div>
        @if(!empty($ix['sources']))
          <div class="sl-sources">
            <div class="rdp-block-title" style="margin:0 0 0.6rem;">Fuentes normativas de referencia</div>
            @foreach($ix['sources'] as $src)
              <div class="sl-source-row"><span class="sl-source-icon">⚖️</span><div><strong>{{ $src['label'] ?? '' }}</strong> — {{ $src['desc'] ?? '' }}</div></div>
            @endforeach
          </div>
        @endif

      @elseif($lesson->type === 'interactive' && ($ix['kind'] ?? null) === 'balance')
        @if(!empty($ix['intro']))<p class="ix-intro">{{ $ix['intro'] }}</p>@endif
        <div class="ix-bars" id="ixBars">
          @foreach($ix['bars'] ?? [] as $b)
            @php $pct = ($b['total'] ?? 0) > 0 ? round((($b['count'] ?? 0) / $b['total']) * 100) : 0; @endphp
            <div class="ix-bar-row">
              <span class="ix-bar-label">{{ $b['label'] ?? '' }}</span>
              <div class="ix-bar-track"><div class="ix-bar-fill {{ $b['color'] ?? 'gold' }}" data-pct="{{ $pct }}" style="width:0%;">{{ $b['count'] ?? 0 }}</div></div>
              <span>{{ $pct }}%</span>
            </div>
          @endforeach
        </div>
        @if(!empty($ix['note']))<p class="ix-intro">{{ $ix['note'] }}</p>@endif

      @elseif($lesson->type === 'interactive' && ($ix['kind'] ?? null) === 'matrix_builder')
        @if(!empty($ix['intro']))<div class="dd-instructions">{{ $ix['intro'] }}</div>@endif
        <div class="dd-pool" id="ddPool">
          @foreach($ix['items'] ?? [] as $item)
            <div class="dd-chip" draggable="true" data-item="{{ $item['id'] }}" data-category="{{ $item['category'] }}" data-hint="{{ $item['hint'] ?? '' }}">{{ $item['label'] }}</div>
          @endforeach
        </div>
        <div class="dd-zones" id="ddZones">
          @foreach($ix['categories'] ?? [] as $cat)
            <div class="dd-zone" data-category="{{ $cat['id'] }}"><h5>{{ $cat['label'] }}</h5></div>
          @endforeach
        </div>
        <div class="dd-feedback" id="ddFeedback">Arrastra cada tarjeta a la categoría correcta.</div>
        <button type="button" class="dd-reset" id="ddReset">Reiniciar actividad</button>

      @elseif($lesson->type === 'glossary')
        @if(!empty($ix['intro']))<p class="ix-intro">{{ $ix['intro'] }}</p>@endif
        <input type="text" class="gl-search" id="glSearch" placeholder="Buscar un término...">
        <div class="gl-grid" id="glGrid">
          @foreach($ix['terms'] ?? [] as $i => $t)
            <div class="gl-term-card" data-idx="{{ $i }}" data-search="{{ \Illuminate\Support\Str::lower(($t['term'] ?? '').' '.($t['short'] ?? '')) }}" onclick="glOpen({{ $i }})">
              <span class="icon">{{ $t['icon'] ?? '🔎' }}</span>
              <div class="t">{{ $t['term'] ?? '' }}</div>
              <div class="s">{{ $t['short'] ?? '' }}</div>
            </div>
          @endforeach
        </div>
        <script type="application/json" id="glData">{!! json_encode($ix['terms'] ?? []) !!}</script>

      @elseif($lesson->type === 'memory')
        @if(!empty($ix['instructions']))<p class="ix-intro">{{ $ix['instructions'] }}</p>@endif
        <div class="mg-status"><span id="mgMoves">Movimientos: 0</span><button type="button" id="mgReset">Reiniciar juego</button></div>
        <div class="mg-grid" id="mgGrid"></div>
        <div class="mg-win" id="mgWin"><h4>¡Completado!</h4><p id="mgWinText"></p></div>
        <script type="application/json" id="mgData">{!! json_encode($ix['pairs'] ?? []) !!}</script>
      @endif
    @endif

    <div class="lesson-nav">
      <div>
        @if($previousLesson)
          <a href="{{ route('lessons.show', $previousLesson) }}" class="btn btn-outline-dark" style="border:1px solid var(--line);padding:10px 18px;border-radius:4px;">← Anterior</a>
        @endif
      </div>
      <form action="{{ route('lessons.complete', $lesson) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-gold">{{ $isCompleted ? ($nextLesson ? 'Siguiente lección →' : 'Volver al curso') : 'Marcar como completada' }}</button>
      </form>
    </div>
  </div>

  <div class="lesson-sidebar" id="lessonSidebar">
    @php
      $totalLessonsAll = $course->modules->sum(fn ($m) => $m->lessons->count());
      $doneLessonsAll = $completedLessonIds->count();
      $resources = $course->modules->flatMap->lessons->filter(fn ($l) => in_array($l->type, ['pdf', 'file'], true) && $l->file_path);
      $lessonIconSvg = [
        'video' => '<path d="M8 5v14l11-7z"/>',
        'pdf' => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" fill="none" stroke="currentColor"/><path d="M14 2v6h6" fill="none" stroke="currentColor"/>',
        'file' => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" fill="none" stroke="currentColor"/><path d="M14 2v6h6" fill="none" stroke="currentColor"/>',
        'text' => '<path d="M4 19.5A2.5 2.5 0 016.5 17H20" fill="none" stroke="currentColor"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" fill="none" stroke="currentColor"/>',
        'interactive' => '<path d="M12 2L2 7l10 5 10-5-10-5z" fill="none" stroke="currentColor"/><path d="M2 17l10 5 10-5" fill="none" stroke="currentColor"/><path d="M2 12l10 5 10-5" fill="none" stroke="currentColor"/>',
        'glossary' => '<path d="M4 19.5A2.5 2.5 0 016.5 17H20" fill="none" stroke="currentColor"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" fill="none" stroke="currentColor"/><circle cx="12" cy="11" r="2.4" fill="none" stroke="currentColor"/>',
        'memory' => '<rect x="3" y="3" width="8" height="8" rx="1.2" fill="none" stroke="currentColor"/><rect x="13" y="3" width="8" height="8" rx="1.2" fill="none" stroke="currentColor"/><rect x="3" y="13" width="8" height="8" rx="1.2" fill="none" stroke="currentColor"/><rect x="13" y="13" width="8" height="8" rx="1.2" fill="none" stroke="currentColor"/>',
      ];
    @endphp
    <div class="rdp-panel-head">
      <div class="rdp-sh-title">{{ $course->title }}</div>
      <div class="rdp-sh-stat">{{ $course->modules->count() }} módulos &middot; {{ $totalLessonsAll }} lecciones</div>
      <div class="rdp-progress-label"><span>Tu progreso</span><span>{{ $progressPercent }}%</span></div>
      <div class="rdp-progress-track"><div class="rdp-progress-fill" style="width:{{ $progressPercent }}%"></div></div>
      <div class="rdp-progress-sub">{{ $doneLessonsAll }} de {{ $totalLessonsAll }} lecciones completadas</div>
    </div>

    <div class="rdp-tabs">
      <button type="button" class="rdp-tab active" data-tab="contenido" onclick="rdpTab('contenido')">Contenido</button>
      <button type="button" class="rdp-tab" data-tab="actividades" onclick="rdpTab('actividades')">Actividades</button>
      <button type="button" class="rdp-tab" data-tab="apuntes" onclick="rdpTab('apuntes')">Apuntes</button>
    </div>

    <div class="rdp-tabpanel active" data-panel="contenido">
      @foreach($course->modules as $module)
        @php $moduleHasCurrent = $module->lessons->contains('id', $lesson->id); @endphp
        <details class="rdp-module" {{ $moduleHasCurrent ? 'open' : '' }}>
          <summary>
            <span class="rdp-module-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg></span>
            <span class="rdp-module-head-text">
              <div class="t">{{ $module->title }}</div>
              <div class="c">{{ $module->lessons->count() }} {{ $module->lessons->count() === 1 ? 'contenido' : 'contenidos' }}</div>
            </span>
            <svg class="rdp-module-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
          </summary>
          <div class="rdp-module-body">
            @foreach($module->lessons as $l)
              @php $lDone = $completedLessonIds->contains($l->id); $lCurrent = $l->id === $lesson->id; @endphp
              <a href="{{ route('lessons.show', $l) }}" class="rdp-lesson-link {{ $lCurrent ? 'current' : '' }} {{ $lDone ? 'done' : '' }}">
                <span class="rdp-lesson-icon">
                  @if($lDone)
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                  @else
                    {!! '<svg viewBox="0 0 24 24">' . ($lessonIconSvg[$l->type] ?? $lessonIconSvg['text']) . '</svg>' !!}
                  @endif
                </span>
                <span class="rdp-lesson-body">
                  <span class="rdp-lesson-title">{{ $l->title }}</span>
                  @if($l->duration_minutes)<span class="rdp-lesson-sub">{{ $l->duration_minutes }} min</span>@endif
                </span>
              </a>
            @endforeach
          </div>
        </details>
      @endforeach

      <div class="rdp-block-title">Recursos</div>
      @forelse($resources as $r)
        <div class="rdp-resource-card">
          <div class="rdp-resource-icon">{!! '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' . ($lessonIconSvg[$r->type] ?? $lessonIconSvg['file']) . '</svg>' !!}</div>
          <div class="rdp-resource-info">
            <div class="t">{{ $r->title }}</div>
            <div class="m">{{ $r->typeLabel() }}</div>
          </div>
          <a href="{{ asset('storage/'.$r->file_path) }}" target="_blank" class="rdp-resource-dl" title="Descargar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4v11m0 0l4-4m-4 4l-4-4M5 19h14"/></svg>
          </a>
        </div>
      @empty
        <div class="rdp-resource-empty">Todavía no hay recursos descargables en este curso.</div>
      @endforelse
    </div>

    <div class="rdp-tabpanel" data-panel="actividades">
      @if($course->exam)
        <a href="{{ route('exams.show', $course) }}" class="rdp-extra-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4M11 11l-7 7"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h11"/></svg>
          <span>{{ $course->exam->title }}</span>
        </a>
        <p style="font-size:0.8rem;color:var(--slate);margin-top:8px;">Responde las preguntas del curso y conoce tu puntaje al instante.</p>
      @else
        <div class="rdp-resource-empty">La autoevaluación de este curso está en preparación.</div>
      @endif

      <div class="rdp-block-title">Soporte</div>
      <a href="{{ route('panel.questions.index') }}" class="rdp-extra-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
        <span>Preguntas y dudas</span>
      </a>
    </div>

    <div class="rdp-tabpanel" data-panel="apuntes">
      <div class="rdp-notes-title">Apuntes — {{ $lesson->title }}</div>
      <div class="rdp-notes-toolbar">
        <button type="button" onclick="document.execCommand('bold')" title="Negrita"><strong>B</strong></button>
        <button type="button" onclick="document.execCommand('italic')" title="Cursiva"><em>I</em></button>
        <button type="button" onclick="document.execCommand('underline')" title="Subrayado"><u>U</u></button>
        <button type="button" onclick="document.execCommand('insertUnorderedList')" title="Lista">&bull;</button>
      </div>
      <div class="rdp-notes-box" id="rdpNotesBox" contenteditable="true" data-placeholder="Escribe tus apuntes sobre esta lección...">{!! ($myNotes[$lesson->id] ?? '') !!}</div>
      <div class="rdp-notes-status" id="rdpNotesStatus">&nbsp;</div>
    </div>

    @if($course->exam)
      <div class="rdp-cert-box">
        @if($certificate)
          <a href="{{ route('certificates.download', $certificate) }}" class="rdp-cert-status rdp-cert-done">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M8.5 12.5L7 21l5-2.5L17 21l-1.5-8.5"/></svg>
            Certificado disponible
          </a>
        @elseif($pendingCertificate)
          <div class="rdp-cert-status rdp-cert-locked">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            Certificado en proceso
          </div>
        @elseif($progressPercent >= 100)
          @if(($course->certificate_type ?? 'gratuita') === 'opcional')
            <button type="button" class="rdp-cert-status rdp-cert-ready" style="width:100%;border:none;" onclick="abrirModalCompra()">Conseguir certificación</button>
          @else
            <a href="{{ route('exams.show', $course) }}" class="rdp-cert-status rdp-cert-ready">Conseguir certificación</a>
          @endif
        @else
          <button type="button" class="rdp-cert-status rdp-cert-locked" style="width:100%;border:none;cursor:default;" onclick="abrirModalBloqueo()">Certificado bloqueado</button>
        @endif
      </div>
    @endif
  </div>
</div>

<div class="modal-overlay" id="modalBloqueo">
  <div class="modal-backdrop" onclick="cerrarModalesLeccion()"></div>
  <div class="modal-box" style="max-width:420px;text-align:center;">
    <button class="modal-close" onclick="cerrarModalesLeccion()">&times;</button>
    <h3>Completa el curso primero</h3>
    <p class="modal-text">Debes finalizar todas las lecciones del curso para poder acceder a tu certificación.</p>
  </div>
</div>

@if(($course->certificate_type ?? 'gratuita') === 'opcional')
<div class="modal-overlay" id="modalCompra">
  <div class="modal-backdrop" onclick="cerrarModalesLeccion()"></div>
  <div class="modal-box" style="max-width:440px;text-align:center;">
    <button class="modal-close" onclick="cerrarModalesLeccion()">&times;</button>
    <h3>Certificación opcional</h3>
    <p class="modal-sub">{{ $course->title }}</p>
    <div class="modal-price">S/ {{ number_format($course->certificate_price ?? 0, 2) }} <span>/ certificado</span></div>
    <p class="modal-text">Esta certificación tiene un costo adicional. Coordina tu pago escribiéndonos por WhatsApp y te habilitaremos el examen para obtenerla.</p>
    <a href="https://wa.me/51969754983?text={{ urlencode('Hola, deseo adquirir la certificación opcional del curso "'.$course->title.'".') }}" target="_blank" class="btn-whatsapp">
      <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      Comprar a través de WhatsApp
    </a>
    <a href="{{ route('exams.show', $course) }}" class="modal-text" style="display:block;margin-top:14px;color:var(--gold);font-weight:600;text-decoration:underline;">Ya realicé el pago, continuar con el examen</a>
  </div>
</div>
@endif

<div class="gl-float" id="glFloat">
  <div class="gl-float-header" id="glFloatHeader">
    <span class="gl-float-icon" id="glFloatIcon">📖</span>
    <div class="gl-float-titles">
      <h3 id="glModalTerm"></h3>
      <p id="glModalShort"></p>
    </div>
    <button type="button" class="gl-float-close" onclick="glClose()">&times;</button>
  </div>
  <div class="gl-float-body">
    <p id="glModalDef"></p>
    <div class="gl-confuse" id="glModalConfuse" style="display:none;"><strong>⚠️ No confundir con:</strong> <span id="glModalConfuseText"></span></div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function abrirModalCompra() { document.getElementById('modalCompra')?.classList.add('active'); }
function abrirModalBloqueo() { document.getElementById('modalBloqueo')?.classList.add('active'); }
function cerrarModalesLeccion() { document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active')); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') { cerrarModalesLeccion(); window.glClose?.(); } });

function lessonToggleDrawer() {
  document.getElementById('lessonSidebar')?.classList.toggle('open');
  document.getElementById('lessonDrawerBackdrop')?.classList.toggle('open');
}

function rdpTab(name) {
  document.querySelectorAll('.rdp-tab').forEach(t => t.classList.toggle('active', t.dataset.tab === name));
  document.querySelectorAll('.rdp-tabpanel').forEach(p => p.classList.toggle('active', p.dataset.panel === name));
}

(function rdpNotes() {
  const box = document.getElementById('rdpNotesBox');
  const status = document.getElementById('rdpNotesStatus');
  if (!box) return;
  let timer;
  box.addEventListener('input', () => {
    status.textContent = 'Guardando...';
    clearTimeout(timer);
    timer = setTimeout(async () => {
      try {
        await fetch('{{ route("lessons.notes.store", $lesson) }}', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: JSON.stringify({ content: box.innerHTML })
        });
        status.textContent = 'Apuntes guardados.';
      } catch (e) {
        status.textContent = 'No se pudo guardar. Revisa tu conexión.';
      }
    }, 900);
  });
})();

/* ---- Top progress line ---- */
(function () {
  const fill = document.getElementById('lessonProgressFill');
  if (!fill) return;
  setTimeout(() => { fill.style.width = fill.dataset.pct + '%'; }, 150);
})();

/* ---- Balance bars animation ---- */
(function () {
  const bars = document.querySelectorAll('#ixBars .ix-bar-fill');
  if (!bars.length) return;
  setTimeout(() => bars.forEach(b => { b.style.width = b.dataset.pct + '%'; }), 150);
})();

/* ---- Interactive glossary (floating window) ---- */
(function () {
  const dataEl = document.getElementById('glData');
  if (!dataEl) return;
  const terms = JSON.parse(dataEl.textContent || '[]');
  const float = document.getElementById('glFloat');

  window.glOpen = function (idx) {
    const t = terms[idx];
    if (!t) return;
    document.getElementById('glFloatIcon').textContent = t.icon || '🔎';
    document.getElementById('glModalTerm').textContent = t.term || '';
    document.getElementById('glModalShort').textContent = t.short || '';
    document.getElementById('glModalDef').textContent = t.definition || '';
    const confuseBox = document.getElementById('glModalConfuse');
    if (t.confuse) {
      confuseBox.style.display = 'block';
      document.getElementById('glModalConfuseText').textContent = t.confuse;
    } else {
      confuseBox.style.display = 'none';
    }
    float.style.left = '';
    float.style.top = '';
    float.classList.add('active');
  };

  window.glClose = function () { float.classList.remove('active'); };

  const search = document.getElementById('glSearch');
  if (search) {
    search.addEventListener('input', () => {
      const q = search.value.trim().toLowerCase();
      document.querySelectorAll('#glGrid .gl-term-card').forEach(card => {
        card.style.display = card.dataset.search.includes(q) ? '' : 'none';
      });
    });
  }

  /* Drag the floating window by its header */
  const header = document.getElementById('glFloatHeader');
  if (header) {
    let dragging = false, offX = 0, offY = 0;
    header.addEventListener('mousedown', e => {
      if (e.target.closest('.gl-float-close')) return;
      dragging = true;
      const rect = float.getBoundingClientRect();
      offX = e.clientX - rect.left;
      offY = e.clientY - rect.top;
      e.preventDefault();
    });
    document.addEventListener('mousemove', e => {
      if (!dragging) return;
      float.style.right = 'auto';
      float.style.bottom = 'auto';
      float.style.left = Math.min(Math.max(0, e.clientX - offX), window.innerWidth - float.offsetWidth) + 'px';
      float.style.top = Math.min(Math.max(0, e.clientY - offY), window.innerHeight - float.offsetHeight) + 'px';
    });
    document.addEventListener('mouseup', () => { dragging = false; });
  }
})();

/* ---- Interactive slide deck (word-by-word reveal) ---- */
(function () {
  const deck = document.getElementById('slDeck');
  if (!deck) return;
  const slides = Array.from(deck.querySelectorAll('.sl-slide'));
  const dots = Array.from(deck.querySelectorAll('.sl-dot'));
  const prevBtn = document.getElementById('slPrev');
  const nextBtn = document.getElementById('slNext');
  const fill = document.getElementById('slProgressFill');
  let current = 0;

  function renderWords(slide) {
    const p = slide.querySelector('.sl-text');
    if (!p || p.dataset.rendered) return;
    const text = p.dataset.words || '';
    let highlights = [];
    try { highlights = JSON.parse(p.dataset.highlight || '[]'); } catch (e) {}
    const words = text.split(/\s+/);
    p.innerHTML = words.map((w, i) => {
      const clean = w.replace(/[.,;:()"“”]/g, '');
      const isHi = highlights.some(h => clean.toLowerCase() === h.toLowerCase());
      return '<span class="sl-word' + (isHi ? ' hi' : '') + '" style="animation-delay:' + (i * 0.045) + 's">' + w + '</span>';
    }).join(' ');
    p.dataset.rendered = '1';
  }

  function show(i) {
    slides.forEach((s, idx) => s.classList.toggle('active', idx === i));
    dots.forEach((d, idx) => d.classList.toggle('active', idx === i));
    prevBtn.disabled = i === 0;
    nextBtn.textContent = i === slides.length - 1 ? 'Fin ✓' : 'Siguiente →';
    fill.style.width = ((i + 1) / slides.length * 100) + '%';
    renderWords(slides[i]);
    current = i;
  }

  prevBtn.addEventListener('click', () => { if (current > 0) show(current - 1); });
  nextBtn.addEventListener('click', () => { if (current < slides.length - 1) show(current + 1); });
  dots.forEach(d => d.addEventListener('click', () => show(parseInt(d.dataset.index, 10))));

  show(0);
})();

/* ---- Memory match game ---- */
(function () {
  const dataEl = document.getElementById('mgData');
  const grid = document.getElementById('mgGrid');
  if (!dataEl || !grid) return;
  const pairs = JSON.parse(dataEl.textContent || '[]');

  let cards = [];
  let flipped = [];
  let matched = 0;
  let moves = 0;
  let lock = false;

  function shuffle(arr) {
    for (let i = arr.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr;
  }

  function build() {
    grid.innerHTML = '';
    flipped = []; matched = 0; moves = 0; lock = false;
    document.getElementById('mgMoves').textContent = 'Movimientos: 0';
    document.getElementById('mgWin').classList.remove('show');

    cards = [];
    pairs.forEach((p, i) => {
      cards.push({ pairId: i, text: p.a, icon: p.icon || '🔹', key: 'a' });
      cards.push({ pairId: i, text: p.b, icon: p.icon || '🔹', key: 'b' });
    });
    shuffle(cards);

    cards.forEach((c, i) => {
      const el = document.createElement('div');
      el.className = 'mg-card';
      el.dataset.index = i;
      el.innerHTML = '<div class="mg-card-inner"><div class="mg-face mg-front">❔</div><div class="mg-face mg-back"><span class="mg-icon">' + c.icon + '</span>' + c.text + '</div></div>';
      el.addEventListener('click', () => flip(i, el));
      grid.appendChild(el);
    });
  }

  function flip(i, el) {
    if (lock || el.classList.contains('flipped') || el.classList.contains('matched')) return;
    el.classList.add('flipped');
    flipped.push({ i, el });
    if (flipped.length === 2) {
      moves++;
      document.getElementById('mgMoves').textContent = 'Movimientos: ' + moves;
      const [f1, f2] = flipped;
      if (cards[f1.i].pairId === cards[f2.i].pairId) {
        f1.el.classList.add('matched');
        f2.el.classList.add('matched');
        flipped = [];
        matched++;
        if (matched === pairs.length) {
          setTimeout(() => {
            document.getElementById('mgWinText').textContent = 'Lo lograste en ' + moves + ' movimientos.';
            document.getElementById('mgWin').classList.add('show');
          }, 400);
        }
      } else {
        lock = true;
        setTimeout(() => {
          f1.el.classList.remove('flipped');
          f2.el.classList.remove('flipped');
          flipped = [];
          lock = false;
        }, 900);
      }
    }
  }

  document.getElementById('mgReset')?.addEventListener('click', build);
  build();
})();

/* ---- Drag & drop matrix classification ---- */
(function () {
  const pool = document.getElementById('ddPool');
  const zonesWrap = document.getElementById('ddZones');
  if (!pool || !zonesWrap) return;

  let dragged = null;

  function attachChip(chip) {
    chip.addEventListener('dragstart', () => { dragged = chip; setTimeout(() => chip.style.opacity = '0.4', 0); });
    chip.addEventListener('dragend', () => { chip.style.opacity = '1'; });
  }
  pool.querySelectorAll('.dd-chip').forEach(attachChip);

  zonesWrap.querySelectorAll('.dd-zone').forEach(zone => {
    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
    zone.addEventListener('drop', e => {
      e.preventDefault();
      zone.classList.remove('dragover');
      if (!dragged || dragged.classList.contains('placed-correct')) return;

      const correct = dragged.dataset.category === zone.dataset.category;
      zone.appendChild(dragged);
      dragged.setAttribute('draggable', correct ? 'false' : 'true');
      dragged.classList.remove('placed-wrong');
      dragged.classList.toggle('placed-correct', correct);
      if (!correct) dragged.classList.add('placed-wrong');

      const feedback = document.getElementById('ddFeedback');
      if (correct) {
        feedback.textContent = '✓ Correcto — ' + (dragged.dataset.hint || '');
      } else {
        feedback.textContent = '✗ Esa no es su categoría. Vuelve a intentarlo.';
      }

      const total = pool.parentElement.querySelectorAll('.dd-chip').length;
      const correctCount = zonesWrap.querySelectorAll('.dd-chip.placed-correct').length;
      if (correctCount === total) {
        feedback.textContent = '🎉 ¡Completaste la clasificación! Todas las tarjetas están en su categoría correcta.';
      }
    });
  });

  document.getElementById('ddReset')?.addEventListener('click', () => {
    document.querySelectorAll('.dd-zone .dd-chip, #ddPool .dd-chip').forEach(chip => {
      chip.classList.remove('placed-correct', 'placed-wrong');
      chip.setAttribute('draggable', 'true');
      pool.appendChild(chip);
    });
    document.getElementById('ddFeedback').textContent = 'Arrastra cada tarjeta a la categoría correcta.';
  });
})();
</script>
@endsection
