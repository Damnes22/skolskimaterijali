<?php
/**
 * models/Section.php
 * Model za upravljanje sekcijama (kategorijama) unutar predmeta.
 */
class Section {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function create(int $subject_id, string $name): bool {
        if ($this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo izmjene u arhiviranim predmetima
        }

        $stmt = $this->conn->prepare("INSERT INTO sections (subject_id, name) VALUES (?, ?)");
        $stmt->bind_param("is", $subject_id, $name);
        return $stmt->execute();
    }

    public function rename(int $id, int $subject_id, string $new_name): bool {
        if ($this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo izmjene u arhiviranim predmetima
        }

        $stmt = $this->conn->prepare("UPDATE sections SET name = ? WHERE id = ? AND subject_id = ?");
        $stmt->bind_param("sii", $new_name, $id, $subject_id);
        return $stmt->execute();
    }

    public function setHidden(int $id, int $subject_id, int $hidden): bool {
        if ($this->isSubjectArchived($subject_id)) {
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE sections SET hidden = ? WHERE id = ? AND subject_id = ?");
        $stmt->bind_param("iii", $hidden, $id, $subject_id);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $subject_id = $this->getSubjectIdForSection($id);
        if ($subject_id === null || $this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo brisanje iz arhiviranih predmeta ili ako sekcija ne postoji
        }

        // Prvo prebacujemo fajlove iz ove sekcije u "Opšte" (NULL) da ne bi ostali "visiti"
        $stmtFiles = $this->conn->prepare("UPDATE files SET section_id = NULL WHERE section_id = ?");
        $stmtFiles->bind_param("i", $id);
        $stmtFiles->execute();

        // Zatim brišemo samu sekciju
        $stmtSec = $this->conn->prepare("DELETE FROM sections WHERE id = ?");
        $stmtSec->bind_param("i", $id);
        return $stmtSec->execute();
    }

    public function isOwnedByAdmin(int $section_id, int $admin_id): bool {
        $stmt = $this->conn->prepare("SELECT sec.id FROM sections sec JOIN subjects sub ON sec.subject_id = sub.id WHERE sec.id = ? AND sub.admin_id = ?");
        $stmt->bind_param("ii", $section_id, $admin_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function moveUp(int $id, int $subject_id): bool {
        if ($this->isSubjectArchived($subject_id)) return false;
        
        $this->ensureDisplayOrderExists($subject_id);

        // Nadji trenutnu sekciju
        $stmt = $this->conn->prepare("SELECT id, display_order FROM sections WHERE id = ? AND subject_id = ?");
        $stmt->bind_param("ii", $id, $subject_id);
        $stmt->execute();
        $current = $stmt->get_result()->fetch_assoc();
        if (!$current) return false;

        // Nadji prethodnu sekciju
        $stmtPrev = $this->conn->prepare("SELECT id, display_order FROM sections WHERE subject_id = ? AND display_order < ? ORDER BY display_order DESC, id DESC LIMIT 1");
        $stmtPrev->bind_param("ii", $subject_id, $current['display_order']);
        $stmtPrev->execute();
        $prev = $stmtPrev->get_result()->fetch_assoc();

        if ($prev) {
            // Zamjeni mesta
            $this->swapOrder($current['id'], $current['display_order'], $prev['id'], $prev['display_order']);
            return true;
        }
        return false;
    }

    public function moveDown(int $id, int $subject_id): bool {
        if ($this->isSubjectArchived($subject_id)) return false;

        $this->ensureDisplayOrderExists($subject_id);

        // Nadji trenutnu sekciju
        $stmt = $this->conn->prepare("SELECT id, display_order FROM sections WHERE id = ? AND subject_id = ?");
        $stmt->bind_param("ii", $id, $subject_id);
        $stmt->execute();
        $current = $stmt->get_result()->fetch_assoc();
        if (!$current) return false;

        // Nadji sledecu sekciju
        $stmtNext = $this->conn->prepare("SELECT id, display_order FROM sections WHERE subject_id = ? AND display_order > ? ORDER BY display_order ASC, id ASC LIMIT 1");
        $stmtNext->bind_param("ii", $subject_id, $current['display_order']);
        $stmtNext->execute();
        $next = $stmtNext->get_result()->fetch_assoc();

        if ($next) {
            // Zamjeni mesta
            $this->swapOrder($current['id'], $current['display_order'], $next['id'], $next['display_order']);
            return true;
        }
        return false;
    }

    private function swapOrder($id1, $order1, $id2, $order2) {
        $stmt = $this->conn->prepare("UPDATE sections SET display_order = ? WHERE id = ?");
        $stmt->bind_param("ii", $order2, $id1);
        $stmt->execute();
        $stmt->bind_param("ii", $order1, $id2);
        $stmt->execute();
    }

    private function ensureDisplayOrderExists(int $subject_id) {
        // Ako su display_order svi 0, postavi im inicijalne vrednosti (10, 20, 30...)
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM sections WHERE subject_id = ? AND display_order > 0");
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        
        if ($res['count'] == 0) {
            $stmtAll = $this->conn->prepare("SELECT id FROM sections WHERE subject_id = ? ORDER BY id ASC");
            $stmtAll->bind_param("i", $subject_id);
            $stmtAll->execute();
            $all = $stmtAll->get_result();
            $order = 10;
            $updateStmt = $this->conn->prepare("UPDATE sections SET display_order = ? WHERE id = ?");
            while ($row = $all->fetch_assoc()) {
                $updateStmt->bind_param("ii", $order, $row['id']);
                $updateStmt->execute();
                $order += 10;
            }
        }
    }

    // Helper method to get subject_id for a given section_id
    private function getSubjectIdForSection(int $section_id): ?int {
        $stmt = $this->conn->prepare("SELECT subject_id FROM sections WHERE id = ?");
        $stmt->bind_param("i", $section_id);
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