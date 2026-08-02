<?php
/**
 * models/File.php
 * Model za upravljanje fajlovima/materijalima (tabela `files`).
 */
class File {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getById(int $file_id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM files WHERE id = ?");
        $stmt->bind_param("i", $file_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function getByIdAndAdmin(int $file_id, int $admin_id): ?array {
        $stmt = $this->conn->prepare("SELECT f.* FROM files f JOIN subjects s ON f.subject_id = s.id WHERE f.id = ? AND s.admin_id = ?");
        $stmt->bind_param("ii", $file_id, $admin_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function getByIdSubjectAndAdmin(int $file_id, int $subject_id, int $admin_id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM files WHERE id = ? AND subject_id = ? AND admin_id = ?");
        $stmt->bind_param("iii", $file_id, $subject_id, $admin_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function rename(int $file_id, string $new_filename): bool {
        $subject_id = $this->getSubjectIdForFile($file_id);
        if ($subject_id === null || $this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo izmjene u arhiviranim predmetima
        }

        $stmt = $this->conn->prepare("UPDATE files SET filename = ? WHERE id = ?");
        $stmt->bind_param("si", $new_filename, $file_id);
        return $stmt->execute();
    }

    public function updateSection(int $file_id, ?int $section_id): bool {
        $subject_id = $this->getSubjectIdForFile($file_id);
        if ($subject_id === null || $this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo izmjene u arhiviranim predmetima
        }

        $stmt = $this->conn->prepare("UPDATE files SET section_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $section_id, $file_id);
        return $stmt->execute();
    }

    public function delete(int $file_id): bool {
        $subject_id = $this->getSubjectIdForFile($file_id);
        if ($subject_id === null || $this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo brisanje iz arhiviranih predmeta
        }

        $stmt = $this->conn->prepare("DELETE FROM files WHERE id = ?");
        $stmt->bind_param("i", $file_id);
        return $stmt->execute();
    }

    public function create(int $subject_id, string $filename, string $filepath, int $admin_id, ?int $section_id): bool {
        if ($this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo dodavanje fajlova u arhivirane predmete
        }

        $stmt = $this->conn->prepare("INSERT INTO files(subject_id, filename, filepath, admin_id, section_id) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("issii", $subject_id, $filename, $filepath, $admin_id, $section_id);
        return $stmt->execute();
    }

    // Helper method to get subject_id for a given file_id
    private function getSubjectIdForFile(int $file_id): ?int {
        $stmt = $this->conn->prepare("SELECT subject_id FROM files WHERE id = ?");
        $stmt->bind_param("i", $file_id);
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