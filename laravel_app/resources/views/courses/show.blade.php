@extends('layouts.app')

@section('title', $course->title.' — Romani Compliance')

@php
  $rdGreetingWord = 'Bienvenido';
  $rdDisplayFirstName = '';
  if (auth()->check()) {
      $rdFirstNameRaw = trim(explode(' ', trim(auth()->user()->name))[0] ?? '');
      $rdDisplayFirstName = mb_convert_case(mb_strtolower($rdFirstNameRaw), MB_CASE_TITLE, 'UTF-8');
      $rdFirstName = mb_strtolower($rdFirstNameRaw);
      $rdFemaleNames = ['rosario', 'laura', 'maria', 'ana', 'carmen', 'lucia', 'sofia', 'valentina', 'camila',
          'daniela', 'gabriela', 'alejandra', 'andrea', 'patricia', 'claudia', 'monica', 'sandra',
          'karen', 'diana', 'paola', 'fiorella', 'milagros', 'jazmin', 'katherine', 'melissa', 'carla',
          'natalia', 'veronica', 'silvia', 'teresa', 'rosa', 'elena', 'julia', 'kyra'];
      $rdMaleEndingA = ['joshua', 'noa', 'luca', 'matias', 'elias', 'jonas', 'tobias'];
      if (in_array($rdFirstName, $rdFemaleNames, true) || (str_ends_with($rdFirstName, 'a') && ! in_array($rdFirstName, $rdMaleEndingA, true))) {
          $rdGreetingWord = 'Bienvenida';
      }
  }

  $allLessons = $course->modules->flatMap->lessons;
  $totalLessons = $allLessons->count();
  $totalDuration = $allLessons->sum('duration_minutes');
  $examQuestions = $course->exam?->questions->count() ?? 0;
  $isOptionalCert = ($course->certificate_type ?? 'gratuita') === 'opcional';

  $formulasPreview = null;
  foreach ($allLessons as $l) {
      if ($l->type === 'interactive' && $l->content) {
          $decoded = json_decode($l->content, true);
          if (($decoded['kind'] ?? null) === 'formulas') { $formulasPreview = $decoded; break; }
      }
  }
@endphp

@section('styles')
:root { --rd-accent: #8B7340; }

.rd-fade-up { animation: rd-fadeUp 0.7s cubic-bezier(0.22,1,0.36,1) both; }
@keyframes rd-fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
.rd-delay-1 { animation-delay: 0.08s; } .rd-delay-2 { animation-delay: 0.16s; } .rd-delay-3 { animation-delay: 0.24s; } .rd-delay-4 { animation-delay: 0.32s; }
@keyframes rd-spin { to { transform: rotate(360deg); } }

.rd-hero { position: relative; background: radial-gradient(120% 100% at 85% 0%, #16283F 0%, #0B1829 55%), var(--ink); padding: 4rem 0 3.2rem; overflow: hidden; }
.rd-hero::after { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(184,154,86,0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(184,154,86,0.06) 1px, transparent 1px); background-size: 42px 42px; mask-image: radial-gradient(ellipse at 75% 20%, black 0%, transparent 65%); pointer-events: none; }
.rd-hero-grid { position: relative; display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 2.5rem; align-items: center; }
.rd-badge-company { display: inline-flex; align-items: center; gap: 8px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--gold-light); background: rgba(184,154,86,0.1); border: 1px solid rgba(184,154,86,0.3); padding: 6px 14px; border-radius: 30px; margin-bottom: 1.2rem; }
.rd-badge-company .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--gold-light); }
.rd-hero h1 { font-weight: 800; font-size: clamp(1.7rem, 3.6vw, 2.6rem); line-height: 1.18; color: var(--white); letter-spacing: -0.02em; margin-bottom: 1rem; }
.rd-hero p.rd-sub { font-size: 0.95rem; color: rgba(255,255,255,0.6); line-height: 1.75; max-width: 520px; margin-bottom: 1.6rem; }
.rd-cert-clarify { background: rgba(184,154,86,0.1); border: 1px solid rgba(184,154,86,0.3); border-radius: 6px; padding: 10px 14px; font-size: 0.82rem; color: rgba(255,255,255,0.75); margin-bottom: 1.2rem; max-width: 500px; }
.rd-cert-clarify strong { color: var(--gold-light); }
.rd-meta-row { display: flex; gap: 1.8rem; flex-wrap: wrap; margin-bottom: 2rem; }
.rd-meta-item .k { font-size: 0.65rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px; }
.rd-meta-item .v { font-size: 0.95rem; color: var(--white); font-weight: 600; }
.rd-cta-row { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
.rd-btn-primary { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--ink); font-weight: 700; font-size: 0.92rem; padding: 15px 32px; border-radius: 8px; border: none; cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease; box-shadow: 0 8px 24px rgba(184,154,86,0.25); }
.rd-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(184,154,86,0.35); }
.rd-btn-secondary { display: inline-flex; align-items: center; gap: 8px; background: transparent; color: var(--white); font-weight: 700; font-size: 0.88rem; padding: 14px 26px; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.3); transition: border-color 0.2s ease, background 0.2s ease; }
.rd-btn-secondary:hover { border-color: var(--gold-light); background: rgba(184,154,86,0.12); }
.rd-progress-chip { font-size: 0.78rem; color: rgba(255,255,255,0.55); }
.rd-login-note { display: block; margin-top: 8px; font-size: 0.74rem; color: rgba(255,255,255,0.4); }
.rd-login-note a { color: var(--gold-light); font-weight: 600; }

