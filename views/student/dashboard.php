<!DOCTYPE html>
<html lang="bs">
<script>
  var urlParams = new URLSearchParams(window.location.search);
  var currentSubject = urlParams.get('subject');
  if (currentSubject) {
    var subjectTheme = localStorage.getItem('subject_' + currentSubject + '_theme');
    if (subjectTheme === 'ocean') {
      document.documentElement.classList.add('theme-ocean');
    }
  } else {
    if(localStorage.getItem('appTheme')==='ocean')document.documentElement.classList.add('theme-ocean');
  }
</script>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="description" content="Školski materijali — pristup nastavnim materijalima, testovima i obavještenjima.">
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
<title>Školski materijali</title>
<script src="https://cdn.tailwindcss.com"></script>
<!-- Google Fonts: Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
/* ============================================================
   SISTEM TEMA — CSS Custom Properties
   Tema: 'purple' (default) i 'ocean' (plava/zelena)
   ============================================================ */
:root {
  --clr-accent:        #a855f7;
  --clr-accent-dark:   #7c3aed;
  --clr-accent-light:  #c084fc;
  --clr-accent-glow:   rgba(168,85,247,0.4);
  --clr-accent-subtle: rgba(124,58,237,0.1);
  --clr-accent-card:   rgba(126,34,206,0.2);
  --clr-accent-border: rgba(168,85,247,0.5);
  --clr-accent-shadow: rgba(168,85,247,0.3);
  --clr-user-from:     #a855f7;
  --clr-user-to:       #ec4899;
  --clr-role-text:     #c084fc;
  --clr-selection:     #a855f7;
  --clr-btn-grad-1:    #7f00ff;
  --clr-btn-grad-2:    #e100ff;
  --clr-btn-grad-h1:   #a100ff;
  --clr-btn-grad-h2:   #ff4ce1;
}

/* Ocean tema: Moderna svjetla tema — Teal + Cyan */
html.theme-ocean {
  --clr-accent:        #0d9488;
  --clr-accent-dark:   #0f766e;
  --clr-accent-light:  #0d9488;
  --clr-accent-glow:   rgba(13,148,136,0.15);
  --clr-accent-subtle: #f0fdfa;
  --clr-accent-card:   #ffffff;
  --clr-accent-border: rgba(13,148,136,0.25);
  --clr-accent-shadow: rgba(13,148,136,0.12);
  --clr-user-from:     #0d9488;
  --clr-user-to:       #0891b2;
  --clr-role-text:     #0d9488;
  --clr-selection:     #0ea5e9;
  --clr-btn-grad-1:    #0369a1;
  --clr-btn-grad-2:    #059669;
  --clr-btn-grad-h1:   #0284c7;
  --clr-btn-grad-h2:   #10b981;
}

::selection { background-color: var(--clr-selection); color: #fff; }

.card-hover:hover {
  border-color: var(--clr-accent-border) !important;
  box-shadow: 0 10px 30px -10px var(--clr-accent-shadow) !important;
}
.subject-item.active { border-left-color: var(--clr-accent) !important; }
#sidebarCollapseBtn:hover {
  border-color: var(--clr-accent) !important;
  color: var(--clr-accent-light) !important;
  box-shadow: 0 0 12px var(--clr-accent-glow) !important;
}

/* ================================================================
   OCEAN TEMA — Kompletni Moderni Svjetli Dizajn (Student)
   Akcentne boje: Teal (#0d9488) + Cyan (#0891b2)
   ================================================================ */

