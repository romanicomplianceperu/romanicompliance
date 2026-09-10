.ac-shell { min-height: calc(100vh - 71px); background: var(--ivory); }
.ac-full { min-height: calc(100vh - 71px); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 3rem 1.5rem; text-align: center; }
.ac-eyebrow { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--gold); margin-bottom: 0.8rem; }
.ac-title { font-family: var(--serif); font-weight: 600; font-size: clamp(1.8rem, 4vw, 2.6rem); color: var(--ink); margin-bottom: 0.7rem; letter-spacing: -0.01em; }
.ac-subtitle { font-size: 0.95rem; color: var(--slate); max-width: 560px; margin: 0 auto 2.4rem; line-height: 1.6; }

/* Two-choice cards (alumno / visitante) */
.ac-choice-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.4rem; max-width: 780px; width: 100%; }
@media (max-width: 640px) { .ac-choice-grid { grid-template-columns: 1fr; } }
.ac-choice-card { background: var(--white); border: 1.5px solid var(--line); border-radius: 16px; padding: 2.6rem 2rem; text-decoration: none; transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease; text-align: center; }
.ac-choice-card:hover { border-color: var(--gold); transform: translateY(-4px); box-shadow: 0 16px 40px rgba(11,24,41,0.08); }
.ac-choice-card:active { transform: translateY(-1px); }
.ac-choice-icon { width: 64px; height: 64px; border-radius: 16px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem; }
.ac-choice-icon svg { width: 30px; height: 30px; }
.ac-choice-card h3 { font-family: var(--serif); font-size: 1.25rem; color: var(--ink); margin-bottom: 8px; }
.ac-choice-card p { font-size: 0.85rem; color: var(--slate); line-height: 1.55; }

/* University cards */
.ac-uni-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem; max-width: 980px; width: 100%; }
@media (max-width: 900px) { .ac-uni-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 600px) { .ac-uni-grid { grid-template-columns: 1fr; } }
.ac-uni-card { background: var(--white); border: 1.5px solid var(--line); border-radius: 16px; padding: 2rem 1.6rem; text-decoration: none; transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease; display: flex; flex-direction: column; align-items: center; text-align: center; }
.ac-uni-card.active:hover { border-color: var(--gold); transform: translateY(-4px); box-shadow: 0 16px 40px rgba(11,24,41,0.08); }
.ac-uni-card.soon { opacity: 0.6; cursor: default; }
.ac-uni-logo { height: 68px; max-width: 100%; object-fit: contain; margin-bottom: 1.2rem; }
.ac-uni-card h3 { font-size: 1.02rem; color: var(--ink); margin-bottom: 4px; font-weight: 700; }
.ac-uni-card .ac-uni-short { font-size: 0.72rem; color: var(--slate-light); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 1rem; }
.ac-uni-cta { font-size: 0.8rem; font-weight: 700; color: var(--gold); }
.ac-uni-soon-badge { font-size: 0.68rem; font-weight: 700; color: var(--slate-light); background: var(--ivory-dim); padding: 4px 12px; border-radius: 20px; }

.ac-btn-primary { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--ink); font-weight: 700; font-size: 0.9rem; padding: 15px 32px; border-radius: 8px; text-decoration: none; transition: transform 0.2s ease, box-shadow 0.2s ease; }
.ac-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(184,154,86,0.35); }

.ac-back-link { display: inline-flex; align-items: center; gap: 6px; font-size: 0.82rem; color: var(--slate); font-weight: 600; margin-bottom: 1.6rem; }
.ac-back-link:hover { color: var(--gold); }
.ac-back-link svg { width: 14px; height: 14px; }

/* Breadcrumbs */
.ac-crumbs { font-size: 0.78rem; color: var(--slate-light); margin-bottom: 1.2rem; display: flex; flex-wrap: wrap; align-items: center; gap: 6px; }
.ac-crumbs a { color: var(--slate-light); font-weight: 600; }
.ac-crumbs a:hover { color: var(--gold); }
.ac-crumbs .sep { opacity: 0.5; }
.ac-crumbs .current { color: var(--ink); font-weight: 700; }

