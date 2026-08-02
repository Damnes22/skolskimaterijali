<?php
class NotificationController {
    private $conn;
    private $current_user_id;

    public function __construct($conn, $current_user_id) {
        $this->conn = $conn;
        $this->current_user_id = $current_user_id;
    }

    public function handleAjax() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return false;

        if (isset($_POST['mark_notification_read'])) {
            $this->markNotificationRead();
            return true;
        }
        if (isset($_POST['mark_all_notifications_read'])) {
            $this->markAllNotificationsRead();
            return true;
        }
        if (isset($_POST['load_more_notifications'])) {
            $this->loadMoreNotifications();
            return true;
        }

        return false;
    }

    private function checkCsrf($isJson = false) {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            if ($isJson) exit(json_encode(['error' => 'CSRF Invalid']));
            exit("CSRF Invalid");
        }
    }

    private function markNotificationRead() {
        $this->checkCsrf();
        $notif_id = (int)$_POST['mark_notification_read'];
        $stmt = $this->conn->prepare("INSERT IGNORE INTO notification_reads (user_id, notification_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $this->current_user_id, $notif_id);
        $stmt->execute();
        exit('success');
    }

    private function markAllNotificationsRead() {
        $this->checkCsrf();
        $stmt = $this->conn->prepare("INSERT IGNORE INTO notification_reads (user_id, notification_id) SELECT ?, n.id FROM notifications n WHERE (n.recipient_id IS NULL OR n.recipient_id = ?)");
        $stmt->bind_param("ii", $this->current_user_id, $this->current_user_id);
        $stmt->execute();
        exit('success');
    }

    private function loadMoreNotifications() {
        $this->checkCsrf(true);
        $offset = (int)$_POST['offset'];
        $limit = 10;
        $notifs = [];
        $stmt = $this->conn->prepare("SELECT n.*, nr.id as is_read FROM notifications n LEFT JOIN notification_reads nr ON n.id = nr.notification_id AND nr.user_id = ? WHERE (n.recipient_id IS NULL OR n.recipient_id = ?) ORDER BY n.id DESC LIMIT ? OFFSET ?");
        if ($stmt) {
            $stmt->bind_param("iiii", $this->current_user_id, $this->current_user_id, $limit, $offset);
            $stmt->execute();
            $res_notif = $stmt->get_result();
            while ($row = $res_notif->fetch_assoc()) $notifs[] = $row;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['notifications' => $notifs], JSON_UNESCAPED_UNICODE);
        exit;
    }
}