/* Floating "take the quiz / get certified" CTA */
.floating-quiz-cta { position: fixed; left: 22px; bottom: 22px; z-index: 190; display: flex; align-items: center; gap: 10px; background: linear-gradient(135deg, var(--gold-light), var(--gold)); color: var(--ink); padding: 13px 18px 13px 16px; border-radius: 50px; box-shadow: 0 16px 36px rgba(184,154,86,0.4); text-decoration: none; font-weight: 700; font-size: 0.82rem; animation: fqcPulse 2.8s ease-in-out infinite; transition: transform 0.2s ease, box-shadow 0.2s ease; }
.floating-quiz-cta:hover { transform: translateY(-3px); box-shadow: 0 20px 44px rgba(184,154,86,0.5); animation-play-state: paused; }
.floating-quiz-cta .fqc-icon { width: 30px; height: 30px; border-radius: 50%; background: rgba(11,24,41,0.12); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.floating-quiz-cta .fqc-icon svg { width: 16px; height: 16px; }
.floating-quiz-cta .fqc-text { display: flex; flex-direction: column; line-height: 1.25; }
.floating-quiz-cta .fqc-text small { font-weight: 500; opacity: 0.75; font-size: 0.68rem; }
.floating-quiz-close { position: absolute; top: -7px; right: -7px; width: 20px; height: 20px; border-radius: 50%; background: var(--ink); color: var(--white); border: 2px solid var(--white); font-size: 0.66rem; line-height: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; }
@keyframes fqcPulse { 0%, 100% { box-shadow: 0 16px 36px rgba(184,154,86,0.4); } 50% { box-shadow: 0 16px 44px rgba(184,154,86,0.65); } }
@media (max-width: 640px) { .floating-quiz-cta { left: 14px; bottom: 14px; padding: 11px 16px 11px 14px; } .floating-quiz-cta .fqc-text small { display: none; } }

.rd-illustration { position: relative; }
.rd-illustration svg { width: 100%; height: auto; filter: drop-shadow(0 20px 50px rgba(0,0,0,0.35)); }
@media (max-width: 900px) {
  .rd-hero-grid { grid-template-columns: 1fr; }
  .rd-illustration { max-width: 300px; margin: 0 auto; order: -1; }
}

/* ---- Stats bar ---- */
.stats-section { background: var(--white); border-bottom: 1px solid var(--line); padding: 1.6rem 0; }
.stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 0; }
.stat-pill { text-align: center; padding: 0 1rem; border-right: 1px solid var(--line); }
.stat-pill:last-child { border-right: none; }
.stat-pill .num { display: block; font-family: var(--serif); font-size: 1.8rem; font-weight: 700; color: var(--ink); }
.stat-pill .lbl { font-size: 0.68rem; color: var(--slate); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 2px; }
@media (max-width: 700px) { .stats-row { grid-template-columns: repeat(2, 1fr); row-gap: 1.2rem; } .stat-pill:nth-child(2n) { border-right: none; } }

.rd-section { padding: 3.6rem 0; }
.rd-section-alt { background: var(--ivory-dim); }
.rd-eyebrow { font-size: 0.7rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.6rem; }
.rd-section h2 { font-weight: 800; font-size: clamp(1.35rem, 3vw, 1.8rem); letter-spacing: -0.01em; margin-bottom: 0.6rem; }
.rd-section-lead { color: var(--slate); font-size: 0.9rem; max-width: 600px; margin-bottom: 1.6rem; }