/* Campus header */
.ac-campus-header { background: var(--white); border-bottom: 1px solid var(--line); padding: 1rem 0; }
.ac-campus-header-row { display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
.ac-campus-brand { display: flex; align-items: center; gap: 10px; font-size: 0.85rem; font-weight: 700; color: var(--ink); }
.ac-campus-brand .tag { font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gold); background: var(--gold-pale); padding: 3px 10px; border-radius: 20px; }
.ac-campus-nav { display: flex; gap: 1.2rem; font-size: 0.82rem; align-items: center; }
.ac-campus-nav a { color: var(--slate); font-weight: 600; }
.ac-campus-nav a:hover { color: var(--gold); }
.ac-logout-form { display: inline-flex; margin: 0; }
.ac-logout-btn { background: none; border: none; padding: 0; margin: 0; color: var(--slate); font-weight: 600; font-size: inherit; font-family: inherit; cursor: pointer; }
.ac-logout-btn:hover { color: var(--gold); }

/* Course header */
.ac-course-header { background: var(--white); border-bottom: 1px solid var(--line); padding: 1.8rem 0; }
.ac-course-header h1 { font-family: var(--serif); font-size: clamp(1.4rem, 3vw, 1.9rem); color: var(--ink); margin-bottom: 4px; }
.ac-course-header .sub { font-size: 0.88rem; color: var(--gold); font-weight: 600; margin-bottom: 10px; }
.ac-course-meta { display: flex; gap: 1.4rem; flex-wrap: wrap; font-size: 0.78rem; color: var(--slate-light); }

/* Course tabs / nav */
.ac-tabs-wrap { background: var(--white); border-bottom: 1px solid var(--line); overflow-x: auto; }
.ac-tabs { display: flex; gap: 0.4rem; padding: 0 24px; max-width: var(--max); margin: 0 auto; }
.ac-tab { display: flex; align-items: center; gap: 6px; padding: 12px 14px; font-size: 0.82rem; font-weight: 600; color: var(--slate); border-bottom: 2px solid transparent; white-space: nowrap; }
.ac-tab.active { color: var(--ink); border-bottom-color: var(--gold); }
.ac-tab.disabled { color: var(--slate-light); cursor: default; }
.ac-tab .soon-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--slate-light); }

/* Widgets grid */
.ac-widget-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.6rem; }
.ac-widget { background: var(--white); border: 1px solid var(--line); border-radius: 12px; padding: 1.3rem 1.4rem; }
.ac-widget .k { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--slate-light); margin-bottom: 8px; }
.ac-widget .v { font-family: var(--serif); font-size: 1.3rem; color: var(--ink); font-weight: 600; }
.ac-widget .v small { font-size: 0.75rem; color: var(--slate); font-weight: 500; }
.ac-progress-track { background: var(--ivory-dim); border-radius: 20px; height: 6px; overflow: hidden; margin-top: 8px; }
.ac-progress-fill { background: var(--gold); height: 100%; }

