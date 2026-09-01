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
.ac-campus-nav { display: flex; gap: 1.2rem; font-size: 0.82rem; }
.ac-campus-nav a { color: var(--slate); font-weight: 600; }
.ac-campus-nav a:hover { color: var(--gold); }

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
.ac-case-card h2 { font-family: var(--serif); font-size: 1.4rem; color: var(--ink); margin-bottom: 1.2rem; }
.ac-case-card .body p { font-size: 0.92rem; color: var(--ink); line-height: 1.85; margin-bottom: 1rem; white-space: pre-line; }
.ac-case-doc-link { display: inline-flex; align-items: center; gap: 8px; font-size: 0.82rem; font-weight: 700; color: var(--gold); margin-top: 0.6rem; }

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