/* Osnova stranice */
html.theme-ocean body {
  background: linear-gradient(135deg, #f0f9ff 0%, #ecfdf5 50%, #f0fdfa 100%) !important;
  color: #1e293b !important;
}
html.theme-ocean .bg-slate-900 {
  background: linear-gradient(135deg, #f0f9ff 0%, #ecfdf5 50%, #f0fdfa 100%) !important;
}

/* Sidebar */
html.theme-ocean aside {
  background: linear-gradient(180deg, #ffffff 0%, #f0fdfa 50%, #ecfeff 100%) !important;
  border-right: 1px solid #ccfbf1 !important;
  box-shadow: 2px 0 20px rgba(13,148,136,0.08) !important;
}
html.theme-ocean aside .border-b,
html.theme-ocean aside .border-gray-800 { border-color: #ccfbf1 !important; }

/* Header */
html.theme-ocean header {
  background: linear-gradient(180deg, rgba(255,255,255,0.98) 0%, rgba(240,253,250,0.95) 100%) !important;
  border-bottom: 1px solid #ccfbf1 !important;
  backdrop-filter: blur(12px) !important;
  box-shadow: 0 4px 24px rgba(13,148,136,0.10) !important;
}

/* Main */
html.theme-ocean main {
  background: linear-gradient(135deg, #f0f9ff 0%, #ecfdf5 50%, #f0fdfa 100%) !important;
}
html.theme-ocean .flex-1.flex.flex-col {
  background: linear-gradient(135deg, #f0f9ff 0%, #ecfdf5 50%, #f0fdfa 100%) !important;
}

/* === KARTICE === */
html.theme-ocean .glass-card {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
  border: 1px solid #ccfbf1 !important;
  box-shadow: 0 4px 20px -4px rgba(13,148,136,0.12), 0 2px 8px rgba(8,145,178,0.08) !important;
  backdrop-filter: none !important;
}
html.theme-ocean .card-hover:hover {
  background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important;
  border-color: #99f6e4 !important;
  transform: translateY(-3px);
  box-shadow: 0 12px 40px -8px rgba(13,148,136,0.22), 0 4px 16px rgba(8,145,178,0.12) !important;
}

/* === NAVIGACIONI LINKOVI === */
html.theme-ocean .nav-link { color: #4b5563 !important; transition: all 0.2s ease; }
html.theme-ocean .nav-link:hover,
html.theme-ocean .nav-link.active {
  color: #0d9488 !important;
  background: linear-gradient(90deg, rgba(240,253,250,0.9), rgba(236,254,255,0.5)) !important;
  border-left-color: #0d9488 !important;
}
html.theme-ocean .nav-link:hover i { color: #0d9488 !important; }
html.theme-ocean .section-label { color: #556170 !important; }

/* === TEKST === */
html.theme-ocean .text-white { color: #0f172a !important; }
html.theme-ocean .hover\:text-white:hover,
html.theme-ocean .hover\:text-white:hover i { color: #ffffff !important; }

html.theme-ocean .text-gray-400 { color: #374151 !important; }
html.theme-ocean .text-gray-300 { color: #1f2937 !important; }
html.theme-ocean .text-gray-200 { color: #111827 !important; }
html.theme-ocean .text-gray-500 { color: #6b7280 !important; }
html.theme-ocean .text-slate-200 { color: #0f172a !important; }

/* === SCROLLBAR U OCEAN TEMI === */
html.theme-ocean ::-webkit-scrollbar-thumb { background: #cbd5e1; }
html.theme-ocean ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

/* === SELECTION U OCEAN TEMI === */
html.theme-ocean ::selection { background-color: #0d9488; color: #ffffff; }

/* === POZADINE === */
html.theme-ocean .bg-gray-800 { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-900 { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-900\/50 { background: linear-gradient(135deg, rgba(248,250,252,0.9) 0%, rgba(240,253,250,0.85) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-800\/50 { background: linear-gradient(135deg, rgba(241,245,249,0.8) 0%, rgba(240,253,250,0.75) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-700\/40 { background: linear-gradient(135deg, rgba(226,232,240,0.6) 0%, rgba(240,253,250,0.55) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-700\/60 { background: linear-gradient(135deg, rgba(226,232,240,0.7) 0%, rgba(240,253,250,0.65) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-800\/40 { background: linear-gradient(135deg, rgba(241,245,249,0.7) 0%, rgba(240,253,250,0.65) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-800\/80 { background: linear-gradient(135deg, rgba(241,245,249,0.9) 0%, rgba(240,253,250,0.85) 100%) !important; border-color: #ccfbf1 !important; }

/* === BORDERI === */
html.theme-ocean .border-gray-700 { border-color: #ccfbf1 !important; }
html.theme-ocean .border-gray-800 { border-color: #ccfbf1 !important; }
html.theme-ocean .border-gray-600 { border-color: #99f6e4 !important; }
html.theme-ocean .border-gray-700\/50 { border-color: rgba(204,251,241,0.8) !important; }

/* === FORME === */
html.theme-ocean input:not([type="checkbox"]):not([type="radio"]):not([type="file"]),
html.theme-ocean textarea {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
  border-color: #ccfbf1 !important;
  color: #1e293b !important;
}
html.theme-ocean input::placeholder,
html.theme-ocean textarea::placeholder { color: #6b7280 !important; }
html.theme-ocean input:focus:not([type="checkbox"]):not([type="radio"]),
html.theme-ocean textarea:focus {
  border-color: #0d9488 !important;
  box-shadow: 0 0 0 3px rgba(13,148,136,0.15), 0 4px 12px rgba(13,148,136,0.1) !important;
  background: #ffffff !important;
}

/* === PURPLE → TEAL/CYAN OVERRIDE === */
html.theme-ocean .text-purple-400 { color: #0891b2 !important; }
html.theme-ocean .text-purple-300 { color: #0e7490 !important; }
html.theme-ocean .text-purple-100 { color: #155e75 !important; }
html.theme-ocean .bg-purple-600\/20 { background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08)) !important; }
html.theme-ocean .bg-purple-500\/20 { background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(8,145,178,0.08)) !important; }
html.theme-ocean .bg-purple-500\/10 { background: linear-gradient(135deg, rgba(13,148,136,0.08), rgba(8,145,178,0.05)) !important; }
html.theme-ocean .bg-purple-900\/20 { background: linear-gradient(135deg, rgba(13,148,136,0.10), rgba(8,145,178,0.06)) !important; }
html.theme-ocean .bg-purple-600 { background: linear-gradient(135deg, #0891b2 0%, #0d9488 100%) !important; }
html.theme-ocean .border-purple-500\/30 { border-color: rgba(13,148,136,0.35) !important; }
html.theme-ocean .border-purple-500 { border-color: #0d9488 !important; }
html.theme-ocean .border-l-4.border-purple-500 { border-left-color: #0891b2 !important; }
html.theme-ocean .hover\:bg-purple-600:hover { background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%) !important; color: #ffffff !important; }
html.theme-ocean .hover\:bg-purple-500:hover { background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%) !important; color: #ffffff !important; }
html.theme-ocean .hover\:text-purple-400:hover { color: #0d9488 !important; }
html.theme-ocean .hover\:text-purple-300:hover { color: #0891b2 !important; }
html.theme-ocean .hover\:border-purple-500:hover { border-color: #0d9488 !important; }
html.theme-ocean .hover\:border-purple-500\/30:hover { border-color: rgba(13,148,136,0.3) !important; }
html.theme-ocean .focus\:border-purple-500:focus { border-color: #0d9488 !important; }
html.theme-ocean .focus\:ring-purple-500 { --tw-ring-color: rgba(13,148,136,0.25) !important; }
html.theme-ocean .from-purple-600 { --tw-gradient-from: #0891b2 var(--tw-gradient-from-position) !important; }
html.theme-ocean .from-purple-500 { --tw-gradient-from: #0ea5e9 var(--tw-gradient-from-position) !important; }
html.theme-ocean .to-pink-500 { --tw-gradient-to: #10b981 var(--tw-gradient-to-position) !important; }
html.theme-ocean .to-blue-600 { --tw-gradient-to: #059669 var(--tw-gradient-to-position) !important; }
html.theme-ocean .shadow-purple-500\/20 { --tw-shadow-color: rgba(13,148,136,0.2) !important; }
html.theme-ocean .hover\:shadow-purple-500\/40:hover { --tw-shadow-color: rgba(13,148,136,0.3) !important; }
html.theme-ocean .group:hover .group-hover\:bg-purple-600 { background-color: #0d9488 !important; }
html.theme-ocean .group:hover .group-hover\:text-purple-300 { color: #0891b2 !important; }
html.theme-ocean .hover\:shadow-\[0_0_12px_rgba\(168\,85\,247\,0\.4\)\]:hover { box-shadow: 0 0 12px rgba(13,148,136,0.3) !important; }

/* === MODALNI PROZORI (Student) === */
html.theme-ocean [id$="Content"],
html.theme-ocean [id$="Modal"] > div {
  background-color: #ffffff !important;
  border-color: #e2e8f0 !important;
  box-shadow: 0 20px 60px rgba(0,0,0,0.10), 0 4px 16px rgba(13,148,136,0.08) !important;
}
html.theme-ocean [id$="Content"] .border-gray-700,
html.theme-ocean [id$="Content"] .border-b { border-color: #f1f5f9 !important; }
html.theme-ocean [id$="Content"] h2 { color: #0f172a !important; }
html.theme-ocean [id$="Content"] label { color: #374151 !important; }
html.theme-ocean .bg-black\/60 { background-color: rgba(15,23,42,0.3) !important; }
html.theme-ocean .bg-gray-700 { background-color: #f1f5f9 !important; }
html.theme-ocean .bg-gray-700\/40 { background-color: rgba(241,245,249,0.8) !important; }

/* === TABELE === */
html.theme-ocean table .border-gray-600 { border-color: #e2e8f0 !important; }
html.theme-ocean table .border-gray-700 { border-color: #f1f5f9 !important; }
html.theme-ocean table tr:hover { background-color: rgba(240,253,250,0.6) !important; }
html.theme-ocean table .text-gray-300 { color: #1f2937 !important; }
html.theme-ocean table .text-gray-200 { color: #111827 !important; }

/* === FILE LISTE / PREDMETI === */
html.theme-ocean .bg-gray-800\/50 { background-color: #ffffff !important; border-color: #e2e8f0 !important; }
html.theme-ocean .bg-gray-800[class*="rounded"] { background-color: #f8fafc !important; border-color: #e2e8f0 !important; }

/* === SUBJEKT KARTICE (Student view) === */
html.theme-ocean .glass-card.card-hover .bg-gray-800 {
  background-color: #f1f5f9 !important;
  border-color: #e2e8f0 !important;
}
html.theme-ocean .group:hover .group-hover\:bg-purple-600 {
  background-color: #0d9488 !important;
  color: #ffffff !important;
}
html.theme-ocean .group-hover\:text-purple-300 { color: #0891b2 !important; }
html.theme-ocean .absolute.bottom-0.left-0 { opacity: 0.9; }

/* === NOTIFICATION DROPDOWN === */
html.theme-ocean #notificationDropdown {
  background-color: #ffffff !important;
  border-color: #e2e8f0 !important;
  box-shadow: 0 8px 32px rgba(0,0,0,0.10) !important;
}
html.theme-ocean #notificationDropdown .bg-gray-800\/80 { background-color: #f8fafc !important; }
html.theme-ocean #notificationDropdown .border-gray-700 { border-color: #f1f5f9 !important; }
html.theme-ocean #notificationDropdown .text-white { color: #0f172a !important; }
html.theme-ocean #notificationDropdown .hover\:bg-gray-700:hover { background-color: #f0fdfa !important; }
html.theme-ocean #notificationDropdown .bg-gray-700\/40 { background-color: rgba(240,253,250,0.8) !important; }

/* === PRETRAGA === */
html.theme-ocean input[placeholder*="pretraga"],
html.theme-ocean input[placeholder*="Pretraga"] {
  background-color: #f1f5f9 !important;
  border-color: #e2e8f0 !important;
  color: #1f2937 !important;
}
html.theme-ocean input[placeholder*="pretraga"]:hover,
html.theme-ocean input[placeholder*="Pretraga"]:hover {
  border-color: #0d9488 !important;
}

/* === SCROLLBAR === */
html.theme-ocean ::-webkit-scrollbar-thumb { background: #cbd5e1 !important; }
html.theme-ocean ::-webkit-scrollbar-thumb:hover { background: #94a3b8 !important; }

/* === GLOBALNI TOOLTIP === */
html.theme-ocean #globalTooltip,
html.theme-ocean #globalTooltip.text-white {
  background-color: #1f2937 !important;
  border-color: #374151 !important;
  color: #ffffff !important;
  box-shadow: 0 4px 20px rgba(0,0,0,0.3), 0 0 12px rgba(13,148,136,0.2) !important;
}

/* === UPLOAD ZONA === */
html.theme-ocean #dropZone,
html.theme-ocean #testDropZone {
  background-color: #f8fafc !important;
  border-color: #cbd5e1 !important;
}
html.theme-ocean #dropZone:hover { border-color: #0d9488 !important; background-color: #f0fdfa !important; }

/* === TOAST PORUKE === */
html.theme-ocean #successMsg {
  background-color: #ffffff !important;
  border-color: rgba(16,185,129,0.3) !important;
  color: #064e3b !important;
}
html.theme-ocean #errorMsg {
  background-color: #ffffff !important;
  border-color: rgba(239,68,68,0.25) !important;
  color: #7f1d1d !important;
}

/* === LOGOUT DUGME === */
html.theme-ocean #logoutBtn {
  background-color: #f8fafc !important;
  border-color: #e2e8f0 !important;
  color: #64748b !important;
}
html.theme-ocean #logoutBtn:hover {
  background-color: #fff1f2 !important;
  border-color: rgba(239,68,68,0.3) !important;
  color: #ef4444 !important;
}

/* === SIDEBAR COLLAPSE DUGME === */
html.theme-ocean #sidebarCollapseBtn {
  background-color: #ffffff !important;
  border-color: #e2e8f0 !important;
  color: #64748b !important;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
}
html.theme-ocean #sidebarCollapseBtn:hover {
  background-color: #f0fdfa !important;
  border-color: #0d9488 !important;
  color: #0d9488 !important;
}

/* === BREADCRUMB === */
html.theme-ocean nav a.bg-gray-800\/40 {
  background-color: #f1f5f9 !important;
  border-color: #e2e8f0 !important;
  color: #64748b !important;
}
html.theme-ocean nav a.bg-gray-800\/40:hover {
  background-color: #f0fdfa !important;
  color: #0d9488 !important;
}
html.theme-ocean .bg-purple-900\/20 { background-color: rgba(13,148,136,0.08) !important; }

/* === SUBJECT ITEMS === */
html.theme-ocean .subject-item:not(.active):hover {
  background-color: rgba(240,253,250,0.8) !important;
  border-color: rgba(13,148,136,0.2) !important;
}
html.theme-ocean .subject-item.active {
  background: linear-gradient(to right, rgba(13,148,136,0.10), rgba(13,148,136,0.02)) !important;
  border-left-color: #0d9488 !important;
}

/* === HOVER EFEKTI === */
html.theme-ocean .hover\:bg-gray-700:hover { background-color: #f0fdfa !important; }
html.theme-ocean .hover\:bg-gray-800:hover { background-color: #f0fdfa !important; }
html.theme-ocean .hover\:border-gray-600:hover { border-color: #99f6e4 !important; }

/* === COLLAPSED SIDEBAR === */
html.theme-ocean body.sidebar-collapsed aside .nav-link.active {
  box-shadow: inset 3px 0 0 #0d9488 !important;
  background: rgba(13,148,136,0.10) !important;
}

/* === ČEKBOKS AREA === */
html.theme-ocean .bg-gray-900\/80 { background-color: #f8fafc !important; border-color: #e2e8f0 !important; }

/* === "UČITAJ JOŠ" DUGME === */
html.theme-ocean #loadMoreNotifsContainer button,
html.theme-ocean #loadMoreUsersContainer button {
  background-color: #f8fafc !important;
  border-color: #e2e8f0 !important;
  color: #0d9488 !important;
}

/* === MOBILE MENU === */
html.theme-ocean #mobileOverlay { background-color: rgba(15,23,42,0.4) !important; }

@layer utilities {
  .animate-fadeIn { animation: fadeIn 0.5s ease-out both; }
  @keyframes fadeIn { 0% { opacity:0; transform: scale(0.97); } 100% { opacity:1; transform: scale(1); } }
  @keyframes ripple { 0% { transform: scale(0); opacity: 0.8; } 100% { transform: scale(4); opacity: 0; } }
  @keyframes thumbGlow { 0%, 100% { box-shadow: 0 0 12px var(--clr-accent-glow), 0 0 24px var(--clr-accent-glow); } 50% { box-shadow: 0 0 24px var(--clr-accent-glow), 0 0 40px var(--clr-accent-glow); } }
  .btn-hover { transition: all 0.2s ease; }
  .btn-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
  .btn-gradient { background: linear-gradient(90deg, var(--clr-btn-grad-1), var(--clr-btn-grad-2)); }
  .btn-gradient:hover { background: linear-gradient(90deg, var(--clr-btn-grad-h1), var(--clr-btn-grad-h2)); }
  
  /* Modern Button Styles */
  .btn-base {
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    letter-spacing: 0.025em;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }
  .btn-base:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.35); }
  .btn-base:active { transform: scale(0.97); }
  .btn-primary { background: linear-gradient(90deg, var(--clr-btn-grad-1), var(--clr-btn-grad-2)); }
  .btn-primary:hover { background: linear-gradient(90deg, var(--clr-btn-grad-h1), var(--clr-btn-grad-h2)); }
  .btn-danger { background-color: #dc2626; } .btn-danger:hover { background-color: #ef4444; }
  .btn-success { background-color: #16a34a; } .btn-success:hover { background-color: #22c55e; }
  .btn-info { background-color: #2563eb; } .btn-info:hover { background-color: #3b82f6; }
  .btn-secondary { background-color: #4b5563; } .btn-secondary:hover { background-color: #6b7280; }

  /* ── THEME PILL TOGGLE ─────────────────────────────────────── */
  @keyframes ripple    { 0% { transform: scale(0); opacity: 0.8; } 100% { transform: scale(4); opacity: 0; } }

  /* Wrapper koji drži track + labele horizontalno */
  .theme-pill-inner {
    display: flex; align-items: center; gap: 7px;
  }
  .theme-pill-label {
    font-size: 10px; font-weight: 700; letter-spacing: 0.06em;
    text-transform: uppercase; line-height: 1;
    pointer-events: none; white-space: nowrap;
    transition: all 0.4s ease;
  }
  .theme-pill-label-dark  { color: rgba(255,255,255,0.75); }
  .theme-pill-label-light { color: rgba(255,255,255,0.30); }
  html.theme-ocean .theme-pill-label-dark  { color: rgba(15,23,42,0.30); }
  html.theme-ocean .theme-pill-label-light { color: rgba(8,145,178,0.90); }

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
}

/* Sidebar Link Styles */
.nav-link { display: flex; align-items: center; justify-content: flex-start; padding: 0.75rem 1rem; color: #94a3b8; border-radius: 0.5rem; transition: all 0.2s; margin-bottom: 0.25rem; cursor: pointer; border: none; border-left: 3px solid transparent; outline: none; background: transparent; width: 100%; text-align: left; font-family: inherit; font-size: inherit; appearance: none; -webkit-appearance: none; text-decoration: none; margin-top: 0; }
.nav-link:hover { background: linear-gradient(90deg, var(--clr-accent-subtle), transparent); color: var(--clr-accent-light); border-left-color: var(--clr-accent-light); }
.nav-link.active { background: linear-gradient(90deg, var(--clr-accent-subtle), transparent); color: var(--clr-accent-light); border-left-color: var(--clr-accent-light); }
.nav-link i { width: 1.5rem; text-align: center; margin-right: 0.75rem; transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), color 0.3s ease; flex-shrink: 0; }
.nav-link:hover i { transform: scale(1.25); color: var(--clr-accent-light); }

@layer utilities {
  /* Glassmorphism Cards */
  .glass-card {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  }
  
  .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid rgba(255, 255, 255, 0.05); }
  .card-hover:hover { 
    background: rgba(30, 41, 59, 0.9);
    border-color: rgba(168, 85, 247, 0.5);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px -10px rgba(168, 85, 247, 0.3);
  }
  
  .subject-item { cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent; }
  .subject-item:not(.active):hover { 
    background-color: rgba(51, 65, 85, 0.5);
    border-color: rgba(148, 163, 184, 0.2);
  }
  .subject-item.active { 
    background: linear-gradient(to right, rgba(126, 34, 206, 0.2), rgba(126, 34, 206, 0.05));
    border-left: 3px solid #a855f7;
  }

  .delete-btn { transition: all 0.2s ease; cursor: pointer; }
  .delete-btn:hover {
    filter: drop-shadow(0 0 8px rgba(239, 68, 68, 0.6));
    text-shadow: 0 0 8px rgba(239, 68, 68, 0.8);
  }

  /* Scrollbar */
  ::-webkit-scrollbar { width: 6px; height: 6px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
  ::-webkit-scrollbar-thumb:hover { background: #64748b; }
  
  body { font-family: 'Inter', sans-serif; }

  /* Modern Sidebar Collapse Styles */
  aside { transition: width 0.4s cubic-bezier(0.2, 0.8, 0.2, 1); }
  aside .logo-text, aside .user-details, aside .nav-link span, aside .section-label, aside #logoutBtn span {
      transition: opacity 0.2s ease; opacity: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .nav-link { position: relative; }
  @media (min-width: 768px) {
      body.sidebar-collapsed aside { width: 5.5rem !important; }
      
      /* Sakrivanje teksta i detalja */
      body.sidebar-collapsed aside .logo-text, 
      body.sidebar-collapsed aside .user-details, 
      body.sidebar-collapsed aside .nav-link span, 
      body.sidebar-collapsed aside #logoutBtn span { 
          opacity: 0; max-width: 0; width: 0; padding: 0; margin: 0; pointer-events: none; visibility: hidden;
      }
      
      /* Potpuno uklanjanje razmaka kod naslova sekcija */
      body.sidebar-collapsed aside .section-label { 
          opacity: 0; height: 0; padding: 0 !important; margin: 0 !important; overflow: hidden; border: none; font-size: 0; 
      }
      
      /* Savršeno centriranje navigacionih linkova u obliku zaobljenih kvadrata */
      body.sidebar-collapsed aside .nav-link { 
          justify-content: center; padding: 0; width: 3.25rem; height: 3.25rem; margin-left: auto; margin-right: auto; border-radius: 0.75rem; border-left: none; margin-bottom: 0.5rem;
      }
      body.sidebar-collapsed aside .nav-link.active { box-shadow: inset 3px 0 0 #c084fc; background: rgba(124, 58, 237, 0.15); }
      body.sidebar-collapsed aside .nav-link i { margin-right: 0; font-size: 1.3rem; }
      
      /* Centriranje Logo sekcije i korisničkog profila */
      body.sidebar-collapsed aside .p-6 { padding-left: 0; padding-right: 0; justify-content: center; }
      body.sidebar-collapsed aside .p-6 > div:first-child { gap: 0; justify-content: center; width: 100%; }
      body.sidebar-collapsed aside .user-container { justify-content: center; padding-left: 0; padding-right: 0; padding: 0; gap: 0; margin-bottom: 0.75rem; display: flex; width: 100%; align-items: center; }
      
      body.sidebar-collapsed #collapseIcon { transform: rotate(180deg); }
      
      /* Logout dugme - isti kvadratni izgled */
      body.sidebar-collapsed aside #logoutBtn {
          width: 3.25rem; height: 3.25rem; justify-content: center; align-items: center; margin-left: auto; margin-right: auto; padding: 0; border-radius: 0.75rem;
      }
      body.sidebar-collapsed aside #logoutBtn i { margin-right: 0; font-size: 1.3rem; }
  }
  
  /* Show sidebar collapse button on hover or when collapsed */
  #sidebarCollapseBtn {
      opacity: 0;
      transition: opacity 0.2s ease-in-out;
  }
  aside:hover #sidebarCollapseBtn,
  body.sidebar-collapsed #sidebarCollapseBtn {
      opacity: 1;
  }

  /* Responzivni stilovi za mobilne uređaje */
  @media (max-width: 640px) {
    .mobile-full-width {
      width: 100% !important;
      max-width: 100% !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-left: 0.5rem !important;
      padding-right: 0.5rem !important;
    }
    .mobile-text-base {
      font-size: 1rem !important;
    }
    .mobile-text-lg {
      font-size: 1.125rem !important;
    }
    .mobile-text-xl {
      font-size: 1.25rem !important;
    }
    .mobile-py-2 {
      padding-top: 0.5rem !important;
      padding-bottom: 0.5rem !important;
    }
    .mobile-px-2 {
      padding-left: 0.5rem !important;
      padding-right: 0.5rem !important;
    }
    .mobile-my-2 {
      margin-top: 0.5rem !important;
      margin-bottom: 0.5rem !important;
    }
    .mobile-flex-col {
      flex-direction: column !important;
    }
    .mobile-w-full {
      width: 100% !important;
    }
    .mobile-text-center {
      text-align: center !important;
    }
  }
}

/* pill hover override - van @layer bloka da bi imao veći prioritet od Tailwind utilities */
.theme-pill-btn:hover {
  background: linear-gradient(135deg, rgba(124,58,237,0.32) 0%, rgba(99,102,241,0.20) 100%) !important;
  border-color: var(--clr-accent) !important;
  box-shadow: inset 0 1px 2px rgba(255,255,255,0.15) !important;
  transform: translateY(-2px) scale(1.03) !important;
}
.theme-pill-btn:hover .theme-pill-track {
  border-color: var(--clr-accent-border) !important;
  box-shadow: inset 0 2px 6px rgba(0,0,0,0.6) !important;
  background: linear-gradient(135deg, rgba(15,23,42,0.98) 0%, rgba(30,41,59,0.95) 100%) !important;
}
.theme-pill-btn:hover .theme-pill-thumb {
  box-shadow: 0 2px 8px rgba(0,0,0,0.4) !important;
}
html.theme-ocean .theme-pill-btn:hover {
  background: linear-gradient(135deg, rgba(8,145,178,0.32) 0%, rgba(13,148,136,0.22) 100%) !important;
  box-shadow: inset 0 1px 2px rgba(255,255,255,0.15) !important;
  border-color: #0891b2 !important;
}
</style>
</head>
<body class="bg-[#0f172a] text-slate-200 h-screen sm:h-screen h-[100dvh] overflow-hidden selection:bg-purple-500 selection:text-white">

<!-- Poruke o uspjehu/greškama -->
<?php if(isset($_SESSION['success_message'])): ?>
<div id="successMsg" class="fixed bottom-6 right-6 bg-slate-900/90 border border-emerald-500/20 text-emerald-100 px-4 py-2.5 rounded-xl shadow-2xl backdrop-blur-md z-[9999] animate-fadeIn flex items-center gap-3 max-w-[320px]">
  <div class="w-6 h-6 rounded-lg bg-emerald-500/10 flex items-center justify-center flex-shrink-0 border border-emerald-500/20">
    <i class="fas fa-check text-emerald-400 text-[10px]"></i>
  </div>
  <span class="text-xs font-medium flex-1 truncate"><?= $_SESSION['success_message'] ?></span>
  <button onclick="this.closest('[id]').style.display='none'" class="flex-shrink-0 text-gray-500 hover:text-white transition-colors ml-1" title="Zatvori"><i class="fas fa-times text-[10px]"></i></button>
  <?php unset($_SESSION['success_message']); ?>
</div>
<?php endif; ?>

<?php if(isset($_SESSION['error_message'])): ?>
<div id="errorMsg" class="fixed bottom-6 right-6 bg-slate-900/90 border border-rose-500/20 text-rose-100 px-4 py-2.5 rounded-xl shadow-2xl backdrop-blur-md z-[9999] animate-fadeIn flex items-center gap-3 max-w-[320px]">
  <div class="w-6 h-6 rounded-lg bg-rose-500/10 flex items-center justify-center flex-shrink-0 border border-rose-500/20">
    <i class="fas fa-exclamation-triangle text-rose-400 text-[10px]"></i>
  </div>
  <span class="text-xs font-medium flex-1 truncate"><?= $_SESSION['error_message'] ?></span>
  <button onclick="this.closest('[id]').style.display='none'" class="flex-shrink-0 text-gray-500 hover:text-white transition-colors ml-1" title="Zatvori"><i class="fas fa-times text-[10px]"></i></button>
  <?php unset($_SESSION['error_message']); ?>
</div>
<?php endif; ?>

<script>
window.addEventListener('DOMContentLoaded', function() {
  // Auto-hide toast notifikacija
  var msgs = ['successMsg', 'errorMsg'];
  msgs.forEach(function(id) {
    var el = document.getElementById(id);
    if (!el) return;
    setTimeout(function() {
      el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
      el.style.opacity = '0';
      el.style.transform = 'translateY(12px)';
      setTimeout(function() { el.style.display = 'none'; }, 400);
    }, 3500);
  });

  // Auto-scroll na aktivan predmet u sidebaru
  var activeLink = document.querySelector('aside .nav-link.active');
  if (activeLink) {
    activeLink.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
  }
});
</script>

<div class="flex h-full">

  <!-- SIDEBAR OVERLAY (Mobile) -->
  <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity backdrop-blur-sm"></div>

  <!-- SIDEBAR -->
  <aside id="sidebar" class="w-64 bg-[#111827] border-r border-gray-800 flex flex-col fixed md:relative inset-y-0 left-0 z-[90] transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out h-full h-[100dvh] md:h-full">
    <button id="sidebarCollapseBtn" title="Preklopi bočnu traku (Ctrl+B)" class="absolute -right-4 top-8 bg-gray-800 border border-gray-700 text-gray-400 hover:text-white hover:bg-gray-700 hover:border-purple-500 hover:text-purple-400 p-1 rounded-full w-8 h-8 hidden md:flex items-center justify-center shadow-lg hover:shadow-[0_0_12px_rgba(168,85,247,0.4)] z-[90] transition-all duration-300 focus:outline-none group">
        <i class="fas fa-chevron-left text-sm transition-transform duration-500" id="collapseIcon"></i>
    </button>

    <div class="p-6 flex items-center justify-between border-b border-gray-800/50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center shadow-lg shadow-purple-500/20 flex-shrink-0">
                <i class="fas fa-graduation-cap text-white text-sm"></i>
            </div>
            <span class="font-bold text-lg tracking-tight text-white logo-text">ŠkolskiPanel</span>
        </div>
        <button id="mobileCloseSidebar" class="md:hidden text-gray-400 hover:text-white transition-colors p-1">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6 px-4 space-y-1">
        <div class="px-2 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider section-label">Glavni izbornik</div>
        <a href="index.php" class="nav-link <?= (!$selected_subject) ? 'active' : '' ?>" title="Početna">
            <i class="fas fa-home"></i> <span>Početna</span>
        </a>
        
        <?php if($is_admin): ?>
        <div class="pt-6 pb-2 px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider section-label">Administracija</div>
        <button id="openManageAdmins" class="nav-link w-full text-left" title="Administratori">
            <i class="fas fa-users-cog"></i> <span>Upravljaj administratorima</span>
        </button>
        <?php endif; ?>

        <?php if(!$is_admin && $subjects && $subjects->num_rows > 0): ?>
        <div class="pt-6 pb-2 px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider section-label">Moji predmeti</div>
        <?php 
            // Reset pointer because we might use it in main content
            $subjects->data_seek(0); 
            while($row = $subjects->fetch_assoc()): 
        ?>
        <a href="index.php?subject=<?= (int)$row['id'] ?>" class="nav-link <?= ((int)$row['id'] === (int)$selected_subject) ? 'active' : '' ?>" title="<?= htmlspecialchars($row['name']) ?>">
            <i class="fas fa-book text-gray-600"></i> 
            <span class="truncate"><?= htmlspecialchars($row['name']) ?></span>
        </a>
        <?php endwhile; $subjects->data_seek(0); ?>
        <?php endif; ?>
    </nav>

    <div class="p-4 border-t border-gray-800">
        <div class="flex items-center gap-2 mb-4 px-2 user-container">
            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white shadow-md flex-shrink-0" style="background: linear-gradient(135deg, var(--clr-user-from), var(--clr-user-to))">
                <i class="fas fa-user text-xs"></i>
            </div>
            <div class="flex flex-col user-details overflow-hidden flex-1 min-w-0">
                <span class="text-sm font-semibold text-white truncate"><?= htmlspecialchars($_SESSION['username']) ?></span>
                <span class="text-xs truncate" style="color: var(--clr-role-text)"><?= $_SESSION['role']==='student'?'Učenik':'Master Admin' ?></span>
            </div>
            <button id="themeToggleBtn" onclick="toggleTheme()" class="theme-pill-btn user-details" title="Promijeni temu" aria-label="Promijeni temu" role="switch">
                <span class="theme-pill-track">
                    <span class="theme-pill-thumb"></span>
                    <i class="fas fa-moon theme-pill-icon theme-pill-icon-left"></i>
                    <i class="fas fa-sun theme-pill-icon theme-pill-icon-right"></i>
                </span>
            </button>
        </div>
        <a href="index.php?route=logout" id="logoutBtn" class="flex items-center justify-center gap-2 w-full py-2 bg-gray-800 hover:bg-red-600/10 hover:text-red-400 text-gray-400 rounded-lg transition-colors text-sm font-medium border border-gray-700 hover:border-red-500/30" title="Odjavi se">
            <i class="fas fa-sign-out-alt"></i> <span>Odjavi se</span>
        </a>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="flex-1 flex flex-col h-screen sm:h-screen h-[100dvh] overflow-hidden bg-slate-900 relative">
    <!-- Topbar (Mobile only mostly, or global search) -->
    <header class="h-16 bg-[#0f172a]/80 backdrop-blur-md border-b border-gray-800 flex items-center justify-between px-6 z-[45]">
        <div class="md:hidden flex items-center gap-2">
            <button id="mobileMenuBtn" class="text-gray-400 hover:text-white"><i class="fas fa-bars text-xl"></i></button>
            <span class="font-bold text-lg">ŠkolskiPanel</span>
        </div>
        
        <!-- Breadcrumbs / Title -->
        <nav class="hidden md:flex items-center gap-2 text-sm font-medium">
            <a href="index.php" class="text-gray-400 hover:text-purple-400 transition-colors flex items-center gap-2 bg-gray-800/40 hover:bg-gray-800/80 px-3 py-1.5 rounded-lg border border-gray-700/50">
                <i class="fas fa-home"></i> Početna
            </a>
            <?php if($selected_subject > 0): ?>
                <?php 
                $subject_name = "Pregled predmeta";
                if (isset($subjects) && $subjects && $subjects->num_rows > 0) {
                    $subjects->data_seek(0);
                    while($row = $subjects->fetch_assoc()) {
                        if ((int)$row['id'] === $selected_subject) {
                            $subject_name = $row['name'];
                            break;
                        }
                    }
                    $subjects->data_seek(0);
                }
                ?>
                <i class="fas fa-chevron-right text-gray-600 text-[10px]"></i>
                <span class="text-purple-100 flex items-center gap-2 bg-purple-900/20 px-3 py-1.5 rounded-lg border border-purple-500/30 shadow-sm">
                    <i class="fas fa-folder-open text-purple-400"></i> <?= htmlspecialchars($subject_name) ?>
                </span>
            <?php endif; ?>
        </nav>

        <!-- Right Actions -->
        <div class="flex items-center gap-4">
            <div class="relative hidden sm:block">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-xs"></i>
                <input type="text" placeholder="Brza pretraga..." class="bg-gray-800 border border-gray-700 text-gray-300 text-sm rounded-full pl-9 pr-4 py-1.5 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 w-64 placeholder-gray-600">
            </div>
            <div class="relative">
                <button id="notificationBell" class="relative p-2 text-gray-400 hover:text-white transition">
                    <i class="fas fa-bell <?= isset($unread_count) && $unread_count > 0 ? 'text-white drop-shadow-[0_0_8px_rgba(255,255,255,0.5)]' : '' ?>" id="bellIcon"></i>
                    <?php if(isset($unread_count) && $unread_count > 0): ?>
                    <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5" id="bellNotificationDotContainer">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border border-gray-900" id="bellNotificationDot"></span>
                    </span>
                    <?php endif; ?>
                </button>
                
                <!-- Dropdown meni -->
                <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl z-[9999] overflow-hidden transform scale-95 opacity-0 transition-all duration-200 origin-top-right">
                    <div class="p-3 border-b border-gray-700 bg-gray-800/80 flex justify-between items-center">
                        <span class="font-bold text-white text-sm">Obavještenja</span>
                        <div class="flex items-center gap-2">
                            <?php if(isset($unread_count) && $unread_count > 0): ?>
                            <button type="button" onclick="markAllNotificationsRead()" class="text-xs text-purple-400 hover:text-purple-300 transition-colors bg-purple-500/10 px-2 py-1 rounded-md border border-purple-500/30 flex items-center gap-1" id="markAllReadBtn" title="Označi sve kao pročitano">
                                <i class="fas fa-check-double"></i> <span class="hidden sm:inline">Pročitano</span>
                            </button>
                            <span class="bg-red-500/20 text-red-400 text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-full font-bold" id="unreadBadge"><?= $unread_count ?> novo</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="max-h-80 overflow-y-auto custom-scrollbar">
                        <div id="notificationList" class="flex flex-col p-1.5 gap-1">
                        <?php if(!empty($recent_notifications)): ?>
                            <?php foreach($recent_notifications as $notif): 
                                $is_read = !is_null($notif['is_read']);
                                $type = $notif['type'] ?? 'info';
                                $icon = 'fa-bell text-purple-400';
                                $bgIcon = 'bg-purple-500/20 border-purple-500/30';
                                if ($type === 'warning') { $icon = 'fa-exclamation-triangle text-yellow-400'; $bgIcon = 'bg-yellow-500/20 border-yellow-500/30'; }
                                elseif ($type === 'urgent') { $icon = 'fa-exclamation-circle text-red-400'; $bgIcon = 'bg-red-500/20 border-red-500/30 shadow-[0_0_10px_rgba(239,68,68,0.5)] animate-pulse'; }
                            ?>
                            <div class="px-3 py-2.5 rounded-lg transition-all cursor-pointer flex gap-3 <?= $is_read ? 'opacity-70 hover:bg-gray-700' : 'bg-gray-700/40 hover:bg-gray-700/60' ?>" data-notif='<?= htmlspecialchars(json_encode($notif, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG), ENT_QUOTES, "UTF-8") ?>' onclick="openNotification(this)">
                                <div class="w-10 h-10 rounded-full <?= $bgIcon ?> border flex items-center justify-center flex-shrink-0">
                                    <i class="fas <?= $icon ?>"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-200 truncate <?= $is_read ? '' : 'font-bold' ?>"><?= !empty($notif['title']) ? htmlspecialchars($notif['title']) : htmlspecialchars($notif['message']) ?></p>
                                    <p class="text-xs text-gray-500 mt-1 truncate">
                                        <?= !empty($notif['title']) ? htmlspecialchars($notif['message']) . ' • ' : '' ?><?= date('d.m.Y H:i', strtotime($notif['created_at'])) ?>
                                    </p>
                                </div>
                                <?php if(!$is_read): ?>
                                <div class="w-2 h-2 bg-blue-500 rounded-full self-center flex-shrink-0 unread-indicator shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-6 text-center text-gray-500">
                                <i class="fas fa-bell-slash text-3xl mb-2 opacity-50"></i>
                                <p class="text-sm">Nemate novih obavještenja</p>
                            </div>
                        <?php endif; ?>
                        </div>
                        <?php if(count($recent_notifications) == 10): ?>
                        <div class="p-2 text-center border-t border-gray-700/50" id="loadMoreNotifsContainer">
                            <button type="button" onclick="loadMoreNotifications()" class="text-xs text-purple-400 hover:text-white transition-colors bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 w-full font-medium">Učitaj još...</button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-8 scroll-smooth pb-24 sm:pb-8">
    <div class="max-w-7xl mx-auto space-y-8">

    <?php if(!$selected_subject): ?>
      <?php if($is_student): ?>
      <!-- Prikaz predmeta kao kartice (Student Dashboard) -->
      <div class="animate-fadeIn">
          <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2"><i class="fas fa-layer-group text-purple-400"></i> Moji predmeti</h2>
          
          <?php if($subjects && $subjects->num_rows > 0): ?>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php 
            $subjects->data_seek(0);
            while($row = $subjects->fetch_assoc()): 
            ?>
            <div onclick="window.location.href='index.php?subject=<?= (int)$row['id'] ?>'" class="glass-card p-7 rounded-2xl cursor-pointer card-hover group relative overflow-hidden flex items-center justify-between">
                <div class="absolute -right-6 -top-6 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fas fa-book text-8xl text-purple-500 transform rotate-12"></i>
                </div>
                <div class="flex items-center gap-5 z-10">
                    <div class="w-16 h-16 rounded-2xl bg-gray-800 border border-gray-700 flex items-center justify-center text-purple-400 group-hover:bg-purple-600 group-hover:text-white transition-colors shadow-lg flex-shrink-0">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-white leading-tight group-hover:text-purple-300 transition-colors mb-1"><?= htmlspecialchars($row['name']) ?></h3>
                        <span class="text-sm text-gray-500 group-hover:text-gray-400 transition-colors">Klikni za pregled</span>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-purple-500 to-pink-500 w-0 group-hover:w-full transition-all duration-500"></div>
            </div>
            <?php endwhile; ?>
          </div>
          <?php else: ?>
          <div class="text-center py-12 glass-card rounded-2xl">
            <i class="fas fa-book-open text-gray-600 text-4xl mb-3"></i>
            <p class="text-gray-500 text-sm italic ml-2">Nema dodijeljenih predmeta.</p>
          </div>
          <?php endif; ?>
      </div>
    <?php else: ?>
    <!-- ADMIN DASHBOARD STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 animate-fadeIn">
      <div class="glass-card p-6 rounded-2xl border-l-4 border-purple-500">
        <p class="text-gray-400 text-sm">Ukupno admina</p>
        <p class="text-3xl font-bold text-purple-300"><?= isset($stats['admins']) ? $stats['admins'] : 0 ?></p>
      </div>
      <div class="glass-card p-6 rounded-2xl border-l-4 border-pink-500">
        <p class="text-gray-400 text-sm">Ukupno učenika</p>
        <p class="text-3xl font-bold text-pink-300"><?= isset($stats['students']) ? $stats['students'] : 0 ?></p>
      </div>
      <div class="glass-card p-6 rounded-2xl border-l-4 border-blue-500">
        <p class="text-gray-400 text-sm">Ukupno predmeta</p>
        <p class="text-3xl font-bold text-blue-300"><?= isset($stats['subjects']) ? $stats['subjects'] : 0 ?></p>
      </div>
      <div class="glass-card p-6 rounded-2xl border-l-4 border-cyan-500">
        <p class="text-gray-400 text-sm">Ukupno materijala</p>
        <p class="text-3xl font-bold text-cyan-300"><?= isset($stats['files']) ? $stats['files'] : 0 ?></p>
      </div>
      <div class="glass-card p-6 rounded-2xl border-l-4 border-teal-500">
        <p class="text-gray-400 text-sm">Ukupno testova</p>
        <p class="text-3xl font-bold text-teal-300"><?= isset($stats['tests']) ? $stats['tests'] : 0 ?></p>
      </div>
      <div class="glass-card p-6 rounded-2xl border-l-4 border-green-500">
        <p class="text-gray-400 text-sm">Predati radovi</p>
        <p class="text-3xl font-bold text-green-300"><?= isset($stats['works']) ? $stats['works'] : 0 ?></p>
      </div>
    </div>

    <div class="glass-card p-6 sm:p-8 rounded-2xl animate-fadeIn mt-6" style="animation-delay: 0.1s">
      <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
        <h2 class="text-xl sm:text-2xl font-semibold text-white">Pregled administratora</h2>
        <div class="flex flex-wrap justify-center sm:justify-end gap-2 w-full sm:w-auto items-center">
            <div class="relative w-full sm:w-auto">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" id="adminSearchInput" placeholder="Pretraži administratore..." class="w-full sm:w-64 bg-gray-900 text-white pl-10 pr-4 py-2.5 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 text-sm">
            </div>
        </div>
      </div>
      <?php if(isset($admin_overview) && $admin_overview && $admin_overview->num_rows > 0): ?>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-gray-600 text-gray-300">
              <th class="p-3">Admin</th>
              <th class="p-3">Učenici</th>
              <th class="p-3">Predmeti</th>
              <th class="p-3">Tip</th>
              <th class="p-3"></th>
            </tr>
          </thead>
          <tbody id="adminTableBody">
            <?php $admin_overview->data_seek(0); while($adminRow = $admin_overview->fetch_assoc()): ?>
            <tr class="border-b border-gray-700 hover:bg-gray-700/60 transition admin-table-row">
              <td class="p-3 admin-username-cell font-medium text-gray-200"><?= htmlspecialchars($adminRow['username']) ?></td>
              <td class="p-3 text-gray-300"><?= (int)$adminRow['student_count'] ?></td>
              <td class="p-3 text-gray-300"><?= (int)$adminRow['subject_count'] ?></td>
              <td class="p-3">
                <?php if((int)$adminRow['id'] === (int)$_SESSION['user_id']): ?>
                  <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded text-xs font-bold border border-yellow-500/30">Master</span>
                <?php else: ?>
                  <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded text-xs font-bold border border-blue-500/30">Admin</span>
                <?php endif; ?>
              </td>
              <td class="p-3 text-right">
                <?php if((int)$adminRow['id'] !== (int)$_SESSION['user_id']): ?>
                  <button onclick="openNotificationModalFor(<?= $adminRow['id'] ?>, '<?= htmlspecialchars($adminRow['username'], ENT_QUOTES) ?>')" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white transition p-2 rounded-lg border border-purple-500/30" title="Pošalji obavještenje"><i class="fas fa-paper-plane"></i></button>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
            <tr id="adminSearchEmpty" class="hidden">
              <td colspan="5" class="p-8 text-center text-gray-500 text-sm italic">
                <i class="fas fa-search text-2xl mb-2 block opacity-40"></i>
                Nema administratora koji odgovaraju pretrazi.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <p class="text-gray-500 text-sm italic ml-2">Nema dostupnih podataka o administratorima.</p>
      <?php endif; ?>
    </div>
    
    <div class="glass-card p-6 sm:p-8 rounded-2xl animate-fadeIn mt-6" style="animation-delay: 0.2s">
      <h2 class="text-xl sm:text-2xl font-semibold text-white mb-4">Korisnici (globalni pregled)</h2>
      <?php if(isset($users) && is_object($users) && $users->num_rows > 0): ?>
      <?php $users->data_seek(0); ?>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-gray-600 text-gray-300">
              <th class="p-3">Korisničko ime</th>
              <th class="p-3">Uloga</th>
              <th class="p-3">Kreirao</th>
            </tr>
          </thead>
          <tbody id="globalUsersList">
            <?php while($u = $users->fetch_assoc()): ?>
            <tr class="border-b border-gray-700 hover:bg-gray-700/60 transition">
              <td class="p-3 text-gray-200"><?= htmlspecialchars($u['username']) ?></td>
              <td class="p-3 text-gray-300"><?= $u['role']==='student' ? 'Učenik' : 'Admin' ?></td>
              <td class="p-3 text-gray-400"><?= htmlspecialchars($u['created_by'] ?? 'Nepoznato') ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <?php if($users->num_rows == 20): ?>
        <div class="p-3 text-center border-t border-gray-700 mt-2" id="loadMoreUsersContainer">
            <button type="button" onclick="loadMoreUsers()" class="text-xs text-purple-400 hover:text-white transition-colors bg-gray-800 border border-gray-700 rounded-lg px-6 py-2.5 font-medium">Učitaj još...</button>
        </div>
        <?php endif; ?>
      </div>
      <?php else: ?>
      <p class="text-gray-500 text-sm italic ml-2">Nema korisnika za prikaz.</p>
      <?php endif; ?>
    </div>

    <?php endif; ?>
    <?php else: ?>

    <div class="glass-card p-4 sm:p-8 rounded-2xl flex flex-col gap-6 animate-fadeIn">
      <div class="flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0 border-b border-gray-700 pb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-white text-center sm:text-left flex items-center gap-3"><i class="fas fa-folder-open text-purple-400"></i> Materijali</h2>
        <?php if($is_admin): ?>
        <div class="flex gap-3">
          <form method="post" class="flex gap-2 items-center">
            <input type="hidden" name="new_section" value="1">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="text" id="sectionInput" name="section_name" placeholder="Nova sekcija..." class="bg-gray-900 text-white rounded-xl text-sm transition-all duration-300 w-0 p-0 border-none opacity-0 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500" required>
            <button type="button" id="cancelSectionBtn" onclick="cancelSectionInput(event)" class="hidden text-gray-400 hover:text-red-400 transition-colors w-8 h-8 flex items-center justify-center rounded-lg" title="Otkaži"><i class="fas fa-times"></i></button>
            <button type="button" id="sectionBtn" onclick="toggleSectionInput(this, event)" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-purple-500/30" title="Dodaj sekciju"><i class="fas fa-folder-plus"></i></button>
          </form>
          <button id="openUpload" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-purple-500/30" title="Dodaj materijal"><i class="fas fa-upload"></i></button>
        </div>
        <?php endif; ?>
      </div>
      <?php if(!empty($general_files) || !empty($sections)): ?>
      <ul class="space-y-2">
        <!-- General Files -->
        <?php if(!empty($general_files)): ?>
            <li class="text-gray-400 uppercase text-xs font-bold tracking-wider mt-4 mb-1">Opšte</li>
            <?php foreach($general_files as $file): ?>
        <li class="flex flex-col sm:flex-row sm:items-center justify-between p-3 sm:px-4 rounded-xl bg-gray-800/50 border border-gray-700/50 hover:bg-gray-800 hover:border-gray-600 transition-all gap-2 group">
          <?php
            $ext = strtolower(pathinfo($file['filename'], PATHINFO_EXTENSION));
            $iconClass = 'fa-file';
            $iconColor = 'text-gray-400';
            switch($ext) {
                case 'pdf': $iconClass = 'fa-file-pdf'; $iconColor = 'text-red-400'; break;
                case 'doc': case 'docx': $iconClass = 'fa-file-word'; $iconColor = 'text-blue-400'; break;
                case 'xls': case 'xlsx': $iconClass = 'fa-file-excel'; $iconColor = 'text-green-400'; break;
                case 'ppt': case 'pptx': $iconClass = 'fa-file-powerpoint'; $iconColor = 'text-orange-400'; break;
                case 'jpg': case 'jpeg': case 'png': case 'gif': $iconClass = 'fa-file-image'; $iconColor = 'text-purple-400'; break;
                case 'zip': case 'rar': $iconClass = 'fa-file-archive'; $iconColor = 'text-yellow-400'; break;
                case 'txt': $iconClass = 'fa-file-alt'; $iconColor = 'text-gray-300'; break;
            }
          ?>
          <div class="flex items-center justify-center sm:justify-start gap-3 w-full sm:w-auto mb-3 sm:mb-0">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gray-900/50 border border-gray-700/50 flex items-center justify-center flex-shrink-0">
                <i class="fas <?= $iconClass ?> <?= $iconColor ?> text-base sm:text-lg"></i>
            </div>
            <span class="text-gray-200 font-medium text-sm sm:text-base truncate leading-tight text-center sm:text-left"><?= htmlspecialchars(pathinfo($file['filename'], PATHINFO_FILENAME)) ?></span>
          </div>
          <div class="flex items-center justify-center sm:justify-end gap-2 w-full sm:w-auto sm:opacity-0 group-hover:opacity-100 transition-opacity mt-2 sm:mt-0 flex-wrap">
            <a href="<?= htmlspecialchars($file['filepath']) ?>" target="_blank" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium flex items-center justify-center gap-2 w-full sm:w-auto order-first sm:order-none" title="Preuzmi"><i class="fas fa-download"></i> <span>Preuzmi</span></a>
            <?php if($is_admin): ?>
                        <button onclick='openRenameFileModal(<?= $file['id'] ?>, <?= htmlspecialchars(json_encode($file['filename']), ENT_QUOTES, "UTF-8") ?>)' class="bg-cyan-600/20 text-cyan-400 hover:bg-cyan-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Preimenuj"><i class="fas fa-edit"></i></button>
            <button onclick="openMoveModal('file', <?= $file['id'] ?>, <?= $file['section_id'] ?? 0 ?>)" class="bg-yellow-600/20 text-yellow-400 hover:bg-yellow-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Premjesti"><i class="fas fa-exchange-alt"></i></button>
            <button onclick="showDeleteModal('file', <?= $file['id'] ?>, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Obriši"><i class="fas fa-trash-alt"></i></button>
            <?php endif; ?>
          </div>
        </li>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Sections -->
        <?php foreach($sections as $sec): ?>
            <li>
                <div class="text-gray-400 uppercase text-xs font-bold tracking-wider mt-4 mb-3 flex justify-between items-center group cursor-pointer select-none" onclick="toggleSection('sec-files-<?= $sec['id'] ?>', this)">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                        <span><?= htmlspecialchars($sec['name']) ?></span>
                    </div>
                <?php if($is_admin): ?>
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity items-center" onclick="event.stopPropagation()">
                        <button onclick='openRenameSectionModal(<?= $sec['id'] ?>, <?= htmlspecialchars(json_encode($sec['name']), ENT_QUOTES, "UTF-8") ?>)' class="text-blue-400 hover:text-blue-300 p-1.5 rounded-lg hover:bg-gray-700 transition"><i class="fas fa-edit text-sm"></i></button>
                        <button onclick="showDeleteModal('section', <?= $sec['id'] ?>, <?= $selected_subject ?>)" class="text-red-400 hover:text-red-300 p-1.5 rounded-lg hover:bg-gray-700 transition"><i class="fas fa-trash-alt text-sm"></i></button>
                    </div>
                <?php endif; ?>
                </div>
                <ul id="sec-files-<?= $sec['id'] ?>" class="space-y-2">
            <?php if(empty($files_by_section[$sec['id']])): ?>
                <li class="text-gray-500 text-sm italic ml-2">Nema materijala u ovoj sekciji.</li>
            <?php else: ?>
                <?php foreach($files_by_section[$sec['id']] as $file): ?>
                    <li class="flex flex-col sm:flex-row sm:items-center justify-between p-3 sm:px-4 rounded-xl bg-gray-800/50 border border-gray-700/50 hover:bg-gray-800 hover:border-gray-600 transition-all gap-2 sm:gap-3 group">
                      <?php
                        $ext = strtolower(pathinfo($file['filename'], PATHINFO_EXTENSION));
                        $iconClass = 'fa-file';
                        $iconColor = 'text-gray-400';
                        switch($ext) {
                            case 'pdf': $iconClass = 'fa-file-pdf'; $iconColor = 'text-red-400'; break;
                            case 'doc': case 'docx': $iconClass = 'fa-file-word'; $iconColor = 'text-blue-400'; break;
                            case 'xls': case 'xlsx': $iconClass = 'fa-file-excel'; $iconColor = 'text-green-400'; break;
                            case 'ppt': case 'pptx': $iconClass = 'fa-file-powerpoint'; $iconColor = 'text-orange-400'; break;
                            case 'jpg': case 'jpeg': case 'png': case 'gif': $iconClass = 'fa-file-image'; $iconColor = 'text-purple-400'; break;
                            case 'zip': case 'rar': $iconClass = 'fa-file-archive'; $iconColor = 'text-yellow-400'; break;
                            case 'txt': $iconClass = 'fa-file-alt'; $iconColor = 'text-gray-300'; break;
                        }
                      ?>
                      <div class="flex items-center justify-center sm:justify-start gap-3 w-full sm:w-auto mb-3 sm:mb-0">
                        <div class="w-10 h-10 rounded-lg bg-gray-900/50 border border-gray-700/50 flex items-center justify-center flex-shrink-0">
                            <i class="fas <?= $iconClass ?> <?= $iconColor ?> text-lg"></i>
                        </div>
                        <span class="text-gray-200 font-medium text-sm sm:text-base break-words leading-tight text-center sm:text-left"><?= htmlspecialchars(pathinfo($file['filename'], PATHINFO_FILENAME)) ?></span>
                      </div>
                      <div class="flex items-center justify-center sm:justify-end gap-2 w-full sm:w-auto sm:opacity-0 group-hover:opacity-100 transition-opacity mt-2 sm:mt-0 flex-wrap">
                        <a href="<?= htmlspecialchars($file['filepath']) ?>" target="_blank" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium flex items-center justify-center gap-2 w-full sm:w-auto order-first sm:order-none" title="Preuzmi"><i class="fas fa-download"></i> <span>Preuzmi</span></a>
                        <?php if($is_admin): ?>
                        <button onclick='openRenameFileModal(<?= $file['id'] ?>, <?= htmlspecialchars(json_encode($file['filename']), ENT_QUOTES, "UTF-8") ?>)' class="bg-cyan-600/20 text-cyan-400 hover:bg-cyan-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Preimenuj"><i class="fas fa-edit"></i></button>
                        <button onclick="openMoveModal('file', <?= $file['id'] ?>, <?= $file['section_id'] ?? 0 ?>)" class="bg-yellow-600/20 text-yellow-400 hover:bg-yellow-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Premjesti"><i class="fas fa-exchange-alt"></i></button>
                        <button onclick="showDeleteModal('file', <?= $file['id'] ?>, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Obriši"><i class="fas fa-trash-alt"></i></button>
                        <?php endif; ?>
                      </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
                </ul>
            </li>
        <?php endforeach; ?>
      </ul>
      <?php else: ?>
      <p class="text-gray-500 text-sm italic ml-2">Nema materijala za ovaj predmet.</p>
      <?php endif; ?>
    </div>

    <div class="glass-card p-4 sm:p-8 rounded-2xl flex flex-col gap-6 animate-fadeIn" style="animation-delay: 0.1s">
      <div class="flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0 border-b border-gray-700 pb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-white text-center sm:text-left flex items-center gap-3"><i class="fas fa-file-signature text-purple-400"></i> Testovi</h2>
      </div>
      <?php if(!empty($general_tests)): ?>
      <ul class="space-y-2">
            <?php foreach($general_tests as $test): ?>
        <li class="flex flex-col sm:flex-row sm:items-center justify-between p-3 sm:px-4 rounded-xl bg-gray-800/50 border border-gray-700/50 hover:bg-gray-800 hover:border-gray-600 transition-all gap-2 group">
          <?php
          $extension = strtolower(pathinfo($test['filename'], PATHINFO_EXTENSION));
          $name_without_ext = pathinfo($test['filepath'], PATHINFO_FILENAME); // Use filepath to get the stored name with timestamp
          $isHidden = isset($test['hidden']) && $test['hidden'] == 1;
          $eyeIcon = $isHidden ? 'fa-eye' : 'fa-eye-slash';
          $eyeText = $isHidden ? 'Prikaži test' : 'Sakrij test';
          $eyeClass = $isHidden ? 'bg-yellow-600 hover:bg-yellow-500' : 'bg-gray-600 hover:bg-gray-500';
          ?>
          <div class="flex items-center justify-center sm:justify-start gap-3 w-full sm:w-auto mb-3 sm:mb-0">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-purple-500/10 border border-purple-500/20 flex items-center justify-center flex-shrink-0 text-purple-400 shadow-[0_0_10px_rgba(168,85,247,0.1)]">
                <i class="fas fa-clipboard-check text-base sm:text-lg"></i>
            </div>
            <div class="text-gray-200 font-medium text-sm sm:text-base leading-tight flex flex-col sm:flex-row sm:items-center min-w-0 text-center sm:text-left">
              <span class="truncate"><?= htmlspecialchars(pathinfo($test['filename'], PATHINFO_FILENAME)) ?></span>
              <?php if($isHidden && $is_admin): ?>
                <span class="text-xs text-yellow-400 border border-yellow-400 px-1 rounded w-fit mt-1 sm:mt-0 sm:ml-2 mx-auto sm:mx-0">Sakriven</span>
              <?php endif; ?>
            </div>
          </div>
          <div class="flex items-center justify-center sm:justify-end gap-2 w-full sm:w-auto flex-wrap sm:opacity-0 group-hover:opacity-100 transition-opacity mt-2 sm:mt-0">
            <?php if($is_admin && $extension === 'html'): ?>
              <a href="index.php?route=download_test_answers&test_id=<?= $test['id'] ?>&test_name=<?= urlencode($name_without_ext) ?>&subject_id=<?= $selected_subject ?>" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Odgovori"><i class="fas fa-file-archive"></i></a>
            <?php endif; ?>
            <?php if($is_admin): ?>
              <a href="edit_test.php?id=<?= $test['id'] ?>" class="bg-cyan-600/20 text-cyan-400 hover:bg-cyan-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Uredi test"><i class="fas fa-edit"></i></a>
              <a href="?route=student&toggle_test_visibility=<?= $test['id'] ?>&subject=<?= $selected_subject ?>" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="<?= $eyeText ?>"><i class="fas <?= $eyeIcon ?>"></i></a>
              <button onclick="showDeleteModal('test', <?= $test['id'] ?>, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Obriši"><i class="fas fa-trash-alt"></i></button>
            <?php endif; ?>
            <?php 
                $isDbTest = isset($test['is_db_test']) && $test['is_db_test'] == 1;
                $testUrl = $isDbTest ? "index.php?route=take_test&id=" . $test['id'] . "&v=" . time() : htmlspecialchars($test['filepath']) . "?v=" . time();
            ?>
            <?php if($isDbTest || $extension === 'html'): ?>
            <a href="<?= $testUrl ?>" target="_blank" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium flex items-center justify-center gap-2 w-full sm:w-auto order-first sm:order-none"><i class="fas fa-play-circle"></i> <span>Pokreni test</span></a>
            <?php else: ?>
            <a href="<?= $testUrl ?>" target="_blank" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium flex items-center justify-center gap-2 w-full sm:w-auto order-first sm:order-none"><i class="fas fa-download"></i> <span>Preuzmi</span></a>
            <?php endif; ?>
          </div>
        </li>
            <?php endforeach; ?>
      </ul>
      <?php else: ?>
      <p class="text-gray-500 text-sm italic ml-2">Nema testova za ovaj predmet.</p>
      <?php endif; ?>
    </div>

    <?php if($is_student): ?>
    <div class="glass-card p-6 sm:p-8 rounded-2xl flex flex-col gap-6 animate-fadeIn" style="animation-delay: 0.2s">
      <div class="border-b border-gray-700 pb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-white text-center sm:text-left flex items-center gap-3"><i class="fas fa-inbox text-purple-400"></i> Predaja radova</h2>
      </div>
      <div class="flex flex-col items-center justify-center gap-6 py-4">
        <div class="opacity-20">
          <i class="fas fa-cloud-upload-alt text-9xl text-purple-500"></i>
        </div>
        <button id="openStudentWorkModal" class="btn-gradient text-white px-6 py-2 rounded-lg btn-hover text-base font-semibold border border-purple-500 shadow-lg flex items-center gap-2">
          <i class="fas fa-paper-plane"></i> Predaj rad
        </button>
      </div>
    </div>
    <?php else: ?>
    <div class="glass-card p-6 sm:p-8 rounded-2xl flex flex-col gap-6 animate-fadeIn" style="animation-delay: 0.2s">
      <div class="flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0 border-b border-gray-700 pb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-white text-center sm:text-left flex items-center gap-3"><i class="fas fa-user-graduate text-purple-400"></i> Radovi učenika</h2>
        <div class="flex gap-3">
          <a href="index.php?download_all_works=1&subject=<?= $selected_subject ?>" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-purple-500/30" title="Preuzmi sve"><i class="fas fa-file-archive"></i></a>
          <button onclick="showDeleteModal('all_works', null, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-red-500/30" title="Obriši sve"><i class="fas fa-trash-alt"></i></button>
        </div>
      </div>
      <?php if($student_works && $student_works->num_rows > 0): ?>
      <ul class="space-y-2">
        <?php while($work = $student_works->fetch_assoc()): ?>
        <li class="flex flex-col sm:flex-row sm:items-center justify-between p-3 sm:px-4 rounded-xl bg-gray-800/50 border border-gray-700/50 hover:bg-gray-800 hover:border-gray-600 transition-all gap-2 group">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-pink-500/20 text-pink-400 flex items-center justify-center flex-shrink-0 border border-pink-500/30">
                <i class="fas fa-file-contract text-lg"></i>
            </div>
            <div class="text-gray-200 text-sm sm:text-base leading-tight break-all">
              <span class="font-medium"><?= htmlspecialchars($work['filename']) ?></span>
              <div class="text-xs text-gray-500 mt-1"><i class="fas fa-user text-gray-600 mr-1"></i> <?= htmlspecialchars($work['username']) ?> &bull; <?= date('d.m.Y H:i', strtotime($work['uploaded_at'])) ?></div>
            </div>
          </div>
          <div class="flex gap-2 sm:opacity-0 group-hover:opacity-100 transition-opacity mt-2 sm:mt-0 items-center justify-end">
            <a href="index.php?subject=<?= $selected_subject ?>&download_work=<?= $work['id'] ?>" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Preuzmi"><i class="fas fa-download"></i></a>
            <button onclick="showDeleteModal('work', <?= $work['id'] ?>, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Obriši"><i class="fas fa-trash-alt"></i></button>
          </div>
        </li>
        <?php endwhile; ?>
      </ul>
      <?php else: ?>
      <p class="text-gray-500 text-sm italic ml-2">Nema radova za ovaj predmet.</p>
      <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php endif; // end of if(!$selected_subject) else ?>
    </div>
  </main>
  </div> <!-- End Main Flex Col -->
</div> <!-- End Page Flex -->

<!-- Modal Upload -->
<?php if($is_admin && $selected_subject > 0): ?>
<div id="uploadModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/0 backdrop-blur-sm transition-all duration-300">
  <div id="uploadContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-lg mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center shadow-lg shadow-purple-500/20">
                <i class="fas fa-cloud-upload-alt text-white text-sm"></i>
            </div>
            Dodaj materijal
        </h2>
        <button type="button" id="closeUpload" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <form id="uploadForm" method="post" enctype="multipart/form-data" class="flex flex-col gap-5">
      <input type="hidden" name="upload_file" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      
      <?php if(!empty($sections)): ?>
      <div class="relative">
          <label class="block text-gray-400 text-xs font-bold uppercase tracking-wider mb-2 ml-1">Sekcija (Opcionalno)</label>
          <select name="section_id" class="w-full bg-gray-900 text-white pl-4 pr-10 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none appearance-none transition-all cursor-pointer">
            <option value="">📂 Opšte (bez sekcije)</option>
            <?php foreach($sections as $sec): ?>
                <option value="<?= $sec['id'] ?>">📁 <?= htmlspecialchars($sec['name']) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="pointer-events-none absolute bottom-0 right-0 top-6 flex items-center px-4 text-gray-400">
            <i class="fas fa-chevron-down text-xs"></i>
          </div>
      </div>
      <?php endif; ?>

      <div id="dropZone" class="relative group border-2 border-dashed border-gray-600 bg-gray-900/50 rounded-xl p-8 text-center cursor-pointer hover:border-purple-500 hover:bg-gray-800/80 transition-all duration-300">
        <div id="uploadPrompt" class="flex flex-col items-center gap-3">
            <div class="w-16 h-16 rounded-full bg-gray-800 group-hover:bg-gray-700 flex items-center justify-center transition-colors mb-2 border border-gray-700 group-hover:border-purple-500/30">
                <i class="fas fa-file-import text-3xl text-gray-500 group-hover:text-purple-400 transition-colors"></i>
            </div>
            <p class="text-gray-300 font-medium group-hover:text-white transition-colors text-lg">Klikni ili prevuci fajl</p>
            <p class="text-gray-500 text-sm">Podržani formati: PDF, DOCX, ZIP, slike...</p>
            <div class="mt-2 px-3 py-1 bg-gray-800 rounded text-xs text-gray-400 border border-gray-700">Max veličina: 10MB</div>
        </div>
        
        <div id="fileDetails" class="hidden flex flex-col items-center animate-fadeIn">
          <div class="w-16 h-16 rounded-2xl bg-purple-500/20 flex items-center justify-center mb-3 text-purple-400 border border-purple-500/30 shadow-lg shadow-purple-500/10">
            <i class="fas fa-file-alt text-3xl"></i>
          </div>
          <div class="text-white font-bold text-lg mb-1 break-all px-4" id="fileName"></div>
          <div class="text-gray-400 text-sm bg-gray-800 px-3 py-1 rounded-full border border-gray-700" id="fileSize"></div>
        </div>
        <input type="file" name="file" id="fileInput" class="hidden" required>
      </div>

      <div class="w-full bg-gray-700 rounded-full h-2 overflow-hidden hidden mt-2" id="progressContainer">
        <div class="bg-gradient-to-r from-purple-600 to-pink-500 h-2 w-0 transition-all duration-300 rounded-full shadow-[0_0_10px_rgba(168,85,247,0.5)]" id="progressBar"></div>
      </div>
      
      <div id="uploadSuccess" class="hidden bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-4 rounded-xl text-center animate-fadeIn">
        <div class="flex items-center justify-center gap-3">
          <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
            <i class="fas fa-check"></i>
          </div>
          <span class="font-bold">Fajl uspješno uploadovan!</span>
        </div>
      </div>

      <button type="submit" class="btn-gradient w-full py-3.5 rounded-xl text-white font-bold shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition-all transform hover:-translate-y-0.5 mt-2 flex items-center justify-center gap-2">
          <i class="fas fa-cloud-upload-alt"></i> Uploaduj materijal
      </button>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal Preimenuj Fajl -->
<?php if($is_admin && $selected_subject > 0): ?>
<div id="renameFileModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="renameFileContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-cyan-400">
            <i class="fas fa-edit text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Preimenuj materijal</h2>
    </div>
    <form method="post" class="flex flex-col gap-5">
      <input type="hidden" name="rename_file" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="hidden" name="file_id" id="renameFileId">
      
      <div class="space-y-2">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Novi naziv fajla</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-file-alt"></i></span>
            <input type="text" name="new_file_name" id="renameFileName" class="w-full bg-gray-900 text-white pl-10 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700 mt-2">
        <button type="button" id="closeRenameFile" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
        <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-purple-500/30">
            <i class="fas fa-save"></i> Sačuvaj
        </button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal za premještanje -->
<?php if($is_admin && $selected_subject > 0): ?>
<div id="moveModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="moveContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-yellow-400">
            <i class="fas fa-exchange-alt text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Premjesti stavku</h2>
    </div>
    <form method="post" class="flex flex-col gap-5">
      <input type="hidden" name="move_item" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="hidden" name="item_id" id="moveItemId">
      <input type="hidden" name="item_type" id="moveItemType">
      
      <div class="space-y-2">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Odaberi novu sekciju</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-folder"></i></span>
            <select name="new_section_id" id="moveSectionId" class="w-full bg-gray-900 text-white pl-10 pr-10 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none appearance-none transition-all cursor-pointer">
                <option value="">📂 Opšte (bez sekcije)</option>
                <?php foreach($sections as $sec): ?>
                    <option value="<?= $sec['id'] ?>">📁 <?= htmlspecialchars($sec['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                <i class="fas fa-chevron-down text-xs"></i>
            </div>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700 mt-2">
        <button type="button" id="closeMoveModal" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
        <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-purple-500/30">
            <i class="fas fa-save"></i> Sačuvaj
        </button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal Upload Rada Učenika -->
<?php if($is_student && $selected_subject > 0): ?>
<div id="studentWorkModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/0 backdrop-blur-sm transition-all duration-300">
  <div id="studentWorkContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-lg mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-pink-600 to-rose-600 flex items-center justify-center shadow-lg shadow-pink-500/20">
                <i class="fas fa-paper-plane text-white text-sm"></i>
            </div>
            Predaj rad
        </h2>
        <button type="button" id="closeStudentWork" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <form id="studentWorkForm" method="post" enctype="multipart/form-data" class="flex flex-col gap-5">
      <input type="hidden" name="upload_student_work" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      
      <div id="studentWorkDropZone" class="relative group border-2 border-dashed border-gray-600 bg-gray-900/50 rounded-xl p-8 text-center cursor-pointer hover:border-pink-500 hover:bg-gray-800/80 transition-all duration-300">
        <div id="studentWorkPrompt" class="flex flex-col items-center gap-3">
            <div class="w-16 h-16 rounded-full bg-gray-800 group-hover:bg-gray-700 flex items-center justify-center transition-colors mb-2 border border-gray-700 group-hover:border-pink-500/30">
                <i class="fas fa-cloud-upload-alt text-3xl text-gray-500 group-hover:text-pink-400 transition-colors"></i>
            </div>
            <p class="text-gray-300 font-medium group-hover:text-white transition-colors text-lg">Klikni ili prevuci svoj rad</p>
            <div class="mt-2 px-3 py-1 bg-gray-800 rounded text-xs text-gray-400 border border-gray-700">Max veličina: 10MB</div>
        </div>
        
        <div id="studentWorkFileDetails" class="hidden flex flex-col items-center animate-fadeIn">
          <div class="w-16 h-16 rounded-2xl bg-pink-500/20 flex items-center justify-center mb-3 text-pink-400 border border-pink-500/30 shadow-lg shadow-pink-500/10">
            <i class="fas fa-file-contract text-3xl"></i>
          </div>
          <div class="text-white font-bold text-lg mb-1 break-all px-4" id="studentWorkFileName"></div>
          <div class="text-gray-400 text-sm bg-gray-800 px-3 py-1 rounded-full border border-gray-700" id="studentWorkFileSize"></div>
        </div>
        <input type="file" name="student_work_file" id="studentWorkFileInput" class="hidden" required>
      </div>

      <div class="w-full bg-gray-700 rounded-full h-2 overflow-hidden hidden mt-2" id="studentWorkProgressContainer">
        <div class="bg-gradient-to-r from-pink-600 to-rose-500 h-2 w-0 transition-all duration-300 rounded-full shadow-[0_0_10px_rgba(236,72,153,0.5)]" id="studentWorkProgressBar"></div>
      </div>
      
      <div id="studentWorkUploadSuccess" class="hidden bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-4 rounded-xl text-center animate-fadeIn">
        <div class="flex items-center justify-center gap-3">
          <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
            <i class="fas fa-check"></i>
          </div>
          <span class="font-bold">Rad uspješno predat!</span>
        </div>
      </div>

      <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-500 hover:to-rose-500 py-3.5 rounded-xl text-white font-bold shadow-lg shadow-pink-500/20 hover:shadow-pink-500/40 transition-all transform hover:-translate-y-0.5 mt-2 flex items-center justify-center gap-2">
          <i class="fas fa-paper-plane"></i> Pošalji rad
      </button>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal Kreiraj Administratora -->
<?php if($is_admin): ?>
<div id="addAdminModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="addAdminContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-purple-400">
            <i class="fas fa-user-plus text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Novi administrator</h2>
    </div>
    <form method="post" class="flex flex-col gap-5" onsubmit="return validateAdminPassword()">
      <input type="hidden" name="new_user" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      
      <div class="space-y-2">
          <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Korisničko ime</label>
          <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-user"></i></span>
              <input type="text" name="username" placeholder="Unesite korisničko ime" class="w-full bg-gray-900 text-white pl-10 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
          </div>
      </div>
      
      <div class="space-y-2">
          <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Lozinka</label>
          <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-lock"></i></span>
              <input type="password" name="password" id="newAdminPassword" placeholder="Lozinka (min 8 karaktera)" class="w-full bg-gray-900 text-white pl-10 pr-10 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
              <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-white toggle-password transition-colors z-10" data-target="newAdminPassword">
                  <i class="fas fa-eye"></i>
              </button>
          </div>
      </div>
      
      <input type="hidden" name="role" value="admin">
      
      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700 mt-2">
          <button type="button" id="closeAddAdmin" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
          <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center justify-center gap-2 border border-purple-500/30">
              <i class="fas fa-user-plus"></i> Kreiraj
          </button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal Upravljaj Adminima -->
<?php if($is_admin): ?>
<div id="manageAdminsModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm overflow-y-auto transition-all duration-300">
  <div id="manageAdminsContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-3xl transform scale-95 opacity-0 transition-all duration-300 my-4">
    <div class="flex items-center justify-between gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-blue-400">
                <i class="fas fa-users-cog text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Upravljaj administratorima</h2>
        </div>
        <button type="button" id="openAddAdminFromManage" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-3 py-1.5 flex items-center gap-2 rounded-lg transition-colors text-sm font-medium border border-purple-500/30"><i class="fas fa-user-plus"></i> <span class="hidden sm:inline">Novi admin</span></button>
    </div>

    <div class="mb-6 flex flex-col sm:flex-row gap-3">
      <div class="relative flex-1">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
            <i class="fas fa-search"></i>
        </span>
        <input type="text" id="modalAdminSearchInput" placeholder="Pretraži administratore..." class="w-full bg-gray-900 text-white pl-10 pr-4 h-10 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 text-sm">
      </div>
      <button type="button" onclick="openNotificationModalFor('', 'Svima')" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-4 h-10 rounded-xl transition-colors text-sm font-medium border border-purple-500/30 flex items-center justify-center gap-2 whitespace-nowrap shadow-lg shadow-purple-500/10">
          <i class="fas fa-paper-plane"></i> Obavijesti sve
      </button>
      <button type="button" id="openNotificationHistoryFromManage" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white px-4 h-10 rounded-xl transition-colors text-sm font-medium border border-blue-500/30 flex items-center justify-center gap-2 whitespace-nowrap shadow-lg shadow-blue-500/10">
          <i class="fas fa-history"></i> Istorija
      </button>
    </div>

    <div class="flex flex-col gap-3 max-h-96 overflow-y-auto custom-scrollbar pr-2">
        <?php 
        $admin_query = $conn->prepare("SELECT u.id, u.username, COUNT(s.id) as student_count 
            FROM users u
            LEFT JOIN users s ON s.parent_admin_id = u.id AND s.role = 'student'
            WHERE u.parent_admin_id = ? OR u.id = ?
            GROUP BY u.id");
        $current_id = (int)$_SESSION['user_id'];
        $admin_query->bind_param("ii", $current_id, $current_id);
        $admin_query->execute();
        $admins_res = $admin_query->get_result();
        
        if ($admins_res->num_rows > 0):
          while($admin = $admins_res->fetch_assoc()): 
        ?>
          <div class="modal-admin-item bg-gray-700/50 hover:bg-gray-700 p-4 rounded-xl flex justify-between items-center transition-colors border border-gray-700/50">
            <div>
              <span class="modal-admin-username font-semibold text-white"><?= htmlspecialchars($admin['username']) ?></span>
              <span class="text-gray-400 text-sm ml-2">(<?= $admin['student_count'] ?> učenika)</span>
            </div>
            <div class="flex gap-2">
              <?php if($admin['id'] !== $current_id): ?>
              <button onclick="openNotificationModalFor(<?= $admin['id'] ?>, '<?= htmlspecialchars($admin['username'], ENT_QUOTES) ?>')" class="bg-purple-600/20 hover:bg-purple-600 text-purple-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg text-sm transition-colors border border-purple-500/30" title="Pošalji obavještenje"><i class="fas fa-paper-plane"></i></button>
              <button type="button" class="bg-blue-600/20 hover:bg-blue-600 text-blue-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg text-sm transition-colors border border-blue-500/30 btn-edit-admin" data-id="<?= $admin['id'] ?>" data-username="<?= htmlspecialchars($admin['username']) ?>" title="Izmijeni"><i class="fas fa-edit"></i></button>
              <button onclick="showDeleteModal('admin', <?= $admin['id'] ?>)" class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg text-sm transition-colors border border-red-500/30" title="Obriši"><i class="fas fa-trash-alt"></i></button>
              <?php else: ?>
              <span class="bg-yellow-600/20 text-yellow-400 border border-yellow-500/30 px-3 py-1.5 rounded-lg text-sm font-medium flex items-center gap-2"><i class="fas fa-star text-xs"></i> Vi ste</span>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile;
        else:
        ?>
          <p class="text-gray-500 text-sm italic ml-2">Nema drugih administratora.</p>
        <?php endif; ?>
        <div id="modalAdminEmptyState" class="hidden p-4 text-center text-gray-500">Nije pronađen nijedan administrator koji odgovara pretrazi.</div>
      </div>

    <div class="flex justify-end mt-6 pt-4 border-t border-gray-700">
      <button type="button" id="closeManageAdmins" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Zatvori</button>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Modal Izmijeni Administratora -->
<?php if($is_admin): ?>
<div id="editAdminModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="editAdminContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-purple-400">
            <i class="fas fa-user-edit text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Izmijeni administratora</h2>
    </div>
    <form method="post" class="flex flex-col gap-5">
      <input type="hidden" name="edit_admin" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="hidden" name="admin_id" id="edit_admin_id">
      
      <div class="space-y-2">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Korisničko ime</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-user"></i></span>
            <input type="text" name="username" id="edit_admin_username" class="w-full bg-gray-900 text-white pl-10 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
        </div>
      </div>
      
      <div class="space-y-2">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Nova lozinka <span class="text-gray-500 font-normal lowercase">(ostavi prazno ako ne mijenjaš)</span></label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-lock"></i></span>
          <input type="password" name="password" id="editAdminPassword" placeholder="Unesite novu lozinku" class="w-full bg-gray-900 text-white pl-10 pr-10 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500">
          <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-white toggle-password transition-colors z-10" data-target="editAdminPassword">
            <i class="fas fa-eye"></i>
          </button>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700">
        <button type="button" id="closeEditAdmin" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
        <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-purple-500/30">
            <i class="fas fa-save"></i> Sačuvaj izmjene
        </button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal Slanje Obavještenja -->
<?php if($is_admin): ?>
<div id="notificationModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="notificationContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center justify-between mb-4 border-b border-gray-700 pb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-yellow-400">
                <i class="fas fa-bullhorn text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-white"><span id="notifModalTitle">Pošalji obavještenje</span></h2>
        </div>
        <button type="button" id="openNotificationHistoryFromModal" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg transition-colors text-sm font-medium border border-blue-500/30 flex items-center gap-2 shadow-lg shadow-blue-500/10" title="Istorija obavijesti">
            <i class="fas fa-history"></i> <span class="hidden sm:inline">Istorija</span>
        </button>
    </div>
    <p class="text-gray-400 text-sm mb-4" id="notifModalDesc">Ova poruka će se prikazati svim ostalim administratorima na njihovoj kontrolnoj tabli.</p>
    <form method="post" class="flex flex-col gap-5">
      <input type="hidden" name="send_notification" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="hidden" name="recipient_id" id="notifRecipientId" value="">
      
      <div class="space-y-2">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Naslov (Opcionalno)</label>
        <input type="text" name="notification_title" class="w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" placeholder="Unesite naslov obavještenja...">
      </div>

      <div class="space-y-2 relative z-40">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Tip obavještenja</label>
        <input type="hidden" name="notification_type" id="notifTypeInput" value="info">
        <button type="button" id="notifTypeBtn" onclick="document.getElementById('notifTypeDropdown').classList.toggle('hidden')" class="w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 hover:border-purple-500 focus:border-purple-500 outline-none transition-all flex items-center justify-between shadow-sm cursor-pointer">
            <span class="truncate font-medium flex items-center gap-3 text-sm" id="notifTypeText">
                <i class="fas fa-info-circle text-blue-400"></i> Informacija
            </span>
            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
        </button>

        <div id="notifTypeDropdown" class="hidden absolute left-0 right-0 top-[100%] mt-2 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden animate-fadeIn z-[60]">
            <div class="flex flex-col p-1.5 gap-1">
                <button type="button" onclick="selectNotifType('info', 'Informacija', 'fa-info-circle text-blue-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                    <div class="w-5 flex justify-center"><i class="fas fa-info-circle text-blue-400"></i></div> Informacija
                </button>
                <button type="button" onclick="selectNotifType('warning', 'Upozorenje', 'fa-exclamation-triangle text-yellow-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                    <div class="w-5 flex justify-center"><i class="fas fa-exclamation-triangle text-yellow-400"></i></div> Upozorenje
                </button>
                <button type="button" onclick="selectNotifType('urgent', 'Hitno', 'fa-exclamation-circle text-red-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                    <div class="w-5 flex justify-center"><i class="fas fa-exclamation-circle text-red-400"></i></div> Hitno
                </button>
            </div>
        </div>
      </div>

      <div class="space-y-2">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Tekst poruke</label>
        <textarea name="notification_message" rows="4" class="w-full bg-gray-900 text-white p-4 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all resize-none placeholder-gray-500" placeholder="Unesite tekst obavještenja..." required></textarea>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700">
        <button type="button" id="closeNotificationModal" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Zatvori</button>
        <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-purple-500/30">
            <i class="fas fa-paper-plane"></i> Pošalji
        </button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal Istorija Obavještenja -->
<?php if($is_admin): ?>
<div id="notificationHistoryModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="notificationHistoryContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-4xl transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] flex flex-col my-4">
    <div class="flex items-center justify-between gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-blue-400">
                <i class="fas fa-history text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Istorija obavještenja</h2>
        </div>
        <button type="button" id="closeNotificationHistory" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-3 py-1.5 flex items-center gap-2 rounded-lg transition-colors text-sm font-medium"><i class="fas fa-arrow-left"></i> Nazad</button>
    </div>
    
    <div class="overflow-y-auto flex-1 custom-scrollbar pr-2">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-700 text-gray-400 text-sm sticky top-0 bg-gray-800">
                    <th class="p-3">Datum</th>
                    <th class="p-3">Tip</th>
                    <th class="p-3">Primalac</th>
                    <th class="p-3">Poruka</th>
                    <th class="p-3 text-right">Akcija</th>
                </tr>
            </thead>
            <tbody class="text-sm" id="notificationHistoryList">
                <?php if($notification_history && $notification_history->num_rows > 0): ?>
                    <?php while($notif = $notification_history->fetch_assoc()): ?>
                        <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition">
                            <td class="p-3 whitespace-nowrap text-gray-400"><?= date('d.m.Y H:i', strtotime($notif['created_at'])) ?></td>
                            <td class="p-3">
                                <?php 
                                    $typeClass = 'text-blue-400';
                                    $typeIcon = 'fa-info-circle';
                                    if($notif['type'] === 'warning') { $typeClass = 'text-yellow-400'; $typeIcon = 'fa-exclamation-triangle'; }
                                    if($notif['type'] === 'urgent') { $typeClass = 'text-red-400'; $typeIcon = 'fa-exclamation-circle'; }
                                ?>
                                <span class="<?= $typeClass ?>"><i class="fas <?= $typeIcon ?> mr-1"></i> <?= ucfirst($notif['type']) ?></span>
                            </td>
                            <td class="p-3">
                                <?php if($notif['recipient_id']): ?>
                                    <span class="text-white bg-gray-700 px-2 py-1 rounded text-xs"><i class="fas fa-user mr-1"></i> <?= htmlspecialchars($notif['recipient_name']) ?></span>
                                <?php else: ?>
                                    <span class="text-green-400 bg-green-900/30 px-2 py-1 rounded text-xs"><i class="fas fa-users mr-1"></i> Svi admini</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-3 text-gray-300 max-w-md">
                                <?php if(!empty($notif['title'])): ?><strong class="text-white block truncate"><?= htmlspecialchars($notif['title']) ?></strong><?php endif; ?>
                                <span class="truncate block text-sm"><?= htmlspecialchars($notif['message']) ?></span>
                            </td>
                            <td class="p-3 text-right">
                                <button onclick="showDeleteModal('notification', <?= $notif['id'] ?>)" class="text-red-400 hover:text-red-300 p-1.5 rounded-lg hover:bg-gray-700 transition" title="Obriši obavještenje">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500 text-sm italic">Nema poslatih obavještenja.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if($history_count == 20): ?>
        <div class="p-3 text-center border-t border-gray-700 mt-2" id="loadMoreHistoryContainer">
            <button type="button" onclick="loadMoreHistory()" class="text-xs text-purple-400 hover:text-white transition-colors bg-gray-800 border border-gray-700 rounded-lg px-6 py-2.5 font-medium">Učitaj još...</button>
        </div>
        <?php endif; ?>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- COMMAND PALETTE (Ctrl + K) -->
<div id="commandPalette" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden items-start justify-center pt-[15vh] transition-all duration-200">
    <div class="bg-gray-800 w-full max-w-2xl rounded-xl shadow-2xl border border-gray-700 overflow-hidden transform scale-95 transition-all duration-200" id="commandPaletteContent">
        <div class="p-4 border-b border-gray-700 flex items-center gap-3">
            <i class="fas fa-search text-gray-400 text-lg"></i>
            <input type="text" id="commandInput" placeholder="Pretraži stranice, predmete ili akcije..." class="bg-transparent border-none outline-none text-white text-lg w-full placeholder-gray-500" autocomplete="off">
            <div class="text-xs text-gray-500 bg-gray-900 px-2 py-1 rounded border border-gray-700">ESC</div>
        </div>
        <div class="max-h-[60vh] overflow-y-auto py-2" id="commandResults">
            <!-- Results injected via JS -->
            <div class="px-4 py-8 text-center text-gray-500" id="commandEmptyState">
                <i class="fas fa-terminal text-2xl mb-2 block opacity-50"></i>
                Upišite nešto za pretragu...
            </div>
        </div>
        <div class="bg-gray-900/50 p-2 text-xs text-gray-500 flex justify-between px-4 border-t border-gray-700">
            <span><strong class="text-gray-400">↑↓</strong> za navigaciju</span>
            <span><strong class="text-gray-400">Enter</strong> za odabir</span>
        </div>
    </div>
</div>

<!-- Modal za potvrdu brisanja -->
<div id="deleteModal" class="hidden fixed inset-0 flex justify-center items-center z-[9999] bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="deleteContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-4 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center text-red-500 border border-red-500/30">
            <i class="fas fa-exclamation-triangle text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white" id="deleteModalTitle">Potvrdi brisanje</h2>
    </div>
    <p class="text-gray-300 mb-6 text-sm sm:text-base leading-relaxed" id="deleteModalMessage">Jeste li sigurni da želite obrisati ovaj sadržaj?</p>
    <div class="flex justify-end gap-3 pt-2">
      <button type="button" id="cancelDelete" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
      <a href="#" id="confirmDelete" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-red-500/30">
        <i class="fas fa-trash-alt"></i> Obriši
      </a>
    </div>
  </div>
</div>

<!-- Modal za Obavještenja (Prikaz) -->
<div id="viewNotificationModal" class="hidden fixed inset-0 flex justify-center items-center z-[80] bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="viewNotificationContent" class="bg-gray-800 p-6 rounded-xl shadow-2xl w-full max-w-md mx-4 transform scale-95 opacity-0 transition-all duration-300 border border-purple-500/30">
    <div class="text-center mb-4">
        <div id="viewNotifIconContainer" class="w-16 h-16 bg-purple-900/50 rounded-full flex items-center justify-center mx-auto mb-3 border border-purple-500/30">
            <i id="viewNotifIcon" class="fas fa-bell text-2xl text-purple-300"></i>
        </div>
        <h2 id="viewNotifTitle" class="text-xl font-bold text-white">Novo obavještenje</h2>
        <p id="viewNotifDate" class="text-gray-400 text-xs mt-1"></p>
    </div>
    <div id="viewNotifMessage" class="bg-gray-700/50 p-4 rounded-lg border border-gray-600 text-gray-200 text-sm sm:text-base mb-6 leading-relaxed whitespace-pre-wrap max-h-[50vh] overflow-y-auto custom-scrollbar">
    </div>
    <div class="flex justify-center">
      <button type="button" onclick="hideModal(document.getElementById('viewNotificationModal'), document.getElementById('viewNotificationContent'))" id="viewNotifCloseBtn" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white border border-purple-500/30 px-6 py-2 rounded-lg font-medium transition-colors"><i class="fas fa-times mr-2"></i> Zatvori</button>
    </div>
  </div>
</div>

<script>
// Funkcije za prikaz i sakrivanje modala

/* --- COMMAND PALETTE LOGIC --- */
const commandPalette = document.getElementById('commandPalette');
const commandInput = document.getElementById('commandInput');
const commandResults = document.getElementById('commandResults');
const commandContent = document.getElementById('commandPaletteContent');

document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        toggleCommandPalette();
    }
    if (e.key === 'Escape' && !commandPalette.classList.contains('hidden')) {
        toggleCommandPalette();
    }
});

function toggleCommandPalette() {
    if (commandPalette.classList.contains('hidden')) {
        commandPalette.classList.remove('hidden');
        commandPalette.classList.add('flex');
        setTimeout(() => { 
            commandContent.classList.remove('scale-95'); 
            commandContent.classList.add('scale-100');
        }, 10);
        commandInput.value = '';
        commandInput.focus();
        generateCommandItems('');
    } else {
        commandContent.classList.remove('scale-100');
        commandContent.classList.add('scale-95');
        setTimeout(() => {
            commandPalette.classList.add('hidden');
            commandPalette.classList.remove('flex');
        }, 200);
    }
}

commandPalette.addEventListener('click', (e) => {
    if (e.target === commandPalette) toggleCommandPalette();
});

const commands = [
    { icon: 'fas fa-home', title: 'Početna', desc: 'Idi na početnu stranu', action: () => window.location.href='index.php' },
    { icon: 'fas fa-sign-out-alt', title: 'Odjavi se', desc: 'Završi sesiju', action: () => window.location.href='index.php?route=logout' },
    <?php if($is_admin): ?>
    { icon: 'fas fa-users-cog', title: 'Administratori', desc: 'Upravljaj administratorima', action: () => { toggleCommandPalette(); document.getElementById('openManageAdmins').click(); } },
    { icon: 'fas fa-user-plus', title: 'Novi Admin', desc: 'Kreiraj novog administratora', action: () => { toggleCommandPalette(); showModal(document.getElementById('addAdminModal'), document.getElementById('addAdminContent')); } },
    { icon: 'fas fa-paper-plane', title: 'Obavještenja', desc: 'Pošalji novo obavještenje', action: () => { toggleCommandPalette(); document.getElementById('openNotificationModal').click(); } },
    <?php endif; ?>
    // Možemo dodati i predmete ovdje ako ih ima u JS
];

function generateCommandItems(filter) {
    const filtered = commands.filter(c => c.title.toLowerCase().includes(filter.toLowerCase()) || c.desc.toLowerCase().includes(filter.toLowerCase()));
    
    if (filtered.length === 0) {
        commandResults.innerHTML = '<div class="p-4 text-center text-gray-500 text-sm italic">Nema rezultata.</div>';
        return;
    }
    
    commandResults.innerHTML = filtered.map((c, i) => `
        <div class="px-4 py-3 hover:bg-purple-600/20 hover:border-l-4 hover:border-purple-500 cursor-pointer flex items-center gap-3 transition-all border-l-4 border-transparent group" onclick="(${c.action})()">
            <div class="w-8 h-8 rounded bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-white group-hover:bg-purple-600 transition-colors"><i class="${c.icon}"></i></div>
            <div>
                <div class="text-white font-medium group-hover:text-purple-300">${c.title}</div>
                <div class="text-gray-500 text-xs group-hover:text-gray-400">${c.desc}</div>
            </div>
        </div>
    `).join('');
}

commandInput.addEventListener('input', (e) => generateCommandItems(e.target.value));

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

function renameSection(id, oldName) {
    const newName = prompt("Unesite novi naziv sekcije:", oldName);
    if (newName && newName.trim() !== "" && newName !== oldName) {
        document.getElementById('renameSectionId').value = id;
        document.getElementById('renameSectionName').value = newName.trim();
        document.getElementById('renameSectionForm').submit();
    }
}

function toggleSection(id, header) {
    const content = document.getElementById(id);
    const icon = header.querySelector('.fa-chevron-down');
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(0deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(-90deg)';
    }
}

// Toggle radovi
function toggleWorks(element) {
  const worksList = element.nextElementSibling;
  const arrow = element.querySelector('span:first-child');
  
  if (worksList.classList.contains('hidden')) {
    worksList.classList.remove('hidden');
    arrow.style.transform = 'rotate(90deg)';
  } else {
    worksList.classList.add('hidden');
    arrow.style.transform = 'rotate(0deg)';
  }
}

document.addEventListener('DOMContentLoaded', function() {

  // Global loader funkcije
  window.showGlobalLoader = function(text = 'Obrađujem podatke...', showProgress = false) {
      const loader = document.getElementById('globalAjaxLoader');
      const textEl = document.getElementById('globalAjaxLoaderText');
      const progressCont = document.getElementById('globalAjaxProgress');
      const progressBar = document.getElementById('globalAjaxProgressBar');
      if(!loader) return;
      
      if (textEl) textEl.textContent = text;
      if (showProgress) {
          if (progressCont) progressCont.classList.remove('hidden');
          if (progressBar) progressBar.style.width = '0%';
      } else {
          if (progressCont) progressCont.classList.add('hidden');
      }
      
      loader.classList.remove('hidden');
      loader.classList.add('flex');
  };

  window.updateGlobalLoaderProgress = function(percent) {
      const progressBar = document.getElementById('globalAjaxProgressBar');
      if (progressBar) progressBar.style.width = percent + '%';
  };

  window.hideGlobalLoader = function() {
      const loader = document.getElementById('globalAjaxLoader');
      if(loader) {
          loader.classList.add('hidden');
          loader.classList.remove('flex');
      }
  };

  // Validacija lozinke za novog admina
  window.validateAdminPassword = function() {
    const pass = document.getElementById('newAdminPassword').value;
    if(pass.length < 8) {
      alert('Lozinka mora imati najmanje 8 karaktera!');
      return false;
    }
    return true;
  };

// Modal za brisanje
const deleteModal = document.getElementById('deleteModal');
const deleteContent = document.getElementById('deleteContent');
const deleteModalTitle = document.getElementById('deleteModalTitle');
const deleteModalMessage = document.getElementById('deleteModalMessage');
const confirmDelete = document.getElementById('confirmDelete');
const cancelDelete = document.getElementById('cancelDelete');

window.showDeleteModal = function(type, id, subjectId = null) {
  if(!deleteModal || !deleteContent) return;
  let title, message, url;
  
  const urlParams = new URLSearchParams(window.location.search);
  const dateFilter = urlParams.get('date_filter') || 'all';

  switch(type) {
    case 'subject':
      title = 'Brisanje predmeta';
      message = 'Jeste li sigurni da želite obrisati ovaj predmet? Ova akcija je nepovratna.';
      url = `?delete_subject=${id}`;
      break;
    case 'file':
      title = 'Brisanje datoteke';
      message = 'Jeste li sigurni da želite obrisati ovu datoteku? Ova akcija je nepovratna.';
      url = `?delete_file=${id}&subject=${subjectId}`;
      break;
    case 'test':
      title = 'Brisanje testa';
      message = 'Jeste li sigurni da želite obrisati ovaj test? Ova akcija je nepovratna.';
      url = `?delete_test=${id}&subject=${subjectId}`;
      break;
    case 'work':
      title = 'Brisanje rada';
      message = 'Jeste li sigurni da želite obrisati ovaj rad? Ova akcija je nepovratna.';
      url = `?delete_work=${id}&subject=${subjectId}`;
      break;
    case 'all_works':
      title = 'Brisanje svih radova';
      message = 'Jeste li sigurni da želite obrisati sve radove za ovaj predmet? Ova akcija je nepovratna.';
      url = `?delete_all_works=1&subject=${subjectId}&date_filter=${dateFilter}`;
      break;
    case 'admin':
      title = 'Brisanje administratora';
      message = 'Jeste li sigurni da želite obrisati ovog administratora i sve njegove učenike? Ova akcija je nepovratna.';
      url = `?delete_admin=${id}`;
      break;
    case 'section':
      title = 'Brisanje sekcije';
      message = 'Jeste li sigurni da želite obrisati ovu sekciju? Svi materijali u njoj će postati "Opšti".';
      url = `?delete_section=${id}&subject=${subjectId}`;
      break;
    case 'notification':
      title = 'Brisanje obavještenja';
      message = 'Jeste li sigurni da želite obrisati ovo obavještenje? Biće trajno uklonjeno za sve korisnike.';
      url = `?delete_notification=${id}&open_history=1`;
      break;
  }
  
  deleteModalTitle.textContent = title;
  deleteModalMessage.textContent = message;
  confirmDelete.href = url;
  
  showModal(deleteModal, deleteContent);
}

if(cancelDelete && deleteModal && deleteContent) {
  cancelDelete.addEventListener('click', () => hideModal(deleteModal, deleteContent));
  deleteModal.addEventListener('click', (e) => {
    if(e.target === deleteModal) hideModal(deleteModal, deleteContent);
  });
}

// Student Work Upload Modal
const openStudentWorkModalBtn = document.getElementById('openStudentWorkModal');
const studentWorkModal = document.getElementById('studentWorkModal');
const studentWorkContent = document.getElementById('studentWorkContent');
const closeStudentWork = document.getElementById('closeStudentWork');
const studentWorkForm = document.getElementById('studentWorkForm');
const studentWorkFileInput = document.getElementById('studentWorkFileInput');
const studentWorkDropZone = document.getElementById('studentWorkDropZone');
const studentWorkPrompt = document.getElementById('studentWorkPrompt');
const studentWorkFileDetails = document.getElementById('studentWorkFileDetails');
const studentWorkFileName = document.getElementById('studentWorkFileName');
const studentWorkFileSize = document.getElementById('studentWorkFileSize');
const studentWorkProgressContainer = document.getElementById('studentWorkProgressContainer');
const studentWorkProgressBar = document.getElementById('studentWorkProgressBar');
const studentWorkUploadSuccess = document.getElementById('studentWorkUploadSuccess');

// Debug
console.log('Student work modal btn:', openStudentWorkModalBtn);
console.log('Student work modal:', studentWorkModal);
console.log('Student work content:', studentWorkContent);

// Setup Student Work Modal Event Listeners
if(openStudentWorkModalBtn && studentWorkModal && studentWorkContent) {
  console.log('Setting up student work modal listeners');
  openStudentWorkModalBtn.addEventListener('click', function() {
    console.log('Button clicked!');
    showModal(studentWorkModal, studentWorkContent);
  });
} else {
  console.log('Missing elements - btn:' + !!openStudentWorkModalBtn + ' modal:' + !!studentWorkModal + ' content:' + !!studentWorkContent);
}

if(closeStudentWork && studentWorkModal && studentWorkContent) {
  closeStudentWork.addEventListener('click', function() {
    hideModal(studentWorkModal, studentWorkContent);
  });
}
studentWorkModal?.addEventListener('click',(e)=>{if(e.target===studentWorkModal) hideModal(studentWorkModal,studentWorkContent);});

// Drag and drop za student work
if(studentWorkDropZone) {
  studentWorkDropZone.addEventListener('dragover',(e)=>{e.preventDefault(); studentWorkDropZone.classList.add('border-purple-500','text-purple-300');});
  studentWorkDropZone.addEventListener('dragleave',()=>{studentWorkDropZone.classList.remove('border-purple-500','text-purple-300');});
  studentWorkDropZone.addEventListener('drop',(e)=>{e.preventDefault(); studentWorkDropZone.classList.remove('border-purple-500','text-purple-300'); if(e.dataTransfer.files.length) studentWorkFileInput.files = e.dataTransfer.files; updateStudentWorkFileDetails();});
  studentWorkDropZone.addEventListener('click',()=>studentWorkFileInput.click());
}

if(studentWorkFileInput) studentWorkFileInput.addEventListener('change',updateStudentWorkFileDetails);

function updateStudentWorkFileDetails() {
  if(!studentWorkFileInput.files.length) return;
  const file = studentWorkFileInput.files[0];
  studentWorkPrompt.classList.add('hidden');
  studentWorkFileDetails.classList.remove('hidden');
  studentWorkFileName.textContent = file.name;
  const units = ['B','KB','MB','GB'];
  let size = file.size;
  let unitIndex = 0;
  while(size >= 1024 && unitIndex < units.length - 1) {
    size /= 1024;
    unitIndex++;
  }
  studentWorkFileSize.textContent = `${size.toFixed(2)} ${units[unitIndex]}`;
}

// Ajax Upload za radove učenika
studentWorkForm?.addEventListener('submit',(e)=>{
  e.preventDefault();
  const file = studentWorkFileInput.files[0];
  if(!file) return;
  
  const submitBtn = studentWorkForm.querySelector('button[type="submit"]');
  const originalBtnContent = submitBtn.innerHTML;
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Slanje...';
  submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

  studentWorkUploadSuccess.classList.add('hidden');
  const formData = new FormData();
  formData.append('upload_student_work','1');
  formData.append('student_work_file',file);
  formData.append('csrf_token', '<?= $csrf_token ?>');
  const xhr = new XMLHttpRequest();
  xhr.open('POST','index.php?subject=<?= $selected_subject ?>',true);
  
  showGlobalLoader('Šaljem rad...', true);
  
  xhr.upload.addEventListener('progress',(e)=>{
    if(e.lengthComputable){
      studentWorkProgressContainer.classList.remove('hidden');
      const percent = (e.loaded / e.total) * 100;
      studentWorkProgressBar.style.width = percent + '%';
      updateGlobalLoaderProgress(percent);
    }
  });
  xhr.onload = function(){
    hideGlobalLoader();
    if(xhr.status===200) {
      const response = xhr.responseText.trim();
      if(response === 'success') {
        studentWorkUploadSuccess.classList.remove('hidden');
        studentWorkFileInput.value = '';
        setTimeout(() => {
          studentWorkProgressBar.style.width = '0%';
          // studentWorkProgressBar.textContent = ''; // Uklonjeno
          setTimeout(() => {
            location.reload();
          }, 500);
        }, 1500);
      } else {
        alert('Greška: ' + response);
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnContent;
        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
      }
    } else {
      alert('Greška pri uploadu! Status: ' + xhr.status);
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnContent;
      submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
    }
  }
  xhr.onerror = function() {
    hideGlobalLoader();
    alert('Mrežna greška!');
    submitBtn.disabled = false;
    submitBtn.innerHTML = originalBtnContent;
    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
  };
  
  xhr.send(formData);
});

<?php if($is_admin): ?>
// Upload modal
const openUpload = document.getElementById('openUpload');
const uploadModal = document.getElementById('uploadModal');
const uploadContent = document.getElementById('uploadContent');
const closeUpload = document.getElementById('closeUpload');
if(openUpload) openUpload.addEventListener('click',()=>showModal(uploadModal, uploadContent));
if(closeUpload) closeUpload.addEventListener('click',()=>hideModal(uploadModal, uploadContent));
uploadModal?.addEventListener('click',(e)=>{if(e.target===uploadModal) hideModal(uploadModal,uploadContent);});

// Test upload modal
const openTestUpload = document.getElementById('openTestUpload');
const testUploadModal = document.getElementById('testUploadModal');
const testUploadContent = document.getElementById('testUploadContent');
const closeTestUpload = document.getElementById('closeTestUpload');
if(openTestUpload) openTestUpload.addEventListener('click',()=>showModal(testUploadModal, testUploadContent));
if(closeTestUpload) closeTestUpload.addEventListener('click',()=>hideModal(testUploadModal, testUploadContent));
testUploadModal?.addEventListener('click',(e)=>{if(e.target===testUploadModal) hideModal(testUploadModal,testUploadContent);});

// Drag & Drop
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const uploadPrompt = document.getElementById('uploadPrompt');
const fileDetails = document.getElementById('fileDetails');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');
const uploadSuccess = document.getElementById('uploadSuccess');

dropZone?.addEventListener('click',()=>fileInput.click());
dropZone?.addEventListener('dragover',(e)=>{ e.preventDefault(); dropZone.classList.add('border-purple-500','text-purple-300'); });
dropZone?.addEventListener('dragleave',(e)=>{ dropZone.classList.remove('border-purple-500','text-purple-300'); });
dropZone?.addEventListener('drop',(e)=>{ 
  e.preventDefault(); 
  dropZone.classList.remove('border-purple-500','text-purple-300'); 
  if(e.dataTransfer.files.length>0) {
    fileInput.files=e.dataTransfer.files;
    showFileDetails(e.dataTransfer.files[0]);
  }
});

// Prikazivanje detalja o fajlu
fileInput?.addEventListener('change', function() {
  if(this.files.length > 0) {
    showFileDetails(this.files[0]);
  }
});

function showFileDetails(file) {
  uploadPrompt.classList.add('hidden');
  fileDetails.classList.remove('hidden');
  fileName.textContent = file.name;
  
  // Formatiranje veličine fajla
  let size = file.size;
  const units = ['B', 'KB', 'MB', 'GB'];
  let unitIndex = 0;
  
  while(size >= 1024 && unitIndex < units.length - 1) {
    size /= 1024;
    unitIndex++;
  }
  
  fileSize.textContent = `${size.toFixed(2)} ${units[unitIndex]}`;
}

// Drag & Drop za testove
const testDropZone = document.getElementById('testDropZone');
const testFileInput = document.getElementById('testFileInput');
const testUploadPrompt = document.getElementById('testUploadPrompt');
const testFileDetails = document.getElementById('testFileDetails');
const testFileName = document.getElementById('testFileName');
const testFileSize = document.getElementById('testFileSize');
const testUploadSuccess = document.getElementById('testUploadSuccess');

testDropZone?.addEventListener('click',()=>testFileInput.click());
testDropZone?.addEventListener('dragover',(e)=>{ e.preventDefault(); testDropZone.classList.add('border-purple-500','text-purple-300'); });
testDropZone?.addEventListener('dragleave',(e)=>{ testDropZone.classList.remove('border-purple-500','text-purple-300'); });
testDropZone?.addEventListener('drop',(e)=>{ 
  e.preventDefault(); 
  testDropZone.classList.remove('border-purple-500','text-purple-300'); 
  if(e.dataTransfer.files.length>0) {
    testFileInput.files=e.dataTransfer.files;
    showTestFileDetails(e.dataTransfer.files[0]);
  }
});

// Prikazivanje detalja o test fajlu
testFileInput?.addEventListener('change', function() {
  if(this.files.length > 0) {
    showTestFileDetails(this.files[0]);
  }
});

function showTestFileDetails(file) {
  testUploadPrompt.classList.add('hidden');
  testFileDetails.classList.remove('hidden');
  testFileName.textContent = file.name;
  
  // Formatiranje veličine fajla
  let size = file.size;
  const units = ['B', 'KB', 'MB', 'GB'];
  let unitIndex = 0;
  
  while(size >= 1024 && unitIndex < units.length - 1) {
    size /= 1024;
    unitIndex++;
  }
  
  testFileSize.textContent = `${size.toFixed(2)} ${units[unitIndex]}`;
}

// Ajax Upload
const uploadForm = document.getElementById('uploadForm');
const progressContainer = document.getElementById('progressContainer');
const progressBar = document.getElementById('progressBar');
uploadForm?.addEventListener('submit',(e)=>{
  e.preventDefault();
  const file = fileInput.files[0];
  if(!file) return;
  
  const submitBtn = uploadForm.querySelector('button[type="submit"]');
  const originalBtnContent = submitBtn.innerHTML;
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Uploadujem...';
  submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

  // Sakrij poruku o uspjehu ako je prikazana
  uploadSuccess.classList.add('hidden');
  
  const formData = new FormData(uploadForm);
  
  const xhr = new XMLHttpRequest();
  xhr.open('POST','index.php?subject=<?= $selected_subject ?>',true);
  
  showGlobalLoader('Uploadujem materijal...', true);

  xhr.upload.addEventListener('progress',(e)=>{
    if(e.lengthComputable){
      progressContainer.classList.remove('hidden');
      const percent = (e.loaded / e.total) * 100;
      progressBar.style.width = percent + '%';
      updateGlobalLoaderProgress(percent);
    }
  });
  
  xhr.onload = function(){
    hideGlobalLoader();
    if(xhr.status===200) {
      // Prikaži poruku o uspjehu
      uploadSuccess.classList.remove('hidden');
      
      // Resetuj progress bar nakon 1.5 sekunde
      setTimeout(() => {
        progressBar.style.width = '0%';
        progressBar.textContent = '';
        
        // Reload stranice nakon 2 sekunde
        setTimeout(() => {
          location.reload();
        }, 500);
      }, 1500);
    } else {
      alert('Greška pri uploadu!');
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnContent;
      submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
    }
  }
  
  xhr.onerror = function() {
    hideGlobalLoader();
    alert('Mrežna greška!');
    submitBtn.disabled = false;
    submitBtn.innerHTML = originalBtnContent;
    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
  };

  xhr.send(formData);
});

// Dodaj Admina Modal
const openAddAdmin = document.getElementById('openAddAdmin');
const openAddAdminFromManage = document.getElementById('openAddAdminFromManage');
const addAdminModal = document.getElementById('addAdminModal');
const addAdminContent = document.getElementById('addAdminContent');
const closeAddAdmin = document.getElementById('closeAddAdmin');

if(openAddAdmin) openAddAdmin.addEventListener('click', () => showModal(addAdminModal, addAdminContent));
if(openAddAdminFromManage) openAddAdminFromManage.addEventListener('click', () => {
    hideModal(manageAdminsModal, manageAdminsContent);
    setTimeout(() => showModal(addAdminModal, addAdminContent), 300);
});
if(closeAddAdmin) closeAddAdmin.addEventListener('click', () => hideModal(addAdminModal, addAdminContent));
addAdminModal?.addEventListener('click', (e) => { if(e.target === addAdminModal) hideModal(addAdminModal, addAdminContent); });

// Upravljaj adminima modal
const openManageAdmins = document.getElementById('openManageAdmins');
const manageAdminsModal = document.getElementById('manageAdminsModal');
const manageAdminsContent = document.getElementById('manageAdminsContent');
const closeManageAdmins = document.getElementById('closeManageAdmins');
if(openManageAdmins) openManageAdmins.addEventListener('click',()=> {
    const searchInput = document.getElementById('modalAdminSearchInput');
    if (searchInput) {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
    }
    showModal(manageAdminsModal,manageAdminsContent);
});
if(closeManageAdmins) closeManageAdmins.addEventListener('click',()=>hideModal(manageAdminsModal,manageAdminsContent));
manageAdminsModal?.addEventListener('click',(e)=>{if(e.target===manageAdminsModal) hideModal(manageAdminsModal,manageAdminsContent);});

// Edit Admin Modal
const editAdminModal = document.getElementById('editAdminModal');
const editAdminContent = document.getElementById('editAdminContent');
const closeEditAdmin = document.getElementById('closeEditAdmin');

document.querySelectorAll('.btn-edit-admin').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    const username = btn.dataset.username;
    document.getElementById('edit_admin_id').value = id;
    document.getElementById('edit_admin_username').value = username;
    hideModal(manageAdminsModal, manageAdminsContent);
    setTimeout(() => showModal(editAdminModal, editAdminContent), 300);
  });
});

if(closeEditAdmin) {
    closeEditAdmin.addEventListener('click', () => {
        hideModal(editAdminModal, editAdminContent);
        setTimeout(() => showModal(manageAdminsModal, manageAdminsContent), 300);
    });
}
editAdminModal?.addEventListener('click', (e) => {
    if(e.target === editAdminModal) {
        hideModal(editAdminModal, editAdminContent);
        setTimeout(() => showModal(manageAdminsModal, manageAdminsContent), 300);
    }
});

// Notification Modal
const notificationModal = document.getElementById('notificationModal');
const notificationContent = document.getElementById('notificationContent');
const openNotificationModal = document.getElementById('openNotificationModal');
const closeNotificationModal = document.getElementById('closeNotificationModal');
const notifRecipientId = document.getElementById('notifRecipientId');
const notifModalTitle = document.getElementById('notifModalTitle');
const notifModalDesc = document.getElementById('notifModalDesc');
let lastModalBeforeHistory = null;

if(openNotificationModal) openNotificationModal.addEventListener('click', () => {
    openNotificationModalFor('', 'Svima');
});
if(closeNotificationModal) closeNotificationModal.addEventListener('click', () => hideModal(notificationModal, notificationContent));
notificationModal?.addEventListener('click', (e) => { if(e.target === notificationModal) hideModal(notificationModal, notificationContent); });

window.selectNotifType = function(value, name, iconClass) {
    document.getElementById('notifTypeInput').value = value;
    document.getElementById('notifTypeText').innerHTML = `<i class="fas ${iconClass}"></i> <span class="truncate">${name}</span>`;
    document.getElementById('notifTypeDropdown').classList.add('hidden');
}

document.addEventListener('click', function(event) {
    var notifDropdown = document.getElementById('notifTypeDropdown');
    var notifBtn = document.getElementById('notifTypeBtn');
    if (notifDropdown && !notifDropdown.classList.contains('hidden')) {
        if (!notifDropdown.contains(event.target) && !notifBtn.contains(event.target)) {
            notifDropdown.classList.add('hidden');
        }
    }
});

window.openNotificationModalFor = function(id, username) {
    if(notifRecipientId) notifRecipientId.value = id;
    if(notifModalTitle) notifModalTitle.textContent = id === '' ? 'Pošalji obavještenje: Svima' : 'Pošalji obavještenje: ' + username;
    if(notifModalDesc) notifModalDesc.textContent = id === '' ? 'Ova poruka će se prikazati svim administratorima na njihovoj kontrolnoj tabli.' : 'Ova poruka će se prikazati samo administratoru ' + username + '.';
    
    if(document.getElementById('notifTypeInput')) window.selectNotifType('info', 'Informacija', 'fa-info-circle text-blue-400');

    if (manageAdminsModal && !manageAdminsModal.classList.contains('hidden')) {
        hideModal(manageAdminsModal, manageAdminsContent);
        setTimeout(() => showModal(notificationModal, notificationContent), 300);
    } else {
        showModal(notificationModal, notificationContent);
    }
}

// Notification History Modal
const notificationHistoryModal = document.getElementById('notificationHistoryModal');
const notificationHistoryContent = document.getElementById('notificationHistoryContent');
const openNotificationHistoryFromModal = document.getElementById('openNotificationHistoryFromModal');
const openNotificationHistoryFromManage = document.getElementById('openNotificationHistoryFromManage');
const closeNotificationHistory = document.getElementById('closeNotificationHistory');

if(openNotificationHistoryFromModal) {
    openNotificationHistoryFromModal.addEventListener('click', () => {
        lastModalBeforeHistory = { modal: notificationModal, content: notificationContent };
        hideModal(notificationModal, notificationContent);
        setTimeout(() => showModal(notificationHistoryModal, notificationHistoryContent), 300);
    });
}
if(openNotificationHistoryFromManage) {
    openNotificationHistoryFromManage.addEventListener('click', () => {
        lastModalBeforeHistory = { modal: manageAdminsModal, content: manageAdminsContent };
        hideModal(manageAdminsModal, manageAdminsContent);
        setTimeout(() => showModal(notificationHistoryModal, notificationHistoryContent), 300);
    });
}
if(closeNotificationHistory) {
    closeNotificationHistory.addEventListener('click', () => {
        hideModal(notificationHistoryModal, notificationHistoryContent);
        if (lastModalBeforeHistory) {
            setTimeout(() => showModal(lastModalBeforeHistory.modal, lastModalBeforeHistory.content), 300);
        } else {
            setTimeout(() => showModal(notificationModal, notificationContent), 300);
        }
    });
}
notificationHistoryModal?.addEventListener('click', (e) => { 
    if(e.target === notificationHistoryModal) {
        hideModal(notificationHistoryModal, notificationHistoryContent);
    }
});

window.escapeHtml = function(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
};

let currentHistoryOffset = 20;
window.loadMoreHistory = function() {
    const btn = document.querySelector('#loadMoreHistoryContainer button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Učitavam...';
    btn.disabled = true;

    const formData = new FormData();
    formData.append('load_more_history', '1');
    formData.append('offset', currentHistoryOffset);
    formData.append('csrf_token', '<?= $csrf_token ?>');

    fetch('index.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json()).then(data => {
        if (data.notifications && data.notifications.length > 0) {
            const list = document.getElementById('notificationHistoryList');
            data.notifications.forEach(notif => {
                let typeClass = 'text-blue-400';
                let typeIcon = 'fa-info-circle';
                if(notif.type === 'warning') { typeClass = 'text-yellow-400'; typeIcon = 'fa-exclamation-triangle'; }
                if(notif.type === 'urgent') { typeClass = 'text-red-400'; typeIcon = 'fa-exclamation-circle'; }
                
                let recipientHtml = notif.recipient_id 
                    ? `<span class="text-white bg-gray-700 px-2 py-1 rounded text-xs"><i class="fas fa-user mr-1"></i> ${escapeHtml(notif.recipient_name)}</span>` 
                    : `<span class="text-green-400 bg-green-900/30 px-2 py-1 rounded text-xs"><i class="fas fa-users mr-1"></i> Svi admini</span>`;
                let msgHtml = notif.title ? `<strong class="text-white block truncate">${escapeHtml(notif.title)}</strong><span class="truncate block text-sm">${escapeHtml(notif.message)}</span>` : `<span class="truncate block text-sm">${escapeHtml(notif.message)}</span>`;

                let dStr = notif.created_at;
                if(dStr && dStr.includes(' ')) dStr = dStr.replace(' ', 'T');
                const d = new Date(dStr);
                const day = String(d.getDate()).padStart(2, '0');
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const year = d.getFullYear();
                const hours = String(d.getHours()).padStart(2, '0');
                const minutes = String(d.getMinutes()).padStart(2, '0');
                const dateFormatted = `${day}.${month}.${year} ${hours}:${minutes}`;

                const tr = document.createElement('tr');
                tr.className = 'border-b border-gray-700/50 hover:bg-gray-700/30 transition';
                tr.innerHTML = `
                    <td class="p-3 whitespace-nowrap text-gray-400">${dateFormatted}</td>
                    <td class="p-3"><span class="${typeClass}"><i class="fas ${typeIcon} mr-1"></i> ${notif.type.charAt(0).toUpperCase() + notif.type.slice(1)}</span></td>
                    <td class="p-3">${recipientHtml}</td>
                    <td class="p-3 text-gray-300 max-w-md">${msgHtml}</td>
                    <td class="p-3 text-right">
                        <button onclick="showDeleteModal('notification', ${notif.id})" class="text-red-400 hover:text-red-300 p-1.5 rounded-lg hover:bg-gray-700 transition" title="Obriši obavještenje">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </button>
                    </td>
                `;
                list.appendChild(tr);
            });
            currentHistoryOffset += data.notifications.length;
            if (data.notifications.length < 20) {
                document.getElementById('loadMoreHistoryContainer').remove();
            } else {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        } else {
            document.getElementById('loadMoreHistoryContainer').remove();
        }
    }).catch(err => {
        console.error(err);
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
};

let currentUsersOffset = 20;
window.loadMoreUsers = function() {
    const btn = document.querySelector('#loadMoreUsersContainer button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Učitavam...';
    btn.disabled = true;

    const formData = new FormData();
    formData.append('load_more_users', '1');
    formData.append('offset', currentUsersOffset);
    formData.append('csrf_token', '<?= $csrf_token ?>');

    fetch('index.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json()).then(data => {
        if (data.users && data.users.length > 0) {
            const list = document.getElementById('globalUsersList');
            data.users.forEach(u => {
                const tr = document.createElement('tr');
                tr.className = 'border-b border-gray-700 hover:bg-gray-700/60 transition';
                const roleDisplay = u.role === 'student' ? 'Učenik' : 'Admin';
                tr.innerHTML = `
                    <td class="p-2">${escapeHtml(u.username)}</td>
                    <td class="p-2">${roleDisplay}</td>
                    <td class="p-2">${escapeHtml(u.created_by)}</td>
                `;
                list.appendChild(tr);
            });
            currentUsersOffset += data.users.length;
            if (data.users.length < 20) document.getElementById('loadMoreUsersContainer').remove();
            else { btn.innerHTML = originalText; btn.disabled = false; }
        } else {
            document.getElementById('loadMoreUsersContainer').remove();
        }
    }).catch(err => { console.error(err); btn.innerHTML = originalText; btn.disabled = false; });
};

    // Toggle password visibility
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

    // Move modal logic
    const moveModal = document.getElementById('moveModal');
    const moveContent = document.getElementById('moveContent');
    const closeMoveModal = document.getElementById('closeMoveModal');

    window.openMoveModal = function(type, id, currentSectionId) {
        document.getElementById('moveItemId').value = id;
        document.getElementById('moveItemType').value = type;
        document.getElementById('moveSectionId').value = currentSectionId || "";
        
        let matchedName = 'Opšte (bez sekcije)';
        let matchedIcon = 'fa-folder-open text-gray-400';
        if (currentSectionId) {
            const dropOptions = document.querySelectorAll('#moveSectionDropdown button');
            for(let opt of dropOptions) {
                if(opt.getAttribute('onclick').includes("'" + currentSectionId + "'") || opt.getAttribute('onclick').includes('"' + currentSectionId + '"')) {
                    matchedName = opt.innerText.trim();
                    matchedIcon = 'fa-folder text-purple-400';
                    break;
                }
            }
        }
        document.getElementById('moveSectionText').innerHTML = `<i class="fas ${matchedIcon}"></i> <span class="truncate">${matchedName}</span>`;
        showModal(moveModal, moveContent);
    }

    if(closeMoveModal) closeMoveModal.addEventListener('click', () => hideModal(moveModal, moveContent));
    moveModal?.addEventListener('click', (e) => {
        if(e.target === moveModal) hideModal(moveModal, moveContent);
    });

    window.selectMoveSection = function(id, name, iconClass) {
        document.getElementById('moveSectionId').value = id;
        document.getElementById('moveSectionText').innerHTML = `<i class="fas ${iconClass}"></i> <span class="truncate">${name}</span>`;
        document.getElementById('moveSectionDropdown').classList.add('hidden');
    }

    window.selectUploadSection = function(id, name, iconClass) {
        document.getElementById('uploadSectionId').value = id;
        document.getElementById('uploadSectionText').innerHTML = `<i class="fas ${iconClass}"></i> <span class="truncate">${name}</span>`;
        document.getElementById('uploadSectionDropdown').classList.add('hidden');
    }

    document.addEventListener('click', function(event) {
        var moveDropdown = document.getElementById('moveSectionDropdown');
        var moveBtn = document.getElementById('moveSectionBtn');
        if (moveDropdown && !moveDropdown.classList.contains('hidden') && !moveDropdown.contains(event.target) && !moveBtn.contains(event.target)) {
            moveDropdown.classList.add('hidden');
        }
        
        var uploadDropdown = document.getElementById('uploadSectionDropdown');
        var uploadBtn = document.getElementById('uploadSectionBtn');
        if (uploadDropdown && !uploadDropdown.classList.contains('hidden') && !uploadDropdown.contains(event.target) && !uploadBtn.contains(event.target)) {
            uploadDropdown.classList.add('hidden');
        }
    });
<?php endif; ?>

// Logika za dropdown obavještenja
const bellBtn = document.getElementById('notificationBell');
const notifDropdown = document.getElementById('notificationDropdown');

if (bellBtn && notifDropdown) {
    bellBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (notifDropdown.classList.contains('hidden')) {
            notifDropdown.classList.remove('hidden');
            requestAnimationFrame(() => {
                notifDropdown.classList.remove('scale-95', 'opacity-0');
                notifDropdown.classList.add('scale-100', 'opacity-100');
            });
        } else {
            closeDropdown();
        }
    });
    
    document.addEventListener('click', (e) => {
        if (!notifDropdown.contains(e.target)) {
            closeDropdown();
        }
    });
    
    function closeDropdown() {
        notifDropdown.classList.remove('scale-100', 'opacity-100');
        notifDropdown.classList.add('scale-95', 'opacity-0');
        setTimeout(() => notifDropdown.classList.add('hidden'), 200);
    }
}

// Logika za prikaz pojedinačnog obavještenja iz menija
window.openNotification = function(el) {
    const notifData = el.getAttribute('data-notif');
    if (!notifData) return;
    const notif = JSON.parse(notifData);

    const modal = document.getElementById('viewNotificationModal');
    const content = document.getElementById('viewNotificationContent');

    const titleEl = document.getElementById('viewNotifTitle');
    const msgEl = document.getElementById('viewNotifMessage');
    const dateEl = document.getElementById('viewNotifDate');
    const iconContainer = document.getElementById('viewNotifIconContainer');
    const iconEl = document.getElementById('viewNotifIcon');
    const closeBtn = document.getElementById('viewNotifCloseBtn');

    msgEl.textContent = notif.message;

    let dateStr = notif.created_at;
    if (dateStr && dateStr.includes(' ')) dateStr = dateStr.replace(' ', 'T');
    const d = new Date(dateStr);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');
    dateEl.textContent = `${day}.${month}.${year} ${hours}:${minutes}`;

    iconContainer.className = 'w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 border';
    iconEl.className = 'fas text-2xl';
    closeBtn.className = 'px-6 py-2 rounded-lg font-medium transition-colors border';
    content.className = 'bg-gray-800 p-6 rounded-xl shadow-2xl w-full max-w-md mx-4 transform scale-95 opacity-0 transition-all duration-300 border';

    if (notif.type === 'warning') {
        titleEl.textContent = 'Upozorenje';
        iconContainer.classList.add('bg-yellow-900/50', 'border-yellow-500/30');
        iconEl.classList.add('fa-exclamation-triangle', 'text-yellow-300');
        closeBtn.classList.add('bg-yellow-600/20', 'text-yellow-400', 'hover:bg-yellow-600', 'hover:text-white', 'border-yellow-500/30');
        content.classList.add('border-yellow-500/30');
    } else if (notif.type === 'urgent') {
        titleEl.textContent = 'Važno obavještenje';
        iconContainer.classList.add('bg-red-900/50', 'border-red-500/30');
        iconEl.classList.add('fa-exclamation-circle', 'text-red-300');
        closeBtn.classList.add('bg-red-600/20', 'text-red-400', 'hover:bg-red-600', 'hover:text-white', 'border-red-500/30');
        content.classList.add('border-red-500/30');
    } else {
        titleEl.textContent = 'Novo obavještenje';
        iconContainer.classList.add('bg-purple-900/50', 'border-purple-500/30');
        iconEl.classList.add('fa-bell', 'text-purple-300');
        closeBtn.classList.add('bg-purple-600/20', 'text-purple-400', 'hover:bg-purple-600', 'hover:text-white', 'border-purple-500/30');
        content.classList.add('border-purple-500/30');
    }

    if (notif.title) {
        titleEl.textContent = notif.title;
    }

    showModal(modal, content);

    const notifDropdown = document.getElementById('notificationDropdown');
    if (notifDropdown && !notifDropdown.classList.contains('hidden')) {
        notifDropdown.classList.remove('scale-100', 'opacity-100');
        notifDropdown.classList.add('scale-95', 'opacity-0');
        setTimeout(() => notifDropdown.classList.add('hidden'), 200);
    }

    if (notif.is_read === null || notif.is_read === undefined || notif.is_read === false) {
        const formData = new FormData();
        formData.append('mark_notification_read', notif.id);
        formData.append('csrf_token', '<?= $csrf_token ?>');
        fetch('index.php', { method: 'POST', body: formData }).then(res => res.text()).then(res => {
            if (res.trim() === 'success') {
                notif.is_read = true;
                el.setAttribute('data-notif', JSON.stringify(notif));
                el.classList.add('opacity-70', 'hover:bg-gray-700'); 
                el.classList.remove('bg-gray-700/40', 'hover:bg-gray-700/60');
                const titleText = el.querySelector('p.text-sm.text-gray-200');
                if (titleText) titleText.classList.remove('font-bold');
                const indicator = el.querySelector('.unread-indicator');
                if (indicator) indicator.remove();
                const badge = document.getElementById('unreadBadge');
                const bellDotContainer = document.getElementById('bellNotificationDotContainer');
                const bellIcon = document.getElementById('bellIcon');
                if (badge) {
                    let count = parseInt(badge.textContent);
                    if (!isNaN(count) && count > 1) badge.textContent = (count - 1) + ' novo';
                    else { badge.remove(); if (bellDotContainer) bellDotContainer.remove(); if(bellIcon) bellIcon.classList.remove('text-white', 'drop-shadow-[0_0_8px_rgba(255,255,255,0.5)]'); }
                } else { 
                    if (bellDotContainer) bellDotContainer.remove(); 
                    if(bellIcon) bellIcon.classList.remove('text-white', 'drop-shadow-[0_0_8px_rgba(255,255,255,0.5)]'); 
                }
            }
        }).catch(err => console.error(err));
    }
};

window.markAllNotificationsRead = function() {
    const formData = new FormData();
    formData.append('mark_all_notifications_read', '1');
    formData.append('csrf_token', '<?= $csrf_token ?>');
    fetch('index.php', { method: 'POST', body: formData }).then(res => res.text()).then(res => {
        if (res.trim() === 'success') {
            const unreadIndicators = document.querySelectorAll('#notificationDropdown .unread-indicator');
            unreadIndicators.forEach(indicator => {
                const notifItem = indicator.closest('.cursor-pointer');
                if (notifItem) {
                    notifItem.classList.add('opacity-70', 'hover:bg-gray-700'); 
                    notifItem.classList.remove('bg-gray-700/40', 'hover:bg-gray-700/60');
                    const titleText = notifItem.querySelector('p.text-sm.text-gray-200');
                    if (titleText) titleText.classList.remove('font-bold');
                    let notifData = notifItem.getAttribute('data-notif');
                    if (notifData) { let notifObj = JSON.parse(notifData); notifObj.is_read = true; notifItem.setAttribute('data-notif', JSON.stringify(notifObj)); }
                }
                indicator.remove();
            });
            const badge = document.getElementById('unreadBadge'); if (badge) badge.remove();
            const bellDotContainer = document.getElementById('bellNotificationDotContainer'); if (bellDotContainer) bellDotContainer.remove();
            const bellIcon = document.getElementById('bellIcon'); if (bellIcon) bellIcon.classList.remove('text-white', 'drop-shadow-[0_0_8px_rgba(255,255,255,0.5)]');
            const markAllBtn = document.getElementById('markAllReadBtn'); if (markAllBtn) markAllBtn.remove();
        }
    }).catch(err => console.error(err));
};

let currentNotifOffset = 10;
window.loadMoreNotifications = function() {
    const btn = document.querySelector('#loadMoreNotifsContainer button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Učitavam...';
    btn.disabled = true;

    const formData = new FormData();
    formData.append('load_more_notifications', '1');
    formData.append('offset', currentNotifOffset);
    formData.append('csrf_token', '<?= $csrf_token ?>');

    fetch('index.php', { method: 'POST', body: formData }).then(res => res.json()).then(data => {
        if (data.notifications && data.notifications.length > 0) {
            const list = document.getElementById('notificationList');
            data.notifications.forEach(notif => {
                const is_read = notif.is_read !== null;
                const type = notif.type || 'info';
                let icon = 'fa-bell text-purple-400', bgIcon = 'bg-purple-500/20 border-purple-500/30';
                if (type === 'warning') { icon = 'fa-exclamation-triangle text-yellow-400'; bgIcon = 'bg-yellow-500/20 border-yellow-500/30'; }
                else if (type === 'urgent') { icon = 'fa-exclamation-circle text-red-400'; bgIcon = 'bg-red-500/20 border-red-500/30 shadow-[0_0_10px_rgba(239,68,68,0.5)] animate-pulse'; }
                
                let dStr = notif.created_at;
                if(dStr && dStr.includes(' ')) dStr = dStr.replace(' ', 'T');
                const d = new Date(dStr);
                const dateFormatted = `${String(d.getDate()).padStart(2, '0')}.${String(d.getMonth() + 1).padStart(2, '0')}.${d.getFullYear()} ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;

                const displayTitle = notif.title ? escapeHtml(notif.title) : escapeHtml(notif.message);
                const displayDesc = notif.title ? escapeHtml(notif.message) + ' • ' + dateFormatted : dateFormatted;

                const item = document.createElement('div');
                item.className = `px-3 py-2.5 rounded-lg transition-all cursor-pointer flex gap-3 ${is_read ? 'opacity-70 hover:bg-gray-700' : 'bg-gray-700/40 hover:bg-gray-700/60'}`;
                const safeJson = JSON.stringify(notif).replace(/'/g, "&apos;").replace(/"/g, "&quot;");
                item.setAttribute('data-notif', safeJson);
                item.onclick = function() { openNotification(this); };
                let indicatorHtml = !is_read ? `<div class="w-2 h-2 bg-blue-500 rounded-full self-center flex-shrink-0 unread-indicator shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>` : '';
                item.innerHTML = `<div class="w-10 h-10 rounded-full ${bgIcon} border flex items-center justify-center flex-shrink-0"><i class="fas ${icon}"></i></div><div class="flex-1 min-w-0"><p class="text-sm text-gray-200 truncate ${is_read ? '' : 'font-bold'}">${displayTitle}</p><p class="text-xs text-gray-500 mt-1 truncate">${displayDesc}</p></div>${indicatorHtml}`;
                list.appendChild(item);
            });
            currentNotifOffset += data.notifications.length;
            if (data.notifications.length < 10) document.getElementById('loadMoreNotifsContainer').remove();
            else { btn.innerHTML = originalText; btn.disabled = false; }
        } else { document.getElementById('loadMoreNotifsContainer').remove(); }
    }).catch(err => { console.error(err); btn.innerHTML = originalText; btn.disabled = false; });
};

    // Sidebar Collapse Logic
    const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
    
    function toggleSidebar() {
        document.body.classList.toggle('sidebar-collapsed');
        const isCollapsed = document.body.classList.contains('sidebar-collapsed');
        localStorage.setItem('sidebar_collapsed', isCollapsed ? 'true' : 'false');
    }

    if(localStorage.getItem('sidebar_collapsed') === 'true') {
        document.body.classList.add('sidebar-collapsed');
    }

    if(sidebarCollapseBtn) {
        sidebarCollapseBtn.addEventListener('click', toggleSidebar);
    }
    
    // Tastaturna prečica (Ctrl+B ili Cmd+B) za bočnu traku
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'b') {
            e.preventDefault();
            toggleSidebar();
        }
    });

    // Mobile Sidebar Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const mobileCloseSidebar = document.getElementById('mobileCloseSidebar');

    if (mobileMenuBtn && sidebar && mobileOverlay) {
        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            mobileOverlay.classList.add('hidden');
            document.body.style.overflow = ''; // Vraća mogućnost skrolanja
        }

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            mobileOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Blokira skrolanje pozadine
        });

        mobileOverlay.addEventListener('click', closeSidebar);

        // Sprečavanje scroll-chaining-a na overlay-u za mobilne uređaje
        mobileOverlay.addEventListener('touchmove', (e) => e.preventDefault(), { passive: false });

        if (mobileCloseSidebar) {
            mobileCloseSidebar.addEventListener('click', closeSidebar);
        }

        // Zatvori sidebar kada korisnik klikne na neku opciju/modal dugme
        const sidebarLinks = sidebar.querySelectorAll('.nav-link, #logoutBtn');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) closeSidebar();
            });
        });

        // Zatvori na resize ako pređe na desktop mod
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768 && !mobileOverlay.classList.contains('hidden')) {
                closeSidebar();
            }
        });
    }

    // Otvaranje istorije ukoliko je prisutan open_history parametar
    const urlParamsObj = new URLSearchParams(window.location.search);
    if(urlParamsObj.get('open_history') === '1') {
        const notificationHistoryModal = document.getElementById('notificationHistoryModal');
        const notificationHistoryContent = document.getElementById('notificationHistoryContent');
        if(notificationHistoryModal && notificationHistoryContent) {
            showModal(notificationHistoryModal, notificationHistoryContent);
            const newUrl = new URL(window.location);
            newUrl.searchParams.delete('open_history');
            window.history.replaceState({}, document.title, newUrl);
        }
    }
}); // End DOMContentLoaded
</script>

<!-- Globalni AJAX Loader -->
<div id="globalAjaxLoader" class="hidden fixed inset-0 z-[9999] bg-[#0f172a]/80 backdrop-blur-sm flex-col items-center justify-center transition-all duration-300">
    <div class="relative flex items-center justify-center">
        <div class="w-16 h-16 border-4 border-gray-700 border-t-purple-500 rounded-full animate-spin"></div>
        <div class="absolute text-purple-400">
            <i class="fas fa-cloud-upload-alt text-xl animate-pulse"></i>
        </div>
    </div>
    <p id="globalAjaxLoaderText" class="mt-4 text-white font-medium tracking-wide text-sm sm:text-base animate-pulse">Obrađujem podatke...</p>
    <div id="globalAjaxProgress" class="hidden w-64 h-1.5 bg-gray-700 rounded-full mt-4 overflow-hidden">
        <div id="globalAjaxProgressBar" class="h-full bg-gradient-to-r from-purple-500 to-pink-500 w-0 transition-all duration-300"></div>
    </div>
</div>

<!-- Modal Preimenuj Sekciju -->
<?php if($is_admin && $selected_subject > 0): ?>
<div id="renameSectionModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="renameSectionContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-cyan-400">
            <i class="fas fa-edit text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Preimenuj sekciju</h2>
    </div>
    <form method="post" class="flex flex-col gap-5">
      <input type="hidden" name="edit_section" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="hidden" name="section_id" id="modalSectionId">
      
      <div class="space-y-2">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Novi naziv sekcije</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-folder"></i></span>
            <input type="text" name="new_section_name" id="modalSectionName" class="w-full bg-gray-900 text-white pl-10 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700 mt-2">
        <button type="button" id="closeRenameSection" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
        <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-purple-500/30">
            <i class="fas fa-save"></i> Sačuvaj
        </button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

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

        const isSidebarCollapsed = document.body.classList.contains('sidebar-collapsed');
        const isInsideSidebar = target.closest('#sidebar');

        // Privremeno skloni native title da se ne duplira
        target.setAttribute('data-tooltip-text', title);
        target.removeAttribute('title');

        if (isInsideSidebar && !isSidebarCollapsed) {
            return;
        }

        clearTimeout(hideTimeout);
        tooltip.textContent = title;
        tooltip.classList.remove('hidden');
        
        // Pozicioniranje
        const rect = target.getBoundingClientRect();
        const tooltipRect = tooltip.getBoundingClientRect();
        
        let top = rect.top - tooltipRect.height - 8;
        let left = rect.left + (rect.width - tooltipRect.width) / 2;

        // Zadrži tooltip unutar ekrana
        if (top < 0) top = rect.bottom + 8;
        if (left < 8) left = 8;
        if (left + tooltipRect.width > window.innerWidth) left = window.innerWidth - tooltipRect.width - 8;

        tooltip.style.top = `${top}px`;
        tooltip.style.left = `${left}px`;

        // Animacija pojave
        requestAnimationFrame(() => {
            tooltip.classList.remove('opacity-0', 'scale-95');
            tooltip.classList.add('opacity-100', 'scale-100');
        });
    });

    document.addEventListener('mouseout', (e) => {
        const target = e.target.closest('[data-tooltip-text]');
        if (!target) return;

        // Vrati native title
        const title = target.getAttribute('data-tooltip-text');
        target.setAttribute('title', title);
        target.removeAttribute('data-tooltip-text');

        // Animacija nestanka
        tooltip.classList.remove('opacity-100', 'scale-100');
        tooltip.classList.add('opacity-0', 'scale-95');
        
        hideTimeout = setTimeout(() => {
            tooltip.classList.add('hidden');
        }, 200);
    });

    // Fix za mobilne uređaje: Sakrij tooltip nakon klika
    document.addEventListener('click', () => {
        tooltip.classList.add('hidden');
        document.querySelectorAll('[data-tooltip-text]').forEach(el => {
            el.setAttribute('title', el.getAttribute('data-tooltip-text'));
            el.removeAttribute('data-tooltip-text');
        });
    });
});

function toggleSectionInput(btn, e) {
    const input = document.getElementById('sectionInput');
    const cancelBtn = document.getElementById('cancelSectionBtn');
    if (input.classList.contains('w-0')) {
        input.classList.remove('w-0', 'p-0', 'border-none', 'opacity-0');
        input.classList.add('w-48', 'px-3', 'h-9', 'border', 'border-gray-700');
        input.focus();
        btn.type = 'submit';
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.title = 'Sačuvaj sekciju';
        if (cancelBtn) cancelBtn.classList.remove('hidden');
        if(e) e.preventDefault();
    }
}

function cancelSectionInput(e) {
    if(e) e.preventDefault();
    const input = document.getElementById('sectionInput');
    const btn = document.getElementById('sectionBtn');
    const cancelBtn = document.getElementById('cancelSectionBtn');
    
    input.value = '';
    input.classList.add('w-0', 'p-0', 'border-none', 'opacity-0');
    input.classList.remove('w-48', 'px-3', 'h-9', 'border', 'border-gray-700');
    
    if (btn) {
        btn.type = 'button';
        btn.innerHTML = '<i class="fas fa-folder-plus"></i>';
        btn.title = 'Dodaj sekciju';
    }
    if (cancelBtn) cancelBtn.classList.add('hidden');
}

// Real-time pretraga administratora
(function() {
    const searchInput = document.getElementById('adminSearchInput');
    if (!searchInput) return;
    searchInput.addEventListener('input', function() {
        const term = this.value.trim().toLowerCase();
        const rows = document.querySelectorAll('#adminTableBody .admin-table-row');
        const emptyRow = document.getElementById('adminSearchEmpty');
        let visible = 0;
        rows.forEach(function(row) {
            const nameCell = row.querySelector('.admin-username-cell');
            const name = nameCell ? nameCell.textContent.toLowerCase() : '';
            if (!term || name.includes(term)) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });
        if (emptyRow) emptyRow.classList.toggle('hidden', visible > 0);
    });
})();
</script>

<script>
/* ============================================================
   TEMA SISTEM — Student Dashboard
   ============================================================ */
// Theme je već učitan na početku stranice sa subject-specificnom logikom

function toggleTheme() {
    var btn = document.getElementById('themeToggleBtn');
    if (btn && btn.classList.contains('switching')) return;
    
    if (btn) btn.classList.add('switching');
    
    document.body.style.transition = 'opacity 0.15s ease';
    document.body.style.opacity = '0.85';
    
    setTimeout(function() {
        var isOcean = document.documentElement.classList.toggle('theme-ocean');
        
        var urlParams = new URLSearchParams(window.location.search);
        var currentSubject = urlParams.get('subject');
        
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
        
        showThemeToast(isOcean ? 'Ocean tema aktivirana 🌊' : 'Ljubičasta tema aktivirana 💜');
    }, 150);
    
    // Reset opacity transition
    setTimeout(function() {
        document.body.style.transition = '';
        document.body.style.opacity = '';
    }, 300);
}

function showThemeToast(msg) {
    var existing = document.getElementById('themeToast');
    if (existing) existing.remove();
    var toast = document.createElement('div');
    toast.id = 'themeToast';
    toast.style.cssText = [
        'position:fixed', 'bottom:1.5rem', 'right:1.5rem',
        'transform:translateY(20px)',
        'background:rgba(15,23,42,0.9)',
        'border:1.5px solid var(--clr-accent-border)',
        'color:#e2e8f0', 'padding:0.5rem 1rem',
        'border-radius:12px', 'font-size:0.75rem',
        'font-weight:500', 'z-index:99999',
        'backdrop-filter:blur(12px)',
        'box-shadow:0 10px 25px -5px rgba(0,0,0,0.4)',
        'transition:all 0.4s cubic-bezier(0.34,1.56,0.64,1)',
        'opacity:0', 'pointer-events:none'
    ].join(';');
    toast.textContent = msg;
    document.body.appendChild(toast);
    requestAnimationFrame(function() {
        requestAnimationFrame(function() {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        });
    });
    setTimeout(function() {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(-50%) translateY(30px) scale(0.95)';
        setTimeout(function() { toast.remove(); }, 400);
    }, 2500);
}
</script>

</body>
</html>