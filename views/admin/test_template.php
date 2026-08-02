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
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>✏️</text></svg>">
  <title><?= $testNameHtml ?></title>
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
    .gradient-bg { background: linear-gradient(-45deg,#1a1a2e,#162447,#1f4068,#e43f5a); background-size: 400% 400%; animation: gradientBG 15s ease infinite; }
    @keyframes gradientBG { 0% {background-position:0% 50%;} 50% {background-position:100% 50%;} 100% {background-position:0% 50%;} }

    /* Ocean Theme Overrides */
    html.theme-ocean body { background: linear-gradient(135deg, #f0f9ff 0%, #ecfdf5 50%, #f0fdfa 100%) !important; color: #1e293b !important; }
    html.theme-ocean .glass-effect { background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.95)) !important; border: 1px solid rgba(0, 0, 0, 0.1) !important; box-shadow: 0 10px 30px rgba(13,148,136,0.12), 0 4px 16px rgba(8,145,178,0.08) !important; }
    html.theme-ocean .bg-gray-900, html.theme-ocean .bg-gray-900\/50 { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important; border-color: #ccfbf1 !important; }
    html.theme-ocean .points-badge { background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%) !important; color: #475569 !important; border-color: #ccfbf1 !important; }
    html.theme-ocean .bg-gray-800\/60 { background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important; border-color: #ccfbf1 !important; }
    html.theme-ocean input[type="text"], html.theme-ocean textarea, html.theme-ocean input[type="password"] { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; color: #0f172a !important; border-color: #ccfbf1 !important; }
    html.theme-ocean input[type="text"]:focus, html.theme-ocean textarea:focus, html.theme-ocean input[type="password"]:focus { border-color: #0d9488 !important; box-shadow: 0 0 0 3px rgba(13,148,136,0.15), 0 4px 12px rgba(13,148,136,0.1) !important; background: #ffffff !important; }
    html.theme-ocean .text-white { color: #0f172a !important; }
    html.theme-ocean .text-gray-300 { color: #334155 !important; }
    html.theme-ocean .text-gray-400 { color: #475569 !important; }
    html.theme-ocean .text-gray-500 { color: #64748b !important; }
    html.theme-ocean .border-gray-700, html.theme-ocean .border-gray-700\/50 { border-color: #ccfbf1 !important; }
    html.theme-ocean .hover\:bg-gray-800:hover { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important; }
    html.theme-ocean .border-gray-500 { border-color: #99f6e4 !important; }
    html.theme-ocean .explanation { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important; border-color: #bfdbfe !important; }
    html.theme-ocean .explanation .text-blue-100 { color: #1e3a8a; }
    html.theme-ocean #startScreen .glass-effect { background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.95)); }
    html.theme-ocean #overlay-content { background: linear-gradient(135deg, #ffffff 0%, #fef2f2 100%); border-color: #fca5a5; }
    html.theme-ocean .bg-gray-700 { background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); color: #334155; }
    html.theme-ocean .hover\:bg-gray-600:hover { background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%); }
    html.theme-ocean .text-emerald-300, html.theme-ocean .text-emerald-400 { color: #059669; }
    html.theme-ocean .text-red-300, html.theme-ocean .text-red-400 { color: #dc2626; }
    html.theme-ocean .bg-emerald-500\/10 { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-color: #a7f3d0; }
    html.theme-ocean .bg-red-500\/10 { background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-color: #fecaca; }

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

    /* Timer urgency */
    @keyframes timerPulse { 0%, 100% { opacity:1; } 50% { opacity:0.5; } }
    .timer-urgent { animation: timerPulse 0.7s ease-in-out infinite !important; color: #ef4444 !important; background-color: rgba(239,68,68,0.15) !important; border-color: rgba(239,68,68,0.3) !important; }
    /* Question slide animations */
    @keyframes slideInRight { from { opacity:0; transform: translateX(28px); } to { opacity:1; transform: translateX(0); } }
    @keyframes slideInLeft { from { opacity:0; transform: translateX(-28px); } to { opacity:1; transform: translateX(0); } }
    .q-slide-right { animation: slideInRight 0.28s cubic-bezier(0.25,0.46,0.45,0.94) forwards; }
    .q-slide-left { animation: slideInLeft 0.28s cubic-bezier(0.25,0.46,0.45,0.94) forwards; }
    /* Progress bar */
    .q-progress-bar { border-radius: 9999px; background: linear-gradient(90deg, #0d9488, #0891b2, #0e7490); transition: width 0.4s cubic-bezier(0.4,0,0.2,1); }
  </style>
</head>
<body class="selection:bg-purple-500 selection:text-white min-h-screen flex flex-col items-center">
  
  <!-- START SCREEN -->
  <div id="startScreen" class="fixed inset-0 z-50 flex flex-col items-center justify-center gradient-bg px-4 text-center" style="display: none;">
    <div class="glass-effect p-8 sm:p-12 rounded-3xl shadow-2xl max-w-lg w-full relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-purple-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/30">
            <i class="fas fa-file-signature text-4xl text-white"></i>
        </div>
        <h1 class="text-3xl font-bold text-white mb-4"><?= $testNameHtml ?></h1>
        <p class="text-gray-300 mb-8">Test će se otvoriti u fullscreen modu radi sprečavanja napuštanja stranice. Sretno!</p>
        <button id="startBtn" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-purple-500/40 flex items-center justify-center gap-3 text-lg">
            <i class="fas fa-play"></i> Započni test
        </button>
    </div>
  </div>

  <!-- WRAPPER -->
  <div class="wrapper w-full max-w-6xl mx-auto hidden flex-1 py-6 sm:py-10 px-4 relative">
    <div class="glass-effect rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl pointer-events-none transform translate-x-1/2 -translate-y-1/2"></div>
        
        <header class="border-b border-gray-700/50 pb-6 mb-8 relative z-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-white text-center mb-6"><?= $testNameHtml ?></h1>
            <div class="flex flex-wrap justify-between items-center gap-4 bg-gray-900/50 p-4 rounded-2xl border border-gray-700/50" id="testHeaderMeta">
                <div class="flex items-center gap-2 text-purple-400 bg-purple-500/10 px-3 py-1.5 rounded-lg border border-purple-500/20 text-sm font-semibold">
                    <i class="fas fa-tasks"></i> Provjera znanja
                </div>
                <div id="progressIndicator" class="text-gray-300 font-medium text-sm hidden"></div>
                <div class="flex items-center gap-3">
                    <button id="themeToggleBtn" type="button" class="theme-pill-btn" title="Promijeni temu" onclick="toggleTheme()">
                        <span class="theme-pill-track">
                            <span class="theme-pill-thumb"></span>
                            <i class="fas fa-moon theme-pill-icon theme-pill-icon-left"></i>
                            <i class="fas fa-sun theme-pill-icon theme-pill-icon-right"></i>
                        </span>
                    </button>
                    <div class="flex items-center gap-2 text-blue-400 bg-blue-500/10 px-4 py-1.5 rounded-lg border border-blue-500/20 font-bold tracking-wider">
                        <i class="fas fa-clock"></i> <span id="timer">00:00</span>
                    </div>
                </div>
            </div>
            <!-- Vizuelni progress bar (one-by-one mod) -->
            <div id="visualProgressContainer" class="hidden mt-2 px-1">
                <div class="w-full bg-gray-700/30 rounded-full h-1 overflow-hidden">
                    <div id="visualProgressBar" class="q-progress-bar h-full" style="width:0%"></div>
                </div>
            </div>
            <div class="mt-4 flex items-start gap-3 text-sm text-yellow-400 bg-yellow-500/10 p-3 rounded-xl border border-yellow-500/20">
                <i class="fas fa-exclamation-triangle mt-0.5"></i>
                <p>Nije dozvoljeno napuštati ovu stranicu. Nakon <strong>dva napuštanja</strong> test se automatski završava.</p>
            </div>
        </header>

        <form id="quizForm" class="relative z-10">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="space-y-2">
              <label for="ime" class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Ime</label>
              <div class="relative">
                  <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500"><i class="fas fa-user"></i></span>
                  <input type="text" id="ime" name="ime" required class="w-full bg-gray-900 text-white pl-11 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" placeholder="Unesite ime">
              </div>
            </div>
            <div class="space-y-2">
              <label for="prezime" class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Prezime</label>
              <div class="relative">
                  <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500"><i class="fas fa-user"></i></span>
                  <input type="text" id="prezime" name="prezime" required class="w-full bg-gray-900 text-white pl-11 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" placeholder="Unesite prezime">
              </div>
            </div>
          </div>

          <div id="questionsContainer" class="space-y-6">
<?= $newQuestionsHtml ?>
          </div>

          <div id="navigationButtons" class="hidden flex-col sm:flex-row justify-between pt-6 border-t border-gray-700 mt-8 gap-4">
            <button type="button" id="prevBtn" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-xl transition-colors text-sm font-bold flex items-center justify-center gap-2 w-full sm:w-auto">
                <i class="fas fa-arrow-left"></i> Prethodno
            </button>
            <button type="submit" id="submitBtn" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white px-8 py-3 rounded-xl transition-all shadow-lg hover:shadow-emerald-500/30 text-sm font-bold flex items-center justify-center gap-2 w-full sm:w-auto mx-auto">
                <i class="fas fa-paper-plane"></i> Predaj test
            </button>
            <button type="button" id="nextBtn" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl transition-colors text-sm font-bold flex items-center justify-center gap-2 w-full sm:w-auto">
                Sledeće <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </form>

        <div id="result" class="mt-8 p-6 rounded-2xl hidden whitespace-pre-wrap font-medium border"></div>
    </div>
    
    <!-- Polje za reset -->
    <div class="mt-8 text-center bg-gray-900/50 p-4 rounded-2xl border border-gray-800 flex items-center justify-center gap-3">
        <i class="fas fa-lock text-gray-500"></i>
        <input type="password" id="unlock" name="unlock" placeholder="Lozinka za reset" class="bg-gray-800 text-white px-3 py-1.5 rounded-lg border border-gray-700 focus:border-purple-500 outline-none text-sm w-48">
        <button id="unlockBtn" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-1.5 rounded-lg text-sm transition-colors border border-gray-600">Resetuj</button>
    </div>
  </div>

  <!-- Overlay -->
  <div id="overlay" class="fixed inset-0 bg-black/90 backdrop-blur-md hidden items-center justify-center z-[9999] px-4">
    <div id="overlay-content" class="bg-gray-800 border border-red-500/50 p-8 rounded-3xl max-w-md w-full text-center shadow-[0_0_50px_rgba(239,68,68,0.2)]">
      <div class="w-20 h-20 mx-auto bg-red-500/20 rounded-full flex items-center justify-center mb-6 border border-red-500/50 text-red-500">
        <i class="fas fa-exclamation-triangle text-4xl"></i>
      </div>
      <h2 id="overlay-title" class="text-2xl font-bold text-white mb-3">Upozorenje</h2>
      <p id="overlay-message" class="text-gray-300 mb-8">Napustili ste stranicu. Molimo vas da ostanete na testu.</p>
      <button id="overlay-btn" class="w-full bg-red-600 hover:bg-red-500 text-white font-bold py-3.5 rounded-xl transition-colors shadow-lg">Nastavi</button>
    </div>
  </div>

  <!-- Alert Modal -->
  <div id="alertModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-[99999] px-4" style="display:none">
    <div class="bg-gray-800 border border-gray-700 p-8 rounded-3xl max-w-sm w-full text-center shadow-2xl">
      <div class="w-14 h-14 mx-auto bg-yellow-500/20 rounded-full flex items-center justify-center mb-5 border border-yellow-500/30">
        <i class="fas fa-info-circle text-yellow-400 text-2xl"></i>
      </div>
      <p id="alertModalMsg" class="text-gray-200 text-base mb-6 leading-relaxed"></p>
      <button id="alertModalBtn" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-bold py-3 rounded-xl transition-colors shadow-lg">U redu</button>
    </div>
  </div>

<script>
    const test_name = "<?= $testNameSafe ?>";
    const test_id_key = "<?= $uniqueTestNameSafe ?>";
    const test_id = <?= $testIdJs ?>;
    const is_db_test = <?= $isDbTestJs ?>;
    const questions = <?= $questionsJson ?>;
    
    // Učitavanje teme (Svijetla / Tamna)
    const savedTheme = localStorage.getItem('test_theme') || 'dark';
    if (savedTheme === 'light') document.body.classList.add('light-mode');
    // Brojač napuštanja taba/prozora
    let leaveCount = 0;
    let testFinished = false;

    const timerEl = document.getElementById("timer");
    const resultEl = document.getElementById("result");
    const form = document.getElementById("quizForm");
    const submitBtn = document.getElementById("submitBtn");

    const overlay = document.getElementById("overlay");
    const overlayTitle = document.getElementById("overlay-title");
    const overlayMessage = document.getElementById("overlay-message");
    const overlayBtn = document.getElementById("overlay-btn");

    function checkNameSurname() {
        if (testFinished) return;
        const imeInput = document.getElementById('ime');
        const prezimeInput = document.getElementById('prezime');
        if (!imeInput || !prezimeInput) return;

        const ime = imeInput.value.trim();
        const prezime = prezimeInput.value.trim();
        const isValid = ime.length > 0 && prezime.length > 0;
        
        const questionInputs = form.querySelectorAll('textarea[name^="q"], input[type="radio"][name^="q"], input[type="checkbox"][name^="q"]');
        questionInputs.forEach(input => {
            input.disabled = !isValid;
            if(!isValid) {
                input.setAttribute('title', 'Unesite ime i prezime da biste odgovorili');
                if(input.type === 'radio' || input.type === 'checkbox') input.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                input.removeAttribute('title');
                if(input.type === 'radio' || input.type === 'checkbox') input.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });
    }

    let seconds = <?= $newSeconds ?>; 
    const isOneByOne = <?= $oneByOneJs ?>;
    const hideResults = <?= $hideResultsJs ?>;

    setInterval(() => {
      if (testFinished) return;
      seconds--;
      localStorage.setItem('test_seconds_' + test_id_key, seconds);
      if (seconds <= 0) {
        seconds = 0;
        (async () => { await finishTest('timer'); })();
        return;
      }
      const m = String(Math.floor(seconds / 60)).padStart(2, "0");
      const s = String(seconds % 60).padStart(2, "0");
      if(timerEl) timerEl.textContent = `${m}:${s}`;
      // Urgency: crveni tajmer kada ostane < 60 sekundi
      const timerWrapper = timerEl ? timerEl.closest('div') : null;
      if (timerWrapper) timerWrapper.classList.toggle('timer-urgent', seconds <= 60);
    }, 1000);

    window.addEventListener('load', function() {
      const urlParams = new URLSearchParams(window.location.search);
      const isPreview = urlParams.has('preview');

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

      const startScreen = document.getElementById('startScreen');
      if(startScreen) { startScreen.style.display = 'flex'; startScreen.classList.remove('hidden'); }
      
        const savedIme = localStorage.getItem('ime_' + test_id_key);
        if (savedIme && form && form.querySelector('input[name="ime"]')) form.querySelector('input[name="ime"]').value = savedIme;
        const savedPrezime = localStorage.getItem('prezime_' + test_id_key);
        if (savedPrezime && form && form.querySelector('input[name="prezime"]')) form.querySelector('input[name="prezime"]').value = savedPrezime;
        
        let hasAnswers = false;
        if(form) {
            const inputs = form.querySelectorAll('textarea[name^="q"], input[type="radio"][name^="q"], input[type="checkbox"][name^="q"]');
            inputs.forEach(input => {
                if(input.type === 'radio') {
                    const saved = localStorage.getItem(test_id_key + '_' + input.name);
                    if(saved === input.value) {
                        input.checked = true;
                        hasAnswers = true;
                    }
                } else if (input.type === 'checkbox') {
                    const saved = localStorage.getItem(test_id_key + '_' + input.name.replace('[]', ''));
                    if(saved) {
                        try {
                            const vals = JSON.parse(saved);
                            if (Array.isArray(vals) && vals.includes(input.value)) {
                                input.checked = true;
                                hasAnswers = true;
                            }
                        } catch(e) {}
                    }
                } else {
                    const saved = localStorage.getItem(test_id_key + '_' + input.name);
                    if(saved) {
                        input.value = saved;
                        hasAnswers = true;
                    }
                }
            });
        }
        
        if (isOneByOne && form) {
            const fieldsets = form.querySelectorAll('fieldset');
            const navBtns = document.getElementById('navigationButtons');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');
            const progressIndicator = document.getElementById('progressIndicator');
            
            if (fieldsets.length > 0) {
                if (progressIndicator) progressIndicator.style.display = 'block';
                let currentIndex = 0;
                let slideDir = 1;
                navBtns.style.display = 'flex';
                submitBtn.style.display = 'none';
                
                function updateVisibility() {
                    fieldsets.forEach((fs, i) => {
                        if (i === currentIndex) {
                            fs.style.display = 'block';
                            fs.classList.remove('q-slide-right', 'q-slide-left');
                            void fs.offsetWidth;
                            fs.classList.add(slideDir >= 0 ? 'q-slide-right' : 'q-slide-left');
                        } else { fs.style.display = 'none'; }
                    });
                    prevBtn.style.visibility = (currentIndex === 0) ? 'hidden' : 'visible';
                    if (progressIndicator) progressIndicator.textContent = `Pitanje ${currentIndex + 1} od ${fieldsets.length}`;
                    const vpc = document.getElementById('visualProgressContainer');
                    const vpb = document.getElementById('visualProgressBar');
                    if (vpc && vpb) {
                        vpc.classList.remove('hidden');
                        vpb.style.width = ((currentIndex + 1) / fieldsets.length * 100) + '%';
                    }
                    if (currentIndex === fieldsets.length - 1) {
                        nextBtn.style.display = 'none';
                        submitBtn.style.display = 'inline-block';
                    } else {
                        nextBtn.style.display = 'inline-block';
                        submitBtn.style.display = 'none';
                    }
                    if(document.querySelector('.wrapper')) document.querySelector('.wrapper').scrollIntoView({ behavior: 'smooth' });
                }
                
                prevBtn.addEventListener('click', () => { if(currentIndex > 0) { slideDir = -1; currentIndex--; updateVisibility(); } });
                nextBtn.addEventListener('click', () => { if(currentIndex < fieldsets.length - 1) { slideDir = 1; currentIndex++; updateVisibility(); } });
                updateVisibility();
            }
        } else if (form) {
            const navBtns = document.getElementById('navigationButtons');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');
            if (navBtns) {
                navBtns.style.display = 'flex';
                if(prevBtn) prevBtn.style.display = 'none';
                if(nextBtn) nextBtn.style.display = 'none';
                if(submitBtn) submitBtn.style.display = 'inline-block';
            }
            // Bojač odgovorenih pitanja (normalni mod)
            const allFs = form.querySelectorAll('fieldset:not(.explanation)');
            if (allFs.length > 0) {
                const hm = document.getElementById('testHeaderMeta');
                if (hm) {
                    const cnt = document.createElement('div');
                    cnt.id = 'answeredCounter';
                    cnt.className = 'flex items-center gap-2 text-gray-300 bg-gray-800 px-3 py-1.5 rounded-lg border border-gray-700 text-sm font-semibold';
                    cnt.innerHTML = `<i class="fas fa-check-circle text-emerald-400"></i> <span id="answeredCount">0</span><span class="text-gray-500">/${allFs.length}</span>`;
                    hm.appendChild(cnt);
                }
                function updateAnswered() {
                    let n = 0;
                    allFs.forEach(fs => {
                        const r = fs.querySelector('input[type="radio"]:checked');
                        const c = fs.querySelector('input[type="checkbox"]:checked');
                        const t = fs.querySelector('textarea[name^="q"]');
                        if (r || c || (t && t.value.trim())) n++;
                    });
                    const el = document.getElementById('answeredCount');
                    if (el) { el.textContent = n; el.style.color = n === allFs.length ? '#34d399' : ''; }
                }
                form.addEventListener('input', updateAnswered);
                updateAnswered();
            }
        }
        
        const savedSeconds = localStorage.getItem('test_seconds_' + test_id_key);
        if (savedSeconds) seconds = parseInt(savedSeconds);

        if(form) {
            checkNameSurname();
            if(hasAnswers) {
                const imeInput = document.getElementById('ime');
                const prezimeInput = document.getElementById('prezime');
                if(imeInput) { imeInput.readOnly = true; imeInput.style.backgroundColor = '#e5e7eb'; imeInput.style.color = '#6b7280'; }
                if(prezimeInput) { prezimeInput.readOnly = true; prezimeInput.style.backgroundColor = '#e5e7eb'; prezimeInput.style.color = '#6b7280'; }
            }
        }
    });

    if(form) {
        form.addEventListener('input', function(e) {
        if (testFinished) return;
        const target = e.target;
        if (target.name === 'ime') {
            localStorage.setItem('ime_' + test_id_key, target.value);
            checkNameSurname();
        }
        else if (target.name === 'prezime') {
            localStorage.setItem('prezime_' + test_id_key, target.value);
            checkNameSurname();
        }
        else if (target.name.startsWith('q')) {
            if (target.type === 'checkbox') {
                const baseName = target.name.replace('[]', '');
                const checkboxes = form.querySelectorAll(`input[name="${target.name}"]:checked`);
                const vals = Array.from(checkboxes).map(cb => cb.value);
                localStorage.setItem(test_id_key + '_' + baseName, JSON.stringify(vals));
            } else {
                localStorage.setItem(test_id_key + '_' + target.name, target.value);
            }
            
            const imeInput = document.getElementById('ime');
            const prezimeInput = document.getElementById('prezime');
            if(imeInput && !imeInput.readOnly) { imeInput.readOnly = true; imeInput.style.backgroundColor = '#e5e7eb'; imeInput.style.color = '#6b7280'; }
            if(prezimeInput && !prezimeInput.readOnly) { prezimeInput.readOnly = true; prezimeInput.style.backgroundColor = '#e5e7eb'; prezimeInput.style.color = '#6b7280'; }
        }
        });

        form.addEventListener("submit", async function (e) {
        e.preventDefault();
        if (testFinished) return;
        await finishTest(false);
        });
    }

    window.addEventListener('beforeunload', function(e) {
      if (!testFinished) {
        e.preventDefault();
        e.returnValue = 'Da li ste sigurni da želite napustiti stranicu? Vaši odgovori će biti sačuvani.';
      }
    });

    function handleLeave() {
      if (testFinished) return;
      leaveCount++;
      if (leaveCount === 1) {
        if(overlayTitle) overlayTitle.textContent = "Upozorenje!";
        if(overlayMessage) overlayMessage.textContent =
          "Napustili ste ovu stranicu. Ako se to ponovi još jednom, test će biti automatski završen.";
        if(overlayBtn) overlayBtn.textContent = "Vrati me na test";
        if(overlayBtn) overlayBtn.onclick = () => {
          if(overlay) overlay.style.display = "none";
        };
        if(overlay) overlay.style.display = "flex";
      } else if (leaveCount >= 2) {
        (async () => { await finishTest('leave'); })();
      }
    }

    document.addEventListener("visibilitychange", () => {
      if (document.hidden) {
        handleLeave();
      }
    });

    document.addEventListener('fullscreenchange', () => {
      if (!document.fullscreenElement && !testFinished) {
        if(overlayTitle) overlayTitle.textContent = "Pažnja!";
        if(overlayMessage) overlayMessage.textContent = "Test se mora raditi u fullscreen modu. Kliknite na dugme ispod za povratak.";
        if(overlayBtn) overlayBtn.textContent = "Vrati se u fullscreen";
        if(overlayBtn) overlayBtn.onclick = () => {
            document.documentElement.requestFullscreen().then(() => {
                if(overlay) overlay.style.display = "none";
            }).catch(err => showAlertModal("Ne mogu aktivirati fullscreen. Pritisnite F11 i pokušajte ponovo."));
        };
        if(overlay) overlay.style.display = "flex";
      }
    });

    window.addEventListener("blur", () => {
      handleLeave();
    });

    const startBtn = document.getElementById('startBtn');
    if(startBtn) {
        startBtn.addEventListener('click', function() {
        document.documentElement.requestFullscreen().then(() => {
            document.getElementById('startScreen').style.display = 'none';
            document.querySelector('.wrapper').classList.remove('hidden');
        }).catch(err => {
            showAlertModal('Fullscreen mod je potreban za test. Dozvolite ga i pokušajte ponovo.');
            console.log('Fullscreen error:', err);
        });
        });
    }

    const unlockBtn = document.getElementById('unlockBtn');
    if(unlockBtn) {
        unlockBtn.addEventListener('click', async function() {
        const password = document.getElementById('unlock').value;
        let hashedPassword = "";
        try { hashedPassword = await hashString(password); } catch(e) {}
        if (hashedPassword === 'efee614420c57ddd2a8e91eeef6f6b83d5356c2288155be0f273bef986e3b850' || hashedPassword === 'fallback_match') {
            Object.keys(localStorage).forEach(key => {
                if(key.includes(test_id_key)) {
                    localStorage.removeItem(key);
                }
            });
            location.reload();
        } else {
            showAlertModal('Pogrešna lozinka za reset.');
        }
        });
    }

    // Alert modal funkcija
    function showAlertModal(message, onClose) {
        const modal = document.getElementById('alertModal');
        if (!modal) { alert(message); if(onClose) onClose(); return; }
        document.getElementById('alertModalMsg').textContent = message;
        modal.style.display = 'flex';
        document.getElementById('alertModalBtn').onclick = function() {
            modal.style.display = 'none';
            if (onClose) onClose();
        };
    }

    async function hashString(str) {
      if (window.crypto && window.crypto.subtle) {
          try {
              const encoder = new TextEncoder();
              const data = encoder.encode(str);
              const hashBuffer = await crypto.subtle.digest('SHA-256', data);
              const hashArray = Array.from(new Uint8Array(hashBuffer));
              return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
          } catch(e) {}
      }
      if (str === 'reset' || str === 'reset123' || str === 'skola123') return 'fallback_match';
      return str;
    }

    async function hashName(name, surname) {
      const fullName = name + ' ' + surname;
      if (window.crypto && window.crypto.subtle) {
          try {
              const encoder = new TextEncoder();
              const data = encoder.encode(fullName);
              const hashBuffer = await crypto.subtle.digest('SHA-256', data);
              const hashArray = Array.from(new Uint8Array(hashBuffer));
              return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
          } catch(e) {}
      }
      let hash = 5381;
      for (let i = 0; i < fullName.length; i++) hash = ((hash << 5) + hash) + fullName.charCodeAt(i);
      return (hash >>> 0).toString(16);
    }

    async function finishTest(endReason) {
      testFinished = true;

      const inputs = form.querySelectorAll("input, textarea, button");
      inputs.forEach((el) => (el.disabled = true));

      const ime = form.querySelector('input[name="ime"]').value;
      const prezime = form.querySelector('input[name="prezime"]').value;
      const hash = await hashName(ime, prezime);

      let answers = {};
      let submitAnswers = {};
      let dbAnswers = [];
      let score = 0;
      let maxScore = 0;
      let questionIndex = 0;
      let realQuestionNum = 1;

      const fieldsets = form.querySelectorAll('fieldset');
      fieldsets.forEach((fs, idx) => {
          if (fs.classList.contains('explanation')) {
              questionIndex++;
              return;
          }

          const qNum = realQuestionNum++;
          
          const qData = questions[questionIndex];
          if (!qData) {
              questionIndex++;
              return;
          }
          
          let val;
          if (qData.type === 'multiple_select') {
              const checkboxes = fs.querySelectorAll('input[type="checkbox"]:checked');
              val = Array.from(checkboxes).map(cb => cb.value);
              if (val.length === 0) val = "(Nema odgovora)";
          } else {
              const text = fs.querySelector('textarea[name^="q"]');
              const radio = fs.querySelector('input[type="radio"]:checked');
              val = "(Nema odgovora)";
              if(text) val = text.value;
              else if(radio) val = radio.value;
          }
          
          let displayVal = Array.isArray(val) ? val.join(', ') : val;
          answers[`Pitanje ${qNum}`] = displayVal;
          
          let isCorrect = null;
          let pts = qData.points !== undefined ? parseFloat(qData.points) : 1;
          let earnedPts = 0;
          let hasAnswer = qData.answer && qData.answer.trim() !== '' && qData.answer !== '[]';

          if (qData && (qData.type === 'multiple_choice' || qData.type === 'multiple_select') && hasAnswer) {
              maxScore += pts;
              
              if (qData.type === 'multiple_select') {
                  let correctAnsArr = [];
                  try { correctAnsArr = JSON.parse(qData.answer); } catch(e) { correctAnsArr = [qData.answer]; }
                  
                  let totalCorrect = correctAnsArr.length;
                  if (totalCorrect === 0) totalCorrect = 1;
                  
                  if (Array.isArray(val) && val.length > 0 && val[0] !== "(Nema odgovora)") {
                      let correctSelected = 0;
                      let wrongSelected = 0;
                      
                      val.forEach(v => {
                          if (correctAnsArr.includes(v)) correctSelected++;
                          else wrongSelected++;
                      });
                      
                      let rawScore = ((correctSelected - wrongSelected) / totalCorrect) * pts;
                      earnedPts = Math.max(0, rawScore);
                      score += earnedPts;
                      
                      if (earnedPts === pts) {
                          isCorrect = true;
                      } else if (earnedPts > 0) {
                          isCorrect = "partial";
                      } else {
                          isCorrect = false;
                      }
                  } else {
                      isCorrect = false;
                  }
              } else {
                  if (val === qData.answer) {
                      earnedPts = pts;
                      score += pts;
                      isCorrect = true;
                  } else {
                      isCorrect = false;
                  }
              }
          }

          let submitVal = displayVal;
          if (isCorrect === true) {
              submitVal += " [✔️ TAČNO]";
              if (!hideResults) {
                  fs.style.borderColor = '#10b981';
                  fs.style.backgroundColor = 'rgba(16, 185, 129, 0.05)';
                  const resDiv = document.createElement('div');
                  resDiv.className = 'mt-4 text-emerald-400 font-bold bg-emerald-500/10 p-3 rounded-xl border border-emerald-500/20 flex items-center gap-2';
                  resDiv.innerHTML = "<i class='fas fa-check-circle'></i> Tačan odgovor!";
                  fs.appendChild(resDiv);
              }
          } else if (isCorrect === "partial") {
              let displayEarned = Number.isInteger(earnedPts) ? earnedPts : earnedPts.toFixed(2);
              submitVal += ` [⚠️ DJELIMIČNO TAČNO - ${displayEarned}/${pts} bodova]`;
              if (!hideResults) {
                  fs.style.borderColor = '#f59e0b';
                  fs.style.backgroundColor = 'rgba(245, 158, 11, 0.05)';
                  const resDiv = document.createElement('div');
                  resDiv.className = 'mt-4 text-yellow-400 font-bold bg-yellow-500/10 p-3 rounded-xl border border-yellow-500/20 flex items-center gap-2';
                  let correctStr = (function(){ try { return JSON.parse(qData.answer).join(', '); } catch(e){ return qData.answer; } })();
                  resDiv.innerHTML = `<i class='fas fa-exclamation-triangle'></i> Djelimično tačno! Osvojeno ${displayEarned} od ${pts} bodova. (Potpuno tačno: ${correctStr})`;
                  fs.appendChild(resDiv);
              }
          } else if (isCorrect === false) {
              let correctStr = qData.type === 'multiple_select' ? (function(){ try { return JSON.parse(qData.answer).join(', '); } catch(e){ return qData.answer; } })() : qData.answer;
              submitVal += ` [❌ NETAČNO - Tačan odgovor: ${correctStr}]`;
              if (!hideResults) {
                  fs.style.borderColor = '#ef4444';
                  fs.style.backgroundColor = 'rgba(239, 68, 68, 0.05)';
                  const resDiv = document.createElement('div');
                  resDiv.className = 'mt-4 text-red-400 font-bold bg-red-500/10 p-3 rounded-xl border border-red-500/20 flex items-center gap-2';
                  resDiv.innerHTML = `<i class='fas fa-times-circle'></i> Netačno. Tačan odgovor je: ${correctStr}`;
                  fs.appendChild(resDiv);
              }
          }
          
          dbAnswers.push({
              numb: qNum,
              answer: Array.isArray(val) ? JSON.stringify(val) : val,
              isCorrect: isCorrect === true || isCorrect === "partial",
              points: pts,
              earnedPoints: earnedPts
          });
          
          submitAnswers[`Pitanje ${qNum}`] = submitVal;
          questionIndex++;
      });

      if(resultEl) {
          resultEl.classList.remove("hidden");
      }

      let resultText = `Ime: ${ime}\nPrezime: ${prezime}\nHash imena i prezimena: ${hash}\n\n`;
      
      if (!hideResults) {
          if (maxScore > 0) {
              const percentage = Math.round((score / maxScore) * 100);
              const displayScore = Number.isInteger(score) ? score : score.toFixed(1);
              const displayMax = Number.isInteger(maxScore) ? maxScore : maxScore.toFixed(1);
              resultText += `=== REZULTAT KVIZA: ${displayScore} od ${displayMax} bodova (${percentage}%) ===\n\n`;
          }
          
          resultText += `Vaši odgovori:\n\n`;
          for (const [question, answer] of Object.entries(submitAnswers)) {
            resultText += `${question}: ${answer}\n\n`;
          }
      } else {
          resultText += `Odgovori su zabilježeni.\n\n`;
      }

      if (endReason === 'timer') {
        if(resultEl) resultEl.className = "mt-8 p-6 rounded-2xl block whitespace-pre-wrap font-medium border bg-orange-500/10 border-orange-500/30 text-orange-300";
        resultText += "Vrijeme testa je isteklo. Test je automatski predan.";
      } else if (endReason === 'leave') {
        if(resultEl) resultEl.className = "mt-8 p-6 rounded-2xl block whitespace-pre-wrap font-medium border bg-red-500/10 border-red-500/30 text-red-300";
        resultText += "Test je automatski završen jer je stranica napuštena dva puta.";
      } else {
        if(resultEl) resultEl.className = "mt-8 p-6 rounded-2xl block whitespace-pre-wrap font-medium border bg-emerald-500/10 border-emerald-500/30 text-emerald-300";
        resultText += "Uspješno si predao/la test.";
      }

      if(resultEl) resultEl.textContent = resultText;

      const resultObj = {
        test_name: "<?= $uniqueTestNameSafe ?>", 
        test_id: test_id,
        is_db_test: is_db_test,
        ime,
        prezime,
        hash,
        answers: is_db_test ? dbAnswers : submitAnswers,
        totalPts: maxScore,
        earnedPts: score,
        endedByLeave: endReason === 'leave' || endReason === 'timer',
        timestamp: new Date().toISOString()
      };

      try {
        const isPhysicalFile = window.location.pathname.includes('/uploads/');
        const fetchUrl = isPhysicalFile ? '../index.php?route=submit_test' : 'index.php?route=submit_test';
        const response = await fetch(fetchUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(resultObj)
        });

        const result = await response.json();

        if (response.ok && result.success) {
          resultText += "\n\nOdgovori su uspješno poslani na server.";
        } else {
          resultText += "\n\nGreška pri slanju odgovora: " + (result.error || "Nepoznata greška");
        }
      } catch (error) {
        resultText += "\n\nGreška pri slanju odgovora na server: " + error.message;
      }

      if(resultEl) resultEl.textContent = resultText;
      
      Object.keys(localStorage).forEach(key => {
          if(key.includes(test_id_key)) localStorage.removeItem(key);
      });

      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.type = 'button';
        submitBtn.innerHTML = '<i class="fas fa-times"></i> Zatvori test';
        submitBtn.className = 'bg-gray-700 hover:bg-gray-600 text-white px-8 py-3 rounded-xl transition-all shadow-lg text-sm font-bold flex items-center justify-center gap-2 w-full sm:w-auto mx-auto mt-4';
        submitBtn.onclick = function(e) {
            e.preventDefault();
            window.close();
            setTimeout(() => { window.location.href = 'index.php'; }, 300);
        };
        submitBtn.style.display = 'flex';
        
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        if (prevBtn) prevBtn.style.display = 'none';
        if (nextBtn) nextBtn.style.display = 'none';
      }

      if (endReason === 'timer') {
        if(overlayTitle) overlayTitle.textContent = "Vrijeme je isteklo!";
        if(overlayMessage) overlayMessage.textContent =
          "Vrijeme testa je isteklo. Test je automatski predan. " +
          "Vaši odgovori su poslani na server.";
        if(overlayBtn) overlayBtn.textContent = "U redu";
        if(overlayBtn) overlayBtn.onclick = () => {
          if(overlay) overlay.style.display = "none";
        };
        if(overlay) overlay.style.display = "flex";
      } else if (endReason === 'leave') {
        if(overlayTitle) overlayTitle.textContent = "Test je završen";
        if(overlayMessage) overlayMessage.textContent =
          "Stranica je napuštena dva puta. Test je automatski završen. " +
          "Vaši odgovori su poslani na server.";
        if(overlayBtn) overlayBtn.textContent = "U redu";
        if(overlayBtn) overlayBtn.onclick = () => {
          if(overlay) overlay.style.display = "none";
        };
        if(overlay) overlay.style.display = "flex";
      }
    }
</script>
</body>
</html>