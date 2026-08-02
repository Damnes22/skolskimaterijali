<?php
class ViewTestResultsController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function handleRequest() {
        $conn = $this->conn;

        // MySQL session na CEST (+02:00) — MySQL vraca stringove vec u CEST formatu.
        // PHP formatBelgradeTime samo interpretira string kao +02:00, bez konverzije.
        $conn->query("SET time_zone = '+02:00'");

        // Auth
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?route=login');
            exit;
        }

        $current_admin_id = (int)$_SESSION['user_id'];

        // Provjera da li je master admin
        $is_master = false;
        $stmt = $conn->prepare("SELECT parent_admin_id FROM users WHERE id = ?");
        $stmt->bind_param("i", $current_admin_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        if ($res) $is_master = is_null($res['parent_admin_id']);

        // CSRF Token
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $csrf_token = $_SESSION['csrf_token'];

        if (isset($_GET['route']) && $_GET['route'] === 'delete_test_result') {
            $this->deleteResult($is_master, $current_admin_id);
            return;
        }
        if (isset($_GET['route']) && $_GET['route'] === 'update_answer_points') {
            $this->updatePoints();
            return;
        }

        $test_id    = isset($_GET['test_id'])    ? (int)$_GET['test_id']    : 0;
        $subject_id = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;
        $test_name  = $_GET['test_name'] ?? '';

        $back_url = $is_master
            ? "index.php?subject={$subject_id}"
            : "index.php?route=admin&subject={$subject_id}";

        if ($test_id <= 0 || $subject_id <= 0) {
            $_SESSION['error_message'] = "Neispravni parametri.";
            header("Location: {$back_url}");
            exit;
        }

        // Provjera pristupa predmetu
        if (!$is_master) {
            $stmt = $conn->prepare("SELECT id FROM subjects WHERE id = ? AND admin_id = ?");
            $stmt->bind_param("ii", $subject_id, $current_admin_id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows === 0) {
                $_SESSION['error_message'] = "Nemate pristup ovom predmetu.";
                header("Location: {$back_url}");
                exit;
            }
        }

        // Podaci o testu
        $stmt = $conn->prepare("SELECT t.filename, t.is_db_test, s.name AS subject_name FROM tests t JOIN subjects s ON t.subject_id = s.id WHERE t.id = ?");
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        $test = $stmt->get_result()->fetch_assoc();

        if (!$test) {
            $_SESSION['error_message'] = "Test nije pronađen.";
            header("Location: {$back_url}");
            exit;
        }

        // Svi rezultati za ovaj test
        $stmt = $conn->prepare("
            SELECT tr.id, tr.student_first_name, tr.student_last_name, tr.total_points,
                   tr.earned_points, tr.submitted_at, u.username, c.name AS class_name
            FROM test_results tr
            LEFT JOIN users u ON u.id = tr.student_id
            LEFT JOIN classes c ON c.id = u.class_id
            WHERE tr.test_id = ?
            ORDER BY tr.submitted_at DESC
        ");
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        $results_raw = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // --- AUTO-HEAL: Popravi netačne maksimalne bodove iz starih predaja (zbog eseja) ---
        $stmtMax = $conn->prepare("SELECT SUM(points) as real_total FROM test_questions WHERE test_id = ? AND type != 'explanation'");
        $stmtMax->bind_param("i", $test_id);
        $stmtMax->execute();
        $real_total_row = $stmtMax->get_result()->fetch_assoc();
        $real_total = $real_total_row ? (float)$real_total_row['real_total'] : 0;

        if ($real_total > 0) {
            foreach ($results_raw as &$r) {
                if (abs((float)$r['total_points'] - $real_total) > 0.01) {
                    $r['total_points'] = $real_total;
                    // Update u bazi u pozadini
                    $stmtUpd = $conn->prepare("UPDATE test_results SET total_points = ? WHERE id = ?");
                    $stmtUpd->bind_param("di", $real_total, $r['id']);
                    $stmtUpd->execute();
                }
            }
            unset($r);
        }

        // Svi odgovori za taj test — JOIN sa test_questions za max_points
        $stmt = $conn->prepare("
            SELECT tsa.result_id, tsa.question_numb, tsa.student_answer,
                   tsa.earned_points,
                   COALESCE(tq.points, 0) AS max_points
            FROM test_student_answers tsa
            LEFT JOIN test_questions tq
                   ON tq.test_id = tsa.test_id AND tq.numb = tsa.question_numb
            WHERE tsa.test_id = ?
            ORDER BY tsa.question_numb ASC
        ");
        if (!$stmt) {
            // Fallback ako JOIN ne radi — dohvati samo odgovore bez max_points
            $stmt = $conn->prepare("
                SELECT result_id, question_numb, student_answer, earned_points, earned_points AS max_points
                FROM test_student_answers
                WHERE test_id = ?
                ORDER BY question_numb ASC
            ");
        }
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        $answers_raw = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


        // Grupiši odgovore po result_id
        $answers_by_result = [];
        $max_q = 0;
        foreach ($answers_raw as $a) {
            $answers_by_result[$a['result_id']][$a['question_numb']] = $a;
            if ($a['question_numb'] > $max_q) $max_q = $a['question_numb'];
        }

        // ============= EXPORT U CSV (DETALJNO SA ODGOVORIMA) =============
        if (isset($_GET['export']) && $_GET['export'] === 'csv') {
            $filename = "rezultati_" . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $test_name ?: $test['filename']) . "_" . date('Ymd_Hi') . ".csv";
            
            while (ob_get_level()) ob_end_clean();
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
            header('Expires: 0');
            
            $output = fopen('php://output', 'w');
            fputs($output, "\xEF\xBB\xBF"); // UTF-8 BOM za naša slova
            
            $headers = ['Učenik', 'Odjeljenje', 'Vrijeme predaje', 'Osvojeni bodovi', 'Max bodovi', 'Procenat (%)'];
            for ($i = 1; $i <= $max_q; $i++) {
                $headers[] = "Odgovor " . $i;
                $headers[] = "Bodovi " . $i;
            }
            // Koristimo ';' umjesto zarez, kako bi regionalni Excel to odmah učitao u zasebne kolone
            fputcsv($output, $headers, ';');
            
            foreach ($results_raw as $r) {
                // Forsiramo float tip kako bi spriječili PHP 8 TypeError kod null vrijednosti
                $earned = (float)$r['earned_points'];
                $total = (float)$r['total_points'];
                $pct = $total > 0 ? round(($earned / $total) * 100, 1) : 0;
                
                $fullName = trim($r['student_first_name'] . ' ' . $r['student_last_name']);
                if (empty($fullName)) $fullName = $r['username'];
                
                $timeFormatted = $r['submitted_at'];
                if ($timeFormatted) {
                    try {
                        $dt = new DateTime($timeFormatted, new DateTimeZone('+02:00'));
                        $timeFormatted = $dt->format('d.m.Y. H:i');
                    } catch (Throwable $e) {}
                } else {
                    $timeFormatted = '—';
                }

                $row = [
                    $fullName,
                    $r['class_name'] ?? '—',
                    $timeFormatted,
                    number_format($earned, 1, ',', ''),
                    number_format($total, 1, ',', ''),
                    number_format($pct, 1, ',', '') . '%'
                ];

                for ($i = 1; $i <= $max_q; $i++) {
                    if (isset($answers_by_result[$r['id']][$i])) {
                        $ans = $answers_by_result[$r['id']][$i];
                        $rawAns = $ans['student_answer'] ?? '';
                        $decoded = json_decode($rawAns, true);
                        $displayAns = is_array($decoded) ? implode(', ', $decoded) : $rawAns;
                        
                        $row[] = $displayAns;
                        $row[] = number_format((float)$ans['earned_points'], 1, ',', '') . ' / ' . number_format((float)$ans['max_points'], 1, ',', '');
                    } else {
                        $row[] = 'Bez odgovora';
                        $row[] = '0,0 / 0,0';
                    }
                }
                fputcsv($output, $row, ';');
            }
            fclose($output);
            exit;
        }

        // Statistika
        $total_submissions = count($results_raw);
        $avg_score = 0;
        $highest_score = 0;
        $lowest_score = PHP_INT_MAX;
        foreach ($results_raw as $r) {
            $pct = $r['total_points'] > 0 ? round(($r['earned_points'] / $r['total_points']) * 100, 1) : 0;
            $avg_score += $pct;
            if ($pct > $highest_score)    $highest_score = $pct;
            if ($pct < $lowest_score)     $lowest_score  = $pct;
        }
        if ($total_submissions > 0) {
            $avg_score   = round($avg_score / $total_submissions, 1);
            if ($lowest_score === PHP_INT_MAX) $lowest_score = 0;
        } else {
            $lowest_score = 0;
        }

        $view_data = compact(
            'test', 'test_id', 'test_name', 'subject_id', 'back_url',
            'results_raw', 'answers_by_result', 'max_q',
            'total_submissions', 'avg_score', 'highest_score', 'lowest_score', 'csrf_token'
        );

        extract($view_data);
        require_once __DIR__ . '/../views/admin/view_test_results.php';
    }

    private function deleteResult($is_master, $current_admin_id) {
        $result_id = isset($_GET['result_id']) ? (int)$_GET['result_id'] : 0;
        $test_id = isset($_GET['test_id']) ? (int)$_GET['test_id'] : 0;
        $subject_id = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;

        // Sigurnosna provjera (da li admin ima pravo nad ovim predmetom)
        if (!$is_master) {
            $stmt = $this->conn->prepare("SELECT id FROM subjects WHERE id = ? AND admin_id = ?");
            $stmt->bind_param("ii", $subject_id, $current_admin_id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows === 0) {
                $_SESSION['error_message'] = "Nemate pristup brisanju ovog pokušaja.";
                header("Location: index.php?route=admin");
                exit;
            }
        }

        if ($result_id > 0) {
            // Brisanje vezanih odgovora za taj pokušaj
            $stmt = $this->conn->prepare("DELETE FROM test_student_answers WHERE result_id = ?");
            $stmt->bind_param("i", $result_id);
            $stmt->execute();
            
            // Brisanje glavnog pokušaja (rezultata)
            $stmt = $this->conn->prepare("DELETE FROM test_results WHERE id = ?");
            $stmt->bind_param("i", $result_id);
            $stmt->execute();
            
            $_SESSION['success_message'] = "Pokušaj uspješno obrisan!";
        }
        
        header("Location: index.php?route=view_test_results&test_id={$test_id}&subject_id={$subject_id}");
        exit;
    }

    private function updatePoints() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Nevažeća metoda.']);
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            echo json_encode(['success' => false, 'error' => 'CSRF token nije validan!']);
            exit;
        }
        
        $result_id = isset($_POST['result_id']) ? (int)$_POST['result_id'] : 0;
        $question_numb = isset($_POST['question_numb']) ? (int)$_POST['question_numb'] : 0;
        $points = isset($_POST['points']) ? (float)$_POST['points'] : 0;

        if ($result_id > 0 && $question_numb > 0) {
            // Ažuriraj bodove za taj specifičan odgovor
            $stmt = $this->conn->prepare("UPDATE test_student_answers SET earned_points = ? WHERE result_id = ? AND question_numb = ?");
            $stmt->bind_param("dii", $points, $result_id, $question_numb);
            if ($stmt->execute()) {
                // Preračunaj ukupne bodove za ovog učenika na ovom testu
                $stmtSum = $this->conn->prepare("SELECT SUM(earned_points) as total_earned FROM test_student_answers WHERE result_id = ?");
                $stmtSum->bind_param("i", $result_id);
                $stmtSum->execute();
                $sumRes = $stmtSum->get_result()->fetch_assoc();
                $total_earned = (float)$sumRes['total_earned'];

                // Preračunaj prave maksimalne bodove testa (samo-izlječenje starih netačnih predaja)
                $stmtMax = $this->conn->prepare("SELECT SUM(points) as real_total FROM test_questions WHERE test_id = (SELECT test_id FROM test_results WHERE id = ?) AND type != 'explanation'");
                $stmtMax->bind_param("i", $result_id);
                $stmtMax->execute();
                $real_total = (float)$stmtMax->get_result()->fetch_assoc()['real_total'];

                // Ažuriraj glavni rezultat u tabeli test_results (osvojene i maksimalne bodove)
                $stmtUpd = $this->conn->prepare("UPDATE test_results SET earned_points = ?, total_points = ? WHERE id = ?");
                $stmtUpd->bind_param("ddi", $total_earned, $real_total, $result_id);
                $stmtUpd->execute();

                echo json_encode(['success' => true]);
                exit;
            }
        }
        echo json_encode(['success' => false]);
        exit;
    }
}
