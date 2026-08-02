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
<meta name="description" content="Admin Panel — upravljajte učenicima, materijalima i testovima na platformi Školski materijali.">
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
<title>Admin Panel - Školski materijali</title>
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
  --clr-badge-bg:      rgba(126,34,206,0.2);
  --clr-badge-text:    #c084fc;
  --clr-badge-border:  rgba(168,85,247,0.3);
  --clr-user-from:     #a855f7;
  --clr-user-to:       #ec4899;
  --clr-logo-from:     #9333ea;
  --clr-logo-to:       #2563eb;
  --clr-role-text:     #c084fc;
  --clr-selection:     #a855f7;
  --clr-btn-grad-1:    #7f00ff;
  --clr-btn-grad-2:    #e100ff;
  --clr-btn-grad-h1:   #a100ff;
  --clr-btn-grad-h2:   #ff4ce1;
}

/* Ocean tema: Moderna mješavina plave i zelene na svijetloj podlozi */
html.theme-ocean {
  --clr-accent:        #0d9488; /* Teal 600 */
  --clr-accent-dark:   #0f766e; /* Teal 700 */
  --clr-accent-light:  #0d9488; /* Teal 400 */
  --clr-accent-glow:   rgba(13,148,136,0.15);
  --clr-accent-subtle: #f0fdfa; /* Emerald 50 */
  --clr-accent-card:   #ffffff;
  --clr-accent-border: rgba(13,148,136,0.25);
  --clr-accent-shadow: rgba(13,148,136,0.12);
  --clr-badge-bg:      #ecfdf5; /* Emerald 50 */
  --clr-badge-text:    #047857; /* Emerald 700 */
  --clr-badge-border:  #d1fae5;
  --clr-user-from:     #0d9488;
  --clr-user-to:       #10b981;
  --clr-logo-from:     #0d9488;
  --clr-logo-to:       #0891b2;
  --clr-role-text:     #0d9488;
  --clr-selection:     #0ea5e9;
  --clr-btn-grad-1:    #0369a1;
  --clr-btn-grad-2:    #059669;
  --clr-btn-grad-h1:   #0284c7;
  --clr-btn-grad-h2:   #10b981;
}

