<?php
require_once __DIR__ . '/../models/File.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/StudentWork.php';

class AdminFileController {
    private $conn;
    private $current_admin_id;
    private $selected_subject;
    private $fileModel;
    private $subjectModel;
    private $studentWorkModel;

    public function __construct($conn, $current_admin_id, $selected_subject) {
        $this->conn = $conn;
        $this->current_admin_id = $current_admin_id;
        $this->selected_subject = $selected_subject;
        
        $this->fileModel = new File($conn);
        $this->subjectModel = new Subject($conn);
        $this->studentWorkModel = new StudentWork($conn);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rename_file']) && $this->selected_subject > 0) {
            $this->renameFile();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['move_item']) && $_POST['item_type'] === 'file' && $this->selected_subject > 0) {
            $this->moveFile();
            return true;
        }
        if (isset($_GET['delete_file']) || isset($_POST['delete_file'])) {
            $this->deleteFile();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_file']) && $this->selected_subject > 0) {
            $this->uploadFile();
            return true;
        }
        if ((isset($_GET['delete_work']) || isset($_POST['delete_work'])) && $this->selected_subject > 0) {
            $this->deleteWork();
            return true;
        }
        if (isset($_GET['delete_all_works']) && $this->selected_subject > 0) {
            $this->deleteAllWorks();
            return true;
        }
        if (isset($_GET['download_all_works']) && $this->selected_subject > 0) {
            $this->downloadAllWorks();
            return true;
        }
        if (isset($_GET['download_work']) && $this->selected_subject > 0) {
            $this->downloadSingleWork();
            return true;
        }
        return false;
    }

    private function checkCsrf() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token nije validan!");
        }
    }

    private function renameFile() {
        $this->checkCsrf();
        $file_id = (int)$_POST['file_id'];
        $new_name = trim($_POST['new_file_name']);
        if (!empty($new_name)) {
            $file = $this->fileModel->getByIdSubjectAndAdmin($file_id, $this->selected_subject, $this->current_admin_id);
            if ($file) {
                $extension = pathinfo($file['filename'], PATHINFO_EXTENSION);
                $final_name = $new_name . '.' . $extension;
                $this->fileModel->rename($file_id, $final_name);
                $_SESSION['success_message'] = "Fajl uspješno preimenovan!";
            }
        }
        header("Location: index.php?route=admin&subject=" . $this->selected_subject);
        exit;
    }

    private function moveFile() {
        $this->checkCsrf();
        $item_id = (int)$_POST['item_id'];
        $new_section_id = !empty($_POST['new_section_id']) ? (int)$_POST['new_section_id'] : NULL;
        
        if ($this->fileModel->getByIdSubjectAndAdmin($item_id, $this->selected_subject, $this->current_admin_id)) {
            $this->fileModel->updateSection($item_id, $new_section_id);
            $_SESSION['success_message'] = "Fajl uspješno premješten!";
        }
        header("Location: index.php?route=admin&subject=" . $this->selected_subject);
        exit;
    }

    private function deleteFile() {
        if (isset($_POST['delete_file'])) $this->checkCsrf();
        $file_id = (int)(isset($_GET['delete_file']) ? $_GET['delete_file'] : $_POST['delete_file']);
        
        $file = $this->fileModel->getByIdAndAdmin($file_id, $this->current_admin_id);
        
        $redirect_subject = $this->selected_subject;
        if ($file) {
            $redirect_subject = $file['subject_id'];
            $fullPath = $file['filepath'];
            if (!preg_match('/^[A-Za-z]:\\\\|^\\//', $fullPath)) {
                $fullPath = __DIR__ . '/../' . $fullPath; // adjusted path because we are inside controllers
            }
            if (file_exists($fullPath)) unlink($fullPath);
            
            if ($this->fileModel->delete($file_id)) {
                $_SESSION['success_message'] = "Fajl uspješno obrisan!";
            } else {
                $_SESSION['error_message'] = "Greška pri brisanju fajla!";
            }
        } else {
            $_SESSION['error_message'] = "Fajl nije pronađen ili nemate pristup!";
        }
        header("Location: index.php?route=admin&subject=" . $redirect_subject);
        exit;
    }

    private function uploadFile() {
        $this->checkCsrf();
        if (!$this->subjectModel->adminOwns($this->selected_subject, $this->current_admin_id)) {
            $_SESSION['error_message'] = "Nemate pristup ovom predmetu!";
            header("Location: index.php?route=admin");
            exit;
        }
        
        if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
            $file_extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'zip', 'rar'];
            
            if (!in_array($file_extension, $allowed_extensions)) {
                $_SESSION['error_message'] = "Nedozvoljen tip fajla!";
                header("Location: index.php?route=admin&subject=" . $this->selected_subject);
                exit;
            }
            
            // Dodatna provera MIME tipa za povećanu bezbednost
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);
            finfo_close($finfo);
            if ($mime_type === 'application/x-php' || $mime_type === 'text/x-php') {
                $_SESSION['error_message'] = "Bezbednosna greška: Neispravan tip fajla!";
                header("Location: index.php?route=admin&subject=" . $this->selected_subject);
                exit;
            }
            if ($_FILES['file']['size'] > 10 * 1024 * 1024) {
                $_SESSION['error_message'] = "Fajl je prevelik! Maksimalna veličina je 10MB.";
                header("Location: index.php?route=admin&subject=" . $this->selected_subject);
                exit;
            }
            
            // Adjust uploadDir relative to controller folder
            $uploadDir = __DIR__ . "/../../uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $filename = basename($_FILES['file']['name']);
            $relativePath = "uploads/" . time() . "_" . $filename;
            $targetPath = __DIR__ . "/../" . $relativePath;
            $section_id = !empty($_POST['section_id']) ? (int)$_POST['section_id'] : NULL;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                $this->fileModel->create($this->selected_subject, $filename, $relativePath, $this->current_admin_id, $section_id);
                $_SESSION['success_message'] = "Fajl uspješno uploadovan!";
            } else {
                $_SESSION['error_message'] = "Greška pri uploadu fajla!";
            }
        } else {
            $_SESSION['error_message'] = "Molimo odaberite fajl za upload!";
        }
        header("Location: index.php?route=admin&subject=" . $this->selected_subject);
        exit;
    }

    private function deleteWork() {
        if (isset($_POST['delete_work'])) $this->checkCsrf();
        $work_id = (int)(isset($_GET['delete_work']) ? $_GET['delete_work'] : $_POST['delete_work']);
        
        $work = $this->studentWorkModel->getByIdAndAdmin($work_id, $this->current_admin_id);
        if ($work) {
            $subject_id = (int)$work['subject_id'];
            $path = $work['filepath'];
            $fullPath = $path;
            if (!preg_match('/^[A-Za-z]:\\\\|^\\//', $path)) {
                $fullPath = __DIR__ . '/../' . $path;
            }
            if (file_exists($fullPath)) unlink($fullPath);
            
            $this->studentWorkModel->delete($work_id);
            $_SESSION['success_message'] = "Rad učenika je obrisan.";
            header("Location: index.php?route=admin&subject=" . $subject_id . "#student-works");
            exit;
        } else {
            $_SESSION['error_message'] = "Rad nije pronađen ili nemate pristup.";
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "#student-works");
            exit;
        }
    }

    private function deleteAllWorks() {
        if (!$this->subjectModel->adminOwns($this->selected_subject, $this->current_admin_id)) {
            $_SESSION['error_message'] = "Predmet ne postoji ili nemate pristup.";
            header("Location: index.php?route=admin");
            exit;
        }
        
        $date_filter = isset($_GET['date_filter']) ? $_GET['date_filter'] : 'all';
        $res = $this->studentWorkModel->getAllBySubjectAndFilter($this->selected_subject, $date_filter);
        
        while ($row = $res->fetch_assoc()) {
            $path = $row['filepath'];
            $fullPath = $path;
            if (!preg_match('/^[A-Za-z]:\\\\|^\\//', $path)) {
                $fullPath = __DIR__ . '/../' . $path;
            }
            if (file_exists($fullPath)) unlink($fullPath);
        }
        
        $this->studentWorkModel->deleteAllBySubjectAndFilter($this->selected_subject, $date_filter);
        
        $msg_suffix = ($date_filter !== 'all') ? " (filtrirano)" : "";
        $_SESSION['success_message'] = "Svi radovi za predmet su obrisani" . $msg_suffix . ".";
        header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
        exit;
    }

    private function downloadAllWorks() {
        if (!$this->subjectModel->adminOwns($this->selected_subject, $this->current_admin_id)) {
            $_SESSION['error_message'] = "Nemate pristup ovom predmetu.";
            header("Location: index.php?route=admin");
            exit;
        }
        
        $date_filter = isset($_GET['date_filter']) ? $_GET['date_filter'] : 'all';
        $res = $this->studentWorkModel->getAllBySubjectAndFilter($this->selected_subject, $date_filter);
        
        if ($res->num_rows === 0) {
            $_SESSION['error_message'] = "Nema radova za preuzimanje.";
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
            exit;
        }

        if (!class_exists('ZipArchive')) {
            $_SESSION['error_message'] = "ZipArchive ekstenzija nije instalirana na serveru. Kontaktirajte administratora.";
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
            exit;
        }
        
        $zip = new ZipArchive();
        $tempDir = __DIR__ . '/../uploads/radovi/';
        if (!is_dir($tempDir)) {
            if (!mkdir($tempDir, 0777, true)) {
                $_SESSION['error_message'] = "Ne mogu kreirati uploads/radovi folder. Provjerite dozvole.";
                header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
                exit;
            }
        }
        
        $tmpZip = $tempDir . 'tmp_radovi_' . time() . '_' . mt_rand() . '.zip';
        $zipResult = $zip->open($tmpZip, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        if ($zipResult !== true) {
            $_SESSION['error_message'] = "Ne mogu napraviti ZIP fajl. Greška: " . $zipResult;
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
            exit;
        }

        $freeSpace = disk_free_space($tempDir);
        if ($freeSpace !== false && $freeSpace < 50 * 1024 * 1024) {
            $_SESSION['error_message'] = "Nedovoljno slobodnog prostora na disku za kreiranje ZIP fajla.";
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
            exit;
        }

        $filesAdded = 0;
        $missingFiles = [];
        
        while ($row = $res->fetch_assoc()) {
            $path = $row['filepath'];
            $fullPath = $path;
            if (!preg_match('/^[A-Za-z]:\\\\|^\\//', $path)) {
                $fullPath = __DIR__ . '/../' . $path;
            }
            if (file_exists($fullPath)) {
                $safeName = $row['id'] . "_" . $row['filename'];
                if (!$zip->addFile($fullPath, $safeName)) {
                    $_SESSION['error_message'] = "Greška pri dodavanju fajla u ZIP: " . $safeName;
                    $zip->close();
                    unlink($tmpZip);
                    header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
                    exit;
                }
                $filesAdded++;
            } else {
                $missingFiles[] = $row['filename'];
            }
        }
        
        if ($filesAdded === 0) {
            $zip->close();
            unlink($tmpZip);
            $_SESSION['error_message'] = "Nijedan fajl ne postoji fizički na serveru. Nedostajući fajlovi: " . implode(', ', $missingFiles);
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
            exit;
        }
        
        if (!$zip->close()) {
            unlink($tmpZip);
            $_SESSION['error_message'] = "Greška pri zatvaranju ZIP arhive.";
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
            exit;
        }
        
        $zipName = "radovi_predmet_" . $this->selected_subject . ($date_filter !== 'all' ? "_" . $date_filter : "") . "_" . date('Ymd_His') . ".zip";
        
        if (!file_exists($tmpZip) || filesize($tmpZip) === 0) {
            $_SESSION['error_message'] = "ZIP fajl nije kreiran ispravno.";
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
            exit;
        }

        try {
            while (ob_get_level()) ob_end_clean();
            
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipName . '"');
            header('Content-Length: ' . filesize($tmpZip));
            header('Cache-Control: private, no-transform, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');
            
            readfile($tmpZip);
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Greška pri slanju fajla: " . $e->getMessage();
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "&date_filter=" . $date_filter . "#student-works");
            exit;
        } finally {
            if (file_exists($tmpZip)) {
                unlink($tmpZip);
            }
        }
        exit;
    }

    private function downloadSingleWork() {
        $work_id = (int)$_GET['download_work'];
        $work = $this->studentWorkModel->getByIdAndAdmin($work_id, $this->current_admin_id);
      
        if (!$work) {
            $_SESSION['error_message'] = "Rad ne postoji ili nemate pristup.";
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "#student-works");
            exit;
        }
        
        $filepath = $work['filepath'];
        $filename = $work['filename'];
        
        $fullFilepath = $filepath;
        if (!preg_match('/^[A-Za-z]:\\\\|^\//', $filepath)) {
            $fullFilepath = __DIR__ . '/../' . $filepath;
        }
        
        if (!file_exists($fullFilepath)) {
            $_SESSION['error_message'] = "Fajl ne postoji na serveru.";
            header("Location: index.php?route=admin&subject=" . $this->selected_subject . "#student-works");
            exit;
        }
        
        while (ob_get_level()) ob_end_clean();
        
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($fullFilepath));
        header('Cache-Control: private, no-transform, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        readfile($fullFilepath);
        exit;
    }
}