/* Activity / week cards */
.ac-activity-card { display: flex; align-items: center; gap: 1rem; background: var(--white); border: 1px solid var(--line); border-radius: 12px; padding: 1.2rem 1.4rem; margin-bottom: 10px; text-decoration: none; transition: border-color 0.15s ease, transform 0.15s ease; }
.ac-activity-card:hover { border-color: var(--gold); transform: translateX(2px); }
.ac-activity-week { width: 44px; height: 44px; border-radius: 10px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; flex-shrink: 0; }
.ac-activity-body { flex: 1; min-width: 0; }
.ac-activity-body h4 { font-size: 0.92rem; color: var(--ink); margin-bottom: 2px; }
.ac-activity-body p { font-size: 0.76rem; color: var(--slate-light); }
.ac-status-badge { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; padding: 4px 11px; border-radius: 20px; flex-shrink: 0; }
.ac-status-badge.disponible { background: rgba(31,122,77,0.1); color: #1F7A4D; }
.ac-status-badge.proximamente { background: var(--ivory-dim); color: var(--slate-light); }
.ac-status-badge.cerrada { background: rgba(179,65,59,0.08); color: #B3413B; }
.ac-status-badge.enviada { background: rgba(31,122,77,0.1); color: #1F7A4D; }
.ac-status-badge.borrador { background: rgba(184,148,46,0.12); color: #8A6D1E; }
.ac-status-badge.pendiente { background: var(--ivory-dim); color: var(--slate-light); }
.ac-status-badge.calificada { background: var(--gold-pale); color: var(--gold); }

/* Case reading card */
.ac-case-card { background: var(--white); border: 1px solid var(--line); border-radius: 14px; padding: 2rem 2.2rem; margin-bottom: 1.6rem; }
.ac-case-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 1.2rem; }
.ac-case-tag { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: var(--slate); background: var(--ivory-dim); padding: 5px 12px; border-radius: 20px; }
.ac-case-card h2 { font-family: var(--serif); font-size: 1.5rem; color: var(--ink); margin-bottom: 1.3rem; line-height: 1.3; }
.ac-case-card .body p { font-size: 0.97rem; color: var(--ink); line-height: 1.9; margin-bottom: 1.1rem; white-space: pre-line; }
.ac-case-doc-link { display: inline-flex; align-items: center; gap: 8px; font-size: 0.82rem; font-weight: 700; color: var(--gold); margin-top: 0.6rem; }

.ac-case-collapsed { margin-bottom: 1.6rem; }
.ac-case-collapsed > summary { cursor: pointer; list-style: none; font-size: 0.85rem; font-weight: 700; color: var(--gold); padding: 0.7rem 1rem; border: 1.5px solid var(--line); border-radius: 10px; background: var(--white); }
.ac-case-collapsed > summary::-webkit-details-marker { display: none; }
.ac-case-collapsed > summary::before { content: '▸ '; }
.ac-case-collapsed[open] > summary::before { content: '▾ '; }
.ac-case-collapsed[open] > summary { border-radius: 10px 10px 0 0; margin-bottom: 0; }

.ac-case-highlight { background: var(--ivory-dim); border-left: 3px solid var(--gold); border-radius: 0 10px 10px 0; padding: 1rem 1.3rem; margin: 1.2rem 0; }
.ac-case-highlight-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gold); margin-bottom: 0.6rem; }
.ac-case-highlight ul { margin: 0; padding-left: 1.1rem; }
.ac-case-highlight li { font-size: 0.9rem; color: var(--ink); line-height: 1.65; margin-bottom: 0.4rem; }
.ac-case-highlight li:last-child { margin-bottom: 0; }

.ac-case-toolbar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 1rem; }
.ac-case-toolbar .ac-deadline-badge { margin-bottom: 0; }
.ac-pdf-btn { display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem; font-weight: 700; color: var(--ink); background: var(--white); border: 1.5px solid var(--line); border-radius: 20px; padding: 7px 15px; transition: border-color 0.15s ease; }
.ac-pdf-btn:hover { border-color: var(--gold); color: var(--gold); }

/* Question form */
.ac-question-card { background: var(--white); border: 1px solid var(--line); border-radius: 12px; padding: 1.4rem 1.6rem; margin-bottom: 1rem; }
.ac-question-card .q-num { font-size: 0.68rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
.ac-question-card .q-text { font-size: 0.95rem; color: var(--ink); font-weight: 600; margin-bottom: 12px; line-height: 1.5; }
.ac-question-card textarea { width: 100%; min-height: 120px; border: 1px solid var(--line); border-radius: 8px; padding: 12px 14px; font-family: var(--sans); font-size: 0.88rem; color: var(--ink); resize: vertical; }
.ac-question-card textarea:focus { border-color: var(--gold); outline: none; }
.ac-question-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 10px; flex-wrap: wrap; gap: 10px; }
.ac-char-count { font-size: 0.72rem; color: var(--slate-light); }
.ac-question-actions { display: flex; gap: 8px; }
.ac-btn-ghost { padding: 9px 16px; border-radius: 20px; border: 1px solid var(--line); background: var(--white); font-size: 0.78rem; font-weight: 600; color: var(--ink); cursor: pointer; }
.ac-btn-ghost:hover { border-color: var(--gold); color: var(--gold); }
.ac-btn-solid { padding: 9px 18px; border-radius: 20px; border: none; background: var(--ink); color: var(--white); font-size: 0.78rem; font-weight: 700; cursor: pointer; }
.ac-btn-solid:hover { background: var(--gold); }
.ac-response-sent { background: rgba(31,122,77,0.06); border: 1px solid rgba(31,122,77,0.2); border-radius: 8px; padding: 12px 14px; font-size: 0.82rem; color: #1F7A4D; }
.ac-response-sent .when { display: block; font-size: 0.72rem; color: var(--slate); margin-top: 4px; }

/* Identify (quick name capture) */
.ac-id-card { background: var(--white); border: 1px solid var(--line); border-radius: 14px; padding: 2rem; max-width: 400px; width: 100%; text-align: left; }
.ac-id-card label { display: block; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-light); margin: 0 0 6px; }
.ac-id-card input { width: 100%; padding: 11px 14px; border: 1px solid var(--line); border-radius: 8px; font-size: 0.88rem; margin-bottom: 14px; }
.ac-id-card input:focus { border-color: var(--gold); outline: none; }

