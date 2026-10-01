.tr-shell { background: var(--ivory); min-height: calc(100vh - 71px); padding-bottom: 5rem; }

/* HERO */
.tr-hero { background: linear-gradient(135deg, var(--ink) 0%, #16283F 55%, #1D3452 100%); padding: 3.2rem 0 3.6rem; position: relative; overflow: hidden; }
.tr-hero::after { content: ''; position: absolute; top: -40%; right: -10%; width: 420px; height: 420px; background: radial-gradient(circle, rgba(201,169,97,0.22), transparent 70%); pointer-events: none; }
.tr-hero-badge { display: inline-flex; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--ink); background: linear-gradient(135deg, var(--gold-light), var(--gold)); padding: 6px 14px; border-radius: 20px; margin-bottom: 1.1rem; max-width: 100%; }
.tr-hero-title { font-family: var(--serif); font-size: clamp(1.6rem, 3.6vw, 2.4rem); color: var(--white); font-weight: 600; line-height: 1.25; margin-bottom: 0.6rem; max-width: 760px; }
.tr-hero-sub { font-size: 0.92rem; color: rgba(255,255,255,0.6); max-width: 680px; line-height: 1.6; margin-bottom: 1.8rem; }
.tr-hero-meta { display: flex; flex-wrap: wrap; gap: 2rem; }
.tr-hero-meta-item { display: flex; flex-direction: column; gap: 3px; }
.tr-hero-meta-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: rgba(255,255,255,0.4); }
.tr-hero-meta-value { font-size: 0.86rem; color: var(--white); font-weight: 600; }

/* BODY LAYOUT */
.tr-body { display: grid; grid-template-columns: 1fr 320px; gap: 1.6rem; margin-top: -1.8rem; position: relative; z-index: 2; align-items: start; }
.tr-main { display: flex; flex-direction: column; gap: 1.2rem; }
.tr-card { background: var(--white); border: 1px solid var(--line); border-radius: 14px; padding: 1.8rem 2rem; box-shadow: var(--shadow-s); }
.tr-card-title { font-family: var(--serif); font-size: 1.2rem; color: var(--ink); margin-bottom: 0.5rem; }
.tr-card-sub { font-size: 0.85rem; color: var(--slate); margin-bottom: 1.1rem; line-height: 1.6; }
.tr-intro { font-size: 0.9rem; color: var(--slate); line-height: 1.8; }

/* MATERIALS */
.tr-materials { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.9rem; }
.tr-material-card { display: flex; align-items: center; gap: 12px; padding: 1rem 1.1rem; border: 1.5px solid var(--line); border-radius: 10px; transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease; background: var(--ivory); }
.tr-material-card:hover { border-color: var(--gold); transform: translateY(-2px); box-shadow: 0 10px 24px rgba(11,24,41,0.08); }
.tr-material-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--gold-pale); color: var(--gold); }
.tr-material-icon svg { width: 22px; height: 22px; }
.tr-material-body { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
.tr-material-label { font-size: 0.82rem; font-weight: 700; color: var(--ink); line-height: 1.3; }
.tr-material-type { font-size: 0.68rem; color: var(--slate-light); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }

/* GLOSSARY ROW */
.tr-glossary-row { display: flex; align-items: center; justify-content: space-between; gap: 1.2rem; flex-wrap: wrap; }

/* BUTTONS */
.tr-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 22px; border-radius: 8px; font-family: var(--sans); font-size: 0.84rem; font-weight: 700; cursor: pointer; transition: all 0.25s ease; text-decoration: none; border: none; }
.tr-btn-solid { background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--ink); }
.tr-btn-solid:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(184,154,86,0.35); }
.tr-btn-outline { background: var(--white); border: 1.5px solid var(--line); color: var(--ink); }
.tr-btn-outline:hover { border-color: var(--gold); color: var(--gold); }
.tr-btn-block { width: 100%; }

/* SIDEBAR CTA */
.tr-side { position: sticky; top: 90px; }
.tr-cta-card { background: var(--white); border: 1.5px solid rgba(139,115,64,0.3); border-radius: 14px; padding: 1.8rem; box-shadow: var(--shadow-m); }
.tr-cta-icon { width: 48px; height: 48px; border-radius: 12px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
.tr-cta-icon svg { width: 24px; height: 24px; }
.tr-cta-card h3 { font-family: var(--serif); font-size: 1.1rem; color: var(--ink); margin-bottom: 0.6rem; }
.tr-cta-card p { font-size: 0.83rem; color: var(--slate); line-height: 1.6; margin-bottom: 0.9rem; }
.tr-cta-note { font-size: 0.76rem !important; color: var(--slate-light) !important; background: var(--ivory-dim); padding: 0.6rem 0.8rem; border-radius: 8px; }

/* GLOSSARY MODAL */
.tr-glossary-overlay { position: fixed; inset: 0; background: rgba(11,24,41,0.55); backdrop-filter: blur(3px); z-index: 300; display: none; align-items: flex-start; justify-content: center; padding: 4vh 20px; }
.tr-glossary-overlay.active { display: flex; }
.tr-glossary-modal { background: var(--white); border-radius: 16px; width: 100%; max-width: 640px; max-height: 88vh; display: flex; flex-direction: column; box-shadow: 0 30px 80px rgba(0,0,0,0.3); animation: trModalIn 0.25s ease; }
@keyframes trModalIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
.tr-glossary-header { display: flex; align-items: center; justify-content: space-between; padding: 1.3rem 1.6rem; border-bottom: 1px solid var(--line); }
.tr-glossary-header h3 { font-family: var(--serif); font-size: 1.15rem; color: var(--ink); }
.tr-glossary-close { background: none; border: none; font-size: 1.6rem; line-height: 1; color: var(--slate-light); cursor: pointer; padding: 0 4px; }
.tr-glossary-close:hover { color: var(--ink); }
.tr-glossary-search { display: flex; align-items: center; gap: 10px; padding: 1rem 1.6rem; border-bottom: 1px solid var(--line); color: var(--slate-light); }
.tr-glossary-search input { flex: 1; border: none; outline: none; font-size: 0.9rem; font-family: var(--sans); color: var(--ink); background: transparent; }
.tr-glossary-list { overflow-y: auto; padding: 0.6rem 1.6rem 1.6rem; flex: 1; }
.tr-glossary-item { padding: 1rem 0; border-bottom: 1px solid var(--line); }
.tr-glossary-item:last-child { border-bottom: none; }
.tr-glossary-item h4 { font-size: 0.92rem; color: var(--gold); font-weight: 700; margin-bottom: 4px; }
.tr-glossary-item p { font-size: 0.83rem; color: var(--slate); line-height: 1.6; }
.tr-glossary-example { margin-top: 6px; background: var(--ivory-dim); border-left: 3px solid var(--gold); padding: 8px 12px; border-radius: 0 6px 6px 0; }
.tr-glossary-empty { text-align: center; color: var(--slate-light); font-size: 0.85rem; padding: 2rem 0; }

@media (max-width: 900px) {
  .tr-body { grid-template-columns: 1fr; }
  .tr-side { position: static; }
  .tr-materials { grid-template-columns: 1fr; }
  .tr-card { padding: 1.5rem 1.3rem; }
}