/* Primjena varijabli na elemente */
::selection { background-color: var(--clr-selection); color: #fff; }

.nav-link:hover,
.nav-link.active {
  background: linear-gradient(90deg, var(--clr-accent-subtle), transparent);
  color: var(--clr-accent-light);
  border-left-color: var(--clr-accent-light);
}
.nav-link:hover i { color: var(--clr-accent-light); }
body.sidebar-collapsed aside .nav-link.active {
  box-shadow: inset 3px 0 0 var(--clr-accent-light) !important;
  background: var(--clr-accent-subtle) !important;
}
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
   OCEAN TEMA — Kompletni Moderni Svjetli Dizajn
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
html.theme-ocean aside .border-gray-800 { border-color: #ccfbf1 !important; }

/* Header */
html.theme-ocean header {
  background: linear-gradient(180deg, rgba(255,255,255,0.98) 0%, rgba(240,253,250,0.95) 100%) !important;
  border-bottom: 1px solid #ccfbf1 !important;
  backdrop-filter: blur(12px) !important;
  box-shadow: 0 4px 24px rgba(13,148,136,0.10) !important;
}

/* Main area */
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
  transform: translateY(-2px);
  box-shadow: 0 12px 40px -8px rgba(13,148,136,0.22), 0 4px 16px rgba(8,145,178,0.12) !important;
}

/* === NAVIGACIONI LINKOVI === */
html.theme-ocean .nav-link { color: #64748b !important; transition: all 0.2s ease; }
html.theme-ocean .nav-link:hover,
html.theme-ocean .nav-link.active {
  color: #0d9488 !important;
  background: linear-gradient(90deg, rgba(240,253,250,0.9), rgba(236,254,255,0.5)) !important;
  border-left-color: #0d9488 !important;
}
html.theme-ocean .nav-link:hover i { color: #0d9488 !important; }
html.theme-ocean .section-label { color: #94a3b8 !important; }

/* === TEKST === */
html.theme-ocean .text-white { color: #0f172a !important; }
html.theme-ocean .hover\:text-white:hover,
html.theme-ocean .hover\:text-white:hover i { color: #ffffff !important; }

html.theme-ocean .text-gray-400 { color: #64748b !important; }
html.theme-ocean .text-gray-300 { color: #475569 !important; }
html.theme-ocean .text-gray-200 { color: #334155 !important; }
html.theme-ocean .text-gray-500 { color: #94a3b8 !important; }
html.theme-ocean .text-slate-200 { color: #1e293b !important; }

/* === POZADINE === */
html.theme-ocean .bg-gray-800 { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-900 { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-900\/50 { background: linear-gradient(135deg, rgba(248,250,252,0.9) 0%, rgba(240,253,250,0.85) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-800\/50 { background: linear-gradient(135deg, rgba(248,250,252,0.9) 0%, rgba(240,253,250,0.85) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-800\/40 { background: linear-gradient(135deg, rgba(248,250,252,0.8) 0%, rgba(240,253,250,0.75) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-800\/80 { background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,253,250,0.9) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-700\/40 { background: linear-gradient(135deg, rgba(240,253,250,0.7) 0%, rgba(236,254,255,0.65) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-700\/60 { background: linear-gradient(135deg, rgba(240,253,250,0.8) 0%, rgba(236,254,255,0.75) 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean .bg-gray-700\/50 { background: linear-gradient(135deg, rgba(240,253,250,0.7) 0%, rgba(236,254,255,0.65) 100%) !important; border-color: #ccfbf1 !important; }

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
html.theme-ocean textarea::placeholder { color: #94a3b8 !important; }
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

/* === BLUE → TEAL/CYAN OVERRIDE === */
html.theme-ocean .text-blue-400 { color: #0d9488 !important; }
html.theme-ocean .text-blue-300 { color: #0f766e !important; }
html.theme-ocean .bg-blue-600\/20 { background: linear-gradient(135deg, rgba(8,145,178,0.12), rgba(13,148,136,0.08)) !important; }
html.theme-ocean .bg-blue-500\/20 { background: linear-gradient(135deg, rgba(8,145,178,0.12), rgba(13,148,136,0.08)) !important; }
html.theme-ocean .bg-blue-600 { background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%) !important; }
html.theme-ocean .border-blue-500 { border-color: #0d9488 !important; }
html.theme-ocean .hover\:bg-blue-600:hover { background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%) !important; }
html.theme-ocean .hover\:bg-blue-500:hover { background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%) !important; }
html.theme-ocean .shadow-purple-500\/20 { --tw-shadow-color: rgba(13,148,136,0.2) !important; }
html.theme-ocean .hover\:shadow-purple-500\/40:hover { --tw-shadow-color: rgba(13,148,136,0.3) !important; }
html.theme-ocean .group:hover .group-hover\:bg-purple-600 { background-color: #0d9488 !important; }
html.theme-ocean .group:hover .group-hover\:text-purple-300 { color: #0891b2 !important; }
html.theme-ocean .hover\:shadow-\[0_0_12px_rgba\(168\,85\,247\,0\.4\)\]:hover { box-shadow: 0 0 12px rgba(13,148,136,0.3) !important; }

/* === MODALNI PROZORI === */
html.theme-ocean [id$="Content"],
html.theme-ocean [id$="Modal"] > div {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
  border-color: #ccfbf1 !important;
  box-shadow: 0 20px 60px rgba(13,148,136,0.12), 0 4px 16px rgba(8,145,178,0.10) !important;
}
html.theme-ocean [id$="Content"] .border-gray-700 { border-color: #ccfbf1 !important; }
html.theme-ocean [id$="Content"] h2 { color: #0f172a !important; }
html.theme-ocean [id$="Content"] label { color: #475569 !important; }
html.theme-ocean [id$="Content"] .text-gray-400 { color: #64748b !important; }

/* Modal backdrop */
html.theme-ocean .bg-black\/60 { background-color: rgba(15,23,42,0.25) !important; }

/* Modal icon containers */
html.theme-ocean .bg-gray-700 { background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important; border-color: #ccfbf1 !important; }

/* === DUGME ZA ZATVARANJE OPCIJA SEKCIJE I PREDMETA (SVIJETLI MOD) === */
html.theme-ocean button[onclick*="toggleSectionActionMenu"].is-active,
html.theme-ocean button[onclick*="toggleActionMenu"].is-active,
html.theme-ocean button[onclick*="toggleSectionActionMenu"]:has(.fa-times),
html.theme-ocean button[onclick*="toggleActionMenu"]:has(.fa-times) {
  background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%) !important;
  color: #0f172a !important;
  border-color: #0d9488 !important;
}

html.theme-ocean button[onclick*="toggleSectionActionMenu"].is-active i,
html.theme-ocean button[onclick*="toggleActionMenu"].is-active i,
html.theme-ocean button[onclick*="toggleSectionActionMenu"]:has(.fa-times) i,
html.theme-ocean button[onclick*="toggleActionMenu"]:has(.fa-times) i {
  color: #0f172a !important;
}

html.theme-ocean button[onclick*="toggleSectionActionMenu"].is-active:hover,
html.theme-ocean button[onclick*="toggleActionMenu"].is-active:hover,
html.theme-ocean button[onclick*="toggleSectionActionMenu"]:hover,
html.theme-ocean button[onclick*="toggleActionMenu"]:hover {
  background: linear-gradient(135deg, #0891b2 0%, #0d9488 100%) !important;
  color: #ffffff !important;
  border-color: #06b6d4 !important;
  box-shadow: 0 4px 14px rgba(8, 145, 178, 0.4) !important;
  transform: scale(1.08) !important;
}

html.theme-ocean button[onclick*="toggleSectionActionMenu"]:hover i,
html.theme-ocean button[onclick*="toggleActionMenu"]:hover i {
  color: #ffffff !important;
}

/* === TABELE === */
html.theme-ocean table .border-gray-600 { border-color: #ccfbf1 !important; }
html.theme-ocean table .border-gray-700 { border-color: #ccfbf1 !important; }
html.theme-ocean table .hover\:bg-gray-700\/60:hover { background: linear-gradient(90deg, rgba(240,253,250,0.9), rgba(236,254,255,0.8)) !important; }
html.theme-ocean .admin-table-row:hover { background: linear-gradient(90deg, rgba(240,253,250,0.85), rgba(236,254,255,0.75)) !important; }

/* === FILE LISTE === */
html.theme-ocean .bg-gray-800\/50 {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
  border-color: #ccfbf1 !important;
}
html.theme-ocean li.flex:hover { background: linear-gradient(90deg, rgba(240,253,250,0.9), rgba(236,254,255,0.8)) !important; border-color: #99f6e4 !important; }

/* === UPLOAD ZONA === */
html.theme-ocean #dropZone,
html.theme-ocean #testDropZone {
  background: linear-gradient(135deg, #f8fafc 0%, #f0fdfa 100%) !important;
  border-color: #ccfbf1 !important;
}
html.theme-ocean #dropZone:hover,
html.theme-ocean #testDropZone:hover {
  border-color: #0d9488 !important;
  background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important;
}
html.theme-ocean #dropZone .bg-gray-800,
html.theme-ocean #testDropZone .bg-gray-800 {
  background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
  border-color: #ccfbf1 !important;
}

/* === NOTIFIKACIONI DROPDOWN === */
html.theme-ocean #notificationDropdown {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
  border-color: #ccfbf1 !important;
  box-shadow: 0 8px 40px rgba(13,148,136,0.12), 0 4px 16px rgba(8,145,178,0.08) !important;
}
html.theme-ocean #notificationDropdown .bg-gray-800\/80 { background: linear-gradient(135deg, #f8fafc 0%, #f0fdfa 100%) !important; border-color: #ccfbf1 !important; }
html.theme-ocean #notificationDropdown .border-gray-700 { border-color: #ccfbf1 !important; }
html.theme-ocean #notificationDropdown .hover\:bg-gray-700:hover { background: linear-gradient(90deg, rgba(240,253,250,0.9), rgba(236,254,255,0.8)) !important; }
html.theme-ocean #notificationDropdown .bg-gray-700\/40 { background: linear-gradient(135deg, rgba(240,253,250,0.8), rgba(236,254,255,0.75)) !important; border-color: #ccfbf1 !important; }
html.theme-ocean #notificationDropdown .hover\:bg-gray-700\/60:hover { background: linear-gradient(135deg, rgba(240,253,250,0.9), rgba(236,254,255,0.85)) !important; border-color: #99f6e4 !important; }

/* === DROPDOWN MENJI === */
html.theme-ocean [id$="Dropdown"]:not(#notificationDropdown) {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
  border-color: #ccfbf1 !important;
  box-shadow: 0 8px 32px rgba(13,148,136,0.10), 0 4px 16px rgba(8,145,178,0.08) !important;
}
html.theme-ocean [id$="Dropdown"] .text-gray-300 { color: #475569 !important; }
html.theme-ocean [id$="Dropdown"] button:hover { background: linear-gradient(90deg, rgba(240,253,250,0.95), rgba(236,254,255,0.9)) !important; color: #0d9488 !important; }
html.theme-ocean [id$="Dropdown"] button i { transition: transform 0.2s ease, color 0.2s ease !important; }
html.theme-ocean [id$="Dropdown"] button:hover i,
html.theme-ocean #moveSectionDropdown button:hover i { color: #0d9488 !important; transform: scale(1.15) !important; filter: drop-shadow(0 2px 4px rgba(13,148,136,0.2)) !important; }
html.theme-ocean [id$="Dropdown"] .border-gray-700 { border-color: #ccfbf1 !important; }
html.theme-ocean [id$="Dropdown"] .bg-gray-900\/50 { background: linear-gradient(135deg, #f8fafc 0%, #f0fdfa 100%) !important; color: #475569 !important; border-color: #ccfbf1 !important; }

/* === CUSTOM SELECT DUGMAD === */
html.theme-ocean #uploadSectionBtn,
html.theme-ocean #moveSectionBtn,
html.theme-ocean #newUserClassBtn,
html.theme-ocean #editUserClassBtn {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
  border-color: #ccfbf1 !important;
  color: #1e293b !important;
}
html.theme-ocean #uploadSectionBtn:hover,
html.theme-ocean #moveSectionBtn:hover,
html.theme-ocean #newUserClassBtn:hover,
html.theme-ocean #editUserClassBtn:hover {
  background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important;
  border-color: #0d9488 !important;
}

/* === TOAST PORUKE === */
html.theme-ocean #successMsg {
  background: linear-gradient(135deg, #ffffff 0%, #f0fdfa 100%) !important;
  border-color: rgba(16,185,129,0.35) !important;
  color: #064e3b !important;
  box-shadow: 0 8px 32px rgba(16,185,129,0.12), 0 4px 16px rgba(13,148,136,0.08) !important;
}
html.theme-ocean #errorMsg {
  background: linear-gradient(135deg, #ffffff 0%, #fef2f2 100%) !important;
  border-color: rgba(239,68,68,0.3) !important;
  color: #7f1d1d !important;
  box-shadow: 0 8px 32px rgba(239,68,68,0.12), 0 4px 16px rgba(220,38,38,0.08) !important;
}

/* === LOGOUT DUGME === */
html.theme-ocean #logoutBtn {
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
  border-color: #ccfbf1 !important;
  color: #64748b !important;
}
html.theme-ocean #logoutBtn:hover {
  background: linear-gradient(135deg, #fff1f2 0%, #fee2e2 100%) !important;
  border-color: rgba(239,68,68,0.35) !important;
  color: #ef4444 !important;
}

/* === SIDEBAR COLLAPSE DUGME === */
html.theme-ocean #sidebarCollapseBtn {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
  border-color: #ccfbf1 !important;
  color: #64748b !important;
  box-shadow: 0 2px 12px rgba(13,148,136,0.08) !important;
}
html.theme-ocean #sidebarCollapseBtn:hover {
  background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important;
  border-color: #0d9488 !important;
  color: #0d9488 !important;
}

/* === BREADCRUMB === */
html.theme-ocean nav a.bg-gray-800\/40 {
  background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
  border-color: #ccfbf1 !important;
  color: #64748b !important;
}
html.theme-ocean nav a.bg-gray-800\/40:hover {
  background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important;
  border-color: #0d9488 !important;
  color: #0d9488 !important;
}

/* === SUBJECT ITEMS === */
html.theme-ocean .subject-item:not(.active):hover {
  background: linear-gradient(90deg, rgba(240,253,250,0.9), rgba(236,254,255,0.8)) !important;
  border-color: rgba(13,148,136,0.25) !important;
}
html.theme-ocean .subject-item.active {
  background: linear-gradient(to right, rgba(13,148,136,0.15), rgba(8,145,178,0.08)) !important;
  border-left-color: #0d9488 !important;
}

/* === HOVER EFEKTI === */
html.theme-ocean .hover\:bg-gray-700:hover { background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important; }
html.theme-ocean .hover\:bg-gray-800:hover { background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%) !important; }
html.theme-ocean .hover\:border-gray-600:hover { border-color: #99f6e4 !important; }

/* === FILE ITEM IKONE === */
html.theme-ocean .bg-gray-900\/50.border.border-gray-700\/50 {
  background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
  border-color: #ccfbf1 !important;
}

/* === SCROLLBAR U OCEAN TEMI === */
html.theme-ocean ::-webkit-scrollbar-thumb { background: #cbd5e1; }
html.theme-ocean ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

/* === SELECTION U OCEAN TEMI === */
html.theme-ocean ::selection { background-color: #0d9488; color: #ffffff; }

/* === COLLAPSED SIDEBAR AKTIVNI LINK === */
html.theme-ocean body.sidebar-collapsed aside .nav-link.active {
  box-shadow: inset 3px 0 0 #0d9488 !important;
  background: rgba(13,148,136,0.08) !important;
}

/* === ČEKBOKS SEKCIJA ZA PREDMETE === */
html.theme-ocean .bg-gray-900\/80 {
  background-color: #f8fafc !important;
  border-color: #e2e8f0 !important;
}
html.theme-ocean label.hover\:bg-gray-800:hover { background-color: #f0fdfa !important; }

/* === NOTIFIKACIONI MODAL TEKST === */
html.theme-ocean #viewNotifMessage {
  background-color: #f8fafc !important;
  border-color: #e2e8f0 !important;
  color: #1e293b !important;
}

/* === "UČITAJ JOŠ" DUGME === */
html.theme-ocean #loadMoreNotifsContainer button,
html.theme-ocean #loadMoreUsersContainer button {
  background-color: #f8fafc !important;
  border-color: #e2e8f0 !important;
  color: #0d9488 !important;
}
html.theme-ocean #loadMoreNotifsContainer button:hover,
html.theme-ocean #loadMoreUsersContainer button:hover {
  background-color: #f0fdfa !important;
  border-color: #0d9488 !important;
  color: #0f766e !important;
}

/* === PAGINATION === */
html.theme-ocean .px-3.py-1.bg-gray-700 {
  background-color: #f1f5f9 !important;
  color: #475569 !important;
}
html.theme-ocean .px-3.py-1.bg-gray-700:hover { background-color: #f0fdfa !important; color: #0d9488 !important; }

/* === IKONA U MODAL HEADERU === */
html.theme-ocean .w-10.h-10.rounded-lg.bg-gray-700 { background-color: #f0fdfa !important; }
html.theme-ocean .w-12.h-12.rounded-2xl { background-color: #f0fdfa !important; }

/* === GLOBALNI TOOLTIP (Ocean Tema) - Force visibility === */
html.theme-ocean #globalTooltip,
html.theme-ocean #globalTooltip.text-white {
  background-color: #1f2937 !important;
  border-color: #374151 !important;
  color: #ffffff !important; /* Forsira belu boju teksta unutar tooltipa */
  box-shadow: 0 4px 20px rgba(0,0,0,0.3), 0 0 12px rgba(13,148,136,0.2) !important;
}

/* === AKTIVNI MODOVI NA KARTICAMA (Ocean Tema) === */
/* Osigurava da kartice "popuju" sa bojama kada je uključen mod za preimenovanje/arhiviranje/brisanje */
html.theme-ocean .subject-card-item.border-blue-500 { background: rgba(59, 130, 246, 0.08) !important; border-color: #3b82f6 !important; }
html.theme-ocean .subject-card-item.border-yellow-500 { background: rgba(234, 179, 8, 0.08) !important; border-color: #eab308 !important; }
html.theme-ocean .subject-card-item.border-red-500 { background: rgba(239, 68, 68, 0.08) !important; border-color: #ef4444 !important; }

/* Prisilno bela boja ikona na aktivnim dugmadima modova */
html.theme-ocean #renameModeBtn.bg-blue-600 i,
html.theme-ocean #archiveModeBtn.bg-yellow-600 i,
html.theme-ocean #deleteModeBtn.bg-red-600 i { color: #ffffff !important; }

/* === MOBILE MENU === */
html.theme-ocean #mobileOverlay { background-color: rgba(15,23,42,0.35) !important; }

@layer utilities {
  .animate-fadeIn { animation: fadeIn 0.5s ease-out both; }
  @keyframes fadeIn { 0% { opacity:0; transform: scale(0.97); } 100% { opacity:1; transform: scale(1); } }
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
  aside { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
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
    body.sidebar-collapsed aside .user-container { justify-content: center; padding-left: 0; padding-right: 0; gap: 0; margin-bottom: 0.75rem; }
    
    body.sidebar-collapsed #sidebarCollapseBtn i { transform: rotate(180deg); }
    
    /* Logout dugme - isti kvadratni izgled */
    body.sidebar-collapsed aside #logoutBtn {
        width: 3.25rem; height: 3.25rem; justify-content: center; align-items: center; margin-left: auto; margin-right: auto; padding: 0; border-radius: 0.75rem;
    }
    body.sidebar-collapsed aside #logoutBtn i { margin-right: 0; font-size: 1.3rem; }
  }
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
</style>
</head>
<body class="bg-[#0f172a] text-slate-200 h-screen overflow-hidden selection:bg-purple-500 selection:text-white">

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
                <i class="fas fa-shield-alt text-white text-sm"></i>
            </div>
            <span class="font-bold text-lg tracking-tight text-white logo-text">AdminPanel</span>
        </div>
        <button id="mobileCloseSidebar" class="md:hidden text-gray-400 hover:text-white transition-colors p-1">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6 px-4 space-y-1">
        <div class="px-2 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider section-label">Glavni izbornik</div>
        <a href="index.php?route=admin" class="nav-link <?= (!$selected_subject) ? 'active' : '' ?>" title="Početna">
            <i class="fas fa-home"></i> <span>Početna</span>
        </a>
        
        <div class="pt-6 pb-2 px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider section-label">Administracija</div>
        <button id="openUserModal" class="nav-link w-full text-left" title="Kreiraj učenika">
            <i class="fas fa-user-plus"></i> <span>Kreiraj učenika</span>
        </button>
        <button id="openManageUsers" class="nav-link w-full text-left" title="Upravljaj učenicima">
            <i class="fas fa-users"></i> <span>Upravljaj učenicima</span>
        </button>
        <button id="openManageClasses" class="nav-link w-full text-left" title="Upravljaj odjeljenjima">
            <i class="fas fa-chalkboard-teacher"></i> <span>Upravljaj odjeljenjima</span>
        </button>

        <?php if($subjects && $subjects->num_rows > 0): ?>
        <div class="pt-6 pb-2 px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider section-label">Predmeti</div>
        <?php 
            // Reset pointer and separate active and archived subjects
            $subjects->data_seek(0);
            $active_subjects = [];
            $archived_subjects = [];
            
            while($row = $subjects->fetch_assoc()) {
                if (!empty($row['is_archived'])) {
                    $archived_subjects[] = $row;
                } else {
                    $active_subjects[] = $row;
                }
            }
            
            // Display active subjects
            foreach($active_subjects as $row): 
        ?>
        <a href="index.php?route=admin&subject=<?= (int)$row['id'] ?>" class="nav-link <?= ((int)$row['id'] === (int)$selected_subject) ? 'active' : '' ?>" title="<?= htmlspecialchars($row['name']) ?>">
            <i class="fas fa-folder text-gray-600"></i>
            <span class="truncate"><?= htmlspecialchars($row['name']) ?></span>
        </a>
        <?php endforeach; 
        
        // Display archived subjects in collapsible section
        if (!empty($archived_subjects)): 
        ?>
        <div class="pt-4 mt-4 border-t border-gray-700/50">
            <button onclick="toggleArchivedSubjects()" class="nav-link w-full text-left justify-between px-2 py-2 text-gray-500 hover:text-gray-300" title="Arhivirani predmeti">
                <div class="flex items-center gap-2">
                    <i class="fas fa-archive text-yellow-500/60"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider">Arhiva (<?= count($archived_subjects) ?>)</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="archiveToggleIcon"></i>
            </button>
            
            <div id="archivedSubjectsContainer" class="hidden pl-2 space-y-0.5 mt-2 max-h-0 overflow-hidden transition-all duration-300">
                <?php foreach($archived_subjects as $row): ?>
                <a href="index.php?route=admin&subject=<?= (int)$row['id'] ?>" class="nav-link <?= ((int)$row['id'] === (int)$selected_subject) ? 'active' : '' ?> opacity-60 hover:opacity-100" title="<?= htmlspecialchars($row['name']) ?>">
                    <i class="fas fa-archive text-yellow-500/60"></i>
                    <span class="truncate text-gray-400"><?= htmlspecialchars($row['name']) ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif;
        
        $subjects->data_seek(0);
        ?>
        <?php endif; ?>
    </nav>

    <div class="p-4 border-t border-gray-800">
        <div class="flex items-center gap-2 mb-4 px-2 user-container">
            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white shadow-md flex-shrink-0" style="background: linear-gradient(135deg, var(--clr-user-from), var(--clr-user-to))">
                <i class="fas fa-user text-xs"></i>
            </div>
            <div class="flex flex-col user-details overflow-hidden flex-1 min-w-0">
                <span class="text-sm font-semibold text-white truncate"><?= htmlspecialchars($_SESSION['username']) ?></span>
                <span class="text-xs truncate" style="color: var(--clr-role-text)">Administrator</span>
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
            <span class="font-bold text-lg">AdminPanel</span>
        </div>
        
        <!-- Breadcrumbs / Title -->
        <nav class="hidden md:flex items-center gap-2 text-sm font-medium">
            <a href="index.php?route=admin" class="text-gray-400 hover:text-purple-400 transition-colors flex items-center gap-2 bg-gray-800/40 hover:bg-gray-800/80 px-3 py-1.5 rounded-lg border border-gray-700/50">
                <i class="fas fa-home"></i> Početna
            </a>
            <?php if($selected_subject > 0): ?>
                <?php 
                $subject_name = "Uređivanje predmeta";
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
                <input type="text" placeholder="Brza pretraga (Ctrl+K)..." onclick="toggleCommandPalette()" readonly class="bg-gray-800 border border-gray-700 text-gray-300 text-sm rounded-full pl-9 pr-4 py-1.5 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 w-64 placeholder-gray-600 cursor-pointer">
            </div>
            <div class="relative">
                <button id="notificationBell" class="relative p-2 text-gray-400 hover:text-white transition">
                    <i class="fas fa-bell"></i>
                    <?php if($unread_count > 0): ?><span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-gray-900" id="bellNotificationDot"></span><?php endif; ?>
                </button>
                
                <!-- Dropdown meni -->
                <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl z-[9999] overflow-hidden transform scale-95 opacity-0 transition-all duration-200 origin-top-right">
                    <div class="p-3 border-b border-gray-700 bg-gray-800/80 flex justify-between items-center">
                        <span class="font-bold text-white text-sm">Obavještenja</span>
                        <div class="flex items-center gap-2">
                            <?php if($unread_count > 0): ?>
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
                                elseif ($type === 'urgent') { $icon = 'fa-exclamation-circle text-red-400'; $bgIcon = 'bg-red-500/20 border-red-500/30'; }
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
    <?php if($is_master): ?>
    <!-- ADMIN DASHBOARD STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 animate-fadeIn">
      <div class="glass-card p-6 rounded-2xl border-l-4 border-purple-500">
        <p class="text-gray-400 text-sm">Ukupno admina</p>
        <p class="text-3xl font-bold text-purple-300"><?= $stats['admins'] ?></p>
      </div>
      <div class="glass-card p-6 rounded-2xl border-l-4 border-pink-500">
        <p class="text-gray-400 text-sm">Ukupno učenika</p>
        <p class="text-3xl font-bold text-pink-300"><?= $stats['students'] ?></p>
      </div>
      <div class="glass-card p-6 rounded-2xl border-l-4 border-blue-500">
        <p class="text-gray-400 text-sm">Ukupno predmeta</p>
        <p class="text-3xl font-bold text-blue-300"><?= $stats['subjects'] ?></p>
      </div>
      <div class="glass-card p-6 rounded-2xl border-l-4 border-cyan-500">
        <p class="text-gray-400 text-sm">Ukupno materijala</p>
        <p class="text-3xl font-bold text-cyan-300"><?= $stats['files'] ?></p>
      </div>
      <div class="glass-card p-6 rounded-2xl border-l-4 border-teal-500">
        <p class="text-gray-400 text-sm">Ukupno testova</p>
        <p class="text-3xl font-bold text-teal-300"><?= $stats['tests'] ?></p>
      </div>
      <div class="glass-card p-6 rounded-2xl border-l-4 border-green-500">
        <p class="text-gray-400 text-sm">Predati radovi</p>
        <p class="text-3xl font-bold text-green-300"><?= $stats['works'] ?></p>
      </div>
    </div>

    <!-- MODERN CHARTS SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fadeIn" style="animation-delay: 0.05s">
        <div class="glass-card p-6 rounded-2xl">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-purple-400"></i> Distribucija korisnika
            </h3>
            <div class="h-64 relative">
                <canvas id="usersChart"></canvas>
            </div>
        </div>
        <div class="glass-card p-6 rounded-2xl">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-cyan-400"></i> Pregled sadržaja
            </h3>
            <div class="h-64 relative">
                <canvas id="contentChart"></canvas>
            </div>
        </div>
    </div>

    <div class="glass-card p-6 sm:p-8 rounded-2xl animate-fadeIn" style="animation-delay: 0.1s">
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
      <?php if($admin_overview && $admin_overview->num_rows > 0): ?>
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
          <tbody>
            <?php while($adminRow = $admin_overview->fetch_assoc()): ?>
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
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <p class="text-gray-500 text-sm italic ml-2">Nema dostupnih podataka o administratorima.</p>
      <?php endif; ?>
    </div>
    
    <div class="glass-card p-6 sm:p-8 rounded-2xl animate-fadeIn" style="animation-delay: 0.2s">
      <h2 class="text-xl sm:text-2xl font-semibold text-white mb-4">Korisnici (globalni pregled)</h2>
      <?php if($users && $users->num_rows > 0): ?>
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
              <td class="p-3 text-gray-400"><?= htmlspecialchars($u['created_by']) ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <?php if($users->num_rows == 20): ?>
        <div class="p-3 text-center border-t border-gray-700 mt-2" id="loadMoreUsersContainer">
            <button type="button" onclick="loadMoreUsers()" class="text-xs text-purple-400 hover:text-white transition-colors bg-gray-800 border border-gray-700 rounded-lg px-6 py-2.5 font-medium" title="Učitaj još korisnika">Učitaj još...</button>
        </div>
        <?php endif; ?>
      </div>
      <?php else: ?>
      <p class="text-gray-500 text-sm italic ml-2">Nema korisnika za prikaz.</p>
      <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="glass-card p-6 sm:p-8 rounded-2xl animate-fadeIn">
      <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-white flex items-center gap-2"><i class="fas fa-layer-group text-purple-400"></i> Moji predmeti</h2>
          
          <?php if($subjects && $subjects->num_rows > 0): ?>
          <div class="flex items-center justify-end gap-2 z-30">
              <button onclick="toggleActionMenu()" id="actionMenuToggleBtn" class="p-2 text-gray-400 hover:text-white bg-gray-800/50 rounded-lg border border-gray-700 transition-all duration-300 shadow-sm flex items-center justify-center w-9 h-9" title="Opcije predmeta">
                  <i class="fas fa-bars transition-transform duration-300"></i>
              </button>
              <div id="actionBtnsContainer" class="max-w-0 opacity-0 overflow-hidden transition-all duration-300 ease-in-out flex gap-2">
                  <button id="renameModeBtn" onclick="toggleRenameMode()" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white w-9 h-9 rounded-lg border border-blue-500/30 flex items-center justify-center transition-all shadow-sm flex-shrink-0" title="Preimenuj predmet">
                      <i class="fas fa-edit"></i>
                  </button>
                  <button id="archiveModeBtn" onclick="toggleArchiveMode()" class="bg-yellow-600/20 text-yellow-400 hover:bg-yellow-600 hover:text-white w-9 h-9 rounded-lg border border-yellow-500/30 flex items-center justify-center transition-all shadow-sm flex-shrink-0" title="Arhiviraj predmet">
                      <i class="fas fa-archive"></i>
                  </button>
                  <button id="deleteModeBtn" onclick="toggleDeleteMode()" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 rounded-lg border border-red-500/30 flex items-center justify-center transition-all shadow-sm flex-shrink-0" title="Obriši predmet">
                      <i class="fas fa-trash-alt"></i>
                  </button>
              </div>
          </div>
          <?php endif; ?>
      </div>
      
      <?php if($subjects && $subjects->num_rows > 0): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <?php while($row = $subjects->fetch_assoc()): 
        $isArchived = (isset($row['is_archived']) && $row['is_archived'] == 1);
      ?>
        <div onclick='handleSubjectClick(event, <?= $row['id'] ?>, <?= htmlspecialchars(json_encode($row['name']), ENT_QUOTES, "UTF-8") ?>, <?= $isArchived ? "true" : "false" ?>)' class="subject-card-item glass-card p-5 rounded-xl cursor-pointer card-hover group relative overflow-hidden flex items-center justify-between border-2 border-transparent transition-all duration-300 <?= $isArchived ? 'opacity-60 grayscale-[0.5]' : '' ?>" data-archived="<?= $isArchived ? '1' : '0' ?>">
            <div class="absolute -right-4 -top-4 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-book text-7xl text-purple-500 transform rotate-12"></i>
            </div>
            <div class="flex items-center gap-4 z-10">
                <div class="w-12 h-12 rounded-lg bg-gray-800 border border-gray-700 flex items-center justify-center text-purple-400 group-hover:bg-purple-600 group-hover:text-white transition-colors shadow-lg flex-shrink-0">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-white leading-tight group-hover:text-purple-300 transition-colors mb-1">
                        <?= htmlspecialchars($row['name']) ?>
                        <?php if($isArchived): ?><span class="ml-2 bg-yellow-500/20 text-yellow-500 text-[10px] px-1.5 py-0.5 rounded border border-yellow-500/30 uppercase tracking-tighter">Arhiva</span><?php endif; ?>
                    </h3>
                    <span class="text-xs text-gray-500 group-hover:text-gray-400 transition-colors"><?= $isArchived ? 'Arhivirano (Samo pregled)' : 'Klikni za upravljanje' ?></span>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 w-0 group-hover:w-full transition-all duration-500"></div>
        </div>
      <?php endwhile; ?>
      </div>
      <?php else: ?>
        <p class="text-gray-500 text-sm italic text-center py-8">Nema kreiranih predmeta.</p>
      <?php endif; ?>

      <form method="post" class="mt-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-folder-plus text-gray-500 group-focus-within:text-purple-500 transition-colors duration-300"></i>
            </div>
            <input type="text" name="new_subject" placeholder="Naziv novog predmeta..." 
                class="block w-full pl-12 pr-32 py-4 rounded-2xl border border-gray-700 bg-gray-900/50 text-gray-100 placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all shadow-inner text-base">
            <div class="absolute inset-y-0 right-2 flex items-center">
                <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                    <i class="fas fa-plus"></i> <span>Kreiraj</span>
                </button>
            </div>
        </div>
      </form>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <?php if($selected_subject > 0): ?>
    <div class="glass-card p-4 sm:p-8 rounded-2xl flex flex-col gap-6 animate-fadeIn relative z-40">
      <div class="flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0 border-b border-gray-700 pb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-white text-center sm:text-left flex items-center justify-center sm:justify-start gap-3"><i class="fas fa-folder-open text-purple-400"></i> Materijali</h2>
        <div class="flex gap-3">
          <form method="post" class="flex gap-2 items-center">
            <input type="hidden" name="new_section" value="1">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="text" id="sectionInput" name="section_name" placeholder="Nova sekcija..." class="bg-gray-700 text-white rounded-lg text-sm transition-all duration-300 w-0 p-0 border-none opacity-0 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500" required>
            <button type="button" id="cancelSectionBtn" onclick="cancelSectionInput(event)" class="hidden text-gray-400 hover:text-red-400 transition-colors w-8 h-8 flex items-center justify-center rounded-lg" title="Otkaži"><i class="fas fa-times"></i></button>
            <button type="button" id="sectionBtn" onclick="toggleSectionInput(this, event)" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-purple-500/30" title="Dodaj sekciju"><i class="fas fa-folder-plus"></i></button>
          </form>
          <button id="openUpload" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-purple-500/30" title="Dodaj materijal"><i class="fas fa-upload"></i></button>
        </div>
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
          <div class="flex items-center justify-between w-full sm:w-auto mb-2 sm:mb-0">
            <div class="flex items-center gap-3 truncate pr-2">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gray-900/50 border border-gray-700/50 flex items-center justify-center flex-shrink-0">
                    <i class="fas <?= $iconClass ?> <?= $iconColor ?> text-base sm:text-lg"></i>
                </div>
                <span class="text-gray-200 font-medium text-sm sm:text-base truncate leading-tight"><?= htmlspecialchars(pathinfo($file['filename'], PATHINFO_FILENAME)) ?></span>
            </div>
            <button type="button" class="sm:hidden bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white p-2 rounded-lg transition-colors border border-purple-500/30 flex-shrink-0" onclick="toggleMobileMenu(this)"><i class="fas fa-ellipsis-v w-4 h-4 flex items-center justify-center"></i></button>
          </div>
          <div class="mobile-menu hidden sm:flex items-center justify-center sm:justify-end gap-2 w-full sm:w-auto sm:opacity-0 group-hover:opacity-100 transition-opacity">
            <a href="<?= $file['filepath'] ?>" target="_blank" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Preuzmi"><i class="fas fa-download"></i></a>
            <button onclick="openRenameFileModal(<?= $file['id'] ?>, '<?= htmlspecialchars($file['filename'], ENT_QUOTES) ?>')" class="bg-cyan-600/20 text-cyan-400 hover:bg-cyan-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Preimenuj"><i class="fas fa-edit"></i></button>
            <button onclick="openMoveModal('file', <?= $file['id'] ?>, <?= $file['section_id'] ?? 0 ?>)" class="bg-yellow-600/20 text-yellow-400 hover:bg-yellow-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Premjesti"><i class="fas fa-exchange-alt"></i></button>
            <button onclick="showDeleteModal('file', <?= $file['id'] ?>, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Obriši"><i class="fas fa-trash-alt"></i></button>
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
                        <?php if (!empty($sec['hidden'])): ?>
                            <span class="ml-2 px-2 py-0.5 rounded text-[10px] font-bold bg-gray-700/50 text-gray-400 border border-gray-600" title="Sekcija je sakrivena od učenika">
                                <i class="fas fa-eye-slash mr-1"></i>SAKRIVENO
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="flex gap-1 items-center" onclick="event.stopPropagation()">
                        <div id="sectionActionBtns-<?= $sec['id'] ?>" class="max-w-0 opacity-0 overflow-hidden transition-all duration-300 ease-in-out flex gap-1">
                            <form action="index.php?route=admin&subject=<?= $selected_subject ?>" method="POST" class="inline m-0">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="toggle_section_hidden" value="1">
                                <input type="hidden" name="section_id" value="<?= $sec['id'] ?>">
                                <?php if (!empty($sec['hidden'])): ?>
                                    <input type="hidden" name="hidden" value="0">
                                    <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white w-8 h-8 flex items-center justify-center rounded-lg transition-colors flex-shrink-0" title="Prikaži sekciju učenicima"><i class="fas fa-eye text-sm"></i></button>
                                <?php else: ?>
                                    <input type="hidden" name="hidden" value="1">
                                    <button type="submit" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white w-8 h-8 flex items-center justify-center rounded-lg transition-colors flex-shrink-0" title="Sakrij sekciju od učenika"><i class="fas fa-eye-slash text-sm"></i></button>
                                <?php endif; ?>
                            </form>
                            <button onclick='openRenameSectionModal(<?= $sec['id'] ?>, <?= htmlspecialchars(json_encode($sec['name']), ENT_QUOTES, "UTF-8") ?>)' class="bg-cyan-600/20 text-cyan-400 hover:bg-cyan-600 hover:text-white w-8 h-8 flex items-center justify-center rounded-lg transition-colors flex-shrink-0" title="Preimenuj sekciju"><i class="fas fa-edit text-sm"></i></button>
                            <button onclick="showDeleteModal('section', <?= $sec['id'] ?>, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-8 h-8 flex items-center justify-center rounded-lg transition-colors flex-shrink-0" title="Obriši sekciju"><i class="fas fa-trash-alt text-sm"></i></button>
                        </div>
                        <button onclick="toggleSectionActionMenu(this, <?= $sec['id'] ?>)" class="text-gray-400 hover:text-white bg-gray-800/50 hover:bg-gray-700 rounded-lg border border-gray-700 transition-all duration-300 shadow-sm flex items-center justify-center w-8 h-8" title="Opcije sekcije">
                            <i class="fas fa-bars transition-transform duration-300"></i>
                        </button>
                    </div>
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
                      <div class="flex items-center justify-between w-full sm:w-auto mb-2 sm:mb-0">
                        <div class="flex items-center gap-3 truncate pr-2">
                            <div class="w-10 h-10 rounded-lg bg-gray-900/50 border border-gray-700/50 flex items-center justify-center flex-shrink-0">
                                <i class="fas <?= $iconClass ?> <?= $iconColor ?> text-lg"></i>
                            </div>
                            <span class="text-gray-200 font-medium text-sm sm:text-base break-words leading-tight"><?= htmlspecialchars(pathinfo($file['filename'], PATHINFO_FILENAME)) ?></span>
                        </div>
                        <button type="button" class="sm:hidden bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white p-2 rounded-lg transition-colors border border-purple-500/30 flex-shrink-0" onclick="toggleMobileMenu(this)"><i class="fas fa-ellipsis-v w-4 h-4 flex items-center justify-center"></i></button>
                      </div>
                      <div class="mobile-menu hidden sm:flex items-center justify-center sm:justify-end gap-2 w-full sm:w-auto sm:opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="<?= $file['filepath'] ?>" target="_blank" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Preuzmi"><i class="fas fa-download"></i></a>
                        <button onclick='openRenameFileModal(<?= $file['id'] ?>, <?= htmlspecialchars(json_encode($file['filename']), ENT_QUOTES, "UTF-8") ?>)' class="bg-cyan-600/20 text-cyan-400 hover:bg-cyan-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Preimenuj"><i class="fas fa-edit"></i></button>
                        <button onclick="openMoveModal('file', <?= $file['id'] ?>, <?= $file['section_id'] ?? 0 ?>)" class="bg-yellow-600/20 text-yellow-400 hover:bg-yellow-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Premjesti"><i class="fas fa-exchange-alt"></i></button>
                        <button onclick="showDeleteModal('file', <?= $file['id'] ?>, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Obriši"><i class="fas fa-trash-alt"></i></button>
                      </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
                </ul>
            </li>
        <?php endforeach; ?>
      </ul>
      <?php else: ?>
        <p class="text-gray-500 text-sm italic ml-2">Nema još materijala za ovaj predmet.</p>
      <?php endif; ?>
    </div>

    <div class="glass-card p-4 sm:p-8 rounded-2xl flex flex-col gap-6 animate-fadeIn relative z-30" style="animation-delay: 0.1s">
      <div class="flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0 border-b border-gray-700 pb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-white text-center sm:text-left flex items-center justify-center sm:justify-start gap-3"><i class="fas fa-file-signature text-purple-400"></i> Testovi</h2>
        <div class="flex gap-3">
          <button id="openCreateTest" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-purple-500/30" title="Napravi test"><i class="fas fa-magic"></i></button>
          <button id="openTestUpload" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-purple-500/30" title="Dodaj test"><i class="fas fa-upload"></i></button>
        </div>
      </div>

      <?php if(!empty($general_tests)): ?>
      <ul class="space-y-2">
            <?php foreach($general_tests as $test): ?>
        <li class="flex flex-col sm:flex-row sm:items-center justify-between p-3 sm:px-4 rounded-xl bg-gray-800/50 border border-gray-700/50 hover:bg-gray-800 hover:border-gray-600 transition-all gap-2 group">
          <?php
          $extension = strtolower(pathinfo($test['filename'], PATHINFO_EXTENSION));
          $name_without_ext = pathinfo($test['filepath'], PATHINFO_FILENAME); 
          $isHidden = isset($test['hidden']) && $test['hidden'] == 1;
          $isDbTest = isset($test['is_db_test']) && $test['is_db_test'] == 1;
          $testUrl = $isDbTest ? "index.php?route=take_test&id=" . $test['id'] : htmlspecialchars($test['filepath']);
          $eyeIcon = $isHidden ? 'fa-eye' : 'fa-eye-slash';
          $eyeText = $isHidden ? 'Prikaži test' : 'Sakrij test';
          $eyeClass = $isHidden ? 'bg-yellow-600/20 text-yellow-400 hover:bg-yellow-600 hover:text-white' : 'bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white';
          if ($extension === 'html' || $isDbTest): ?>
            <div class="flex items-center justify-between w-full sm:w-auto mb-2 sm:mb-0">
                <div class="flex flex-col sm:flex-row sm:items-center pr-2 overflow-hidden">
                    <a href="<?= $testUrl ?>" target="_blank" class="flex items-center gap-2 text-blue-400 hover:text-blue-300 font-medium text-sm sm:text-base truncate">
                        <i class="fas fa-clipboard-check text-purple-400 flex-shrink-0"></i>
                        <span class="truncate"><?= htmlspecialchars(pathinfo($test['filename'], PATHINFO_FILENAME)) ?></span>
                    </a>
                    <?php if($isHidden): ?><span class="text-xs text-yellow-400 border border-yellow-400 px-1 rounded w-fit mt-1 sm:mt-0 sm:ml-2">Sakriven</span><?php endif; ?>
                </div>
                <button type="button" class="sm:hidden bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white p-2 rounded-lg transition-colors border border-purple-500/30 flex-shrink-0" onclick="toggleMobileMenu(this)"><i class="fas fa-ellipsis-v w-4 h-4 flex items-center justify-center"></i></button>
            </div>
            <div class="mobile-menu hidden sm:flex gap-2 w-full sm:w-auto flex-wrap justify-center sm:justify-end sm:opacity-0 group-hover:opacity-100 transition-opacity">
              <a href="?route=admin&toggle_test_visibility=<?= $test['id'] ?>&subject=<?= $selected_subject ?>" class="<?= $eyeClass ?> w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="<?= $eyeText ?>"><i class="fas <?= $eyeIcon ?>"></i></a>
              <a href="index.php?route=view_test_results&test_id=<?= $test['id'] ?>&test_name=<?= urlencode($name_without_ext) ?>&subject_id=<?= $selected_subject ?>" class="bg-emerald-600/20 text-emerald-400 hover:bg-emerald-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Pregledaj odgovore"><i class="fas fa-chart-bar"></i></a>
              <a href="index.php?route=download_test_answers&test_id=<?= $test['id'] ?>&test_name=<?= urlencode($name_without_ext) ?>&subject_id=<?= $selected_subject ?>&format=csv" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Preuzmi odgovore (CSV)"><i class="fas fa-file-csv"></i></a>
              <a href="edit_test.php?id=<?= $test['id'] ?>" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Izmijeni"><i class="fas fa-edit"></i></a>
              <button onclick="showDeleteModal('test', <?= $test['id'] ?>, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Obriši"><i class="fas fa-trash-alt"></i></button>
            </div>
          <?php else: ?>
            <div class="flex items-center justify-between w-full sm:w-auto mb-2 sm:mb-0">
                <div class="flex flex-col sm:flex-row sm:items-center pr-2 overflow-hidden">
                    <span class="flex items-center gap-2 text-sm sm:text-base truncate text-gray-200">
                        <i class="fas fa-clipboard-check text-purple-400 flex-shrink-0"></i>
                        <span class="truncate"><?= htmlspecialchars(pathinfo($test['filename'], PATHINFO_FILENAME)) ?></span>
                    </span>
                    <?php if($isHidden): ?><span class="text-xs text-yellow-400 border border-yellow-400 px-1 rounded w-fit mt-1 sm:mt-0 sm:ml-2">Sakriven</span><?php endif; ?>
                </div>
                <button type="button" class="sm:hidden bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white p-2 rounded-lg transition-colors border border-purple-500/30 flex-shrink-0" onclick="toggleMobileMenu(this)"><i class="fas fa-ellipsis-v w-4 h-4 flex items-center justify-center"></i></button>
            </div>
            <div class="mobile-menu hidden sm:flex gap-2 sm:gap-3 w-full sm:w-auto flex-wrap justify-center sm:justify-end opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity">
              <a href="?route=admin&toggle_test_visibility=<?= $test['id'] ?>&subject=<?= $selected_subject ?>" class="<?= $eyeClass ?> w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="<?= $eyeText ?>"><i class="fas <?= $eyeIcon ?>"></i></a>
              <a href="<?= $testUrl ?>" target="_blank" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Preuzmi"><i class="fas fa-download"></i></a>
              <button onclick="showDeleteModal('test', <?= $test['id'] ?>, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Obriši"><i class="fas fa-trash-alt"></i></button>
            </div>
          <?php endif; ?>
        </li>
            <?php endforeach; ?>
      </ul>
      <?php else: ?>
        <p class="text-gray-500 text-sm italic ml-2">Nema jos testova za ovaj predmet.</p>
      <?php endif; ?>
    </div>

    <div id="student-works" class="glass-card p-6 sm:p-8 rounded-2xl flex flex-col gap-6 animate-fadeIn relative z-20" style="animation-delay: 0.2s">
      <div class="flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0 border-b border-gray-700 pb-4">
        <h2 class="text-xl sm:text-2xl font-bold text-white text-center sm:text-left flex items-center justify-center sm:justify-start gap-3"><i class="fas fa-user-graduate text-purple-400"></i> Radovi učenika</h2>
        <div class="flex flex-wrap justify-center sm:justify-end gap-3">
          <!-- Filter Group -->
          <div class="flex items-center">
              <!-- Filter Button (Sortiraj) -->
              <button type="button" onclick="toggleFilterSlide()" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-blue-500/30 <?= $date_filter !== 'all' ? 'bg-blue-600 !text-white' : '' ?>" title="Sortiraj">
                  <i class="fas fa-filter"></i>
              </button>
              
              <!-- Sliding Container -->
              <div id="filterMenuWrapper" class="relative z-20 flex items-center transition-all duration-300 ease-in-out w-0 ml-0 opacity-0 pointer-events-none overflow-hidden">
                  <div class="w-[180px] shrink-0">
                      <button id="filterTriggerBtn" type="button" onclick="document.getElementById('customSortDropdown').classList.toggle('hidden')" class="w-full bg-gray-800 text-white text-sm rounded-lg border border-gray-600 px-3 py-1.5 flex items-center justify-between hover:border-purple-500 hover:bg-gray-700 transition-all shadow-md">
                          <span class="truncate font-medium flex items-center gap-2">
                            <?php 
                            if($date_filter === 'today') echo '<i class="fas fa-calendar-day text-blue-400"></i> Danas';
                            elseif($date_filter === 'week') echo '<i class="fas fa-calendar-week text-blue-400"></i> Zadnjih 7 dana';
                            elseif($date_filter === 'month') echo '<i class="fas fa-calendar text-blue-400"></i> Zadnjih 30 dana';
                            else echo '<i class="fas fa-calendar-alt text-gray-400"></i> Svi datumi';
                            ?>
                          </span>
                          <i class="fas fa-chevron-down text-[10px] text-gray-400 ml-1"></i>
                      </button>
                      
                      <div id="customSortDropdown" class="hidden absolute left-0 right-2 top-full mt-2 min-w-[200px] bg-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden animate-fadeIn z-50">
                          <div class="p-2 border-b border-gray-700 bg-gray-900/50 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                              <i class="fas fa-calendar-check text-blue-400 mb-0.5"></i> Filtriraj
                          </div>
                          <div class="flex flex-col p-1.5 gap-1">
                              <a href="index.php?route=admin&subject=<?= $selected_subject ?>&date_filter=all#student-works" class="px-3 py-2 text-sm rounded-lg transition-all flex items-center gap-3 <?= $date_filter === 'all' ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">
                                  <div class="w-5 flex justify-center"><i class="fas fa-calendar-alt"></i></div> Svi datumi
                              </a>
                              <a href="index.php?route=admin&subject=<?= $selected_subject ?>&date_filter=today#student-works" class="px-3 py-2 text-sm rounded-lg transition-all flex items-center gap-3 <?= $date_filter === 'today' ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">
                                  <div class="w-5 flex justify-center"><i class="fas fa-calendar-day"></i></div> Danas
                              </a>
                              <a href="index.php?route=admin&subject=<?= $selected_subject ?>&date_filter=week#student-works" class="px-3 py-2 text-sm rounded-lg transition-all flex items-center gap-3 <?= $date_filter === 'week' ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">
                                  <div class="w-5 flex justify-center"><i class="fas fa-calendar-week"></i></div> Zadnjih 7 dana
                              </a>
                              <a href="index.php?route=admin&subject=<?= $selected_subject ?>&date_filter=month#student-works" class="px-3 py-2 text-sm rounded-lg transition-all flex items-center gap-3 <?= $date_filter === 'month' ? 'bg-blue-600/20 text-blue-400 font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">
                                  <div class="w-5 flex justify-center"><i class="fas fa-calendar"></i></div> Zadnjih 30 dana
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <script>
            function toggleFilterSlide() {
                var wrapper = document.getElementById('filterMenuWrapper');
                var isHidden = wrapper.classList.contains('w-0');
                if(isHidden) {
                    wrapper.classList.remove('w-0', 'ml-0', 'opacity-0', 'pointer-events-none');
                    wrapper.classList.add('w-[180px]', 'ml-3', 'opacity-100');
                    setTimeout(() => wrapper.classList.remove('overflow-hidden'), 310);
                } else {
                    wrapper.classList.add('overflow-hidden');
                    wrapper.classList.remove('w-[180px]', 'ml-3', 'opacity-100');
                    wrapper.classList.add('w-0', 'ml-0', 'opacity-0', 'pointer-events-none');
                    var dp = document.getElementById('customSortDropdown');
                    if(dp) dp.classList.add('hidden');
                }
            }
            
            document.addEventListener('click', function(event) {
                var dropdown = document.getElementById('customSortDropdown');
                var btn = document.getElementById('filterTriggerBtn');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    if (!dropdown.contains(event.target) && !btn.contains(event.target)) {
                        dropdown.classList.add('hidden');
                    }
                }
                
                // Zatvori dropdown menije za preuzimanje formata
                var downloadDropdowns = document.querySelectorAll('[id^="downloadFormat_"]');
                downloadDropdowns.forEach(function(dropdown) {
                    if (!dropdown.classList.contains('hidden')) {
                        var testId = dropdown.id.replace('downloadFormat_', '').replace('downloadFormat_file_', '');
                        var button = document.querySelector('button[onclick*="downloadFormat_' + testId + '"]');
                        if (!dropdown.contains(event.target) && button && !button.contains(event.target)) {
                            dropdown.classList.add('hidden');
                        }
                    }
                });
            });
          </script>
          <a href="index.php?route=admin&subject=<?= $selected_subject ?>&download_all_works=1&date_filter=<?= $date_filter ?>" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-purple-500/30" title="Preuzmi sve"><i class="fas fa-file-archive"></i></a>
          <button onclick="showDeleteModal('all_works', null, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors border border-red-500/30" title="Obriši sve"><i class="fas fa-trash-alt"></i></button>
        </div>
      </div>

      <?php if($student_works instanceof mysqli_result && $student_works->num_rows > 0): ?>
      <ul class="space-y-2">
        <?php while($work = $student_works->fetch_assoc()): ?>
        <li class="flex flex-col sm:flex-row justify-between items-center py-3 px-4 rounded-xl bg-gray-800/50 border border-gray-700/50 hover:bg-gray-800 hover:border-gray-600 transition-all gap-2 group">
          <div class="flex items-center justify-between w-full sm:w-auto flex-1">
            <div class="pr-2 min-w-0 flex-1">
                <span class="text-sm sm:text-base block font-medium text-gray-200 truncate" title="<?= htmlspecialchars($work['filename']) ?>"><?= htmlspecialchars($work['filename']) ?></span>
                <div class="text-gray-400 text-xs flex flex-wrap gap-x-2 items-center mt-1">
                    <span><i class="fas fa-user mr-1 text-gray-500"></i><?= htmlspecialchars($work['username']) ?></span>
                    <span class="text-gray-500"><i class="far fa-clock mr-1"></i><?= date('d.m.Y H:i', strtotime($work['uploaded_at'])) ?></span>
                </div>
            </div>
            <button type="button" class="sm:hidden bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white p-2 rounded-lg transition-colors border border-purple-500/30 flex-shrink-0" onclick="toggleMobileMenu(this)"><i class="fas fa-ellipsis-v w-4 h-4 flex items-center justify-center"></i></button>
          </div>
          <div class="mobile-menu hidden sm:flex w-full justify-center sm:w-auto gap-2 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity">
            <a href="index.php?route=admin&subject=<?= $selected_subject ?>&download_work=<?= $work['id'] ?>" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Preuzmi"><i class="fas fa-download"></i></a>
            <button onclick="showDeleteModal('work', <?= $work['id'] ?>, <?= $selected_subject ?>)" class="bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors" title="Obriši"><i class="fas fa-trash-alt"></i></button>
          </div>
        </li>
        <?php endwhile; ?>
      </ul>
      
      <?php if($total_works_pages > 1): ?>
      <div class="flex justify-center items-center gap-3 mt-4 pt-2 border-t border-gray-700">
        <?php if($current_page_works > 1): ?>
          <a href="index.php?route=admin&subject=<?= $selected_subject ?>&works_page=<?= $current_page_works - 1 ?><?= $date_filter !== 'all' ? '&date_filter='.$date_filter : '' ?>#student-works" class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded text-sm text-white transition">← Prethodna</a>
        <?php endif; ?>
        <span class="text-gray-400 text-sm">Strana <?= $current_page_works ?> od <?= $total_works_pages ?></span>
        <?php if($current_page_works < $total_works_pages): ?>
          <a href="index.php?route=admin&subject=<?= $selected_subject ?>&works_page=<?= $current_page_works + 1 ?><?= $date_filter !== 'all' ? '&date_filter='.$date_filter : '' ?>#student-works" class="px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded text-sm text-white transition">Sledeća →</a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      
      <?php else: ?>
        <p class="text-gray-500 text-sm italic ml-2">Nema radova za ovaj predmet.</p>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    </div> <!-- End max-w-7xl -->
  </main>
    </div> <!-- End Flex-1 Col -->
</div>

<!-- Modal Upload -->
<?php if($selected_subject > 0): ?>
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
      <div class="space-y-2 relative z-40">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Sekcija (Opcionalno)</label>
        <input type="hidden" name="section_id" id="uploadSectionId" value="">
        <button type="button" id="uploadSectionBtn" onclick="document.getElementById('uploadSectionDropdown').classList.toggle('hidden')" class="w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 hover:border-purple-500 focus:border-purple-500 outline-none transition-all flex items-center justify-between shadow-sm cursor-pointer">
            <span class="truncate font-medium flex items-center gap-3 text-sm" id="uploadSectionText">
                <i class="fas fa-folder-open text-gray-400"></i> Opšte (bez sekcije)
            </span>
            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
        </button>

        <div id="uploadSectionDropdown" class="hidden absolute left-0 right-0 top-[100%] mt-2 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden animate-fadeIn z-[60] max-h-48 overflow-y-auto custom-scrollbar">
            <div class="flex flex-col p-1.5 gap-1">
                <button type="button" onclick="selectUploadSection('', 'Opšte (bez sekcije)', 'fa-folder-open text-gray-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                    <div class="w-5 flex justify-center"><i class="fas fa-folder-open text-gray-400"></i></div> Opšte (bez sekcije)
                </button>
                <?php foreach($sections as $sec): ?>
                <button type="button" onclick="selectUploadSection('<?= $sec['id'] ?>', '<?= htmlspecialchars($sec['name'], ENT_QUOTES) ?>', 'fa-folder text-purple-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                    <div class="w-5 flex justify-center"><i class="fas fa-folder text-purple-400"></i></div> <span class="truncate"><?= htmlspecialchars($sec['name']) ?></span>
                </button>
                <?php endforeach; ?>
            </div>
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

      <button type="submit" class="w-full bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white py-3.5 rounded-xl font-bold transition-colors border border-purple-500/30 mt-2 flex items-center justify-center gap-2">
          <i class="fas fa-cloud-upload-alt"></i> Uploaduj materijal
      </button>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal Kreiraj Test -->
<?php if($selected_subject > 0): ?>
<div id="createTestModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="createTestContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-purple-400">
            <i class="fas fa-magic text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Napravi novi test</h2>
    </div>
    <form method="post" class="flex flex-col gap-5">
      <input type="hidden" name="create_test" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      
      <div class="space-y-2">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Naziv testa</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-file-signature"></i></span>
            <input type="text" name="test_name" placeholder="npr. Prvi test" class="w-full bg-gray-900 text-white pl-10 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700 mt-2">
        <button type="button" id="closeCreateTest" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
        <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-purple-500/30">
            <i class="fas fa-check"></i> Kreiraj
        </button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal Preimenuj Predmet -->
<div id="renameSubjectModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="renameSubjectContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-blue-400">
            <i class="fas fa-edit text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Preimenuj predmet</h2>
    </div>
    <form method="post" class="flex flex-col gap-5">
      <input type="hidden" name="rename_subject" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="hidden" name="subject_id" id="modalRenameSubjectId">
      
      <div class="space-y-2">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Novi naziv predmeta</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-book"></i></span>
            <input type="text" name="new_subject_name" id="modalRenameSubjectName" class="w-full bg-gray-900 text-white pl-10 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700 mt-2">
        <button type="button" id="closeRenameSubject" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
        <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-purple-500/30">
            <i class="fas fa-save"></i> Sačuvaj
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal za premještanje -->
<?php if($selected_subject > 0): ?>
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
      
      <div class="space-y-2 relative z-40">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Odaberi novu sekciju</label>
        <input type="hidden" name="new_section_id" id="moveSectionId" value="">
        <button type="button" id="moveSectionBtn" onclick="document.getElementById('moveSectionDropdown').classList.toggle('hidden')" class="w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 hover:border-purple-500 focus:border-purple-500 outline-none transition-all flex items-center justify-between shadow-sm cursor-pointer">
            <span class="truncate font-medium flex items-center gap-3 text-sm" id="moveSectionText">
                <i class="fas fa-folder-open text-gray-400"></i> Opšte (bez sekcije)
            </span>
            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
        </button>

        <div id="moveSectionDropdown" class="hidden absolute left-0 right-0 top-[100%] mt-2 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden animate-fadeIn z-[60] max-h-48 overflow-y-auto custom-scrollbar">
            <div class="flex flex-col p-1.5 gap-1">
                <button type="button" onclick="selectMoveSection('', 'Opšte (bez sekcije)', 'fa-folder-open text-gray-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                    <div class="w-5 flex justify-center"><i class="fas fa-folder-open text-gray-400"></i></div> Opšte (bez sekcije)
                </button>
                <?php foreach($sections as $sec): ?>
                <button type="button" onclick='selectMoveSection("<?= $sec['id'] ?>", <?= htmlspecialchars(json_encode($sec['name']), ENT_QUOTES, "UTF-8") ?>, "fa-folder text-purple-400")' class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                    <div class="w-5 flex justify-center"><i class="fas fa-folder text-purple-400"></i></div> <span class="truncate"><?= htmlspecialchars($sec['name']) ?></span>
                </button>
                <?php endforeach; ?>
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

<!-- Modal Preimenuj Sekciju -->
<?php if($selected_subject > 0): ?>
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

<!-- Modal Preimenuj Fajl -->
<?php if($selected_subject > 0): ?>
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

<!-- Modal za Obavještenja (Prikaz) -->
<div id="viewNotificationModal" class="hidden fixed inset-0 flex justify-center items-center z-[60] bg-black/60 backdrop-blur-sm transition-all duration-300">
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

<!-- Modal Kreiraj učenika -->
<!-- Modal Upload Testa -->
<?php if($selected_subject > 0): ?>
<div id="testUploadModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/0 backdrop-blur-sm transition-all duration-300">
  <div id="testUploadContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-lg mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-teal-500/20">
                <i class="fas fa-file-signature text-white text-sm"></i>
            </div>
            Dodaj test
        </h2>
        <button type="button" id="closeTestUpload" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <form id="testUploadForm" method="post" enctype="multipart/form-data" class="flex flex-col gap-5">
      <input type="hidden" name="upload_test" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      
      <div id="testDropZone" class="relative group border-2 border-dashed border-gray-600 bg-gray-900/50 rounded-xl p-8 text-center cursor-pointer hover:border-teal-500 hover:bg-gray-800/80 transition-all duration-300">
        <div id="testUploadPrompt" class="flex flex-col items-center gap-3">
            <div class="w-16 h-16 rounded-full bg-gray-800 group-hover:bg-gray-700 flex items-center justify-center transition-colors mb-2 border border-gray-700 group-hover:border-teal-500/30">
                <i class="fas fa-file-code text-3xl text-gray-500 group-hover:text-teal-400 transition-colors"></i>
            </div>
            <p class="text-gray-300 font-medium group-hover:text-white transition-colors text-lg">Klikni ili prevuci test</p>
            <p class="text-gray-500 text-sm">Podržani formati: HTML (preporučeno), PDF...</p>
        </div>
        
        <div id="testFileDetails" class="hidden flex flex-col items-center animate-fadeIn">
          <div class="w-16 h-16 rounded-2xl bg-teal-500/20 flex items-center justify-center mb-3 text-teal-400 border border-teal-500/30 shadow-lg shadow-teal-500/10">
            <i class="fas fa-file-code text-3xl"></i>
          </div>
          <div class="text-white font-bold text-lg mb-1 break-all px-4" id="testFileName"></div>
          <div class="text-gray-400 text-sm bg-gray-800 px-3 py-1 rounded-full border border-gray-700" id="testFileSize"></div>
        </div>
        <input type="file" name="test_file" id="testFileInput" class="hidden" required>
      </div>

      <div class="w-full bg-gray-700 rounded-full h-2 overflow-hidden hidden mt-2" id="testProgressContainer">
        <div class="bg-gradient-to-r from-teal-500 to-emerald-500 h-2 w-0 transition-all duration-300 rounded-full shadow-[0_0_10px_rgba(20,184,166,0.5)]" id="testProgressBar"></div>
      </div>
      
      <div id="testUploadSuccess" class="hidden bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-4 rounded-xl text-center animate-fadeIn">
        <div class="flex items-center justify-center gap-3">
          <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
            <i class="fas fa-check"></i>
          </div>
          <span class="font-bold">Test uspješno uploadovan!</span>
        </div>
      </div>

      <button type="submit" class="w-full bg-teal-600/20 text-teal-400 hover:bg-teal-600 hover:text-white py-3.5 rounded-xl font-bold transition-colors border border-teal-500/30 mt-2 flex items-center justify-center gap-2">
          <i class="fas fa-upload"></i> Uploaduj test
      </button>
    </form>
  </div>
</div>
<?php endif; ?>

<?php if(true): ?>
<div id="userModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="userContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-3xl mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] overflow-y-auto custom-scrollbar">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center shadow-lg shadow-purple-500/30 text-white">
            <i class="fas fa-user-plus text-xl"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Novi učenik</h2>
    </div>
    
    <form method="post" id="createUserForm" class="flex flex-col gap-5">
      <input type="hidden" name="new_user" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

      <!-- Inline greška (prikazuje se bez zatvaranja modala) -->
      <div id="createUserError" class="hidden items-center gap-3 bg-yellow-500/10 border border-yellow-500/30 text-yellow-300 px-4 py-3 rounded-xl text-sm animate-fadeIn">
          <i class="fas fa-exclamation-triangle text-yellow-400 flex-shrink-0"></i>
          <span id="createUserErrorText"></span>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Lijeva kolona: Unos podataka -->
        <div class="flex flex-col gap-5">
          <div class="space-y-2">
            <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Korisničko ime</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" name="username" placeholder="Unesite korisničko ime" class="w-full bg-gray-900 text-white pl-10 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
            </div>
          </div>

          <div class="space-y-2">
            <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Lozinka</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password" id="newUserPassword" placeholder="Unesite lozinku" class="w-full bg-gray-900 text-white pl-10 pr-10 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
                <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-white toggle-password transition-colors" data-target="newUserPassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
          </div>

          <input type="hidden" name="role" value="student">

          <div class="space-y-2 relative z-40">
            <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Odjeljenje (Opcionalno)</label>
            <input type="hidden" name="class_id" id="newUserClassId" value="">
            <button type="button" id="newUserClassBtn" onclick="document.getElementById('newUserClassDropdown').classList.toggle('hidden')" class="w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 hover:border-purple-500 focus:border-purple-500 outline-none transition-all flex items-center justify-between shadow-sm cursor-pointer">
                <span class="truncate font-medium flex items-center gap-3 text-sm" id="newUserClassText">
                    <i class="fas fa-users-slash text-gray-400"></i> Bez odjeljenja
                </span>
                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
            </button>

            <div id="newUserClassDropdown" class="hidden absolute left-0 right-0 bottom-[100%] mb-2 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden animate-fadeIn z-[60] max-h-48 overflow-y-auto custom-scrollbar">
                <div class="flex flex-col p-1.5 gap-1">
                    <button type="button" onclick="selectUserClass('newUser', '', 'Bez odjeljenja', 'fa-users-slash text-gray-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                        <div class="w-5 flex justify-center"><i class="fas fa-users-slash text-gray-400"></i></div> Bez odjeljenja
                    </button>
                    <?php if(isset($classes) && $classes->num_rows > 0): ?>
                    <?php $classes->data_seek(0); while($cls = $classes->fetch_assoc()): ?>
                    <button type="button" onclick='selectUserClass("newUser", "<?= $cls['id'] ?>", <?= htmlspecialchars(json_encode($cls['name']), ENT_QUOTES, "UTF-8") ?>, "fa-users text-emerald-400")' class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                        <div class="w-5 flex justify-center"><i class="fas fa-users text-emerald-400"></i></div> <span class="truncate"><?= htmlspecialchars($cls['name']) ?></span>
                    </button>
                    <?php endwhile; endif; ?>
                </div>
            </div>
          </div>
        </div>

        <!-- Desna kolona: Dodjela predmeta -->
        <div class="space-y-3 flex flex-col h-full">
          <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 flex items-center gap-2"><i class="fas fa-book-open text-purple-400"></i> Dodjela predmeta</label>
          <div class="bg-gray-900/80 shadow-inner rounded-2xl border border-gray-700 p-2 flex-1 overflow-y-auto custom-scrollbar min-h-[160px] max-h-[200px] md:min-h-[200px] md:max-h-[280px]">
              <?php
              $all_subjects = $conn->prepare("SELECT * FROM subjects WHERE admin_id = ? ORDER BY name ASC");
              $all_subjects->bind_param("i", $current_admin_id);
              $all_subjects->execute();
              $subject_res = $all_subjects->get_result();
              if($subject_res->num_rows > 0):
                  while($sub = $subject_res->fetch_assoc()):
              ?>
              <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-800 cursor-pointer transition-all border border-transparent hover:border-purple-500/30 group mb-1">
                  <div class="relative flex items-center justify-center flex-shrink-0">
                      <input type="checkbox" name="user_subjects[]" value="<?= $sub['id'] ?>" class="peer w-5 h-5 border-2 border-gray-600 rounded-md bg-gray-800 checked:bg-purple-600 checked:border-purple-600 focus:ring-offset-0 focus:ring-0 appearance-none transition-all cursor-pointer shadow-inner">
                      <i class="fas fa-check absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-xs opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></i>
                  </div>
                  <div class="w-8 h-8 rounded-lg bg-gray-800 border border-gray-700 flex items-center justify-center text-gray-500 group-hover:text-purple-400 group-hover:bg-gray-900 group-hover:border-purple-500/30 transition-all flex-shrink-0 ml-1">
                      <i class="fas fa-book text-xs"></i>
                  </div>
                  <span class="text-gray-300 group-hover:text-white text-sm font-medium select-none flex-1 truncate"><?= htmlspecialchars($sub['name']) ?></span>
              </label>
              <?php 
                  endwhile; 
              else:
              ?>
                  <div class="p-4 text-center text-gray-500 text-sm italic">Nema dostupnih predmeta.</div>
              <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700">
        <button type="button" id="closeUser" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
        <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-purple-500/30">
            <i class="fas fa-user-plus"></i> Kreiraj 
        </button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Modal Upravljaj učenicima -->
<?php if(true): ?>
<div id="manageUsersModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm overflow-y-auto transition-all duration-300">
  <div id="manageUsersContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-3xl transform scale-95 opacity-0 transition-all duration-300 my-4">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-blue-400">
            <i class="fas fa-users-cog text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Upravljaj učenicima</h2>
    </div>
    
    <div class="mb-6 flex flex-col sm:flex-row gap-3">
      <div class="relative flex-1">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
            <i class="fas fa-search"></i>
        </span>
        <input type="text" id="searchStudents" placeholder="Pretraži učenike..." class="w-full bg-gray-900 text-white pl-10 pr-4 h-10 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 text-sm">
      </div>
      
      <div class="relative w-full sm:w-48 z-40">
          <input type="hidden" id="filterStudentsClass" value="">
          <button type="button" id="filterStudentsClassBtn" onclick="document.getElementById('filterStudentsClassDropdown').classList.toggle('hidden')" class="w-full bg-gray-900 text-white px-4 h-10 rounded-xl border border-gray-700 hover:border-purple-500 focus:border-purple-500 outline-none transition-all flex items-center justify-between shadow-sm cursor-pointer">
              <span class="truncate font-medium flex items-center gap-2 text-sm" id="filterStudentsClassText">
                  <i class="fas fa-filter text-gray-400"></i> Sva odjeljenja
              </span>
              <i class="fas fa-chevron-down text-xs text-gray-400"></i>
          </button>

          <div id="filterStudentsClassDropdown" class="hidden absolute left-0 right-0 top-[100%] mt-2 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden animate-fadeIn z-[60] max-h-48 overflow-y-auto custom-scrollbar">
              <div class="flex flex-col p-1.5 gap-1">
                  <button type="button" onclick="selectFilterClass('', 'Sva odjeljenja', 'fa-filter text-gray-400')" class="px-3 py-2 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                      <div class="w-5 flex justify-center"><i class="fas fa-filter text-gray-400"></i></div> Sva odjeljenja
                  </button>
                  <button type="button" onclick="selectFilterClass('none', 'Bez odjeljenja', 'fa-users-slash text-gray-400')" class="px-3 py-2 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                      <div class="w-5 flex justify-center"><i class="fas fa-users-slash text-gray-400"></i></div> Bez odjeljenja
                  </button>
                  <?php if(isset($classes) && $classes->num_rows > 0): ?>
                  <?php $classes->data_seek(0); while($cls = $classes->fetch_assoc()): ?>
                  <button type="button" onclick='selectFilterClass("<?= $cls['id'] ?>", <?= htmlspecialchars(json_encode($cls['name']), ENT_QUOTES, "UTF-8") ?>, "fa-users text-emerald-400")' class="px-3 py-2 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                      <div class="w-5 flex justify-center"><i class="fas fa-users text-emerald-400"></i></div> <span class="truncate"><?= htmlspecialchars($cls['name']) ?></span>
                  </button>
                  <?php endwhile; endif; ?>
              </div>
          </div>
      </div>

      <button type="button" id="notifyAllBtn" onclick="notifyFiltered()" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-4 h-10 rounded-xl transition-colors text-sm font-medium border border-purple-500/30 flex items-center justify-center gap-2 whitespace-nowrap shadow-lg shadow-purple-500/10">
          <i class="fas fa-paper-plane"></i> <span id="notifyAllBtnLabel">Obavijesti sve</span>
      </button>
      <button type="button" id="openTeacherNotificationHistory" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white px-4 h-10 rounded-xl transition-colors text-sm font-medium border border-blue-500/30 flex items-center justify-center gap-2 whitespace-nowrap shadow-lg shadow-blue-500/10">
          <i class="fas fa-history"></i> Istorija
      </button>
    </div>
    
    <div class="flex flex-col gap-3 max-h-96 overflow-y-auto custom-scrollbar pr-2">
      <?php 
      $users->data_seek(0);
      while($user = $users->fetch_assoc()): 
        // Dohvati predmete korisnika za edit modal
        $u_subs = [];
        $stmt_subs = $conn->prepare("SELECT subject_id FROM user_subjects WHERE user_id = ?");
        $stmt_subs->bind_param("i", $user['id']);
        $stmt_subs->execute();
        $res_subs = $stmt_subs->get_result();
        while($row_sub = $res_subs->fetch_assoc()) $u_subs[] = $row_sub['subject_id'];
        $u_subs_json = htmlspecialchars(json_encode($u_subs), ENT_QUOTES, 'UTF-8');
      ?>
      <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl bg-gray-700/50 hover:bg-gray-700 student-item transition-colors border border-gray-700/50 gap-2 group" data-mobile-row data-class-id="<?= empty($user['class_id']) ? 'none' : htmlspecialchars($user['class_id']) ?>">
        <div class="flex items-center justify-between w-full sm:w-auto mb-0 sm:mb-0">
          <div class="flex flex-row items-center flex-wrap gap-x-2 gap-y-1 pr-2 overflow-hidden">
            <span class="student-username font-semibold text-white"><?= htmlspecialchars($user['username']) ?></span>
            <?php if(!empty($user['class_name'])): ?>
              <span class="bg-emerald-500/20 text-emerald-400 text-[11px] px-2 py-0.5 rounded border border-emerald-500/30 uppercase tracking-wider font-bold w-fit"><i class="fas fa-users mr-1"></i><?= htmlspecialchars($user['class_name']) ?></span>
            <?php endif; ?>
          </div>
          <button type="button" class="sm:hidden bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white p-2 rounded-lg transition-colors border border-purple-500/30 flex-shrink-0" onclick="toggleMobileMenuDiv(this)" title="Opcije">
            <i class="fas fa-ellipsis-v w-4 h-4 flex items-center justify-center"></i>
          </button>
        </div>
        <div class="mobile-menu hidden sm:flex items-center gap-2 w-full sm:w-auto justify-center sm:justify-end sm:opacity-0 group-hover:opacity-100 transition-opacity">
          <button onclick="openNotificationModalFor(<?= $user['id'] ?>, '<?= htmlspecialchars($user['username'], ENT_QUOTES) ?>')" class="bg-purple-600/20 hover:bg-purple-600 text-purple-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg text-sm transition-colors border border-purple-500/30" title="Pošalji obavještenje"><i class="fas fa-paper-plane"></i></button>
          <button class="bg-blue-600/20 hover:bg-blue-600 text-blue-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg btn-edit-user text-sm transition-colors border border-blue-500/30" data-id="<?= $user['id'] ?>" data-username="<?= htmlspecialchars($user['username']) ?>" data-role="<?= $user['role'] ?>" data-class-id="<?= htmlspecialchars($user['class_id'] ?? '') ?>" data-subjects="<?= $u_subs_json ?>" title="Izmijeni učenika"><i class="fas fa-edit"></i></button>
          <button onclick="showDeleteModal('user', <?= $user['id'] ?>)" class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg text-sm transition-colors border border-red-500/30" title="Obriši učenika"><i class="fas fa-trash-alt"></i></button>
        </div>
      </div>

      <?php endwhile; ?>
      <div id="manageUsersEmptyState" class="hidden p-4 text-center text-gray-500 text-sm italic border border-dashed border-gray-700 rounded-xl bg-gray-800/50 mt-2">Nije pronađen nijedan učenik koji odgovara pretrazi.</div>
    </div>
    <div class="flex justify-end mt-6 pt-4 border-t border-gray-700">
      <button type="button" id="closeManageUsers" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Zatvori</button>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Modal Upravljaj odjeljenjima -->
<div id="manageClassesModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm overflow-y-auto transition-all duration-300">
  <div id="manageClassesContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-2xl transform scale-95 opacity-0 transition-all duration-300 my-4">
    <div class="flex items-center justify-between gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-emerald-400">
                <i class="fas fa-chalkboard-teacher text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Upravljaj odjeljenjima</h2>
        </div>
        <button type="button" id="closeManageClasses" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors"><i class="fas fa-times"></i></button>
    </div>

    <form method="post" class="mb-6 flex flex-col sm:flex-row gap-3">
        <input type="hidden" name="add_class" value="1">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                <i class="fas fa-plus"></i>
            </span>
            <input type="text" name="class_name" placeholder="Unesite naziv odjeljenja (npr. I-1)..." class="w-full bg-gray-900 text-white pl-10 pr-4 py-2.5 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 text-sm" required>
        </div>
        <button type="submit" class="bg-emerald-600/20 text-emerald-400 hover:bg-emerald-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold border border-emerald-500/30 flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/10 whitespace-nowrap">
            <i class="fas fa-save"></i> Dodaj
        </button>
    </form>

    <div class="flex flex-col gap-3 max-h-80 overflow-y-auto custom-scrollbar pr-2">
        <?php if(isset($classes) && $classes->num_rows > 0): ?>
            <?php 
            $classes->data_seek(0);
            while($cls = $classes->fetch_assoc()): 
                $student_count = 0;
                if(isset($conn)) {
                    $stmt_c = $conn->prepare("SELECT COUNT(*) as cnt FROM users WHERE class_id = ?");
                    $stmt_c->bind_param("i", $cls['id']);
                    $stmt_c->execute();
                    $res_c = $stmt_c->get_result();
                    if($res_c && $row_c = $res_c->fetch_assoc()) $student_count = $row_c['cnt'];
                }
            ?>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl bg-gray-700/50 hover:bg-gray-700 transition-colors border border-gray-700/50 gap-2 group" data-mobile-row>
                <div class="flex items-center justify-between w-full sm:w-auto">
                  <div>
                    <span class="font-semibold text-white"><?= htmlspecialchars($cls['name']) ?></span>
                    <span class="text-gray-400 text-sm ml-2">(<?= $student_count ?> <?= $student_count % 10 == 1 && $student_count % 100 != 11 ? 'učenik' : 'učenika' ?>)</span>
                  </div>
                  <button type="button" class="sm:hidden bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white p-2 rounded-lg transition-colors border border-purple-500/30 flex-shrink-0" onclick="toggleMobileMenuDiv(this)" title="Opcije">
                    <i class="fas fa-ellipsis-v w-4 h-4 flex items-center justify-center"></i>
                  </button>
                </div>
                <div class="mobile-menu hidden sm:flex gap-2 w-full sm:w-auto justify-center sm:justify-end sm:opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="index.php?route=organize_class&id=<?= $cls['id'] ?>" class="bg-purple-600/20 hover:bg-purple-600 text-purple-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg text-sm transition-colors border border-purple-500/30" title="Organizuj odjeljenje"><i class="fas fa-users-cog"></i></a>
                    <button type="button" class="bg-blue-600/20 hover:bg-blue-600 text-blue-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg text-sm transition-colors border border-blue-500/30" onclick="editClass(<?= $cls['id'] ?>, '<?= htmlspecialchars($cls['name'], ENT_QUOTES) ?>')" title="Izmijeni"><i class="fas fa-edit"></i></button>
                    <button type="button" onclick="showDeleteModal('class', <?= $cls['id'] ?>)" class="bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg text-sm transition-colors border border-red-500/30" title="Obriši"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="p-4 text-center text-gray-500 text-sm italic border border-dashed border-gray-700 rounded-xl bg-gray-800/50">Nema dodatih odjeljenja.</div>
        <?php endif; ?>
    </div>
  </div>
</div>

<!-- Modal Izmijeni odjeljenje -->
<div id="editClassModal" class="hidden fixed inset-0 flex justify-center items-center z-[60] bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="editClassContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-blue-400">
            <i class="fas fa-edit text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Izmijeni odjeljenje</h2>
    </div>
    <form method="post" class="flex flex-col gap-5">
      <input type="hidden" name="edit_class" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="hidden" name="class_id" id="editClassId">
      
      <div class="space-y-2">
        <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Novi naziv odjeljenja</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500"><i class="fas fa-chalkboard-teacher"></i></span>
            <input type="text" name="new_class_name" id="editClassName" class="w-full bg-gray-900 text-white pl-10 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700 mt-2">
        <button type="button" id="closeEditClass" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
        <button type="submit" class="bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-blue-500/30">
            <i class="fas fa-save"></i> Sačuvaj
        </button>
      </div>
    </form>
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

<!-- Modal Izmijeni učenika -->
<div id="editUserModal" class="hidden fixed inset-0 flex justify-center items-center z-50 bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="editUserContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-3xl mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] overflow-y-auto custom-scrollbar">
    <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center shadow-lg shadow-purple-500/30 text-white">
            <i class="fas fa-user-edit text-xl"></i>
        </div>
        <h2 class="text-xl font-bold text-white">Izmijeni učenika</h2>
    </div>
    
    <form id="editUserForm" method="post" class="flex flex-col gap-5">
      <input type="hidden" name="edit_user_id" id="editUserId">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Lijeva kolona: Unos podataka -->
        <div class="flex flex-col gap-5">
          <div class="space-y-2">
            <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Korisničko ime</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" name="edit_username" id="editUsername" placeholder="Unesite korisničko ime" class="w-full bg-gray-900 text-white pl-10 pr-4 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500" required>
            </div>
          </div>

          <div class="space-y-2">
            <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Nova lozinka <span class="text-gray-500 font-normal lowercase">(ostavi prazno ako se ne mijenja)</span></label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="edit_password" id="editPassword" placeholder="Unesite novu lozinku" class="w-full bg-gray-900 text-white pl-10 pr-10 py-3 rounded-xl border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500">
                <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-white toggle-password transition-colors" data-target="editPassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
          </div>

          <input type="hidden" name="edit_role" value="student">
          
          <div class="space-y-2 relative z-40">
            <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1">Odjeljenje (Opcionalno)</label>
            <input type="hidden" name="edit_class_id" id="editUserClassId" value="">
            <button type="button" id="editUserClassBtn" onclick="document.getElementById('editUserClassDropdown').classList.toggle('hidden')" class="w-full bg-gray-900 text-white px-4 py-3 rounded-xl border border-gray-700 hover:border-purple-500 focus:border-purple-500 outline-none transition-all flex items-center justify-between shadow-sm cursor-pointer">
                <span class="truncate font-medium flex items-center gap-3 text-sm" id="editUserClassText">
                    <i class="fas fa-users-slash text-gray-400"></i> Bez odjeljenja
                </span>
                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
            </button>

            <div id="editUserClassDropdown" class="hidden absolute left-0 right-0 bottom-[100%] mb-2 bg-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden animate-fadeIn z-[60] max-h-48 overflow-y-auto custom-scrollbar">
                <div class="flex flex-col p-1.5 gap-1">
                    <button type="button" onclick="selectUserClass('editUser', '', 'Bez odjeljenja', 'fa-users-slash text-gray-400')" class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                        <div class="w-5 flex justify-center"><i class="fas fa-users-slash text-gray-400"></i></div> Bez odjeljenja
                    </button>
                    <?php if(isset($classes) && $classes->num_rows > 0): ?>
                    <?php $classes->data_seek(0); while($cls = $classes->fetch_assoc()): ?>
                    <button type="button" onclick='selectUserClass("editUser", "<?= $cls['id'] ?>", <?= htmlspecialchars(json_encode($cls['name']), ENT_QUOTES, "UTF-8") ?>, "fa-users text-emerald-400")' class="px-3 py-2.5 text-sm rounded-lg transition-all flex items-center gap-3 text-gray-300 hover:bg-gray-700 hover:text-white text-left w-full">
                        <div class="w-5 flex justify-center"><i class="fas fa-users text-emerald-400"></i></div> <span class="truncate"><?= htmlspecialchars($cls['name']) ?></span>
                    </button>
                    <?php endwhile; endif; ?>
                </div>
            </div>
          </div>
        </div>

        <!-- Desna kolona: Dodjela predmeta -->
        <div id="editSubjectsDiv" class="space-y-3 flex flex-col h-full">
          <label class="text-gray-400 text-xs font-bold uppercase tracking-wider ml-1 flex items-center gap-2"><i class="fas fa-book-open text-purple-400"></i> Dodjela predmeta</label>
          <div id="editSubjects" class="bg-gray-900/80 shadow-inner rounded-2xl border border-gray-700 p-2 flex-1 overflow-y-auto custom-scrollbar min-h-[160px] max-h-[200px] md:min-h-[200px] md:max-h-[280px]">
            <?php
            $all_subjects3 = $conn->prepare("SELECT * FROM subjects WHERE admin_id = ? ORDER BY name ASC");
            $all_subjects3->bind_param("i", $current_admin_id);
            $all_subjects3->execute();
            $subject_res2 = $all_subjects3->get_result();
            if($subject_res2->num_rows > 0):
            while($sub = $subject_res2->fetch_assoc()):
            ?>
            <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-800 cursor-pointer transition-all border border-transparent hover:border-purple-500/30 group mb-1">
              <div class="relative flex items-center justify-center flex-shrink-0">
                  <input type="checkbox" name="edit_user_subjects[]" value="<?= $sub['id'] ?>" class="peer w-5 h-5 border-2 border-gray-600 rounded-md bg-gray-800 checked:bg-purple-600 checked:border-purple-600 focus:ring-offset-0 focus:ring-0 appearance-none transition-all cursor-pointer shadow-inner edit-subject-checkbox">
                  <i class="fas fa-check absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-xs opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></i>
              </div>
              <div class="w-8 h-8 rounded-lg bg-gray-800 border border-gray-700 flex items-center justify-center text-gray-500 group-hover:text-purple-400 group-hover:bg-gray-900 group-hover:border-purple-500/30 transition-all flex-shrink-0 ml-1">
                  <i class="fas fa-book text-xs"></i>
              </div>
              <span class="text-gray-300 group-hover:text-white text-sm font-medium select-none flex-1 truncate"><?= htmlspecialchars($sub['name']) ?></span>
            </label>
            <?php 
                endwhile; 
            else:
            ?>
                <div class="p-4 text-center text-gray-500 text-sm italic">Nema dostupnih predmeta.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      
      <div class="flex justify-end gap-3 pt-4 border-t border-gray-700">
        <button type="button" id="closeEditUser" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white px-5 py-2.5 rounded-xl transition-colors text-sm font-medium border border-gray-500/30">Otkaži</button>
        <button type="submit" class="bg-purple-600/20 text-purple-400 hover:bg-purple-600 hover:text-white px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border border-purple-500/30">
            <i class="fas fa-save"></i> Sačuvaj 
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Slanje Obavještenja -->
<div id="notificationModal" class="hidden fixed inset-0 flex justify-center items-center z-[60] bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="notificationContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-0 transform scale-95 opacity-0 transition-all duration-300">
    <div class="flex items-center gap-3 mb-4 border-b border-gray-700 pb-4">
        <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-yellow-400">
            <i class="fas fa-bullhorn text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-white"><span id="notifModalTitle">Pošalji obavještenje</span></h2>
    </div>
    <p class="text-gray-400 text-sm mb-4" id="notifModalDesc">Ova poruka će se prikazati odabranim učenicima na njihovoj početnoj stranici.</p>
    <form method="post" class="flex flex-col gap-5">
      <input type="hidden" name="send_notification" value="1">
      <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
      <input type="hidden" name="recipient_id" id="notifRecipientId" value="">
      <input type="hidden" name="class_id" id="notifClassId" value="">
      
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

<!-- Modal Istorija Obavještenja -->
<div id="teacherNotificationHistoryModal" class="hidden fixed inset-0 flex justify-center items-center z-[60] bg-black/60 backdrop-blur-sm transition-all duration-300">
  <div id="teacherNotificationHistoryContent" class="bg-gray-800 border border-gray-700 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-4xl transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] flex flex-col my-4">
    <div class="flex items-center justify-between gap-3 mb-6 border-b border-gray-700 pb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gray-700 flex items-center justify-center text-blue-400">
                <i class="fas fa-history text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Istorija obavještenja</h2>
        </div>
        <button type="button" id="closeTeacherNotificationHistory" class="bg-gray-600/20 text-gray-400 hover:bg-gray-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition-colors"><i class="fas fa-times"></i></button>
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
            <tbody class="text-sm" id="teacherNotificationHistoryList">
                <?php if($notification_history && $notification_history->num_rows > 0): ?>
                    <?php while($notif = $notification_history->fetch_assoc()): ?>
                        <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition">
                            <td class="p-3 whitespace-nowrap text-gray-400"><?= date('d.m.Y H:i', strtotime($notif['created_at'])) ?></td>
                            <td class="p-3">
                                <?php 
                                    $typeClass = 'text-blue-400'; $typeIcon = 'fa-info-circle';
                                    if($notif['type'] === 'warning') { $typeClass = 'text-yellow-400'; $typeIcon = 'fa-exclamation-triangle'; }
                                    if($notif['type'] === 'urgent') { $typeClass = 'text-red-400'; $typeIcon = 'fa-exclamation-circle'; }
                                ?>
                                <span class="<?= $typeClass ?>"><i class="fas <?= $typeIcon ?> mr-1"></i> <?= ucfirst($notif['type']) ?></span>
                            </td>
                            <td class="p-3">
                                <span class="text-white bg-gray-700 px-2 py-1 rounded text-xs"><i class="fas fa-user mr-1"></i> <?= htmlspecialchars($notif['recipient_name']) ?></span>
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
                    <tr><td colspan="5" class="p-4 text-center text-gray-500 text-sm italic">Nema poslatih obavještenja.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if($history_count == 20): ?>
        <div class="p-3 text-center border-t border-gray-700 mt-2" id="loadMoreHistoryContainer">
            <button type="button" onclick="loadMoreHistory()" class="text-xs text-purple-400 hover:text-white transition-colors bg-gray-800 border border-gray-700 rounded-lg px-6 py-2.5 font-medium" title="Učitaj starija obavještenja">Učitaj još...</button>
        </div>
        <?php endif; ?>
    </div>
  </div>
</div>

<!-- COMMAND PALETTE (Ctrl + K) -->
<div id="commandPalette" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden items-start justify-center pt-[15vh] transition-all duration-200">
    <div class="bg-gray-800 w-full max-w-2xl rounded-xl shadow-2xl border border-gray-700 overflow-hidden transform scale-95 transition-all duration-200" id="commandPaletteContent">
        <div class="p-4 border-b border-gray-700 flex items-center gap-3">
            <i class="fas fa-search text-gray-400 text-lg"></i>
            <input type="text" id="commandInput" placeholder="Pretraži komande, učenike ili sekcije..." class="bg-transparent border-none outline-none text-white text-lg w-full placeholder-gray-500" autocomplete="off">
            <div class="text-xs text-gray-500 bg-gray-900 px-2 py-1 rounded border border-gray-700">ESC</div>
        </div>
        <div class="max-h-[60vh] overflow-y-auto py-2" id="commandResults">
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

<script>
// Funkcije za prikaz i sakrivanje modala
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

let isRenameModeActive = false;
let isDeleteModeActive = false;
let isArchiveModeActive = false;
const CSRF_TOKEN = '<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES) ?>';

window.toggleActionMenu = function() {
    const container = document.getElementById('actionBtnsContainer');
    const btn = document.getElementById('actionMenuToggleBtn');
    const icon = btn.querySelector('i');
    
    if (container.classList.contains('max-w-0')) {
        container.classList.remove('max-w-0', 'opacity-0');
        container.classList.add('max-w-[150px]', 'opacity-100');
        btn.classList.add('bg-gray-700', 'text-white', 'is-active');
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times', 'rotate-90');
    } else {
        container.classList.add('max-w-0', 'opacity-0');
        container.classList.remove('max-w-[150px]', 'opacity-100');
        btn.classList.remove('bg-gray-700', 'text-white', 'is-active');
        icon.classList.remove('fa-times', 'rotate-90');
        icon.classList.add('fa-bars');
        if (isRenameModeActive) toggleRenameMode();
        if (isDeleteModeActive) toggleDeleteMode();
        if (isArchiveModeActive) toggleArchiveMode();
    }
};

    window.toggleSectionActionMenu = function(btn, sectionId) {
        const container = document.getElementById('sectionActionBtns-' + sectionId);
        const icon = btn.querySelector('i');
        
        if (container.classList.contains('max-w-0')) {
            // Zatvori sve ostale otvorene menije za sekcije
            document.querySelectorAll('[id^="sectionActionBtns-"]').forEach(el => {
                if (el !== container && !el.classList.contains('max-w-0')) {
                    el.classList.add('max-w-0', 'opacity-0');
                    el.classList.remove('max-w-[120px]', 'opacity-100');
                    const otherBtn = el.nextElementSibling;
                    const otherIcon = otherBtn.querySelector('i');
                    otherBtn.classList.remove('bg-gray-700', 'text-white', 'is-active');
                    otherIcon.classList.remove('fa-times', 'rotate-90');
                    otherIcon.classList.add('fa-bars');
                }
            });

            container.classList.remove('max-w-0', 'opacity-0');
            container.classList.add('max-w-[120px]', 'opacity-100');
            btn.classList.add('bg-gray-700', 'text-white', 'is-active');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times', 'rotate-90');
        } else {
            container.classList.add('max-w-0', 'opacity-0');
            container.classList.remove('max-w-[120px]', 'opacity-100');
            btn.classList.remove('bg-gray-700', 'text-white', 'is-active');
            icon.classList.remove('fa-times', 'rotate-90');
            icon.classList.add('fa-bars');
        }
    };

window.toggleRenameMode = function() {
    if (isDeleteModeActive) toggleDeleteMode(); // Ugasi delete mode ako je upaljen
    if (isArchiveModeActive) toggleArchiveMode(); // Ugasi archive mode ako je upaljen
    isRenameModeActive = !isRenameModeActive;
    const btn = document.getElementById('renameModeBtn');
    const cards = document.querySelectorAll('.subject-card-item');
    
    if (isRenameModeActive) {
        btn.classList.replace('bg-blue-600/20', 'bg-blue-600');
        btn.classList.replace('text-blue-400', 'text-white');
        btn.classList.add('shadow-[0_0_10px_rgba(59,130,246,0.6)]');
        cards.forEach(card => {
            card.classList.replace('border-transparent', 'border-blue-500');
            card.classList.add('shadow-[0_0_15px_rgba(59,130,246,0.3)]', 'bg-blue-900/10');
            const subtitle = card.querySelector('span.text-xs.text-gray-500');
            if(subtitle) subtitle.innerHTML = '<i class="fas fa-edit text-blue-400"></i> Klikni za preimenovanje';
        });
    } else {
        btn.classList.replace('bg-blue-600', 'bg-blue-600/20');
        btn.classList.replace('text-white', 'text-blue-400');
        btn.classList.remove('shadow-[0_0_10px_rgba(59,130,246,0.6)]');
        cards.forEach(card => {
            card.classList.replace('border-blue-500', 'border-transparent');
            card.classList.remove('shadow-[0_0_15px_rgba(59,130,246,0.3)]', 'bg-blue-900/10');
            const subtitle = card.querySelector('span.text-xs.text-gray-500');
            if(subtitle) subtitle.innerHTML = card.dataset.archived === '1' ? 'Arhivirano (Samo pregled)' : 'Klikni za upravljanje';
        });
    }
};

window.toggleArchiveMode = function() {
    if (isRenameModeActive) toggleRenameMode();
    if (isDeleteModeActive) toggleDeleteMode();
    isArchiveModeActive = !isArchiveModeActive;
    const btn = document.getElementById('archiveModeBtn');
    const cards = document.querySelectorAll('.subject-card-item');
    
    if (isArchiveModeActive) {
        btn.classList.replace('bg-yellow-600/20', 'bg-yellow-600');
        btn.classList.replace('text-yellow-400', 'text-white');
        btn.classList.add('shadow-[0_0_10px_rgba(202,138,4,0.6)]');
        cards.forEach(card => {
            card.classList.replace('border-transparent', 'border-yellow-500');
            card.classList.add('shadow-[0_0_15px_rgba(202,138,4,0.3)]', 'bg-yellow-900/10');
            const subtitle = card.querySelector('span.text-xs.text-gray-500');
            if(subtitle) subtitle.innerHTML = '<i class="fas fa-archive text-yellow-400"></i> Klikni za arhiviranje/aktivaciju';
        });
        if (typeof showThemeToast === 'function') showThemeToast('Aktiviran mod za arhiviranje 📦');
    } else {
        btn.classList.replace('bg-yellow-600', 'bg-yellow-600/20');
        btn.classList.replace('text-white', 'text-yellow-400');
        btn.classList.remove('shadow-[0_0_10px_rgba(202,138,4,0.6)]');
        cards.forEach(card => {
            card.classList.replace('border-yellow-500', 'border-transparent');
            card.classList.remove('shadow-[0_0_15px_rgba(202,138,4,0.3)]', 'bg-yellow-900/10');
            const subtitle = card.querySelector('span.text-xs.text-gray-500');
            if(subtitle) subtitle.innerHTML = card.dataset.archived === '1' ? 'Arhivirano (Samo pregled)' : 'Klikni za upravljanje';
        });
    }
};

window.toggleDeleteMode = function() {
    if (isRenameModeActive) toggleRenameMode(); // Ugasi rename mode ako je upaljen
    if (isArchiveModeActive) toggleArchiveMode(); // Ugasi archive mode ako je upaljen
    isDeleteModeActive = !isDeleteModeActive;
    const btn = document.getElementById('deleteModeBtn');
    const cards = document.querySelectorAll('.subject-card-item');
    
    if (isDeleteModeActive) {
        btn.classList.replace('bg-red-600/20', 'bg-red-600');
        btn.classList.replace('text-red-400', 'text-white');
        btn.classList.add('shadow-[0_0_10px_rgba(239,68,68,0.6)]');
        cards.forEach(card => {
            card.classList.replace('border-transparent', 'border-red-500');
            card.classList.add('shadow-[0_0_15px_rgba(239,68,68,0.3)]', 'bg-red-900/10');
            const subtitle = card.querySelector('span.text-xs.text-gray-500');
            if(subtitle) subtitle.innerHTML = '<i class="fas fa-trash-alt text-red-400"></i> Klikni za brisanje';
        });
    } else {
        btn.classList.replace('bg-red-600', 'bg-red-600/20');
        btn.classList.replace('text-white', 'text-red-400');
        btn.classList.remove('shadow-[0_0_10px_rgba(239,68,68,0.6)]');
        cards.forEach(card => {
            card.classList.replace('border-red-500', 'border-transparent');
            card.classList.remove('shadow-[0_0_15px_rgba(239,68,68,0.3)]', 'bg-red-900/10');
            const subtitle = card.querySelector('span.text-xs.text-gray-500');
            if(subtitle) subtitle.innerHTML = card.dataset.archived === '1' ? 'Arhivirano (Samo pregled)' : 'Klikni za upravljanje';
        });
    }
};

window.handleSubjectClick = function(event, id, name, isArchived) {
    if (isRenameModeActive) {
        if (isArchived) { alert("Arhivirani predmet se ne može preimenovati."); return; }
        event.preventDefault();
        event.stopPropagation();
        openRenameSubjectModal(id, name);
    } else if (isDeleteModeActive) {
        if (isArchived) { alert("Arhivirani predmet se ne može obrisati."); return; }
        event.preventDefault();
        event.stopPropagation();
        showDeleteModal('subject', id);
    } else if (isArchiveModeActive) {
        event.preventDefault();
        event.stopPropagation();
        showDeleteModal(isArchived ? 'unarchive_subject' : 'archive_subject', id);
    } else {
        window.location.href = 'index.php?route=admin&subject=' + id;
    }
};

const renameSubjectModal = document.getElementById('renameSubjectModal');
const renameSubjectContent = document.getElementById('renameSubjectContent');
const closeRenameSubject = document.getElementById('closeRenameSubject');

window.openRenameSubjectModal = function(id, oldName) {
    document.getElementById('modalRenameSubjectId').value = id;
    document.getElementById('modalRenameSubjectName').value = oldName;
    showModal(renameSubjectModal, renameSubjectContent);
}

if(closeRenameSubject) closeRenameSubject.addEventListener('click', () => hideModal(renameSubjectModal, renameSubjectContent));
renameSubjectModal?.addEventListener('click', (e) => { if(e.target === renameSubjectModal) hideModal(renameSubjectModal, renameSubjectContent); });

const renameSectionModal = document.getElementById('renameSectionModal');
const renameSectionContent = document.getElementById('renameSectionContent');
const closeRenameSection = document.getElementById('closeRenameSection');

window.openRenameSectionModal = function(id, oldName) {
    document.getElementById('modalSectionId').value = id;
    document.getElementById('modalSectionName').value = oldName;
    showModal(renameSectionModal, renameSectionContent);
}

if(closeRenameSection) closeRenameSection.addEventListener('click', () => hideModal(renameSectionModal, renameSectionContent));
renameSectionModal?.addEventListener('click', (e) => {
    if(e.target === renameSectionModal) hideModal(renameSectionModal, renameSectionContent);
});

const renameFileModal = document.getElementById('renameFileModal');
const renameFileContent = document.getElementById('renameFileContent');
const closeRenameFile = document.getElementById('closeRenameFile');

window.openRenameFileModal = function(id, fullName) {
    const lastDotIndex = fullName.lastIndexOf('.');
    const nameWithoutExt = lastDotIndex !== -1 ? fullName.substring(0, lastDotIndex) : fullName;
    document.getElementById('renameFileId').value = id;
    document.getElementById('renameFileName').value = nameWithoutExt;
    showModal(renameFileModal, renameFileContent);
}

if(closeRenameFile) closeRenameFile.addEventListener('click', () => hideModal(renameFileModal, renameFileContent));
renameFileModal?.addEventListener('click', (e) => { if(e.target === renameFileModal) hideModal(renameFileModal, renameFileContent); });

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
            if(opt.getAttribute('onclick').includes("'" + currentSectionId + "'")) {
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

window.selectNotifType = function(value, name, iconClass) {
    document.getElementById('notifTypeInput').value = value;
    document.getElementById('notifTypeText').innerHTML = `<i class="fas ${iconClass}"></i> <span class="truncate">${name}</span>`;
    document.getElementById('notifTypeDropdown').classList.add('hidden');
}

window.selectUserClass = function(prefix, id, name, iconClass) {
    document.getElementById(prefix + 'ClassId').value = id;
    document.getElementById(prefix + 'ClassText').innerHTML = `<i class="fas ${iconClass}"></i> <span class="truncate">${name}</span>`;
    document.getElementById(prefix + 'ClassDropdown').classList.add('hidden');
}

    window.selectFilterClass = function(id, name, iconClass) {
        document.getElementById('filterStudentsClass').value = id;
        document.getElementById('filterStudentsClassText').innerHTML = `<i class="fas ${iconClass}"></i> <span class="truncate">${name}</span>`;
        document.getElementById('filterStudentsClassDropdown').classList.add('hidden');
    if (typeof window.filterStudents === 'function') window.filterStudents();
        // Ažuriraj labelu dugmeta za obavijesti
        const label = document.getElementById('notifyAllBtnLabel');
        if (label) {
            label.textContent = (id && id !== '') ? 'Obavijesti: ' + name : 'Obavijesti sve';
        }
    }

document.addEventListener('click', function(event) {
    var newUserDropdown = document.getElementById('newUserClassDropdown');
    var newUserBtn = document.getElementById('newUserClassBtn');
    if (newUserDropdown && !newUserDropdown.classList.contains('hidden') && !newUserDropdown.contains(event.target) && !newUserBtn.contains(event.target)) {
        newUserDropdown.classList.add('hidden');
    }

    var editUserDropdown = document.getElementById('editUserClassDropdown');
    var editUserBtn = document.getElementById('editUserClassBtn');
    if (editUserDropdown && !editUserDropdown.classList.contains('hidden') && !editUserDropdown.contains(event.target) && !editUserBtn.contains(event.target)) {
        editUserDropdown.classList.add('hidden');
    }

    var moveDropdown = document.getElementById('moveSectionDropdown');
    var moveBtn = document.getElementById('moveSectionBtn');
    if (moveDropdown && !moveDropdown.classList.contains('hidden')) {
        if (!moveDropdown.contains(event.target) && !moveBtn.contains(event.target)) {
            moveDropdown.classList.add('hidden');
        }
    }

    var uploadDropdown = document.getElementById('uploadSectionDropdown');
    var uploadBtn = document.getElementById('uploadSectionBtn');
    if (uploadDropdown && !uploadDropdown.classList.contains('hidden')) {
        if (!uploadDropdown.contains(event.target) && !uploadBtn.contains(event.target)) {
            uploadDropdown.classList.add('hidden');
        }
    }

    var notifDropdown = document.getElementById('notifTypeDropdown');
    var notifBtn = document.getElementById('notifTypeBtn');
    if (notifDropdown && !notifDropdown.classList.contains('hidden')) {
        if (!notifDropdown.contains(event.target) && !notifBtn.contains(event.target)) {
            notifDropdown.classList.add('hidden');
        }
    }
});

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




// Modal za brisanje
const deleteModal = document.getElementById('deleteModal');
const deleteContent = document.getElementById('deleteContent');
const deleteModalTitle = document.getElementById('deleteModalTitle');
const deleteModalMessage = document.getElementById('deleteModalMessage');
const confirmDelete = document.getElementById('confirmDelete');
const cancelDelete = document.getElementById('cancelDelete');

window.showDeleteModal = function(type, id, subjectId = null) {
  if(!deleteModal || !deleteContent) return;
  let title, message, url, btnText, btnIcon, btnClass;

  // Defaultne vrijednosti za brisanje (Crvena boja)
  btnText = 'Obriši';
  btnIcon = 'fa-trash-alt';
  btnClass = 'bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white border-red-500/30';
  
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
    case 'user':
      title = 'Brisanje učenika';
      message = 'Jeste li sigurni da želite obrisati ovog učenika? Ova akcija je nepovratna.';
      url = `?route=admin&delete_user=${id}`;
      break;
        case 'class':
          title = 'Brisanje odjeljenja';
          message = 'Jeste li sigurni da želite obrisati ovo odjeljenje? Ova akcija je nepovratna.';
          url = `?route=admin&delete_class=${id}`;
          break;
    case 'work':
      title = 'Brisanje rada';
      message = 'Jeste li sigurni da želite obrisati ovaj rad? Ova akcija je nepovratna.';
      url = `?route=admin&delete_work=${id}&subject=${subjectId}`;
      break;
    case 'test':
      title = 'Brisanje testa';
      message = 'Jeste li sigurni da zelite obrisati ovaj test? Ova akcija je nepovratna.';
      url = `?route=admin&delete_test=${id}&subject=${subjectId}`;
      break;
    case 'section':
      title = 'Brisanje sekcije';
      message = 'Jeste li sigurni da želite obrisati ovu sekciju? Svi materijali u njoj će postati "Opšti".';
      url = `?route=admin&delete_section=${id}&subject=${subjectId}`;
      break;
    case 'notification':
      title = 'Brisanje obavještenja';
      message = 'Jeste li sigurni da želite obrisati ovo obavještenje?';
      url = `?route=admin&delete_notification=${id}&open_history=1`;
      break;
    case 'all_works':
      title = 'Brisanje svih radova';
      message = 'Jeste li sigurni da želite obrisati sve radove za ovaj predmet? Ova akcija je nepovratna.';
      url = `?route=admin&delete_all_works=1&subject=${subjectId}&date_filter=${dateFilter}`;
      break;
    case 'archive_subject':
      title = 'Arhiviranje predmeta';
      message = 'Da li želite arhivirati ovaj predmet? Postaće read-only za učenike i blokiraće se sve nove izmjene.';
      url = `?route=admin&archive_subject=${id}`;
      btnText = 'Arhiviraj';
      btnIcon = 'fa-archive';
      btnClass = 'bg-yellow-600/20 text-yellow-400 hover:bg-yellow-600 hover:text-white border-yellow-500/30';
      break;
    case 'unarchive_subject':
      title = 'Aktivacija predmeta';
      message = 'Da li želite vratiti ovaj predmet iz arhive u aktivno stanje?';
      url = `?route=admin&unarchive_subject=${id}`;
      btnText = 'Aktiviraj';
      btnIcon = 'fa-box-open';
      btnClass = 'bg-emerald-600/20 text-emerald-400 hover:bg-emerald-600 hover:text-white border-emerald-500/30';
      break;
  }
  
  deleteModalTitle.textContent = title;
  deleteModalMessage.textContent = message;
  confirmDelete.innerHTML = `<i class="fas ${btnIcon}"></i> ${btnText}`;
  confirmDelete.className = `px-6 py-2.5 rounded-xl transition-colors text-sm font-bold flex items-center gap-2 border ${btnClass}`;

  // Za archive/unarchive koristimo POST formu sa CSRF tokenom umjesto GET linka
  if (type === 'archive_subject' || type === 'unarchive_subject') {
    confirmDelete.removeAttribute('href');
    confirmDelete.onclick = function(e) {
      e.preventDefault();
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'index.php?route=admin';
      form.innerHTML = '<input type="hidden" name="csrf_token" value="' + CSRF_TOKEN + '"><input type="hidden" name="' + type + '" value="' + id + '">';
      document.body.appendChild(form);
      form.submit();
    };
  } else {
    confirmDelete.onclick = null;
    confirmDelete.href = url;
  }

  showModal(deleteModal, deleteContent);
}

if(cancelDelete && deleteModal && deleteContent) {
  cancelDelete.addEventListener('click', () => hideModal(deleteModal, deleteContent));
  deleteModal.addEventListener('click', (e) => {
    if(e.target === deleteModal) hideModal(deleteModal, deleteContent);
  });
}

/* --- COMMAND PALETTE LOGIC --- */
const commandPalette = document.getElementById('commandPalette');
const commandInput = document.getElementById('commandInput');
const commandResults = document.getElementById('commandResults');
const commandContent = document.getElementById('commandPaletteContent');

document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); window.toggleCommandPalette(); }
    if (e.key === 'Escape' && !commandPalette.classList.contains('hidden')) { window.toggleCommandPalette(); }
});

window.toggleCommandPalette = function() {
    if (commandPalette.classList.contains('hidden')) {
        commandPalette.classList.remove('hidden'); commandPalette.classList.add('flex');
        setTimeout(() => { commandContent.classList.remove('scale-95'); commandContent.classList.add('scale-100'); }, 10);
        commandInput.value = ''; commandInput.focus(); generateCommandItems('');
    } else {
        commandContent.classList.remove('scale-100'); commandContent.classList.add('scale-95');
        setTimeout(() => { commandPalette.classList.add('hidden'); commandPalette.classList.remove('flex'); }, 200);
    }
};

commandPalette.addEventListener('click', (e) => { if (e.target === commandPalette) toggleCommandPalette(); });

const commands = [
    { icon: 'fas fa-home', title: 'Početna', desc: 'Idi na početnu stranu', action: () => window.location.href='index.php?route=admin' },
    { icon: 'fas fa-user-plus', title: 'Kreiraj učenika', desc: 'Dodaj novog učenika', action: () => { toggleCommandPalette(); document.getElementById('openUserModal').click(); } },
    { icon: 'fas fa-users', title: 'Upravljaj učenicima', desc: 'Prikaz i uređivanje učenika', action: () => { toggleCommandPalette(); document.getElementById('openManageUsers').click(); } },
    { icon: 'fas fa-chalkboard-teacher', title: 'Upravljaj odjeljenjima', desc: 'Dodaj i uredi odjeljenja', action: () => { toggleCommandPalette(); document.getElementById('openManageClasses').click(); } },
    { icon: 'fas fa-sign-out-alt', title: 'Odjavi se', desc: 'Završi sesiju', action: () => window.location.href='index.php?route=logout' }
    <?php if($selected_subject > 0): ?>
    , { icon: 'fas fa-upload', title: 'Dodaj materijal', desc: 'Upload novog fajla', action: () => { toggleCommandPalette(); document.getElementById('openUpload').click(); } }
    , { icon: 'fas fa-file-signature', title: 'Dodaj test', desc: 'Upload novog testa', action: () => { toggleCommandPalette(); document.getElementById('openTestUpload').click(); } }
    , { icon: 'fas fa-magic', title: 'Napravi test', desc: 'Kreiraj novi test', action: () => { toggleCommandPalette(); document.getElementById('openCreateTest').click(); } }
    <?php endif; ?>
];

function generateCommandItems(filter) {
    const filtered = commands.filter(c => c.title.toLowerCase().includes(filter.toLowerCase()) || c.desc.toLowerCase().includes(filter.toLowerCase()));
    if (filtered.length === 0) { commandResults.innerHTML = '<div class="p-4 text-center text-gray-500 text-sm italic">Nema rezultata.</div>'; return; }
    commandResults.innerHTML = filtered.map((c) => `<div class="px-4 py-3 hover:bg-purple-600/20 hover:border-l-4 hover:border-purple-500 cursor-pointer flex items-center gap-3 transition-all border-l-4 border-transparent group" onclick="(${c.action})()"><div class="w-8 h-8 rounded bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-white group-hover:bg-purple-600 transition-colors"><i class="${c.icon}"></i></div><div><div class="text-white font-medium group-hover:text-purple-300">${c.title}</div><div class="text-gray-500 text-xs group-hover:text-gray-400">${c.desc}</div></div></div>`).join('');
}
commandInput.addEventListener('input', (e) => generateCommandItems(e.target.value));

// Logika za prikaz obavještenja
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

    // Formatiranje datuma
    let dateStr = notif.created_at;
    if (dateStr && dateStr.includes(' ')) {
        dateStr = dateStr.replace(' ', 'T'); // Fix za Safari/iOS parsiranje datuma
    }
    const d = new Date(dateStr);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');
    dateEl.textContent = `${day}.${month}.${year} ${hours}:${minutes}`;

    // Reset klasa na default (info)
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

    // Automatsko zatvaranje dropdown-a
    const notifDropdown = document.getElementById('notificationDropdown');
    if (notifDropdown && !notifDropdown.classList.contains('hidden')) {
        notifDropdown.classList.remove('scale-100', 'opacity-100');
        notifDropdown.classList.add('scale-95', 'opacity-0');
        setTimeout(() => notifDropdown.classList.add('hidden'), 200);
    }

    // Ako nije pročitano, pošalji AJAX zahtjev da se označi kao pročitano
    if (notif.is_read === null || notif.is_read === undefined || notif.is_read === false) {
        const formData = new FormData();
        formData.append('mark_notification_read', notif.id);
        formData.append('csrf_token', '<?= $csrf_token ?>');

        fetch('index.php?route=admin', {
            method: 'POST',
            body: formData
        }).then(res => res.text()).then(res => {
            if (res.trim() === 'success') {
                notif.is_read = true; // Spriječi ponovno slanje zahtjeva pri idućem kliku
                el.setAttribute('data-notif', JSON.stringify(notif));
                
                // Ažuriraj vizuelni status elementa u padajućem meniju
                el.classList.add('opacity-70');
                el.classList.remove('bg-gray-700/20');
                const titleText = el.querySelector('p.text-sm.text-gray-200');
                if (titleText) titleText.classList.remove('font-bold');

                const indicator = el.querySelector('.unread-indicator');
                if (indicator) indicator.remove();

                // Ažuriraj badge/zvonce brojku
                const badge = document.getElementById('unreadBadge');
                const bellDot = document.getElementById('bellNotificationDot');
                if (badge) {
                    let count = parseInt(badge.textContent);
                    if (!isNaN(count) && count > 1) {
                        badge.textContent = (count - 1) + ' novo';
                    } else {
                        badge.remove();
                        if (bellDot) bellDot.remove();
                    }
                } else {
                    if (bellDot) bellDot.remove();
                }
            }
        }).catch(err => console.error('Greška:', err));
    }
};

// Označi sve kao pročitano
window.markAllNotificationsRead = function() {
    const formData = new FormData();
    formData.append('mark_all_notifications_read', '1');
    formData.append('csrf_token', '<?= $csrf_token ?>');

    fetch('index.php?route=admin', {
        method: 'POST',
        body: formData
    }).then(res => res.text()).then(res => {
        if (res.trim() === 'success') {
            // Ažuriraj sve vizuelne elemente u meniju (ukloni tačkice i bold font)
            const unreadIndicators = document.querySelectorAll('#notificationDropdown .unread-indicator');
            unreadIndicators.forEach(indicator => {
                const notifItem = indicator.closest('.cursor-pointer');
                if (notifItem) {
                    notifItem.classList.add('opacity-70', 'hover:bg-gray-700');
                    notifItem.classList.remove('bg-gray-700/40', 'hover:bg-gray-700/60');
                    const titleText = notifItem.querySelector('p.text-sm.text-gray-200');
                    if (titleText) titleText.classList.remove('font-bold');
                    
                    // Ažuriranje skrivenog JSON podatka na elementu
                    let notifData = notifItem.getAttribute('data-notif');
                    if (notifData) {
                        let notifObj = JSON.parse(notifData);
                        notifObj.is_read = true;
                        notifItem.setAttribute('data-notif', JSON.stringify(notifObj));
                    }
                }
                indicator.remove(); // Brisanje tačkice (indikatora)
            });

            // Uklanjanje bedževa
            const badge = document.getElementById('unreadBadge'); if (badge) badge.remove();
            const bellDot = document.getElementById('bellNotificationDot'); if (bellDot) bellDot.remove();
            const markAllBtn = document.getElementById('markAllReadBtn'); if (markAllBtn) markAllBtn.remove();
        }
    }).catch(err => console.error('Greška:', err));
};

window.escapeHtml = function(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
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

    fetch('index.php?route=admin', {
        method: 'POST',
        body: formData
    }).then(res => res.json()).then(data => {
        if (data.notifications && data.notifications.length > 0) {
            const list = document.getElementById('notificationList');
            data.notifications.forEach(notif => {
                const is_read = notif.is_read !== null;
                const type = notif.type || 'info';
                let icon = 'fa-bell text-purple-400';
                let bgIcon = 'bg-purple-500/20 border-purple-500/30';
                if (type === 'warning') { icon = 'fa-exclamation-triangle text-yellow-400'; bgIcon = 'bg-yellow-500/20 border-yellow-500/30'; }
                else if (type === 'urgent') { icon = 'fa-exclamation-circle text-red-400'; bgIcon = 'bg-red-500/20 border-red-500/30'; }
                
                let dStr = notif.created_at;
                if(dStr && dStr.includes(' ')) dStr = dStr.replace(' ', 'T');
                const d = new Date(dStr);
                const day = String(d.getDate()).padStart(2, '0');
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const year = d.getFullYear();
                const hours = String(d.getHours()).padStart(2, '0');
                const minutes = String(d.getMinutes()).padStart(2, '0');
                const dateFormatted = `${day}.${month}.${year} ${hours}:${minutes}`;

                const displayTitle = notif.title ? escapeHtml(notif.title) : escapeHtml(notif.message);
            const displayDesc = notif.title ? escapeHtml(notif.message) + ' • ' + dateFormatted : dateFormatted;

                const item = document.createElement('div');
                item.className = `px-3 py-2.5 rounded-lg transition-all cursor-pointer flex gap-3 ${is_read ? 'opacity-70 hover:bg-gray-700' : 'bg-gray-700/40 hover:bg-gray-700/60'}`;
                
                const safeJson = JSON.stringify(notif).replace(/'/g, "&apos;").replace(/"/g, "&quot;");
                item.setAttribute('data-notif', safeJson);
                item.onclick = function() { openNotification(this); };

                let indicatorHtml = !is_read ? `<div class="w-2 h-2 bg-blue-500 rounded-full self-center flex-shrink-0 unread-indicator shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>` : '';

                item.innerHTML = `
                    <div class="w-10 h-10 rounded-full ${bgIcon} border flex items-center justify-center flex-shrink-0">
                        <i class="fas ${icon}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-200 truncate ${is_read ? '' : 'font-bold'}">${displayTitle}</p>
                        <p class="text-xs text-gray-500 mt-1 truncate">${displayDesc}</p>
                    </div>
                    ${indicatorHtml}
                `;
                list.appendChild(item);
            });
            currentNotifOffset += data.notifications.length;
            
            if (data.notifications.length < 10) {
                document.getElementById('loadMoreNotifsContainer').remove();
            } else {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        } else {
            document.getElementById('loadMoreNotifsContainer').remove();
        }
    }).catch(err => {
        console.error(err);
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
};

// Upload modal
const openUpload = document.getElementById('openUpload');
const uploadModal = document.getElementById('uploadModal');
const uploadContent = document.getElementById('uploadContent');
const closeUpload = document.getElementById('closeUpload');
const uploadForm = document.getElementById('uploadForm');

if(openUpload) openUpload.addEventListener('click',()=>showModal(uploadModal, uploadContent));
if(closeUpload) closeUpload.addEventListener('click',()=>hideModal(uploadModal, uploadContent));
uploadModal?.addEventListener('click',(e)=>{if(e.target===uploadModal) hideModal(uploadModal,uploadContent);});

// Drag & Drop
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const uploadPrompt = document.getElementById('uploadPrompt');
const fileDetails = document.getElementById('fileDetails');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');
const uploadSuccess = document.getElementById('uploadSuccess');
const progressContainer = document.getElementById('progressContainer');
const progressBar = document.getElementById('progressBar');

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

fileInput?.addEventListener('change', function() {
  if(this.files.length > 0) {
    showFileDetails(this.files[0]);
  }
});

function showFileDetails(file) {
  uploadPrompt.classList.add('hidden');
  fileDetails.classList.remove('hidden');
  fileName.textContent = file.name;
  
  let size = file.size;
  const units = ['B', 'KB', 'MB', 'GB'];
  let unitIndex = 0;
  
  while(size >= 1024 && unitIndex < units.length - 1) {
    size /= 1024;
    unitIndex++;
  }
  
  fileSize.textContent = `${size.toFixed(2)} ${units[unitIndex]}`;
}

// Ajax Upload
uploadForm?.addEventListener('submit',(e)=>{
  e.preventDefault();
  const file = fileInput.files[0];
  if(!file) return;
  
  const submitBtn = uploadForm.querySelector('button[type="submit"]');
  const originalBtnContent = submitBtn.innerHTML;
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Uploadujem...';
  submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

  uploadSuccess.classList.add('hidden');
  
  const formData = new FormData(uploadForm);
  
  const xhr = new XMLHttpRequest();
  xhr.open('POST','index.php?route=admin&subject=<?= $selected_subject ?>',true);
  
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
      uploadSuccess.classList.remove('hidden');
      
      setTimeout(() => {
        progressBar.style.width = '0%';
        // progressBar.textContent = ''; // Uklonjeno
        
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

// Test upload modal
const openTestUpload = document.getElementById('openTestUpload');
const testUploadModal = document.getElementById('testUploadModal');
const testUploadContent = document.getElementById('testUploadContent');
const closeTestUpload = document.getElementById('closeTestUpload');
const testUploadForm = document.getElementById('testUploadForm');

if(openTestUpload) openTestUpload.addEventListener('click',()=>showModal(testUploadModal, testUploadContent));
if(closeTestUpload) closeTestUpload.addEventListener('click',()=>hideModal(testUploadModal, testUploadContent));
testUploadModal?.addEventListener('click',(e)=>{if(e.target===testUploadModal) hideModal(testUploadModal,testUploadContent);});

// Create Test modal
const openCreateTest = document.getElementById('openCreateTest');
const createTestModal = document.getElementById('createTestModal');
const createTestContent = document.getElementById('createTestContent');
const closeCreateTest = document.getElementById('closeCreateTest');
if(openCreateTest) openCreateTest.addEventListener('click',()=>showModal(createTestModal, createTestContent));
if(closeCreateTest) closeCreateTest.addEventListener('click',()=>hideModal(createTestModal, createTestContent));
createTestModal?.addEventListener('click',(e)=>{if(e.target===createTestModal) hideModal(createTestModal,createTestContent);});

// Test drag & drop
const testDropZone = document.getElementById('testDropZone');
const testFileInput = document.getElementById('testFileInput');
const testUploadPrompt = document.getElementById('testUploadPrompt');
const testFileDetails = document.getElementById('testFileDetails');
const testFileName = document.getElementById('testFileName');
const testFileSize = document.getElementById('testFileSize');
const testUploadSuccess = document.getElementById('testUploadSuccess');
const testProgressContainer = document.getElementById('testProgressContainer');
const testProgressBar = document.getElementById('testProgressBar');

testDropZone?.addEventListener('click',()=>testFileInput.click());
testDropZone?.addEventListener('dragover',(e)=>{ e.preventDefault(); testDropZone.classList.add('border-purple-500','text-purple-300'); });
testDropZone?.addEventListener('dragleave',()=>{ testDropZone.classList.remove('border-purple-500','text-purple-300'); });
testDropZone?.addEventListener('drop',(e)=>{ 
  e.preventDefault(); 
  testDropZone.classList.remove('border-purple-500','text-purple-300'); 
  if(e.dataTransfer.files.length>0) {
    testFileInput.files=e.dataTransfer.files;
    showTestFileDetails(e.dataTransfer.files[0]);
  }
});

testFileInput?.addEventListener('change', function() {
  if(this.files.length > 0) {
    showTestFileDetails(this.files[0]);
  }
});

function showTestFileDetails(file) {
  testUploadPrompt.classList.add('hidden');
  testFileDetails.classList.remove('hidden');
  testFileName.textContent = file.name;
  
  let size = file.size;
  const units = ['B', 'KB', 'MB', 'GB'];
  let unitIndex = 0;
  
  while(size >= 1024 && unitIndex < units.length - 1) {
    size /= 1024;
    unitIndex++;
  }
  
  testFileSize.textContent = `${size.toFixed(2)} ${units[unitIndex]}`;
}

// Ajax upload testa
testUploadForm?.addEventListener('submit',(e)=>{
  e.preventDefault();
  const file = testFileInput.files[0];
  if(!file) return;
  
  const submitBtn = testUploadForm.querySelector('button[type="submit"]');
  const originalBtnContent = submitBtn.innerHTML;
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Uploadujem...';
  submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

  testUploadSuccess.classList.add('hidden');
  
  const formData = new FormData(testUploadForm);
  
  const xhr = new XMLHttpRequest();
  xhr.open('POST','index.php?route=admin&subject=<?= $selected_subject ?>',true);
  
  showGlobalLoader('Uploadujem test...', true);
  
  xhr.upload.addEventListener('progress',(e)=>{
    if(e.lengthComputable){
      testProgressContainer.classList.remove('hidden');
      const percent = (e.loaded / e.total) * 100;
      testProgressBar.style.width = percent + '%';
      updateGlobalLoaderProgress(percent);
    }
  });
  
  xhr.onload = function(){
    hideGlobalLoader();
    if(xhr.status===200) {
      testUploadSuccess.classList.remove('hidden');
      
      setTimeout(() => {
        testProgressBar.style.width = '0%';
        // testProgressBar.textContent = ''; // Uklonjeno
        
        setTimeout(() => {
          location.reload();
        }, 500);
      }, 1500);
    } else {
      alert('Greska pri uploadu testa!');
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

// Kreiraj korisnika modal
const openUser = document.getElementById('openUserModal');
const userModal = document.getElementById('userModal');
const userContent = document.getElementById('userContent');
const closeUser = document.getElementById('closeUser');
if(openUser) openUser.addEventListener('click',()=>showModal(userModal,userContent));
if(closeUser) closeUser.addEventListener('click',()=>hideModal(userModal,userContent));
userModal?.addEventListener('click',(e)=>{if(e.target===userModal) hideModal(userModal,userContent);});

// ── AJAX kreiranje učenika ──────────────────────────────────────────────────
const createUserForm = document.getElementById('createUserForm');
if (createUserForm) {
    createUserForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const errorBox  = document.getElementById('createUserError');
        const errorText = document.getElementById('createUserErrorText');
        const submitBtn = createUserForm.querySelector('button[type="submit"]');

        // Sakrij prethodnu grešku, onemogući dugme
        errorBox.classList.add('hidden');
        errorBox.classList.remove('flex');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Kreiranje...';

        try {
            const res = await fetch('index.php?route=admin', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: new FormData(createUserForm)
            });
            const data = await res.json();

            if (data.success) {
                // Uspjeh: zatvori modal i refreshaj stranicu
                hideModal(userModal, userContent);
                createUserForm.reset();
                document.getElementById('newUserClassText').innerHTML = '<i class="fas fa-users-slash text-gray-400"></i> Bez odjeljenja';
                document.getElementById('newUserClassId').value = '';
                // Kratka pauza (animacija zatvaranja), pa refresh
                setTimeout(() => { window.location.reload(); }, 350);
            } else {
                // Greška: ostani na modalu, prikaži upozorenje
                errorText.textContent = data.error || 'Došlo je do greške.';
                errorBox.classList.remove('hidden');
                errorBox.classList.add('flex');
                // Fokusiraj username polje radi lakše izmjene
                const usernameInput = createUserForm.querySelector('input[name="username"]');
                if (usernameInput) {
                    usernameInput.focus();
                    usernameInput.select();
                }
                // Shake animacija na username polju
                usernameInput?.classList.add('border-yellow-500', 'focus:border-yellow-500', 'focus:ring-yellow-500');
                setTimeout(() => {
                    usernameInput?.classList.remove('border-yellow-500', 'focus:border-yellow-500', 'focus:ring-yellow-500');
                }, 2500);
            }
        } catch (err) {
            errorText.textContent = 'Greška pri slanju zahtjeva. Pokušaj ponovo.';
            errorBox.classList.remove('hidden');
            errorBox.classList.add('flex');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-user-plus"></i> Kreiraj';
        }
    });
}
// ────────────────────────────────────────────────────────────────────────────

// Upravljaj korisnicima modal
const openManageUsers = document.getElementById('openManageUsers');
const manageUsersModal = document.getElementById('manageUsersModal');
const manageUsersContent = document.getElementById('manageUsersContent');
const closeManageUsers = document.getElementById('closeManageUsers');
if(openManageUsers) openManageUsers.addEventListener('click',()=> {
    // Resetovanje polja i filtera prilikom svakog otvaranja modala
    const searchInput = document.getElementById('searchStudents');
    if(searchInput) searchInput.value = '';
    if(typeof selectFilterClass === 'function') {
        selectFilterClass('', 'Sva odjeljenja', 'fa-filter text-gray-400');
    }
    showModal(manageUsersModal,manageUsersContent);
});
if(closeManageUsers) closeManageUsers.addEventListener('click',()=>hideModal(manageUsersModal,manageUsersContent));
manageUsersModal?.addEventListener('click',(e)=>{if(e.target===manageUsersModal) hideModal(manageUsersModal,manageUsersContent);});

// Izmijeni korisnika modal
const editUserModal = document.getElementById('editUserModal');
const editUserContent = document.getElementById('editUserContent');
const closeEditUser = document.getElementById('closeEditUser');
const editUserForm = document.getElementById('editUserForm');

document.querySelectorAll('.btn-edit-user').forEach(btn=>{
  btn.addEventListener('click',()=>{
    const id = btn.dataset.id;
    const username = btn.dataset.username;
    const role = btn.dataset.role;
    const subjects = JSON.parse(btn.dataset.subjects || '[]');

    document.getElementById('editUserId').value = id;
    document.getElementById('editUsername').value = username;
    
    // Popuni odjeljenje
    const classId = btn.dataset.classId;
    const classInput = document.getElementById('editUserClassId');
    const classText = document.getElementById('editUserClassText');
    if (classInput && classText) {
        if (classId && classId !== '') {
            // Pretraga po onclick atributu koji nosi taj ID
            const btnInDropdown = document.querySelector(`#editUserClassDropdown button[onclick*='"${classId}"']`);
            const nameSpan = btnInDropdown ? btnInDropdown.querySelector('.truncate') : null;
            classInput.value = classId;
            classText.innerHTML = `<i class="fas fa-users text-emerald-400"></i> <span class="truncate">${nameSpan ? nameSpan.textContent : 'Odabrano odjeljenje'}</span>`;
        } else {
            classInput.value = '';
            classText.innerHTML = `<i class="fas fa-users-slash text-gray-400"></i> <span class="truncate">Bez odjeljenja</span>`;
        }
    }

    document.querySelectorAll('.edit-subject-checkbox').forEach(chk => {
        chk.checked = subjects.includes(parseInt(chk.value));
    });
    showModal(editUserModal,editUserContent);
  });
});
if(closeEditUser) closeEditUser.addEventListener('click',()=>hideModal(editUserModal,editUserContent));
editUserModal?.addEventListener('click',(e)=>{if(e.target===editUserModal) hideModal(editUserModal,editUserContent);});



// Pretraga učenika i filtriranje po odjeljenju
const searchStudents = document.getElementById('searchStudents');
const filterStudentsClass = document.getElementById('filterStudentsClass');

window.filterStudents = function() {
    const searchTerm = searchStudents ? searchStudents.value.toLowerCase() : '';
    const classFilter = filterStudentsClass ? filterStudentsClass.value : '';
    const items = document.querySelectorAll('.student-item');
    let hasVisible = false;
    
    items.forEach(item => {
        const username = item.querySelector('.student-username').textContent.toLowerCase();
        const itemClassId = item.getAttribute('data-class-id');
        
        const matchesSearch = username.includes(searchTerm);
        const matchesClass = classFilter === '' || itemClassId === classFilter;
        
        if (matchesSearch && matchesClass) {
            item.style.display = '';
            hasVisible = true;
        } else {
            item.style.display = 'none';
        }
    });
    
    const emptyState = document.getElementById('manageUsersEmptyState');
    if (emptyState) {
        emptyState.style.display = hasVisible || items.length === 0 ? 'none' : 'block';
    }
}

if(searchStudents) searchStudents.addEventListener('input', window.filterStudents);
if(filterStudentsClass) filterStudentsClass.addEventListener('change', window.filterStudents);

// Upravljaj odjeljenjima modal
const openManageClasses = document.getElementById('openManageClasses');
const manageClassesModal = document.getElementById('manageClassesModal');
const manageClassesContent = document.getElementById('manageClassesContent');
const closeManageClasses = document.getElementById('closeManageClasses');

if(openManageClasses) openManageClasses.addEventListener('click',()=>showModal(manageClassesModal,manageClassesContent));
if(closeManageClasses) closeManageClasses.addEventListener('click',()=>hideModal(manageClassesModal,manageClassesContent));
manageClassesModal?.addEventListener('click',(e)=>{if(e.target===manageClassesModal) hideModal(manageClassesModal,manageClassesContent);});

// Izmijeni odjeljenje modal
const editClassModal = document.getElementById('editClassModal');
const editClassContent = document.getElementById('editClassContent');
const closeEditClass = document.getElementById('closeEditClass');

window.editClass = function(id, name) {
    document.getElementById('editClassId').value = id;
    document.getElementById('editClassName').value = name;
    hideModal(manageClassesModal, manageClassesContent);
    setTimeout(() => showModal(editClassModal, editClassContent), 300);
}
if(closeEditClass) {
    closeEditClass.addEventListener('click', () => {
        hideModal(editClassModal, editClassContent);
        setTimeout(() => showModal(manageClassesModal, manageClassesContent), 300);
    });
}
editClassModal?.addEventListener('click', (e) => {
    if(e.target === editClassModal) {
        hideModal(editClassModal, editClassContent);
        setTimeout(() => showModal(manageClassesModal, manageClassesContent), 300);
    }
});

// Organizacija odjeljenja modal
const classStudentsModal = document.getElementById('manageClassStudentsModal');
const classStudentsContent = document.getElementById('manageClassStudentsContent');
const closeClassStudents = document.getElementById('closeClassStudents');
const backToClassesBtn = document.getElementById('backToClassesBtn');

window.openClassStudentsModal = function(classId, className) {
    window._currentClassId = classId;
    window._currentClassName = className;
    document.getElementById('classStudentsTitleName').textContent = className;
    const container = document.getElementById('classStudentsListContainer');
    container.innerHTML = '';

    const students = document.querySelectorAll(`.student-item[data-class-id="${classId}"]`);
    
    if(students.length === 0) {
        container.innerHTML = '<div class="p-8 text-center text-gray-500 text-sm italic border border-dashed border-gray-700 rounded-xl bg-gray-800/50 flex flex-col items-center"><i class="fas fa-users-slash text-3xl mb-3 opacity-50"></i>Nema učenika u ovom odjeljenju.</div>';
    } else {
        students.forEach(student => {
            const clone = student.cloneNode(true);
            clone.style.display = ''; // Force show u slučaju da je bio sakriven pretragom u glavnom modalu
            
            // Re-bind edit dugmeta za klonirani red
            const editBtn = clone.querySelector('.btn-edit-user');
            if (editBtn) {
                editBtn.onclick = function() {
                    const id = this.dataset.id;
                    const username = this.dataset.username;
                    const subjects = JSON.parse(this.dataset.subjects || '[]');
                    const classIdVal = this.dataset.classId;

                    document.getElementById('editUserId').value = id;
                    document.getElementById('editUsername').value = username;
                    
                    const classInput = document.getElementById('editUserClassId');
                    const classText = document.getElementById('editUserClassText');
                    if (classInput && classText) {
                        if (classIdVal && classIdVal !== '') {
                            const btnInDropdown = document.querySelector(`#editUserClassDropdown button[onclick*='"${classIdVal}"']`);
                            const nameSpan = btnInDropdown ? btnInDropdown.querySelector('.truncate') : null;
                            classInput.value = classIdVal;
                            classText.innerHTML = `<i class="fas fa-users text-emerald-400"></i> <span class="truncate">${nameSpan ? nameSpan.textContent : 'Odabrano odjeljenje'}</span>`;
                        } else {
                            classInput.value = '';
                            classText.innerHTML = `<i class="fas fa-users-slash text-gray-400"></i> <span class="truncate">Bez odjeljenja</span>`;
                        }
                    }

                    document.querySelectorAll('.edit-subject-checkbox').forEach(chk => {
                        chk.checked = subjects.includes(parseInt(chk.value));
                    });
                    
                    hideModal(classStudentsModal, classStudentsContent);
                    setTimeout(() => showModal(editUserModal, editUserContent), 300);
                };
            }
            container.appendChild(clone);
        });
    }

    hideModal(manageClassesModal, manageClassesContent);
    setTimeout(() => showModal(classStudentsModal, classStudentsContent), 300);
};

if(closeClassStudents) closeClassStudents.addEventListener('click', () => hideModal(classStudentsModal, classStudentsContent));
if(backToClassesBtn) backToClassesBtn.addEventListener('click', () => {
    hideModal(classStudentsModal, classStudentsContent);
    setTimeout(() => showModal(manageClassesModal, manageClassesContent), 300);
});
classStudentsModal?.addEventListener('click', (e) => {
    if(e.target === classStudentsModal) hideModal(classStudentsModal, classStudentsContent);
});

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

// Logika modala za slanje obavještenja
const notificationModal = document.getElementById('notificationModal');
const notificationContent = document.getElementById('notificationContent');
const closeNotificationModal = document.getElementById('closeNotificationModal');
const notifRecipientId = document.getElementById('notifRecipientId');
const notifModalTitle = document.getElementById('notifModalTitle');
const notifModalDesc = document.getElementById('notifModalDesc');

window.openNotificationModalFor = function(id, username, classId) {
    classId = classId || '';
    if(notifRecipientId) notifRecipientId.value = id;
    const classIdInput = document.getElementById('notifClassId');
    if(classIdInput) classIdInput.value = classId;
    let title, desc;
    if (id !== '') {
        title = 'Pošalji obavještenje: ' + username;
        desc = 'Ova poruka će se prikazati samo učeniku ' + username + '.';
    } else if (classId !== '') {
        const classLabel = document.getElementById('filterStudentsClassText');
        const className = classLabel ? classLabel.textContent.trim() : classId;
        title = 'Pošalji obavještenje: ' + className;
        desc = 'Ova poruka će se prikazati svim učenicima odjeljenja ' + className + '.';
    } else {
        title = 'Pošalji obavještenje: Svima';
        desc = 'Ova poruka će se prikazati svim vašim učenicima.';
    }
    if(notifModalTitle) notifModalTitle.textContent = title;
    if(notifModalDesc) notifModalDesc.textContent = desc;
    if(document.getElementById('notifTypeInput')) window.selectNotifType('info', 'Informacija', 'fa-info-circle text-blue-400');
    showModal(notificationModal, notificationContent);
};

// Obavijesti sve / odabrano odjeljenje
window.notifyFiltered = function() {
    const classId = document.getElementById('filterStudentsClass')?.value || '';
    openNotificationModalFor('', '', classId);
    // Azuriraj labelu dugmeta
    const btn = document.getElementById('notifyAllBtn');
    if (btn) {
        const label = document.getElementById('notifyAllBtnLabel');
        if (label) {
            const classLabel = document.getElementById('filterStudentsClassText');
            const txt = classLabel ? classLabel.textContent.trim() : '';
            label.textContent = (classId && classId !== '') ? 'Obavijesti: ' + txt : 'Obavijesti sve';
        }
    }
};

if(closeNotificationModal) closeNotificationModal.addEventListener('click', () => hideModal(notificationModal, notificationContent));
notificationModal?.addEventListener('click', (e) => { if(e.target === notificationModal) hideModal(notificationModal, notificationContent); });

// Logika za istoriju obavještenja (Nastavnik)
const teacherNotificationHistoryModal = document.getElementById('teacherNotificationHistoryModal');
const teacherNotificationHistoryContent = document.getElementById('teacherNotificationHistoryContent');
const openTeacherNotificationHistory = document.getElementById('openTeacherNotificationHistory');
const closeTeacherNotificationHistory = document.getElementById('closeTeacherNotificationHistory');

if(openTeacherNotificationHistory) {
    openTeacherNotificationHistory.addEventListener('click', () => {
        hideModal(manageUsersModal, manageUsersContent);
        setTimeout(() => showModal(teacherNotificationHistoryModal, teacherNotificationHistoryContent), 300);
    });
}
if(closeTeacherNotificationHistory) {
    closeTeacherNotificationHistory.addEventListener('click', () => {
        hideModal(teacherNotificationHistoryModal, teacherNotificationHistoryContent);
        setTimeout(() => showModal(manageUsersModal, manageUsersContent), 300);
    });
}
teacherNotificationHistoryModal?.addEventListener('click', (e) => { 
    if(e.target === teacherNotificationHistoryModal) hideModal(teacherNotificationHistoryModal, teacherNotificationHistoryContent);
});

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

    fetch('index.php?route=admin', { method: 'POST', body: formData })
    .then(res => res.json()).then(data => {
        if (data.notifications && data.notifications.length > 0) {
            const list = document.getElementById('teacherNotificationHistoryList');
            data.notifications.forEach(notif => {
                let typeClass = 'text-blue-400'; let typeIcon = 'fa-info-circle';
                if(notif.type === 'warning') { typeClass = 'text-yellow-400'; typeIcon = 'fa-exclamation-triangle'; }
                if(notif.type === 'urgent') { typeClass = 'text-red-400'; typeIcon = 'fa-exclamation-circle'; }
                
                let recipientHtml = `<span class="text-white bg-gray-700 px-2 py-1 rounded text-xs"><i class="fas fa-user mr-1"></i> ${escapeHtml(notif.recipient_name)}</span>`;
                let dStr = notif.created_at;
                if(dStr && dStr.includes(' ')) dStr = dStr.replace(' ', 'T');
                const d = new Date(dStr);
                const dateFormatted = `${String(d.getDate()).padStart(2, '0')}.${String(d.getMonth() + 1).padStart(2, '0')}.${d.getFullYear()} ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;

                const tr = document.createElement('tr');
                tr.className = 'border-b border-gray-700/50 hover:bg-gray-700/30 transition';
                tr.innerHTML = `<td class="p-3 whitespace-nowrap text-gray-400">${dateFormatted}</td>
                    <td class="p-3"><span class="${typeClass}"><i class="fas ${typeIcon} mr-1"></i> ${notif.type.charAt(0).toUpperCase() + notif.type.slice(1)}</span></td>
                    <td class="p-3">${recipientHtml}</td>
                            <td class="p-3 text-gray-300 max-w-md">${escapeHtml(notif.message || '')}</td>
                    <td class="p-3 text-right"><button onclick="showDeleteModal('notification', ${notif.id})" class="text-red-400 hover:text-red-300 p-1.5 rounded-lg hover:bg-gray-700 transition" title="Obriši obavještenje"><i class="fas fa-trash-alt text-sm"></i></button></td>`;
                list.appendChild(tr);
            });
            currentHistoryOffset += data.notifications.length;
            if (data.notifications.length < 20) document.getElementById('loadMoreHistoryContainer').remove();
            else { btn.innerHTML = originalText; btn.disabled = false; }
        } else { document.getElementById('loadMoreHistoryContainer').remove(); }
    }).catch(err => { console.error(err); if (btn) { btn.innerHTML = originalText; btn.disabled = false; } });
};

// Sidebar Collapse Logic
const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
if(localStorage.getItem('sidebar_collapsed') === 'true') {
    document.body.classList.add('sidebar-collapsed');
}

if(sidebarCollapseBtn) {
    sidebarCollapseBtn.addEventListener('click', () => {
        document.body.classList.toggle('sidebar-collapsed');
        const isCollapsed = document.body.classList.contains('sidebar-collapsed');
        localStorage.setItem('sidebar_collapsed', isCollapsed ? 'true' : 'false');
    });
}

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
      const teacherNotificationHistoryModal = document.getElementById('teacherNotificationHistoryModal');
      const teacherNotificationHistoryContent = document.getElementById('teacherNotificationHistoryContent');
      if(teacherNotificationHistoryModal && teacherNotificationHistoryContent) {
          showModal(teacherNotificationHistoryModal, teacherNotificationHistoryContent);
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

// Toggle mobilnog menija za DIV redove (modali učenika i odjeljenja)
function toggleMobileMenuDiv(btn) {
    const row = btn.closest('[data-mobile-row]');
    const menu = row.querySelector('.mobile-menu');
    const isHidden = menu.classList.contains('hidden');

    // Zatvori sve ostale mobile-menu unutar [data-mobile-row]
    document.querySelectorAll('[data-mobile-row] .mobile-menu').forEach(m => {
        if (!m.classList.contains('hidden') && m !== menu) {
            m.classList.add('hidden');
            m.classList.remove('flex');
            const parentRow = m.closest('[data-mobile-row]');
            if (parentRow) {
                const triggerBtn = parentRow.querySelector('button[onclick="toggleMobileMenuDiv(this)"]');
                if (triggerBtn) {
                    triggerBtn.classList.remove('bg-purple-600', 'text-white');
                    triggerBtn.classList.add('bg-purple-600/20', 'text-purple-400');
                }
            }
        }
    });

    if (isHidden) {
        menu.classList.remove('hidden');
        menu.classList.add('flex');
        btn.classList.remove('bg-purple-600/20', 'text-purple-400');
        btn.classList.add('bg-purple-600', 'text-white');
    } else {
        menu.classList.add('hidden');
        menu.classList.remove('flex');
        btn.classList.remove('bg-purple-600', 'text-white');
        btn.classList.add('bg-purple-600/20', 'text-purple-400');
    }
}

function toggleMobileMenu(btn) {

    const li = btn.closest('li');
    const menu = li.querySelector('.mobile-menu');
    const isHidden = menu.classList.contains('hidden');

    // Zatvori sve ostale otvorene menije
    document.querySelectorAll('.mobile-menu').forEach(m => {
        if (!m.classList.contains('hidden') && m !== menu) {
            m.classList.add('hidden');
            m.classList.remove('flex');
            const parentLi = m.closest('li');
            if (parentLi) {
                const triggerBtn = parentLi.querySelector('button[onclick="toggleMobileMenu(this)"]');
                if (triggerBtn) {
                    triggerBtn.classList.remove('bg-purple-600', 'text-white', 'border-purple-500');
                    triggerBtn.classList.add('bg-purple-600/20', 'text-purple-400');
                }
            }
        }

        var filterClassDropdown = document.getElementById('filterStudentsClassDropdown');
        var filterClassBtn = document.getElementById('filterStudentsClassBtn');
        if (filterClassDropdown && !filterClassDropdown.classList.contains('hidden')) {
            if (!filterClassDropdown.contains(event.target) && !filterClassBtn.contains(event.target)) {
                filterClassDropdown.classList.add('hidden');
            }
        }
    });

    if (isHidden) {
        menu.classList.remove('hidden');
        menu.classList.add('flex');
        btn.classList.add('bg-purple-600', 'text-white', 'border-purple-500');
        btn.classList.remove('bg-purple-600/20', 'text-purple-400');
    } else {
        menu.classList.add('hidden');
        menu.classList.remove('flex');
        btn.classList.remove('bg-purple-600', 'text-white', 'border-purple-500');
        btn.classList.add('bg-purple-600/20', 'text-purple-400');
    }
}

function toggleSectionInput(btn, e) {
    const input = document.getElementById('sectionInput');
    const cancelBtn = document.getElementById('cancelSectionBtn');
    if (input.classList.contains('w-0')) {
        input.classList.remove('w-0', 'p-0', 'border-none', 'opacity-0');
        input.classList.add('w-48', 'px-3', 'h-9', 'border', 'border-gray-600');
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
    input.classList.remove('w-48', 'px-3', 'h-9', 'border', 'border-gray-600');
    
    if (btn) {
        btn.type = 'button';
        btn.innerHTML = '<i class="fas fa-folder-plus"></i>';
        btn.title = 'Dodaj sekciju';
    }
    if (cancelBtn) cancelBtn.classList.add('hidden');
}
</script>

<!-- ===== Moderna custom validacija (srpski jezik) ===== -->
<style>
.field-error-tooltip {
    position: absolute;
    z-index: 99999;
    background: linear-gradient(135deg, #1e1e2e, #2d1b3d);
    border: 1px solid rgba(239,68,68,0.4);
    color: #fca5a5;
    font-size: 12px;
    font-weight: 600;
    padding: 8px 13px;
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.5), 0 0 0 1px rgba(239,68,68,0.15);
    display: flex;
    align-items: center;
    gap: 7px;
    white-space: nowrap;
    pointer-events: none;
    animation: tooltipIn 0.18s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    max-width: 280px;
    white-space: normal;
}
.field-error-tooltip::before {
    content: '';
    position: absolute;
    top: -6px;
    left: 16px;
    width: 10px;
    height: 10px;
    background: #2d1b3d;
    border-left: 1px solid rgba(239,68,68,0.4);
    border-top: 1px solid rgba(239,68,68,0.4);
    transform: rotate(45deg);
}
.field-error-tooltip .err-icon {
    color: #ef4444;
    font-size: 13px;
    flex-shrink: 0;
}
.field-error-glow {
    box-shadow: 0 0 0 2px rgba(239,68,68,0.5) !important;
    border-color: #ef4444 !important;
    animation: errorShake 0.35s cubic-bezier(.36,.07,.19,.97) both;
}
@keyframes tooltipIn {
    from { opacity: 0; transform: translateY(-6px) scale(0.95); }
    to   { opacity: 1; transform: translateY(0)   scale(1); }
}
@keyframes errorShake {
    10%, 90% { transform: translateX(-2px); }
    20%, 80% { transform: translateX(3px); }
    30%, 50%, 70% { transform: translateX(-3px); }
    40%, 60% { transform: translateX(3px); }
}

/* ────────────────────────────────────────────────────────────────── */
/* Archived Subjects Collapse/Expand Animation */
/* ────────────────────────────────────────────────────────────────── */
#archivedSubjectsContainer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#archivedSubjectsContainer:not(.hidden) {
    max-height: 500px;
}

#archiveToggleIcon {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
<script>
(function() {
    // Srpske poruke validacije
    function getValidationMsg(input) {
        const val = input.value.trim();
        const tag = input.tagName.toLowerCase();

        if (input.validity.valueMissing || (input.required && val === '')) {
            if (tag === 'select') return 'Molimo odaberite opciju.';
            if (input.type === 'checkbox') return 'Ovo polje je obavezno.';
            if (input.type === 'file') return 'Molimo odaberite fajl.';
            return 'Ovo polje je obavezno.';
        }
        if (input.validity.tooShort) {
            return `Minimalna dužina je ${input.minLength} znakova (uneseno ${val.length}).`;
        }
        if (input.validity.tooLong) {
            return `Maksimalna dužina je ${input.maxLength} znakova.`;
        }
        if (input.validity.typeMismatch) {
            if (input.type === 'email') return 'Unesite ispravnu e-mail adresu.';
            if (input.type === 'url')   return 'Unesite ispravnu URL adresu.';
            return 'Format nije ispravan.';
        }
        if (input.validity.patternMismatch) {
            return input.title || 'Vrijednost ne odgovara traženom formatu.';
        }
        if (input.validity.rangeUnderflow) {
            return `Minimalna vrijednost je ${input.min}.`;
        }
        if (input.validity.rangeOverflow) {
            return `Maksimalna vrijednost je ${input.max}.`;
        }
        if (input.validity.stepMismatch) {
            return 'Unesite ispravnu vrijednost koraka.';
        }
        if (input.validity.badInput) {
            return 'Unesite ispravnu vrijednost.';
        }
        return 'Ova vrijednost nije ispravna.';
    }

    let currentTooltip = null;
    let currentGlowEl = null;

    function removeTooltip() {
        if (currentTooltip) { currentTooltip.remove(); currentTooltip = null; }
        if (currentGlowEl)  { currentGlowEl.classList.remove('field-error-glow'); currentGlowEl = null; }
    }

    function showTooltip(input) {
        removeTooltip();
        const msg = getValidationMsg(input);
        const tooltip = document.createElement('div');
        tooltip.className = 'field-error-tooltip';
        tooltip.innerHTML = `<i class="fas fa-exclamation-circle err-icon"></i><span>${msg}</span>`;

        // Pozicioniranje
        const rect = input.getBoundingClientRect();
        tooltip.style.position = 'fixed';
        tooltip.style.top  = (rect.bottom + 8) + 'px';
        tooltip.style.left = rect.left + 'px';

        document.body.appendChild(tooltip);
        currentTooltip = tooltip;

        // Glow na inputu
        input.classList.add('field-error-glow');
        currentGlowEl = input;

        // Scroll do inputa ako je izvan vidnog polja
        input.scrollIntoView({ behavior: 'smooth', block: 'center' });

        // Auto-ukloni za 3.5 sekunde
        setTimeout(removeTooltip, 3500);
    }

    // Sve forme postavljamo na novalidate i hvatamo invalid event
    function initForms() {
        document.querySelectorAll('form').forEach(form => {
            if (form.dataset.customValidated) return;
            form.noValidate = true;
            form.dataset.customValidated = '1';

            form.addEventListener('submit', function(e) {
                const invalid = Array.from(form.elements).find(el => {
                    if (!el.willValidate) return false;
                    return !el.checkValidity();
                });
                if (invalid) {
                    e.preventDefault();
                    e.stopPropagation();
                    showTooltip(invalid);
                    invalid.focus();
                }
            });
        });

        // Ukloni tooltip kad korisnik počne pisati
        document.addEventListener('input', function(e) {
            if (e.target === currentGlowEl || e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                removeTooltip();
            }
        }, true);

        document.addEventListener('click', function(e) {
            if (currentTooltip && !currentTooltip.contains(e.target) && e.target !== currentGlowEl) {
                removeTooltip();
            }
        });
    }

    // Inicijalizuj odmah i promatraj dinamički dodane forme (modali)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initForms);
    } else {
        initForms();
    }

    // Observer za dinamički generisane forme unutar modala
    const obs = new MutationObserver(() => initForms());
    obs.observe(document.body, { childList: true, subtree: true });
})();
</script>

</body>
</html>

<?php if(isset($_SESSION['reopen_manage_users']) && $_SESSION['reopen_manage_users']): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(() => {
        const btn = document.getElementById('openManageUsers');
        if (btn) btn.click();
    }, 100);
});
</script>
<?php unset($_SESSION['reopen_manage_users']); endif; ?>

<script>
/* ============================================================
   TEMA SISTEM — Admin Dashboard
   ============================================================ */
// Theme je već učitan na početku stranice sa subject-specificnom logikom

function toggleTheme() {
    var btn = document.getElementById('themeToggleBtn');
    // Sprečava dvostruki klik tokom animacije
    if (btn && btn.classList.contains('switching')) return;
    if (btn) btn.classList.add('switching');

    // Suptilan fade prijelaz stranice
    document.body.style.transition = 'opacity 0.15s ease';
    document.body.style.opacity = '0.88';

    setTimeout(function() {
        var isOcean = document.documentElement.classList.toggle('theme-ocean');

        var urlParams = new URLSearchParams(window.location.search);
        var currentSubject = urlParams.get('subject');
        if (currentSubject) {
            localStorage.setItem('subject_' + currentSubject + '_theme', isOcean ? 'ocean' : 'purple');
        } else {
            localStorage.setItem('appTheme', isOcean ? 'ocean' : 'purple');
        }

        // Vrati opacity
        document.body.style.opacity = '1';

        // Ukloni switching klasu nakon animacije
        if (btn) {
            setTimeout(function() { btn.classList.remove('switching'); }, 420);
        }

        // ARIA atribut
        if (btn) btn.setAttribute('aria-checked', isOcean ? 'true' : 'false');

        // Toast notifikacija
        showThemeToast(isOcean ? '🌊 Ocean tema aktivirana' : '💜 Ljubičasta tema aktivirana');
    }, 150);

    // Resetuj body transition
    setTimeout(function() {
        document.body.style.transition = '';
        document.body.style.opacity = '';
    }, 310);
}

// ── TOGGLE ARHIVIRANIH PREDMETA U SIDEBARU ──────────────────────────
function toggleArchivedSubjects() {
    const container = document.getElementById('archivedSubjectsContainer');
    const icon = document.getElementById('archiveToggleIcon');
    const isHidden = container.classList.contains('hidden');
    
    if (isHidden) {
        container.classList.remove('hidden');
        // Calculate max-height for smooth animation
        const height = container.scrollHeight;
        container.style.maxHeight = height + 'px';
        icon.style.transform = 'rotate(180deg)';
        localStorage.setItem('archivedSubjectsExpanded', 'true');
    } else {
        container.style.maxHeight = '0';
        setTimeout(() => {
            container.classList.add('hidden');
        }, 300);
        icon.style.transform = 'rotate(0deg)';
        localStorage.setItem('archivedSubjectsExpanded', 'false');
    }
}

// ── RESTORE ARCHIVED SUBJECTS STATE ────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    const wasExpanded = localStorage.getItem('archivedSubjectsExpanded') === 'true';
    const container = document.getElementById('archivedSubjectsContainer');
    const icon = document.getElementById('archiveToggleIcon');
    
    if (container && wasExpanded) {
        container.classList.remove('hidden');
        const height = container.scrollHeight;
        container.style.maxHeight = height + 'px';
        if (icon) icon.style.transform = 'rotate(180deg)';
    }
});

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
        'backdrop-filter:blur(16px)',
        'box-shadow:0 10px 25px -5px rgba(0,0,0,0.4)',
        'transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1)',
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
        toast.style.transform = 'translateX(-50%) translateY(12px)';
        setTimeout(function() { toast.remove(); }, 350);
    }, 2200);
}
</script>
