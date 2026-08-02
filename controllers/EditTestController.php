<?php
class EditTestController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function handleRequest() {
        // Provjera pristupa
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            return ['redirect' => 'index.php?route=login'];
        }

        $current_admin_id = (int)$_SESSION['user_id'];
        $test_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Provjera da li je master admin
        $is_master = false;
        $stmt = $this->conn->prepare("SELECT parent_admin_id FROM users WHERE id = ?");
        $stmt->bind_param("i", $current_admin_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $is_master = is_null($row['parent_admin_id']);
        }

        // Dohvati podatke o testu i provjeri vlasništvo
        if ($is_master) {
            $stmt = $this->conn->prepare("SELECT * FROM tests WHERE id = ?");
            $stmt->bind_param("i", $test_id);
        } else {
            // Obični admin vidi samo svoje testove ili testove gdje je on admin predmeta
            $stmt = $this->conn->prepare("SELECT t.* FROM tests t JOIN subjects s ON t.subject_id = s.id WHERE t.id = ? AND s.admin_id = ?");
            $stmt->bind_param("ii", $test_id, $current_admin_id);
        }

        $stmt->execute();
        $test = $stmt->get_result()->fetch_assoc();

        if (!$test) {
            return ['error_die' => 'Test nije pronađen ili nemate pristup.'];
        }

        // CSRF zaštita
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $csrf_token = $_SESSION['csrf_token'];

        $isDbTest = isset($test['is_db_test']) && $test['is_db_test'] == 1;

        // Određivanje pune putanje fajla
        $fullPath = $test['filepath'];
        if (!preg_match('/^[A-Za-z]:\\\\|^\\//', $fullPath)) {
            $fullPath = __DIR__ . '/../' . $fullPath;
        }

        if (!$isDbTest) {
            if (!file_exists($fullPath)) {
                return ['error_die' => 'Fajl testa fizički ne postoji na serveru.'];
            }
            
            $htmlContent = file_get_contents($fullPath);
            $originalHtmlContent = $htmlContent;

            $currentTestName = "";
            if (preg_match('/(?:const|let|var)\s+test_name\s*=\s*["\'](.*?)["\']\s*;/', $htmlContent, $matches)) {
                $currentTestName = $matches[1];
            } elseif (preg_match('/test_name:\s*["\'](.*?)["\']/', $htmlContent, $matches)) {
                $currentTestName = $matches[1];
            } elseif (preg_match('/<h1>(.*?)<\/h1>/', $htmlContent, $matches)) {
                $currentTestName = $matches[1];
            }

            $currentDuration = 40;
            if (preg_match('/(?:let|var|const)\s+seconds\s*=\s*(\d+)\s*;/', $htmlContent, $matches)) {
                $currentDuration = round($matches[1] / 60);
            }

            $isOneByOne = false;
            if (preg_match('/(?:let|var|const)\s+isOneByOne\s*=\s*(true|false)\s*;/', $htmlContent, $matches)) {
                $isOneByOne = $matches[1] === 'true';
            }

            $hideResults = false;
            if (preg_match('/(?:let|var|const)\s+hideResults\s*=\s*(true|false)\s*;/', $htmlContent, $matches)) {
                $hideResults = $matches[1] === 'true';
            }
        } else {
            $htmlContent = "";
            $originalHtmlContent = "";
            $currentTestName = $test['filename'] ?? 'Test';
            $currentDuration = $test['duration'] ?? 40;
            $isOneByOne = isset($test['is_one_by_one']) ? ($test['is_one_by_one'] == 1) : false;
            $hideResults = $test['hide_results'] == 1;
        }

        $success_msg = null;
        $error_msg = null;

        // Logika za čuvanje izmjena
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Provjera CSRF tokena
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                return ['error_die' => 'CSRF token nije validan!'];
            }

            $questions = [];
            
            // Priprema varijabli za template
            $newTestName = isset($_POST['test_name']) ? $_POST['test_name'] : ($currentTestName ?: 'Test');
            $testNameHtml = htmlspecialchars($newTestName);
            $testNameSafe = addslashes($newTestName);

            // DOHVATI JEDINSTVENI NAZIV FAJLA ZA SUBMIT
            $uniqueTestName = pathinfo($test['filepath'], PATHINFO_FILENAME);
            $uniqueTestNameSafe = addslashes($uniqueTestName);

            // Ažuriranje naziva testa
            if (isset($_POST['test_name'])) {
                $safeNameForReplace = str_replace('$', '\$', addslashes($newTestName));
                $htmlContent = preg_replace('/(const|let|var)\s+test_name\s*=\s*["\'].*?["\']\s*;/', '$1 test_name = "' . $safeNameForReplace . '";', $htmlContent);
                $htmlContent = preg_replace('/test_name:\s*["\'].*?["\']/i', 'test_name: "' . $safeNameForReplace . '"', $htmlContent);
                $htmlContent = preg_replace('/<h1>(.*?)<\/h1>/', '<h1>' . htmlspecialchars($newTestName) . '</h1>', $htmlContent);
                $htmlContent = preg_replace('/<title>(.*?)<\/title>/', '<title>' . htmlspecialchars($newTestName) . '</title>', $htmlContent);
            }

            // Ažuriranje trajanja testa
            $newDuration = isset($_POST['test_duration']) ? (int)$_POST['test_duration'] : $currentDuration;
            $newSeconds = $newDuration * 60;
            $htmlContent = preg_replace('/(let|var|const)\s+seconds\s*=\s*\d+\s*;/', '$1 seconds = ' . $newSeconds . ';', $htmlContent);

            $newOneByOne = isset($_POST['one_by_one']);
            $oneByOneJs = $newOneByOne ? 'true' : 'false';
            $isOneByOne = $newOneByOne;

            $newHideResults = isset($_POST['hide_results']);
            $hideResultsJs = $newHideResults ? 'true' : 'false';
            $hideResults = $newHideResults;

            $imagesDir = __DIR__ . '/../uploads/images/';
            if (!is_dir($imagesDir)) {
                mkdir($imagesDir, 0777, true);
            }

            $currentDuration = $newDuration;

            if (isset($_POST['q_question']) && is_array($_POST['q_question'])) {
                $realQuestionCount = 0;
                foreach ($_POST['q_question'] as $i => $questionText) {
                    $type = $_POST['q_type'][$i] ?? 'multiple_choice';
                    
                    $numb = 0;
                    if ($type !== 'explanation') {
                        $realQuestionCount++;
                        $numb = $realQuestionCount;
                    }

                    if ($type === 'essay' || $type === 'explanation') {
                        $options = ['', '', '', ''];
                        $answer = '';
                    } else {
                        $options = isset($_POST['q_options'][$i]) ? $_POST['q_options'][$i] : [];
                        $answer = $_POST['q_answer'][$i] ?? '';
                        // Za multiple_select, q_answer[$i] dolazi kao JSON string iz JS updateCorrectAnswerHidden()
                        // Ostavljamo ga kao je, bez implode transformacije
                        if ($type === 'multiple_select') {
                            // Osiguramo da je validan JSON
                            $decoded = json_decode($answer, true);
                            if (!is_array($decoded)) {
                                // Fallback: ako nije JSON, tretiraj kao comma-separated
                                $decoded = array_map('trim', explode(',', $answer));
                                $answer = json_encode(array_values(array_filter($decoded)), JSON_UNESCAPED_UNICODE);
                            }
                            // $answer ostaje kao JSON string npr. ["A","B"]
                        } elseif (is_array($answer)) {
                            $answer = implode(', ', $answer);
                        }
                    }

                    $image_path = $_POST['q_existing_image'][$i] ?? '';

                    // Handle image removal
                    if (isset($_POST['q_remove_image']) && is_array($_POST['q_remove_image']) && in_array($i, $_POST['q_remove_image'])) {
                        if (!empty($image_path) && file_exists(__DIR__ . '/../' . $image_path)) {
                            @unlink(__DIR__ . '/../' . $image_path);
                        }
                        $image_path = '';
                    }

                    // Handle new image upload
                    if (isset($_FILES['q_image']['name'][$i]) && $_FILES['q_image']['error'][$i] === 0) {
                        if (!empty($image_path) && file_exists(__DIR__ . '/../' . $image_path)) {
                            @unlink(__DIR__ . '/../' . $image_path);
                        }

                        $img_name = $_FILES['q_image']['name'][$i];
                        $img_tmp = $_FILES['q_image']['tmp_name'][$i];
                        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
                        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                        if (in_array($img_ext, $allowed_ext)) {
                            $new_img_name = time() . '_' . uniqid('', true) . '.' . $img_ext;
                            if (move_uploaded_file($img_tmp, $imagesDir . $new_img_name)) {
                                $image_path = 'uploads/images/' . $new_img_name;
                            }
                        }
                    }

                    $points = isset($_POST['q_points'][$i]) ? (float)$_POST['q_points'][$i] : 1;

                    $questions[] = [
                        'numb' => $numb,
                        'question' => $questionText,
                        'type' => $type,
                        'answer' => $answer,
                        'options' => $options,
                        'image' => $image_path,
                        'points' => $points
                    ];
                }
            }

            // Generisanje HTML-a za pitanja
            $newQuestionsHtml = "";
            foreach ($questions as $q) {
                $qType = $q['type'] ?? 'multiple_choice';
                
                if ($qType === 'explanation') {
                    $newQuestionsHtml .= "            <!-- Objašnjenje -->\n";
                    $newQuestionsHtml .= "            <fieldset class=\"explanation bg-blue-900/20 border border-blue-500/30 rounded-2xl p-5 sm:p-7 transition-all duration-300\">\n";
                    $newQuestionsHtml .= "              <legend style=\"display:none\">Info</legend>\n";
                    $newQuestionsHtml .= "              <div class=\"flex items-center gap-3 mb-3 text-blue-400 font-bold uppercase tracking-wider text-xs\"><i class=\"fas fa-info-circle text-lg\"></i> Objašnjenje / Info</div>\n";
                    $newQuestionsHtml .= "              <div class=\"explanation-content text-blue-100 leading-relaxed\">" . nl2br(htmlspecialchars($q['question'])) . "</div>\n";
                } else {
                    $pts = $q['points'] ?? 1;
                    $ptsText = ($pts == 1) ? '1 bod' : "{$pts} bodova";
                    $newQuestionsHtml .= "            <!-- Pitanje {$q['numb']} -->\n";
                    $newQuestionsHtml .= "            <fieldset class=\"bg-gray-800/60 border border-gray-700 rounded-2xl p-5 sm:p-7 transition-all duration-300\">\n";
                    $newQuestionsHtml .= "              <legend style=\"display:none\">Pitanje " . $q['numb'] . "</legend>\n";
                    $newQuestionsHtml .= "              <div class=\"flex justify-between items-start gap-4 mb-5\">\n";
                    $newQuestionsHtml .= "                  <div class=\"question-text text-white font-semibold text-lg leading-snug\"><span class=\"text-purple-400 mr-1\">{$q['numb']}.</span> " . nl2br(htmlspecialchars($q['question'])) . "</div>\n";
                    $newQuestionsHtml .= "                  <div class=\"points-badge flex-shrink-0 bg-gray-900 text-gray-400 text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-700\">{$ptsText}</div>\n";
                    $newQuestionsHtml .= "              </div>\n";
                }
                
                if (!empty($q['image']) && file_exists(__DIR__ . '/../' . $q['image'])) {
                    $imageSrc = str_replace('uploads/', '', $q['image']);
                    $newQuestionsHtml .= "              <div class=\"mb-6 flex justify-center\"><img src=\"" . htmlspecialchars($imageSrc) . "\" alt=\"Slika za pitanje\" class=\"max-w-full h-auto rounded-xl border border-gray-600 shadow-lg\"></div>\n";
                }
                
                if ($qType === 'essay') {
                    $newQuestionsHtml .= "              <textarea name=\"q{$q['numb']}\" rows=\"4\" class=\"w-full bg-gray-900 text-white border border-gray-700 rounded-xl p-4 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none transition-all placeholder-gray-500 resize-y shadow-inner disabled:opacity-50 disabled:cursor-not-allowed\" placeholder=\"Unesite vaš odgovor ovdje...\"></textarea>\n";
                } elseif ($qType === 'multiple_choice' || $qType === 'multiple_select') {
                    $newQuestionsHtml .= "              <div class=\"space-y-3\">\n";
                    $inputType = $qType === 'multiple_select' ? 'checkbox' : 'radio';
                    $inputName = $qType === 'multiple_select' ? "q{$q['numb']}[]" : "q{$q['numb']}";
                    $roundedClass = $qType === 'multiple_select' ? 'rounded' : 'rounded-full';
                    $innerRoundedClass = $qType === 'multiple_select' ? 'rounded-sm' : 'rounded-full';
                    foreach ($q['options'] as $idx => $opt) {
                        if(trim($opt) === '') continue;
                        $newQuestionsHtml .= "                  <label class=\"flex items-center gap-4 p-4 rounded-xl bg-gray-900/50 border border-gray-700 hover:bg-gray-800 hover:border-purple-500/50 cursor-pointer transition-all group\">\n";
                        $newQuestionsHtml .= "                      <div class=\"relative flex items-center justify-center w-5 h-5 flex-shrink-0\">\n";
                        $newQuestionsHtml .= "                          <input type=\"{$inputType}\" name=\"{$inputName}\" value=\"" . htmlspecialchars($opt) . "\" class=\"peer w-5 h-5 border-2 border-gray-500 {$roundedClass} bg-transparent checked:border-purple-500 appearance-none transition-all cursor-pointer shadow-inner\">\n";
                        $newQuestionsHtml .= "                          <div class=\"absolute w-2.5 h-2.5 bg-purple-500 {$innerRoundedClass} opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none\"></div>\n";
                        $newQuestionsHtml .= "                      </div>\n";
                        $newQuestionsHtml .= "                      <span class=\"text-gray-300 group-hover:text-white transition-colors text-sm sm:text-base\">" . htmlspecialchars($opt) . "</span>\n";
                        $newQuestionsHtml .= "                  </label>\n";
                    }
                    $newQuestionsHtml .= "              </div>\n";
                }
                $newQuestionsHtml .= "            </fieldset>\n";
            }

            $questionsJson = json_encode($questions, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
            $isDbTestJs = $isDbTest ? 1 : 0;
            $testIdJs = (int)$test_id;

            // Dobijamo template i mijenjamo {$newQuestionsHtml} sa stvarnim HTML-om
            $finalContent = $this->getTestHtmlTemplate($testNameHtml, $newQuestionsHtml, $testNameSafe, $uniqueTestNameSafe, $testIdJs, $isDbTestJs, $questionsJson, $newSeconds, $oneByOneJs, $hideResultsJs);

            if ($isDbTest) {
                $dur = isset($_POST['test_duration']) ? (int)$_POST['test_duration'] : 40;
                $obo = isset($_POST['one_by_one']) ? 1 : 0;
                $hr = isset($_POST['hide_results']) ? 1 : 0;
                
                $stmt = $this->conn->prepare("UPDATE tests SET filename = ?, duration = ?, is_one_by_one = ?, hide_results = ? WHERE id = ?");
                $stmt->bind_param("siiii", $newTestName, $dur, $obo, $hr, $test_id);
                $stmt->execute();
                
                $this->conn->query("DELETE FROM test_questions WHERE test_id = " . (int)$test_id);
                $stmtIns = $this->conn->prepare("INSERT INTO test_questions(test_id, numb, question, type, points, image, options, correct_answer) VALUES (?,?,?,?,?,?,?,?)");
                foreach ($questions as $q) {
                   $opts = json_encode($q['options'], JSON_UNESCAPED_UNICODE);
                   $stmtIns->bind_param("iissssss", $test_id, $q['numb'], $q['question'], $q['type'], $q['points'], $q['image'], $opts, $q['answer']);
                   $stmtIns->execute();
                }
                
                file_put_contents($fullPath, $finalContent);
                
                $success_msg = "Test je uspješno ažuriran u bazi i pregled je generisan!";
                $currentTestName = $newTestName;
                $currentDuration = $dur;
                $isOneByOne = $obo == 1;
                $hideResults = $hr == 1;
            } else {
                file_put_contents($fullPath, $finalContent);
                $success_msg = "Test je uspješno ažuriran!";
                $htmlContent = $finalContent;
                $currentTestName = $newTestName;
            }
        }

        // Ekstrakcija postojećih pitanja za prikaz u formi
        $questionsData = [];
        $parse_warning = null;
        
        if ($isDbTest) {
            $stmt = $this->conn->prepare("SELECT * FROM test_questions WHERE test_id = ? ORDER BY id ASC");
            $stmt->bind_param("i", $test['id']);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $optsArray = json_decode($row['options'], true);
                $row['options'] = is_array($optsArray) ? $optsArray : ['', '', '', ''];
                $row['answer'] = $row['correct_answer']; 
                $questionsData[] = $row;
            }
        } else {
            if (preg_match('/(?:const|let|var)\s+questions\s*=\s*(\[(?:[^\[\]]|(?1))*\])\s*;/', $htmlContent, $matches)) {
                $jsonStr = $matches[1];
                
                $questionsData = json_decode($jsonStr, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $cleanJson = $jsonStr;
                    $cleanJson = preg_replace('/([{,])\s*([a-zA-Z0-9_]+?)\s*:/', '$1"$2":', $cleanJson);
                    $cleanJson = preg_replace('/,\s*([\]}])/m', '$1', $cleanJson);
                    
                    $questionsData = json_decode($cleanJson, true);
                    
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $parse_warning = "Greška pri parsiranju JSON-a: " . json_last_error_msg();
                        $questionsData = [];
                    }
                }
            }

            // FALLBACK HTML parsing
            if (empty($questionsData) && !isset($parse_warning)) {
                if (preg_match_all('/<fieldset[^>]*>(.*?)<\/fieldset>/s', $htmlContent, $matches)) {
                    foreach ($matches[1] as $i => $fieldsetContent) {
                        $qData = [
                            'numb' => $i + 1,
                            'type' => 'multiple_choice',
                            'question' => '',
                            'answer' => '',
                            'options' => ['', '', '', ''],
                            'image' => '',
                            'points' => 1
                        ];

                        if (preg_match('/<div class="explanation-content"[^>]*>(.*?)<\/div>/s', $fieldsetContent, $explMatch)) {
                            $qData['type'] = 'explanation';
                            $rawText = preg_replace('/<br\s*\/?>/i', "\n", trim($explMatch[1]));
                            $qData['question'] = htmlspecialchars_decode(strip_tags($rawText)); 
                        } else {
                            if (preg_match('/<div class="question-text"[^>]*>(.*?)<\/div>/s', $fieldsetContent, $qMatch)) {
                                $rawText = preg_replace('/<br\s*\/?>/i', "\n", trim($qMatch[1]));
                                $qData['question'] = preg_replace('/^\d+\.\s*/', '', htmlspecialchars_decode(strip_tags($rawText)));
                            }
                            elseif (preg_match('/<legend>(.*?)<\/legend>/s', $fieldsetContent, $legendMatch)) {
                                $qData['question'] = preg_replace('/^\d+\.\s*/', '', htmlspecialchars_decode(trim($legendMatch[1])));
                            }
                            
                            if (preg_match('/<textarea/', $fieldsetContent)) {
                                $qData['type'] = 'essay';
                            } elseif (preg_match('/<input[^>]*type="checkbox"/', $fieldsetContent)) {
                                $qData['type'] = 'multiple_select';
                            } else {
                                $qData['type'] = 'multiple_choice';
                            }
                        }

                        if (preg_match_all('/<input[^>]*type="(?:radio|checkbox)"[^>]*value="(.*?)"[^>]*>/s', $fieldsetContent, $optMatches)) {
                            foreach ($optMatches[1] as $idx => $val) {
                                if ($idx < 4) $qData['options'][$idx] = htmlspecialchars_decode($val);
                            }
                        }

                        if (preg_match('/<img[^>]*src="(.*?)"[^>]*>/s', $fieldsetContent, $imgMatch)) {
                            $qData['image'] = 'uploads/' . htmlspecialchars_decode($imgMatch[1]);
                        }
                        
                        $questionsData[] = $qData;
                    }
                }
            }

            if (empty($questionsData) && !isset($parse_warning)) {
                $questionsData = []; 
            }
        }

        return [
            'test' => $test,
            'is_master' => $is_master,
            'csrf_token' => $csrf_token,
            'currentTestName' => $currentTestName,
            'currentDuration' => $currentDuration,
            'isOneByOne' => $isOneByOne,
            'hideResults' => $hideResults,
            'questionsData' => $questionsData,
            'parse_warning' => $parse_warning,
            'success_msg' => $success_msg,
            'error_msg' => $error_msg
        ];
    }

    private function getTestHtmlTemplate($testNameHtml, $newQuestionsHtml, $testNameSafe, $uniqueTestNameSafe, $testIdJs, $isDbTestJs, $questionsJson, $newSeconds, $oneByOneJs, $hideResultsJs) {
        // Učitavamo originalni templejt za HTML testove
        $is_generating_static = true;
        ob_start();
        include __DIR__ . '/../views/student/take_test.php';
        return ob_get_clean();
    }
}