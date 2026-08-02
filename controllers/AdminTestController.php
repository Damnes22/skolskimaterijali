<?php
require_once __DIR__ . '/../models/Test.php';
require_once __DIR__ . '/../models/Subject.php';

class AdminTestController {
    private $conn;
    private $current_admin_id;
    private $selected_subject;
    private $testModel;
    private $subjectModel;

    public function __construct($conn, $current_admin_id, $selected_subject) {
        $this->conn = $conn;
        $this->current_admin_id = $current_admin_id;
        $this->selected_subject = $selected_subject;
        
        $this->testModel = new Test($conn);
        $this->subjectModel = new Subject($conn);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['move_item']) && $_POST['item_type'] === 'test' && $this->selected_subject > 0) {
            $this->moveTest();
            return true;
        }
        if (isset($_GET['delete_test']) || isset($_POST['delete_test'])) {
            $this->deleteTest();
            return true;
        }
        if (isset($_GET['toggle_test_visibility']) && $this->selected_subject > 0) {
            $this->toggleVisibility();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_test']) && $this->selected_subject > 0) {
            $this->uploadTest();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_test']) && $this->selected_subject > 0) {
            $this->createTest();
            return true;
        }
        return false;
    }

    private function checkCsrf() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token nije validan!");
        }
    }

    private function moveTest() {
        $this->checkCsrf();
        $item_id = (int)$_POST['item_id'];
        $new_section_id = !empty($_POST['new_section_id']) ? (int)$_POST['new_section_id'] : NULL;
        
        if ($this->testModel->getByIdSubjectAndAdmin($item_id, $this->selected_subject, $this->current_admin_id)) {
            $this->testModel->updateSection($item_id, $new_section_id);
            $_SESSION['success_message'] = "Test uspješno premješten!";
        }
        header("Location: index.php?route=admin&subject=" . $this->selected_subject);
        exit;
    }

    private function deleteTest() {
        if (isset($_POST['delete_test'])) $this->checkCsrf();
        $test_id = (int)(isset($_GET['delete_test']) ? $_GET['delete_test'] : $_POST['delete_test']);
        
        $test = $this->testModel->getByIdAndAdmin($test_id, $this->current_admin_id);
        $redirect_subject = $this->selected_subject;
        if ($test) {
            $redirect_subject = $test['subject_id'];
            $fullPath = BASE_DIR . '/../' . $test['filepath']; // Use BASE_DIR from config.php
            if (file_exists($fullPath)) @unlink($fullPath); // Use @ to suppress errors if file is already deleted or permissions issue
            
            if ($this->testModel->delete($test_id)) {
                $_SESSION['success_message'] = "Test uspješno obrisan!";
            } else {
                $_SESSION['error_message'] = "Greška pri brisanju testa!";
            }
        } else {
            $_SESSION['error_message'] = "Test nije pronađen ili nemate pristup!";
        }
        header("Location: index.php?route=admin&subject=" . $redirect_subject);
        exit;
    }

    private function toggleVisibility() {
        $test_id = (int)$_GET['toggle_test_visibility'];
        
        $new_hidden = $this->testModel->toggleVisibility($test_id);
        if ($new_hidden !== null) {
            $_SESSION['success_message'] = $new_hidden ? "Test je sakriven." : "Test je vidljiv.";
        }
        header("Location: index.php?route=admin&subject=" . $this->selected_subject);
        exit;
    }

    private function uploadTest() {
        $this->checkCsrf();
        if (!$this->subjectModel->adminOwns($this->selected_subject, $this->current_admin_id)) {
            $_SESSION['error_message'] = "Nemate pristup ovom predmetu!";
            header("Location: index.php?route=admin");
            exit;
        }

        if (isset($_FILES['test_file']) && $_FILES['test_file']['error'] === 0) {
            $file_extension = strtolower(pathinfo($_FILES['test_file']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'zip', 'rar', 'html'];

            if (!in_array($file_extension, $allowed_extensions)) {
                $_SESSION['error_message'] = "Nedozvoljen tip fajla!";
                header("Location: index.php?route=admin&subject=" . $this->selected_subject);
                exit;
            }

            if ($_FILES['test_file']['size'] > 10 * 1024 * 1024) {
                $_SESSION['error_message'] = "Fajl je prevelik! Maksimalna veličina je 10MB.";
                header("Location: index.php?route=admin&subject=" . $this->selected_subject);
                exit;
            }

            $uploadDir = __DIR__ . "/../../uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $filename = basename($_FILES['test_file']['name']);
            $newFilename = time() . "_test_" . $filename;
            $relativePath = "uploads/" . $newFilename;
            $targetPath = __DIR__ . "/../" . $relativePath;
            $section_id = !empty($_POST['test_section_id']) ? (int)$_POST['test_section_id'] : NULL;

            if (move_uploaded_file($_FILES['test_file']['tmp_name'], $targetPath)) {
                $this->testModel->createFromFile($this->selected_subject, $filename, $relativePath, $this->current_admin_id, $section_id);
                $_SESSION['success_message'] = "Test uspješno uploadovan!";
            } else {
                $_SESSION['error_message'] = "Greška pri uploadu testa!";
            }
        } else {
            $_SESSION['error_message'] = "Molimo odaberite fajl za upload!";
        }
        header("Location: index.php?route=admin&subject=" . $this->selected_subject);
        exit;
    }

    private function createTest() {
        $this->checkCsrf();
        if (!$this->subjectModel->adminOwns($this->selected_subject, $this->current_admin_id)) {
            $_SESSION['error_message'] = "Nemate pristup ovom predmetu!";
            header("Location: index.php?route=admin");
            exit;
        }

        $test_name = trim($_POST['test_name']);
        if (empty($test_name)) {
            $_SESSION['error_message'] = "Naziv testa je obavezan!";
            header("Location: index.php?route=admin&subject=" . $this->selected_subject);
            exit;
        }

        $filename = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $test_name) . ".html";
        $uniqueName = time() . "_test_" . $filename;
        $relativePath = "uploads/" . $uniqueName;

        // Za DB testove ne kreiramo fizički HTML fajl. Zapisujemo is_db_test = 1 u bazu.
        // Filename sadrži naziv testa (clean), a kolonu is_db_test postavljamo na 1.
        $new_test_id = $this->testModel->createDbTest($this->selected_subject, $test_name, $relativePath, $this->current_admin_id);
        
        if ($new_test_id) {
            $_SESSION['success_message'] = "Test uspješno kreiran! Možete dodati pitanja.";
            header("Location: index.php?route=edit_test&id=" . $new_test_id);
            exit;
        } else {
            $_SESSION['error_message'] = "Greška pri upisu u bazu!";
        }
        
        header("Location: index.php?route=admin&subject=" . $this->selected_subject);
        exit;
    }
}
