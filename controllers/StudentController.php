<?php
class StudentController {
    private $conn;
    private $userModel;
    private $subjectModel;
    private $studentWorkModel;

    public function __construct($conn) {
        $this->conn = $conn;
        require_once __DIR__ . '/../models/User.php';
        require_once __DIR__ . '/../models/Subject.php';
        require_once __DIR__ . '/../models/StudentWork.php';
        $this->userModel = new User($conn);
        $this->subjectModel = new Subject($conn);
        $this->studentWorkModel = new StudentWork($conn);
    }

    public function index() {
        $conn = $this->conn;

        // Postavi timezone
        date_default_timezone_set('Europe/Belgrade');

        // Osiguraj uploads folder
        $uploadsDir = __DIR__ . '/../uploads/radovi/';
        if (!is_dir($uploadsDir)) mkdir($uploadsDir, 0777, true);

        // CSRF zaštita
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $csrf_token = $_SESSION['csrf_token'];

        // Auth provjera
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?route=login");
            exit;
        }

        $is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
        $is_student = isset($_SESSION['role']) && $_SESSION['role'] === 'student';
        $is_master_admin = false;

        // Provjera da li je master admin (admin bez parent_admin_id)
        if ($is_admin) {
            if ($this->userModel->getById($_SESSION['user_id'])) {
                $is_master_admin = $this->userModel->isMasterAdmin($_SESSION['user_id']);
                if (!$is_master_admin) {
                    // Obični admin → preusmjeri na admin dashboard
                    $params = $_GET;
                    $params['route'] = 'admin';
                    $new_query = http_build_query($params);
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        header("Location: index.php?" . $new_query, true, 307);
                    } else {
                        header("Location: index.php?" . $new_query);
                    }
                    exit;
                }
            } else {
                session_destroy();
                header("Location: index.php?route=login");
                exit;
            }
        }

        $selected_subject = isset($_GET['subject']) ? (int)$_GET['subject'] : 0;
        $student_parent_admin_id = null;

        if ($is_student) {
            $student_parent_admin_id = $this->userModel->getStudentParentAdminId($_SESSION['user_id']);
        }

        // Provjera pristupa predmetu za učenika
        if ($is_student && $selected_subject > 0) {
            if (!$this->subjectModel->studentHasAccess($selected_subject, $_SESSION['user_id'], $student_parent_admin_id)) {
                $selected_subject = 0;
                $_SESSION['error_message'] = "Nemate pristup odabranom predmetu.";
            }
        }

        // ============= DELEGIRANJE MASTER ADMIN AKCIJA =============
        if ($is_master_admin) {
            require_once 'controllers/MasterAdminActionsController.php';
            $masterActions = new MasterAdminActionsController($conn, $selected_subject);
            $masterActions->handleRequest(); // exit se desi unutar ako je akcija obrađena
        }

        // ============= PREUZIMANJE RADA (učenik i admin) =============
        if (isset($_GET['download_work']) && $selected_subject > 0) {
            $work_id = (int)$_GET['download_work'];
            if ($is_student) {
                $work = $this->studentWorkModel->getStudentWorkById($work_id, $_SESSION['user_id'], $selected_subject);
            } else {
                $work = $this->studentWorkModel->getById($work_id);
                if ($work && $work['subject_id'] != $selected_subject) $work = null;
            }
            if (!$work) {
                $_SESSION['error_message'] = "Rad ne postoji ili nemate pristup.";
                header("Location: index.php?subject=" . $selected_subject); exit;
            }
            $filepath = $work['filepath'];
            $filename = $work['filename'];
            $fullPath = preg_match('/^[A-Za-z]:\\\\|^\//', $filepath) ? $filepath : __DIR__ . '/../' . $filepath;
            if (!file_exists($fullPath)) {
                $_SESSION['error_message'] = "Fajl ne postoji na serveru.";
                header("Location: index.php?subject=" . $selected_subject); exit;
            }
            while (ob_get_level()) ob_end_clean();
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($fullPath));
            header('Cache-Control: private, no-transform, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');
            readfile($fullPath);
            exit;
        }

        // ============= UPLOAD RADA UČENIKA =============
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_student_work']) && $selected_subject > 0 && $is_student) {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("CSRF token nije validan!");
            if (isset($_FILES['student_work_file']) && $_FILES['student_work_file']['error'] === 0) {
                $file_extension = strtolower(pathinfo($_FILES['student_work_file']['name'], PATHINFO_EXTENSION));
                $allowed = ['pdf','doc','docx','ppt','pptx','zip','rar','jpg','jpeg','png','txt','csv','xlsx','xls'];
                if (!in_array($file_extension, $allowed)) {
                    $_SESSION['error_message'] = "Nedozvoljen tip fajla!";
                    header("Location: index.php?subject=" . $selected_subject); exit;
                }
                if ($_FILES['student_work_file']['size'] > 10 * 1024 * 1024) {
                    $_SESSION['error_message'] = "Fajl je prevelik (max 10MB)!";
                    header("Location: index.php?subject=" . $selected_subject); exit;
                }
            $subject_name_val = $this->subjectModel->getSubjectNameWithAccessCheck($selected_subject, $_SESSION['user_id'], $student_parent_admin_id);
            if (!$subject_name_val) {
                    $_SESSION['error_message'] = "Nemate pristup ovom predmetu.";
                    header("Location: index.php"); exit;
                }
            $subject_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $subject_name_val);
                $workDir = __DIR__ . "/../uploads/radovi/" . $subject_name . "/";
                if (!is_dir($workDir)) mkdir($workDir, 0777, true);
                $user = preg_replace('/[^A-Za-z0-9_\-]/', '_', $_SESSION['username']);
                $filename = time() . "_" . $user . "_" . basename($_FILES['student_work_file']['name']);
                $targetPath = $workDir . $filename;
                if (move_uploaded_file($_FILES['student_work_file']['tmp_name'], $targetPath)) {
                    $filepath = "uploads/radovi/" . $subject_name . "/" . $filename;
                    $user_id = (int)$_SESSION['user_id'];
                echo $this->studentWorkModel->submitWork($selected_subject, $user_id, $filename, $filepath) ? "success" : "Greška pri spremanju u bazu.";
                } else {
                    echo "Greška pri uploadu rada!";
                }
            } else {
                echo isset($_FILES['student_work_file']) ? "Greška pri uploadu: " . $_FILES['student_work_file']['error'] : "Nema fajla!";
            }
            exit;
        }

        // ============= AJAX OBAVJEŠTENJA DELEGIRANA KONTROLERU =============
        require_once 'controllers/NotificationController.php';
        if ((new NotificationController($conn, (int)$_SESSION['user_id']))->handleAjax()) exit;

        // ============= UČITAVANJE RADOVA UČENIKA =============
        $student_works = null;
        $total_works_pages = 1;
        $current_page_works = 1;
        $works_per_page = 10;
        $date_filter = $_GET['date_filter'] ?? 'all';

        if ($selected_subject > 0) {
            $col_check = $conn->query("SHOW TABLES LIKE 'student_works'");
            if ($col_check->num_rows > 0) {
                if ($is_admin) {
                    $date_condition = "";
                    if ($date_filter === 'today') $date_condition = " AND DATE(sw.uploaded_at) = CURDATE()";
                    elseif ($date_filter === 'week') $date_condition = " AND sw.uploaded_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                    elseif ($date_filter === 'month') $date_condition = " AND sw.uploaded_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
                    $current_page_works = max(1, (int)($_GET['works_page'] ?? 1));
                    $offset = ($current_page_works - 1) * $works_per_page;
                $total_count = $this->studentWorkModel->countWorksBySubject($selected_subject, $date_filter);
                    $total_works_pages = max(1, ceil($total_count / $works_per_page));
                $student_works = $this->studentWorkModel->getWorksBySubjectPaginated($selected_subject, $date_filter, $works_per_page, $offset);
                }
            }
        }

        // ============= INICIJALIZACIJA OBAVJEŠTENJA =============
        $unread_count = 0;
        $recent_notifications = [];

        if (isset($_SESSION['user_id'])) {
            $current_user_id = (int)$_SESSION['user_id'];
            $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM notifications n LEFT JOIN notification_reads nr ON n.id = nr.notification_id AND nr.user_id = ? WHERE (n.recipient_id IS NULL OR n.recipient_id = ?) AND nr.id IS NULL");
            if ($stmt) {
                $stmt->bind_param("ii", $current_user_id, $current_user_id);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($res) $unread_count = $res->fetch_assoc()['cnt'];
            }
            $stmt = $conn->prepare("SELECT n.*, nr.id as is_read FROM notifications n LEFT JOIN notification_reads nr ON n.id = nr.notification_id AND nr.user_id = ? WHERE (n.recipient_id IS NULL OR n.recipient_id = ?) ORDER BY n.id DESC LIMIT 10");
            if ($stmt) {
                $stmt->bind_param("ii", $current_user_id, $current_user_id);
                $stmt->execute();
                $res_notif = $stmt->get_result();
                if ($res_notif) while($row = $res_notif->fetch_assoc()) $recent_notifications[] = $row;
            }
        }

        // ============= UČITAVANJE KORISNIKA (za master admin prikaz) =============
        $users = [];
        if ($is_admin) {
        $users = $this->userModel->getAllUsersWithCreators(20);
        }

        // ============= ISTORIJA OBAVJEŠTENJA (za master admin) =============
        $notification_history = null;
        $history_count = 0;
        if ($is_admin) {
            $stmt = $conn->prepare("SELECT n.*, u.username as recipient_name FROM notifications n LEFT JOIN users u ON n.recipient_id = u.id WHERE n.recipient_id IS NULL OR u.role = 'admin' ORDER BY n.created_at DESC LIMIT 20");
            $stmt->execute();
            $notification_history = $stmt->get_result();
            if ($notification_history) $history_count = $notification_history->num_rows;
        }

        // ============= UČITAVANJE PREDMETA =============
        if ($is_admin) {
            $stmt = $conn->prepare("SELECT u.username, s.* FROM subjects s LEFT JOIN users u ON s.admin_id = u.id ORDER BY s.name ASC");
            $stmt->execute();
            $subjects = $stmt->get_result();
        } else {
            $user_id = $_SESSION['user_id'];
            if (is_null($student_parent_admin_id)) {
                $stmt = $conn->prepare("SELECT s.* FROM subjects s JOIN user_subjects us ON s.id = us.subject_id WHERE us.user_id = ? ORDER BY s.name ASC");
                $stmt->bind_param("i", $user_id);
            } else {
                $stmt = $conn->prepare("SELECT s.* FROM subjects s JOIN user_subjects us ON s.id = us.subject_id WHERE us.user_id = ? AND s.admin_id = ? ORDER BY s.name ASC");
                $stmt->bind_param("ii", $user_id, $student_parent_admin_id);
            }
            $stmt->execute();
            $subjects = $stmt->get_result();
        }

        // ============= UČITAVANJE SEKCIJA, FAJLOVA, TESTOVA =============
        $sections = [];
        $files_by_section = [];
        $general_files = [];
        $tests_by_section = [];
        $general_tests = [];

        if ($selected_subject > 0) {
            if ($is_admin) {
                $stmt = $conn->prepare("SELECT * FROM sections WHERE subject_id=? ORDER BY display_order ASC, id ASC");
            } else {
                $stmt = $conn->prepare("SELECT * FROM sections WHERE subject_id=? AND hidden = 0 ORDER BY display_order ASC, id ASC");
            }
            $stmt->bind_param("i", $selected_subject);
            $stmt->execute();
            $sections_res = $stmt->get_result();
            while($row = $sections_res->fetch_assoc()) {
                $sections[$row['id']] = $row;
                $files_by_section[$row['id']] = [];
                $tests_by_section[$row['id']] = [];
            }
        }

        if ($selected_subject > 0) {
            if (is_null($student_parent_admin_id)) {
                $stmt = $conn->prepare("SELECT f.* FROM files f JOIN user_subjects us ON us.subject_id = f.subject_id WHERE us.user_id = ? AND f.subject_id = ? ORDER BY f.id ASC");
                $stmt->bind_param("ii", $_SESSION['user_id'], $selected_subject);
            } else {
                $stmt = $conn->prepare("SELECT f.* FROM files f JOIN user_subjects us ON us.subject_id = f.subject_id JOIN subjects s ON s.id = f.subject_id WHERE us.user_id = ? AND f.subject_id = ? AND s.admin_id = ? ORDER BY f.id ASC");
                $stmt->bind_param("iii", $_SESSION['user_id'], $selected_subject, $student_parent_admin_id);
            }
            $stmt->execute();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()) {
                if (!empty($row['section_id'])) {
                    if (isset($sections[$row['section_id']])) {
                        $files_by_section[$row['section_id']][] = $row;
                    }
                    // Ako je sekcija sakrivena (nije u $sections), fajl se ne prikazuje
                } else {
                    $general_files[] = $row;
                }
            }
        }

        if ($selected_subject > 0) {
            if ($is_admin) {
                $stmt = $conn->prepare("SELECT * FROM tests WHERE subject_id=? ORDER BY id ASC");
                $stmt->bind_param("i", $selected_subject);
                $stmt->execute();
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()) $general_tests[] = $row;
            } else {
                if (is_null($student_parent_admin_id)) {
                    $stmt = $conn->prepare("SELECT t.* FROM tests t JOIN user_subjects us ON us.subject_id = t.subject_id WHERE us.user_id = ? AND t.subject_id = ? AND t.hidden = 0 ORDER BY t.id ASC");
                    $stmt->bind_param("ii", $_SESSION['user_id'], $selected_subject);
                } else {
                    $stmt = $conn->prepare("SELECT t.* FROM tests t JOIN user_subjects us ON us.subject_id = t.subject_id JOIN subjects s ON s.id = t.subject_id WHERE us.user_id = ? AND t.subject_id = ? AND s.admin_id = ? AND t.hidden = 0 ORDER BY t.id ASC");
                    $stmt->bind_param("iii", $_SESSION['user_id'], $selected_subject, $student_parent_admin_id);
                }
                $stmt->execute();
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()) {
                    if (!empty($row['section_id']) && !isset($sections[$row['section_id']])) {
                        continue; // Preskoči testove u sakrivenim sekcijama
                    }
                    $general_tests[] = $row;
                }
            }
        }

        // ============= STATISTIKE (za master admin overview) =============
        $stats = ['admins' => 0, 'students' => 0, 'subjects' => 0, 'files' => 0, 'tests' => 0, 'works' => 0];
        $res = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='admin'"); if ($res) $stats['admins'] = (int)$res->fetch_assoc()['total'];
        $res = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='student'"); if ($res) $stats['students'] = (int)$res->fetch_assoc()['total'];
        $res = $conn->query("SELECT COUNT(*) AS total FROM subjects"); if ($res) $stats['subjects'] = (int)$res->fetch_assoc()['total'];
        $res = $conn->query("SELECT COUNT(*) AS total FROM files"); if ($res) $stats['files'] = (int)$res->fetch_assoc()['total'];
        $res = $conn->query("SELECT COUNT(*) AS total FROM tests"); if ($res) $stats['tests'] = (int)$res->fetch_assoc()['total'];
        $table_check = $conn->query("SHOW TABLES LIKE 'student_works'");
        if ($table_check && $table_check->num_rows > 0) { $res = $conn->query("SELECT COUNT(*) AS total FROM student_works"); if ($res) $stats['works'] = (int)$res->fetch_assoc()['total']; }

        // Pregled administratora (sa pretraživanjem)
        $admin_search = isset($_GET['admin_search']) ? trim($_GET['admin_search']) : '';
        $sql = "SELECT a.id, a.username, COUNT(DISTINCT u.id) AS student_count, COUNT(DISTINCT s.id) AS subject_count FROM users a LEFT JOIN users u ON u.parent_admin_id = a.id AND u.role = 'student' LEFT JOIN subjects s ON s.admin_id = a.id WHERE a.role='admin'";
        if (!empty($admin_search)) $sql .= " AND a.username LIKE ?";
        $sql .= " GROUP BY a.id, a.username ORDER BY a.id ASC";
        $stmt = $conn->prepare($sql);
        if (!empty($admin_search)) { $search_param = "%" . $admin_search . "%"; $stmt->bind_param("s", $search_param); }
        $stmt->execute();
        $admin_overview = $stmt->get_result();

        require 'views/student/dashboard.php';
    }
}