/* Floating CTA to /cursos */
.ac-float-cta { position: fixed; left: 22px; bottom: 22px; z-index: 150; display: flex; align-items: center; gap: 8px; background: var(--ink); color: var(--white); padding: 12px 18px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 0.82rem; box-shadow: 0 12px 30px rgba(11,24,41,0.3); animation: acFloatPulse 3.2s ease-in-out infinite; }
.ac-float-cta:hover { animation-play-state: paused; background: var(--gold); }
@keyframes acFloatPulse { 0%, 100% { box-shadow: 0 12px 30px rgba(11,24,41,0.3); } 50% { box-shadow: 0 12px 34px rgba(184,154,86,0.45); } }
.ac-float-cta span.short { display: none; }
@media (max-width: 560px) { .ac-float-cta span.full { display: none; } .ac-float-cta span.short { display: inline; } .ac-float-cta { padding: 12px 16px; } }

/* Mobile bottom nav for course pages */
.ac-mobile-nav { display: none; }
@media (max-width: 760px) {
  .ac-tabs-wrap { display: none; }
  .ac-mobile-nav { display: flex; position: sticky; top: 0; z-index: 60; background: var(--white); border-bottom: 1px solid var(--line); overflow-x: auto; }
  .ac-mobile-nav a, .ac-mobile-nav span { flex-shrink: 0; padding: 12px 14px; font-size: 0.78rem; font-weight: 600; color: var(--slate); border-bottom: 2px solid transparent; }
  .ac-mobile-nav a.active { color: var(--ink); border-bottom-color: var(--gold); }
  .ac-mobile-nav span { color: var(--slate-light); }
}

