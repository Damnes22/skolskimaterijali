<?php
require_once __DIR__ . '/../models/ClassModel.php';
require_once __DIR__ . '/../models/Subject.php';

class OrganizeClassController {
    private $conn;
    private $classModel;
    private $subjectModel;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->classModel = new ClassModel($conn);
        $this->subjectModel = new Subject($conn);
    }

    public function index() {
        // Provjera pristupa
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?route=login");
            exit;
        }

        $current_admin_id = (int)$_SESSION['user_id'];
        $class_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Provjera vlasništva nad odjeljenjem
        $class = $this->classModel->getByIdAndAdmin($class_id, $current_admin_id);
        if (!$class) {
            die("Odjeljenje nije pronađeno ili nemate pristup.");
        }
        $class_name = htmlspecialchars($class['name']);

        // CSRF zaštita
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $csrf_token = $_SESSION['csrf_token'];

        // AJAX handler
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                echo json_encode(['status' => 'error', 'message' => 'CSRF zaštita nije validna. Osvježite stranicu.']);
                exit;
            }
            
            $student_id = isset($_POST['student_id']) ? (int)$_POST['student_id'] : 0;
            
            if ($_POST['action'] === 'add' || $_POST['action'] === 'remove') {
                // Provjera da li student pripada ovom master adminu
                if (!$this->classModel->studentBelongsToAdmin($student_id, $current_admin_id)) {
                    echo json_encode(['status' => 'error', 'message' => 'Učenik ne postoji ili nemate pristup.']);
                    exit;
                }
            }

            if ($_POST['action'] === 'add') {
                if ($this->classModel->addStudent($student_id, $class_id)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Greška na serveru.']);
                }
                exit;
            } elseif ($_POST['action'] === 'remove') {
                if ($this->classModel->removeStudent($student_id)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Greška na serveru.']);
                }
                exit;
            } elseif ($_POST['action'] === 'assign_subject_to_class') {
                $subject_id = (int)$_POST['subject_id'];

                // Provjera vlasništva nad predmetom
                if (!$this->subjectModel->adminOwns($subject_id, $current_admin_id)) {
                    echo json_encode(['status' => 'error', 'message' => 'Izabrani predmet nije pronađen.']);
                    exit;
                }

                // Efikasno dodjeljivanje predmeta svim učenicima iz odjeljenja pomoću jednog upita
                if ($this->classModel->assignSubjectToClass($subject_id, $class_id, $current_admin_id)) {
                    echo json_encode(['status' => 'success', 'message' => 'Predmet je uspješno dodijeljen učenicima.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Greška pri dodjeli predmeta.']);
                }
                exit;
            }
        }

        // Fetch predmete ovog admina (za masovnu dodjelu)
        $admin_subjects = $this->subjectModel->getAllForAdmin($current_admin_id)->fetch_all(MYSQLI_ASSOC);

        // Fetch ucenici u ovom odjeljenju
        $in_class = $this->classModel->getStudentsInClass($class_id, $current_admin_id);

        // Fetch ostali ucenici
        $out_class = $this->classModel->getStudentsNotInClass($class_id, $current_admin_id);

        require 'views/admin/organize_class.php';
    }
}
