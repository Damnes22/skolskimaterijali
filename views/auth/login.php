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
<meta name="description" content="Prijavite se na Školski Panel — centralizovana platforma za dijeljenje nastavnih materijala i testova.">
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
<title>Školski materijali - Prijava</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
  tailwind.config = {
    theme: {
      extend: {
        screens: { 'xs': '320px' },
        fontFamily: { sans: ['Inter', 'sans-serif'] }
      }
    }
  }
</script>
<style>
@layer utilities {
  .animate-fadeIn { animation: fadeIn 0.25s ease-out forwards; }
  @keyframes fadeIn { 0% { opacity:0; transform: scale(0.97); } 100% { opacity:1; transform: scale(1); } }
  .btn-hover { transition: all 0.2s ease; }
  .btn-hover:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.35); }
  .gradient-bg { background: linear-gradient(-45deg,#1a1a2e,#162447,#1f4068,#e43f5a); background-size: 400% 400%; animation: gradientBG 15s ease infinite; }
  @keyframes gradientBG { 0% {background-position:0% 50%;} 50% {background-position:100% 50%;} 100% {background-position:0% 50%;} }
  .animate-shake { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
  @keyframes shake {
    10%, 90% { transform: translate3d(-1px, 0, 0); }
    20%, 80% { transform: translate3d(2px, 0, 0); }
    30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
    40%, 60% { transform: translate3d(4px, 0, 0); }
  }
  body { font-family: 'Inter', sans-serif; }

  /* Svijetla Ocean tema overrides */
  html.theme-ocean body.gradient-bg {
    background: linear-gradient(135deg, #f0f9ff 0%, #ecfdf5 50%, #f0fdfa 100%);
    animation: none;
    color: #334155;
  }
  html.theme-ocean .bg-gray-800 {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
    border-color: #ccfbf1 !important;
    box-shadow: 0 25px 60px -12px rgba(13, 148, 136, 0.15), 0 8px 24px rgba(8, 145, 178, 0.1) !important;
  }
  html.theme-ocean .bg-gray-900 { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-color: #ccfbf1 !important; color: #1e293b !important; }
  html.theme-ocean .border-gray-700 { border-color: #ccfbf1 !important; }
  html.theme-ocean .border-b { border-color: #ccfbf1 !important; }
  html.theme-ocean .text-white { color: #0f172a !important; }
  html.theme-ocean .text-gray-100 { color: #1e293b !important; }
  html.theme-ocean .text-gray-300 { color: #334155 !important; }
  html.theme-ocean input { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-color: #ccfbf1 !important; color: #1e293b !important; }
  html.theme-ocean input:focus { border-color: #0d9488 !important; box-shadow: 0 0 0 3px rgba(13,148,136,0.15), 0 4px 12px rgba(13,148,136,0.1) !important; background: #ffffff !important; }
  html.theme-ocean input::placeholder { color: #94a3b8 !important; }
  html.theme-ocean .text-gray-400 { color: #64748b !important; }
  html.theme-ocean .text-gray-500 { color: #94a3b8 !important; }
  html.theme-ocean button#loginBtn {
    background: linear-gradient(135deg, #0d9488 0%, #0891b2 50%, #0e7490 100%) !important;
    color: #ffffff !important;
    border-color: transparent !important;
    box-shadow: 0 4px 16px rgba(13,148,136,0.25), 0 2px 8px rgba(8,145,178,0.15) !important;
  }
  html.theme-ocean button#loginBtn:hover {
    background: linear-gradient(135deg, #0f766e 0%, #0e7490 50%, #155e75 100%) !important;
    box-shadow: 0 6px 20px rgba(13,148,136,0.35), 0 4px 12px rgba(8,145,178,0.2) !important;
  }
  html.theme-ocean .bg-purple-600\/20 { background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08)) !important; }
  html.theme-ocean .bg-blue-600\/20 { background: linear-gradient(135deg, rgba(8,145,178,0.12), rgba(13,148,136,0.08)) !important; }
  html.theme-ocean .bg-gradient-to-br { background: linear-gradient(135deg, #0d9488 0%, #0891b2 50%, #0e7490 100%) !important; }
  html.theme-ocean .shadow-purple-500\/30 { box-shadow: 0 10px 20px -3px rgba(13,148,136,0.35), 0 4px 12px rgba(8,145,178,0.2) !important; }
  html.theme-ocean .bg-red-500\/10 { background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%) !important; border-color: #fecaca !important; }
  html.theme-ocean .text-red-400 { color: #dc2626 !important; }
  html.theme-ocean .bg-red-900\/50 { background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%) !important; }

  /* Scrollbar in ocean theme */
  html.theme-ocean ::-webkit-scrollbar-thumb { background: #cbd5e1; }
  html.theme-ocean ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

  /* Selection in ocean theme */
  html.theme-ocean ::selection { background-color: #0d9488; color: #ffffff; }

  /* Theme pill button */
  .theme-pill-btn {
    position: relative;
    width: 48px;
    height: 26px;
    background: rgba(139, 92, 246, 0.2);
    border: 1px solid rgba(139, 92, 246, 0.3);
    border-radius: 999px;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  .theme-pill-track {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 6px;
  }
  .theme-pill-thumb {
    position: absolute;
    left: 3px;
    width: 18px;
    height: 18px;
    background: linear-gradient(135deg, #a855f7, #7c3aed);
    border-radius: 50%;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(168, 85, 247, 0.4);
  }
  .theme-pill-icon {
    font-size: 10px;
    color: #a855f7;
    transition: all 0.3s ease;
    opacity: 0.5;
  }
  .theme-pill-icon-left {
    opacity: 1;
  }
  .theme-pill-icon-right {
    opacity: 0.3;
  }
  html.theme-ocean .theme-pill-btn {
    background: rgba(13, 148, 136, 0.2);
    border-color: rgba(13, 148, 136, 0.3);
  }
  html.theme-ocean .theme-pill-thumb {
    left: calc(100% - 21px);
    background: linear-gradient(135deg, #0d9488, #0891b2);
    box-shadow: 0 2px 8px rgba(13, 148, 136, 0.4);
  }
  html.theme-ocean .theme-pill-icon {
    color: #0d9488;
  }
  html.theme-ocean .theme-pill-icon-left {
    opacity: 0.3;
  }
  html.theme-ocean .theme-pill-icon-right {
    opacity: 1;
  }
}
</style>
</head>
<body class="gradient-bg text-gray-100 flex items-center justify-center min-h-screen p-4">
<div class="bg-gray-800 p-6 sm:p-8 rounded-3xl shadow-2xl w-full max-w-md <?php echo !empty($msg) ? 'animate-shake' : 'animate-fadeIn'; ?> border border-gray-700 relative overflow-hidden">
    <!-- Dekorativni sjaj u pozadini kartice -->
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="flex flex-col items-center justify-center gap-3 mb-8 border-b border-gray-700/50 pb-6 relative z-10">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center shadow-lg shadow-purple-500/30 mb-2">
            <i class="fas fa-graduation-cap text-white text-2xl"></i>
        </div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold text-white tracking-tight">ŠkolskiPanel</h1>
            <button id="themeToggleBtn" onclick="toggleTheme()" class="theme-pill-btn" title="Promijeni temu">
                <span class="theme-pill-track">
                    <span class="theme-pill-thumb"></span>
                    <i class="fas fa-palette theme-pill-icon theme-pill-icon-left"></i>
                    <i class="fas fa-sun theme-pill-icon theme-pill-icon-right"></i>
                </span>
            </button>
        </div>
        <p class="text-gray-400 text-sm">Prijavite se za pristup materijalima</p>
    </div>

    <?php if(!empty($msg)): ?>
    <div class="flex flex-col gap-2 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 shadow-sm relative z-10">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-circle flex-shrink-0"></i>
            <p class="text-sm font-medium"><?= htmlspecialchars($msg) ?></p>
        </div>
        <?php
        // Prikaz progress bara za preostale pokušaje
        $attempts = $_SESSION['login_attempts'] ?? 0;
        $maxAttempts = 5;
        $remaining = max(0, $maxAttempts - $attempts);
        $pct = ($remaining / $maxAttempts) * 100;
        $barColor = $remaining <= 1 ? 'bg-red-500' : ($remaining <= 3 ? 'bg-orange-400' : 'bg-yellow-400');
        if ($attempts > 0 && $attempts < $maxAttempts):
        ?>
        <div class="mt-1">
            <div class="flex justify-between text-[11px] text-red-400/70 mb-1">
                <span>Preostalo pokušaja</span>
                <span class="font-bold"><?= $remaining ?> / <?= $maxAttempts ?></span>
            </div>
            <div class="w-full h-1.5 bg-red-900/50 rounded-full overflow-hidden">
                <div class="h-full <?= $barColor ?> rounded-full transition-all duration-500" style="width: <?= $pct ?>%"></div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <form method="post" action="index.php?route=login" class="flex flex-col gap-5 relative z-10" id="loginForm">
        <div class="space-y-2">
            <label for="username" class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Korisničko ime</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500"><i class="fas fa-user"></i></span>
                <input type="text" id="username" name="username" placeholder="Unesite korisničko ime" required class="w-full bg-gray-900 text-white pl-11 pr-4 py-3.5 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 shadow-inner">
            </div>
        </div>
        <div class="space-y-2">
            <label for="password" class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Lozinka</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500"><i class="fas fa-lock"></i></span>
                <input type="password" id="password" name="password" placeholder="Unesite lozinku" required class="w-full bg-gray-900 text-white pl-11 pr-12 py-3.5 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 shadow-inner">
                <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500 hover:text-white toggle-password transition-colors" data-target="password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <button type="submit" id="loginBtn" class="w-full bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white py-3.5 rounded-xl font-bold transition-all border border-purple-500/30 mt-4 flex items-center justify-center gap-2 text-base shadow-lg hover:shadow-purple-500/25 active:scale-[0.98]">
            <i class="fas fa-sign-in-alt"></i> Prijavi se
        </button>
    </form>
    <div class="mt-8 text-center text-gray-500 text-xs font-medium uppercase tracking-wider relative z-10">
        &copy; <?= date('Y') ?> Školski materijali
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-password').forEach(btn => {
      btn.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const icon = this.querySelector('i');

        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          input.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    });

    const loginForm = document.getElementById('loginForm');
    if(loginForm) {
      loginForm.addEventListener('submit', function() {
        const btn = document.getElementById('loginBtn');
        btn.style.pointerEvents = 'none';
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Prijavljivanje...';
      });
    }
});

function toggleTheme() {
  var isOcean = document.documentElement.classList.toggle('theme-ocean');
  localStorage.setItem('appTheme', isOcean ? 'ocean' : 'purple');

  var btn = document.getElementById('themeToggleBtn');
  if (btn) {
    btn.style.transform = 'scale(0.9)';
    setTimeout(function() { btn.style.transform = ''; }, 200);
  }
}
</script>
</body>
</html>
