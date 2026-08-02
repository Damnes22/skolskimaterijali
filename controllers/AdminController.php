<?php
class AdminController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function index() {
        $conn = $this->conn;
        



// Postavi timezone na Belgrade
date_default_timezone_set('Europe/Belgrade');

// Sinhronizuj MySQL vremensku zonu sa PHP-om
$conn->query("SET time_zone = '" . date('P') . "'");

// Osiguraj da uploads folder postoji
$uploadsDir = __DIR__ . '/../uploads/radovi/';
if (!is_dir($uploadsDir)) {
  mkdir($uploadsDir, 0777, true);
}

// CSRF zaštita
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?route=login");
    exit;
}

// Provjera uloga - samo admini mogu pristupiti
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$current_admin_id = (int)$_SESSION['user_id'];

// Provjera da li je master admin (nema parent_admin_id)
$is_master = false;
$stmt = $conn->prepare("SELECT parent_admin_id FROM users WHERE id = ? AND role = 'admin'");
$stmt->bind_param("i", $current_admin_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $is_master = is_null($row['parent_admin_id']);
}

// Ako je master admin, preusmjeri na index.php gdje je njegov pravi dashboard
if ($is_master) {
    header("Location: index.php");
    exit;
}

// Odabrani predmet
$selected_subject = isset($_GET['subject']) ? (int)$_GET['subject'] : 0;

require_once 'controllers/NotificationController.php';
if ((new NotificationController($conn, $current_admin_id))->handleAjax()) exit;

// ============= SLANJE OBAVJEŠTENJA UČENICIMA =============
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_notification'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("CSRF token nije validan!");
    
    $title = trim($_POST['notification_title'] ?? '');
    $message = trim($_POST['notification_message']);
    $type = $_POST['notification_type'] ?? 'info';
    $recipient_id = !empty($_POST['recipient_id']) ? (int)$_POST['recipient_id'] : NULL;
    $class_id_filter = !empty($_POST['class_id']) ? (int)$_POST['class_id'] : NULL;

    if (!in_array($type, ['info', 'warning', 'urgent'])) $type = 'info';

    if (!empty($message)) {
        if ($recipient_id) {
            // Slanje jednom učeniku
            $check = $conn->prepare("SELECT id FROM users WHERE id = ? AND parent_admin_id = ? AND role = 'student'");
            $check->bind_param("ii", $recipient_id, $current_admin_id);
            $check->execute();
            $check_res = $check->get_result();
            if ($check_res && $check_res->num_rows > 0) {
                $stmt = $conn->prepare("INSERT INTO notifications (title, message, type, recipient_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $title, $message, $type, $recipient_id);
                $stmt->execute();
                $_SESSION['success_message'] = "Obavještenje uspješno poslato učeniku!";
            } else {
                $_SESSION['error_message'] = "Nemate pristup ovom učeniku.";
            }
        } elseif ($class_id_filter) {
            // Slanje učenicima odabranog odjeljenja
            $stmt_students = $conn->prepare("
                SELECT u.id FROM users u
                JOIN classes c ON u.class_id = c.id
                WHERE u.parent_admin_id = ? AND u.role = 'student' AND c.id = ? AND c.admin_id = ?
            ");
            $stmt_students->bind_param("iii", $current_admin_id, $class_id_filter, $current_admin_id);
            $stmt_students->execute();
            $res_students = $stmt_students->get_result();
            if ($res_students && $res_students->num_rows > 0) {
                $stmt_insert = $conn->prepare("INSERT INTO notifications (title, message, type, recipient_id) VALUES (?, ?, ?, ?)");
                while ($row = $res_students->fetch_assoc()) {
                    $student_id = $row['id'];
                    $stmt_insert->bind_param("sssi", $title, $message, $type, $student_id);
                    $stmt_insert->execute();
                }
                $_SESSION['success_message'] = "Obavještenje uspješno poslato učenicima odabranog odjeljenja!";
            } else {
                $_SESSION['error_message'] = "Nema učenika u odabranom odjeljenju.";
            }
        } else {
            // Slanje svim učenicima ovog nastavnika
            $stmt_students = $conn->prepare("SELECT id FROM users WHERE parent_admin_id = ? AND role = 'student'");
            $stmt_students->bind_param("i", $current_admin_id);
            $stmt_students->execute();
            $res_students = $stmt_students->get_result();
            if ($res_students && $res_students->num_rows > 0) {
                $stmt_insert = $conn->prepare("INSERT INTO notifications (title, message, type, recipient_id) VALUES (?, ?, ?, ?)");
                while ($row = $res_students->fetch_assoc()) {
                    $student_id = $row['id'];
                    $stmt_insert->bind_param("sssi", $title, $message, $type, $student_id);
                    $stmt_insert->execute();
                }
                $_SESSION['success_message'] = "Obavještenje uspješno poslato svim vašim učenicima!";
            } else {
                $_SESSION['error_message'] = "Nemate učenika kojima biste poslali obavještenje.";
            }
        }
    } else {
        $_SESSION['error_message'] = "Tekst obavještenja ne može biti prazan.";
    }
    header("Location: index.php?route=admin" . ($selected_subject > 0 ? "&subject=" . $selected_subject : ""));
    exit;
}

// ============= BRISANJE OBAVJEŠTENJA =============
if (isset($_GET['delete_notification'])) {
    $notif_id = (int)$_GET['delete_notification'];
    $stmt = $conn->prepare("SELECT n.id FROM notifications n JOIN users u ON n.recipient_id = u.id WHERE n.id = ? AND u.parent_admin_id = ?");
    $stmt->bind_param("ii", $notif_id, $current_admin_id);
    $stmt->execute();
    $notif_res = $stmt->get_result();
    if ($notif_res && $notif_res->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM notification_reads WHERE notification_id = ?");
        $stmt->bind_param("i", $notif_id);
        $stmt->execute();
        
        $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
        $stmt->bind_param("i", $notif_id);
        if ($stmt->execute()) $_SESSION['success_message'] = "Obavještenje uspješno obrisano!";
    } else {
        $_SESSION['error_message'] = "Nemate pristup brisanju ovog obavještenja!";
    }
        $redirect_url = "index.php?route=admin" . ($selected_subject > 0 ? "&subject=" . $selected_subject : "");
    if (isset($_GET['open_history'])) {
            $redirect_url .= "&open_history=1";
    }
    header("Location: " . $redirect_url);
    exit;
}

// ============= AJAX UČITAVANJE ISTORIJE OBAVJEŠTENJA =============
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['load_more_history'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) exit(json_encode(['error' => 'CSRF Invalid']));
    $offset = (int)$_POST['offset'];
    $limit = 20;
    $notifs = [];
    $stmt = $conn->prepare("SELECT n.*, u.username as recipient_name FROM notifications n JOIN users u ON n.recipient_id = u.id WHERE u.parent_admin_id = ? ORDER BY n.created_at DESC LIMIT ? OFFSET ?");
    if ($stmt) {
        $stmt->bind_param("iii", $current_admin_id, $limit, $offset);
        $stmt->execute();
        $res_notif = $stmt->get_result();
        if ($res_notif) {
            while($row = $res_notif->fetch_assoc()) $notifs[] = $row;
        }
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['notifications' => $notifs], JSON_UNESCAPED_UNICODE);
    exit;
}

