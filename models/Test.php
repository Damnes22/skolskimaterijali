<?php
/**
 * models/Test.php
 * Model za upravljanje testovima (tabela `tests`).
 */
class Test {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getById(int $test_id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM tests WHERE id = ?");
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function getByIdAndAdmin(int $test_id, int $admin_id): ?array {
        $stmt = $this->conn->prepare("SELECT t.* FROM tests t JOIN subjects s ON t.subject_id = s.id WHERE t.id = ? AND s.admin_id = ?");
        $stmt->bind_param("ii", $test_id, $admin_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function getByIdSubjectAndAdmin(int $test_id, int $subject_id, int $admin_id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM tests WHERE id = ? AND subject_id = ? AND admin_id = ?");
        $stmt->bind_param("iii", $test_id, $subject_id, $admin_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function createFromFile(int $subject_id, string $filename, string $filepath, int $admin_id, ?int $section_id): bool {
        if ($this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo dodavanje testova u arhivirane predmete
        }

        $stmt = $this->conn->prepare("INSERT INTO tests(subject_id, filename, filepath, admin_id, section_id, is_db_test) VALUES(?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("issii", $subject_id, $filename, $filepath, $admin_id, $section_id);
        return $stmt->execute();
    }

    public function createDbTest(int $subject_id, string $test_name, string $filepath, int $admin_id, ?int $section_id = null): ?int {
        if ($this->isSubjectArchived($subject_id)) {
            return null; // Ne dozvoljavamo dodavanje testova u arhivirane predmete
        }

        $stmt = $this->conn->prepare("INSERT INTO tests(subject_id, filename, filepath, admin_id, section_id, is_db_test, duration, is_one_by_one, hide_results) VALUES(?, ?, ?, ?, ?, 1, 40, 0, 0)");
        $stmt->bind_param("issii", $subject_id, $test_name, $filepath, $admin_id, $section_id);
        if ($stmt->execute()) {
            return (int)$stmt->insert_id;
        }
        return null;
    }

    public function updateSection(int $test_id, ?int $section_id): bool {
        $subject_id = $this->getSubjectIdForTest($test_id);
        if ($subject_id === null || $this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo izmjene u arhiviranim predmetima
        }

        $stmt = $this->conn->prepare("UPDATE tests SET section_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $section_id, $test_id);
        return $stmt->execute();
    }

    public function delete(int $test_id): bool {
        $subject_id = $this->getSubjectIdForTest($test_id);
        if ($subject_id === null || $this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo brisanje iz arhiviranih predmeta
        }

        // Ako je DB test, prvo brišemo pitanja zbog stranih ključeva (iako postoji ON DELETE CASCADE, dobro je biti eksplicitan)
        $stmtCheck = $this->conn->prepare("SELECT is_db_test FROM tests WHERE id = ?");
        $stmtCheck->bind_param("i", $test_id);
        $stmtCheck->execute();
        $testData = $stmtCheck->get_result()->fetch_assoc();

        if ($testData && $testData['is_db_test'] == 1) {
            $stmtDelQuestions = $this->conn->prepare("DELETE FROM test_questions WHERE test_id = ?");
            $stmtDelQuestions->bind_param("i", $test_id);
            $stmtDelQuestions->execute();
        }
        
        $stmt = $this->conn->prepare("DELETE FROM tests WHERE id = ?");
        $stmt->bind_param("i", $test_id);
        return $stmt->execute();
    }

    public function toggleVisibility(int $test_id): ?int {
        $subject_id = $this->getSubjectIdForTest($test_id);
        if ($subject_id === null || $this->isSubjectArchived($subject_id)) {
            return null; // Ne dozvoljavamo izmjene u arhiviranim predmetima
        }

        $stmt = $this->conn->prepare("SELECT hidden FROM tests WHERE id = ?");
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $new_hidden = $row['hidden'] ? 0 : 1;
            $upd = $this->conn->prepare("UPDATE tests SET hidden = ? WHERE id = ?");
            $upd->bind_param("ii", $new_hidden, $test_id);
            $upd->execute();
            return $new_hidden;
        }
        return null;
    }

    // Helper method to get subject_id for a given test_id
    private function getSubjectIdForTest(int $test_id): ?int {
        $stmt = $this->conn->prepare("SELECT subject_id FROM tests WHERE id = ?");
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? (int)$res['subject_id'] : null;
    }

    // Helper method to check if a subject is archived
    private function isSubjectArchived(int $subject_id): bool {
        $stmt = $this->conn->prepare("SELECT is_archived FROM subjects WHERE id = ?");
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res && $res['is_archived'] == 1;
    }
}