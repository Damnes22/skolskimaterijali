<?php
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/Section.php';

class AdminSubjectController {
    private $conn;
    private $current_admin_id;
    private $selected_subject;
    private $subjectModel;
    private $sectionModel;

    public function __construct($conn, $current_admin_id, $selected_subject) {
        $this->conn = $conn;
        $this->current_admin_id = $current_admin_id;
        $this->selected_subject = $selected_subject;
        
        $this->subjectModel = new Subject($conn);
        $this->sectionModel = new Section($conn);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_subject'])) {
            $this->createSubject();
            return true;
        }
        if (isset($_GET['delete_subject']) || isset($_POST['delete_subject'])) {
            $this->deleteSubject();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rename_subject'])) {
            $this->renameSubject();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_section']) && $this->selected_subject > 0) {
            $this->createSection();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_section']) && $this->selected_subject > 0) {
            $this->editSection();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_section_hidden']) && $this->selected_subject > 0) {
            $this->toggleSectionHidden();
            return true;
        }
        if (isset($_GET['delete_section']) || isset($_POST['delete_section'])) {
            $this->deleteSection();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['archive_subject'])) {
            $this->checkCsrf();
            $this->archiveSubject();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unarchive_subject'])) {
            $this->checkCsrf();
            $this->unarchiveSubject();
            return true;
        }
        
        return false;
    }

    private function checkCsrf() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token nije validan!");
        }
    }

    private function createSubject() {
        $this->checkCsrf();
        $name = trim($_POST['new_subject']);
        if (!empty($name)) {
            if ($this->subjectModel->create($name, $this->current_admin_id)) {
                $_SESSION['success_message'] = "Predmet uspješno dodat!";
            } else {
                $_SESSION['error_message'] = "Greška pri dodavanju predmeta!";
            }
        } else {
            $_SESSION['error_message'] = "Naziv predmeta ne može biti prazan!";
        }
        header("Location: index.php?route=admin");
        exit;
    }

    private function deleteSubject() {
        if (isset($_POST['delete_subject'])) $this->checkCsrf();
        $id = (int)(isset($_GET['delete_subject']) ? $_GET['delete_subject'] : $_POST['delete_subject']);
        
        if (!$this->subjectModel->adminOwns($id, $this->current_admin_id)) {
            $_SESSION['error_message'] = "Predmet ne postoji ili nemate pristup!";
            header("Location: index.php?route=admin");
            exit;
        }
        
        if ($this->subjectModel->delete($id, $this->current_admin_id)) {
            $_SESSION['success_message'] = "Predmet uspješno obrisan!";
        } else {
            $_SESSION['error_message'] = "Greška pri brisanju predmeta!";
        }
        header("Location: index.php?route=admin");
        exit;
    }

    private function archiveSubject() {
        $id = (int)($_POST['archive_subject'] ?? $_GET['archive_subject'] ?? 0);
        if ($this->subjectModel->archive($id, $this->current_admin_id)) {
            $_SESSION['success_message'] = "📦 Predmet je arhiviran i postavljen u read-only mod.";
        } else {
            $_SESSION['error_message'] = "Greška: Neuspješno arhiviranje ili nemate prava pristupa.";
        }
        header("Location: index.php?route=admin");
        exit;
    }

    private function unarchiveSubject() {
        $id = (int)($_POST['unarchive_subject'] ?? $_GET['unarchive_subject'] ?? 0);
        if ($this->subjectModel->unarchive($id, $this->current_admin_id)) {
            $_SESSION['success_message'] = "✅ Predmet je uspješno vraćen iz arhive.";
        } else {
            $_SESSION['error_message'] = "Greška pri pokušaju aktivacije predmeta.";
        }
        header("Location: index.php?route=admin");
        exit;
    }

    private function renameSubject() {
        $this->checkCsrf();
        $id = (int)$_POST['subject_id'];
        $new_name = trim($_POST['new_subject_name']);
        
        if (!empty($new_name)) {
            if ($this->subjectModel->rename($id, $new_name, $this->current_admin_id)) {
                $_SESSION['success_message'] = "Predmet uspješno preimenovan!";
            } else {
                $_SESSION['error_message'] = "Greška pri preimenovanju ili nemate pristup predmetu!";
            }
        } else {
            $_SESSION['error_message'] = "Naziv predmeta ne može biti prazan!";
        }
        header("Location: index.php?route=admin");
        exit;
    }

    private function createSection() {
        $this->checkCsrf();
        if ($this->subjectModel->adminOwns($this->selected_subject, $this->current_admin_id)) {
            $sec_name = trim($_POST['section_name']);
            if (!empty($sec_name)) {
                $this->sectionModel->create($this->selected_subject, $sec_name);
                $_SESSION['success_message'] = "Sekcija dodata!";
            }
        } else {
            $_SESSION['error_message'] = "Nemate pristup ovom predmetu!";
        }
        header("Location: index.php?route=admin&subject=" . $this->selected_subject);
        exit;
    }

    private function editSection() {
        $this->checkCsrf();
        if (!$this->subjectModel->adminOwns($this->selected_subject, $this->current_admin_id)) die("Nemate pristup!");

        $sec_id = (int)$_POST['section_id'];
        $new_name = trim($_POST['new_section_name']);
        if (!empty($new_name)) {
            $this->sectionModel->rename($sec_id, $this->selected_subject, $new_name);
            $_SESSION['success_message'] = "Sekcija preimenovana!";
        }
        header("Location: index.php?route=admin&subject=" . $this->selected_subject);
        exit;
    }

    private function toggleSectionHidden() {
        $this->checkCsrf();
        if (!$this->subjectModel->adminOwns($this->selected_subject, $this->current_admin_id)) die("Nemate pristup!");

        $sec_id = (int)$_POST['section_id'];
        $hidden = (int)$_POST['hidden'];
        
        $this->sectionModel->setHidden($sec_id, $this->selected_subject, $hidden);
        $_SESSION['success_message'] = $hidden ? "Sekcija sakrivena od učenika!" : "Sekcija je sada vidljiva učenicima!";
        
        header("Location: index.php?route=admin&subject=" . $this->selected_subject);
        exit;
    }

    private function deleteSection() {
        if (isset($_POST['delete_section'])) $this->checkCsrf();
        $sec_id = (int)(isset($_GET['delete_section']) ? $_GET['delete_section'] : $_POST['delete_section']);

        if ($this->sectionModel->isOwnedByAdmin($sec_id, $this->current_admin_id)) {
            $this->sectionModel->delete($sec_id);
            $_SESSION['success_message'] = "Sekcija obrisana!";
        } else {
            $_SESSION['error_message'] = "Nemate pristup brisanju ove sekcije!";
        }
        
        $redirect_subject = isset($_GET['subject']) ? (int)$_GET['subject'] : (isset($_POST['subject']) ? (int)$_POST['subject'] : $this->selected_subject);
        header("Location: index.php?route=admin&subject=" . $redirect_subject);
        exit;
    }
}
