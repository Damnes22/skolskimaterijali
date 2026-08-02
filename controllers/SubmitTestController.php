<?php
class SubmitTestController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function handleRequest() {
        // Čistimo izlazni bafer kako bismo spriječili da bilo kakav HTML ili razmaci prekinu JSON
        while (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: application/json; charset=utf-8');
        $conn = $this->conn;

        // Postavi MySQL session na UTC — NOW() će upisati UTC timestamp
        // bez obzira na timezone InfinityFree servera (US Eastern).
        $conn->query("SET time_zone = '+00:00'");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method'], JSON_UNESCAPED_UNICODE);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON'], JSON_UNESCAPED_UNICODE);
    exit;
}

if (isset($input['is_db_test']) && $input['is_db_test'] == 1) {
    // Spremanje u bazu za DB testove
    $test_id = (int)$input['test_id'];
    $ime = $input['ime'] ?? 'unknown';
    $prezime = $input['prezime'] ?? 'unknown';
    $endedByLeave = !empty($input['endedByLeave']) ? 1 : 0;
    $totalPts = (float)($input['totalPts'] ?? 0);
    $earnedPts = (float)($input['earnedPts'] ?? 0);
    
    // Provjeri postoji li vec prijava
    $stmt = $conn->prepare("SELECT id FROM test_results WHERE test_id = ? AND student_first_name = ? AND student_last_name = ?");
    $stmt->bind_param("iss", $test_id, $ime, $prezime);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Već ste predali rad za ovaj test! Ponovno slanje nije dozvoljeno.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    $stmtIns = $conn->prepare("INSERT INTO test_results (test_id, student_first_name, student_last_name, total_points, earned_points, automatically_submitted, submitted_at) VALUES (?, ?, ?, ?, ?, ?, UTC_TIMESTAMP())");
    $stmtIns->bind_param("issddi", $test_id, $ime, $prezime, $totalPts, $earnedPts, $endedByLeave);
    
    if ($stmtIns->execute()) {
        $result_id = $conn->insert_id;
        
        $answers = $input['answers'] ?? [];
        $stmtAns = $conn->prepare("INSERT INTO test_student_answers (result_id, test_id, question_numb, student_answer, is_correct, earned_points) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($answers as $ans) {
            $is_correct = !empty($ans['isCorrect']) ? 1 : 0;
            $pts = (float)($ans['points'] ?? 1);
            if (isset($ans['earnedPoints'])) {
                $earnedPtsForQ = (float)$ans['earnedPoints'];
            } else {
                $earnedPtsForQ = $is_correct ? $pts : 0;
            }
            
            $stmtAns->bind_param("iiisid", $result_id, $test_id, $ans['numb'], $ans['answer'], $is_correct, $earnedPtsForQ);
            $stmtAns->execute();
        }
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Greška pri upisu u bazu podataka.'], JSON_UNESCAPED_UNICODE);
    }
    exit;
}

// Fallback logic for legacy HTML JSON saving
$test_name = $input['test_name'] ?? '';
if (empty($test_name)) {
    echo json_encode(['success' => false, 'error' => 'Missing test_name'], JSON_UNESCAPED_UNICODE);
    exit;
}

// Sanitize test name
$test_name = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $test_name);

$answersDir = __DIR__ . '/../uploads/answers/' . $test_name . '/';
if (!is_dir($answersDir)) {
    mkdir($answersDir, 0777, true);
}

// Sanitizacija imena i prezimena
$imeRaw = $input['ime'] ?? 'unknown';
$prezimeRaw = $input['prezime'] ?? 'unknown';
$imeSafe = preg_replace('/[^a-zA-Z0-9]/', '', $imeRaw);
$prezimeSafe = preg_replace('/[^a-zA-Z0-9]/', '', $prezimeRaw);

// === ZAŠTITA OD ZLOUPOTREBE ===
$pattern = $answersDir . '*_' . $imeSafe . '_' . $prezimeSafe . '.json';
$existing_files = glob($pattern);

if (!empty($existing_files)) {
    echo json_encode(['success' => false, 'error' => 'Već ste predali rad za ovaj test! Ponovno slanje nije dozvoljeno.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$filename = time() . '_' . $imeSafe . '_' . $prezimeSafe . '.json';
$filepath = $answersDir . $filename;

        if (file_put_contents($filepath, json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to save file'], JSON_UNESCAPED_UNICODE);
        }
    }
}