<?php
/**
 * models/User.php
 * Model za rad sa korisnicima (admins + studenti).
 *
 * Metode rade sa već postojećom $conn konekcijom ili mogu koristiti Database singleton.
 */
class User {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    /**
     * Pronađi korisnika po ID-u.
     */
    public function getById(int $id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    /**
     * Pronađi korisnika po korisničkom imenu.
     */
    public function getByUsername(string $username): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    /**
     * Kreiraj novog korisnika. Vraća ID kreiranog korisnika ili null pri grešci.
     */
    public function create(string $username, string $password, string $role, ?int $parent_admin_id = null, ?int $class_id = null): ?int {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare(
            "INSERT INTO users (username, password, role, parent_admin_id, class_id) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssii", $username, $hash, $role, $parent_admin_id, $class_id);
        if ($stmt->execute()) {
            return (int)$stmt->insert_id;
        }
        return null;
    }

    /**
     * Ažuriraj lozinku korisnika.
     */
    public function updatePassword(int $id, string $new_password): bool {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hash, $id);
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    /**
     * Ažuriraj korisničko ime.
     */
    public function updateUsername(int $id, string $username): bool {
        // Provjera jedinstvenosti
        $check = $this->conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $check->bind_param("si", $username, $id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            return false; // Već postoji
        }
        $stmt = $this->conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $username, $id);
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    /**
     * Obriši korisnika i sve njegove učenike (za brisanje nastavnika od strane master admina).
     */
    public function deleteAdminWithStudents(int $admin_id): bool {
        try {
            $stmt = $this->conn->prepare("DELETE FROM user_subjects WHERE user_id IN (SELECT id FROM users WHERE parent_admin_id = ?)");
            $stmt->bind_param("i", $admin_id); $stmt->execute();
            $stmt = $this->conn->prepare("DELETE FROM users WHERE parent_admin_id = ?");
            $stmt->bind_param("i", $admin_id); $stmt->execute();
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $admin_id); $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Provjeri da li korisničko ime postoji.
     */
    public function usernameExists(string $username, ?int $exclude_id = null): bool {
        if ($exclude_id !== null) {
            $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
            $stmt->bind_param("si", $username, $exclude_id);
        } else {
            $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
        }
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    /**
     * Provjeri da li je korisnik master admin (admin bez parent_admin_id).
     */
    public function isMasterAdmin(int $user_id): bool {
        $stmt = $this->conn->prepare("SELECT parent_admin_id FROM users WHERE id = ? AND role = 'admin'");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 0) return false;
        $row = $res->fetch_assoc();
        return is_null($row['parent_admin_id']);
    }

    /**
     * Učitaj sve učenike za određenog nastavnika/admina.
     */
    public function getStudentsByAdmin(int $admin_id): array {
        $stmt = $this->conn->prepare(
            "SELECT u.*, c.name as class_name FROM users u LEFT JOIN classes c ON u.class_id = c.id WHERE u.role = 'student' AND u.parent_admin_id = ? ORDER BY u.username ASC"
        );
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getStudentParentAdminId(int $user_id): ?int {
        $stmt = $this->conn->prepare("SELECT parent_admin_id FROM users WHERE id = ? AND role = 'student'");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc()['parent_admin_id'] : null;
    }

    public function getAllUsersWithCreators(int $limit): mysqli_result {
        $stmt = $this->conn->prepare("SELECT u.*, COALESCE(pa.username, 'Master Admin') as created_by FROM users u LEFT JOIN users pa ON u.parent_admin_id = pa.id ORDER BY u.role DESC, u.id DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getAdminsOverview(string $search): mysqli_result {
        $sql = "SELECT a.id, a.username, COUNT(DISTINCT u.id) AS student_count, COUNT(DISTINCT s.id) AS subject_count FROM users a LEFT JOIN users u ON u.parent_admin_id = a.id AND u.role = 'student' LEFT JOIN subjects s ON s.admin_id = a.id WHERE a.role='admin'";
        if (!empty($search)) $sql .= " AND a.username LIKE ?";
        $sql .= " GROUP BY a.id, a.username ORDER BY a.id ASC";
        $stmt = $this->conn->prepare($sql);
        if (!empty($search)) { 
            $param = "%$search%"; 
            $stmt->bind_param("s", $param); 
        }
        $stmt->execute();
        return $stmt->get_result();
    }
}
