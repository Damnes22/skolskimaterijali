<?php

class AuthController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function showLogin() {
        // Ako je već ulogovan, preusmjeri gđe treba
        if (isset($_SESSION['user_id'])) {
            $this->redirectBasedOnRole($_SESSION['role'], $_SESSION['parent_admin_id'] ?? null);
        }
        
        $msg = "";
        require 'views/auth/login.php';
    }

    public function login() {
        $msg = "";

        // ======= BRUTE-FORCE ZAŠTITA =======
        $maxAttempts = 5;
        $lockoutSeconds = 15 * 60; // 15 minuta

        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['login_lockout_until'] = 0;
        }

        // Provjera da li je korisnik zaključan
        if ($_SESSION['login_lockout_until'] > time()) {
            $remaining = ceil(($_SESSION['login_lockout_until'] - time()) / 60);
            $msg = "Previše neuspješnih pokušaja. Pokušajte ponovo za {$remaining} min.";
            require 'views/auth/login.php';
            return;
        }

        // Reset ako je lockout istekao
        if ($_SESSION['login_lockout_until'] > 0 && $_SESSION['login_lockout_until'] <= time()) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['login_lockout_until'] = 0;
        }
        // ====================================

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $user = $res->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                // Uspješan login – reset brute-force brojača
                $_SESSION['login_attempts'] = 0;
                $_SESSION['login_lockout_until'] = 0;

                // Generisanje novog ID sesije radi sprječavanja fiksacije sesije
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['parent_admin_id'] = $user['parent_admin_id'];

                $this->redirectBasedOnRole($user['role'], $user['parent_admin_id']);
            } else {
                $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] >= $maxAttempts) {
                    $_SESSION['login_lockout_until'] = time() + $lockoutSeconds;
                    $msg = "Previše neuspješnih pokušaja. Pokušajte ponovo za 15 min.";
                } else {
                    $remaining_attempts = $maxAttempts - $_SESSION['login_attempts'];
                    $msg = "Pogrešna lozinka! Preostalo pokušaja: {$remaining_attempts}.";
                }
            }
        } else {
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= $maxAttempts) {
                $_SESSION['login_lockout_until'] = time() + $lockoutSeconds;
                $msg = "Previše neuspješnih pokušaja. Pokušajte ponovo za 15 min.";
            } else {
                $msg = "Korisnik ne postoji!";
            }
        }

        require 'views/auth/login.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?route=login");
        exit;
    }

    private function redirectBasedOnRole($role, $parent_admin_id = null) {
        $query = $_GET;
        unset($query['route']);

        if ($role === 'admin' && !is_null($parent_admin_id)) {
            // Obični admini idu na svoj dashboard
            $query['route'] = 'admin';
            $queryString = http_build_query($query);
            header("Location: index.php?" . $queryString);
        } else {
            // Učenici i Master Admin idu na glavnu (čistu) rutu
            $queryString = http_build_query($query);
            $url = "index.php" . (!empty($queryString) ? "?" . $queryString : "");
            header("Location: " . $url);
        }
        exit;
    }
}
