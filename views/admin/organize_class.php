<!DOCTYPE html>
<html lang="bs">
<script>
  if(localStorage.getItem('appTheme')==='ocean') {
    document.documentElement.classList.add('theme-ocean');
  }
</script>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="Organizacija odjeljenja — dodajte i uklanjajte učenike iz razrednog odjeljenja.">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
  <title>Organizacija Odjeljenja: <?= $class_name ?></title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } }
  </script>
  <style>
    body { background-color: #0f172a; color: #e2e8f0; font-family: 'Inter', sans-serif; }
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    .glass-effect { background: rgba(30, 41, 59, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
    .glass-strong { background: rgba(30,41,59,0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); }
    .gradient-bg { background: linear-gradient(-45deg,#1a1a2e,#162447,#1f4068,#4f46e5); background-size: 400% 400%; animation: gradientBG 15s ease infinite; }
    @keyframes gradientBG { 0% {background-position:0% 50%;} 50% {background-position:100% 50%;} 100% {background-position:0% 50%;} }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.1); border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(139, 92, 246, 0.5); }
    @keyframes fadeUp { from { opacity:0; transform: translateY(16px); } to { opacity:1; transform: translateY(0); } }
    .fade-up { animation: fadeUp .45s ease both; }
    /* Toast animacija */
    @keyframes toastIn { from { opacity:0; transform: translateY(-16px) scale(0.97); } to { opacity:1; transform: translateY(0) scale(1); } }
    @keyframes toastOut { from { opacity:1; transform: translateY(0) scale(1); } to { opacity:0; transform: translateY(-12px) scale(0.97); } }
    .toast-enter { animation: toastIn 0.3s ease forwards; }
    .toast-exit { animation: toastOut 0.35s ease forwards; }

  /* ================================================================
     OCEAN TEMA — Kompletni Moderni Svjetli Dizajn (Organize Class)
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
  html.theme-ocean .border-gray-700 { border-color: #e2e8f0 !important; }
  html.theme-ocean .border-gray-700\/50 { border-color: #e2e8f0 !important; }
  html.theme-ocean .text-white { color: #0f172a !important; }
  html.theme-ocean .hover\:text-white:hover,
  html.theme-ocean .hover\:text-white:hover i { color: #ffffff !important; }

  html.theme-ocean .text-gray-100 { color: #1e293b !important; }
  html.theme-ocean .text-gray-200 { color: #1e293b !important; }
  html.theme-ocean .text-gray-300 { color: #334155 !important; }
  html.theme-ocean .text-gray-400 { color: #64748b !important; }
  html.theme-ocean .text-gray-500 { color: #94a3b8 !important; }
  html.theme-ocean .bg-gray-900\/40 {
    background-color: #f8fafc !important;
    border-color: rgba(13,148,136,0.15) !important;
  }
  html.theme-ocean .bg-gray-900\/50 { background-color: #f8fafc !important; }
  html.theme-ocean .bg-gray-800\/50 {
    background-color: rgba(248,250,252,0.95) !important;
    border-color: #e2e8f0 !important;
  }
  html.theme-ocean .text-purple-400 { color: #0891b2 !important; }
  html.theme-ocean .bg-purple-500\/20 { background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08)) !important; }
  html.theme-ocean .bg-purple-500\/5 { background: linear-gradient(135deg, rgba(13,148,136,0.06), rgba(8,145,178,0.04)) !important; }
  html.theme-ocean .border-purple-500\/20 { border-color: rgba(13,148,136,0.25) !important; }
  html.theme-ocean .border-purple-500\/40 { border-color: rgba(13,148,136,0.35) !important; }
  html.theme-ocean .border-purple-500\/30 { border-color: rgba(13,148,136,0.3) !important; }
  html.theme-ocean .user-item {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
    border-color: #ccfbf1 !important;
  }
  html.theme-ocean .in-class-item:hover { border-color: rgba(239,68,68,0.4) !important; }
  html.theme-ocean .out-class-item:hover { border-color: rgba(16,185,129,0.4) !important; }
  html.theme-ocean #searchIn,
  html.theme-ocean #searchOut {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
    border-color: #ccfbf1 !important;
    color: #0f172a !important;
  }
  html.theme-ocean #searchIn::placeholder,
  html.theme-ocean #searchOut::placeholder { color: #94a3b8 !important; }
  html.theme-ocean #searchIn:focus { border-color: #10b981 !important; box-shadow: 0 0 0 3px rgba(16,185,129,0.15), 0 4px 12px rgba(16,185,129,0.1) !important; background: #ffffff !important; }
  html.theme-ocean #searchOut:focus { border-color: #0d9488 !important; box-shadow: 0 0 0 3px rgba(13,148,136,0.15), 0 4px 12px rgba(13,148,136,0.1) !important; background: #ffffff !important; }
  html.theme-ocean #subjectModal .bg-gray-800 {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
    border-color: #ccfbf1 !important;
  }
  html.theme-ocean #massSubjectBtn {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
    border-color: #ccfbf1 !important;
    color: #0f172a !important;
  }
  html.theme-ocean #massSubjectDropdown {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
    border-color: #ccfbf1 !important;
  }
  html.theme-ocean #massSubjectDropdown button { color: #334155 !important; }
  html.theme-ocean #massSubjectDropdown button:hover { background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important; color: #0d9488 !important; }
  html.theme-ocean .hover\:bg-gray-700:hover { background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important; color: #0d9488 !important; }
  html.theme-ocean .bg-gray-700\/40 { background: linear-gradient(135deg, rgba(241,245,249,0.9), rgba(240,253,250,0.85)) !important; border-color: #ccfbf1 !important; color: #475569 !important; }
  html.theme-ocean .border-emerald-500\/20 { border-color: rgba(16,185,129,0.25) !important; }
  html.theme-ocean .bg-emerald-500\/5 { background: linear-gradient(135deg, rgba(16,185,129,0.06), rgba(13,148,136,0.04)) !important; }
  html.theme-ocean .bg-emerald-500\/20 { background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(13,148,136,0.08)) !important; }
  html.theme-ocean .border-emerald-500\/30 { border-color: rgba(16,185,129,0.35) !important; }
  html.theme-ocean .bg-purple-600\/10 { background: linear-gradient(135deg, rgba(13,148,136,0.08), rgba(8,145,178,0.05)) !important; }
  html.theme-ocean .bg-blue-600\/10 { background: linear-gradient(135deg, rgba(8,145,178,0.08), rgba(13,148,136,0.05)) !important; }
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

  /* Theme variables for toggle */
  :root {
    --clr-accent: #a855f7; --clr-accent-glow: rgba(168,85,247,0.4);
    --clr-accent-border: rgba(168,85,247,0.5);
    --clr-user-from: #a855f7; --clr-user-to: #ec4899;
  }
  html.theme-ocean {
    --clr-accent: #0d9488; --clr-accent-glow: rgba(13,148,136,0.15);
    --clr-accent-border: rgba(13,148,136,0.25);
    --clr-user-from: #0d9488; --clr-user-to: #0891b2;
  }

  /* Theme pill toggle - Standardized without glow */
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

<!-- Toast kontejner -->
<div id="toastContainer" class="fixed bottom-6 right-6 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

<div class="bg-gray-800 border border-gray-700 rounded-3xl shadow-2xl max-w-6xl w-full px-4 sm:px-10 py-6 sm:py-12 flex flex-col gap-6 sm:gap-8 mx-4 relative overflow-hidden min-h-[80vh]">
      <!-- Dekorativni sjaj -->
      <div class="absolute top-0 right-0 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl pointer-events-none transform translate-x-1/2 -translate-y-1/2"></div>
      <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none transform -translate-x-1/2 translate-y-1/2"></div>

    <!-- Header -->
    <header class="fade-up flex flex-col sm:flex-row sm:items-start justify-between gap-4 border-b border-gray-700/50 pb-6 relative z-10">
      <div class="flex items-start gap-4">
        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center shadow-xl shadow-purple-500/25 flex-shrink-0">
          <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
        </div>
        <div>
          <div class="text-xs text-purple-400 font-semibold uppercase tracking-widest mb-1 flex items-center gap-2">
            <i class="fas fa-layer-group"></i> Organizacija Odjeljenja
          </div>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight tracking-tight"><?= $class_name ?></h1>
          <p class="text-gray-400 text-sm mt-1">Pregled i dodjela učenika u odjeljenju</p>
        </div>
      </div>
      <div class="flex items-center gap-3 flex-shrink-0 flex-wrap justify-end">
        <button id="themeToggleBtn" onclick="toggleTheme()" class="theme-pill-btn" title="Promijeni temu">
          <span class="theme-pill-track">
            <span class="theme-pill-thumb"></span>
            <i class="fas fa-moon theme-pill-icon theme-pill-icon-left"></i>
            <i class="fas fa-sun theme-pill-icon theme-pill-icon-right"></i>
          </span>
        </button>
        <div class="bg-gray-800/50 px-4 py-2 rounded-xl border border-gray-700/50 flex flex-col items-center justify-center min-w-[110px]">
            <span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Ukupno učenika</span>
            <span class="text-lg font-bold text-emerald-400 leading-none mt-1" id="totalCount"><?= count($in_class) ?></span>
        </div>
        <a href="index.php?route=admin" class="flex items-center gap-2 bg-gray-700/40 text-gray-300 hover:bg-gray-700 hover:text-white px-4 py-2.5 rounded-xl transition-colors text-sm font-bold border border-gray-600/30" title="Vrati se na admin panel">
            <i class="fas fa-arrow-left"></i> <span class="hidden sm:inline">Nazad</span>
        </a>
      </div>
    </header>

    <!-- Content -->
    <div class="relative z-10 flex-1 flex flex-col">
      <div class="fade-up grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 flex-1 h-full" style="animation-delay:.1s">
      
      <!-- Lista učenika u odjeljenju -->
      <div class="bg-gray-900/40 rounded-2xl shadow-xl flex flex-col border border-emerald-500/20 h-[600px] lg:h-auto overflow-hidden relative group transition-all hover:border-emerald-500/40">
        <div class="absolute inset-0 bg-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
        <div class="p-4 sm:p-5 border-b border-gray-700/50 flex justify-between items-center gap-3 relative z-10 bg-gray-800/50">
          <h2 class="text-xs sm:text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-2 sm:gap-3 flex-shrink-0">
            <span class="w-8 h-8 rounded-lg bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-base"><i class="fas fa-user-check"></i></span> <span class="hidden sm:inline">Učenici u odjeljenju</span><span class="sm:hidden">U odjeljenju</span>
          </h2>
          <div class="flex items-center justify-end gap-2 flex-1 min-w-0">
            <!-- Dodijeli predmet dugme -->
            <?php if(!empty($admin_subjects) && !empty($in_class)): ?>
            <button onclick="document.getElementById('subjectModal').classList.toggle('hidden')" class="bg-blue-600/20 hover:bg-blue-600 text-blue-400 hover:text-white w-9 h-9 rounded-lg border border-blue-500/30 flex items-center justify-center transition-colors flex-shrink-0 shadow-sm" title="Masovna dodjela predmeta">
                <i class="fas fa-book-medical"></i>
            </button>
            <?php endif; ?>
            <div class="relative flex-1 max-w-[240px]">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-search text-sm"></i></span>
              <input type="text" id="searchIn" placeholder="Pretraži..." class="w-full bg-gray-900/50 text-white pl-9 pr-3 py-1.5 rounded-lg border border-gray-700 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm transition-all shadow-inner">
            </div>
          </div>
        </div>
        
        <div id="inClassContainer" class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-2 relative z-10">
          <?php if(empty($in_class)): ?>
            <div id="inClassEmpty" class="h-full flex flex-col items-center justify-center text-gray-500 py-12">
              <i class="fas fa-user-slash text-4xl mb-3 opacity-50"></i>
              <p>Ovo odjeljenje je trenutno prazno.</p>
            </div>
          <?php else: ?>
            <div id="inClassEmpty" class="hidden h-full flex flex-col items-center justify-center text-gray-500 py-12">
              <i class="fas fa-user-slash text-4xl mb-3 opacity-50"></i>
              <p>Nema rezultata.</p>
            </div>
            <?php foreach($in_class as $user): ?>
              <div class="user-item in-class-item flex items-center justify-between p-3 rounded-xl bg-gray-800/80 border border-gray-700 hover:border-red-500/50 transition-all group/item" data-id="<?= $user['id'] ?>" data-name="<?= strtolower($user['username']) ?>">
                <div class="flex items-center gap-3 overflow-hidden pr-2">
                  <div class="w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user"></i>
                  </div>
                  <span class="text-gray-200 font-medium truncate"><?= htmlspecialchars($user['username']) ?></span>
                </div>
                <button onclick="moveUser(<?= $user['id'] ?>, 'remove', this)" class="bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white w-8 h-8 rounded-lg flex items-center justify-center transition-all flex-shrink-0" title="Ukloni iz odjeljenja">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <!-- Lista ostalih učenika -->
      <div class="bg-gray-900/40 rounded-2xl shadow-xl flex flex-col border border-purple-500/20 h-[600px] lg:h-auto overflow-hidden relative group transition-all hover:border-purple-500/40">
        <div class="absolute inset-0 bg-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
        <div class="p-4 sm:p-5 border-b border-gray-700/50 flex justify-between items-center gap-3 relative z-10 bg-gray-800/50">
          <h2 class="text-xs sm:text-sm font-bold text-purple-400 uppercase tracking-wider flex items-center gap-2 sm:gap-3 flex-shrink-0">
            <span class="w-8 h-8 rounded-lg bg-purple-500/20 border border-purple-500/30 flex items-center justify-center text-base"><i class="fas fa-users"></i></span> <span class="hidden sm:inline">Ostali učenici</span><span class="sm:hidden">Ostali</span>
          </h2>
          <div class="flex items-center justify-end gap-2 flex-1 min-w-0">
            <div class="relative flex-1 max-w-[240px]">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-search text-sm"></i></span>
              <input type="text" id="searchOut" placeholder="Pretraži..." class="w-full bg-gray-900/50 text-white pl-9 pr-3 py-1.5 rounded-lg border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none text-sm transition-all shadow-inner">
            </div>
          </div>
        </div>
        
        <div id="outClassContainer" class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-2 relative z-10">
          <?php if(empty($out_class)): ?>
            <div id="outClassEmpty" class="h-full flex flex-col items-center justify-center text-gray-500 py-12">
              <i class="fas fa-search-minus text-4xl mb-3 opacity-50"></i>
              <p>Nema drugih učenika u sistemu.</p>
            </div>
          <?php else: ?>
            <div id="outClassEmpty" class="hidden h-full flex flex-col items-center justify-center text-gray-500 py-12">
              <i class="fas fa-search-minus text-4xl mb-3 opacity-50"></i>
              <p>Nema rezultata.</p>
            </div>
            <?php foreach($out_class as $user): ?>
              <div class="user-item out-class-item flex items-center justify-between p-3 rounded-xl bg-gray-800/80 border border-gray-700 hover:border-emerald-500/50 transition-all group/item" data-id="<?= $user['id'] ?>" data-name="<?= strtolower($user['username']) ?>">
                <div class="flex items-center gap-3 overflow-hidden pr-2">
                  <div class="w-8 h-8 rounded-full bg-gray-700 text-gray-400 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user"></i>
                  </div>
                  <div class="flex flex-col truncate">
                    <span class="text-gray-200 font-medium truncate"><?= htmlspecialchars($user['username']) ?></span>
                    <?php if($user['current_class']): ?>
                        <span class="text-xs text-yellow-500/80 mt-0.5 truncate"><i class="fas fa-exclamation-triangle"></i> Trenutno u: <?= htmlspecialchars($user['current_class']) ?></span>
                    <?php else: ?>
                        <span class="text-xs text-gray-500 mt-0.5"><i class="fas fa-minus"></i> Bez odjeljenja</span>
                    <?php endif; ?>
                  </div>
                </div>
                <button onclick="moveUser(<?= $user['id'] ?>, 'add', this)" class="bg-emerald-500/10 hover:bg-emerald-600 text-emerald-400 hover:text-white w-8 h-8 rounded-lg flex items-center justify-center transition-all flex-shrink-0" title="Dodaj u odjeljenje">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</div>

  <!-- Modal za dodjelu predmeta -->
  <div id="subjectModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-gray-800 border border-gray-700 p-6 rounded-2xl shadow-2xl w-full max-w-md mx-4 transform scale-95 transition-all animate-fadeIn">
      <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center text-lg">
          <i class="fas fa-book-open"></i>
        </div>
        <h2 class="text-lg font-bold text-white">Masovna dodjela predmeta</h2>
      </div>
      <p class="text-sm text-gray-400 mb-4">Odabrani predmet će biti automatski dodijeljen svim učenicima koji se trenutno nalaze u ovom odjeljenju.</p>
      
      <div class="space-y-4 mb-6">
        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Izaberite predmet</label>
        <div class="relative z-40">
            <input type="hidden" id="massSubjectSelect" value="">
            <button type="button" id="massSubjectBtn" onclick="document.getElementById('massSubjectDropdown').classList.toggle('hidden')" class="w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 hover:border-blue-500 focus:border-blue-500 outline-none transition-all flex items-center justify-between shadow-sm cursor-pointer">
                <span class="truncate font-medium flex items-center gap-3 text-sm" id="massSubjectText">
                    <i class="fas fa-book-open text-gray-400"></i> Odaberite predmet
                </span>
                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
            </button>

            <div id="massSubjectDropdown" class="hidden absolute left-0 right-0 top-[100%] mt-2 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden animate-fadeIn z-[60] max-h-48 overflow-y-auto custom-scrollbar">
                <div class="flex flex-col p-1.5 gap-1">
                    <button type="button" onclick="selectMassSubject('', 'Odaberite predmet')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                        <div class="w-5 flex justify-center"><i class="fas fa-book-open text-gray-400"></i></div> Odaberite predmet
                    </button>
                    <?php foreach($admin_subjects as $sub): ?>
                    <button type="button" onclick="selectMassSubject('<?= $sub['id'] ?>', '<?= htmlspecialchars($sub['name'], ENT_QUOTES) ?>')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                        <div class="w-5 flex justify-center"><i class="fas fa-book text-blue-400"></i></div> <span class="truncate"><?= htmlspecialchars($sub['name']) ?></span>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700">
        <button onclick="document.getElementById('subjectModal').classList.add('hidden')" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-xl text-sm transition-colors border border-gray-600">Otkaži</button>
        <button id="confirmSubjectBtn" onclick="assignSubjectToClass()" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-bold transition-colors shadow-lg hover:shadow-blue-500/30 flex items-center gap-2 border border-blue-500/50">
            <i class="fas fa-check"></i> Dodijeli
        </button>
      </div>
    </div>
  </div>

  <script>
    const csrfToken = "<?= $csrf_token ?>";

    // Toast notifikacije
    function showToast(message, type = 'success') {
      const container = document.getElementById('toastContainer');
      const isSuccess = type === 'success';
      const toast = document.createElement('div');
      toast.className = [
        'pointer-events-auto flex items-center gap-3 px-4 py-2.5 rounded-xl shadow-2xl backdrop-blur-md border max-w-[320px] toast-enter',
        isSuccess
          ? 'bg-slate-900/90 border-emerald-500/20 text-emerald-100'
          : 'bg-slate-900/90 border-rose-500/20 text-rose-100'
      ].join(' ');
      toast.innerHTML = `
        <div class="w-6 h-6 rounded-lg flex items-center justify-center flex-shrink-0 border ${isSuccess ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-rose-500/10 border-rose-500/20'}">
          <i class="fas ${isSuccess ? 'fa-check text-emerald-400 text-[10px]' : 'fa-exclamation-triangle text-rose-400 text-[10px]'}"></i>
        </div>
        <span class="text-xs font-medium">${message}</span>
      `;
      container.appendChild(toast);
      setTimeout(() => {
        toast.classList.remove('toast-enter');
        toast.classList.add('toast-exit');
        setTimeout(() => toast.remove(), 400);
      }, 2000);
    }

    function selectMassSubject(id, name) {
        document.getElementById('massSubjectSelect').value = id;
        document.getElementById('massSubjectText').innerHTML = id === '' ? 
            `<i class="fas fa-book-open flex-shrink-0 text-gray-400"></i> <span class="truncate">Odaberite predmet</span>` : 
            `<i class="fas fa-book flex-shrink-0 text-blue-400"></i> <span class="truncate">${name}</span>`;
        document.getElementById('massSubjectDropdown').classList.add('hidden');
    }
    
    document.addEventListener('click', function(e) {
        const btn = document.getElementById('massSubjectBtn');
        const dropdown = document.getElementById('massSubjectDropdown');
        if (btn && dropdown && !btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Unos pretrage
    document.getElementById('searchIn').addEventListener('input', function(e) {
        filterItems('in-class-item', e.target.value.toLowerCase(), 'inClassEmpty', 'inClassContainer');
    });

    document.getElementById('searchOut').addEventListener('input', function(e) {
        filterItems('out-class-item', e.target.value.toLowerCase(), 'outClassEmpty', 'outClassContainer');
    });

    function filterItems(className, term, emptyId, containerId) {
        const items = document.querySelectorAll('.' + className);
        let hasActive = false;
        items.forEach(item => {
            const name = item.getAttribute('data-name');
            if (name.includes(term)) {
                item.style.display = 'flex';
                hasActive = true;
            } else {
                item.style.display = 'none';
            }
        });
        const emptyEl = document.getElementById(emptyId);
        if (emptyEl) {
            emptyEl.style.display = hasActive ? 'none' : 'flex';
        }
    }

    async function moveUser(studentId, action, btnEl) {
        const itemEl = btnEl.closest('.user-item');
        
        // Disable button during req
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
        
        const fd = new FormData();
        fd.append('action', action);
        fd.append('student_id', studentId);
        fd.append('csrf_token', csrfToken);

        try {
            const res = await fetch(window.location.href, {
                method: 'POST',
                body: fd
            });
            const data = await res.json();
            
            if (data.status === 'success') {
                window.location.reload();
            } else {
                showToast(data.message || 'Greška na serveru.', 'error');
                btnEl.disabled = false;
                btnEl.innerHTML = action === 'add' ? '<i class="fas fa-plus"></i>' : '<i class="fas fa-times"></i>';
            }
        } catch (e) {
            showToast('Mrežna greška. Pokušajte ponovo.', 'error');
            btnEl.disabled = false;
            btnEl.innerHTML = action === 'add' ? '<i class="fas fa-plus"></i>' : '<i class="fas fa-times"></i>';
        }
    }

    async function assignSubjectToClass() {
        const subId = document.getElementById('massSubjectSelect').value;
        if (!subId) {
            showToast('Molimo odaberite predmet.', 'error');
            return;
        }

        const btn = document.getElementById('confirmSubjectBtn');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Obrada...';

        const fd = new FormData();
        fd.append('action', 'assign_subject_to_class');
        fd.append('subject_id', subId);
        fd.append('csrf_token', csrfToken);

        try {
            const res = await fetch(window.location.href, {
                method: 'POST',
                body: fd
            });
            const data = await res.json();
            
            if (data.status === 'success') {
                showToast('Predmet je uspješno dodijeljen svim učenicima!');
                document.getElementById('subjectModal').classList.add('hidden');
                btn.disabled = false;
                btn.innerHTML = originalText;
            } else {
                showToast(data.message || 'Greška prilikom dodjele.', 'error');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        } catch (e) {
            showToast('Mrežna greška. Pokušajte ponovo.', 'error');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }

    function toggleTheme() {
      var btn = document.getElementById('themeToggleBtn');
      if (btn && btn.classList.contains('switching')) return;
      if (btn) btn.classList.add('switching');
      
      document.body.style.transition = 'opacity 0.15s ease';
      document.body.style.opacity = '0.85';
      
      setTimeout(function() {
        var isOcean = document.documentElement.classList.toggle('theme-ocean');
        localStorage.setItem('appTheme', isOcean ? 'ocean' : 'purple');
        
        document.body.style.opacity = '1';
        if (btn) {
          setTimeout(function() {
            btn.classList.remove('switching');
          }, 400);
        }
        
        if (typeof showToast === 'function') showToast(isOcean ? 'Ocean tema aktivirana 🌊' : 'Ljubičasta tema aktivirana 💜');
      }, 150);
    }
  </script>

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
        
        hideTimeout = setTimeout(() => {
            tooltip.classList.add('hidden');
        }, 200);
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
</body>
</html>
