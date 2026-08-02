<?php
/**
 * models/ClassModel.php
 * Model za upravljanje odjeljenjima (tabela `classes`) i dodjelu učenika/predmeta.
 */
class ClassModel {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getByIdAndAdmin(int $class_id, int $admin_id): ?array {
        $stmt = $this->conn->prepare("SELECT name FROM classes WHERE id = ? AND admin_id = ?");
        $stmt->bind_param("ii", $class_id, $admin_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    public function studentBelongsToAdmin(int $student_id, int $admin_id): bool {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE id = ? AND parent_admin_id = ? AND role = 'student'");
        $stmt->bind_param("ii", $student_id, $admin_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function addStudent(int $student_id, int $class_id): bool {
        $stmt = $this->conn->prepare("UPDATE users SET class_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $class_id, $student_id);
        return $stmt->execute();
    }

    public function removeStudent(int $student_id): bool {
        $stmt = $this->conn->prepare("UPDATE users SET class_id = NULL WHERE id = ?");
        $stmt->bind_param("i", $student_id);
        return $stmt->execute();
    }

    public function assignSubjectToClass(int $subject_id, int $class_id, int $admin_id): bool {
        $stmt = $this->conn->prepare("INSERT IGNORE INTO user_subjects (user_id, subject_id) SELECT id, ? FROM users WHERE class_id = ? AND parent_admin_id = ? AND role = 'student'");
        $stmt->bind_param("iii", $subject_id, $class_id, $admin_id);
        return $stmt->execute();
    }

    public function getStudentsInClass(int $class_id, int $admin_id): array {
        $stmt = $this->conn->prepare("SELECT id, username FROM users WHERE class_id = ? AND parent_admin_id = ? ORDER BY username ASC");
        $stmt->bind_param("ii", $class_id, $admin_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getStudentsNotInClass(int $class_id, int $admin_id): array {
        $stmt = $this->conn->prepare("SELECT u.id, u.username, c.name as current_class FROM users u LEFT JOIN classes c ON u.class_id = c.id WHERE (u.class_id IS NULL OR u.class_id != ?) AND u.parent_admin_id = ? AND u.role = 'student' ORDER BY u.username ASC");
        $stmt->bind_param("ii", $class_id, $admin_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}