<?php
/**
 * models/Database.php
 * Singleton wrapper za MySQL konekciju.
 * Koristi se za centralizovan pristup bez proslijeđivanja $conn varijable svuda.
 *
 * Upotreba:
 *   $db = Database::getInstance();
 *   $conn = $db->getConnection();
 */
class Database {
    private static ?Database $instance = null;
    private mysqli $conn;

    private function __construct() {
        $localConfig = __DIR__ . '/../config.local.php';
        if (!file_exists($localConfig)) {
            die("❌ Nedostaje config.local.php!");
        }
        require_once $localConfig;
        $this->conn = new mysqli($host, $user, $pass, $db);
        if ($this->conn->connect_error) {
            die("❌ Greška pri povezivanju sa bazom: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
        $this->conn->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    /**
     * Vraća jedinu instancu Database klase.
     */
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Vraća aktivnu mysqli konekciju.
     */
    public function getConnection(): mysqli {
        return $this->conn;
    }

    // Spriječi kloniranje i serijalizaciju singletona
    private function __clone() {}
    public function __wakeup() {}
}
