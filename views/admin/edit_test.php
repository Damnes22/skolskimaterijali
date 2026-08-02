<!DOCTYPE html>
<html lang="bs">
<script>
  if(localStorage.getItem('appTheme')==='ocean') {
    document.documentElement.classList.add('theme-ocean');
  }
</script>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Uredi Test - <?= htmlspecialchars($test['filename']) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
  tailwind.config = {
    theme: {
      extend: {
        screens: {
          'xs': '320px',
        }
      }
    }
  }
</script>
<style>
/* Theme variables for toggle */
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
@layer utilities {
  .animate-fadeIn { animation: fadeIn 0.5s ease-out both; }
  @keyframes fadeIn { 0% { opacity:0; transform: scale(0.97); } 100% { opacity:1; transform: scale(1); } }

  .gradient-bg { background: linear-gradient(-45deg,#1a1a2e,#162447,#1f4068,#e43f5a); background-size: 400% 400%; animation: gradientBG 15s ease infinite; }
  @keyframes gradientBG { 0% {background-position:0% 50%;} 50% {background-position:100% 50%;} 100% {background-position:0% 50%;} }
  @keyframes ripple { 0% { transform: scale(0); opacity: 0.8; } 100% { transform: scale(4); opacity: 0; } }
  @keyframes thumbGlow { 0%, 100% { box-shadow: 0 0 12px var(--clr-accent-glow); } 50% { box-shadow: 0 0 24px var(--clr-accent-glow); } }
}

/* Mobile: q-card controls toolbar on bottom */
@media (max-width: 639px) {
  .q-card-controls-top { display: none !important; }
  .q-card-controls-bottom { display: flex !important; }
  .question-card h3 { padding-right: 0 !important; }
}
@media (min-width: 640px) {
  .q-card-controls-top { display: flex !important; }
  .q-card-controls-bottom { display: none !important; }
}

/* ================================================================
   OCEAN TEMA — Kompletni Moderni Svjetli Dizajn (Edit Test)
   Akcentne boje: Teal (#0d9488) + Cyan (#0891b2)
   ================================================================ */
html.theme-ocean body {
  background-color: #f0f9ff !important;
  color: #1e293b !important;
}
html.theme-ocean .bg-\[\#0f172a\] { background-color: #f0f9ff !important; }

/* Glavni kontejner kartice */
html.theme-ocean .bg-gray-800 {
  background-color: #ffffff !important;
  border-color: #e2e8f0 !important;
  box-shadow: 0 4px 24px rgba(13,148,136,0.08) !important;
}
html.theme-ocean .border-gray-700 { border-color: #e2e8f0 !important; }
html.theme-ocean .border-gray-700\/50 { border-color: #e2e8f0 !important; }
html.theme-ocean .border-gray-700\/80 { border-color: #e2e8f0 !important; }

/* Tekst boje */
html.theme-ocean .text-white { color: #0f172a !important; }
html.theme-ocean .text-gray-100 { color: #1e293b !important; }
html.theme-ocean .text-gray-300 { color: #334155 !important; }
html.theme-ocean .text-gray-400 { color: #64748b !important; }
html.theme-ocean .text-gray-500 { color: #94a3b8 !important; }

/* Header logo ikona */
html.theme-ocean .bg-gradient-to-br.from-purple-600.to-blue-600 {
  background: linear-gradient(135deg, #0d9488, #0891b2) !important;
  box-shadow: 0 10px 25px rgba(13,148,136,0.3) !important;
}

/* Pozadine inputa i kartica pitanja */
html.theme-ocean .bg-gray-900 {
  background-color: #f8fafc !important;
  color: #1e293b !important;
  border-color: #e2e8f0 !important;
}
html.theme-ocean .bg-gray-900\/50 { background-color: #f8fafc !important; border-color: #e2e8f0 !important; }
html.theme-ocean .bg-gray-800\/60 { background-color: #f8fafc !important; border-color: #e2e8f0 !important; }
html.theme-ocean .bg-gray-800\/80 { background-color: #f1f5f9 !important; border-color: #e2e8f0 !important; }
html.theme-ocean .question-card {
  background-color: #ffffff !important;
  border-color: #e2e8f0 !important;
}
html.theme-ocean .question-card:hover { background-color: #f8fafc !important; }

/* Inputi i textarea */
html.theme-ocean input[type="text"],
html.theme-ocean input[type="number"],
html.theme-ocean textarea,
html.theme-ocean input[type="file"] {
  background-color: #f8fafc !important;
  color: #0f172a !important;
  border-color: #e2e8f0 !important;
}
html.theme-ocean input::placeholder,
html.theme-ocean textarea::placeholder { color: #94a3b8 !important; }
html.theme-ocean input:focus,
html.theme-ocean textarea:focus {
  border-color: #0d9488 !important;
  box-shadow: 0 0 0 1px #0d9488 !important;
}
html.theme-ocean .focus-within\:border-purple-500:focus-within { border-color: #0d9488 !important; }

/* Purple → Teal akcentne boje */
html.theme-ocean .text-purple-400 { color: #0891b2 !important; }
html.theme-ocean .bg-purple-500\/10 { background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08)) !important; border-color: rgba(13,148,136,0.25) !important; }
html.theme-ocean .border-purple-500\/20 { border-color: rgba(13,148,136,0.25) !important; }
html.theme-ocean .hover\:bg-purple-600:hover { background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%) !important; }
html.theme-ocean .bg-purple-600 { background: linear-gradient(135deg, #0891b2 0%, #0d9488 100%) !important; }
html.theme-ocean .bg-purple-600\/20 { background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08)) !important; border-color: rgba(13,148,136,0.25) !important; }
html.theme-ocean .border-purple-500\/30 { border-color: rgba(13,148,136,0.35) !important; }
html.theme-ocean .focus\:border-purple-500:focus { border-color: #0d9488 !important; }
html.theme-ocean .focus\:ring-purple-500:focus { --tw-ring-color: rgba(13,148,136,0.25) !important; }
html.theme-ocean .hover\:border-purple-500:hover { border-color: #0d9488 !important; }
html.theme-ocean .hover\:border-purple-500\/50:hover { border-color: rgba(13,148,136,0.4) !important; }
html.theme-ocean .checked\:bg-purple-600:checked { background: linear-gradient(135deg, #0891b2 0%, #0d9488 100%) !important; border-color: #0d9488 !important; }
html.theme-ocean .checked\:border-purple-600:checked { border-color: #0d9488 !important; }
html.theme-ocean .bg-purple-500 { background: linear-gradient(135deg, #0891b2 0%, #0d9488 100%) !important; }
html.theme-ocean .peer-checked\:opacity-100 { background: linear-gradient(135deg, #0891b2 0%, #0d9488 100%) !important; }

/* Hoveri sivi → svjetli */
html.theme-ocean .hover\:bg-gray-700:hover { background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important; color: #0d9488 !important; }
html.theme-ocean .hover\:bg-gray-800:hover { background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important; }
html.theme-ocean .bg-gray-700 { background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-700\/30 { background: linear-gradient(135deg, rgba(226,232,240,0.5), rgba(240,253,250,0.45)) !important; border-color: #ccfbf1 !important; }

/* Custom select dropdown */
html.theme-ocean .custom-select-dropdown {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
  border-color: #ccfbf1 !important;
}
html.theme-ocean .custom-select-dropdown button:hover {
  background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important;
  color: #0d9488 !important;
}
html.theme-ocean .bg-gray-700.text-white { background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important; color: #0d9488 !important; }

/* Format toolbar */
html.theme-ocean .format-toolbar { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .format-btn { background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important; border-color: #ccfbf1 !important; color: #334155 !important; }

/* Slika upload kontejner */
html.theme-ocean .bg-gray-900\/50.p-3 { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-color: #ccfbf1 !important; }

/* Savjet za tačne odgovore */
html.theme-ocean .bg-purple-500\/10.w-fit { background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08)) !important; color: #0d9488 !important; border-color: rgba(13,148,136,0.25) !important; }
html.theme-ocean .text-purple-400.mb-3 { color: #0891b2 !important; }

/* Akcioni gumbi */
html.theme-ocean .bg-emerald-600\/20 { background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(13,148,136,0.08)) !important; }
html.theme-ocean .bg-gray-600\/20 { background: linear-gradient(135deg, rgba(100,116,139,0.12), rgba(71,85,105,0.08)) !important; }
html.theme-ocean .bg-blue-600\/20 { background: linear-gradient(135deg, rgba(37,99,235,0.12), rgba(8,145,178,0.08)) !important; }

/* Toast poruke */
html.theme-ocean #successMsg,
html.theme-ocean #errorMsg {
  background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(248,250,252,0.95) 100%) !important;
  border-color: #ccfbf1 !important;
  color: #1e293b !important;
}

/* Dekorativni sjaj — sakrij u svjetloj temi */
html.theme-ocean .bg-purple-600\/10 { background: linear-gradient(135deg, rgba(13,148,136,0.08), rgba(8,145,178,0.05)) !important; }
html.theme-ocean .bg-blue-600\/10 { background: linear-gradient(135deg, rgba(8,145,178,0.08), rgba(13,148,136,0.05)) !important; }

/* Bottom toolbar na mobilnom */
html.theme-ocean .border-gray-700\/50.pt-4 { border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-700\/30 { background: linear-gradient(135deg, rgba(226,232,240,0.6), rgba(240,253,250,0.55)) !important; border-color: #ccfbf1 !important; }

/* === SCROLLBAR U OCEAN TEMI === */
html.theme-ocean ::-webkit-scrollbar-thumb { background: #cbd5e1; }
html.theme-ocean ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

/* === SELECTION U OCEAN TEMI === */
html.theme-ocean ::selection { background-color: #0d9488; color: #ffffff; }

/* Theme pill toggle - Enhanced (Standardized without glow) */
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

<!-- Poruke o uspjehu/greškama -->
<?php if(isset($success_msg)): ?>
<div id="successMsg" class="fixed bottom-6 right-6 bg-slate-900/90 border border-emerald-500/20 text-emerald-100 px-4 py-2.5 rounded-xl shadow-2xl backdrop-blur-md z-[9999] animate-fadeIn flex items-center gap-3 max-w-[320px]">
  <div class="w-6 h-6 rounded-lg bg-emerald-500/10 flex items-center justify-center flex-shrink-0 border border-emerald-500/20">
    <i class="fas fa-check text-emerald-400 text-[10px]"></i>
  </div>
  <span class="text-xs font-medium flex-1 truncate"><?= $success_msg ?></span>
  <button onclick="this.closest('[id]').style.display='none'" class="flex-shrink-0 text-gray-500 hover:text-white transition-colors ml-1" title="Zatvori"><i class="fas fa-times text-[10px]"></i></button>
</div>
<?php endif; ?>

<?php if(isset($error_msg)): ?>
<div id="errorMsg" class="fixed bottom-6 right-6 bg-slate-900/90 border border-rose-500/20 text-rose-100 px-4 py-2.5 rounded-xl shadow-2xl backdrop-blur-md z-[9999] animate-fadeIn flex items-center gap-3 max-w-[320px]">
  <div class="w-6 h-6 rounded-lg bg-rose-500/10 flex items-center justify-center flex-shrink-0 border border-rose-500/20">
    <i class="fas fa-exclamation-triangle text-rose-400 text-[10px]"></i>
  </div>
  <span class="text-xs font-medium flex-1 truncate"><?= $error_msg ?></span>
  <button onclick="this.closest('[id]').style.display='none'" class="flex-shrink-0 text-gray-500 hover:text-white transition-colors ml-1" title="Zatvori"><i class="fas fa-times text-[10px]"></i></button>
</div>
<?php endif; ?>

<script>
window.addEventListener('DOMContentLoaded', function() {
  var msgs = ['successMsg', 'errorMsg'];
  msgs.forEach(function(id) {
    var el = document.getElementById(id);
    if(el) {
      setTimeout(function() {
        el.style.display = 'none';
      }, 3500);
    }
  });
});

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
  }, 150);
}
</script>

<div class="bg-gray-800 border border-gray-700 rounded-3xl shadow-2xl max-w-6xl w-full px-4 sm:px-10 py-6 sm:py-12 flex flex-col gap-6 sm:gap-8 mx-4 relative overflow-hidden">
  
  <!-- Dekorativni sjaj -->
  <div class="absolute top-0 right-0 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl pointer-events-none transform translate-x-1/2 -translate-y-1/2"></div>
  <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none transform -translate-x-1/2 translate-y-1/2"></div>

  <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border-b border-gray-700/50 pb-6 relative z-10">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center shadow-lg shadow-purple-500/30 flex-shrink-0">
            <i class="fas fa-edit text-white text-base sm:text-xl"></i>
        </div>
        <div>
            <h1 class="text-xl sm:text-3xl font-bold text-white tracking-tight leading-tight">Uređivanje testa</h1>
            <p class="text-gray-500 text-xs mt-0.5 truncate max-w-[200px] sm:max-w-none"><?= htmlspecialchars($test['filename']) ?></p>
        </div>
    </div>
    <div class="flex items-center gap-2 w-full sm:w-auto">
        <button id="themeToggleBtn" onclick="toggleTheme()" class="theme-pill-btn" title="Promijeni temu">
            <span class="theme-pill-track">
                <span class="theme-pill-thumb"></span>
                <i class="fas fa-moon theme-pill-icon theme-pill-icon-left"></i>
                <i class="fas fa-sun theme-pill-icon theme-pill-icon-right"></i>
            </span>
        </button>
        <a href="<?= htmlspecialchars($test['filepath']) ?>?preview=1" target="_blank" class="flex-1 sm:flex-none bg-emerald-600/20 text-emerald-400 hover:bg-emerald-600 hover:text-white px-3 sm:px-5 py-2 sm:py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center justify-center gap-2 border border-emerald-500/30">
            <i class="fas fa-eye"></i> <span class="sm:inline">Pregledaj</span>
        </a>
        <a href="index.php?route=<?= $is_master ? 'student' : 'admin' ?>&subject=<?= $test['subject_id'] ?>" class="flex-1 sm:flex-none bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-3 sm:px-5 py-2 sm:py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center justify-center gap-2 border border-gray-500/30">
            <i class="fas fa-arrow-left"></i> <span class="sm:inline">Nazad</span>
        </a>
    </div>
  </header>

  <main class="flex flex-col gap-4 sm:gap-6 relative z-10">
    <div class="animate-fadeIn">
        
        <?php if(isset($parse_warning)): ?>
            <div class="bg-yellow-600/20 border border-yellow-500/50 text-yellow-400 p-4 rounded-xl mb-6 shadow-lg flex items-start gap-3">
                <i class="fas fa-exclamation-triangle mr-2"></i> <?= $parse_warning ?>
                <div>
                    <p class="font-semibold">Upozorenje pri parsiranju</p>
                    <p class="text-sm mt-1 text-yellow-500">Editor očekuje format: <code>const questions = [...];</code> unutar HTML fajla. <?= $parse_warning ?></p>
                </div>
            </div>
        <?php endif; ?>

        <form method="post" id="testForm" class="space-y-6" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <div class="bg-gray-800/60 p-6 rounded-2xl border border-gray-700/80 shadow-lg">
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="flex-1">
                        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 mb-2 block">Naziv testa <span class="text-gray-500 font-normal normal-case">(prikazuje se u zaglavlju)</span></label>
                        <input type="text" name="test_name" value="<?= htmlspecialchars($currentTestName) ?>" class="w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" placeholder="Unesite naziv testa...">
                    </div>
                    <div class="w-full sm:w-40 flex-shrink-0">
                        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 mb-2 block">Vrijeme <span class="text-gray-500 font-normal normal-case">(min)</span></label>
                        <div class="flex items-center bg-gray-900 rounded-xl border border-gray-700 overflow-hidden focus-within:border-purple-500 focus-within:ring-1 focus-within:ring-purple-500 transition-all">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-3 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-colors outline-none cursor-pointer flex-shrink-0">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <input type="number" name="test_duration" value="<?= htmlspecialchars($currentDuration) ?>" min="1" class="w-full bg-transparent text-white text-center border-none p-0 focus:ring-0 appearance-none [-moz-appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none font-medium" placeholder="40">
                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-3 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-colors outline-none cursor-pointer flex-shrink-0">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <label class="mt-6 flex items-center gap-4 bg-gray-900/50 p-4 rounded-xl border border-gray-700/50 cursor-pointer group hover:bg-gray-900 transition-colors">
                    <div class="relative flex items-center">
                        <input type="checkbox" id="one_by_one" name="one_by_one" value="1" <?= $isOneByOne ? 'checked' : '' ?> class="peer w-6 h-6 border-2 border-gray-600 rounded bg-gray-800 checked:bg-purple-600 checked:border-purple-600 focus:ring-offset-0 focus:ring-0 appearance-none transition-colors cursor-pointer">
                        <i class="fas fa-check absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-xs opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors select-none flex flex-col">
                        <span class="text-base">Prikazuj pitanja jedno po jedno</span>
                        <span class="text-gray-500 text-xs font-normal mt-0.5">Učenici će vidjeti samo jedno pitanje na ekranu (Wizard mode) umjesto svih odjednom.</span>
                    </span>
                </label>

                <label class="mt-4 flex items-center gap-4 bg-gray-900/50 p-4 rounded-xl border border-gray-700/50 cursor-pointer group hover:bg-gray-900 transition-colors">
                    <div class="relative flex items-center">
                        <input type="checkbox" id="hide_results" name="hide_results" value="1" <?= $hideResults ? 'checked' : '' ?> class="peer w-6 h-6 border-2 border-gray-600 rounded bg-gray-800 checked:bg-purple-600 checked:border-purple-600 focus:ring-offset-0 focus:ring-0 appearance-none transition-colors cursor-pointer">
                        <i class="fas fa-check absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-xs opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors select-none flex flex-col">
                        <span class="text-base">Sakrij rezultate od učenika</span>
                        <span class="text-gray-500 text-xs font-normal mt-0.5">Učenik neće vidjeti osvojene bodove ni tačne odgovore nakon predaje testa, već će oni biti poslati samo vama.</span>
                    </span>
                </label>
            </div>

            <div id="questions-container" class="space-y-6">
                <?php foreach($questionsData as $index => $q): ?>
                    <?php 
                        $qType = $q['type'] ?? (!empty(array_filter($q['options'])) ? 'multiple_choice' : 'essay');
                    ?>
                    <div class="question-card bg-gray-800/60 hover:bg-gray-800/80 transition-colors p-4 sm:p-7 rounded-2xl border border-gray-700/80 shadow-lg relative group">
                        <!-- Kontrole: vidljive na desktop-u gore desno -->
                        <div class="q-card-controls-top absolute top-4 right-4 gap-2">
                            <button type="button" onclick="toggleCollapse(this)" class="text-gray-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-700 transition-colors" title="Sakrij/Prikaži">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <button type="button" onclick="duplicateQuestion(this)" class="text-blue-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg hover:bg-blue-600 transition-colors" title="Dupliraj pitanje">
                                <i class="fas fa-copy"></i>
                            </button>
                            <span class="drag-handle text-gray-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-700 transition-colors cursor-move" title="Pomjeri pitanje">
                                <i class="fas fa-grip-vertical"></i>
                            </span>
                            <button type="button" onclick="removeQuestion(this)" class="text-red-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg hover:bg-red-600 transition-colors" title="Obriši pitanje">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        
                        <h3 class="font-bold mb-4 sm:mb-6 text-lg sm:text-xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-700 flex items-center justify-center text-purple-400 text-sm"><i class="fas <?= $qType === 'explanation' ? 'fa-info' : 'fa-question' ?>"></i></div>
                            <span class="text-white"><span class="q-label"><?= $qType === 'explanation' ? 'Objašnjenje' : 'Pitanje' ?></span> <span class="q-number-wrapper" <?= $qType === 'explanation' ? 'style="display:none;"' : '' ?>>#<span class="q-number"><?= $q['numb'] ?? ($index + 1) ?></span></span></span>
                        </h3>
                        
                        <div class="question-content grid gap-4 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <div class="flex-1">
                                    <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 mb-2 block">Tip pitanja</label>
                                    <div class="relative">
                                        <?php
                                            $typeIcons = [
                                                'multiple_choice' => 'fa-list-ul text-blue-400',
                                                'multiple_select' => 'fa-check-square text-indigo-400',
                                                'essay' => 'fa-align-left text-green-400',
                                                'explanation' => 'fa-info-circle text-purple-400'
                                            ];
                                            $typeLabels = [
                                                'multiple_choice' => 'Višestruki izbor (1 tačan)',
                                                'multiple_select' => 'Višestruki odabir (više tačnih)',
                                                'essay' => 'Esej',
                                                'explanation' => 'Objašnjenje (Info)'
                                            ];
                                            $currentIcon = $typeIcons[$qType] ?? $typeIcons['multiple_choice'];
                                            $currentLabel = $typeLabels[$qType] ?? $typeLabels['multiple_choice'];
                                        ?>
                                        <input type="hidden" name="q_type[<?= $index ?>]" value="<?= $qType ?>" class="q-type-input">
                                        <button type="button" onclick="elevateZIndex(this); this.nextElementSibling.classList.toggle('hidden')" class="w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 hover:border-purple-500 focus:border-purple-500 outline-none transition-all flex items-center justify-between shadow-sm cursor-pointer custom-select-btn">
                                            <span class="truncate font-medium flex items-center gap-3 text-sm">
                                                <i class="fas <?= $currentIcon ?>"></i> <?= $currentLabel ?>
                                            </span>
                                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                                        </button>

                                        <div class="hidden absolute left-0 right-0 top-[100%] mt-2 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden animate-fadeIn z-[60] custom-select-dropdown">
                                            <div class="flex flex-col p-1.5 gap-1">
                                                <button type="button" onclick="selectQuestionType(this, 'multiple_choice', 'Višestruki izbor (1 tačan)', 'fa-dot-circle text-blue-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 <?= $qType === 'multiple_choice' ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> text-left w-full">
                                                    <div class="w-5 flex justify-center"><i class="fas fa-dot-circle text-blue-400"></i></div> Višestruki izbor (1 tačan)
                                                </button>
                                                <button type="button" onclick="selectQuestionType(this, 'multiple_select', 'Višestruki odabir (više tačnih)', 'fa-check-square text-indigo-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 <?= $qType === 'multiple_select' ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> text-left w-full">
                                                    <div class="w-5 flex justify-center"><i class="fas fa-check-square text-indigo-400"></i></div> Višestruki odabir (više tačnih)
                                                </button>
                                                <button type="button" onclick="selectQuestionType(this, 'essay', 'Esej', 'fa-align-left text-green-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 <?= $qType === 'essay' ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> text-left w-full">
                                                    <div class="w-5 flex justify-center"><i class="fas fa-align-left text-green-400"></i></div> Esej
                                                </button>
                                                <button type="button" onclick="selectQuestionType(this, 'explanation', 'Objašnjenje (Info)', 'fa-info-circle text-purple-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 <?= $qType === 'explanation' ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?> text-left w-full">
                                                    <div class="w-5 flex justify-center"><i class="fas fa-info-circle text-purple-400"></i></div> Objašnjenje (Info)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-32 points-container <?= $qType === 'explanation' ? 'hidden' : '' ?>">
                                    <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 mb-2 block">Bodovi</label>
                                    <div class="flex items-center bg-gray-900 rounded-xl border border-gray-700 overflow-hidden focus-within:border-purple-500 focus-within:ring-1 focus-within:ring-purple-500 transition-all">
                                        <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-3 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-colors outline-none cursor-pointer flex-shrink-0">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <input type="number" step="0.5" min="0" name="q_points[<?= $index ?>]" value="<?= htmlspecialchars($q['points'] ?? 1) ?>" class="w-full bg-transparent text-white text-center border-none p-0 focus:ring-0 appearance-none [-moz-appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none font-medium">
                                        <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-3 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-colors outline-none cursor-pointer flex-shrink-0">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 question-text-label">Tekst pitanja</label>
                                    <button type="button" onclick="toggleFormatToolbar(this)" class="flex items-center gap-1.5 text-xs text-purple-400 hover:text-white bg-purple-500/10 hover:bg-purple-600 px-2.5 py-1 rounded-lg border border-purple-500/20 hover:border-purple-500 transition-all" title="Opcije formatiranja">
                                        <i class="fas fa-pen-nib"></i> <span class="hidden sm:inline">Format</span>
                                    </button>
                                </div>
                                <div class="format-toolbar hidden mb-2 flex-wrap gap-1 p-2 bg-gray-900/80 border border-gray-700 rounded-xl animate-fadeIn">
                                    <button type="button" onclick="applyFormat(this, 'bold')" class="format-btn w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-purple-600 hover:border-purple-500 hover:text-white text-gray-300 transition-all" title="Podebljano"><b>B</b></button>
                                    <button type="button" onclick="applyFormat(this, 'italic')" class="format-btn w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-purple-600 hover:border-purple-500 hover:text-white text-gray-300 transition-all" title="Kurziv"><i>I</i></button>
                                    <button type="button" onclick="applyFormat(this, 'underline')" class="format-btn w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-purple-600 hover:border-purple-500 hover:text-white text-gray-300 transition-all" title="Podvučeno"><span class="underline">U</span></button>
                                    <button type="button" onclick="applyFormat(this, 'sup')" class="format-btn w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-purple-600 hover:border-purple-500 hover:text-white text-gray-300 transition-all" title="Gornji indeks">X<sup>2</sup></button>
                                    <button type="button" onclick="applyFormat(this, 'sub')" class="format-btn w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-purple-600 hover:border-purple-500 hover:text-white text-gray-300 transition-all" title="Donji indeks">X<sub>2</sub></button>
                                    <div class="w-px bg-gray-700 mx-1 self-stretch"></div>
                                    <button type="button" onclick="applyFormat(this, 'code')" class="format-btn px-2 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-emerald-600 hover:border-emerald-500 hover:text-white text-emerald-400 transition-all text-xs font-mono" title="Inline kod">&lt;/&gt;</button>
                                    <button type="button" onclick="applyFormat(this, 'codeblock')" class="format-btn px-2.5 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-emerald-600 hover:border-emerald-500 hover:text-white text-emerald-400 transition-all text-xs gap-1" title="Blok koda"><i class="fas fa-code"></i> Blok</button>
                                    <div class="w-px bg-gray-700 mx-1 self-stretch"></div>
                                    <button type="button" onclick="applyFormat(this, 'removeAll')" class="format-btn px-2.5 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-red-600 hover:border-red-500 hover:text-white text-gray-400 transition-all text-xs gap-1" title="Ukloni formatiranje"><i class="fas fa-times"></i> Ukloni</button>
                                </div>
                                <textarea name="q_question[<?= $index ?>]" class="question-textarea w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 resize-y min-h-[80px]" rows="2" required><?= htmlspecialchars($q['question']) ?></textarea>
                            </div>

                            <div>
                                <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 mb-2 block">Slika uz pitanje <span class="text-gray-500 font-normal lowercase">(opcionalno)</span></label>
                                <div class="flex flex-col xs:flex-row xs:flex-wrap items-start xs:items-center gap-3 bg-gray-900/50 p-3 sm:p-4 rounded-xl border border-gray-700/50">
                                    <?php if(!empty($q['image']) && file_exists($q['image'])): ?>
                                    <div class="flex-shrink-0 relative group existing-image-container">
                                        <img src="<?= htmlspecialchars($q['image']) ?>" alt="Trenutna slika" class="h-16 w-16 rounded-md object-cover cursor-pointer border border-gray-600" onclick="openLightbox(this.src)">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 rounded-md flex items-center justify-center pointer-events-none">
                                            <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100"></i>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="flex-shrink-0 relative group new-image-preview hidden">
                                        <img src="" alt="Preview" class="h-16 w-16 rounded-md object-cover cursor-pointer border border-gray-600" onclick="openLightbox(this.src)">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 rounded-md flex items-center justify-center pointer-events-none">
                                            <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow w-full xs:w-auto flex flex-col xs:flex-row xs:items-center flex-wrap gap-2">
                                        <label class="cursor-pointer inline-flex items-center px-3 py-2 bg-purple-600 text-white text-sm font-semibold rounded-xl hover:bg-purple-700 transition-colors shadow-md w-full xs:w-auto justify-center xs:justify-start">
                                            <i class="fas fa-camera mr-2"></i> Odaberi sliku
                                            <input type="file" name="q_image[<?= $index ?>]" accept="image/*" onchange="previewImage(this)" class="hidden">
                                        </label>
                                        <span class="text-xs sm:text-sm text-gray-400 file-name-display truncate max-w-full xs:max-w-[160px]"><?= (!empty($q['image']) && file_exists($q['image'])) ? basename($q['image']) : 'Nije odabrana slika' ?></span>
                                        <input type="hidden" name="q_existing_image[<?= $index ?>]" value="<?= htmlspecialchars($q['image'] ?? '') ?>">
                                        <button type="button" class="ml-2 text-red-400 hover:text-white bg-red-500/10 hover:bg-red-500 w-8 h-8 rounded-lg hidden items-center justify-center transition-colors remove-new-image-btn" onclick="removeNewImage(this)" title="Ukloni novu sliku">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <?php if(!empty($q['image']) && file_exists($q['image'])): ?>
                                        <div class="ml-2 inline-flex items-center remove-existing-container">
                                            <input type="checkbox" name="q_remove_image[]" value="<?= $index ?>" id="remove_img_<?= $index ?>" class="peer sr-only remove-existing-checkbox">
                                            <button type="button" onclick="removeExistingImage(this)" class="text-red-400 hover:text-white bg-red-500/10 hover:bg-red-500 w-8 h-8 rounded-lg flex items-center justify-center transition-colors" title="Ukloni sliku">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="options-container <?= ($qType === 'essay' || $qType === 'explanation') ? 'hidden' : '' ?>">
                                <div class="text-xs text-purple-400 mb-3 ml-1 font-medium flex items-center gap-1.5 bg-purple-500/10 w-fit px-3 py-1.5 rounded-lg border border-purple-500/20"><i class="fas fa-check-circle"></i> Označite kružić pored opcije da biste je postavili kao tačan odgovor.</div>
                                <div class="options-grid grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                    <?php 
                                    $optsCount = max(2, count($q['options'] ?? []));
                                    $inputType = $qType === 'multiple_select' ? 'checkbox' : 'radio';
                                    $roundedClass = $qType === 'multiple_select' ? 'rounded' : 'rounded-full';
                                    $innerRoundedClass = $qType === 'multiple_select' ? 'rounded-sm' : 'rounded-full';
                                    for($i=0; $i<$optsCount; $i++): 
                                    $rawOptVal = isset($q['options'][$i]) ? $q['options'][$i] : '';
                                    $optVal = htmlspecialchars($rawOptVal);
                                    $isChecked = '';
                                    if ($qType === 'multiple_select') {
                                        $ansArray = json_decode($q['answer'] ?? '[]', true) ?: [];
                                        if (!is_array($ansArray)) $ansArray = [$q['answer']];
                                        $isChecked = in_array($rawOptVal, $ansArray) ? 'checked' : '';
                                    } else {
                                        $isChecked = ($rawOptVal !== '' && isset($q['answer']) && $rawOptVal === $q['answer']) ? 'checked' : '';
                                    }
                                    ?>
                                    <div class="option-item">
                                        <div class="flex justify-between items-center mb-1.5">
                                            <label class="text-gray-400 text-[10px] font-bold uppercase tracking-wider ml-1">Opcija <span class="opt-num"><?= $i+1 ?></span></label>
                                            <button type="button" onclick="removeOption(this)" class="text-red-400 hover:text-red-300 text-xs px-2 <?= $optsCount <= 2 ? 'hidden' : '' ?>" title="Ukloni opciju"><i class="fas fa-times"></i></button>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="relative flex items-center justify-center w-6 h-6 flex-shrink-0">
                                            <input type="<?= $inputType ?>" name="correct_radio_<?= $index ?>" value="<?= $optVal ?>" <?= $isChecked ?> onclick="updateCorrectAnswerHidden(this.closest('.question-card'))" class="peer w-5 h-5 border-2 border-gray-600 <?= $roundedClass ?> bg-gray-800 checked:border-purple-500 appearance-none transition-all cursor-pointer shadow-inner correct-answer-selector">
                                                <div class="absolute w-2.5 h-2.5 bg-purple-500 <?= $innerRoundedClass ?> opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></div>
                                            </div>
                                            <input type="text" name="q_options[<?= $index ?>][]" value="<?= $optVal ?>" class="w-full bg-gray-900 text-white px-4 py-2.5 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 text-sm option-input" placeholder="Unesite odgovor..." oninput="updateRadioValue(this)">
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <button type="button" onclick="addOption(this)" class="bg-gray-800 hover:bg-gray-700 text-purple-400 text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-700 hover:border-purple-500/50 transition-colors flex items-center gap-1.5 shadow-sm">
                                        <i class="fas fa-plus"></i> Dodaj opciju
                                    </button>
                                </div>
                            </div>

                            <input type="hidden" name="q_answer[<?= $index ?>]" class="correct-answer-input" value="<?= htmlspecialchars($q['answer'] ?? '') ?>">

                        </div>

                        <!-- Kontrole: toolbar na dnu kartice, vidljiv samo na mobilnom -->
                        <div class="q-card-controls-bottom border-t border-gray-700/50 pt-4 mt-4 flex gap-3 justify-between">
                            <button type="button" onclick="toggleCollapse(this)" class="flex-1 text-gray-400 hover:text-white h-10 flex items-center justify-center rounded-xl bg-gray-700/30 hover:bg-gray-700 transition-colors border border-gray-600/30 shadow-sm" title="Sakrij/Prikaži">
                                <i class="fas fa-chevron-up text-base"></i>
                            </button>
                            <button type="button" onclick="duplicateQuestion(this)" class="flex-1 text-blue-400 hover:text-white h-10 flex items-center justify-center rounded-xl bg-blue-500/10 hover:bg-blue-500 transition-colors border border-blue-500/20 shadow-sm" title="Dupliraj pitanje">
                                <i class="fas fa-copy text-base"></i>
                            </button>
                            <span class="drag-handle flex-1 text-gray-400 hover:text-white h-10 flex items-center justify-center rounded-xl bg-gray-700/30 hover:bg-gray-700 transition-colors cursor-move border border-gray-600/30 shadow-sm" title="Pomjeri pitanje">
                                <i class="fas fa-grip-vertical text-base"></i>
                            </span>
                            <button type="button" onclick="removeQuestion(this)" class="flex-1 text-red-400 hover:text-white h-10 flex items-center justify-center rounded-xl bg-red-500/10 hover:bg-red-500 transition-colors border border-red-500/20 shadow-sm" title="Obriši pitanje">
                                <i class="fas fa-trash-alt text-base"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="flex flex-col gap-3 pt-6 sm:pt-8 border-t border-gray-700">
                <!-- Mobile: Sačuvaj prominentno na vrhu, Dodaj ispod -->
                <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-8 py-4 rounded-xl transition-all text-sm font-bold flex items-center justify-center gap-2 shadow-lg shadow-purple-500/20 sm:hidden">
                    <i class="fas fa-save"></i> Sačuvaj izmjene
                </button>
                <div class="flex flex-col sm:flex-row gap-3 justify-between items-stretch sm:items-center">
                    <button type="button" onclick="addQuestion()" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white px-6 py-3 rounded-xl transition-colors text-sm font-bold flex items-center justify-center gap-2 border border-blue-500/30">
                        <i class="fas fa-plus-circle"></i> Dodaj novo pitanje
                    </button>
                    <button type="submit" class="hidden sm:flex bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-8 py-3 rounded-xl transition-colors text-sm font-bold items-center justify-center gap-2 border border-purple-500/30">
                        <i class="fas fa-save"></i> Sačuvaj izmjene
                    </button>
                </div>
            </div>
        </form>
    </div>
  </main>
</div>

<!-- Template za novo pitanje (hidden) -->
<template id="question-template">
    <div class="question-card bg-gray-800/60 hover:bg-gray-800/80 transition-colors p-4 sm:p-7 rounded-2xl border border-gray-700/80 shadow-lg relative group animate-fadeIn">
        <!-- Kontrole: vidljive na desktop-u gore desno -->
        <div class="q-card-controls-top absolute top-4 right-4 gap-2">
            <button type="button" onclick="toggleCollapse(this)" class="text-gray-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-700 transition-colors" title="Sakrij/Prikaži">
                <i class="fas fa-chevron-up"></i>
            </button>
            <button type="button" onclick="duplicateQuestion(this)" class="text-blue-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg hover:bg-blue-600 transition-colors" title="Dupliraj pitanje">
                <i class="fas fa-copy"></i>
            </button>
            <span class="drag-handle text-gray-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-700 transition-colors cursor-move" title="Pomjeri pitanje">
                <i class="fas fa-grip-vertical"></i>
            </span>
            <button type="button" onclick="removeQuestion(this)" class="text-red-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg hover:bg-red-600 transition-colors" title="Obriši pitanje">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
        
        <h3 class="font-bold mb-4 sm:mb-6 text-lg sm:text-xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gray-700 flex items-center justify-center text-purple-400 text-sm"><i class="fas fa-question"></i></div>
            <span class="text-white"><span class="q-label">Pitanje</span> <span class="q-number-wrapper">#<span class="q-number"></span></span></span>
        </h3>
        
        <div class="question-content grid gap-4 transition-all duration-300">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <div class="flex-1">
                    <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 mb-2 block">Tip pitanja</label>
                    <div class="relative">
                        <input type="hidden" name="q_type[]" value="multiple_choice" class="q-type-input">
                        <button type="button" onclick="elevateZIndex(this); this.nextElementSibling.classList.toggle('hidden')" class="w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 hover:border-purple-500 focus:border-purple-500 outline-none transition-all flex items-center justify-between shadow-sm cursor-pointer custom-select-btn">
                            <span class="truncate font-medium flex items-center gap-3 text-sm">
                                <i class="fas fa-dot-circle text-blue-400"></i> Višestruki izbor (1 tačan)
                            </span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>

                        <div class="hidden absolute left-0 right-0 top-[100%] mt-2 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden animate-fadeIn z-[60] custom-select-dropdown">
                            <div class="flex flex-col p-1.5 gap-1">
                                <button type="button" onclick="selectQuestionType(this, 'multiple_choice', 'Višestruki izbor (1 tačan)', 'fa-dot-circle text-blue-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 bg-gray-700 text-white text-left w-full">
                                    <div class="w-5 flex justify-center"><i class="fas fa-dot-circle text-blue-400"></i></div> Višestruki izbor (1 tačan)
                                </button>
                                <button type="button" onclick="selectQuestionType(this, 'multiple_select', 'Višestruki odabir (više tačnih)', 'fa-check-square text-indigo-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                                    <div class="w-5 flex justify-center"><i class="fas fa-check-square text-indigo-400"></i></div> Višestruki odabir (više tačnih)
                                </button>
                                <button type="button" onclick="selectQuestionType(this, 'essay', 'Esej', 'fa-align-left text-green-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                                    <div class="w-5 flex justify-center"><i class="fas fa-align-left text-green-400"></i></div> Esej
                                </button>
                                <button type="button" onclick="selectQuestionType(this, 'explanation', 'Objašnjenje (Info)', 'fa-info-circle text-purple-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                                    <div class="w-5 flex justify-center"><i class="fas fa-info-circle text-purple-400"></i></div> Objašnjenje (Info)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full sm:w-32 points-container">
                    <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 mb-2 block">Bodovi</label>
                    <div class="flex items-center bg-gray-900 rounded-xl border border-gray-700 overflow-hidden focus-within:border-purple-500 focus-within:ring-1 focus-within:ring-purple-500 transition-all">
                        <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-3 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-colors outline-none cursor-pointer flex-shrink-0">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <input type="number" step="0.5" min="0" name="q_points[]" value="1" class="w-full bg-transparent text-white text-center border-none p-0 focus:ring-0 appearance-none [-moz-appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none font-medium">
                        <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-3 py-3 text-gray-400 hover:text-white hover:bg-gray-800 transition-colors outline-none cursor-pointer flex-shrink-0">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 question-text-label">Tekst pitanja</label>
                    <button type="button" onclick="toggleFormatToolbar(this)" class="flex items-center gap-1.5 text-xs text-purple-400 hover:text-white bg-purple-500/10 hover:bg-purple-600 px-2.5 py-1 rounded-lg border border-purple-500/20 hover:border-purple-500 transition-all" title="Opcije formatiranja">
                        <i class="fas fa-pen-nib"></i> <span class="hidden sm:inline">Format</span>
                    </button>
                </div>
                <div class="format-toolbar hidden mb-2 flex-wrap gap-1 p-2 bg-gray-900/80 border border-gray-700 rounded-xl animate-fadeIn">
                    <button type="button" onclick="applyFormat(this, 'bold')" class="format-btn w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-purple-600 hover:border-purple-500 hover:text-white text-gray-300 transition-all" title="Podebljano"><b>B</b></button>
                    <button type="button" onclick="applyFormat(this, 'italic')" class="format-btn w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-purple-600 hover:border-purple-500 hover:text-white text-gray-300 transition-all" title="Kurziv"><i>I</i></button>
                    <button type="button" onclick="applyFormat(this, 'underline')" class="format-btn w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-purple-600 hover:border-purple-500 hover:text-white text-gray-300 transition-all" title="Podvučeno"><span class="underline">U</span></button>
                    <button type="button" onclick="applyFormat(this, 'sup')" class="format-btn w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-purple-600 hover:border-purple-500 hover:text-white text-gray-300 transition-all" title="Gornji indeks">X<sup>2</sup></button>
                    <button type="button" onclick="applyFormat(this, 'sub')" class="format-btn w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-purple-600 hover:border-purple-500 hover:text-white text-gray-300 transition-all" title="Donji indeks">X<sub>2</sub></button>
                    <div class="w-px bg-gray-700 mx-1 self-stretch"></div>
                    <button type="button" onclick="applyFormat(this, 'code')" class="format-btn px-2 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-emerald-600 hover:border-emerald-500 hover:text-white text-emerald-400 transition-all text-xs font-mono" title="Inline kod">&lt;/&gt;</button>
                    <button type="button" onclick="applyFormat(this, 'codeblock')" class="format-btn px-2.5 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-emerald-600 hover:border-emerald-500 hover:text-white text-emerald-400 transition-all text-xs gap-1" title="Blok koda"><i class="fas fa-code"></i> Blok</button>
                    <div class="w-px bg-gray-700 mx-1 self-stretch"></div>
                    <button type="button" onclick="applyFormat(this, 'removeAll')" class="format-btn px-2.5 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 hover:bg-red-600 hover:border-red-500 hover:text-white text-gray-400 transition-all text-xs gap-1" title="Ukloni formatiranje"><i class="fas fa-times"></i> Ukloni</button>
                </div>
                <textarea name="q_question[]" class="question-textarea w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 resize-y min-h-[80px]" rows="2" required></textarea>
            </div>

            <div>
                <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 mb-2 block">Slika uz pitanje <span class="text-gray-500 font-normal lowercase">(opcionalno)</span></label>
                <div class="flex flex-col xs:flex-row xs:flex-wrap items-start xs:items-center gap-3 bg-gray-900/50 p-3 sm:p-4 rounded-xl border border-gray-700/50">
                    <div class="flex-shrink-0 relative group new-image-preview hidden">
                        <img src="" alt="Preview" class="h-16 w-16 rounded-md object-cover cursor-pointer border border-gray-600" onclick="openLightbox(this.src)">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 rounded-md flex items-center justify-center pointer-events-none">
                            <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100"></i>
                        </div>
                    </div>
                    <div class="flex-grow w-full xs:w-auto flex flex-col xs:flex-row xs:items-center flex-wrap gap-2">
                        <label class="cursor-pointer inline-flex items-center px-3 py-2 bg-gray-800 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 border border-gray-600 transition-colors shadow-sm w-full xs:w-auto justify-center xs:justify-start">
                            <i class="fas fa-camera mr-2"></i> Odaberi sliku
                            <input type="file" name="q_image[]" accept="image/*" onchange="previewImage(this)" class="hidden">
                        </label>
                        <span class="text-xs sm:text-sm text-gray-500 file-name-display truncate max-w-full xs:max-w-[160px]">Nije odabrana slika</span>
                        <input type="hidden" name="q_existing_image[]" value="">
                        <button type="button" class="ml-2 text-red-400 hover:text-white bg-red-500/10 hover:bg-red-500 w-8 h-8 rounded-lg hidden items-center justify-center transition-colors remove-new-image-btn" onclick="removeNewImage(this)" title="Ukloni novu sliku">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="options-container">
                <div class="text-xs text-purple-400 mb-3 ml-1 font-medium flex items-center gap-1.5 bg-purple-500/10 w-fit px-3 py-1.5 rounded-lg border border-purple-500/20"><i class="fas fa-check-circle"></i> Označite kružić pored opcije da biste je postavili kao tačan odgovor.</div>
                <div class="options-grid grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                    <!-- JS ce ubaciti ovde opcije -->
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="button" onclick="addOption(this)" class="bg-gray-800 hover:bg-gray-700 text-purple-400 text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-700 hover:border-purple-500/50 transition-colors flex items-center gap-1.5 shadow-sm">
                        <i class="fas fa-plus"></i> Dodaj opciju
                    </button>
                </div>
            </div>

            <input type="hidden" name="q_answer[]" class="correct-answer-input" value="">

        </div>

        <!-- Kontrole: toolbar na dnu kartice, vidljiv samo na mobilnom (template) -->
        <div class="q-card-controls-bottom border-t border-gray-700/50 pt-4 mt-4 flex gap-3 justify-between">
            <button type="button" onclick="toggleCollapse(this)" class="flex-1 text-gray-400 hover:text-white h-10 flex items-center justify-center rounded-xl bg-gray-700/30 hover:bg-gray-700 transition-colors border border-gray-600/30 shadow-sm" title="Sakrij/Prikaži">
                <i class="fas fa-chevron-up text-base"></i>
            </button>
            <button type="button" onclick="duplicateQuestion(this)" class="flex-1 text-blue-400 hover:text-white h-10 flex items-center justify-center rounded-xl bg-blue-500/10 hover:bg-blue-500 transition-colors border border-blue-500/20 shadow-sm" title="Dupliraj pitanje">
                <i class="fas fa-copy text-base"></i>
            </button>
            <span class="drag-handle flex-1 text-gray-400 hover:text-white h-10 flex items-center justify-center rounded-xl bg-gray-700/30 hover:bg-gray-700 transition-colors cursor-move border border-gray-600/30 shadow-sm" title="Pomjeri pitanje">
                <i class="fas fa-grip-vertical text-base"></i>
            </span>
            <button type="button" onclick="removeQuestion(this)" class="flex-1 text-red-400 hover:text-white h-10 flex items-center justify-center rounded-xl bg-red-500/10 hover:bg-red-500 transition-colors border border-red-500/20 shadow-sm" title="Obriši pitanje">
                <i class="fas fa-trash-alt text-base"></i>
            </button>
        </div>
    </div>
</template>

<!-- Lightbox Modal -->
<div id="imageLightbox" class="hidden fixed inset-0 z-[100] flex justify-center items-center bg-black/90 backdrop-blur-sm transition-all duration-300 opacity-0" onclick="closeLightbox()">
    <div class="relative max-w-[90vw] max-h-[90vh]" onclick="event.stopPropagation()">
        <img id="lightboxImage" src="" alt="Full size" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl object-contain">
        <button class="absolute -top-10 right-0 text-white text-3xl hover:text-gray-300 transition" onclick="closeLightbox()">&times;</button>
    </div>
</div>

<!-- Modal za potvrdu brisanja -->
<div id="deleteModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="deleteContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-4 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center text-red-500 border border-red-500/30">
            <i class="fas fa-exclamation-triangle text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Potvrdi brisanje</h2>
    </div>
    <p class="text-gray-300 mb-6 text-sm sm:text-base leading-relaxed">Jeste li sigurni da želite obrisati ovo pitanje?</p>
    <div class="flex justify-end gap-3 pt-2">
      <button type="button" id="cancelDeleteBtn" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
      <button type="button" id="confirmDeleteBtn" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-red-500/30">
        <i class="fas fa-trash-alt"></i> Obriši
      </button>
    </div>
  </div>
</div>

<script>
    function previewImage(input) {
        const container = input.closest('.bg-gray-900\\/50');
        const previewContainer = container.querySelector('.new-image-preview');
        const existingContainer = container.querySelector('.existing-image-container');
        const img = previewContainer.querySelector('img');
        const fileNameDisplay = container.querySelector('.file-name-display');
        const removeBtn = container.querySelector('.remove-new-image-btn');
        const removeExistingContainer = container.querySelector('.remove-existing-container');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                previewContainer.classList.remove('hidden');
                if(existingContainer) existingContainer.classList.add('hidden');
                if(removeBtn) {
                    removeBtn.classList.remove('hidden');
                    removeBtn.classList.add('flex');
                }
                if(removeExistingContainer) removeExistingContainer.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
            if(fileNameDisplay) fileNameDisplay.textContent = input.files[0].name;
        } else {
            if(removeBtn) removeNewImage(removeBtn);
        }
    }

    function removeNewImage(btn) {
        const container = btn.closest('.bg-gray-900\\/50');
        const input = container.querySelector('input[type="file"]');
        const previewContainer = container.querySelector('.new-image-preview');
        const existingContainer = container.querySelector('.existing-image-container');
        const fileNameDisplay = container.querySelector('.file-name-display');
        const removeExistingContainer = container.querySelector('.remove-existing-container');
        const removeExistingCheckbox = container.querySelector('.remove-existing-checkbox');
        
        input.value = ''; // Reset inputa
        previewContainer.classList.add('hidden');
        previewContainer.querySelector('img').src = '';
        
        btn.classList.add('hidden'); btn.classList.remove('flex');
        
        if (removeExistingCheckbox && removeExistingCheckbox.checked) {
            if(fileNameDisplay) fileNameDisplay.textContent = 'Nije odabrana slika';
        } else {
            if(existingContainer) existingContainer.classList.remove('hidden');
            if(removeExistingContainer) removeExistingContainer.classList.remove('hidden');
            
            const existingImageInput = container.querySelector('input[name^="q_existing_image"]');
            if(existingImageInput && existingImageInput.value !== '') {
                const fileName = existingImageInput.value.split('/').pop();
                if(fileNameDisplay) fileNameDisplay.textContent = fileName;
            } else {
                if(fileNameDisplay) fileNameDisplay.textContent = 'Nije odabrana slika';
            }
        }
    }

    function removeExistingImage(btn) {
        const container = btn.closest('.bg-gray-900\\/50');
        const existingContainer = container.querySelector('.existing-image-container');
        const fileNameDisplay = container.querySelector('.file-name-display');
        const checkbox = container.querySelector('.remove-existing-checkbox');
        const removeContainer = container.querySelector('.remove-existing-container');
        
        if(existingContainer) existingContainer.classList.add('hidden');
        if(checkbox) checkbox.checked = true;
        if(fileNameDisplay) fileNameDisplay.textContent = 'Nije odabrana slika';
        if(removeContainer) removeContainer.classList.add('hidden');
    }

    function openLightbox(src) {
        const lightbox = document.getElementById('imageLightbox');
        const img = document.getElementById('lightboxImage');
        img.src = src;
        lightbox.classList.remove('hidden');
        requestAnimationFrame(() => {
            lightbox.classList.remove('opacity-0');
        });
    }

    function closeLightbox() {
        const lightbox = document.getElementById('imageLightbox');
        lightbox.classList.add('opacity-0');
        setTimeout(() => {
            lightbox.classList.add('hidden');
        }, 300);
    }

        window.selectQuestionType = function(btn, value, text, iconClass) {
            const container = btn.closest('.relative');
            const input = container.querySelector('.q-type-input');
            const btnText = container.querySelector('.custom-select-btn span');
            const dropdown = container.querySelector('.custom-select-dropdown');
            
            input.value = value;
            btnText.innerHTML = `<i class="fas ${iconClass}"></i> ${text}`;
            dropdown.classList.add('hidden');
            
            const allBtns = dropdown.querySelectorAll('button');
            allBtns.forEach(b => {
                b.classList.remove('bg-gray-700', 'text-white');
                b.classList.add('text-gray-300', 'hover:bg-gray-700', 'hover:text-white');
            });
            btn.classList.remove('text-gray-300', 'hover:bg-gray-700', 'hover:text-white');
            btn.classList.add('bg-gray-700', 'text-white');
            
            const card = btn.closest('.question-card');
            if(card) card.style.zIndex = '';
            
            toggleQuestionType(input);
        };

        window.elevateZIndex = function(btn) {
            document.querySelectorAll('.question-card').forEach(c => c.style.zIndex = '');
            document.querySelectorAll('.custom-select-dropdown').forEach(d => {
                if(d !== btn.nextElementSibling) d.classList.add('hidden');
            });
            const card = btn.closest('.question-card');
            if(card && btn.nextElementSibling.classList.contains('hidden')) {
                card.style.zIndex = '50';
            }
        };

        document.addEventListener('click', function(e) {
            if(!e.target.closest('.custom-select-btn') && !e.target.closest('.custom-select-dropdown')) {
                document.querySelectorAll('.custom-select-dropdown').forEach(d => d.classList.add('hidden'));
                document.querySelectorAll('.question-card').forEach(c => c.style.zIndex = '');
            }
        });

    function toggleQuestionType(select) {
        const card = select.closest('.question-card');
        const optionsContainer = card.querySelector('.options-container');
        const pointsContainer = card.querySelector('.points-container');
        const label = card.querySelector('.q-label');
        const textLabel = card.querySelector('.question-text-label');
        const isMultiSelect = select.value === 'multiple_select';
        
        if (select.value === 'explanation') {
            optionsContainer.classList.add('hidden');
            if (pointsContainer) pointsContainer.classList.add('hidden');
            label.textContent = 'Objašnjenje';
            textLabel.textContent = 'Tekst objašnjenja';
            card.querySelector('h3 i').className = 'fas fa-info';
        } else if (select.value === 'essay') {
            optionsContainer.classList.add('hidden');
            if (pointsContainer) pointsContainer.classList.remove('hidden');
            label.textContent = 'Pitanje';
            textLabel.textContent = 'Tekst pitanja';
            card.querySelector('h3 i').className = 'fas fa-question';
        } else {
            optionsContainer.classList.remove('hidden');
            if (pointsContainer) pointsContainer.classList.remove('hidden');
            label.textContent = 'Pitanje';
            textLabel.textContent = 'Tekst pitanja';
            card.querySelector('h3 i').className = 'fas fa-question';
            
            card.querySelectorAll('.correct-answer-selector').forEach(input => {
                input.type = isMultiSelect ? 'checkbox' : 'radio';
                if (isMultiSelect) {
                    input.classList.replace('rounded-full', 'rounded');
                    input.nextElementSibling.classList.replace('rounded-full', 'rounded-sm');
                } else {
                    input.classList.replace('rounded', 'rounded-full');
                    input.nextElementSibling.classList.replace('rounded-sm', 'rounded-full');
                }
            });
            updateCorrectAnswerHidden(card);
        }
        updateNumbers();
    }

    function updateNumbers() {
        let realNum = 1;
        document.querySelectorAll('.question-card').forEach((card, index) => {
            const typeSelect = card.querySelector('[name^="q_type"]');
            const numWrapper = card.querySelector('.q-number-wrapper');
            
            if (typeSelect && typeSelect.value === 'explanation') {
                if(numWrapper) numWrapper.style.display = 'none';
            } else {
                if(numWrapper) numWrapper.style.display = 'inline';
                card.querySelector('.q-number').textContent = realNum++;
            }
            
            // Ažuriraj SVA polja da koriste ispravan index kako bi backend dobio savršeno uvezane podatke
            card.querySelectorAll('[name^="q_type"]').forEach(el => el.name = `q_type[${index}]`);
            card.querySelectorAll('[name^="q_question"]').forEach(el => el.name = `q_question[${index}]`);
            card.querySelectorAll('[name^="q_image"]').forEach(el => el.name = `q_image[${index}]`);
            card.querySelectorAll('[name^="q_points"]').forEach(el => el.name = `q_points[${index}]`);
            card.querySelectorAll('[name^="q_existing_image"]').forEach(el => el.name = `q_existing_image[${index}]`);
            card.querySelectorAll('.correct-answer-input').forEach(el => el.name = `q_answer[${index}]`);
            
            // Ažuriraj radio button names da budu jedinstveni po grupi
            const selectors = card.querySelectorAll('.correct-answer-selector');
            selectors.forEach(sel => {
                sel.name = 'correct_radio_' + index;
            });
            
            card.querySelectorAll('.option-input').forEach(el => {
                el.name = `q_options[${index}][]`;
            });
            
            // Ažuriraj remove image checkbox values da odgovaraju trenutnom redoslijedu
            const removeCb = card.querySelector('input[type="checkbox"][id^="remove_img_"]');
            if(removeCb) {
                removeCb.name = 'q_remove_image[]';
                removeCb.value = index;
                removeCb.id = 'remove_img_' + index;
                const label = card.querySelector('label[for^="remove_img_"]');
                if(label) label.setAttribute('for', 'remove_img_' + index);
            }
            
            updateOptionNumbers(card);
        });
    }

    window.updateOptionNumbers = function(card) {
        const options = card.querySelectorAll('.option-item');
        options.forEach((opt, idx) => {
            opt.querySelector('.opt-num').textContent = idx + 1;
            const removeBtn = opt.querySelector('button[onclick="removeOption(this)"]');
            if (removeBtn) {
                if (options.length <= 2) {
                    removeBtn.classList.add('hidden');
                } else {
                    removeBtn.classList.remove('hidden');
                }
            }
        });
    }

    window.addOptionToCard = function(card) {
        const grid = card.querySelector('.options-grid');
        const index = Array.from(document.querySelectorAll('.question-card')).indexOf(card);
        const type = card.querySelector('.q-type-input').value;
        const isMulti = type === 'multiple_select';
        const inputType = isMulti ? 'checkbox' : 'radio';
        const roundedClass = isMulti ? 'rounded' : 'rounded-full';
        const innerRoundedClass = isMulti ? 'rounded-sm' : 'rounded-full';
        const div = document.createElement('div');
        div.className = 'option-item animate-fadeIn';
        div.innerHTML = `
            <div class="flex justify-between items-center mb-1.5">
                <label class="text-gray-400 text-[10px] font-bold uppercase tracking-wider ml-1">Opcija <span class="opt-num"></span></label>
                <button type="button" onclick="removeOption(this)" class="text-red-400 hover:text-red-300 text-xs px-2" title="Ukloni opciju"><i class="fas fa-times"></i></button>
            </div>
            <div class="flex items-center gap-2">
                <div class="relative flex items-center justify-center w-6 h-6 flex-shrink-0">
                    <input type="${inputType}" name="correct_radio_${index}" onclick="updateCorrectAnswerHidden(this.closest('.question-card'))" class="peer w-5 h-5 border-2 border-gray-600 ${roundedClass} bg-gray-800 checked:border-purple-500 appearance-none transition-all cursor-pointer shadow-inner correct-answer-selector">
                    <div class="absolute w-2.5 h-2.5 bg-purple-500 ${innerRoundedClass} opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></div>
                </div>
                <input type="text" name="q_options[${index}][]" class="w-full bg-gray-900 text-white px-4 py-2.5 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 text-sm option-input" placeholder="Unesite odgovor..." oninput="updateRadioValue(this)">
            </div>
        `;
        grid.appendChild(div);
        updateOptionNumbers(card);
    }

    window.addOption = function(btn) {
        addOptionToCard(btn.closest('.question-card'));
    }

    window.removeOption = function(btn) {
        const card = btn.closest('.question-card');
        const optionItem = btn.closest('.option-item');
        
        optionItem.remove();
        updateCorrectAnswerHidden(card);
        updateOptionNumbers(card);
    }

    // Modal logic
    let questionToDelete = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteContent = document.getElementById('deleteContent');

    function showModal(modal, content){
        modal.classList.remove('hidden');
        requestAnimationFrame(()=> {
            modal.classList.remove('bg-black/0');
            modal.classList.add('bg-black/50');
            content.classList.remove('opacity-0','scale-95');
            content.classList.add('opacity-100','scale-100');
        });
    }

    function hideModal(modal, content){
        modal.classList.remove('bg-black/50');
        modal.classList.add('bg-black/0');
        content.classList.remove('opacity-100','scale-100');
        content.classList.add('opacity-0','scale-95');
        setTimeout(()=> modal.classList.add('hidden'),300);
    }


    // ===================== FORMAT TOOLBAR =====================
    function toggleFormatToolbar(btn) {
        // Idemo do zajedničkog parent diva koji sadrži i dugme i toolbar i textarea
        const wrapper = btn.closest('div').parentElement; // .content div pitanja
        const header = btn.closest('div');                // flex div koji drži label + dugme
        const toolbar = header.nextElementSibling;       // .format-toolbar div
        const textarea = toolbar.nextElementSibling;     // <textarea>

        if (!toolbar || !toolbar.classList.contains('format-toolbar')) return; // guard

        const isHidden = toolbar.classList.contains('hidden');

        if (isHidden) {
            // Prikaži toolbar: ukloni hidden, postaći flex
            toolbar.classList.remove('hidden');
            toolbar.style.display = 'flex';
            btn.classList.add('bg-purple-600', 'text-white');
            btn.classList.remove('bg-purple-500/10', 'text-purple-400');
            if (textarea) textarea.focus();
        } else {
            // Sakrij toolbar
            toolbar.style.display = '';
            toolbar.classList.add('hidden');
            btn.classList.remove('bg-purple-600', 'text-white');
            btn.classList.add('bg-purple-500/10', 'text-purple-400');
        }
    }

    function applyFormat(btn, type) {
        const toolbar = btn.closest('.format-toolbar');
        const textarea = toolbar.nextElementSibling;
        if (!textarea) return;

        textarea.focus();
        const start  = textarea.selectionStart;
        const end    = textarea.selectionEnd;
        const selected = textarea.value.substring(start, end);
        const before   = textarea.value.substring(0, start);
        const after    = textarea.value.substring(end);

        // Tagovi za svaki tip formatiranja
        const tags = {
            bold:      ['<strong>', '</strong>'],
            italic:    ['<em>', '</em>'],
            underline: ['<u>', '</u>'],
            sup:       ['<sup>', '</sup>'],
            sub:       ['<sub>', '</sub>'],
            code:      ['<code>', '</code>'],
        };

        if (type === 'removeAll') {
            // Ukloni sve poznate HTML tagove iz odabira
            const cleaned = selected.replace(/<\/?(?:strong|b|em|i|u|sup|sub|code|pre|span)[^>]*>/gi, '');
            textarea.value = before + cleaned + after;
            textarea.selectionStart = start;
            textarea.selectionEnd   = start + cleaned.length;
            textarea.focus();
            return;
        }

        if (type === 'codeblock') {
            const inner = selected.length > 0 ? selected : '\n';
            const wrapped = `<pre><code>${inner}</code></pre>`;
            textarea.value = before + wrapped + after;
            if (selected.length > 0) {
                textarea.selectionStart = start;
                textarea.selectionEnd   = start + wrapped.length;
            } else {
                // Postavi kursor unutar <pre><code>|</code></pre>
                const cursorPos = start + '<pre><code>'.length;
                textarea.selectionStart = textarea.selectionEnd = cursorPos;
            }
            textarea.focus();
            return;
        }

        if (tags[type]) {
            const [open, close] = tags[type];

            if (selected.length > 0) {
                // Provjeri toggle: ako odabrani tekst već ima ovaj tag, ukloni ga
                const pattern = new RegExp(
                    '^' + open.replace(/[<>]/g, '\\$&') +
                    '([\\s\\S]*)' +
                    close.replace(/[<>]/g, '\\$&') + '$', 'i'
                );
                if (pattern.test(selected)) {
                    // Toggle off — ukloni tagove
                    const inner = selected.replace(pattern, '$1');
                    textarea.value = before + inner + after;
                    textarea.selectionStart = start;
                    textarea.selectionEnd   = start + inner.length;
                } else {
                    // Dodaj tagove
                    const wrapped = open + selected + close;
                    textarea.value = before + wrapped + after;
                    textarea.selectionStart = start;
                    textarea.selectionEnd   = start + wrapped.length;
                }
            } else {
                // Bez selekcije: ubaci tag i postavi kursor između
                const wrapped = open + close;
                textarea.value = before + wrapped + after;
                textarea.selectionStart = textarea.selectionEnd = start + open.length;
            }

            textarea.focus();
        }
    }
    // ===========================================================

    function duplicateQuestion(btn) {

        const card = btn.closest('.question-card');
        const clone = card.cloneNode(true);
        
        // Reset file input jer se fajlovi ne mogu klonirati iz sigurnosnih razloga
        const fileInput = clone.querySelector('input[type="file"]');
        if(fileInput) fileInput.value = '';
        
        // Resetuj hidden input za postojeću sliku da ne bi brisanje jedne uticalo na drugu
        // (Opcionalno: ako želite da zadržite sliku, ostavite ovo, ali pazite na brisanje)
        // Za sada ćemo zadržati referencu na sliku radi lakšeg rada
        
        // Uncheck remove image checkbox
        const removeCb = clone.querySelector('input[name="q_remove_image[]"]');
        if(removeCb) removeCb.checked = false;

        // Ubaci klon nakon trenutne kartice
        card.parentNode.insertBefore(clone, card.nextSibling);
        
        updateNumbers();
        
        // Glatko skrolovanje sa offsetom ka klonu
        setTimeout(() => {
            const offset = 40;
            const topPos = clone.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top: topPos, behavior: 'smooth' });
        }, 50);
    }

    function toggleCollapse(btn) {
        const card = btn.closest('.question-card');
        const content = card.querySelector('.question-content');
        const icons = card.querySelectorAll('.fa-chevron-up, .fa-chevron-down');
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icons.forEach(i => { i.classList.remove('fa-chevron-down'); i.classList.add('fa-chevron-up'); });
        } else {
            content.classList.add('hidden');
            icons.forEach(i => { i.classList.remove('fa-chevron-up'); i.classList.add('fa-chevron-down'); });
        }
    }

    function removeQuestion(btn) {
        questionToDelete = btn.closest('.question-card');
        showModal(deleteModal, deleteContent);
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (questionToDelete) {
            questionToDelete.classList.add('fade-out');
            setTimeout(() => {
                questionToDelete.remove();
                updateNumbers();
                questionToDelete = null;
            }, 300); // Wait for animation
            hideModal(deleteModal, deleteContent);
        }
    });

    document.getElementById('cancelDeleteBtn').addEventListener('click', function() {
        hideModal(deleteModal, deleteContent);
        questionToDelete = null;
    });
    
    // Close on click outside
    deleteModal.addEventListener('click', (e) => {
        if(e.target === deleteModal) {
            hideModal(deleteModal, deleteContent);
            questionToDelete = null;
        }
    });

    function addQuestion() {
        const container = document.getElementById('questions-container');
        const template = document.getElementById('question-template');
        const clone = template.content.cloneNode(true);
        
        container.appendChild(clone);
        const newCard = container.lastElementChild;
        
        for(let i=0; i<4; i++) {
            addOptionToCard(newCard);
        }

        updateNumbers();
        
        // Glatko skrolovanje sa offsetom ka novom pitanju
        setTimeout(() => {
            const newCard = container.lastElementChild;
            const offset = 40;
            const topPos = newCard.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top: topPos, behavior: 'smooth' });
        }, 50);
    }

    // Kada se kuca u input polje opcije, ažuriraj value radio dugmeta
    function updateRadioValue(input) {
        const selector = input.previousElementSibling.querySelector('.correct-answer-selector');
        if (selector) {
            selector.value = input.value;
            if(selector.checked) {
                updateCorrectAnswerHidden(input.closest('.question-card'));
            }
        }
    }

    // Funkcija koja dinamički kupi sve označene tačne odgovore
    window.updateCorrectAnswerHidden = function(card) {
        const type = card.querySelector('.q-type-input').value;
        const hiddenInput = card.querySelector('.correct-answer-input');
        if (type === 'multiple_choice') {
            const checked = card.querySelector('.correct-answer-selector:checked');
            hiddenInput.value = checked ? checked.closest('.relative').nextElementSibling.value : '';
        } else if (type === 'multiple_select') {
            const checkedElements = card.querySelectorAll('.correct-answer-selector:checked');
            const vals = Array.from(checkedElements).map(chk => chk.closest('.relative').nextElementSibling.value);
            hiddenInput.value = JSON.stringify(vals);
        } else {
            hiddenInput.value = '';
        }
    }

    // Drag & Drop funkcionalnost
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('questions-container');
        let draggedItem = null;

        // Aktiviraj drag samo na handle-u
        container.addEventListener('mousedown', function(e) {
            const handle = e.target.closest('.drag-handle');
            if (handle) {
                const card = handle.closest('.question-card');
                card.setAttribute('draggable', 'true');
            }
        });

        container.addEventListener('mouseup', function(e) {
            const handle = e.target.closest('.drag-handle');
            if (handle) {
                const card = handle.closest('.question-card');
                card.setAttribute('draggable', 'false');
            }
        });

        container.addEventListener('dragstart', function(e) {
            const card = e.target.closest('.question-card');
            if (card && card.getAttribute('draggable') === 'true') {
                draggedItem = card;
                e.dataTransfer.effectAllowed = 'move';
                card.classList.add('opacity-50', 'border-purple-500');
            } else {
                e.preventDefault();
            }
        });

        container.addEventListener('dragend', function(e) {
            const card = e.target.closest('.question-card');
            if (card) {
                card.classList.remove('opacity-50', 'border-purple-500');
                card.setAttribute('draggable', 'false');
            }
            draggedItem = null;
            updateNumbers();
        });

        container.addEventListener('dragover', function(e) {
            e.preventDefault();
            const card = e.target.closest('.question-card');
            if (card && card !== draggedItem && draggedItem) {
                const rect = card.getBoundingClientRect();
                const next = (e.clientY - rect.top) / (rect.bottom - rect.top) > 0.5;
                if (next) {
                    container.insertBefore(draggedItem, card.nextSibling);
                } else {
                    container.insertBefore(draggedItem, card);
                }
            }
        });
    });

    // Validacija prije slanja
    document.getElementById('testForm').addEventListener('submit', function(e) {
        // Uklonjena stroga validacija za tačan odgovor jer HTML template testovi nemaju tačan odgovor
        // let valid = true;
        // document.querySelectorAll('.question-card').forEach((card, index) => {
        //     const answer = card.querySelector('.correct-answer-input').value;
        //     // Provjeravamo da li su opcije popunjene (ako jesu, onda je kviz i mora imati odgovor)
        //     const hasOptions = Array.from(card.querySelectorAll('.option-input')).some(input => input.value.trim() !== '');
        //     if(hasOptions && !answer) {
        //         alert('Molimo označite tačan odgovor za pitanje #' + (index + 1));
        //         valid = false;
        //         e.preventDefault();
        //         return;
        //     }
        // });
    });

    // Inicijalno postavljanje brojeva (ako je potrebno)
    updateNumbers();
</script>

<style>
    /* .animate-fadeIn je već definisan u @layer utilities */
    .fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }
    @keyframes fadeOut {
        0% { opacity: 1; transform: scale(1); max-height: 1000px; margin-bottom: 24px; }
        100% { opacity: 0; transform: scale(0.95); max-height: 0; margin-bottom: 0; padding: 0; border: none; }
    }
    /* Prevent zoom on iOS inputs */
    @media screen and (max-width: 768px) {
        input, textarea, select { font-size: 16px !important; }
    }
</style>

</body>
</html>
