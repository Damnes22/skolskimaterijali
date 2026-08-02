<?php
/**
 * models/Subject.php
 * Model za upravljanje predmetima.
 */
class Subject {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    /**
     * Svi predmeti za učenika (uz opcionalni filter po nastavniku).
     */
    public function getAllForStudent(int $user_id, ?int $parent_admin_id = null) {
        $sql = "SELECT s.* FROM subjects s JOIN user_subjects us ON us.subject_id = s.id WHERE us.user_id = ? AND s.is_archived = 0";
        if (!is_null($parent_admin_id)) {
            $sql .= " AND s.admin_id = ?";
        }
        $sql .= " ORDER BY s.name ASC";
        
        $stmt = $this->conn->prepare($sql);
        if (!is_null($parent_admin_id)) {
            $stmt->bind_param("ii", $user_id, $parent_admin_id);
        } else {
            $stmt->bind_param("i", $user_id);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Svi predmeti sa imenom nastavnika (za master admin pregled).
     */
    public function getAllWithAdminNames() {
        $stmt = $this->conn->prepare("SELECT u.username, s.* FROM subjects s LEFT JOIN users u ON s.admin_id = u.id ORDER BY s.name ASC");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Predmeti nastavnika (za obični admin dashboard).
     */
    public function getAllForAdmin(int $admin_id) {
        $stmt = $this->conn->prepare("SELECT * FROM subjects WHERE admin_id = ? ORDER BY name ASC");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Pronađi predmet po ID-u.
     */
    public function getById(int $id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    /**
     * Kreiraj novi predmet. Vraća ID ili null.
     */
    public function create(string $name, int $admin_id): ?int {
        $stmt = $this->conn->prepare("INSERT INTO subjects (name, admin_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $admin_id);
        return $stmt->execute() ? (int)$stmt->insert_id : null;
    }

    /**
     * Arhiviraj predmet.
     */
    public function archive(int $id, ?int $admin_id = null): bool {
        if ($admin_id !== null) {
            $stmt = $this->conn->prepare("UPDATE subjects SET is_archived = 1 WHERE id = ? AND admin_id = ?");
            $stmt->bind_param("ii", $id, $admin_id);
        } else {
            $stmt = $this->conn->prepare("UPDATE subjects SET is_archived = 1 WHERE id = ?");
            $stmt->bind_param("i", $id);
        }
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    /**
     * Vrati predmet iz arhive.
     */
    public function unarchive(int $id, ?int $admin_id = null): bool {
        if ($admin_id !== null) {
            $stmt = $this->conn->prepare("UPDATE subjects SET is_archived = 0 WHERE id = ? AND admin_id = ?");
            $stmt->bind_param("ii", $id, $admin_id);
        } else {
            $stmt = $this->conn->prepare("UPDATE subjects SET is_archived = 0 WHERE id = ?");
            $stmt->bind_param("i", $id);
        }
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    /**
     * Preimenuj predmet (uz provjeru vlasništva za obične admine).
     */
    public function rename(int $id, string $new_name, ?int $admin_id = null): bool {
        $subject = $this->getById($id);
        if ($subject && $subject['is_archived'] == 1) {
            return false; // Ne dozvoljavamo preimenovanje arhiviranih predmeta
        }

        if ($admin_id !== null) {
            $stmt = $this->conn->prepare("UPDATE subjects SET name = ? WHERE id = ? AND admin_id = ?");
            $stmt->bind_param("sii", $new_name, $id, $admin_id);
        } else {
            $stmt = $this->conn->prepare("UPDATE subjects SET name = ? WHERE id = ?");
            $stmt->bind_param("si", $new_name, $id);
        }
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    /**
     * Obriši predmet (uz provjeru vlasništva za obične admine).
     */
    public function delete(int $id, ?int $admin_id = null): bool {
        $subject = $this->getById($id);
        if ($subject && $subject['is_archived'] == 1) {
            return false; // Ne dozvoljavamo brisanje arhiviranih predmeta
        }

        if ($admin_id !== null) {
            $stmt = $this->conn->prepare("DELETE FROM subjects WHERE id = ? AND admin_id = ?");
            $stmt->bind_param("ii", $id, $admin_id);
        } else {
            $stmt = $this->conn->prepare("DELETE FROM subjects WHERE id = ?");
            $stmt->bind_param("i", $id);
        }
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    /**
     * Toggle vidljivosti testova za predmet. Vraća novu vrijednost (0 ili 1) ili false.
     */
    public function toggleTests(int $subject_id) {
        $stmt = $this->conn->prepare("SELECT hide_tests FROM subjects WHERE id = ?");
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $new_hide = $res->fetch_assoc()['hide_tests'] ? 0 : 1;
            $upd = $this->conn->prepare("UPDATE subjects SET hide_tests = ? WHERE id = ?");
            $upd->bind_param("ii", $new_hide, $subject_id);
            $upd->execute();
            return $new_hide;
        }
        return false;
    }

    /**
     * Provjeri da li admin ima pristup predmetu.
     */
    public function adminOwns(int $subject_id, int $admin_id): bool {
        $stmt = $this->conn->prepare("SELECT id FROM subjects WHERE id = ? AND admin_id = ?");
        $stmt->bind_param("ii", $subject_id, $admin_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function studentHasAccess(int $subject_id, int $student_id, ?int $parent_admin_id): bool {
        if (is_null($parent_admin_id)) { // Master admin
            $stmt = $this->conn->prepare("SELECT s.id FROM subjects s JOIN user_subjects us ON us.subject_id = s.id WHERE us.user_id = ? AND s.id = ? AND s.is_archived = 0 LIMIT 1");
            $stmt->bind_param("ii", $student_id, $subject_id);
        } else { // Non-master admin
            $stmt = $this->conn->prepare("SELECT s.id FROM subjects s JOIN user_subjects us ON us.subject_id = s.id WHERE us.user_id = ? AND s.id = ? AND s.admin_id = ? AND s.is_archived = 0 LIMIT 1");
            $stmt->bind_param("iii", $student_id, $subject_id, $parent_admin_id);
        }
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function getSubjectNameWithAccessCheck(int $subject_id, int $student_id, ?int $parent_admin_id): ?string {
        if (is_null($parent_admin_id)) {
            $stmt = $this->conn->prepare("SELECT s.name FROM subjects s JOIN user_subjects us ON us.subject_id = s.id WHERE us.user_id = ? AND s.id = ? AND s.is_archived = 0 LIMIT 1");
            $stmt->bind_param("ii", $student_id, $subject_id);
        } else { // Non-master admin
            $stmt = $this->conn->prepare("SELECT s.name FROM subjects s JOIN user_subjects us ON us.subject_id = s.id WHERE us.user_id = ? AND s.id = ? AND s.admin_id = ? AND s.is_archived = 0 LIMIT 1");
            $stmt->bind_param("iii", $student_id, $subject_id, $parent_admin_id);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc()['name'] : null;
    }

    public function isArchived(int $subject_id): bool {
        $stmt = $this->conn->prepare("SELECT is_archived FROM subjects WHERE id = ?");
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res && $res['is_archived'] == 1;
    }
}