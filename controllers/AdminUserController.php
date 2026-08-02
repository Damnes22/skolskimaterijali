<?php
class AdminUserController {
    private $conn;
    private $current_admin_id;

    public function __construct($conn, $current_admin_id) {
        $this->conn = $conn;
        $this->current_admin_id = $current_admin_id;
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_user'])) {
            $this->createUser();
            return true;
        }
        if (isset($_GET['delete_user'])) {
            $this->deleteUser();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user_id'])) {
            $this->editUser();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
            $this->addClass();
            return true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_class'])) {
            $this->editClass();
            return true;
        }
        if (isset($_GET['delete_class'])) {
            $this->deleteClass();
            return true;
        }
        return false;
    }

    private function checkCsrf() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token nije validan!");
        }
    }

    private function createUser() {
        $this->checkCsrf();
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $role = $_POST['role'];
        $class_id = !empty($_POST['class_id']) ? (int)$_POST['class_id'] : NULL;
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($role === 'admin') {
            $_SESSION['error_message'] = 'Nemate dozvolu da kreirate nove administratore!';
            if ($isAjax) { 
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['success' => false, 'error' => 'Nemate dozvolu da kreirate nove administratore!'], JSON_UNESCAPED_UNICODE); 
                exit; 
            }
            header('Location: index.php?route=admin'); exit;
        }

        if (!empty($username) && !empty($password) && in_array($role, ['student'])) {
            $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                // ── Korisnik već postoji ──────────────────────────────────────────
                $_SESSION['error_message'] = 'Korisničko ime već postoji!';
                if ($isAjax) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['success' => false, 'error' => "Korisničko ime \"" . htmlspecialchars($username) . "\" već postoji! Odaberite drugo ime."], JSON_UNESCAPED_UNICODE);
                    exit;
                }
            } else {
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->conn->prepare("INSERT INTO users(username,password,role,parent_admin_id,class_id) VALUES(?,?,?,?,?)");
                $stmt->bind_param("sssii", $username, $hash_pass, $role, $this->current_admin_id, $class_id);
                if ($stmt->execute()) {
                    $new_user_id = $stmt->insert_id;
                    if ($role === 'student' && !empty($_POST['user_subjects'])) {
                        $stmt2 = $this->conn->prepare("INSERT INTO user_subjects(user_id,subject_id) VALUES(?,?)");
                        foreach ($_POST['user_subjects'] as $sub_id) {
                            $sub_id = (int)$sub_id;
                            $stmt2->bind_param("ii", $new_user_id, $sub_id);
                            $stmt2->execute();
                        }
                    }
                    $_SESSION['success_message'] = 'Učenik kreiran uspješno!';
                    if ($isAjax) {
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode(['success' => true, 'message' => 'Učenik kreiran uspješno!'], JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                } else {
                    $_SESSION['error_message'] = 'Greška pri kreiranju učenika!';
                    if ($isAjax) {
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode(['success' => false, 'error' => 'Greška pri kreiranju učenika!'], JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                }
            }
        } else {
            $_SESSION['error_message'] = 'Popuni sva polja ispravno!';
            if ($isAjax) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['success' => false, 'error' => 'Popuni sva polja ispravno!'], JSON_UNESCAPED_UNICODE);
                exit;
            }
        }
        header('Location: index.php?route=admin');
        exit;
    }

    private function deleteUser() {
        $uid = (int)$_GET['delete_user'];
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE id = ? AND parent_admin_id = ?");
        $stmt->bind_param("ii", $uid, $this->current_admin_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows === 0) {
            $_SESSION['error_message'] = "Korisnik ne postoji ili nemate pristup!";
            header("Location: index.php?route=admin");
            exit;
        }
        try {
            $stmt = $this->conn->prepare("DELETE FROM user_subjects WHERE user_id=?");
            $stmt->bind_param("i", $uid);
            $stmt->execute();
            
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
            $stmt->bind_param("i", $uid);
            $stmt->execute();
            $_SESSION['success_message'] = "Korisnik uspješno obrisan!";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Greška pri brisanju učenika!";
        }
        header("Location: index.php?route=admin");
        exit;
    }

    private function editUser() {
        $this->checkCsrf();
        $edit_id = (int)$_POST['edit_user_id'];
        $edit_username = trim($_POST['edit_username']);
        $edit_role = $_POST['edit_role'];
        $edit_class_id = !empty($_POST['edit_class_id']) ? (int)$_POST['edit_class_id'] : NULL;
        
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE id = ? AND parent_admin_id = ?");
        $stmt->bind_param("ii", $edit_id, $this->current_admin_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows === 0) {
            $_SESSION['error_message'] = "Korisnik ne postoji ili nemate pristup!";
            header("Location: index.php?route=admin");
            exit;
        }
        
        try {
            if (!empty($edit_username) && in_array($edit_role, ['student'])) {
                if (!empty($_POST['edit_password'])) {
                    $edit_password = password_hash($_POST['edit_password'], PASSWORD_DEFAULT);
                    $stmt = $this->conn->prepare("UPDATE users SET username=?, password=?, class_id=? WHERE id=?");
                    $stmt->bind_param("ssii", $edit_username, $edit_password, $edit_class_id, $edit_id);
                } else {
                    $stmt = $this->conn->prepare("UPDATE users SET username=?, class_id=? WHERE id=?");
                    $stmt->bind_param("sii", $edit_username, $edit_class_id, $edit_id);
                }
                
                if ($stmt->execute()) {
                    $stmt = $this->conn->prepare("DELETE FROM user_subjects WHERE user_id=?");
                    $stmt->bind_param("i", $edit_id);
                    $stmt->execute();
                    
                    if ($edit_role === 'student' && !empty($_POST['edit_user_subjects'])) {
                        $stmt = $this->conn->prepare("INSERT INTO user_subjects(user_id,subject_id) VALUES(?,?)");
                        foreach ($_POST['edit_user_subjects'] as $sub_id) {
                            $sub_id = (int)$sub_id;
                            $stmt->bind_param("ii", $edit_id, $sub_id);
                            $stmt->execute();
                        }
                    }
                    $_SESSION['success_message'] = "Korisnik ažuriran uspješno!";
                } else {
                    $_SESSION['error_message'] = "Greška pri ažuriranju!";
                }
            } else {
                $_SESSION['error_message'] = "Popuni sva polja ispravno!";
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Došlo je do greške!";
        }
        $_SESSION['reopen_manage_users'] = true;
        header("Location: index.php?route=admin");
        exit;
    }

    private function addClass() {
        $this->checkCsrf();
        $name = trim($_POST['class_name']);
        if (!empty($name)) {
            $stmt = $this->conn->prepare("INSERT INTO classes (name, admin_id) VALUES (?, ?)");
            $stmt->bind_param("si", $name, $this->current_admin_id);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Odjeljenje uspješno dodato!";
            } else {
                $_SESSION['error_message'] = "Greška pri dodavanju odjeljenja!";
            }
        } else {
            $_SESSION['error_message'] = "Naziv odjeljenja ne može biti prazan!";
        }
        header("Location: index.php?route=admin");
        exit;
    }

    private function editClass() {
        $this->checkCsrf();
        $class_id = (int)$_POST['class_id'];
        $new_name = trim($_POST['new_class_name']);
        if (!empty($new_name) && $class_id > 0) {
            $stmt = $this->conn->prepare("UPDATE classes SET name = ? WHERE id = ? AND admin_id = ?");
            $stmt->bind_param("sii", $new_name, $class_id, $this->current_admin_id);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Odjeljenje uspješno preimenovano!";
            } else {
                $_SESSION['error_message'] = "Greška pri preimenovanju odjeljenja!";
            }
        } else {
            $_SESSION['error_message'] = "Naziv odjeljenja ne može biti prazan!";
        }
        header("Location: index.php?route=admin");
        exit;
    }

    private function deleteClass() {
        $class_id = (int)$_GET['delete_class'];
        $stmt = $this->conn->prepare("DELETE FROM classes WHERE id = ? AND admin_id = ?");
        $stmt->bind_param("ii", $class_id, $this->current_admin_id);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Odjeljenje uspješno obrisano!";
        } else {
            $_SESSION['error_message'] = "Greška pri brisanju odjeljenja!";
        }
        header("Location: index.php?route=admin");
        exit;
    }
}