// ============= DELEGIRANJE POD-KONTROLERIMA =============
require_once 'controllers/AdminSubjectController.php';
if ((new AdminSubjectController($conn, $current_admin_id, $selected_subject))->handleRequest()) exit;

require_once 'controllers/AdminFileController.php';
if ((new AdminFileController($conn, $current_admin_id, $selected_subject))->handleRequest()) exit;

require_once 'controllers/AdminTestController.php';
if ((new AdminTestController($conn, $current_admin_id, $selected_subject))->handleRequest()) exit;

require_once 'controllers/AdminUserController.php';
if ((new AdminUserController($conn, $current_admin_id))->handleRequest()) exit;

// ============= UČITAVANJE PODATAKA =============
$users = [];
$stmt = $conn->prepare("
    SELECT u.*, c.name as class_name 
    FROM users u 
    LEFT JOIN classes c ON u.class_id = c.id 
    WHERE u.parent_admin_id = ? AND u.role = 'student' 
    ORDER BY u.username ASC
");
$stmt->bind_param("i", $current_admin_id);
$stmt->execute();
$users = $stmt->get_result();

// Učitavanje odjeljenja
$classes = null;
$stmt = $conn->prepare("SELECT * FROM classes WHERE admin_id = ? ORDER BY name ASC");
$stmt->bind_param("i", $current_admin_id);
$stmt->execute();
$classes = $stmt->get_result();

// Učitavanje predmeta
$stmt = $conn->prepare("SELECT * FROM subjects WHERE admin_id = ? ORDER BY name ASC");
$stmt->bind_param("i", $current_admin_id);
$stmt->execute();
$subjects = $stmt->get_result();

// Učitavanje fajlova
$sections = [];
$files_by_section = [];
$general_files = [];
$tests_by_section = [];
$general_tests = [];

if ($selected_subject > 0) {
    // Provjera vlasništva nad predmetom prije učitavanja sadržaja
    $stmt_check = $conn->prepare("SELECT id FROM subjects WHERE id=? AND admin_id=?");
    $stmt_check->bind_param("ii", $selected_subject, $current_admin_id);
    $stmt_check->execute();
    $check_res = $stmt_check->get_result();
    if (!$check_res || $check_res->num_rows === 0) {
        $selected_subject = 0;
    }
}

if ($selected_subject > 0) {
    // Sections
    $stmt = $conn->prepare("SELECT * FROM sections WHERE subject_id=? ORDER BY display_order ASC, id ASC");
    $stmt->bind_param("i", $selected_subject);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_assoc()) {
        $sections[$row['id']] = $row;
        $files_by_section[$row['id']] = [];
        $tests_by_section[$row['id']] = [];
    }

    // Files
    $stmt = $conn->prepare("SELECT * FROM files WHERE subject_id=? ORDER BY id ASC");
    $stmt->bind_param("i", $selected_subject);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_assoc()) {
        if ($row['section_id'] && isset($sections[$row['section_id']])) {
            $files_by_section[$row['section_id']][] = $row;
        } else {
            $general_files[] = $row;
        }
    }
    
    // Tests
    $stmt = $conn->prepare("SELECT * FROM tests WHERE subject_id=? ORDER BY id ASC");
    $stmt->bind_param("i", $selected_subject);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_assoc()) {
        $general_tests[] = $row;
    }
}