/* Form errors */
.ac-form-error { background: rgba(179,65,59,0.08); border: 1px solid rgba(179,65,59,0.25); color: #B3413B; border-radius: 8px; padding: 10px 14px; font-size: 0.82rem; margin-bottom: 14px; }

/* Deadline badge */
.ac-deadline-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 0.76rem; font-weight: 700; color: #B3413B; background: rgba(179,65,59,0.08); padding: 6px 13px; border-radius: 20px; margin-bottom: 1rem; }
.ac-deadline-badge.closed { color: var(--slate-light); background: var(--ivory-dim); }

/* Registration mode toggle */
.ac-mode-toggle { display: flex; gap: 10px; margin-bottom: 1.4rem; }
.ac-mode-btn { flex: 1; border: 1.5px solid var(--line); background: var(--white); border-radius: 12px; padding: 1rem; text-align: center; cursor: pointer; font-weight: 700; font-size: 0.88rem; color: var(--slate); transition: border-color 0.15s ease, color 0.15s ease; }
.ac-mode-btn.active { border-color: var(--gold); color: var(--ink); background: var(--gold-pale); }
.ac-mode-btn small { display: block; font-weight: 500; font-size: 0.72rem; color: var(--slate-light); margin-top: 3px; }

/* Group member rows */
.ac-member-row { display: grid; grid-template-columns: 1.2fr 1.2fr 1fr auto; gap: 8px; margin-bottom: 8px; align-items: center; }
@media (max-width: 720px) { .ac-member-row { grid-template-columns: 1fr; } }
.ac-member-row input { padding: 10px 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 0.85rem; }
.ac-member-row input:focus { border-color: var(--gold); outline: none; }
.ac-member-remove { background: none; border: none; color: var(--slate-light); cursor: pointer; font-size: 1.1rem; padding: 4px 8px; }
.ac-member-remove:hover { color: #B3413B; }
.ac-member-add { display: inline-flex; align-items: center; gap: 6px; background: none; border: 1px dashed var(--line); border-radius: 8px; padding: 9px 14px; font-size: 0.82rem; font-weight: 700; color: var(--gold); cursor: pointer; margin-top: 4px; }
.ac-member-add:hover { border-color: var(--gold); }

/* Group code banner */
.ac-group-code-banner { background: var(--ink); color: var(--white); border-radius: 12px; padding: 1.2rem 1.4rem; margin-bottom: 1.4rem; text-align: center; }
.ac-group-code-banner .label { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(255,255,255,0.6); margin-bottom: 4px; }
.ac-group-code-banner .code { font-family: var(--serif); font-size: 1.5rem; font-weight: 700; color: var(--gold-light); letter-spacing: 0.02em; }
.ac-group-code-banner .hint { font-size: 0.76rem; color: rgba(255,255,255,0.7); margin-top: 6px; }

/* Drag and drop game */
.ac-game { background: var(--white); border: 1px solid var(--line); border-radius: 14px; padding: 1.8rem 1.8rem 1.6rem; margin-bottom: 1.6rem; }
.ac-game h3 { font-family: var(--serif); font-size: 1.1rem; color: var(--ink); margin-bottom: 4px; }
.ac-game .ac-game-hint { font-size: 0.82rem; color: var(--slate); margin-bottom: 1.2rem; line-height: 1.55; }
.ac-dnd-chips { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 1.4rem; min-height: 46px; padding: 10px; background: var(--ivory-dim); border-radius: 10px; }
.ac-dnd-chip { touch-action: none; user-select: none; cursor: grab; background: var(--white); border: 1.5px solid var(--gold); color: var(--ink); font-size: 0.8rem; font-weight: 600; padding: 9px 14px; border-radius: 20px; box-shadow: 0 2px 6px rgba(11,24,41,0.06); }
.ac-dnd-chip.dragging { opacity: 0.4; }
.ac-dnd-chip.placed { cursor: default; border-color: #1F7A4D; }
.ac-dnd-zones { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; }
.ac-dnd-zone { border: 1.5px dashed var(--line); border-radius: 12px; padding: 12px; min-height: 100px; background: var(--ivory); transition: border-color 0.15s ease, background 0.15s ease; }
.ac-dnd-zone.over { border-color: var(--gold); background: var(--gold-pale); }
.ac-dnd-zone .zone-title { font-size: 0.76rem; font-weight: 700; color: var(--slate); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 8px; }
.ac-dnd-zone .zone-chips { display: flex; flex-wrap: wrap; gap: 6px; }
.ac-game-feedback { margin-top: 1rem; font-size: 0.82rem; padding: 10px 14px; border-radius: 8px; display: none; }
.ac-game-feedback.ok { display: block; background: rgba(31,122,77,0.08); color: #1F7A4D; }
.ac-game-feedback.warn { display: block; background: rgba(184,148,46,0.1); color: #8A6D1E; }

/* Registration/read-only member list on interactive page */
.ac-team-chip { display: inline-flex; align-items: center; gap: 6px; background: var(--ivory-dim); border-radius: 20px; padding: 5px 12px; font-size: 0.78rem; color: var(--ink); margin: 0 6px 6px 0; }

/* Score banner (shown only after the activity has been submitted) */
.ac-score-banner { background: var(--ink); color: var(--white); border-radius: 14px; padding: 1.4rem 1.6rem; margin-bottom: 1.6rem; text-align: center; }
.ac-score-banner .score-value { font-family: var(--serif); font-size: 2rem; font-weight: 700; color: var(--gold-light); line-height: 1; }
.ac-score-banner .score-value small { font-family: var(--sans); font-size: 0.9rem; font-weight: 500; color: rgba(255,255,255,0.7); }
.ac-score-banner .score-percent { font-size: 0.86rem; color: rgba(255,255,255,0.85); margin-top: 8px; }
.ac-score-banner .score-note { font-size: 0.74rem; color: rgba(255,255,255,0.55); margin-top: 8px; }
.ac-score-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px; margin-top: 1.2rem; padding-top: 1.1rem; border-top: 1px solid rgba(255,255,255,0.15); text-align: left; }
.ac-score-stat .stat-row { display: flex; justify-content: space-between; align-items: baseline; font-size: 0.76rem; margin-bottom: 5px; }
.ac-score-stat .stat-label { color: rgba(255,255,255,0.8); font-weight: 600; }
.ac-score-stat .stat-value { color: var(--gold-light); font-weight: 700; }
.ac-score-stat .stat-bar { height: 6px; border-radius: 4px; background: rgba(255,255,255,0.15); overflow: hidden; }
.ac-score-stat .stat-fill { height: 100%; background: var(--gold-light); border-radius: 4px; }

/* Exercises section */
.ac-ex-section { margin-bottom: 1.8rem; }
.ac-ex-section > h3 { font-family: var(--serif); font-size: 1.15rem; color: var(--ink); margin-bottom: 6px; }
.ac-ex-intro { font-size: 0.85rem; color: var(--slate); margin-bottom: 1.2rem; line-height: 1.55; }
.ac-ex-card { background: var(--white); border: 1px solid var(--line); border-radius: 14px; padding: 1.5rem 1.6rem; margin-bottom: 1.1rem; }
.ac-ex-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 1rem; }
.ac-ex-prompt { font-size: 0.94rem; color: var(--ink); font-weight: 600; line-height: 1.5; }
.ac-ex-points { flex-shrink: 0; font-size: 0.66rem; font-weight: 700; text-transform: uppercase; color: var(--gold); background: var(--gold-pale); padding: 4px 10px; border-radius: 12px; white-space: nowrap; }
.ac-ex-statement { font-size: 0.98rem; color: var(--ink); font-style: italic; background: var(--ivory-dim); border-radius: 10px; padding: 0.9rem 1.1rem; margin-bottom: 1.1rem; line-height: 1.6; }
.ac-ex-hint { font-size: 0.78rem; color: var(--slate-light); margin-top: 0.9rem; }

/* V/F */
.ac-vf-row { display: flex; gap: 10px; }
.ac-vf-btn { flex: 1; min-height: 46px; border: 1.5px solid var(--line); background: var(--white); color: var(--slate); font-weight: 700; font-size: 0.9rem; padding: 0.85rem; border-radius: 10px; cursor: pointer; transition: border-color 0.15s ease, background 0.15s ease, color 0.15s ease; }
.ac-vf-btn:hover:not(:disabled) { border-color: var(--gold); }
.ac-vf-btn.selected { border-color: var(--gold); background: var(--gold-pale); color: var(--ink); }
.ac-vf-btn.answer-correct { border-color: #1F7A4D; background: rgba(31,122,77,0.1); color: #1F7A4D; }
.ac-vf-btn.answer-wrong { border-color: #B3413B; background: rgba(179,65,59,0.08); color: #B3413B; }
.ac-vf-btn:disabled { cursor: default; opacity: 0.9; }

/* MCQ */
.ac-mcq-list { display: flex; flex-direction: column; gap: 8px; }
.ac-mcq-opt { text-align: left; min-height: 44px; border: 1.5px solid var(--line); background: var(--white); color: var(--ink); font-size: 0.88rem; padding: 0.8rem 1rem; border-radius: 10px; cursor: pointer; transition: border-color 0.15s ease, background 0.15s ease; }
.ac-mcq-opt:hover:not(:disabled) { border-color: var(--gold); }
.ac-mcq-opt.selected { border-color: var(--gold); background: var(--gold-pale); font-weight: 700; }
.ac-mcq-opt.answer-correct { border-color: #1F7A4D; background: rgba(31,122,77,0.1); color: #1F7A4D; font-weight: 700; }
.ac-mcq-opt.answer-wrong { border-color: #B3413B; background: rgba(179,65,59,0.08); color: #B3413B; }
.ac-mcq-opt:disabled { cursor: default; opacity: 0.92; }

/* Fill in the blank */
.ac-fill-text { font-size: 0.98rem; color: var(--ink); background: var(--ivory-dim); border-radius: 10px; padding: 1.1rem 1.2rem; line-height: 2.2; }
.ac-fill-options { display: inline-flex; flex-wrap: wrap; gap: 6px; margin: 4px 4px 8px; vertical-align: middle; }
.ac-fill-opt { min-height: 42px; border: 1.5px solid var(--line); background: var(--white); color: var(--ink); font-size: 0.85rem; font-weight: 600; padding: 0.6rem 0.95rem; border-radius: 20px; cursor: pointer; transition: border-color 0.15s ease, background 0.15s ease, color 0.15s ease; }
.ac-fill-opt:hover:not(:disabled) { border-color: var(--gold); }
.ac-fill-opt.selected { border-color: var(--gold); background: var(--gold-pale); color: var(--ink); }
.ac-fill-opt.is-correct-answer { border-color: #1F7A4D; background: rgba(31,122,77,0.1); color: #1F7A4D; }
.ac-fill-opt.is-wrong-pick { border-color: #B3413B; background: rgba(179,65,59,0.08); color: #B3413B; }
.ac-fill-opt:disabled { cursor: default; opacity: 0.92; }

/* Matching (drag and drop) */
.ac-match-tray { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 1rem; min-height: 50px; padding: 12px; background: var(--ivory-dim); border-radius: 10px; }
.ac-match-drag-chip { touch-action: manipulation; user-select: none; -webkit-user-select: none; -webkit-touch-callout: none; cursor: pointer; background: var(--white); border: 1.5px solid var(--gold); color: var(--ink); font-size: 0.82rem; font-weight: 600; line-height: 1.4; padding: 0.7rem 0.95rem; min-height: 44px; box-sizing: border-box; display: flex; align-items: center; border-radius: 12px; box-shadow: 0 2px 6px rgba(11,24,41,0.06); transition: box-shadow 0.15s ease, transform 0.15s ease; }
.ac-match-drag-chip.picked { border-color: var(--gold); background: var(--gold-pale); box-shadow: 0 0 0 3px rgba(139,115,64,0.28); transform: translateY(-1px); }
.ac-match-drag-chip.placed { cursor: pointer; border-color: #1F7A4D; }
.ac-match-drag-chip[disabled] { cursor: default; }
.ac-match-drag-chip.answer-correct { border-color: #1F7A4D !important; background: rgba(31,122,77,0.1) !important; }
.ac-match-drag-chip.answer-wrong { border-color: #B3413B !important; background: rgba(179,65,59,0.08) !important; }
.ac-match-zones { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; }
.ac-match-zone { border: 1.5px dashed var(--line); border-radius: 12px; padding: 12px; min-height: 90px; background: var(--ivory); transition: border-color 0.15s ease, background 0.15s ease; cursor: pointer; }
.ac-match-zone .zone-title { font-size: 0.76rem; font-weight: 700; color: var(--slate); text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 8px; }
.ac-match-zone .zone-chips { display: flex; flex-wrap: wrap; gap: 6px; min-height: 6px; }
.ac-match-correct-note { margin-top: 6px; font-size: 0.74rem; color: #B3413B; font-weight: 600; }
@media (max-width: 480px) { .ac-match-drag-chip { width: 100%; } }

/* Ordering (drag and drop, with up/down fallback) */
.ac-order-list { display: flex; flex-direction: column; gap: 8px; }
.ac-order-row { display: flex; align-items: center; gap: 10px; border: 1.5px solid var(--line); background: var(--white); border-radius: 10px; padding: 0.75rem 0.9rem; min-height: 44px; box-sizing: border-box; }
.ac-order-row.answer-correct { border-color: #1F7A4D; background: rgba(31,122,77,0.08); }
.ac-order-row.answer-wrong { border-color: #B3413B; background: rgba(179,65,59,0.06); }
.ac-order-num { flex-shrink: 0; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; background: var(--ink); color: var(--white); font-size: 0.72rem; font-weight: 700; border-radius: 50%; }
.ac-order-text { flex: 1; font-size: 0.86rem; color: var(--ink); line-height: 1.45; }
.ac-order-controls { display: flex; gap: 6px; flex-shrink: 0; }
.ac-order-btn { width: 44px; height: 44px; border: 1px solid var(--line); background: var(--white); border-radius: 8px; cursor: pointer; font-size: 1.1rem; color: var(--slate); touch-action: manipulation; }
.ac-order-btn:hover:not(:disabled) { border-color: var(--gold); color: var(--gold); }
.ac-order-btn:active:not(:disabled) { background: var(--gold-pale); }
.ac-order-btn:disabled { opacity: 0.35; cursor: default; }

/* Memory / flip-card game */
.ac-memory-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin: 0.4rem 0 1rem; }
@media (max-width: 560px) { .ac-memory-grid { grid-template-columns: repeat(2, 1fr); } }
.ac-memory-card { aspect-ratio: 3 / 4; cursor: pointer; perspective: 700px; touch-action: manipulation; }
.ac-memory-card-inner { position: relative; width: 100%; height: 100%; transition: transform 0.45s; transform-style: preserve-3d; }
.ac-memory-card.flipped .ac-memory-card-inner, .ac-memory-card.matched .ac-memory-card-inner { transform: rotateY(180deg); }
.ac-memory-card-front, .ac-memory-card-back { position: absolute; inset: 0; backface-visibility: hidden; -webkit-backface-visibility: hidden; border-radius: 12px; display: flex; align-items: center; justify-content: center; padding: 8px; text-align: center; box-sizing: border-box; }
.ac-memory-card-front { background: var(--ink); font-size: 1.6rem; box-shadow: 0 2px 6px rgba(11,24,41,0.15); }
.ac-memory-card-back { background: var(--white); border: 1.5px solid var(--gold); color: var(--ink); font-size: 0.74rem; font-weight: 600; line-height: 1.3; transform: rotateY(180deg); }
.ac-memory-card.matched .ac-memory-card-back { background: var(--gold-pale); border-color: #1F7A4D; color: #1F7A4D; }
.ac-memory-card.matched { cursor: default; }

.ac-memory-review { display: flex; flex-direction: column; gap: 8px; margin: 0.4rem 0 1rem; }
.ac-memory-review-row { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px; font-size: 0.82rem; border: 1px solid var(--line); }
.ac-memory-review-row.answer-correct { border-color: #1F7A4D; background: rgba(31,122,77,0.08); }
.ac-memory-review-row.answer-wrong { border-color: #B3413B; background: rgba(179,65,59,0.06); }
.ac-memory-review-text { flex: 1; color: var(--ink); }
.ac-memory-review-link { color: var(--slate-light); flex-shrink: 0; }
.ac-order-correct-note { margin-top: 8px; font-size: 0.78rem; color: #B3413B; font-weight: 600; }

/* Critical-response section (excluded from the automatic score) */
.ac-critica-section { margin-bottom: 1.6rem; }
.ac-critica-head { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 4px; }
.ac-critica-head h3 { font-family: var(--serif); font-size: 1.1rem; color: var(--ink); margin: 0; }
.ac-optional-notice { font-size: 0.8rem; color: var(--gold); background: var(--gold-pale); border-radius: 10px; padding: 0.7rem 1rem; margin-bottom: 1.2rem; line-height: 1.5; }
.ac-critica-badge { font-size: 0.64rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em; color: var(--slate); background: var(--ivory-dim); padding: 4px 10px; border-radius: 12px; }

/* Autosave status */
.ac-autosave-status { display: block; width: 100%; font-size: 0.76rem; color: var(--slate-light); margin-bottom: 4px; }
@media (min-width: 640px) { .ac-autosave-status { width: auto; margin-right: auto; margin-bottom: 0; align-self: center; } }

/* Mobile tightening for the interactive case page */
@media (max-width: 480px) {
  .ac-case-card { padding: 1.5rem 1.3rem; }
  .ac-ex-card { padding: 1.2rem 1.1rem; }
  .ac-question-card { padding: 1.2rem 1.2rem; }
  .ac-ex-header { flex-direction: column; gap: 6px; }
  .ac-ex-points { align-self: flex-start; }
  .ac-question-actions { flex-direction: column; align-items: stretch; }
  .ac-question-actions button { width: 100%; }
  .ac-score-banner { padding: 1.2rem 1.1rem; }
  .ac-score-banner .score-value { font-size: 1.6rem; }
  .ac-case-collapsed > summary { font-size: 0.8rem; padding: 0.65rem 0.9rem; }
  .ac-modal-btn-row { flex-direction: column; }
}

.ac-modal-btn-row { display: flex; gap: 10px; }

/* Access-code gate, shown as a blurred-backdrop modal window over the course page */
.ac-gate-box { max-width: 420px; text-align: left; }
.ac-gate-box h3 { font-family: var(--serif); font-size: 1.3rem; color: var(--ink); margin-bottom: 0.4rem; }
.ac-gate-form label { display: block; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-light); margin: 0 0 6px; }
.ac-gate-form input[type="text"] { width: 100%; box-sizing: border-box; padding: 12px 14px; border: 1px solid var(--line); border-radius: 8px; font-size: 0.95rem; margin-bottom: 14px; }
.ac-gate-form input[type="text"]:focus { border-color: var(--gold); outline: none; }
@media (max-width: 480px) {
  .ac-gate-box { padding: 1.6rem; }
}
