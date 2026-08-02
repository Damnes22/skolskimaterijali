<?php
/**
 * MasterAdminActionsController.php
 *
 * Rukuje svim admin akcijama za Master Admin korisnike
 * (upravljanje predmetima, fajlovima, testovima, nastavnicima, obavještenjima).
 * Poziva se iz StudentController::index() kada je korisnik master admin.
 */
class MasterAdminActionsController {
    private $conn;
    private $selected_subject;
    private $csrf_token;
    private $subjectModel;
    private $sectionModel;
    private $fileModel;
    private $testModel;
    private $studentWorkModel;
    private $userModel;

    public function __construct($conn, $selected_subject) {
        $this->conn = $conn;
        $this->selected_subject = $selected_subject;
        $this->csrf_token = $_SESSION['csrf_token'] ?? '';
        
        require_once __DIR__ . '/../models/Subject.php';
        require_once __DIR__ . '/../models/Section.php';
        require_once __DIR__ . '/../models/File.php';
        require_once __DIR__ . '/../models/Test.php';
        require_once __DIR__ . '/../models/StudentWork.php';
        require_once __DIR__ . '/../models/User.php';
        
        $this->subjectModel = new Subject($conn);
        $this->sectionModel = new Section($conn);
        $this->fileModel = new File($conn);
        $this->testModel = new Test($conn);
        $this->studentWorkModel = new StudentWork($conn);
        $this->userModel = new User($conn);
    }

