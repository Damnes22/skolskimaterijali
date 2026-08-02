<?php
// config.php — Centralna konfiguracija
// Kredencijali su premješteni u config.local.php (nije u git-u!)
// Za postavljanje: kopiraj config.local.example.php u config.local.php i unesi podatke.

$localConfig = __DIR__ . '/config.local.php';
if (!file_exists($localConfig)) {
    die("❌ Nedostaje config.local.php! Kopiraj config.local.example.php u config.local.php i popuni podatke.");
}
require_once $localConfig;

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Greška pri povezivanju sa bazom: " . $conn->connect_error);
}

// Forsiranje UTF-8 encodinga za bazu podataka
$conn->set_charset("utf8mb4");
$conn->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
mb_internal_encoding('UTF-8');

// Globalne konstante putanja
define('BASE_DIR', __DIR__);
define('UPLOAD_DIR', __DIR__ . '/uploads/');

// Globalna podešavanja vremenske zone
date_default_timezone_set('Europe/Belgrade');
$conn->query("SET time_zone = '" . date('P') . "'");
