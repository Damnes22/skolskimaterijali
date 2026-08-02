<?php
/**
 * edit_test.php — Backward-compatibility wrapper
 *
 * Ovaj fajl postoji samo radi retrokompatibilnosti.
 * Preusmjerava sve zahtjeve na MVC rutu: index.php?route=edit_test
 *
 * Interni linkovi u kodu trebaju koristiti: index.php?route=edit_test&id=X
 */

session_start();

// Proslijedi sve GET parametre MVC routeru
$params = $_GET;
$params['route'] = 'edit_test';

// POST zahtjev preusmjeri sa 307 (čuva POST metodu i tijelo)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location: index.php?" . http_build_query($params), true, 307);
} else {
    header("Location: index.php?" . http_build_query($params));
}
exit;