    /**
     * Provjerava CSRF token za POST zahtjeve.
     */
    private function checkCsrf() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token nije validan!");
        }
    }

    /**
     * Obradi zahtjev — vrati true ako je akcija obrađena (i treba exit), false inače.
     */
    public function handleRequest() {
        $conn = $this->conn;
        $selected_subject = $this->selected_subject;

        // ============= BRISANJE RADA UČENIKA (ADMIN) =============
        if ((isset($_GET['delete_work']) || isset($_POST['delete_work']))) {
            $work_id = (int)(isset($_GET['delete_work']) ? $_GET['delete_work'] : $_POST['delete_work']);
            if (isset($_POST['delete_work'])) $this->checkCsrf();

            $work = $this->studentWorkModel->getById($work_id);
            if ($work) {
                $subject_id = (int)$work['subject_id'];
                $path = $work['filepath'];
                $fullPath = preg_match('/^[A-Za-z]:\\\\|^\//', $path) ? $path : __DIR__ . '/../' . $path;
                if (file_exists($fullPath)) unlink($fullPath);
                $this->studentWorkModel->delete($work_id);
                $_SESSION['success_message'] = "Rad učenika je obrisan.";
                header("Location: index.php?subject=" . $subject_id . "#student-works");
            } else {
                $_SESSION['error_message'] = "Rad nije pronađen.";
                header("Location: index.php?subject=" . $selected_subject);
            }
            exit;
        }

        // ============= BRISANJE SVIH RADOVA (ADMIN) =============
        if (isset($_GET['delete_all_works']) && $selected_subject > 0) {
            $date_filter = $_GET['date_filter'] ?? 'all';
            $res = $this->studentWorkModel->getAllBySubjectAndFilter($selected_subject, $date_filter);
            while ($row = $res->fetch_assoc()) {
                $path = $row['filepath'];
                $fullPath = preg_match('/^[A-Za-z]:\\\\|^\//', $path) ? $path : __DIR__ . '/../' . $path;
                if (file_exists($fullPath)) unlink($fullPath);
            }
            $this->studentWorkModel->deleteAllBySubjectAndFilter($selected_subject, $date_filter);
            $suffix = ($date_filter !== 'all') ? " (filtrirano)" : "";
            $_SESSION['success_message'] = "Svi radovi za predmet su obrisani" . $suffix . ".";
            header("Location: index.php?subject=" . $selected_subject . "&date_filter=" . $date_filter . "#student-works");
            exit;
        }

        // ============= PREUZIMANJE SVIH RADOVA (ADMIN ZIP) =============
        if (isset($_GET['download_all_works']) && $selected_subject > 0) {
            $date_filter = $_GET['date_filter'] ?? 'all';
            $res = $this->studentWorkModel->getAllBySubjectAndFilter($selected_subject, $date_filter);
            if ($res->num_rows === 0) {
                $_SESSION['error_message'] = "Nema radova za preuzimanje.";
                header("Location: index.php?subject=" . $selected_subject);
                exit;
            }
            $zip = new ZipArchive();
            $tmpZip = __DIR__ . '/../uploads/radovi/tmp_radovi_' . time() . '_' . mt_rand() . '.zip';
            if ($zip->open($tmpZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                $_SESSION['error_message'] = "Ne mogu napraviti ZIP fajl.";
                header("Location: index.php?subject=" . $selected_subject);
                exit;
            }
            $filesAdded = 0;
            while ($row = $res->fetch_assoc()) {
                $path = $row['filepath'];
                $fullPath = preg_match('/^[A-Za-z]:\\\\|^\//', $path) ? $path : __DIR__ . '/../' . $path;
                if (file_exists($fullPath)) { $zip->addFile($fullPath, $row['id'] . "_" . $row['filename']); $filesAdded++; }
            }
            if ($filesAdded === 0) { $zip->close(); unlink($tmpZip); $_SESSION['error_message'] = "Fajlovi ne postoje fizički na serveru."; header("Location: index.php?subject=" . $selected_subject); exit; }
            $zip->close();
            $zipName = "radovi_predmet_" . $selected_subject . ($date_filter !== 'all' ? "_" . $date_filter : "") . "_" . date('Ymd_His') . ".zip";
            while (ob_get_level()) ob_end_clean();
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipName . '"');
            header('Content-Length: ' . filesize($tmpZip));
            header('Cache-Control: private, no-transform, no-store, must-revalidate');
            readfile($tmpZip);
            unlink($tmpZip);
            exit;
        }

        // ============= DODAVANJE PREDMETA =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_subject'])) {
            $this->checkCsrf();
            $name = trim($_POST['new_subject']);
            $current_admin_id = (int)$_SESSION['user_id'];
            if (!empty($name)) {
                if ($this->subjectModel->create($name, $current_admin_id)) {
                    $_SESSION['success_message'] = "Predmet uspješno dodat!";
                } else {
                    $_SESSION['error_message'] = "Greška pri dodavanju predmeta!";
                }
            }
            header("Location: index.php"); exit;
        }

        // ============= ARHIVIRANJE PREDMETA =============
        if (isset($_GET['archive_subject'])) {
            $id = (int)$_GET['archive_subject'];
            if ($this->subjectModel->archive($id)) {
                $_SESSION['success_message'] = "📦 Predmet je uspješno premješten u arhivu.";
            }
            header("Location: index.php"); exit;
        }

        // ============= DEARHIVIRANJE PREDMETA =============
        if (isset($_GET['unarchive_subject'])) {
            $id = (int)$_GET['unarchive_subject'];
            if ($this->subjectModel->unarchive($id)) {
                $_SESSION['success_message'] = "✅ Predmet je uspješno vraćen iz arhive i ponovo je aktivan.";
            }
            header("Location: index.php"); exit;
        }

        // ============= PREIMENOVANJE PREDMETA =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rename_subject'])) {
            $this->checkCsrf();
            $subject_id = (int)$_POST['subject_id'];
            $new_name = trim($_POST['new_subject_name']);
            if (!empty($new_name) && $subject_id > 0) {
                if ($this->subjectModel->rename($subject_id, $new_name)) {
                    $_SESSION['success_message'] = "Predmet uspješno preimenovan!";
                } else {
                    $_SESSION['error_message'] = "Greška pri preimenovanju (moguće da je predmet arhiviran)!";
                }
            } else {
                $_SESSION['error_message'] = "Naziv predmeta ne može biti prazan!";
            }
            header("Location: index.php"); exit;
        }

        // ============= BRISANJE PREDMETA =============
        if (isset($_GET['delete_subject']) || isset($_POST['delete_subject'])) {
            $id = (int)(isset($_GET['delete_subject']) ? $_GET['delete_subject'] : $_POST['delete_subject']);
            if (isset($_POST['delete_subject'])) $this->checkCsrf();
            if ($this->subjectModel->delete($id)) {
                $_SESSION['success_message'] = "Predmet uspješno obrisan!";
            } else {
                $_SESSION['error_message'] = "Greška pri brisanju predmeta!";
            }
            header("Location: index.php"); exit;
        }

        // ============= DODAVANJE SEKCIJE =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_section']) && $selected_subject > 0) {
            $this->checkCsrf();
            $sec_name = trim($_POST['section_name']);
            if (!empty($sec_name)) {
                $this->sectionModel->create($selected_subject, $sec_name);
                $_SESSION['success_message'] = "Sekcija dodata!";
            }
            header("Location: index.php?subject=" . $selected_subject); exit;
        }

        // ============= PREIMENOVANJE SEKCIJE =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_section']) && $selected_subject > 0) {
            $this->checkCsrf();
            $sec_id = (int)$_POST['section_id'];
            $new_name = trim($_POST['new_section_name']);
            if (!empty($new_name)) {
                $this->sectionModel->rename($sec_id, $selected_subject, $new_name);
                $_SESSION['success_message'] = "Sekcija preimenovana!";
            }
            header("Location: index.php?subject=" . $selected_subject); exit;
        }

        // ============= BRISANJE SEKCIJE =============
        if (isset($_GET['delete_section']) || isset($_POST['delete_section'])) {
            $sec_id = (int)(isset($_GET['delete_section']) ? $_GET['delete_section'] : $_POST['delete_section']);
            if (isset($_POST['delete_section'])) $this->checkCsrf();
            $this->sectionModel->delete($sec_id);
            $_SESSION['success_message'] = "Sekcija obrisana!";
            $redirect_subject = isset($_GET['subject']) ? (int)$_GET['subject'] : (isset($_POST['subject']) ? (int)$_POST['subject'] : $selected_subject);
            header("Location: index.php?subject=" . $redirect_subject); exit;
        }

        // ============= PREIMENOVANJE FAJLA =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rename_file']) && $selected_subject > 0) {
            $this->checkCsrf();
            $file_id = (int)$_POST['file_id'];
            $new_name = trim($_POST['new_file_name']);
            if (!empty($new_name)) {
                $file = $this->fileModel->getById($file_id);
                if ($file && $file['subject_id'] == $selected_subject) {
                    $ext = pathinfo($file['filename'], PATHINFO_EXTENSION);
                    $final_name = $new_name . '.' . $ext;
                    $this->fileModel->rename($file_id, $final_name);
                    $_SESSION['success_message'] = "Fajl uspješno preimenovan!";
                }
            }
            header("Location: index.php?subject=" . $selected_subject); exit;
        }

        // ============= PREMJEŠTANJE STAVKE (fajl ili test) =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['move_item']) && $selected_subject > 0) {
            $this->checkCsrf();
            $item_id = (int)$_POST['item_id'];
            $item_type = $_POST['item_type'];
            $new_section_id = !empty($_POST['new_section_id']) ? (int)$_POST['new_section_id'] : NULL;
            if ($item_type === 'test') {
                $this->testModel->updateSection($item_id, $new_section_id);
                $_SESSION['success_message'] = "Stavka uspješno premještena!";
            } else {
                $this->fileModel->updateSection($item_id, $new_section_id);
                $_SESSION['success_message'] = "Stavka uspješno premještena!";
            }
            header("Location: index.php?subject=" . $selected_subject); exit;
        }

        // ============= BRISANJE FAJLA =============
        if (isset($_GET['delete_file']) || isset($_POST['delete_file'])) {
            $file_id = (int)(isset($_GET['delete_file']) ? $_GET['delete_file'] : $_POST['delete_file']);
            if (isset($_POST['delete_file'])) $this->checkCsrf();
            $file = $this->fileModel->getById($file_id);
            $redirect_subject = $selected_subject;
            if ($file) {
                $redirect_subject = $file['subject_id'];
                $fullPath = preg_match('/^[A-Za-z]:\\\\|^\//', $file['filepath']) ? $file['filepath'] : __DIR__ . '/../' . $file['filepath'];
                if (file_exists($fullPath)) unlink($fullPath);
                if ($this->fileModel->delete($file_id)) {
                    $_SESSION['success_message'] = "Fajl uspješno obrisan!";
                } else {
                    $_SESSION['error_message'] = "Greška pri brisanju fajla!";
                }
            } else {
                $_SESSION['error_message'] = "Fajl nije pronađen!";
            }
            header("Location: index.php?subject=" . $redirect_subject); exit;
        }

        // ============= BRISANJE TESTA =============
        if (isset($_GET['delete_test']) || isset($_POST['delete_test'])) {
            $test_id = (int)(isset($_GET['delete_test']) ? $_GET['delete_test'] : $_POST['delete_test']);
            if (isset($_POST['delete_test'])) $this->checkCsrf();
            $test = $this->testModel->getById($test_id);
            $redirect_subject = $selected_subject;
            if ($test) {
                $redirect_subject = $test['subject_id'];
                if (!empty($test['filepath'])) {
                    $fullPath = preg_match('/^[A-Za-z]:\\\\|^\//', $test['filepath']) ? $test['filepath'] : __DIR__ . '/../' . $test['filepath'];
                    if (file_exists($fullPath)) unlink($fullPath);
                }
                $_SESSION[$this->testModel->delete($test_id) ? 'success_message' : 'error_message'] = "Test uspješno obrisan!";
            } else {
                $_SESSION['error_message'] = "Test nije pronađen!";
            }
            header("Location: index.php?subject=" . $redirect_subject); exit;
        }

        // ============= TOGGLE VIDLJIVOSTI TESTA =============
        if (isset($_GET['toggle_test_visibility'])) {
            $test_id = (int)$_GET['toggle_test_visibility'];
            $new_hidden = $this->testModel->toggleVisibility($test_id);
            if ($new_hidden !== null) {
                $_SESSION['success_message'] = $new_hidden ? "Test je sakriven." : "Test je vidljiv.";
            }
            header("Location: index.php?subject=" . ($_GET['subject'] ?? $selected_subject)); exit;
        }

        // ============= TOGGLE TESTOVA PO PREDMETU =============
        if (isset($_GET['toggle_tests']) && isset($_GET['subject'])) {
            $subject_id = (int)$_GET['subject'];
            $new_hide = $this->subjectModel->toggleTests($subject_id);
            if ($new_hide !== false) {
                $_SESSION['success_message'] = $new_hide ? "Testovi su sada sakriveni za učenike!" : "Testovi su sada vidljivi za učenike!";
            }
            header("Location: index.php?subject=" . $subject_id); exit;
        }

        // ============= UPLOAD FAJLA (ADMIN) =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_file']) && $selected_subject > 0) {
            $this->checkCsrf();
            if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
                $file_extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                $allowed_extensions = ['pdf','doc','docx','xls','xlsx','ppt','pptx','txt','jpg','jpeg','png','gif','zip','rar'];
                if (!in_array($file_extension, $allowed_extensions)) {
                    $_SESSION['error_message'] = "Nedozvoljen tip fajla!";
                    header("Location: index.php?subject=" . $selected_subject); exit;
                }
                if ($_FILES['file']['size'] > 10 * 1024 * 1024) {
                    $_SESSION['error_message'] = "Fajl je prevelik! Maksimalna veličina je 10MB.";
                    header("Location: index.php?subject=" . $selected_subject); exit;
                }
                $uploadDir = "uploads/";
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $filename = basename($_FILES['file']['name']);
                $targetPath = $uploadDir . time() . "_" . $filename;
                $section_id = !empty($_POST['section_id']) ? (int)$_POST['section_id'] : NULL;
                $current_admin_id = (int)$_SESSION['user_id'];
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                    $this->fileModel->create($selected_subject, $filename, $targetPath, $current_admin_id, $section_id);
                    $_SESSION['success_message'] = "Fajl uspješno uploadovan!";
                } else {
                    $_SESSION['error_message'] = "Greška pri uploadu fajla!";
                }
            } else {
                $_SESSION['error_message'] = "Molimo odaberite fajl za upload!";
            }
            header("Location: index.php?subject=" . $selected_subject); exit;
        }

        // ============= KREIRANJE NASTAVNIKA (MASTER ADMIN) =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_user'])) {
            $this->checkCsrf();
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $role = $_POST['role'];
            if (!empty($username) && !empty($password) && $role === 'admin') {
                if ($this->userModel->usernameExists($username)) {
                    $_SESSION['error_message'] = "Korisničko ime već postoji!";
                } else {
                    $current_user_id = (int)$_SESSION['user_id'];
                    if ($this->userModel->create($username, $password, $role, $current_user_id)) {
                        $_SESSION['success_message'] = "Nastavnik kreiran uspješno!";
                    } else {
                        $_SESSION['error_message'] = "Greška pri kreiranju: " . $conn->error;
                    }
                }
            } else {
                $_SESSION['error_message'] = "Na ovoj stranici je dozvoljeno samo kreiranje administratora.";
            }
            header("Location: index.php"); exit;
        }

        // ============= IZMJENA NASTAVNIKA (MASTER ADMIN) =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_admin'])) {
            $this->checkCsrf();
            $admin_id = (int)$_POST['admin_id'];
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            if (!empty($username)) {
                if ($this->userModel->usernameExists($username, $admin_id)) {
                    $_SESSION['error_message'] = "Korisničko ime već postoji!";
                } else {
                    if (!empty($password)) {
                        $this->userModel->updatePassword($admin_id, $password);
                    }
                    $_SESSION[$this->userModel->updateUsername($admin_id, $username) ? 'success_message' : 'error_message'] = "Administrator uspješno ažuriran!";
                }
            } else {
                $_SESSION['error_message'] = "Korisničko ime ne može biti prazno!";
            }
            header("Location: index.php"); exit;
        }

        // ============= BRISANJE NASTAVNIKA (MASTER ADMIN) =============
        if (isset($_GET['delete_admin'])) {
            $admin_id = (int)$_GET['delete_admin'];
            $current_user = (int)$_SESSION['user_id'];
            $user = $this->userModel->getById($admin_id);
            if ($user && $user['role'] === 'admin' && $admin_id !== $current_user) {
                if ($this->userModel->deleteAdminWithStudents($admin_id)) {
                    $_SESSION['success_message'] = "Administrator i svi njegovi učenici su obrisani!";
                } else {
                    $_SESSION['error_message'] = "Greška pri brisanju administratora!";
                }
            } else {
                $_SESSION['error_message'] = "Ne možete obrisati ovog administratora!";
            }
            header("Location: index.php"); exit;
        }

        // ============= SLANJE OBAVJEŠTENJA (MASTER ADMIN) =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_notification'])) {
            $this->checkCsrf();
            $title = trim($_POST['notification_title'] ?? '');
            $message = trim($_POST['notification_message']);
            $type = $_POST['notification_type'] ?? 'info';
            $recipient_id = !empty($_POST['recipient_id']) ? (int)$_POST['recipient_id'] : NULL;
            if (!in_array($type, ['info', 'warning', 'urgent'])) $type = 'info';
            if (!empty($message)) {
                $stmt = $conn->prepare("INSERT INTO notifications (title, message, type, recipient_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $title, $message, $type, $recipient_id);
                $stmt->execute();
                $_SESSION['success_message'] = $recipient_id ? "Obavještenje uspješno poslato administratoru!" : "Obavještenje uspješno poslato svim administratorima!";
            }
            header("Location: index.php"); exit;
        }

        // ============= BRISANJE OBAVJEŠTENJA (MASTER ADMIN) =============
        if (isset($_GET['delete_notification'])) {
            $notif_id = (int)$_GET['delete_notification'];
            $stmt = $conn->prepare("DELETE FROM notification_reads WHERE notification_id = ?");
            $stmt->bind_param("i", $notif_id); $stmt->execute();
            $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
            $stmt->bind_param("i", $notif_id);
            if ($stmt->execute()) $_SESSION['success_message'] = "Obavještenje uspješno obrisano za sve korisnike!";
            $redirect_url = "index.php" . ($selected_subject > 0 ? "?subject=" . $selected_subject : "");
            if (isset($_GET['open_history'])) {
                $redirect_url .= (strpos($redirect_url, '?') !== false ? "&" : "?") . "open_history=1";
            }
            header("Location: " . $redirect_url); exit;
        }

        // ============= AJAX: UČITAVANJE ISTORIJE OBAVJEŠTENJA =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['load_more_history'])) {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) exit(json_encode(['error' => 'CSRF Invalid']));
            $offset = (int)$_POST['offset'];
            $limit = 20;
            $notifs = [];
            $stmt = $conn->prepare("SELECT n.*, u.username as recipient_name FROM notifications n LEFT JOIN users u ON n.recipient_id = u.id WHERE n.recipient_id IS NULL OR u.role = 'admin' ORDER BY n.created_at DESC LIMIT ? OFFSET ?");
            if ($stmt) {
                $stmt->bind_param("ii", $limit, $offset);
                $stmt->execute();
                $res_notif = $stmt->get_result();
                while($row = $res_notif->fetch_assoc()) $notifs[] = $row;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['notifications' => $notifs], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // ============= AJAX: UČITAVANJE KORISNIKA =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['load_more_users'])) {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) exit(json_encode(['error' => 'CSRF Invalid']));
            $offset = (int)$_POST['offset'];
            $limit = 20;
            $users_data = [];
            $stmt = $conn->prepare("SELECT u.*, COALESCE(pa.username, 'Master Admin') as created_by FROM users u LEFT JOIN users pa ON u.parent_admin_id = pa.id ORDER BY u.role DESC, u.id DESC LIMIT ? OFFSET ?");
            if ($stmt) {
                $stmt->bind_param("ii", $limit, $offset);
                $stmt->execute();
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()) $users_data[] = $row;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['users' => $users_data], JSON_UNESCAPED_UNICODE);
            exit;
        }

        return false; // Nijedna akcija nije pokrenuta
    }

    /**
     * Kreira SQL uvjet za filtriranje po datumu.
     */
    private function getDateCondition($date_filter, $column = 'uploaded_at') {
        if ($date_filter === 'today') return " AND DATE($column) = CURDATE()";
        if ($date_filter === 'week') return " AND $column >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        if ($date_filter === 'month') return " AND $column >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        return "";
    }
}
