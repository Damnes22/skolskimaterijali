<?php
/**
 * models/StudentWork.php
 * Model za upravljanje predatim radovima učenika (tabela `student_works`).
 */
class StudentWork {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getById(int $work_id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM student_works WHERE id = ?");
        $stmt->bind_param("i", $work_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function getStudentWorkById(int $work_id, int $student_id, int $subject_id): ?array {
        $stmt = $this->conn->prepare("SELECT filename, filepath FROM student_works WHERE id = ? AND user_id = ? AND subject_id = ?");
        $stmt->bind_param("iii", $work_id, $student_id, $subject_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function getByIdAndAdmin(int $work_id, int $admin_id): ?array {
        $stmt = $this->conn->prepare("SELECT sw.* FROM student_works sw JOIN subjects s ON sw.subject_id = s.id WHERE sw.id = ? AND s.admin_id = ?");
        $stmt->bind_param("ii", $work_id, $admin_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function delete(int $work_id): bool {
        $stmt = $this->conn->prepare("DELETE FROM student_works WHERE id = ?");
        $stmt->bind_param("i", $work_id);
        return $stmt->execute();
    }

    public function submitWork(int $subject_id, int $user_id, string $filename, string $filepath): bool {
        if ($this->isSubjectArchived($subject_id)) {
            return false; // Ne dozvoljavamo predaju radova u arhivirane predmete
        }

        $stmt = $this->conn->prepare("INSERT INTO student_works(subject_id,user_id,filename,filepath) VALUES(?,?,?,?)");
        $stmt->bind_param("iiss", $subject_id, $user_id, $filename, $filepath);
        return $stmt->execute();
    }

    private function getDateCondition(string $filter): string {
        if ($filter === 'today') return " AND DATE(uploaded_at) = CURDATE()";
        if ($filter === 'week') return " AND uploaded_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        if ($filter === 'month') return " AND uploaded_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        return "";
    }

    public function countWorksBySubject(int $subject_id, string $filter): int {
        $cond = $this->getDateCondition($filter);
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM student_works WHERE subject_id = ?" . $cond);
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        return (int)$stmt->get_result()->fetch_assoc()['total'];
    }

    public function getWorksBySubjectPaginated(int $subject_id, string $filter, int $limit, int $offset): mysqli_result {
        $cond = $this->getDateCondition($filter);
        $stmt = $this->conn->prepare("SELECT sw.*, u.username FROM student_works sw LEFT JOIN users u ON sw.user_id = u.id WHERE sw.subject_id = ?" . $cond . " ORDER BY sw.uploaded_at DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("iii", $subject_id, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getAllBySubjectAndFilter(int $subject_id, string $filter): mysqli_result {
        $date_condition = $this->getDateCondition($filter);
        $stmt = $this->conn->prepare("SELECT id, filename, filepath, uploaded_at FROM student_works WHERE subject_id = ?" . $date_condition . " ORDER BY uploaded_at DESC");
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function deleteAllBySubjectAndFilter(int $subject_id, string $filter): bool {
        $date_condition = $this->getDateCondition($filter);
        $stmt = $this->conn->prepare("DELETE FROM student_works WHERE subject_id = ?" . $date_condition);
        $stmt->bind_param("i", $subject_id);
        return $stmt->execute();
    }

    // Helper metoda za provjeru arhiviranog predmeta
    private function isSubjectArchived(int $subject_id): bool {
        $stmt = $this->conn->prepare("SELECT is_archived FROM subjects WHERE id = ?");
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res && $res['is_archived'] == 1;
    }
}