// Učitavanje istorije obavještenja
$notification_history = null;
$history_count = 0;
$stmt_hist = $conn->prepare("
    SELECT n.*, u.username as recipient_name 
    FROM notifications n 
    JOIN users u ON n.recipient_id = u.id 
    WHERE u.parent_admin_id = ?
    ORDER BY n.created_at DESC 
    LIMIT 20
");
$stmt_hist->bind_param("i", $current_admin_id);
$stmt_hist->execute();
$notification_history = $stmt_hist->get_result();
if($notification_history) $history_count = $notification_history->num_rows;

// Dohvati ukupan broj nepročitanih obavještenja
$unread_count = 0;
$stmt = $conn->prepare("
    SELECT COUNT(*) as cnt 
    FROM notifications n
    LEFT JOIN notification_reads nr ON n.id = nr.notification_id AND nr.user_id = ?
    WHERE (n.recipient_id IS NULL OR n.recipient_id = ?)
      AND nr.id IS NULL
");
if ($stmt) {
    $stmt->bind_param("ii", $current_admin_id, $current_admin_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res) $unread_count = $res->fetch_assoc()['cnt'];
}

// Dohvati obavještenja za prikaz u padajućem meniju (sa limitom za učitaj još)
$recent_notifications = [];
$stmt = $conn->prepare("
    SELECT n.*, nr.id as is_read 
    FROM notifications n
    LEFT JOIN notification_reads nr ON n.id = nr.notification_id AND nr.user_id = ?
    WHERE (n.recipient_id IS NULL OR n.recipient_id = ?)
    ORDER BY n.id DESC
    LIMIT 10
");
if ($stmt) {
    $stmt->bind_param("ii", $current_admin_id, $current_admin_id);
    $stmt->execute();
    $res_notif = $stmt->get_result();
    if ($res_notif) {
        while($row = $res_notif->fetch_assoc()) {
            $recent_notifications[] = $row;
        }
    }
}

// Učitavanje učeničkih radova sa paginacijom
$student_works = null;
$total_works_pages = 1;
$current_page_works = 1;
$works_per_page = 10;
$date_filter = isset($_GET['date_filter']) ? $_GET['date_filter'] : 'all';

if ($selected_subject > 0) {
    $col_check = $conn->query("SHOW TABLES LIKE 'student_works'");
    if ($col_check->num_rows > 0) {
        $date_condition = "";
        if ($date_filter === 'today') {
            $date_condition = " AND DATE(sw.uploaded_at) = CURDATE()";
        } elseif ($date_filter === 'week') {
            $date_condition = " AND sw.uploaded_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        } elseif ($date_filter === 'month') {
            $date_condition = " AND sw.uploaded_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        }
        
        // Paginacija
        $current_page_works = isset($_GET['works_page']) ? (int)$_GET['works_page'] : 1;
        if ($current_page_works < 1) $current_page_works = 1;
        $offset = ($current_page_works - 1) * $works_per_page;
        
        // Ukupan broj radova za paginaciju
        $count_stmt = $conn->prepare("
            SELECT COUNT(*) as total 
            FROM student_works sw 
            WHERE sw.subject_id = ?" . $date_condition
        );
        $count_stmt->bind_param("i", $selected_subject);
        $count_stmt->execute();
        $total_count = $count_stmt->get_result()->fetch_assoc()['total'];
        $total_works_pages = ceil($total_count / $works_per_page);
        
        // Učitavanje radova sa paginacijom
        $stmt = $conn->prepare("
            SELECT sw.*, u.username 
            FROM student_works sw 
            LEFT JOIN users u ON sw.user_id = u.id 
            WHERE sw.subject_id = ?" . $date_condition . " 
            ORDER BY sw.uploaded_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->bind_param("iii", $selected_subject, $works_per_page, $offset);
        $stmt->execute();
        $student_works = $stmt->get_result();
    }
}

        require 'views/admin/dashboard.php';
    }
}