/* ---- Learning outcomes ---- */
.learn-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 12px; }
.learn-item { display: flex; align-items: flex-start; gap: 10px; background: var(--white); border: 1px solid var(--line); border-radius: 8px; padding: 14px 16px; font-size: 0.85rem; color: var(--ink); line-height: 1.5; }
.learn-item svg { width: 16px; height: 16px; flex-shrink: 0; color: #1F7A4D; margin-top: 2px; }

/* ---- Module cards ---- */
.rd-modules { display: grid; gap: 1rem; margin-top: 0.5rem; }
.rd-module-card { display: grid; grid-template-columns: auto 1fr; gap: 1.2rem; background: var(--white); border: 1px solid var(--line); border-radius: 12px; padding: 1.5rem 1.7rem; transition: border-color 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease; }
.rd-module-card:hover { border-color: var(--gold); transform: translateY(-3px); box-shadow: 0 12px 30px rgba(11,24,41,0.08); }

/* ---- Subject-type picker (two-pane) ---- */
.ss-picker { display: grid; grid-template-columns: 1fr 1.3fr; gap: 1.4rem; background: var(--white); border: 1px solid var(--line); border-radius: 14px; overflow: hidden; box-shadow: 0 10px 30px rgba(11,24,41,0.05); }
.ss-picker-list { border-right: 1px solid var(--line); max-height: 480px; overflow-y: auto; padding: 8px; }
.ss-picker-item { width: 100%; display: flex; align-items: center; gap: 10px; padding: 12px 12px; border-radius: 9px; border: none; background: none; text-align: left; cursor: pointer; font-size: 0.85rem; font-weight: 600; color: var(--ink); transition: background 0.15s; }
.ss-picker-item:hover { background: var(--ivory); }
.ss-picker-item.active { background: var(--gold-pale); color: var(--gold); }
.ss-picker-icon { font-size: 1.1rem; flex-shrink: 0; }
.ss-picker-label { flex: 1; line-height: 1.3; }
.ss-picker-chevron { width: 14px; height: 14px; flex-shrink: 0; opacity: 0.4; }
.ss-picker-item.active .ss-picker-chevron { opacity: 1; }
.ss-picker-detail { padding: 2rem 1.8rem; display: flex; align-items: center; }
.ss-picker-empty { text-align: center; color: var(--slate-light); font-size: 0.85rem; margin: 0 auto; max-width: 280px; }
.ss-picker-empty span { font-size: 1.8rem; display: block; margin-bottom: 10px; }
.ss-picker-content { width: 100%; }
.ss-picker-eyebrow { font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gold); margin-bottom: 6px; }
.ss-picker-content h3 { font-family: var(--serif); font-size: 1.2rem; color: var(--ink); margin-bottom: 10px; }
.ss-picker-content p { font-size: 0.88rem; color: var(--slate); line-height: 1.7; }
.ss-adapt { display: none; align-items: flex-start; gap: 12px; background: rgba(31,122,77,0.08); border: 1px solid rgba(31,122,77,0.25); border-radius: 10px; padding: 14px 18px; margin-top: 1rem; }
.ss-adapt-icon { width: 24px; height: 24px; border-radius: 50%; background: #1F7A4D; color: var(--white); font-size: 0.8rem; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ss-adapt strong { display: block; font-size: 0.85rem; color: #1F7A4D; margin-bottom: 3px; }
.ss-adapt p { font-size: 0.85rem; color: var(--ink); line-height: 1.6; }
@media (max-width: 800px) {
  .ss-picker { grid-template-columns: 1fr; }
  .ss-picker-list { border-right: none; border-bottom: 1px solid var(--line); max-height: 260px; }
  .ss-picker-detail { padding: 1.5rem; }
}
.rd-module-num { width: 42px; height: 42px; border-radius: 10px; background: var(--gold-pale); color: var(--gold); font-weight: 800; font-size: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.rd-module-card h3 { font-size: 1.03rem; margin-bottom: 0.5rem; }
.rd-lesson-chip { display: inline-block; font-size: 0.78rem; color: var(--slate); padding: 3px 0; }

/* ---- Methodology preview ---- */
.rd-formula-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 1.6rem; }
.rd-formula-box { background: linear-gradient(160deg, var(--ink) 0%, var(--ink-light) 100%); border-radius: 12px; padding: 1.5rem; text-align: center; color: var(--white); box-shadow: 0 12px 30px rgba(11,24,41,0.18); }
.rd-formula-box .lbl { font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gold-light); margin-bottom: 8px; }
.rd-formula-box .eq { font-family: var(--serif); font-size: 1.7rem; font-weight: 700; }
.rd-preview-table-wrap { overflow-x: auto; border: 1px solid var(--line); border-radius: 10px; }
.rd-preview-table { width: 100%; border-collapse: collapse; font-size: 0.83rem; background: var(--white); }
.rd-preview-table th { background: var(--ink); color: var(--white); text-align: left; padding: 10px 14px; font-size: 0.66rem; text-transform: uppercase; letter-spacing: 0.04em; }
.rd-preview-table td { padding: 10px 14px; border-top: 1px solid var(--line); }
.rd-preview-table tr.lvl-bajo td:first-child { color: #1F7A4D; font-weight: 700; }
.rd-preview-table tr.lvl-medio td:first-child { color: #8A6D1E; font-weight: 700; }
.rd-preview-table tr.lvl-alto td:first-child { color: #B3413B; font-weight: 700; }

/* ---- Instructor ---- */
.rd-instructor-card { display: flex; gap: 1.6rem; align-items: center; background: var(--white); border: 1px solid var(--line); border-radius: 14px; padding: 1.8rem; box-shadow: var(--shadow-s); }
.rd-instructor-card img { width: 96px; height: 96px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold-pale); flex-shrink: 0; }
.rd-instructor-card h3 { font-size: 1.1rem; margin-bottom: 2px; }
.rd-instructor-role { font-size: 0.8rem; color: var(--gold); font-weight: 600; margin-bottom: 8px; }
.rd-instructor-bio { font-size: 0.85rem; color: var(--slate); line-height: 1.6; margin-bottom: 8px; }
.rd-cred-row { display: flex; gap: 6px; flex-wrap: wrap; }
.rd-cred-chip { font-size: 0.66rem; font-weight: 700; color: var(--gold); background: var(--gold-pale); padding: 3px 10px; border-radius: 20px; }
@media (max-width: 560px) { .rd-instructor-card { flex-direction: column; text-align: center; } .rd-cred-row { justify-content: center; } }

/* ---- Syllabus table ---- */
.syllabus-table-wrap { overflow-x: auto; border: 1px solid var(--line); border-radius: 10px; }
.syllabus-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; background: var(--white); }
.syllabus-table thead th { background: var(--ink); color: var(--white); text-align: left; padding: 12px 16px; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; }
.syllabus-table td { padding: 11px 16px; border-top: 1px solid var(--line); vertical-align: middle; }
.syllabus-table tr.module-row td { background: var(--ivory); font-weight: 700; color: var(--ink); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.03em; padding-top: 14px; padding-bottom: 14px; }
.syllabus-table tr.module-row:first-child td { border-top: none; }
.syllabus-lesson-num { color: var(--slate-light); font-variant-numeric: tabular-nums; width: 30px; }
.syllabus-type-badge { display: inline-block; font-size: 0.62rem; font-weight: 700; text-transform: uppercase; padding: 3px 9px; border-radius: 10px; letter-spacing: 0.03em; white-space: nowrap; }
.syllabus-type-badge.t-video { background: rgba(11,24,41,0.08); color: var(--ink); }
.syllabus-type-badge.t-pdf, .syllabus-type-badge.t-file { background: var(--gold-pale); color: var(--gold); }
.syllabus-type-badge.t-text { background: rgba(90,100,117,0.1); color: var(--slate); }
.syllabus-type-badge.t-interactive { background: rgba(184,148,46,0.12); color: #8A6D1E; }
.syllabus-type-badge.t-glossary { background: rgba(139,115,64,0.12); color: var(--gold); }
.syllabus-type-badge.t-memory { background: rgba(31,122,77,0.1); color: #1F7A4D; }
.syllabus-duration { color: var(--slate-light); font-size: 0.8rem; text-align: right; white-space: nowrap; }
.syllabus-total-row td { background: var(--ivory); font-weight: 700; color: var(--ink); border-top: 2px solid var(--ink); }

.rd-cta-band { background: linear-gradient(135deg, var(--ink), var(--ink-90)); border-radius: 16px; padding: 3rem 2rem; text-align: center; color: var(--white); }
.rd-cta-band p { color: rgba(255,255,255,0.6); font-size: 0.9rem; margin-bottom: 1.4rem; max-width: 480px; margin-left: auto; margin-right: auto; }

/* ---- Welcome modal (guest quick-start) ---- */
.rd-welcome-modal .rd-welcome-img { width: 100%; border-radius: 10px; margin-bottom: 1.2rem; overflow: hidden; }
.rd-welcome-modal .rd-welcome-img svg { width: 100%; display: block; }
.rd-welcome-modal ul { list-style: none; margin: 1rem 0 1.4rem; }
.rd-welcome-modal ul li { display: flex; align-items: start; gap: 8px; font-size: 0.85rem; color: var(--slate); margin-bottom: 8px; }
.rd-welcome-modal ul li svg { width: 15px; height: 15px; flex-shrink: 0; color: #1F7A4D; margin-top: 2px; }
.rd-step { display: none; }
.rd-step.active { display: block; }
.rd-form-group { margin-bottom: 1rem; }
.rd-form-group label { display: block; font-size: 0.75rem; font-weight: 600; color: var(--slate); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
.rd-form-group input { width: 100%; padding: 12px 14px; border: 1px solid var(--line); border-radius: 6px; font-size: 0.9rem; box-sizing: border-box; }
.rd-form-hint { font-size: 0.76rem; color: var(--slate-light); margin-top: 4px; }

/* ---- Onboarding overlay — full page, same navy as the site footer ---- */
#rdOnboard { position: fixed; inset: 0; z-index: 900; background: var(--ink-90); display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.6s ease, visibility 0.6s ease; padding: 1.5rem; overflow: hidden; }
#rdOnboard::before { content: ''; position: absolute; inset: 0; background: radial-gradient(60% 50% at 50% 0%, rgba(184,154,86,0.14), transparent 70%); pointer-events: none; }
#rdOnboard::after { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(184,154,86,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(184,154,86,0.05) 1px, transparent 1px); background-size: 46px 46px; mask-image: radial-gradient(ellipse at 50% 30%, black 0%, transparent 70%); pointer-events: none; }
#rdOnboard.active { opacity: 1; visibility: visible; }
#rdOnboard.leaving { opacity: 0; }
.rd-ob-logo { position: absolute; top: 1.6rem; left: 50%; transform: translateX(-50%); z-index: 2; }
.rd-ob-logo img { height: 22px; filter: brightness(0) invert(1); opacity: 0.55; }
.rd-ob-skip { position: absolute; top: 1.7rem; right: 1.8rem; z-index: 3; font-size: 0.72rem; color: rgba(255,255,255,0.32); background: none; border: none; cursor: pointer; letter-spacing: 0.02em; }
.rd-ob-skip:hover { color: rgba(255,255,255,0.6); }

.rd-ob-name { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) scale(1); text-align: center; transition: top 1.1s cubic-bezier(0.16,0.84,0.3,1), transform 1.1s cubic-bezier(0.16,0.84,0.3,1); z-index: 20; }
.rd-ob-name.docked { top: 2.6rem; transform: translate(-50%, 0) scale(0.4); }
.rd-ob-name h1 { font-family: var(--serif); font-weight: 700; font-size: clamp(2.6rem, 9vw, 5.2rem); color: var(--white); letter-spacing: 0.01em; white-space: nowrap; min-height: 1.2em; max-width: 92vw; overflow: hidden; text-overflow: clip; transition: background 0.4s ease, padding 0.4s ease, border-radius 0.4s ease, box-shadow 0.4s ease; }
.rd-ob-name.docked h1 { background: var(--ink); padding: 10px 34px; border-radius: 40px; box-shadow: 0 10px 30px rgba(11,24,41,0.35); }
@media (max-width: 480px) {
  .rd-ob-name h1 { font-size: clamp(1.7rem, 8.5vw, 2.4rem); white-space: normal; line-height: 1.15; }
  .rd-ob-name { width: 90vw; }
  .rd-ob-subtext { font-size: 0.82rem; }
}
.rd-ob-name.docked .rd-ob-subtext { opacity: 0 !important; }
.rd-ob-subtext { margin-top: 1rem; font-size: 0.92rem; color: rgba(255,255,255,0.45); opacity: 0; transition: opacity 0.7s ease; min-height: 1.4em; }
.rd-ob-subtext.show { opacity: 1; }
.rd-ob-cursor { display: inline-block; width: 2px; background: var(--gold-light); margin-left: 2px; animation: rdObBlink 0.9s steps(1) infinite; }
@keyframes rdObBlink { 50% { opacity: 0; } }

.rd-ob-progress-row { position: absolute; bottom: 2.2rem; left: 50%; transform: translateX(-50%); display: flex; align-items: center; gap: 10px; z-index: 2; }
.rd-ob-mini-spinner { width: 13px; height: 13px; border: 2px solid rgba(255,255,255,0.18); border-top-color: var(--gold-light); border-radius: 50%; animation: rd-spin 0.8s linear infinite; flex-shrink: 0; }
.rd-ob-count { font-size: 0.68rem; color: rgba(255,255,255,0.4); letter-spacing: 0.04em; white-space: nowrap; }
.rd-ob-master-track { width: min(220px, 55vw); height: 2px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden; }
.rd-ob-master-fill { height: 100%; width: 0%; background: var(--gold-light); }

.rd-ob-carousel { position: relative; width: 100%; max-width: 560px; min-height: 440px; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.9s ease; margin-top: 4.5rem; margin-bottom: 3rem; }
.rd-ob-carousel.show { opacity: 1; visibility: visible; }
.rd-ob-track { position: relative; width: 100%; flex: 1; min-height: 400px; }
.rd-ob-highlight { margin-top: 1.1rem; font-family: var(--serif); font-weight: 600; font-size: 1.05rem; color: var(--gold); letter-spacing: 0.01em; padding: 0.6rem 1rem; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
.rd-ob-card { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 2.4rem 2.2rem; opacity: 0; visibility: hidden; filter: blur(6px); transition: opacity 0.6s ease, filter 0.6s ease; background: rgba(250,250,246,0.88); backdrop-filter: blur(22px); -webkit-backdrop-filter: blur(22px); border: 1px solid rgba(255,255,255,0.6); border-radius: 18px; box-shadow: 0 24px 60px rgba(0,0,0,0.3); overflow-y: auto; }
.rd-ob-card.active { opacity: 1; visibility: visible; filter: blur(0); }
.rd-ob-card.leaving { opacity: 0; filter: blur(6px); }
.rd-ob-eyebrow { font-size: 0.66rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: 0.14em; margin-bottom: 0.9rem; }
.rd-ob-icon { width: 52px; height: 52px; border-radius: 14px; background: var(--gold-pale); color: var(--gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem; }
.rd-ob-icon svg { width: 26px; height: 26px; }
.rd-ob-card h2 { font-family: var(--serif); font-weight: 600; font-size: clamp(1.3rem, 3.4vw, 1.7rem); color: var(--ink); margin-bottom: 0.7rem; letter-spacing: 0; min-height: 1.3em; }
.rd-ob-card p { font-size: 0.88rem; color: var(--slate); line-height: 1.65; max-width: 400px; margin: 0 auto; }
.rd-ob-final-btn { font-size: 1rem !important; padding: 18px 40px !important; }

.rd-ob-loading { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); display: flex; flex-direction: column; align-items: center; gap: 14px; opacity: 1; transition: opacity 0.5s ease; z-index: 2; }
.rd-ob-loading.hide { opacity: 0; visibility: hidden; pointer-events: none; }
.rd-ob-spinner { width: 26px; height: 26px; border: 2.5px solid rgba(184,154,86,0.25); border-top-color: var(--gold-light); border-radius: 50%; animation: rd-spin 0.8s linear infinite; }
.rd-ob-loading span { font-size: 0.85rem; color: rgba(255,255,255,0.55); letter-spacing: 0.02em; }
.rd-ob-instructor-photo { width: 84px; height: 84px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold-pale); margin: 0 auto 1rem; display: block; }
.rd-ob-route { display: flex; flex-direction: column; align-items: center; gap: 2px; max-width: 320px; margin: 1rem auto 0; }
.rd-ob-route .step { font-size: 0.82rem; font-weight: 600; color: var(--ink); }
.rd-ob-route .step .n { color: var(--gold); font-weight: 700; font-size: 0.7rem; letter-spacing: 0.06em; display: block; }
.rd-ob-route .step.cert { color: var(--gold); }
.rd-ob-route .down { color: var(--slate-light); font-size: 0.75rem; }
.rd-ob-benefits { text-align: left; max-width: 380px; margin: 1rem auto 0; list-style: none; }
.rd-ob-benefits li { display: flex; align-items: start; gap: 9px; font-size: 0.85rem; color: var(--ink); margin-bottom: 8px; line-height: 1.5; }
.rd-ob-benefits li .n { font-family: var(--serif); color: var(--gold); font-weight: 700; font-size: 0.9rem; flex-shrink: 0; }
.rd-ob-cert-badge { display: flex; align-items: center; gap: 12px; background: var(--gold-pale); border: 1px solid rgba(139,115,64,0.25); border-radius: 12px; padding: 0.9rem 1.3rem; margin-top: 1rem; }
.rd-ob-cert-badge svg { width: 30px; height: 30px; color: var(--gold); flex-shrink: 0; }
.rd-ob-cert-badge div { text-align: left; font-size: 0.72rem; font-weight: 700; color: var(--gold); letter-spacing: 0.04em; line-height: 1.5; }
.rd-ob-cta { margin-top: 1.6rem; }

@media (max-width: 900px) { .rd-modules { gap: 0.8rem; } }
@endsection

@section('content')
@if($enrollment && in_array($certificateStage ?? 'none', ['awaiting_payment', 'processing'], true))
  <div class="wrap" style="padding-top:2rem;">
    @include('courses._certificate-payment-banner', ['course' => $course, 'stage' => $certificateStage, 'enrollment' => $enrollment])
  </div>
@endif

<section class="rd-hero">
  <div class="wrap rd-hero-grid">
    <div class="rd-fade-up">
      <div class="rd-badge-company"><span class="dot"></span>{{ $course->category->name ?? 'Capacitación online' }} &middot; {{ $isOptionalCert ? 'Certificación opcional' : 'Certificación gratuita' }}</div>
      <h1>{{ $course->title }}</h1>
      @if($isOptionalCert)
        <p class="rd-cert-clarify">Este curso es <strong>gratuito</strong>. Solo la certificación oficial tiene un costo de <strong>S/ {{ number_format($course->certificate_price ?? 0, 2) }}</strong>, y es completamente opcional.</p>
      @endif
      <p class="rd-sub">{{ $course->description }}</p>
      <div class="rd-meta-row">
        @if($course->instructor)
          <div class="rd-meta-item"><div class="k">Instructor</div><div class="v">{{ $course->instructor->name }}</div></div>
        @elseif($course->instructor_name)
          <div class="rd-meta-item"><div class="k">Instructor</div><div class="v">{{ $course->instructor_name }}</div></div>
        @endif
        @if($course->duration_minutes)
          <div class="rd-meta-item"><div class="k">Duración</div><div class="v">{{ $course->lectiveHours() }} {{ $course->lectiveHours() === 1 ? 'hora' : 'horas' }}</div></div>
        @endif
        <div class="rd-meta-item"><div class="k">Módulos</div><div class="v">{{ $course->modules->count() }}</div></div>
        <div class="rd-meta-item"><div class="k">Certificación</div><div class="v">{{ $isOptionalCert ? 'S/ '.number_format($course->certificate_price ?? 0, 0) : 'Gratuita' }}, con QR</div></div>
      </div>
      <div class="rd-cta-row">
        @if($enrollment)
          @php $next = $course->nextLessonFor(auth()->user()); @endphp
          <a href="{{ $next ? route('lessons.show', $next) : route('courses.show', $course) }}" class="rd-btn-primary">
            {{ $enrollment->progress_percent > 0 ? 'Continuar curso' : 'Comenzar curso' }}
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </a>
          @if($course->exam)
            <a href="{{ route('exams.show', $course) }}" class="rd-btn-secondary" title="Puedes dar el cuestionario en cualquier momento, sin necesidad de terminar el curso">
              Dar el cuestionario
            </a>
          @endif
          <span class="rd-progress-chip">{{ $enrollment->progress_percent }}% completado</span>
        @else
          <button type="button" class="rd-btn-primary" onclick="rdOpenWelcome()">
            Inscribirme gratis
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </button>
        @endif
      </div>
      @if(!$enrollment)
        <span class="rd-login-note">No necesitas crear una cuenta — solo tu nombre. @auth @else ¿Ya tienes cuenta? <a href="{{ route('login', ['intended' => route('courses.show', $course)]) }}">Inicia sesión</a> @endauth</span>
      @endif
    </div>

    <div class="rd-illustration rd-fade-up rd-delay-2">
      <svg viewBox="0 0 480 460" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <radialGradient id="rdGlow" cx="50%" cy="35%" r="65%">
            <stop offset="0%" stop-color="#8B7340" stop-opacity="0.35"/>
            <stop offset="100%" stop-color="#8B7340" stop-opacity="0"/>
          </radialGradient>
          <linearGradient id="rdLine" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#B89A56"/>
            <stop offset="100%" stop-color="#8B7340" stop-opacity="0.2"/>
          </linearGradient>
        </defs>
        <circle cx="240" cy="210" r="190" fill="url(#rdGlow)"/>
        <circle cx="240" cy="210" r="150" fill="none" stroke="#1C2E45" stroke-width="1.2" stroke-dasharray="3 7"/>
        <g stroke="url(#rdLine)" stroke-width="1.6" fill="none" opacity="0.85">
          <line x1="240" y1="210" x2="120" y2="120"/><line x1="240" y1="210" x2="360" y2="120"/>
          <line x1="240" y1="210" x2="110" y2="280"/><line x1="240" y1="210" x2="370" y2="290"/>
          <line x1="240" y1="210" x2="240" y2="70"/>
        </g>
        <g>
          <circle cx="120" cy="120" r="8" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
          <circle cx="360" cy="120" r="6" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
          <circle cx="110" cy="280" r="6" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
          <circle cx="370" cy="290" r="8" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
          <circle cx="240" cy="70" r="6" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
        </g>
        <g transform="translate(240,210)">
          <circle r="58" fill="#0B1829" stroke="#B89A56" stroke-width="2"/>
          <path d="M0 -30 L26 -18 L26 6 C26 26 14 40 0 46 C-14 40 -26 26 -26 6 L-26 -18 Z" fill="none" stroke="#FAFAF6" stroke-width="2.2"/>
          <path d="M-11 0 L-3 9 L13 -10" fill="none" stroke="#B89A56" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </g>
        <text x="240" y="430" font-family="Arial, sans-serif" font-size="13" fill="#8A919D" text-anchor="middle" letter-spacing="2">{{ \Illuminate\Support\Str::upper($course->category->name ?? 'COMPLIANCE Y GESTIÓN DE RIESGOS') }}</text>
      </svg>
    </div>
  </div>
</section>

<section class="stats-section">
  <div class="wrap">
    <div class="stats-row">
      <div class="stat-pill"><span class="num">{{ $course->modules->count() }}</span><span class="lbl">Módulos</span></div>
      <div class="stat-pill"><span class="num">{{ $totalLessons }}</span><span class="lbl">{{ $totalLessons === 1 ? 'Lección' : 'Lecciones' }}</span></div>
      <div class="stat-pill"><span class="num">{{ $course->lectiveHours() }}</span><span class="lbl">{{ $course->lectiveHours() === 1 ? 'Hora' : 'Horas' }}</span></div>
      @if($course->exam)
        <div class="stat-pill"><span class="num">{{ $examQuestions }}</span><span class="lbl">Preguntas</span></div>
      @endif
      <div class="stat-pill"><span class="num">{{ $isOptionalCert ? 'S/ '.number_format($course->certificate_price ?? 0, 0) : '100%' }}</span><span class="lbl">{{ $isOptionalCert ? 'Certificación' : 'Gratuito' }}</span></div>
    </div>
  </div>
</section>

@if($totalLessons > 0)
<section class="rd-section" style="padding-bottom:0.5rem;">
  <div class="wrap">
    <div class="rd-eyebrow">Objetivos</div>
    <h2>Lo que aprenderás</h2>
    <div class="learn-grid">
      @foreach($allLessons as $l)
        <div class="learn-item">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
          <span>{{ $l->title }}</span>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@if($course->slug === 'listas-internacionales-ft-fpadm')
  @include('courses._subject-selector')
@elseif($course->modules->count() > 0)
<section class="rd-section">
  <div class="wrap">
    <div class="rd-eyebrow">Temario</div>
    <h2>Módulos del curso</h2>
    <p class="rd-section-lead">Programa estructurado en {{ $course->modules->count() }} módulos, pensado para avanzar a tu propio ritmo.</p>
    <div class="rd-modules">
      @foreach($course->modules as $module)
        <div class="rd-module-card rd-fade-up rd-delay-{{ min($loop->iteration, 4) }}">
          <div class="rd-module-num">{{ sprintf('%02d', $loop->iteration) }}</div>
          <div>
            <h3>{{ $module->title }}</h3>
            @forelse($module->lessons as $lesson)
              <span class="rd-lesson-chip">&middot; {{ $lesson->title }}</span><br>
            @empty
              <span class="rd-lesson-chip" style="color:var(--slate-light);">Contenido en preparación.</span>
            @endforelse
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@if($formulasPreview)
<section class="rd-section rd-section-alt">
  <div class="wrap" style="max-width:820px;">
    <div class="rd-eyebrow">Vista previa</div>
    <h2>Un vistazo a la metodología</h2>
    <p class="rd-section-lead">Así se ve el contenido dentro del curso — esto es solo una muestra.</p>
    @if(!empty($formulasPreview['formulas']))
      <div class="rd-formula-row">
        @foreach($formulasPreview['formulas'] as $f)
          <div class="rd-formula-box"><div class="lbl">{{ $f['label'] ?? '' }}</div><div class="eq">{{ $f['eq'] ?? '' }}</div></div>
        @endforeach
      </div>
    @endif
    @if(!empty($formulasPreview['rangos']))
      <div class="rd-preview-table-wrap">
        <table class="rd-preview-table">
          <thead><tr><th>Nivel</th><th>Rango RR</th><th>Plan de acción</th></tr></thead>
          <tbody>
            @foreach($formulasPreview['rangos'] as $row)
              <tr class="lvl-{{ \Illuminate\Support\Str::slug($row['nivel'] ?? '') }}"><td>{{ $row['nivel'] ?? '' }}</td><td>{{ $row['rango'] ?? '' }}</td><td>{{ $row['plan'] ?? '' }}</td></tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</section>
@endif

@if($course->instructor && $course->instructor->bio)
<section class="rd-section">
  <div class="wrap" style="max-width:720px;">
    <div class="rd-eyebrow">Instructor</div>
    <h2 style="margin-bottom:1.6rem;">Tu guía en esta capacitación</h2>
    <div class="rd-instructor-card">
      <img src="{{ $course->instructor->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $course->instructor->name }}">
      <div>
        <h3>{{ $course->instructor->name }}</h3>
        <div class="rd-instructor-role">{{ $course->instructor->title ?? 'Instructor' }}</div>
        <p class="rd-instructor-bio">{{ \Illuminate\Support\Str::limit($course->instructor->bio, 240) }}</p>
        @if($course->instructor->credentialsList())
          <div class="rd-cred-row">
            @foreach($course->instructor->credentialsList() as $cred)
              <span class="rd-cred-chip">{{ $cred }}</span>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endif

@if($totalLessons > 0)
<section class="rd-section rd-section-alt">
  <div class="wrap">
    <div class="rd-eyebrow">Detalle completo</div>
    <h2>Plan de estudios</h2>
    <p class="rd-section-lead">Módulo, lección, tipo de contenido y duración de cada parte del curso.</p>
    <div class="syllabus-table-wrap">
      <table class="syllabus-table">
        <thead><tr><th style="width:40px;">#</th><th>Contenido</th><th>Tipo</th><th style="text-align:right;">Duración</th></tr></thead>
        <tbody>
          @foreach($course->modules as $module)
            <tr class="module-row"><td colspan="4">{{ $module->title }}</td></tr>
            @foreach($module->lessons as $lesson)
              <tr>
                <td class="syllabus-lesson-num">{{ sprintf('%02d', $loop->iteration) }}</td>
                <td>{{ $lesson->title }}</td>
                <td><span class="syllabus-type-badge t-{{ $lesson->type }}">{{ $lesson->typeLabel() }}</span></td>
                <td class="syllabus-duration">{{ $lesson->duration_minutes ? $lesson->duration_minutes.' min' : '—' }}</td>
              </tr>
            @endforeach
          @endforeach
          @if($course->exam)
            <tr class="module-row"><td colspan="4">Evaluación final</td></tr>
            <tr>
              <td class="syllabus-lesson-num">—</td>
              <td>{{ $course->exam->title }}</td>
              <td><span class="syllabus-type-badge t-interactive">{{ $examQuestions }} preguntas</span></td>
              <td class="syllabus-duration">{{ $course->exam->time_limit_minutes }} min</td>
            </tr>
          @endif
          <tr class="syllabus-total-row">
            <td colspan="3">Duración total estimada</td>
            <td class="syllabus-duration">{{ $totalDuration }} min</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
@endif

<section class="rd-section">
  <div class="wrap" style="max-width:900px;">
    <div class="rd-cta-band rd-fade-up">
      <h2 style="color:var(--white);">¿Listo para comenzar?</h2>
      <p>Avanza a tu propio ritmo, autoevalúate al finalizar y obtén tu certificado verificable por QR.</p>
      @if($enrollment)
        @php $next2 = $course->nextLessonFor(auth()->user()); @endphp
        <a href="{{ $next2 ? route('lessons.show', $next2) : route('courses.show', $course) }}" class="rd-btn-primary">Continuar curso</a>
      @else
        <button type="button" class="rd-btn-primary" onclick="rdOpenWelcome()">Inscribirme gratis</button>
      @endif
    </div>
  </div>
</section>

<div class="modal-overlay" id="modalBloqueo">
  <div class="modal-backdrop" onclick="cerrarModalesCurso()"></div>
  <div class="modal-box" style="max-width:420px;text-align:center;">
    <button class="modal-close" onclick="cerrarModalesCurso()">&times;</button>
    <h3>Completa el curso primero</h3>
    <p class="modal-text">Debes finalizar todas las lecciones del curso para poder acceder a tu certificación.</p>
  </div>
</div>

@if($isOptionalCert)
<div class="modal-overlay" id="modalCompra">
  <div class="modal-backdrop" onclick="cerrarModalesCurso()"></div>
  <div class="modal-box" style="max-width:440px;text-align:center;">
    <button class="modal-close" onclick="cerrarModalesCurso()">&times;</button>
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

{{-- ---- Guest quick-start modal: name + email only, no account required ---- --}}
@if(!$enrollment)
<div class="modal-overlay" id="rdWelcomeModal">
  <div class="modal-backdrop" onclick="rdCloseWelcome()"></div>
  <div class="modal-box rd-welcome-modal" style="max-width:480px;">
    <button class="modal-close" onclick="rdCloseWelcome()">&times;</button>

    <div class="rd-step active" id="rdStep1">
      <div class="rd-welcome-img">
        <svg viewBox="0 0 400 160" xmlns="http://www.w3.org/2000/svg">
          <rect width="400" height="160" fill="#0B1829"/>
          <circle cx="330" cy="30" r="70" fill="#8B7340" opacity="0.25"/>
          <text x="30" y="70" font-family="Arial, sans-serif" font-weight="bold" font-size="20" fill="#FAFAF6">Bienvenido a</text>
          <text x="30" y="98" font-family="Arial, sans-serif" font-weight="bold" font-size="20" fill="#B89A56">{{ \Illuminate\Support\Str::limit($course->title, 30) }}</text>
        </svg>
      </div>
      <h3>Antes de empezar</h3>
      <p class="modal-sub">{{ \Illuminate\Support\Str::limit($course->description, 140) }}</p>
      <ul>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg> {{ $course->modules->count() }} módulos con contenido práctico</li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg> Modelo descargable listo para usar</li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg> Certificado {{ $isOptionalCert ? 'verificable por QR (S/ '.number_format($course->certificate_price ?? 0, 0).')' : 'gratuito, verificable por QR' }}</li>
      </ul>
      <button type="button" class="btn btn-gold btn-block" style="width:100%;justify-content:center;" onclick="rdGoStep2()">Ver contenido</button>
    </div>

    <div class="rd-step" id="rdStep2">
      <h3>¿Cómo te llamas?</h3>
      <p class="modal-sub">Nada de contraseñas ni registro — solo tu nombre y correo para guardar tu avance y tu certificado.</p>
      <form action="{{ route('courses.guest-start', $course) }}" method="POST">
        @csrf
        <div class="rd-form-group">
          <label>Nombre completo</label>
          <input type="text" name="full_name" required autofocus autocomplete="off" spellcheck="false">
        </div>
        <div class="rd-form-group">
          <label>Correo electrónico</label>
          <input type="email" name="email" required autocomplete="off">
          <div class="rd-form-hint">Lo usamos para tu certificado y para que no pierdas tu avance.</div>
        </div>
        <button type="submit" class="btn btn-gold btn-block" style="width:100%;justify-content:center;">Entrar al curso</button>
      </form>
      <p class="rd-form-hint" style="text-align:center;margin-top:12px;">¿Ya tienes cuenta? <a href="{{ route('login', ['intended' => route('courses.show', $course)]) }}" style="color:var(--gold);font-weight:600;">Inicia sesión</a></p>
    </div>
  </div>
</div>
@endif

@auth
<div id="rdOnboard">
  <div class="rd-ob-logo"><img src="{{ asset('images/logos.png') }}" alt="Romani Compliance"></div>
  <button type="button" class="rd-ob-skip" onclick="rdOnboardFinish()">Omitir →</button>

  <div class="rd-ob-loading" id="rdObLoading">
    <div class="rd-ob-spinner"></div>
    <span>Cargando tu experiencia...</span>
  </div>

  <div class="rd-ob-name" id="rdObName">
    <h1 id="rdObNameText"></h1>
    <div class="rd-ob-subtext" id="rdObSubtext"></div>
  </div>

  <div class="rd-ob-carousel" id="rdObCarousel">
    <div class="rd-ob-track" id="rdObTrack">
      <div class="rd-ob-card" data-card="0">
        <div class="rd-ob-eyebrow">Bienvenida</div>
        <h2>Bienvenido a tu capacitación</h2>
        <p>Una experiencia diseñada para aprender, comprender y aplicar.</p>
        <div class="rd-ob-highlight">APRENDER · APLICAR · CERTIFICARTE</div>
      </div>

      <div class="rd-ob-card" data-card="1">
        <div class="rd-ob-eyebrow">Sobre este curso</div>
        <h2>{{ \Illuminate\Support\Str::limit($course->title, 60) }}</h2>
        <p>{{ \Illuminate\Support\Str::limit($course->description, 150) }}</p>
      </div>

      @if($course->instructor)
        <div class="rd-ob-card" data-card="2" data-duration="long">
          <div class="rd-ob-eyebrow">Tu capacitador</div>
          <img src="{{ $course->instructor->displayPhoto() ?? asset('images/logos.png') }}" alt="{{ $course->instructor->name }}" class="rd-ob-instructor-photo">
          <h2>{{ $course->instructor->name }}</h2>
          <p style="color:var(--gold);font-weight:600;font-size:0.85rem;margin-bottom:0.5rem;">{{ $course->instructor->title ?? 'Instructor' }}</p>
          <p>{{ \Illuminate\Support\Str::limit($course->instructor->bio, 130) }}</p>
        </div>
      @endif

      <div class="rd-ob-card" data-card="3">
        <div class="rd-ob-eyebrow">Certificación</div>
        <h2>Tu capacitación, con respaldo verificable</h2>
        <p>{{ $isOptionalCert ? 'Al completar el curso puedes solicitar tu certificado oficial (S/ '.number_format($course->certificate_price ?? 0, 0).').' : 'Al completar la capacitación tu certificado se emite al instante, sin costo.' }}</p>
        <div class="rd-ob-cert-badge">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><rect x="6" y="6" width="4" height="4"/><rect x="14" y="6" width="4" height="4"/><rect x="6" y="14" width="4" height="4"/><path d="M14 14h2v2h-2zM18 14h2v2h-2zM14 18h2v2h-2zM18 18h2v2h-2z"/></svg>
          <div>CERTIFICACIÓN DIGITAL<br>VERIFICABLE POR QR</div>
        </div>
      </div>

      <div class="rd-ob-card" data-card="4">
        <div class="rd-ob-eyebrow">Material incluido</div>
        <h2>¿Qué te llevarás de este curso?</h2>
        <ul class="rd-ob-benefits" style="margin-top:0.6rem;">
          @foreach($allLessons->take(3) as $i => $l)
            <li><span class="n">{{ sprintf('%02d', $i + 1) }}</span> {{ $l->title }}</li>
          @endforeach
        </ul>
      </div>

      <div class="rd-ob-card" data-card="5">
        <div class="rd-ob-eyebrow">Tu ruta</div>
        <h2>Tu recorrido comienza aquí</h2>
        <div class="rd-ob-route">
          @foreach($course->modules as $module)
            <div class="step"><span class="n">MÓDULO {{ sprintf('%02d', $loop->iteration) }}</span>{{ $module->title }}</div>
            <div class="down">↓</div>
          @endforeach
          <div class="step cert"><span class="n">FINAL</span>Certificación</div>
        </div>
        <div class="rd-ob-cta">
          <button type="button" class="rd-btn-primary rd-ob-final-btn" onclick="rdOnboardFinish()">Comenzar curso →</button>
        </div>
      </div>
    </div>

    <div class="rd-ob-progress-row">
      <div class="rd-ob-mini-spinner"></div>
      <div class="rd-ob-master-track"><div class="rd-ob-master-fill" id="rdObMasterFill"></div></div>
      <div class="rd-ob-count" id="rdObCount">01 / 06</div>
    </div>
  </div>
</div>
@endauth

@if($enrollment && $course->exam && !$certificate && !$pendingCertificate)
  <a href="{{ route('exams.show', $course) }}" class="floating-quiz-cta" id="floatingQuizCta" data-course="{{ $course->id }}">
    <span class="fqc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 11l3 3L22 4M11 11l-7 7"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h11"/></svg></span>
    <span class="fqc-text">Dar el cuestionario<small>Sin necesidad de terminar el curso</small></span>
    <button type="button" class="floating-quiz-close" id="floatingQuizClose" onclick="event.preventDefault(); event.stopPropagation(); fqcDismiss();">&times;</button>
  </a>
@endif
@endsection

@section('scripts')
<script>
function rdOpenWelcome() { document.getElementById('rdWelcomeModal')?.classList.add('active'); }
function rdCloseWelcome() { document.getElementById('rdWelcomeModal')?.classList.remove('active'); }
function rdGoStep2() {
  document.getElementById('rdStep1').classList.remove('active');
  document.getElementById('rdStep2').classList.add('active');
}
(function () {
  const cta = document.getElementById('floatingQuizCta');
  if (!cta) return;
  const key = 'rc_quiz_cta_dismissed_' + cta.dataset.course;
  if (sessionStorage.getItem(key) === '1') { cta.style.display = 'none'; }
  window.fqcDismiss = function () {
    sessionStorage.setItem(key, '1');
    cta.style.display = 'none';
  };
})();

function abrirModalCompra() { document.getElementById('modalCompra')?.classList.add('active'); }
function abrirModalBloqueo() { document.getElementById('modalBloqueo')?.classList.add('active'); }
function cerrarModalesCurso() { document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active')); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') { cerrarModalesCurso(); rdCloseWelcome(); } });

let rdObCards = [];
let rdObIndex = 0;
let rdObAutoTimer = null;
let rdObDurations = [];
let rdObTotalMs = 0;
let rdObMasterRaf = null;
const RD_OB_NAME = "{{ $rdGreetingWord }}, {{ addslashes($rdDisplayFirstName) }}.";
const RD_OB_NORMAL_MS = 2600;
const RD_OB_INSTRUCTOR_MS = 3200;
const RD_OB_NAME_DOCK_DELAY = 2200;

function rdTypewrite(el, text, speed, onDone) {
  el.textContent = '';
  const cursor = document.createElement('span');
  cursor.className = 'rd-ob-cursor';
  let i = 0;
  (function step() {
    el.textContent = text.slice(0, i);
    el.appendChild(cursor);
    i++;
    if (i <= text.length) { setTimeout(step, speed); } else { cursor.remove(); if (onDone) onDone(); }
  })();
}

(function rdOnboarding() {
  const overlay = document.getElementById('rdOnboard');
  if (!overlay) return;

  const params = new URLSearchParams(window.location.search);
  const justJoined = params.get('bienvenida') === '1';
  if (!justJoined) return;

  rdObCards = Array.from(document.querySelectorAll('#rdObTrack .rd-ob-card'));
  rdObDurations = rdObCards.map(c => c.dataset.duration === 'long' ? RD_OB_INSTRUCTOR_MS : RD_OB_NORMAL_MS);
  rdObTotalMs = RD_OB_NAME_DOCK_DELAY + rdObDurations.reduce((a, b) => a + b, 0);
  rdObCards[0].classList.add('active');

  overlay.classList.add('active');
  rdObStartMasterProgress();

  // Confeti bien visible en toda la página apenas empieza la bienvenida.
  if (typeof window.fireConfetti === 'function') window.fireConfetti({ count: 200 });

  const loadingEl = document.getElementById('rdObLoading');
  const nameEl = document.getElementById('rdObName');

  setTimeout(() => {
    loadingEl.classList.add('hide');
    const subtext = document.getElementById('rdObSubtext');
    rdTypewrite(document.getElementById('rdObNameText'), RD_OB_NAME, 45, () => {
      setTimeout(() => { subtext.textContent = 'Gracias por confiar en Romani Compliance.'; subtext.classList.add('show'); }, 200);
      setTimeout(() => { nameEl.classList.add('docked'); document.getElementById('rdObCarousel').classList.add('show'); rdObStartAuto(); }, 1600);
    });
  }, 500);
})();

function rdObStartMasterProgress() {
  const fill = document.getElementById('rdObMasterFill');
  const start = performance.now();
  function tick(now) {
    const pct = Math.min(100, ((now - start) / rdObTotalMs) * 100);
    fill.style.width = pct + '%';
    if (pct < 100) rdObMasterRaf = requestAnimationFrame(tick);
  }
  rdObMasterRaf = requestAnimationFrame(tick);
}

function rdObTypewriteCardTitle(card) {
  const h2 = card.querySelector('h2');
  if (!h2 || h2.dataset.typed) return;
  h2.dataset.typed = '1';
  rdTypewrite(h2, h2.textContent, 14);
}

function rdObRenderCount() {
  const el = document.getElementById('rdObCount');
  if (el) el.textContent = String(rdObIndex + 1).padStart(2, '0') + ' / ' + String(rdObCards.length).padStart(2, '0');
}

function rdObStartAuto() {
  rdObTypewriteCardTitle(rdObCards[0]);
  rdObRenderCount();
  const advance = () => {
    if (rdObIndex < rdObCards.length - 1) {
      rdObCards[rdObIndex].classList.remove('active');
      rdObCards[rdObIndex].classList.add('leaving');
      rdObIndex++;
      rdObCards[rdObIndex].classList.add('active');
      rdObTypewriteCardTitle(rdObCards[rdObIndex]);
      rdObRenderCount();
      setTimeout(() => rdObCards[rdObIndex - 1]?.classList.remove('leaving'), 750);
      rdObAutoTimer = setTimeout(advance, rdObDurations[rdObIndex]);
    }
  };
  rdObAutoTimer = setTimeout(advance, rdObDurations[rdObIndex]);
}

function rdOnboardFinish() {
  clearTimeout(rdObAutoTimer);
  cancelAnimationFrame(rdObMasterRaf);
  if (typeof window.fireConfetti === 'function') window.fireConfetti({ count: 220 });
  const overlay = document.getElementById('rdOnboard');
  setTimeout(() => overlay.classList.add('leaving'), 500);
  setTimeout(() => {
    @php $firstLesson = $course->nextLessonFor(auth()->user() ?? new \App\Models\User()); @endphp
    @if(auth()->check() && $firstLesson)
      window.location.href = '{{ route('lessons.show', $firstLesson) }}';
    @else
      overlay.classList.remove('active');
      const url = new URL(window.location.href);
      url.searchParams.delete('bienvenida');
      window.history.replaceState({}, '', url);
    @endif
  }, 950);
}

@if(session('success') && str_contains(session('success'), 'completado todas las lecciones'))
if (typeof window.fireConfetti === 'function') { window.fireConfetti(); }
@endif
</script>
@endsection
