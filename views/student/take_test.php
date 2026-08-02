<?php
if (!isset($is_generating_static) || !$is_generating_static) {
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
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
  <meta charset="UTF-8" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />
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
    /* Kod u tekstu pitanja */
    .question-text code, .explanation-content code {
        font-family: 'Fira Code', 'Courier New', monospace;
        background: rgba(16, 185, 129, 0.12);
        color: #34d399;
        padding: 0.1em 0.45em;
        border-radius: 5px;
        font-size: 0.88em;
        border: 1px solid rgba(52, 211, 153, 0.25);
    }
    .question-text pre, .explanation-content pre {
        font-family: 'Fira Code', 'Courier New', monospace;
        background: #0f2027;
        color: #a3e635;
        padding: 1rem 1.25rem;
        border-radius: 10px;
        font-size: 0.85em;
        overflow-x: auto;
        border: 1px solid rgba(163, 230, 53, 0.2);
        margin: 0.75rem 0;
        white-space: pre;
        line-height: 1.6;
    }
    .question-text pre code, .explanation-content pre code {
        background: transparent;
        color: inherit;
        padding: 0;
        border: none;
        font-size: inherit;
    }
    html.theme-ocean .question-text code, html.theme-ocean .explanation-content code {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; color: #065f46 !important; border-color: #a7f3d0 !important;
    }
    html.theme-ocean .question-text pre, html.theme-ocean .explanation-content pre {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; color: #166534 !important; border-color: #86efac !important;
    }

    /* === SCROLLBAR U OCEAN TEMI === */
    html.theme-ocean ::-webkit-scrollbar-thumb { background: #cbd5e1; }
    html.theme-ocean ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* === SELECTION U OCEAN TEMI === */
    html.theme-ocean ::selection { background-color: #0d9488; color: #ffffff; }

    /* === THEME TOGGLE BUTTON CSS === */
    html.theme-ocean #themeToggleBtn {
      background: rgba(255, 255, 255, 0.9);
      border: 1px solid rgba(0, 0, 0, 0.1);
      color: #64748b;
    }
    html.theme-ocean #themeToggleBtn:hover {
      background: #ffffff;
      color: #0f172a;
    }
    html:not(.theme-ocean) #themeIconLight, html:not(.theme-ocean) #themeTextLight { display: none; }
    html.theme-ocean #themeIconDark, html.theme-ocean #themeTextDark { display: none; }
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
                    <button id="themeToggleBtn" type="button" class="flex items-center justify-center gap-2 px-3 py-1.5 rounded-lg bg-gray-800 border border-gray-700 text-gray-400 hover:text-white hover:bg-gray-700 transition-colors shadow-sm font-semibold text-sm" title="Promijeni temu" onclick="toggleTheme()">
                        <i class="fas fa-moon" id="themeIconDark"></i><span id="themeTextDark">Tamna tema</span>
                        <i class="fas fa-sun" id="themeIconLight"></i><span id="themeTextLight">Svijetla tema</span>
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
    let testStarted = false;
    let cheatDetectionActive = false;

    // Prisilno osvježavanje ako je stranica učitana iz keša pretraživača (Back/Forward dugme)
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });

    const timerEl = document.getElementById("timer");
    const resultEl = document.getElementById("result");
    const form = document.getElementById("quizForm");
    const submitBtn = document.getElementById("submitBtn");

    const overlay = document.getElementById("overlay");
    const overlayTitle = document.getElementById("overlay-title");
    const overlayMessage = document.getElementById("overlay-message");
    const overlayBtn = document.getElementById("overlay-btn");

    // Funkcija koja onemogućava pitanja dok se ne unesu ime i prezime
    function checkNameSurname() {
        if (testFinished) return;
        const imeInput = document.getElementById('ime');
        const prezimeInput = document.getElementById('prezime');
        if (!imeInput || !prezimeInput) return;

        const ime = imeInput.value.trim();
        const prezime = prezimeInput.value.trim();
        const isValid = ime.length > 0 && prezime.length > 0;
        
        const questionInputs = form.querySelectorAll('textarea[name^="q"], input[type="radio"], input[type="checkbox"]');
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

    // Jednostavan tajmer
    let seconds = <?= $newSeconds ?>; 
    const isOneByOne = <?= $oneByOneJs ?>;
    const hideResults = <?= $hideResultsJs ?>;

    setInterval(() => {
      if (!testStarted || testFinished) return;
      seconds--;
      localStorage.setItem('test_seconds_' + test_id_key, seconds); // Sačuvaj tajmer
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

    // Učitavanje stanja na load
    window.addEventListener('load', function() {
      const urlParams = new URLSearchParams(window.location.search);
      const isPreview = urlParams.has('preview');

      // Inicijalizacija prekidača teme
      window.toggleTheme = function() {
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
      const wrapper = document.querySelector('.wrapper');
      if(startScreen) { startScreen.style.display = 'flex'; startScreen.classList.remove('hidden'); }
      
        const savedIme = localStorage.getItem('ime_' + test_id_key);
        if (savedIme && form && form.querySelector('input[name="ime"]')) form.querySelector('input[name="ime"]').value = savedIme;
        const savedPrezime = localStorage.getItem('prezime_' + test_id_key);
        if (savedPrezime && form && form.querySelector('input[name="prezime"]')) form.querySelector('input[name="prezime"]').value = savedPrezime;
        
        // Dynamic loading of questions
        let hasAnswers = false;
        if(form) {
            const inputs = form.querySelectorAll('textarea[name^="q"], input[type="radio"], input[type="checkbox"]');
            inputs.forEach(input => {
                if(input.type === 'radio') {
                    const saved = localStorage.getItem(test_id_key + '_' + input.name);
                    if(saved === input.value) {
                        input.checked = true;
                        hasAnswers = true;
                    }
                } else if(input.type === 'checkbox') {
                    try {
                        const saved = JSON.parse(localStorage.getItem(test_id_key + '_' + input.name) || '[]');
                        if(saved.includes(input.value)) {
                            input.checked = true;
                            hasAnswers = true;
                        }
                    } catch(e) {}
                } else {
                    const saved = localStorage.getItem(test_id_key + '_' + input.name);
                    if(saved) {
                        input.value = saved;
                        hasAnswers = true;
                    }
                }
            });
        }
        
        // Init One-By-One Logic
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
                        const cb = fs.querySelector('input[type="checkbox"]:checked');
                        const t = fs.querySelector('textarea[name^="q"]');
                        if (r || cb || (t && t.value.trim())) n++;
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

        // Provjeri status polja na učitavanju
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

    // Sačuvavanje odgovora na promjenu
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
                const checkboxes = form.querySelectorAll(`input[name="${target.name}"]:checked`);
                const values = Array.from(checkboxes).map(cb => cb.value);
                localStorage.setItem(test_id_key + '_' + target.name, JSON.stringify(values));
            } else {
                localStorage.setItem(test_id_key + '_' + target.name, target.value);
            }
            const imeInput = document.getElementById('ime');
            const prezimeInput = document.getElementById('prezime');
            if(imeInput && !imeInput.readOnly) { imeInput.readOnly = true; imeInput.style.backgroundColor = '#e5e7eb'; imeInput.style.color = '#6b7280'; }
            if(prezimeInput && !prezimeInput.readOnly) { prezimeInput.readOnly = true; prezimeInput.style.backgroundColor = '#e5e7eb'; prezimeInput.style.color = '#6b7280'; }
        }
        });

        // Obrada predaje testa
        form.addEventListener("submit", async function (e) {
        e.preventDefault();
        if (testFinished) return;
        await finishTest(false);
        });
    }

    // Sprečavanje refresha
    window.addEventListener('beforeunload', function(e) {
      if (cheatDetectionActive && !testFinished) {
        e.preventDefault();
        e.returnValue = 'Da li ste sigurni da želite napustiti stranicu? Vaši odgovori će biti sačuvani.';
      }
    });

    // Obrada napuštanja taba/prozora
    function handleLeave() {
      if (testFinished) return;

      leaveCount++;

      // Prvo napuštanje -> upozorenje
      if (leaveCount === 1) {
        if(overlayTitle) overlayTitle.textContent = "Upozorenje!";
        if(overlayMessage) overlayMessage.textContent =
          "Napustili ste ovu stranicu. Ako se to ponovi još jednom, test će biti automatski završen.";
        if(overlayBtn) overlayBtn.textContent = "Vrati me na test";

        if(overlayBtn) overlayBtn.onclick = () => {
          if(overlay) overlay.style.display = "none";
        };

        if(overlay) overlay.style.display = "flex";
      }
      // Drugo napuštanje -> automatski završetak testa
      else if (leaveCount >= 2) {
        (async () => { await finishTest('leave'); })();
      }
    }

    // Detekcija promjene vidljivosti taba
    document.addEventListener("visibilitychange", () => {
      if (document.hidden && cheatDetectionActive) {
        handleLeave();
      }
    });

    // Detekcija izlaska iz fullscreen
    document.addEventListener('fullscreenchange', () => {
      if (!document.fullscreenElement && cheatDetectionActive && !testFinished) {
        // Blokiraj interakciju i forsiraj povratak u fullscreen
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

    // Dodatno: gubitak fokusa prozora
    window.addEventListener("blur", () => {
      if (cheatDetectionActive) {
        handleLeave();
      }
    });

    // Start dugme
    const startBtn = document.getElementById('startBtn');
    if(startBtn) {
        startBtn.addEventListener('click', function() {
        document.documentElement.requestFullscreen().then(() => {
            document.getElementById('startScreen').style.display = 'none';
            document.querySelector('.wrapper').classList.remove('hidden');
            testStarted = true;
            
            // Aktivacija detekcije sa zadrškom od 1.5s 
            // Spriječava lažne 'blur' evente koje pretraživač stvara ulaskom u Fullscreen
            setTimeout(() => {
                cheatDetectionActive = true;
            }, 1500);
        }).catch(err => {
            showAlertModal('Fullscreen mod je potreban za test. Dozvolite ga i pokušajte ponovo.');
            console.log('Fullscreen error:', err);
        });
        });
    }

    // Reset dugme
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

    // Funkcija za hashiranje stringa
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

    // Funkcija za hashiranje imena i prezimena
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

    // Funkcija koja prikuplja odgovore i završava test
    async function finishTest(endReason) {
      testFinished = true;

      // Onemogući sve inpute i dugme
      const inputs = form.querySelectorAll("input, textarea, button");
      inputs.forEach((el) => (el.disabled = true));

      // Prikupljanje imena i prezimena
      const ime = form.querySelector('input[name="ime"]').value;
      const prezime = form.querySelector('input[name="prezime"]').value;
      const hash = await hashName(ime, prezime);

      // Prikupljanje odgovora
      let answers = {};
      let submitAnswers = {};
      let dbAnswers = [];
      let score = 0;
      let maxScore = 0;
      let questionIndex = 0;
      let realQuestionNum = 1;
      let hasEssay = false;

      const fieldsets = form.querySelectorAll('fieldset');
      fieldsets.forEach((fs, idx) => {
          // Skip explanations
          if (fs.classList.contains('explanation')) {
              questionIndex++;
              return;
          }

          const qNum = realQuestionNum++;
          const text = fs.querySelector('textarea[name^="q"]');
          const radio = fs.querySelector('input[type="radio"]:checked');
          const checkboxes = fs.querySelectorAll('input[type="checkbox"]:checked');
          let val = "(Nema odgovora)";
          if(text) val = text.value;
          else if(checkboxes.length > 0) {
              val = Array.from(checkboxes).map(cb => cb.value).join(', ');
          }
          else if(radio) val = radio.value;
          
          answers[`Pitanje ${qNum}`] = val;
          
          const qData = questions[questionIndex];
          if (!qData) {
              questionIndex++;
              return;
          }
          
          let isCorrect = null;
          let pts = qData.points !== undefined ? parseFloat(qData.points) : 1;
          
          // Dekodiranje HTML entiteta kako bi se spriječilo nepoklapanje (npr. &quot; vs ")
          const decodeHTMLEntities = (text) => {
              const textArea = document.createElement('textarea');
              textArea.innerHTML = text;
              return textArea.value;
          };
          
          const rawCorrectAns = qData.answer !== undefined ? qData.answer : (qData.correct_answer || '');
          const correctAnsRaw = decodeHTMLEntities(String(rawCorrectAns)).trim();
          const studentAns = decodeHTMLEntities(String(val)).trim();

          // Helper: parsira JSON niz ili comma-separated u stvarni JavaScript niz
          function parseAnswerArr(str) {
              str = str.trim();
              // Pokušaj JSON.parse ako počinje s '['
              if (str.startsWith('[')) {
                  try {
                      const parsed = JSON.parse(str);
                      if (Array.isArray(parsed)) return parsed.map(s => String(s).trim()).filter(s => s);
                  } catch(e) {}
              }
              // Fallback: comma-separated
              return str.split(',').map(s => s.trim()).filter(s => s);
          }

          // ── BODOVANJE ─────────────────────────────────────────────────────────
          let earnedPtsForQ = 0;  // bodovi koje je učenik zaslužio za ovo pitanje
          let isPartial = false;  // djelimično tačan (samo za multiple_select)

          maxScore += pts;
          if (qData.type === 'essay') hasEssay = true;

          if (qData && (qData.type === 'multiple_choice' || qData.type === 'multiple_select') && correctAnsRaw !== '') {
              if (qData.type === 'multiple_select') {
                  const correctArr = parseAnswerArr(correctAnsRaw);
                  const studentArr = studentAns.split(',').map(s => s.trim()).filter(s => s);
                  const totalCorrect = correctArr.length;

                  // Koliko je učenik tačno označio (presjek)
                  const numCorrectSelected = studentArr.filter(a => correctArr.includes(a)).length;
                  // Koliko je učenik pogrešno označio (nije u tačnom nizu)
                  const numWrongSelected   = studentArr.filter(a => !correctArr.includes(a)).length;

                  // Neto tačnih (penalizacija za pogrešne)
                  const netCorrect = Math.max(0, numCorrectSelected - numWrongSelected);
                  const ratio = totalCorrect > 0 ? netCorrect / totalCorrect : 0;

                  if (ratio >= 1) {
                      // Sve tačno, bez pogrešnih
                      isCorrect = true;
                      earnedPtsForQ = pts;
                  } else if (ratio >= 0.5) {
                      // Pola ili više tačnih (neto) → pola bodova
                      isCorrect = false;
                      isPartial = true;
                      earnedPtsForQ = parseFloat((pts / 2).toFixed(2));
                  } else if (ratio >= 1 / 3) {
                      // Trećina ili više tačnih (neto) → trećina bodova
                      isCorrect = false;
                      isPartial = true;
                      earnedPtsForQ = parseFloat((pts / 3).toFixed(2));
                  } else {
                      isCorrect = false;
                      earnedPtsForQ = 0;
                  }
                  score += earnedPtsForQ;

              } else {
                  // multiple_choice: jednostavno poređenje
                  const correctAnsStr = decodeHTMLEntities(correctAnsRaw).trim();
                  isCorrect = studentAns === correctAnsStr;
                  earnedPtsForQ = isCorrect ? pts : 0;
                  score += earnedPtsForQ;
              }
          }

          // ── PRIKAZ TAČNOG ODGOVORA ────────────────────────────────────────────
          let correctAnsDisplay;
          if (qData && qData.type === 'multiple_select') {
              correctAnsDisplay = parseAnswerArr(correctAnsRaw).join(', ');
          } else {
              correctAnsDisplay = correctAnsRaw;
          }

          // ── FEEDBACK UI i SUBMIT TEKST ────────────────────────────────────────
          let submitVal = val;
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
          } else if (isPartial) {
              // Djelimičan odgovor — žuto
              const ptsLabel = Number.isInteger(earnedPtsForQ) ? earnedPtsForQ : earnedPtsForQ.toFixed(2);
              submitVal += ` [⚠️ DJELIMIČNO (${ptsLabel}/${pts} bod.) - Tačan odgovor: ${correctAnsDisplay}]`;
              if (!hideResults) {
                  fs.style.borderColor = '#f59e0b';
                  fs.style.backgroundColor = 'rgba(245, 158, 11, 0.05)';
                  const resDiv = document.createElement('div');
                  resDiv.className = 'mt-4 text-yellow-400 font-bold bg-yellow-500/10 p-3 rounded-xl border border-yellow-500/20 flex items-center gap-2 flex-wrap';
                  resDiv.innerHTML = `<i class='fas fa-adjust'></i> Djelimično tačno (${ptsLabel} od ${pts} bod.). Tačan odgovor: <span class="answer-text font-semibold ml-1"></span>`;
                  resDiv.querySelector('.answer-text').textContent = correctAnsDisplay;
                  fs.appendChild(resDiv);
              }
          } else if (isCorrect === false) {
              submitVal += ` [❌ NETAČNO - Tačan odgovor: ${correctAnsDisplay}]`;
              if (!hideResults) {
                  fs.style.borderColor = '#ef4444';
                  fs.style.backgroundColor = 'rgba(239, 68, 68, 0.05)';
                  const resDiv = document.createElement('div');
                  resDiv.className = 'mt-4 text-red-400 font-bold bg-red-500/10 p-3 rounded-xl border border-red-500/20 flex items-center gap-2 flex-wrap';
                  resDiv.innerHTML = `<i class='fas fa-times-circle'></i> Netačno. Tačan odgovor je: <span class="answer-text font-semibold ml-1"></span>`;
                  resDiv.querySelector('.answer-text').textContent = correctAnsDisplay;
                  fs.appendChild(resDiv);
              }
          }

          dbAnswers.push({
              numb: qNum,
              answer: val,
              isCorrect: isCorrect === true,
              earnedPoints: earnedPtsForQ,  // backend koristi ovo za pohranivanje
              points: pts
          });
          
          submitAnswers[`Pitanje ${qNum}`] = submitVal;
          questionIndex++;
      });

      // Prikaz rezultata
      if(resultEl) {
          resultEl.classList.remove("hidden");
      }

      let resultText = `Ime: ${ime}\nPrezime: ${prezime}\n\n`;
      
      if (!hideResults) {
          if (maxScore > 0) {
              const percentage = Math.round((score / maxScore) * 100);
              const displayScore = Number.isInteger(score) ? score : score.toFixed(1);
              const displayMax = Number.isInteger(maxScore) ? maxScore : maxScore.toFixed(1);
              resultText += `=== REZULTAT KVIZA: ${displayScore} od ${displayMax} bodova (${percentage}%) ===\n`;
              if (hasEssay) {
                  resultText += `* Napomena: Esejska pitanja će naknadno ocijeniti nastavnik, pa vaš konačni rezultat može biti veći.\n`;
              }
              resultText += `\n`;
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

      // Priprema JSON za slanje na server
      const resultObj = {
        test_name: "<?= $uniqueTestNameSafe ?>", // Naziv testa mora odgovarati nazivu fajla bez .html
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

      // Slanje na server
      try {
        // Detektuj da li se fajl otvara direktno iz uploads/ foldera (statički preview)
        // ili kroz MVC rutu (index.php?route=take_test) koji je u root-u
        const isInUploads = window.location.pathname.toLowerCase().includes('/uploads/');
        const submitUrl = isInUploads ? '../index.php?route=submit_test' : 'index.php?route=submit_test';
        const response = await fetch(submitUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(resultObj)
        });

        const rawText = await response.text();
        let result;
        try {
          result = JSON.parse(rawText);
        } catch (e) {
          throw new Error("Server je vratio neispravan odgovor: " + rawText.substring(0, 150));
        }

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
            setTimeout(() => { window.location.href = 'index.php'; }, 300); // Fallback ako browser blokira zatvaranje
        };
        submitBtn.style.display = 'flex';
        
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        if (prevBtn) prevBtn.style.display = 'none';
        if (nextBtn) nextBtn.style.display = 'none';
      }

      // Overlay poruka ako je završetak zbog timera ili napuštanja
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
