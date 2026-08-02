<?php
class DownloadTestAnswersController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function handleRequest() {
        ob_start();
        $conn = $this->conn;

        // MySQL session na CEST (+02:00) — isti pristup kao u ViewTestResultsController
        date_default_timezone_set('UTC');
        $conn->query("SET time_zone = '+02:00'");

        // Helper: MySQL vraca CEST string, samo parsiramo i formatiramo
        $toBelgrade = function(?string $ts): string {
            if (empty($ts) || $ts === '0000-00-00 00:00:00') return '';
            try {
                $dt = new DateTime($ts, new DateTimeZone('+02:00'));
                return $dt->format('d.m.Y. H:i');
            } catch (Exception $e) {
                return $ts;
            }
        };

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            die("Access denied");
        }

        $current_admin_id = (int)$_SESSION['user_id'];

// Provjera da li je master admin
$is_master = false;
$stmt = $conn->prepare("SELECT parent_admin_id FROM users WHERE id = ?");
$stmt->bind_param("i", $current_admin_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $is_master = is_null($row['parent_admin_id']);
}

// Odredi gdje preusmjeriti u slučaju greške
$redirect_url = $is_master ? "index.php" : "index.php?route=admin";

$test_name = $_GET['test_name'] ?? '';
$test_id = isset($_GET['test_id']) ? (int)$_GET['test_id'] : 0;
$subject_id = (int)($_GET['subject_id'] ?? 0);

if ($subject_id > 0) {
    $redirect_url .= ($is_master ? "?" : "&") . "subject=" . $subject_id;
}

if ((empty($test_name) && $test_id <= 0) || $subject_id <= 0) {
    $_SESSION['error_message'] = "Neispravni parametri.";
    header("Location: " . $redirect_url);
    exit;
}

if (!$is_master) {
    $stmt = $conn->prepare("SELECT id FROM subjects WHERE id = ? AND admin_id = ?");
    $stmt->bind_param("ii", $subject_id, $current_admin_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        $_SESSION['error_message'] = "Nemate pristup ovom predmetu.";
        header("Location: " . $redirect_url);
        exit;
    }
}

// Provjeri da li je predmet arhiviran
$is_subject_archived = false;
$stmt_subject_archived = $conn->prepare("SELECT is_archived FROM subjects WHERE id = ?");
$stmt_subject_archived->bind_param("i", $subject_id);
$stmt_subject_archived->execute();
$subject_archived_res = $stmt_subject_archived->get_result()->fetch_assoc();
if ($subject_archived_res && $subject_archived_res['is_archived'] == 1) {
    $is_subject_archived = true;
}
// LOGIKA ZA BAZU (NOVI SISTEM)
if ($test_id > 0) {
    $stmt = $conn->prepare("SELECT is_db_test, filename FROM tests WHERE id = ?");
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $testData = $stmt->get_result()->fetch_assoc();
    
    if ($testData && $testData['is_db_test'] == 1) {
        $test_name_safe = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $testData['filename']);
        
        $stmtResults = $conn->prepare("SELECT id, student_first_name, student_last_name, total_points, earned_points, submitted_at FROM test_results WHERE test_id = ? ORDER BY student_first_name, student_last_name");
        $stmtResults->bind_param("i", $test_id);
        $stmtResults->execute();
        $results = $stmtResults->get_result();
        
        if ($results->num_rows === 0) {
            $_SESSION['error_message'] = "Nema odgovora za ovaj test u bazi.";
            header("Location: " . $redirect_url);
            exit;
        }
        
        // Nabavka svih odgovora
        $stmtAns = $conn->prepare("SELECT result_id, question_numb, student_answer, earned_points FROM test_student_answers WHERE test_id = ?");
        $stmtAns->bind_param("i", $test_id);
        $stmtAns->execute();
        $ansRes = $stmtAns->get_result();
        
        $all_answers = [];
        $max_q = 0;
        while ($a = $ansRes->fetch_assoc()) {
            if (!isset($all_answers[$a['result_id']])) $all_answers[$a['result_id']] = [];
            $pts_str = str_replace('.', ',', (string)$a['earned_points']);
            $ansStr = $a['student_answer'];
            $decodedAns = json_decode($ansStr, true);
            if (is_array($decodedAns)) {
                $ansStr = implode(', ', $decodedAns);
            }
            $all_answers[$a['result_id']][$a['question_numb']] = $ansStr . " (Bodovi: " . $pts_str . ")";
            if ($a['question_numb'] > $max_q) $max_q = $a['question_numb'];
        }
        
        $filename_prefix = $is_subject_archived ? 'ARHIVA_' : '';
        $csvFilename = $filename_prefix . 'odgovori_' . $test_name_safe . '_' . date('Ymd_His') . '.csv';

        ob_end_clean();
        
        $headers = ['Ime', 'Prezime', 'Osvojeni Bodovi', 'Ukupno Bodova', 'Procenat', 'Vrijeme predaje'];
        for ($i = 1; $i <= $max_q; $i++) {
            $headers[] = "Odgovor " . $i;
        }
        
        $req_format = $_GET['format'] ?? 'csv';
        
        if ($req_format === 'excel') {
            header('Content-Type: application/vnd.ms-excel; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . str_replace('.csv', '.xls', $csvFilename) . '"');
            echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            echo '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"></head>';
            echo '<body><table border="1">';
            echo '<tr><th style="background-color:#4b5563;color:white;padding:8px;text-align:left;">' . implode('</th><th style="background-color:#4b5563;color:white;padding:8px;text-align:left;">', $headers) . '</th></tr>';
            
            while ($row = $results->fetch_assoc()) {
                $procenat = $row['total_points'] > 0 ? round(($row['earned_points'] / $row['total_points']) * 100, 2) . '%' : '0%';
                $earned = str_replace('.', ',', (string)$row['earned_points']);
                $total = str_replace('.', ',', (string)$row['total_points']);
                $procenat = str_replace('.', ',', (string)$procenat);
                $rowData = [
                    $row['student_first_name'], $row['student_last_name'], $earned, $total, $procenat,
                    $toBelgrade($row['submitted_at'])
                ];
                for ($i = 1; $i <= $max_q; $i++) { $rowData[] = $all_answers[$row['id']][$i] ?? 'Nema odgovora'; }
                echo '<tr><td style="padding:5px;">' . implode('</td><td style="padding:5px;">', array_map(function($v){ return htmlspecialchars((string)$v); }, $rowData)) . '</td></tr>';
            }
            echo '</table></body></html>';
            exit;
        } else {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $csvFilename . '"');
            echo "\xEF\xBB\xBF";
            $out = fopen('php://output', 'w');
            fputcsv($out, $headers, ';'); // Mijenjamo zarez u tačka-zarez za kolonizaciju
            
            while ($row = $results->fetch_assoc()) {
                $procenat = $row['total_points'] > 0 ? round(($row['earned_points'] / $row['total_points']) * 100, 2) . '%' : '0%';
                $earned = str_replace('.', ',', (string)$row['earned_points']);
                $total = str_replace('.', ',', (string)$row['total_points']);
                $procenat = str_replace('.', ',', (string)$procenat);
                $rowData = [
                    $row['student_first_name'], $row['student_last_name'], $earned, $total, $procenat,
                    $toBelgrade($row['submitted_at'])
                ];
                for ($i = 1; $i <= $max_q; $i++) { $rowData[] = $all_answers[$row['id']][$i] ?? 'Nema odgovora'; }
                fputcsv($out, $rowData, ';');
            }
            fclose($out);
            exit;
        }
    }
}

