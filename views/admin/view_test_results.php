<?php
// views/admin/view_test_results.php
$test_display_name = htmlspecialchars(pathinfo($test['filename'], PATHINFO_FILENAME));
$subject_display   = htmlspecialchars($test['subject_name'] ?? '');

/**
 * Formatira MySQL timestamp u Belgrade vrijemenu.
 * MySQL TIMESTAMP je u UTC; konvertujemo u Europe/Belgrade.
 */
function formatBelgradeTime(?string $ts): string {
    if (empty($ts) || $ts === '0000-00-00 00:00:00') return '—';
    try {
        // MySQL session je '+02:00' (CEST) pa string vec sadrzi CEST vrijednost.
        // Samo parsiramo i formatiramo, bez ikakve konverzije zone.
        $dt = new DateTime($ts, new DateTimeZone('+02:00'));
        return $dt->format('d.m.Y. H:i');
    } catch (Exception $e) {
        return $ts;
    }
}

?>
<!DOCTYPE html>
<html lang="bs">
<script>
  if(localStorage.getItem('appTheme')==='ocean') {
    document.documentElement.classList.add('theme-ocean');
  }
</script>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pregled odgovora — <?= $test_display_name ?></title>
<meta name="description" content="Pregled svih odgovora i bodova učenika na testu <?= $test_display_name ?>">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
  body { background: #0f172a; }

  .gradient-bg { background: linear-gradient(-45deg,#1a1a2e,#162447,#1f4068,#1a1a2e); background-size:400% 400%; animation: gradBG 12s ease infinite; }
  @keyframes gradBG { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }

  .glass { background: rgba(255,255,255,0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.07); }
  .glass-strong { background: rgba(30,41,59,0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); }

  .stat-card { background: linear-gradient(135deg, rgba(255,255,255,0.04), rgba(255,255,255,0.01)); border: 1px solid rgba(255,255,255,0.07); transition: transform .2s, box-shadow .2s; }
  .stat-card:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(0,0,0,.35); }

  .student-row { transition: background .15s; }
  .student-row:hover { background: rgba(139,92,246,.06); }

  .score-bar-track { background: rgba(255,255,255,0.07); border-radius: 999px; overflow: hidden; height: 6px; }
  .score-bar-fill  { height: 100%; border-radius: 999px; transition: width 1s cubic-bezier(.4,0,.2,1); }

  .answer-chip { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; border: 1px solid; }

  .accordion-btn { cursor: pointer; user-select: none; }
  .accordion-content { transition: max-height .35s cubic-bezier(.4,0,.2,1), opacity .25s; overflow: hidden; }
  .accordion-content.closed { max-height: 0 !important; opacity: 0; }

  .custom-scrollbar::-webkit-scrollbar { width: 5px; }
  .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
  .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(139,92,246,.4); border-radius: 99px; }

  @keyframes fadeUp { from { opacity:0; transform: translateY(16px); } to { opacity:1; transform: translateY(0); } }
  .fade-up { animation: fadeUp .45s ease both; }

  .badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; letter-spacing: .03em; }

  /* Score colour helpers */
  .score-excellent { color: #34d399; border-color: rgba(52,211,153,.3); background: rgba(52,211,153,.08); }
  .score-good      { color: #60a5fa; border-color: rgba(96,165,250,.3); background: rgba(96,165,250,.08); }
  .score-average   { color: #fbbf24; border-color: rgba(251,191,36,.3);  background: rgba(251,191,36,.08); }
  .score-poor      { color: #f87171; border-color: rgba(248,113,113,.3); background: rgba(248,113,113,.08); }
  .bar-excellent { background: linear-gradient(90deg,#059669,#34d399); }
  .bar-good      { background: linear-gradient(90deg,#2563eb,#60a5fa); }
  .bar-average   { background: linear-gradient(90deg,#d97706,#fbbf24); }
  .bar-poor      { background: linear-gradient(90deg,#dc2626,#f87171); }

  @media print {
    body {
      background-color: #fff !important;
      color: #000 !important;
    }
    .non-printable, #editPointsModal, #deleteModal, #resultsList {
      display: none !important;
    }
    .printable-area {
      display: block !important;
    }
    .bg-gray-800, .bg-gray-900\/40, .glass-strong {
      background: none !important;
      border: none !important;
      box-shadow: none !important;
      padding: 0 !important;
    }
    .print-header {
      display: block !important;
      text-align: center;
      margin-bottom: 1.5rem;
    }
    .print-header h1 { font-size: 22pt; color: #000; }
    .print-header p { font-size: 14pt; color: #333; }

    /* Standardna HTML tabela za štampu */
    table { width: 100%; border-collapse: collapse; border: 1px solid #000; font-size: 11pt; margin-bottom: 1rem; }
    th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; vertical-align: top; color: #000 !important; }
    th { background-color: #f5f5f5 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; font-weight: bold; }
  }

  /* ================================================================
     OCEAN TEMA — Kompletni Moderni Svjetli Dizajn (View Results)
     Akcentne boje: Teal (#0d9488) + Cyan (#0891b2)
     ================================================================ */
  html.theme-ocean body,
  html.theme-ocean .bg-\[\#0f172a\] {
    background-color: #f0f9ff !important;
    color: #1e293b !important;
  }
  html.theme-ocean .bg-gray-800 {
    background-color: #ffffff !important;
    border-color: #e2e8f0 !important;
    box-shadow: 0 4px 24px rgba(13,148,136,0.08) !important;
  }
  html.theme-ocean .bg-gray-900\/40 { background-color: #f8fafc !important; border-color: #e2e8f0 !important; }
  html.theme-ocean .bg-gray-900\/50 { background-color: #f8fafc !important; }
  html.theme-ocean .glass { background: rgba(255,255,255,0.8) !important; border-color: #e2e8f0 !important; }
  html.theme-ocean .glass-strong { background: rgba(255,255,255,0.95) !important; border-color: #e2e8f0 !important; }
  html.theme-ocean .stat-card { background: #ffffff !important; border-color: #e2e8f0 !important; }
  html.theme-ocean .student-row:hover { background: rgba(13,148,136,0.04) !important; }
  html.theme-ocean .border-gray-700 { border-color: #e2e8f0 !important; }
  html.theme-ocean .border-gray-700\/50 { border-color: #e2e8f0 !important; }
  html.theme-ocean .border-white\/5 { border-color: #e2e8f0 !important; }
  html.theme-ocean .border-white\/7 { border-color: #e2e8f0 !important; }
  html.theme-ocean .text-white { color: #0f172a !important; }
  html.theme-ocean .hover\:text-white:hover,
  html.theme-ocean .hover\:text-white:hover i { color: #ffffff !important; }

  html.theme-ocean .text-gray-100 { color: #1e293b !important; }
  html.theme-ocean .text-gray-200 { color: #1e293b !important; }
  html.theme-ocean .text-gray-300 { color: #334155 !important; }
  html.theme-ocean .text-gray-400 { color: #64748b !important; }
  html.theme-ocean .text-gray-500 { color: #94a3b8 !important; }
  html.theme-ocean .text-gray-600 { color: #94a3b8 !important; }
  /* Purple → Teal */
  html.theme-ocean .text-purple-400 { color: #0d9488 !important; }
  html.theme-ocean .bg-purple-500\/15 { background-color: rgba(13,148,136,0.1) !important; }
  html.theme-ocean .border-purple-500\/20 { border-color: rgba(13,148,136,0.2) !important; }
  html.theme-ocean .bg-purple-500\/20 { background-color: rgba(13,148,136,0.1) !important; }
  html.theme-ocean .bg-purple-500\/30 { background-color: rgba(13,148,136,0.12) !important; }
  html.theme-ocean .border-indigo-500\/25 { border-color: rgba(13,148,136,0.2) !important; }
  html.theme-ocean .from-indigo-950\/60 { background: rgba(240,253,250,0.9) !important; }
  html.theme-ocean .to-purple-950\/60 { background: rgba(236,253,245,0.9) !important; }
  html.theme-ocean .bg-gradient-to-r.from-indigo-950\/60.to-purple-950\/60 {
    background: linear-gradient(to right, rgba(240,253,250,0.9), rgba(236,253,245,0.9)) !important;
    border-color: rgba(13,148,136,0.2) !important;
  }
  html.theme-ocean .text-indigo-400 { color: #0d9488 !important; }
  html.theme-ocean .text-indigo-300\/70 { color: rgba(13,148,136,0.7) !important; }
  html.theme-ocean .bg-indigo-500\/20 { background-color: rgba(13,148,136,0.1) !important; }
  html.theme-ocean .border-indigo-500\/30 { border-color: rgba(13,148,136,0.2) !important; }
  html.theme-ocean .text-indigo-300 { color: #0d9488 !important; }
  /* Search & Filter */
  html.theme-ocean #searchInput {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
    border-color: #ccfbf1 !important;
    color: #0f172a !important;
  }
  html.theme-ocean #searchInput::placeholder { color: #94a3b8 !important; }
  html.theme-ocean #sortSelectBtn {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
    border-color: #ccfbf1 !important;
    color: #0f172a !important;
  }
  html.theme-ocean #sortSelectDropdown {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
    border-color: #ccfbf1 !important;
  }
  html.theme-ocean #sortSelectDropdown button { color: #334155 !important; }
  html.theme-ocean #sortSelectDropdown button:hover { background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important; color: #0d9488 !important; }
  /* Rezultati redovi */
  html.theme-ocean .bg-gray-800\/80 { background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important; border-color: #ccfbf1 !important; }
  /* Analitika blokovi */
  html.theme-ocean .bg-gray-900\/50 { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-color: #ccfbf1 !important; }
  html.theme-ocean .score-bar-track { background: linear-gradient(90deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08)) !important; }
  html.theme-ocean .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(13,148,136,0.4) !important; }
  /* Modali */
  html.theme-ocean #editPointsModal .bg-gray-800,
  html.theme-ocean #deleteModal .bg-gray-800 {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
    border-color: #ccfbf1 !important;
  }
  html.theme-ocean #editPointsModal input[type="number"] {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
    color: #0f172a !important;
  }
  html.theme-ocean .bg-gray-700\/40 { background: linear-gradient(135deg, rgba(241,245,249,0.9), rgba(240,253,250,0.85)) !important; border-color: #ccfbf1 !important; color: #475569 !important; }
  html.theme-ocean .hover\:bg-gray-700:hover { background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important; color: #0d9488 !important; }
  html.theme-ocean .bg-purple-600\/20 { background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08)) !important; }
  html.theme-ocean .bg-purple-500\/10 { background: linear-gradient(135deg, rgba(13,148,136,0.08), rgba(8,145,178,0.05)) !important; }
  html.theme-ocean .focus\:border-purple-500:focus { border-color: #0d9488 !important; }
  html.theme-ocean .focus\:ring-purple-500:focus { --tw-ring-color: rgba(13,148,136,0.25); }
  html.theme-ocean .hover\:border-purple-500:hover { border-color: #0d9488 !important; }
  /* Dekorativni sjajev */
  html.theme-ocean .bg-purple-600\/10 { background: linear-gradient(135deg, rgba(13,148,136,0.08), rgba(8,145,178,0.05)) !important; }
  html.theme-ocean .bg-blue-600\/10 { background: linear-gradient(135deg, rgba(8,145,178,0.08), rgba(13,148,136,0.05)) !important; }
  html.theme-ocean .bg-gray-800\/60 { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-color: #ccfbf1 !important; }

  /* === GLOBALNI TOOLTIP === */
  html.theme-ocean #globalTooltip,
  html.theme-ocean #globalTooltip.text-white {
    background-color: #1f2937 !important;
    border-color: #374151 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3), 0 0 12px rgba(13,148,136,0.2) !important;
  }

  /* === SCROLLBAR U OCEAN TEMI === */
  html.theme-ocean ::-webkit-scrollbar-thumb { background: #cbd5e1; }
  html.theme-ocean ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

  /* === SELECTION U OCEAN TEMI === */
  html.theme-ocean ::selection { background-color: #0d9488; color: #ffffff; }

  /* Theme pill toggle - Modern Enhanced */
  :root {
    --clr-accent: #a855f7;
    --clr-accent-glow: rgba(168,85,247,0.4);
    --clr-accent-border: rgba(168,85,247,0.5);
    --clr-user-from: #a855f7; --clr-user-to: #ec4899;
  }
  html.theme-ocean {
    --clr-accent: #0d9488;
    --clr-accent-glow: rgba(13,148,136,0.15);
    --clr-accent-border: rgba(13,148,136,0.25);
    --clr-user-from: #0d9488; --clr-user-to: #0891b2;
  }
  @keyframes ripple { 0% { transform: scale(0); opacity: 0.8; } 100% { transform: scale(4); opacity: 0; } }

  .theme-pill-btn {
    background: linear-gradient(135deg, rgba(124,58,237,0.18) 0%, rgba(99,102,241,0.10) 100%);
    border: 1.5px solid rgba(124,58,237,0.35);
    padding: 5px 10px; border-radius: 30px;
    cursor: pointer; flex-shrink: 0; outline: none;
    transition: all 0.35s cubic-bezier(0.34,1.56,0.64,1);
    backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden;
    box-shadow: inset 0 1px 1px rgba(255,255,255,0.08);
  }
  .theme-pill-btn::before {
    content: ''; position: absolute; top: 50%; left: 50%; width: 8px; height: 8px;
    border-radius: 50%; background: #7c3aed; transform: translate(-50%, -50%);
    opacity: 0; pointer-events: none;
  }
  .theme-pill-btn::after {
    content: ''; position: absolute; inset: 0; border-radius: 30px;
    background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 60%);
    pointer-events: none;
  }
  .theme-pill-btn:active::before { animation: ripple 0.6s cubic-bezier(0.4, 0, 0.6, 1); }
  .theme-pill-btn:hover {
    background: linear-gradient(135deg, rgba(124,58,237,0.32) 0%, rgba(99,102,241,0.20) 100%) !important;
    border-color: #7c3aed !important;
    box-shadow: inset 0 1px 2px rgba(255,255,255,0.15) !important;
    transform: translateY(-2px) scale(1.03) !important;
  }
  .theme-pill-btn:active { transform: scale(0.94); box-shadow: none; }
  .theme-pill-btn:focus-visible { outline: 2px solid #7c3aed; outline-offset: 3px; }
  .theme-pill-track {
    display: flex; align-items: center; justify-content: space-between;
    width: 52px; height: 28px; border-radius: 14px;
    background: linear-gradient(135deg, rgba(15,23,42,0.95) 0%, rgba(30,41,59,0.85) 100%);
    border: 1px solid rgba(255,255,255,0.12);
    position: relative; padding: 0 6px;
    box-shadow: inset 0 2px 6px rgba(0,0,0,0.6), inset 0 1px 2px rgba(0,0,0,0.4);
    transition: all 0.4s cubic-bezier(0.42, 0, 0.58, 1); flex-shrink: 0;
  }
  html.theme-ocean .theme-pill-track {
    background: linear-gradient(135deg, rgba(226,232,240,0.95) 0%, rgba(241,245,249,0.90) 100%);
    border-color: rgba(148,163,184,0.4);
    box-shadow: inset 0 2px 6px rgba(0,0,0,0.08), inset 0 1px 2px rgba(0,0,0,0.05);
  }
  .theme-pill-btn:hover .theme-pill-track {
    border-color: rgba(124,58,237,0.35) !important;
    box-shadow: inset 0 2px 6px rgba(0,0,0,0.6) !important;
    background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%) !important;
  }
  .theme-pill-thumb {
    position: absolute; left: 3px; top: 50%; transform: translateY(-50%);
    width: 22px; height: 22px; border-radius: 50%;
    background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
    box-shadow: 0 2px 8px rgba(0,0,0,0.4);
    transition: left 0.5s cubic-bezier(0.68,-0.55,0.265,1.55), box-shadow 0.4s ease, background 0.4s ease;
    z-index: 2;
  }
  .theme-pill-thumb::after {
    content: ''; position: absolute; inset: 3px; border-radius: 50%;
    background: linear-gradient(135deg, rgba(255,255,255,0.35) 0%, transparent 70%);
    pointer-events: none;
  }
  .theme-pill-btn:hover .theme-pill-thumb { box-shadow: 0 2px 8px rgba(0,0,0,0.4) !important; }
  html.theme-ocean .theme-pill-thumb {
    left: 27px;
    background: linear-gradient(135deg, #0ea5e9 0%, #0d9488 100%);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  }
  .theme-pill-icon {
    font-size: 10px; z-index: 1; line-height: 1;
    transition: all 0.45s cubic-bezier(0.34, 1.56, 0.64, 1); pointer-events: none;
  }
  .theme-pill-icon-left  { color: #fff; opacity: 1; transform: scale(1.15) rotate(0deg); }
  .theme-pill-icon-right { color: rgba(255,255,255,0.3); opacity: 0.35; transform: scale(0.85) rotate(-20deg); }
  html.theme-ocean .theme-pill-btn {
    background: linear-gradient(135deg, rgba(8,145,178,0.18) 0%, rgba(13,148,136,0.10) 100%);
    border-color: rgba(8,145,178,0.45);
    box-shadow: inset 0 1px 1px rgba(255,255,255,0.12);
  }
  html.theme-ocean .theme-pill-btn:hover {
    background: linear-gradient(135deg, rgba(8,145,178,0.32) 0%, rgba(13,148,136,0.22) 100%) !important;
    box-shadow: inset 0 1px 2px rgba(255,255,255,0.15) !important;
    border-color: #0891b2 !important;
  }
  html.theme-ocean .theme-pill-icon-left  { color: rgba(15,23,42,0.28); opacity: 0.35; transform: scale(0.85) rotate(20deg); }
  html.theme-ocean .theme-pill-icon-right { color: #0ea5e9; opacity: 1; transform: scale(1.15) rotate(0deg); }
</style>
</head>
<body class="bg-[#0f172a] min-h-screen flex justify-center py-4 sm:py-10 text-gray-100 selection:bg-purple-500 selection:text-white">

<div class="bg-gray-800 border border-gray-700 rounded-3xl shadow-2xl max-w-6xl w-full px-4 sm:px-10 py-6 sm:py-12 flex flex-col gap-6 sm:gap-8 mx-4 relative overflow-hidden min-h-[80vh]">
    <!-- Dekorativni sjaj -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl pointer-events-none transform translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none transform -translate-x-1/2 translate-y-1/2"></div>

  <!-- ── HEADER ── -->
  <header class="fade-up flex flex-col sm:flex-row sm:items-start justify-between gap-4 border-b border-gray-700/50 pb-6 relative z-10 non-printable">
    <div class="flex items-start gap-4">
      <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-600 flex items-center justify-center shadow-xl shadow-emerald-500/25 flex-shrink-0">
        <i class="fas fa-chart-bar text-white text-xl"></i>
      </div>
      <div>
        <div class="text-xs text-emerald-400 font-semibold uppercase tracking-widest mb-1 flex items-center gap-2">
          <i class="fas fa-book-open"></i> <?= $subject_display ?>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight tracking-tight"><?= $test_display_name ?></h1>
        <p class="text-gray-400 text-sm mt-1">Pregled odgovora i bodova učenika</p>
      </div>
    </div>
    <div class="flex items-center gap-2 flex-shrink-0">
      <button id="themeToggleBtn" onclick="toggleTheme()" class="theme-pill-btn" title="Promijeni temu">
        <span class="theme-pill-track">
          <span class="theme-pill-thumb"></span>
          <i class="fas fa-moon theme-pill-icon theme-pill-icon-left"></i>
          <i class="fas fa-sun theme-pill-icon theme-pill-icon-right"></i>
        </span>
      </button>
      <button onclick="printWithSorting()" class="flex items-center gap-2 bg-gray-700/40 text-gray-300 hover:bg-gray-700 hover:text-white px-4 py-2.5 rounded-xl transition-colors text-sm font-bold border border-gray-600/30">
        <i class="fas fa-print"></i> <span class="hidden sm:inline">Štampaj</span>
      </button>
      <a href="index.php?route=view_test_results&test_id=<?= $test_id ?>&test_name=<?= urlencode($test_name) ?>&subject_id=<?= $subject_id ?>&export=csv"
         class="flex items-center gap-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white px-4 py-2.5 rounded-xl transition-colors text-sm font-bold border border-blue-500/30">
        <i class="fas fa-file-csv"></i> <span class="hidden sm:inline">Izvezi CSV</span>
      </a>
      <a href="<?= htmlspecialchars($back_url) ?>"
         class="flex items-center gap-2 bg-gray-700/40 text-gray-300 hover:bg-gray-700 hover:text-white px-4 py-2.5 rounded-xl transition-colors text-sm font-bold border border-gray-600/30">
        <i class="fas fa-arrow-left"></i> <span class="hidden sm:inline">Nazad</span>
      </a>
    </div>
  </header>

  <?php if (isset($_SESSION['success_message'])): ?>
      <div id="toastSuccess" class="fixed top-6 right-6 sm:top-8 sm:right-8 bg-emerald-900/90 border border-emerald-500/30 text-emerald-300 px-5 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.5)] backdrop-blur-md z-[9999] fade-up flex items-center gap-3 sm:gap-4 max-w-sm non-printable">
        <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
          <i class="fas fa-check text-emerald-400"></i>
        </div>
        <div class="flex flex-col flex-1 min-w-0">
          <span class="font-bold text-sm sm:text-base text-emerald-100 leading-tight">Uspješno</span>
          <span class="text-xs sm:text-sm opacity-90 mt-0.5"><?= htmlspecialchars($_SESSION['success_message']) ?></span>
        </div>
        <button onclick="this.closest('[id]').style.display='none'" class="flex-shrink-0 text-emerald-400/60 hover:text-emerald-300 transition-colors ml-1 p-1 rounded-lg hover:bg-emerald-800/50" title="Zatvori"><i class="fas fa-times text-xs"></i></button>
      </div>
      <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['error_message'])): ?>
      <div id="toastError" class="fixed top-6 right-6 sm:top-8 sm:right-8 bg-rose-900/90 border border-rose-500/30 text-rose-300 px-5 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.5)] backdrop-blur-md z-[9999] fade-up flex items-center gap-3 sm:gap-4 max-w-sm non-printable">
        <div class="w-8 h-8 rounded-full bg-rose-500/20 flex items-center justify-center flex-shrink-0">
          <i class="fas fa-exclamation-triangle text-rose-400"></i>
        </div>
        <div class="flex flex-col flex-1 min-w-0">
          <span class="font-bold text-sm sm:text-base text-rose-100 leading-tight">Greška</span>
          <span class="text-xs sm:text-sm opacity-90 mt-0.5"><?= htmlspecialchars($_SESSION['error_message']) ?></span>
        </div>
        <button onclick="this.closest('[id]').style.display='none'" class="flex-shrink-0 text-rose-400/60 hover:text-rose-300 transition-colors ml-1 p-1 rounded-lg hover:bg-rose-800/50" title="Zatvori"><i class="fas fa-times text-xs"></i></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>

  <script>
  window.addEventListener('DOMContentLoaded', function() {
    ['toastSuccess', 'toastError'].forEach(function(id) {
      var el = document.getElementById(id);
      if (!el) return;
      setTimeout(function() {
        el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        el.style.opacity = '0';
        el.style.transform = 'translateY(-12px)';
        setTimeout(function() { el.style.display = 'none'; }, 400);
      }, 3500);
    });
  });
  </script>

  <div class="relative z-10 space-y-6 printable-area">
<?php if ($total_submissions === 0): ?>
  <!-- Empty state -->
  <div class="fade-up bg-gray-900/40 rounded-2xl p-16 flex flex-col items-center gap-4 text-center border border-white/5 non-printable" style="animation-delay:.1s">
    <div class="w-20 h-20 rounded-full bg-gray-800 flex items-center justify-center border border-gray-700 mb-2">
      <i class="fas fa-inbox text-4xl text-gray-600"></i>
    </div>
    <h2 class="text-xl font-bold text-white">Nema odgovora</h2>
    <p class="text-gray-400 max-w-sm">Nijedan učenik još uvijek nije predao ovaj test ili odgovori nisu registrovani u bazi podataka.</p>
  </div>
<?php else: ?>

  <!-- ── STAT CARDS ── -->
  <?php
    function scoreClass($pct) {
        if ($pct >= 80) return 'score-excellent';
        if ($pct >= 60) return 'score-good';
        if ($pct >= 40) return 'score-average';
        return 'score-poor';
    }
    function barClass($pct) {
        if ($pct >= 80) return 'bar-excellent';
        if ($pct >= 60) return 'bar-good';
        if ($pct >= 40) return 'bar-average';
        return 'bar-poor';
    }
  ?>
  <div class="fade-up grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 non-printable" style="animation-delay:.08s">
    <!-- Total predaja -->
    <div class="stat-card rounded-2xl p-4 sm:p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-purple-500/15 flex items-center justify-center border border-purple-500/20">
          <i class="fas fa-users text-purple-400"></i>
        </div>
        <span class="text-xs text-gray-500 font-medium">ukupno</span>
      </div>
      <div class="text-3xl font-extrabold text-white"><?= $total_submissions ?></div>
      <div class="text-xs text-gray-400 mt-1 font-medium">predaja testa</div>
    </div>

    <!-- Prosjek -->
    <div class="stat-card rounded-2xl p-4 sm:p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center border border-blue-500/20">
          <i class="fas fa-chart-line text-blue-400"></i>
        </div>
        <span class="text-xs text-gray-500 font-medium">prosjek</span>
      </div>
      <div class="text-3xl font-extrabold <?= scoreClass($avg_score) ?> border-0 bg-transparent p-0"><?= $avg_score ?>%</div>
      <div class="text-xs text-gray-400 mt-1 font-medium">prosječan rezultat</div>
    </div>

    <!-- Najviši -->
    <div class="stat-card rounded-2xl p-4 sm:p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center border border-emerald-500/20">
          <i class="fas fa-trophy text-emerald-400"></i>
        </div>
        <span class="text-xs text-gray-500 font-medium">max</span>
      </div>
      <div class="text-3xl font-extrabold text-emerald-400"><?= $highest_score ?>%</div>
      <div class="text-xs text-gray-400 mt-1 font-medium">najviši rezultat</div>
    </div>

    <!-- Najniži -->
    <div class="stat-card rounded-2xl p-4 sm:p-5">
      <div class="flex items-start justify-between mb-3">
        <div class="w-10 h-10 rounded-xl bg-red-500/15 flex items-center justify-center border border-red-500/20">
          <i class="fas fa-arrow-trend-down text-red-400"></i>
        </div>
        <span class="text-xs text-gray-500 font-medium">min</span>
      </div>
      <div class="text-3xl font-extrabold text-red-400"><?= $lowest_score ?>%</div>
      <div class="text-xs text-gray-400 mt-1 font-medium">najniži rezultat</div>
    </div>
  </div>

<?php
// ────────────────────────────────────────────────────────────
// ANALYTICS: računanje statistike za nastavnika
// ────────────────────────────────────────────────────────────

// 1. Distribucija ocjenskih razreda
$grade_excellent = 0; // >= 80%
$grade_good      = 0; // 60-79%
$grade_average   = 0; // 40-59%
$grade_poor      = 0; // < 40%
foreach ($results_raw as $r) {
    $pct_g = $r['total_points'] > 0 ? ($r['earned_points'] / $r['total_points']) * 100 : 0;
    if ($pct_g >= 80)      $grade_excellent++;
    elseif ($pct_g >= 60)  $grade_good++;
    elseif ($pct_g >= 40)  $grade_average++;
    else                   $grade_poor++;
}

// 2. Statistika po pitanjima (suma zarađenih / suma max bodova)
$q_earned_sum = []; // [question_numb => total earned]
$q_max_sum    = []; // [question_numb => total max]
$q_full_count = []; // [question_numb => count učenika koji su dobili pun bod]
$q_student_count = []; // [question_numb => ukupno učenika koji su odgovorili]

foreach ($answers_by_result as $rid => $qmap) {
    foreach ($qmap as $qn => $ans) {
        $ep = (float)($ans['earned_points'] ?? 0);
        $mp = (float)($ans['max_points'] ?? 0);
        if ($mp <= 0) continue;
        if (!isset($q_earned_sum[$qn])) { $q_earned_sum[$qn] = 0; $q_max_sum[$qn] = 0; $q_full_count[$qn] = 0; $q_student_count[$qn] = 0; }
        $q_earned_sum[$qn]   += $ep;
        $q_max_sum[$qn]      += $mp;
        $q_student_count[$qn]++;
        if (abs($ep - $mp) < 0.01) $q_full_count[$qn]++;
    }
}

// 3. Error rate po pitanju (% učenika koji NISU dobili pun bod)
$q_error_rate = [];
foreach ($q_student_count as $qn => $cnt) {
    if ($cnt > 0) {
        $error_pct = round((1 - $q_full_count[$qn] / $cnt) * 100);
        $q_error_rate[$qn] = $error_pct;
    }
}
arsort($q_error_rate); // sortiraj od najtežeg

// 4. Pitanja koja treba ponoviti (>= 50% grešaka)
$repeat_questions = array_filter($q_error_rate, fn($v) => $v >= 50);

// 5. Prosječan score pitanja (za tooltip)
$q_avg_score = [];
foreach ($q_earned_sum as $qn => $es) {
    $ms = $q_max_sum[$qn];
    $q_avg_score[$qn] = $ms > 0 ? round(($es / $ms) * 100) : 0;
}
?>

  <!-- ── ANALYTICS BLOK ── -->
  <?php if ($total_submissions > 0): ?>
  <div class="fade-up non-printable" style="animation-delay:.11s" id="analyticsBlock">
    <!-- Header accordion -->
    <button type="button"
            onclick="toggleAnalytics()"
            class="w-full flex items-center justify-between px-5 py-4 rounded-2xl border border-indigo-500/25 bg-gradient-to-r from-indigo-950/60 to-purple-950/60 hover:from-indigo-900/70 hover:to-purple-900/70 transition-all group"
            id="analyticsToggleBtn"
            aria-expanded="true">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center">
          <i class="fas fa-chart-pie text-indigo-400 text-sm"></i>
        </div>
        <div class="text-left">
          <div class="font-bold text-white text-sm">Analitika razreda</div>
          <div class="text-xs text-indigo-300/70">Distribucija ocjena · Najteža pitanja</div>
        </div>
      </div>
      <i class="fas fa-chevron-up text-indigo-400 text-xs transition-transform duration-300" id="analyticsChevron"></i>
    </button>

    <!-- Analytics sadržaj -->
    <div id="analyticsContent" class="overflow-hidden transition-all duration-500" style="max-height: 1200px; opacity: 1;">
      <div class="mt-3 grid grid-cols-1 lg:grid-cols-2 gap-4">

        <!-- ── Lijevo: Distribucija ocjena ── -->
        <div class="rounded-2xl border border-white/7 bg-gray-900/50 p-5 flex flex-col gap-4">
          <div class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
            <i class="fas fa-chart-donut text-indigo-400"></i> Distribucija ocjena
          </div>

          <div class="flex flex-col sm:flex-row items-center gap-6">
            <!-- Canvas -->
            <div class="relative flex-shrink-0" style="width:150px;height:150px">
              <canvas id="gradeDonutChart" width="150" height="150"></canvas>
              <!-- Centar label -->
              <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <div class="text-2xl font-extrabold text-white"><?= $total_submissions ?></div>
                <div class="text-[10px] text-gray-400 font-medium">učenika</div>
              </div>
            </div>

            <!-- Legenda -->
            <div class="flex flex-col gap-2.5 flex-1 w-full">
              <?php
              $grade_data = [
                ['label' => 'Odličan (≥80%)',  'count' => $grade_excellent, 'color' => '#34d399', 'bg' => 'rgba(52,211,153,0.12)',  'border' => 'rgba(52,211,153,0.3)'],
                ['label' => 'Dobar (60–79%)',  'count' => $grade_good,      'color' => '#60a5fa', 'bg' => 'rgba(96,165,250,0.12)',  'border' => 'rgba(96,165,250,0.3)'],
                ['label' => 'Dovoljan (40–59%)','count' => $grade_average,  'color' => '#fbbf24', 'bg' => 'rgba(251,191,36,0.12)',  'border' => 'rgba(251,191,36,0.3)'],
                ['label' => 'Nedovoljan (<40%)','count' => $grade_poor,     'color' => '#f87171', 'bg' => 'rgba(248,113,113,0.12)', 'border' => 'rgba(248,113,113,0.3)'],
              ];
              foreach ($grade_data as $gd):
                $gpct = $total_submissions > 0 ? round($gd['count'] / $total_submissions * 100) : 0;
              ?>
              <div class="flex items-center gap-3 rounded-xl px-3 py-2" style="background:<?= $gd['bg'] ?>;border:1px solid <?= $gd['border'] ?>">
                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:<?= $gd['color'] ?>"></span>
                <span class="text-xs text-gray-300 flex-1 font-medium"><?= $gd['label'] ?></span>
                <span class="text-sm font-extrabold" style="color:<?= $gd['color'] ?>"><?= $gd['count'] ?></span>
                <span class="text-[10px] text-gray-500 w-8 text-right"><?= $gpct ?>%</span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Mini KPI: prolaznost -->
          <?php
          $passing = $grade_excellent + $grade_good + $grade_average;
          $pass_rate = $total_submissions > 0 ? round($passing / $total_submissions * 100) : 0;
          $pass_color = $pass_rate >= 80 ? '#34d399' : ($pass_rate >= 60 ? '#60a5fa' : ($pass_rate >= 40 ? '#fbbf24' : '#f87171'));
          ?>
          <div class="mt-1 rounded-xl px-4 py-3 flex items-center justify-between" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06)">
            <span class="text-xs text-gray-400 font-medium"><i class="fas fa-graduation-cap mr-1.5"></i>Prolaznost razreda</span>
            <div class="flex items-center gap-2">
              <div class="h-1.5 w-28 rounded-full overflow-hidden" style="background:rgba(255,255,255,0.07)">
                <div class="h-full rounded-full transition-all duration-1000" style="width:<?= $pass_rate ?>%;background:<?= $pass_color ?>"></div>
              </div>
              <span class="text-sm font-extrabold" style="color:<?= $pass_color ?>"><?= $pass_rate ?>%</span>
            </div>
          </div>
        </div>

        <!-- ── Desno: Najteža pitanja ── -->
        <div class="rounded-2xl border border-white/7 bg-gray-900/50 p-5 flex flex-col gap-3">
          <div class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
            <i class="fas fa-fire text-orange-400"></i> Najteža pitanja (po stopi greške)
          </div>

          <?php if (empty($q_error_rate)): ?>
          <div class="flex-1 flex items-center justify-center text-gray-500 text-sm py-8">
            <i class="fas fa-info-circle mr-2"></i>Nema dovoljno podataka o odgovorima.
          </div>
          <?php else: ?>

          <div class="flex flex-col gap-2 flex-1">
            <?php
            $rank = 0;
            foreach ($q_error_rate as $qn => $err_pct):
              $rank++;
              if ($rank > 8) break; // Prikaži max 8 pitanja
              $avg_sc = $q_avg_score[$qn] ?? 0;
              $cnt_q  = $q_student_count[$qn] ?? 0;
              // Boja po stepenu greške
              if ($err_pct >= 70)      { $dot_color = '#f87171'; $bar_color = 'linear-gradient(90deg,#dc2626,#f87171)'; $label_color = '#fca5a5'; }
              elseif ($err_pct >= 50)  { $dot_color = '#fb923c'; $bar_color = 'linear-gradient(90deg,#ea580c,#fb923c)'; $label_color = '#fdba74'; }
              elseif ($err_pct >= 30)  { $dot_color = '#fbbf24'; $bar_color = 'linear-gradient(90deg,#d97706,#fbbf24)'; $label_color = '#fde68a'; }
              else                     { $dot_color = '#34d399'; $bar_color = 'linear-gradient(90deg,#059669,#34d399)'; $label_color = '#6ee7b7'; }
            ?>
            <div class="rounded-xl px-3 py-2.5 flex items-center gap-3 hover:bg-white/3 transition-colors" style="background:rgba(255,255,255,0.025);border:1px solid rgba(255,255,255,0.05)">
              <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 text-xs font-black" style="background:rgba(255,255,255,0.05);color:<?= $label_color ?>">
                <?= $rank ?>
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between mb-1.5 gap-2">
                  <span class="text-xs font-bold text-gray-200 truncate">Pitanje <?= $qn ?></span>
                  <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="text-[10px] text-gray-500"><?= $cnt_q ?> uč.</span>
                    <span class="text-xs font-extrabold" style="color:<?= $label_color ?>"><?= $err_pct ?>% greš.</span>
                  </div>
                </div>
                <div class="h-1.5 rounded-full overflow-hidden" style="background:rgba(255,255,255,0.07)">
                  <div class="h-full rounded-full" style="width:<?= $err_pct ?>%;background:<?= $bar_color ?>;transition:width 1.2s cubic-bezier(.4,0,.2,1)"></div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <!-- Preporuka nastavniku -->
          <?php if (!empty($repeat_questions)): ?>
          <div class="mt-1 rounded-xl px-4 py-3 flex items-start gap-3" style="background:rgba(251,191,36,0.07);border:1px solid rgba(251,191,36,0.2)">
            <i class="fas fa-lightbulb text-amber-400 mt-0.5 flex-shrink-0"></i>
            <div>
              <div class="text-xs font-bold text-amber-300 mb-0.5">Preporuka za nastavnika</div>
              <div class="text-xs text-amber-200/80 leading-relaxed">
                Više od polovine učenika je pogriješilo na pitanjima:
                <span class="font-bold text-amber-300"><?= implode(', ', array_map(fn($k) => 'Pit. ' . $k, array_keys($repeat_questions))) ?></span>.
                Preporučuje se ponavljanje tog gradiva na narednom času.
              </div>
            </div>
          </div>
          <?php else: ?>
          <div class="mt-1 rounded-xl px-4 py-3 flex items-center gap-3" style="background:rgba(52,211,153,0.07);border:1px solid rgba(52,211,153,0.2)">
            <i class="fas fa-circle-check text-emerald-400 flex-shrink-0"></i>
            <div class="text-xs text-emerald-300/90 leading-relaxed">
              Odlično! Nijedno pitanje nema stopu greške ≥50%. Gradivo je dobro usvojeno.
            </div>
          </div>
          <?php endif; ?>

          <?php endif; // end empty check ?>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- ── SEARCH + FILTER ── -->
  <div class="fade-up flex flex-col sm:flex-row gap-3 relative z-50 non-printable" style="animation-delay:.13s">
    <div class="relative flex-1">
      <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500"><i class="fas fa-search text-sm"></i></span>
      <input id="searchInput" type="text" placeholder="Pretraži po imenu ili korisničkom imenu..."
             class="w-full bg-gray-800/60 text-white pl-10 pr-4 py-2.5 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 text-sm backdrop-blur-md">
    </div>
    <div class="relative w-full sm:w-56 z-40">
      <input type="hidden" id="sortSelect" value="date_desc">
      <button type="button" id="sortSelectBtn" onclick="document.getElementById('sortSelectDropdown').classList.toggle('hidden')" class="w-full bg-gray-800/60 text-white px-4 py-2.5 rounded-xl border border-gray-700 hover:border-purple-500 hover:shadow-[0_0_15px_rgba(168,85,247,0.15)] focus:border-purple-500 outline-none transition-all flex items-center justify-between shadow-sm cursor-pointer backdrop-blur-md h-full min-h-[42px] group">
          <span class="truncate font-medium flex items-center gap-2.5 text-sm" id="sortSelectText">
              <i class="fas fa-sort-amount-down text-purple-400"></i> Datum ↓ (najnoviji)
          </span>
          <i class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-purple-400 transition-colors"></i>
      </button>

      <div id="sortSelectDropdown" class="hidden absolute left-0 sm:right-0 sm:left-auto w-full sm:w-[220px] top-[100%] mt-2 bg-gray-900/95 backdrop-blur-xl border border-gray-700/80 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] overflow-hidden z-[60] max-h-60 overflow-y-auto custom-scrollbar fade-up" style="animation-delay: 0s; animation-duration: 0.2s;">
          <div class="flex flex-col p-2 gap-1">
              <button type="button" onclick="selectSortOption('date_desc', 'Datum ↓ (najnoviji)', 'fa-sort-amount-down text-purple-400')" class="px-3 py-2.5 text-sm rounded-xl transition-all flex items-center gap-3 text-gray-400 hover:bg-gray-800/80 hover:text-white text-left w-full group/btn">
                  <div class="w-7 h-7 rounded-lg bg-gray-800 flex justify-center items-center border border-gray-700 group-hover/btn:border-purple-500/50 transition-colors"><i class="fas fa-sort-amount-down text-purple-400"></i></div> Datum ↓ (najnoviji)
              </button>
              <button type="button" onclick="selectSortOption('date_asc', 'Datum ↑ (najstariji)', 'fa-sort-amount-up text-purple-400')" class="px-3 py-2.5 text-sm rounded-xl transition-all flex items-center gap-3 text-gray-400 hover:bg-gray-800/80 hover:text-white text-left w-full group/btn">
                  <div class="w-7 h-7 rounded-lg bg-gray-800 flex justify-center items-center border border-gray-700 group-hover/btn:border-purple-500/50 transition-colors"><i class="fas fa-sort-amount-up text-purple-400"></i></div> Datum ↑ (najstariji)
              </button>
              <button type="button" onclick="selectSortOption('score_desc', 'Rezultat ↓ (najviši)', 'fa-sort-numeric-down text-emerald-400')" class="px-3 py-2.5 text-sm rounded-xl transition-all flex items-center gap-3 text-gray-400 hover:bg-gray-800/80 hover:text-white text-left w-full group/btn">
                  <div class="w-7 h-7 rounded-lg bg-gray-800 flex justify-center items-center border border-gray-700 group-hover/btn:border-emerald-500/50 transition-colors"><i class="fas fa-sort-numeric-down text-emerald-400"></i></div> Rezultat ↓ (najviši)
              </button>
              <button type="button" onclick="selectSortOption('score_asc', 'Rezultat ↑ (najniži)', 'fa-sort-numeric-up text-emerald-400')" class="px-3 py-2.5 text-sm rounded-xl transition-all flex items-center gap-3 text-gray-400 hover:bg-gray-800/80 hover:text-white text-left w-full group/btn">
                  <div class="w-7 h-7 rounded-lg bg-gray-800 flex justify-center items-center border border-gray-700 group-hover/btn:border-emerald-500/50 transition-colors"><i class="fas fa-sort-numeric-up text-emerald-400"></i></div> Rezultat ↑ (najniži)
              </button>
              <div class="h-px bg-gray-700/50 my-0.5 mx-2"></div>
              <button type="button" onclick="selectSortOption('name_asc', 'Ime (A–Ž)', 'fa-sort-alpha-down text-blue-400')" class="px-3 py-2.5 text-sm rounded-xl transition-all flex items-center gap-3 text-gray-400 hover:bg-gray-800/80 hover:text-white text-left w-full group/btn">
                  <div class="w-7 h-7 rounded-lg bg-gray-800 flex justify-center items-center border border-gray-700 group-hover/btn:border-blue-500/50 transition-colors"><i class="fas fa-sort-alpha-down text-blue-400"></i></div> Ime (A–Ž)
              </button>
          </div>
      </div>
    </div>
  </div>

  <!-- Print-only header -->
  <div class="print-header hidden">
      <h1>Rezultati testa: <?= $test_display_name ?></h1>
      <p>Predmet: <?= $subject_display ?></p>
  </div>

  <!-- ── TABELA ZA ŠTAMPU (vidljiva samo pri štampanju) ── -->
  <div class="hidden print:block w-full">
    <table>
      <thead>
        <tr>
          <th>Učenik</th>
          <th>Vrijeme predaje</th>
          <th>Bodovi</th>
          <th>Rezultat</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($results_raw as $i => $r):
          $pct = $r['total_points'] > 0 ? round(($r['earned_points'] / $r['total_points']) * 100, 1) : 0;
          $fullName = trim($r['student_first_name'] . ' ' . $r['student_last_name']);
          $dtFormatted = formatBelgradeTime($r['submitted_at']);
          $answers = $answers_by_result[$r['id']] ?? [];
        ?>
        <tr>
          <td>
            <?= htmlspecialchars($fullName) ?>
            <?php if (!empty($r['class_name'])): ?> (<?= htmlspecialchars($r['class_name']) ?>)<?php endif; ?>
          </td>
          <td><?= $dtFormatted ?></td>
          <td><?= number_format($r['earned_points'], 1) ?> / <?= number_format($r['total_points'], 1) ?></td>
          <td><?= $pct ?>%</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- ── STUDENT LIST ── -->
  <div class="fade-up space-y-3" id="resultsList" style="animation-delay:.18s">
    <?php
    $avatar_colors = [
        ['from' => '#a855f7', 'to' => '#ec4899'], // Purple to Pink
        ['from' => '#22d3ee', 'to' => '#0ea5e9'], // Cyan to Sky
        ['from' => '#f97316', 'to' => '#f59e0b'], // Orange to Amber
        ['from' => '#10b981', 'to' => '#34d399'], // Emerald to Green
        ['from' => '#ef4444', 'to' => '#f97316'], // Red to Orange
        ['from' => '#6366f1', 'to' => '#8b5cf6'], // Indigo to Violet
    ];
    foreach ($results_raw as $i => $r):
      $pct = $r['total_points'] > 0 ? round(($r['earned_points'] / $r['total_points']) * 100, 1) : 0;
      $scClass = scoreClass($pct);
      $bClass  = barClass($pct);
      $fullName = trim($r['student_first_name'] . ' ' . $r['student_last_name']);
      $dtFormatted = $r['submitted_at'] ? date('d.m.Y. H:i', strtotime($r['submitted_at'])) : '—';
      $answers = $answers_by_result[$r['id']] ?? [];
      $color_index = crc32($fullName) % count($avatar_colors);
      $color_pair = $avatar_colors[$color_index];
      $initials = mb_strtoupper(mb_substr($r['student_first_name'], 0, 1) . mb_substr($r['student_last_name'], 0, 1));
    ?>
    <div class="student-row glass-strong rounded-2xl overflow-hidden result-item"
         data-result-id="<?= $r['id'] ?>"
         data-name="<?= htmlspecialchars(strtolower($fullName . ' ' . ($r['username'] ?? ''))) ?>"
         data-score="<?= $pct ?>"
         data-date="<?= $r['submitted_at'] ?? '' ?>">

      <!-- Row header (always visible) -->
      <div class="accordion-btn flex flex-col sm:flex-row sm:items-center gap-3 p-4 sm:p-5" onclick="toggleAccordion(this)">

        <!-- Avatar + name -->
        <div class="flex items-center gap-3 flex-1 min-w-0">
          <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 text-sm font-black text-white shadow-lg"
               style="background: linear-gradient(135deg, <?= $color_pair['from'] ?>, <?= $color_pair['to'] ?>); text-shadow: 0 1px 3px rgba(0,0,0,0.2);">
            <?= $initials ?>
          </div>
          <div class="min-w-0">
            <div class="font-bold text-white text-sm sm:text-base truncate"><?= htmlspecialchars($fullName) ?></div>
            <div class="flex items-center gap-2 flex-wrap mt-0.5">
              <?php if (!empty($r['username'])): ?>
                <span class="text-xs text-gray-400">@<?= htmlspecialchars($r['username']) ?></span>
              <?php endif; ?>
              <?php if (!empty($r['class_name'])): ?>
                <span class="badge bg-emerald-500/10 text-emerald-400 border border-emerald-500/25">
                  <i class="fas fa-users text-[9px]"></i> <?= htmlspecialchars($r['class_name']) ?>
                </span>
              <?php endif; ?>
              <span class="text-xs text-gray-500"><i class="fas fa-clock mr-1"></i><?= $dtFormatted ?></span>
            </div>
          </div>
        </div>

        <!-- Score -->
        <div class="flex items-center gap-4 sm:gap-6 flex-shrink-0">
          <div class="text-right">
            <div class="text-xs text-gray-500 mb-1">Bodovi</div>
            <div class="font-bold text-sm <?= $scClass ?> border-0 bg-transparent p-0">
              <?= number_format($r['earned_points'], 1) ?> / <?= number_format($r['total_points'], 1) ?>
            </div>
          </div>
          <div class="flex flex-col items-end gap-1.5 min-w-[90px] sm:min-w-[120px]">
            <div class="text-right font-extrabold text-lg <?= $scClass ?> border-0 bg-transparent p-0 leading-none"><?= $pct ?>%</div>
            <div class="score-bar-track w-full">
              <div class="score-bar-fill <?= $bClass ?>" style="width:<?= $pct ?>%"></div>
            </div>
          </div>
          <div class="flex items-center gap-3 pl-2 sm:pl-4 border-l border-white/10 ml-2">
            <i class="fas fa-chevron-down text-gray-500 text-sm transition-transform duration-300 accordion-chevron"></i>
            <button type="button" onclick="event.stopPropagation(); showDeleteResultModal('index.php?route=delete_test_result&result_id=<?= $r['id'] ?>&test_id=<?= $test_id ?>&subject_id=<?= $subject_id ?>', '<?= htmlspecialchars($fullName, ENT_QUOTES) ?>');" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-8 h-8 flex items-center justify-center rounded-lg transition-colors" title="Obriši pokušaj">
              <i class="fas fa-trash-alt text-xs"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Detailed answers (collapsible) -->
      <?php if (!empty($answers)): ?>
      <div class="accordion-content closed" style="max-height: 2000px;">
        <div class="border-t border-white/5 px-4 sm:px-5 pb-4 sm:pb-5 pt-4">
          <div class="text-xs text-gray-500 uppercase tracking-widest font-bold mb-3 flex items-center gap-2">
            <i class="fas fa-list-ol text-purple-400"></i> Odgovori po pitanjima
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5">
            <?php for ($q = 1; $q <= $max_q; $q++):
              $ans = $answers[$q] ?? null;
              if (!$ans) continue;
              $ep  = (float)($ans['earned_points'] ?? 0);
              $mp  = (float)($ans['max_points'] ?? 0);
              $qpct = $mp > 0 ? round(($ep / $mp) * 100) : 0;
              $qScClass = scoreClass($qpct);
              $qBClass  = barClass($qpct);
              $rawAns = $ans['student_answer'];
              $decoded = json_decode($rawAns, true);
              $displayAns = is_array($decoded) ? implode(', ', $decoded) : $rawAns;
            ?>
            <div class="bg-gray-800/80 rounded-xl p-3 border border-white/5 hover:border-white/10 transition-colors shadow-inner">
              <div class="flex items-center justify-between mb-2 gap-2">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pitanje <?= $q ?></span>
                <div class="flex items-center gap-2">
                  <span class="answer-chip <?= $qScClass ?>">
                    <?= number_format($ep, 1) ?> / <?= number_format($mp, 1) ?> bod.
                  </span>
                  <button type="button" onclick="editPoints(<?= $r['id'] ?>, <?= $q ?>, <?= $ep ?>, <?= $mp ?>)" class="text-blue-400 hover:text-blue-300 transition-colors w-6 h-6 flex items-center justify-center rounded-md hover:bg-blue-500/20 border border-transparent hover:border-blue-500/30" title="Izmijeni bodove">
                    <i class="fas fa-edit text-xs"></i>
                  </button>
                </div>
              </div>
              <div class="text-sm text-gray-200 font-medium mb-2 break-words leading-relaxed min-h-[1.4rem]">
                <?= $displayAns !== '' && $displayAns !== null ? htmlspecialchars($displayAns) : '<span class="text-gray-500 italic text-xs">Bez odgovora</span>' ?>
              </div>
            </div>
            <?php endfor; ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>

<?php endif; ?>
  </div> <!-- /relative z-10 space-y-6 -->
</div> <!-- /wrapper -->

<!-- Globalni Custom Tooltip -->
<div id="globalTooltip" class="fixed z-[100] hidden bg-gray-900/95 text-white text-xs font-medium px-3 py-1.5 rounded-lg border border-gray-700/50 shadow-[0_4px_20px_rgba(0,0,0,0.5)] pointer-events-none transition-all duration-200 opacity-0 whitespace-nowrap backdrop-blur-sm transform scale-95"></div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tooltip = document.getElementById('globalTooltip');
    let hideTimeout;
    document.addEventListener('mouseover', (e) => {
        const target = e.target.closest('[title]');
        if (!target) return;
        const title = target.getAttribute('title');
        if (!title) return;
        target.setAttribute('data-tooltip-text', title);
        target.removeAttribute('title');
        clearTimeout(hideTimeout);
        tooltip.textContent = title;
        tooltip.classList.remove('hidden');
        const rect = target.getBoundingClientRect();
        const tooltipRect = tooltip.getBoundingClientRect();
        let top = rect.top - tooltipRect.height - 8;
        let left = rect.left + (rect.width - tooltipRect.width) / 2;
        if (top < 0) top = rect.bottom + 8;
        if (left < 8) left = 8;
        if (left + tooltipRect.width > window.innerWidth) left = window.innerWidth - tooltipRect.width - 8;
        tooltip.style.top = `${top}px`;
        tooltip.style.left = `${left}px`;
        requestAnimationFrame(() => {
            tooltip.classList.remove('opacity-0', 'scale-95');
            tooltip.classList.add('opacity-100', 'scale-100');
        });
    });
    document.addEventListener('mouseout', (e) => {
        const target = e.target.closest('[data-tooltip-text]');
        if (!target) return;
        const title = target.getAttribute('data-tooltip-text');
        target.setAttribute('title', title);
        target.removeAttribute('data-tooltip-text');
        tooltip.classList.remove('opacity-100', 'scale-100');
        tooltip.classList.add('opacity-0', 'scale-95');
        hideTimeout = setTimeout(() => { tooltip.classList.add('hidden'); }, 200);
    });
    document.addEventListener('click', () => {
        if(tooltip) tooltip.classList.add('hidden');
        document.querySelectorAll('[data-tooltip-text]').forEach(el => {
            el.setAttribute('title', el.getAttribute('data-tooltip-text'));
            el.removeAttribute('data-tooltip-text');
        });
    });
});
</script>

<!-- Modal za izmjenu bodova -->
<div id="editPointsModal" class="hidden fixed inset-0 flex justify-center items-center z-[9999] bg-black/0 backdrop-blur-sm transition-all duration-300">
  <div id="editPointsContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-4 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400 border border-blue-500/30">
            <i class="fas fa-star-half-alt text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Izmijeni bodove</h2>
    </div>
    <input type="hidden" id="epResultId">
    <input type="hidden" id="epQuestionNumb">
    <div class="space-y-2 mb-6">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 block mb-2">Novi broj bodova (Max: <span id="epMaxPoints"></span>)</label>
        <div class="flex items-center bg-gray-900 rounded-xl border border-gray-700 overflow-hidden focus-within:border-purple-500 focus-within:ring-1 focus-within:ring-purple-500 transition-all">
            <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-colors outline-none cursor-pointer flex-shrink-0">
                <i class="fas fa-minus text-sm"></i>
            </button>
            <input type="number" step="0.5" min="0" id="epNewPoints" class="w-full bg-transparent text-white text-center border-none p-0 focus:ring-0 appearance-none [-moz-appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none font-medium text-lg">
            <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-colors outline-none cursor-pointer flex-shrink-0">
                <i class="fas fa-plus text-sm"></i>
            </button>
        </div>
    </div>
    <div class="flex justify-end gap-3 pt-2 mt-2">
      <button type="button" id="cancelEditPoints" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
      <button type="button" id="confirmEditPoints" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-blue-500/30">
        <i class="fas fa-save"></i> Sačuvaj
      </button>
    </div>
  </div>
</div>

<!-- Modal za potvrdu brisanja -->
<div id="deleteModal" class="hidden fixed inset-0 flex justify-center items-center z-[9999] bg-black/0 backdrop-blur-sm transition-all duration-300">
  <div id="deleteContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-4 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center text-red-500 border border-red-500/30">
            <i class="fas fa-exclamation-triangle text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white" id="deleteModalTitle">Potvrdi brisanje</h2>
    </div>
    <p class="text-gray-300 mb-6 text-sm sm:text-base leading-relaxed" id="deleteModalMessage">Jeste li sigurni da želite obrisati ovaj pokušaj?</p>
    <div class="flex justify-end gap-3 pt-2">
      <button type="button" id="cancelDelete" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
      <a href="#" id="confirmDelete" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-red-500/30">
        <i class="fas fa-trash-alt"></i> Obriši
      </a>
    </div>
  </div>
</div>

<script>
// ── Accordion ─────────────────────────────────────────────
function toggleAccordion(btn) {
    const content   = btn.nextElementSibling;
    const chevron   = btn.querySelector('.accordion-chevron');
    if (!content) return;
    const isClosed  = content.classList.contains('closed');
    content.classList.toggle('closed', !isClosed);
    chevron && chevron.classList.toggle('rotate-180', isClosed);
    
    // Pohrani otvoren accordion u sessionStorage
    const resultItem = btn.closest('.result-item');
    if (resultItem && !isClosed) {
        const resultId = resultItem.getAttribute('data-result-id');
        if (resultId) {
            sessionStorage.setItem('openedResultId', resultId);
        }
    }
}

// ── Print with Sorting ───────────────────────────────────
function printWithSorting() {
    const printTable = document.querySelector('.hidden.print\\:block table');
    const tbody = printTable ? printTable.querySelector('tbody') : null;
    
    if (!tbody) {
        window.print();
        return;
    }
    
    // Get all visible rows from the interactive list (already sorted by filterAndSort)
    const list = document.getElementById('resultsList');
    const resultItems = Array.from(list.querySelectorAll('.result-item')).filter(el => el.style.display !== 'none');
    
    if (resultItems.length === 0) {
        window.print();
        return;
    }
    
    // Extract student full names from result items in sorted order
    // Navigate: result-item > accordion-btn > name-container > .font-bold.text-white
    const sortedNames = resultItems.map(item => {
        // Find the name element - it's the first .font-bold.text-white inside accordion-btn
        const nameEl = item.querySelector('.accordion-btn .font-bold.text-white');
        const nameText = nameEl ? nameEl.textContent.trim() : '';
        return nameText.toLowerCase();
    }).filter(name => name.length > 0); // Filter out empty names
    
    // Get all rows from print table
    const allTableRows = Array.from(tbody.querySelectorAll('tr'));
    
    // Filter and sort rows based on visible order
    const visibleTableRows = allTableRows.filter(row => {
        const rowNameEl = row.querySelector('td:first-child');
        if (!rowNameEl) return false;
        
        const rowName = rowNameEl.textContent.trim().toLowerCase();
        // Remove class info in parentheses for comparison
        const rowNameClean = rowName.replace(/\s*\([^)]*\)\s*$/, '').trim();
        
        // Check if this name is in the sorted list
        return sortedNames.some(sortedName => {
            const sortedNameClean = sortedName.replace(/\s*\([^)]*\)\s*$/, '').trim();
            return rowNameClean.includes(sortedNameClean) || sortedNameClean.includes(rowNameClean);
        });
    });
    
    // Sort filtered rows based on the sorted order
    visibleTableRows.sort((rowA, rowB) => {
        const nameAEl = rowA.querySelector('td:first-child');
        const nameBEl = rowB.querySelector('td:first-child');
        
        const nameA = nameAEl ? nameAEl.textContent.trim().toLowerCase().replace(/\s*\([^)]*\)\s*$/g, '').trim() : '';
        const nameB = nameBEl ? nameBEl.textContent.trim().toLowerCase().replace(/\s*\([^)]*\)\s*$/g, '').trim() : '';
        
        // Find index in sorted list
        const indexA = sortedNames.findIndex(sn => {
            const snClean = sn.replace(/\s*\([^)]*\)\s*$/, '').trim();
            return nameA.includes(snClean) || snClean.includes(nameA);
        });
        const indexB = sortedNames.findIndex(sn => {
            const snClean = sn.replace(/\s*\([^)]*\)\s*$/, '').trim();
            return nameB.includes(snClean) || snClean.includes(nameB);
        });
        
        return (indexA === -1 ? 999 : indexA) - (indexB === -1 ? 999 : indexB);
    });
    
    // Clear tbody and re-append only visible, sorted rows
    tbody.innerHTML = '';
    visibleTableRows.forEach(row => tbody.appendChild(row));
    
    // Print after a small delay to ensure DOM is updated
    setTimeout(() => window.print(), 100);
}


// ── Search ────────────────────────────────────────────────
const searchInput = document.getElementById('searchInput');
const sortSelect  = document.getElementById('sortSelect');
const list        = document.getElementById('resultsList');
const emptyEl     = document.getElementById('emptySearch');

function filterAndSort() {
    const q    = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const sort = sortSelect ? sortSelect.value : 'date_desc';
    const items = Array.from(list.querySelectorAll('.result-item'));

    let visible = items.filter(el => {
        const name = el.dataset.name || '';
        return q === '' || name.includes(q);
    });

    items.forEach(el => el.style.display = 'none');

    visible.sort((a, b) => {
        if (sort === 'score_desc') return parseFloat(b.dataset.score) - parseFloat(a.dataset.score);
        if (sort === 'score_asc')  return parseFloat(a.dataset.score) - parseFloat(b.dataset.score);
        if (sort === 'name_asc')   return (a.dataset.name || '').localeCompare(b.dataset.name || '');
        if (sort === 'date_asc')   return (a.dataset.date || '').localeCompare(b.dataset.date || '');
        return (b.dataset.date || '').localeCompare(a.dataset.date || ''); // date_desc
    });

    visible.forEach(el => { el.style.display = ''; list.appendChild(el); });
    emptyEl && (emptyEl.style.display = visible.length === 0 ? '' : 'none');
}

function selectSortOption(value, name, iconClass) {
    if (sortSelect) sortSelect.value = value;
    const textEl = document.getElementById('sortSelectText');
    if (textEl) textEl.innerHTML = `<i class="fas ${iconClass}"></i> ${name}`;
    const dropdown = document.getElementById('sortSelectDropdown');
    if (dropdown) dropdown.classList.add('hidden');
    filterAndSort();
}

document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('sortSelectDropdown');
    const btn = document.getElementById('sortSelectBtn');
    if (dropdown && !dropdown.classList.contains('hidden')) {
        if (!dropdown.contains(event.target) && btn && !btn.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    }
});

if(searchInput) searchInput.addEventListener('input', filterAndSort);

// ── Animate score bars on load ────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.score-bar-fill').forEach(bar => {
        const w = bar.style.width;
        bar.style.width = '0%';
        requestAnimationFrame(() => setTimeout(() => bar.style.width = w, 80));
    });

    // Otvori accordion koji je bio otvoren prije osvežavanja
    const openedResultId = sessionStorage.getItem('openedResultId');
    if (openedResultId) {
        const resultItem = document.querySelector(`.result-item[data-result-id="${openedResultId}"]`);
        if (resultItem) {
            const accordionBtn = resultItem.querySelector('.accordion-btn');
            const accordionContent = resultItem.querySelector('.accordion-content');
            const chevron = accordionBtn?.querySelector('.accordion-chevron');
            
            if (accordionContent && accordionContent.classList.contains('closed')) {
                accordionContent.classList.remove('closed');
                if (chevron) {
                    chevron.classList.add('rotate-180');
                }
            }
        }
        // Očisti sessionStorage nakon otvaranja
        sessionStorage.removeItem('openedResultId');
    }
});

// ── Delete Modal Logic ────────────────────────────────────
const deleteModal = document.getElementById('deleteModal');
const deleteContent = document.getElementById('deleteContent');
const confirmDelete = document.getElementById('confirmDelete');
const cancelDelete = document.getElementById('cancelDelete');

function showDeleteResultModal(url, studentName) {
    const msgEl = document.getElementById('deleteModalMessage');
    if(msgEl) msgEl.innerHTML = `Da li ste sigurni da želite obrisati pokušaj učenika <strong>${studentName}</strong>? Ova akcija je nepovratna.`;
    if(confirmDelete) confirmDelete.href = url;

    if(deleteModal) {
        deleteModal.classList.remove('hidden');
        requestAnimationFrame(() => {
            deleteModal.classList.remove('bg-black/0');
            deleteModal.classList.add('bg-black/60');
            if(deleteContent) {
                deleteContent.classList.remove('opacity-0', 'scale-95');
                deleteContent.classList.add('opacity-100', 'scale-100');
            }
        });
    }
}

function hideDeleteModal() {
    if(deleteModal) {
        deleteModal.classList.remove('bg-black/60');
        deleteModal.classList.add('bg-black/0');
    }
    if(deleteContent) {
        deleteContent.classList.remove('opacity-100', 'scale-100');
        deleteContent.classList.add('opacity-0', 'scale-95');
    }
    setTimeout(() => {
        if(deleteModal) deleteModal.classList.add('hidden');
    }, 300);
}

if (cancelDelete) cancelDelete.addEventListener('click', hideDeleteModal);
if (deleteModal) deleteModal.addEventListener('click', (e) => { if(e.target === deleteModal) hideDeleteModal(); });

// ── Edit Points Modal Logic ───────────────────────────────
const editPointsModal = document.getElementById('editPointsModal');
const editPointsContent = document.getElementById('editPointsContent');

function editPoints(resultId, questionNumb, currentPoints, maxPoints) {
    const epResId = document.getElementById('epResultId');
    const epQNumb = document.getElementById('epQuestionNumb');
    const epMax = document.getElementById('epMaxPoints');
    const epNew = document.getElementById('epNewPoints');
    
    if(epResId) epResId.value = resultId;
    if(epQNumb) epQNumb.value = questionNumb;
    if(epMax) epMax.textContent = maxPoints;
    if(epNew) {
        epNew.value = currentPoints;
        epNew.max = maxPoints;
    }

    if(editPointsModal) {
        editPointsModal.classList.remove('hidden');
        requestAnimationFrame(() => {
            editPointsModal.classList.remove('bg-black/0');
            editPointsModal.classList.add('bg-black/60');
            if(editPointsContent) {
                editPointsContent.classList.remove('opacity-0', 'scale-95');
                editPointsContent.classList.add('opacity-100', 'scale-100');
            }
        });
    }
}

function hideEditPointsModal() {
    if(editPointsModal) {
        editPointsModal.classList.remove('bg-black/60');
        editPointsModal.classList.add('bg-black/0');
    }
    if(editPointsContent) {
        editPointsContent.classList.remove('opacity-100', 'scale-100');
        editPointsContent.classList.add('opacity-0', 'scale-95');
    }
    setTimeout(() => {
        if(editPointsModal) editPointsModal.classList.add('hidden');
    }, 300);
}

const cancelEditPoints = document.getElementById('cancelEditPoints');
if(cancelEditPoints) cancelEditPoints.addEventListener('click', hideEditPointsModal);
if(editPointsModal) editPointsModal.addEventListener('click', (e) => { if(e.target === editPointsModal) hideEditPointsModal(); });

const confirmEditPoints = document.getElementById('confirmEditPoints');
if(confirmEditPoints) {
    confirmEditPoints.addEventListener('click', function() {
        const btn = this;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Čuvanje...';
        btn.disabled = true;

        const fd = new FormData();
        const epResId = document.getElementById('epResultId');
        const epQNumb = document.getElementById('epQuestionNumb');
        const epNew = document.getElementById('epNewPoints');
        
        if(epResId) fd.append('result_id', epResId.value);
        if(epQNumb) fd.append('question_numb', epQNumb.value);
        if(epNew) fd.append('points', epNew.value);
        fd.append('csrf_token', '<?= $csrf_token ?>');

        // Pohrani result_id koji je aktuelno otvoren
        const epResId_val = epResId ? epResId.value : null;
        if (epResId_val) {
            sessionStorage.setItem('openedResultId', epResId_val);
        }

        fetch('index.php?route=update_answer_points', { method: 'POST', body: fd })
          .then(res => res.json())
          .then(data => { 
              if(data.success) {
                  window.location.reload(); 
              } else { 
                  alert('Greška pri čuvanju bodova.'); 
                  btn.innerHTML = originalHtml; 
                  btn.disabled = false; 
              } 
          })
          .catch(err => { 
              alert('Mrežna greška.'); 
              btn.innerHTML = originalHtml; 
              btn.disabled = false; 
          });
    });
}

// ── Analytics Toggle ─────────────────────────────────────
function toggleAnalytics() {
    const content = document.getElementById('analyticsContent');
    const chevron = document.getElementById('analyticsChevron');
    const btn     = document.getElementById('analyticsToggleBtn');
    if (!content) return;
    const isOpen = content.style.maxHeight !== '0px' && content.style.opacity !== '0';
    if (isOpen) {
        content.style.maxHeight = '0px';
        content.style.opacity   = '0';
        content.style.marginTop = '0';
        if (chevron) { chevron.classList.remove('rotate-180'); chevron.classList.add('rotate-0'); }
        if (btn) btn.setAttribute('aria-expanded', 'false');
    } else {
        content.style.maxHeight = '1200px';
        content.style.opacity   = '1';
        content.style.marginTop = '';
        if (chevron) { chevron.classList.add('rotate-180'); chevron.classList.remove('rotate-0'); }
        if (btn) btn.setAttribute('aria-expanded', 'true');
    }
}

// ── Theme Toggle ───────────────────────────────────────────
function toggleTheme() {
  var btn = document.getElementById('themeToggleBtn');
  if (btn && btn.classList.contains('switching')) return;
  if (btn) btn.classList.add('switching');
  
  document.body.style.transition = 'opacity 0.15s ease';
  document.body.style.opacity = '0.85';
  
  setTimeout(function() {
    var isOcean = document.documentElement.classList.toggle('theme-ocean');
    
    var urlParams = new URLSearchParams(window.location.search);
    var currentSubject = urlParams.get('subject_id');
    
    if (currentSubject) {
        localStorage.setItem('subject_' + currentSubject + '_theme', isOcean ? 'ocean' : 'purple');
    } else {
        localStorage.setItem('appTheme', isOcean ? 'ocean' : 'purple');
    }

    document.body.style.opacity = '1';
    if (btn) {
      setTimeout(function() {
        btn.classList.remove('switching');
      }, 400);
    }
  }, 150);
}

// ── Grade Donut Chart (Chart.js) ──────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('gradeDonutChart');
    if (!canvas || typeof Chart === 'undefined') return;

    const gradeData = {
        labels: ['Odličan (≥80%)', 'Dobar (60–79%)', 'Dovoljan (40–59%)', 'Nedovoljan (<40%)'],
        datasets: [{
            data: [
                <?= (int)$grade_excellent ?>,
                <?= (int)$grade_good ?>,
                <?= (int)$grade_average ?>,
                <?= (int)$grade_poor ?>
            ],
            backgroundColor: [
                'rgba(52,211,153,0.85)',
                'rgba(96,165,250,0.85)',
                'rgba(251,191,36,0.85)',
                'rgba(248,113,113,0.85)'
            ],
            borderColor: [
                'rgba(52,211,153,0.2)',
                'rgba(96,165,250,0.2)',
                'rgba(251,191,36,0.2)',
                'rgba(248,113,113,0.2)'
            ],
            borderWidth: 2,
            hoverOffset: 6
        }]
    };

    new Chart(canvas, {
        type: 'doughnut',
        data: gradeData,
        options: {
            cutout: '72%',
            responsive: false,
            animation: { animateRotate: true, duration: 900, easing: 'easeInOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            const pct   = total > 0 ? Math.round(ctx.parsed / total * 100) : 0;
                            return ` ${ctx.parsed} učenika (${pct}%)`;
                        }
                    },
                    backgroundColor: 'rgba(15,23,42,0.95)',
                    titleColor: '#e2e8f0',
                    bodyColor: '#94a3b8',
                    borderColor: 'rgba(255,255,255,0.08)',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 10
                }
            }
        }
    });

    // Animacija bar-ova u analitici
    document.querySelectorAll('#analyticsContent [style*="width:"]').forEach(bar => {
        if (!bar.closest('.score-bar-track')) {
            const w = bar.style.width;
            bar.style.width = '0%';
            requestAnimationFrame(() => setTimeout(() => bar.style.width = w, 150));
        }
    });

    // Default: chevron rotiran (otvoren)
    const chevron = document.getElementById('analyticsChevron');
    if (chevron) chevron.classList.add('rotate-180');
});
</script>
</body>
</html>