// LOGIKA ZA STARE FAJLOVE (POBOLJŠANA)
$test_name_safe = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $test_name);
$answersDir = __DIR__ . '/../uploads/answers/' . $test_name_safe . '/';

if (!is_dir($answersDir)) {
    $_SESSION['error_message'] = "Nema odgovora za ovaj test.";
    header("Location: " . $redirect_url);
    exit;
}

// Odredi format preuzimanja
$format = $_GET['format'] ?? 'zip'; // 'zip', 'csv', 'excel'

if ($format === 'csv' || $format === 'excel') {
    // Generiši CSV iz JSON fajlova
    $files = glob($answersDir . '*.json');
    if (empty($files)) {
        $_SESSION['error_message'] = "Nema odgovora za ovaj test.";
        header("Location: " . $redirect_url);
        exit;
    }
    
    $filename_prefix = $is_subject_archived ? 'ARHIVA_' : '';
    $csvFilename = $filename_prefix . 'odgovori_' . $test_name_safe . '_' . date('Ymd_His') . '.csv';

    ob_end_clean();
    
    $headers = ['Ime', 'Prezime', 'Korisničko ime', 'Vrijeme predaje', 'Ukupno bodova', 'Odgovori'];
    
    if ($format === 'excel') {
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . str_replace('.csv', '.xls', $csvFilename) . '"');
        
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"></head>';
        echo '<body><table border="1">';
        echo '<tr><th style="background-color:#4b5563;color:white;padding:8px;text-align:left;">' . implode('</th><th style="background-color:#4b5563;color:white;padding:8px;text-align:left;">', $headers) . '</th></tr>';
        
        foreach ($files as $file) {
            $jsonContent = file_get_contents($file);
            $data = json_decode($jsonContent, true);
            if ($data) {
                $studentName = $data['studentName'] ?? 'Nepoznato';
                $studentUsername = $data['studentUsername'] ?? 'Nepoznato';
                $submitTime = $data['submitTime'] ?? date('Y-m-d H:i:s');
                $totalScore = $data['totalScore'] ?? 0;
                $totalScoreStr = str_replace('.', ',', (string)$totalScore);
                
                $answers = [];
                if (isset($data['answers']) && is_array($data['answers'])) {
                    foreach ($data['answers'] as $index => $answer) {
                        $answers[] = "Pitanje " . ($index + 1) . ": " . (is_array($answer) ? implode(', ', $answer) : $answer);
                    }
                }
                $answersText = implode(' | ', $answers);
                
                $rowData = [
                    explode(' ', $studentName)[0] ?? $studentName, explode(' ', $studentName)[1] ?? '', $studentUsername, $submitTime, $totalScoreStr, $answersText
                ];
                echo '<tr><td style="padding:5px;">' . implode('</td><td style="padding:5px;">', array_map(function($v){ return htmlspecialchars((string)$v); }, $rowData)) . '</td></tr>';
            }
        }
        echo '</table></body></html>';
        exit;
    } else {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $csvFilename . '"');
        echo "\xEF\xBB\xBF";
        $out = fopen('php://output', 'w');
        fputcsv($out, $headers, ';');
        
        foreach ($files as $file) {
            $jsonContent = file_get_contents($file);
            $data = json_decode($jsonContent, true);
            if ($data) {
                $studentName = $data['studentName'] ?? 'Nepoznato';
                $studentUsername = $data['studentUsername'] ?? 'Nepoznato';
                $submitTime = $data['submitTime'] ?? date('Y-m-d H:i:s');
                $totalScore = $data['totalScore'] ?? 0;
                $totalScoreStr = str_replace('.', ',', (string)$totalScore);
                
                $answers = [];
                if (isset($data['answers']) && is_array($data['answers'])) {
                    foreach ($data['answers'] as $index => $answer) {
                        $answers[] = "Pitanje " . ($index + 1) . ": " . (is_array($answer) ? implode(', ', $answer) : $answer);
                    }
                }
                $answersText = implode(' | ', $answers);
                
                $rowData = [
                    explode(' ', $studentName)[0] ?? $studentName, explode(' ', $studentName)[1] ?? '', $studentUsername, $submitTime, $totalScoreStr, $answersText
                ];
                fputcsv($out, $rowData, ';');
            }
        }
        fclose($out);
        exit;
    }
    
} else {
    // Originalni ZIP format (sirovi JSON fajlovi)
    if (!class_exists('ZipArchive')) {
        $_SESSION['error_message'] = "ZipArchive ekstenzija nije dostupna na serveru.";
        header("Location: " . $redirect_url);
        exit;
    }

    $zip = new ZipArchive();
    // Osiguraj da uploads folder postoji
    $uploadBase = __DIR__ . '/../uploads/';
    if (!is_dir($uploadBase)) mkdir($uploadBase, 0777, true);

    // Koristi lokalni folder za temp fajl (sigurnije na shared hostingu)
    $tmpZip = tempnam($uploadBase, 'answers_zip_');
    if ($zip->open($tmpZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        $_SESSION['error_message'] = "Greška pri kreiranju ZIP fajla.";
        header("Location: " . $redirect_url);
        exit;
    }

    $files = glob($answersDir . '*.json');
    if (empty($files)) {
        $zip->close();
        unlink($tmpZip);
        $_SESSION['error_message'] = "Nema odgovora za ovaj test.";
        header("Location: " . $redirect_url);
        exit;
    }

    // Dodaj i CSV summary u ZIP
    $csvContent = $this->generateCSVSummary($files, $test_name_safe);
    $zip->addFromString('SUMMARY_' . $test_name_safe . '.csv', $csvContent);

    foreach ($files as $file) {
        $zip->addFile($file, basename($file));
    }

    if (!$zip->close()) {
        $_SESSION['error_message'] = "Greška pri zatvaranju ZIP fajla.";
        header("Location: " . $redirect_url);
        exit;
    }

    if (file_exists($tmpZip)) {
        $filename_prefix = $is_subject_archived ? 'ARHIVA_' : '';
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $filename_prefix . 'odgovori_' . $test_name_safe . '.zip"');
        header('Content-Length: ' . filesize($tmpZip));
        
        ob_end_clean(); // Očisti buffer prije slanja fajla
        readfile($tmpZip);
        unlink($tmpZip);
    } else {
        $_SESSION['error_message'] = "Greška pri generisanju fajla.";
        header("Location: " . $redirect_url);
        exit;
    }
}

}

    // Pomoćna funkcija za generisanje CSV summary-a
    private function generateCSVSummary($files, $test_name_safe) {
        $csv = "\xEF\xBB\xBF"; // BOM za UTF-8
        $csv .= "Ime;Prezime;Korisničko ime;Vrijeme predaje;Ukupno bodova\n";
        
        foreach ($files as $file) {
            $jsonContent = file_get_contents($file);
            $data = json_decode($jsonContent, true);
            
            if ($data) {
                $studentName = $data['studentName'] ?? 'Nepoznato';
                $studentUsername = $data['studentUsername'] ?? 'Nepoznato';
                $submitTime = $data['submitTime'] ?? date('Y-m-d H:i:s');
                $totalScore = $data['totalScore'] ?? 0;
                $totalScoreStr = str_replace('.', ',', (string)$totalScore);
                
                $nameParts = explode(' ', $studentName);
                $firstName = $nameParts[0] ?? $studentName;
                $lastName = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : '';
                
                $csv .= "$firstName;$lastName;$studentUsername;$submitTime;$totalScoreStr\n";
            }
        }
        
        return $csv;
    }
}