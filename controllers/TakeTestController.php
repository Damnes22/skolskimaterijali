<?php

class TakeTestController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function handleRequest() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?route=login");
            exit;
        }

        $conn = $this->conn;
        $test_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Fetch configuration from DB
        $stmt = $conn->prepare("SELECT * FROM tests WHERE id = ? AND is_db_test = 1");
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        $test = $stmt->get_result()->fetch_assoc();

        if (!$test) {
            die("Test ne postoji ili nije validan DB test.");
        }

        $testNameHtml = htmlspecialchars($test['filename']);
        $testNameSafe = addslashes($test['filename']);
        $uniqueTestNameSafe = (string)$test_id; // Koristimo test_id kao jedinstveni ključ za slanje na server
        $oneByOneJs = isset($test['is_one_by_one']) && $test['is_one_by_one'] == 1 ? 'true' : 'false';
        $newSeconds = (int)$test['duration'] * 60;
        $hideResultsJs = $test['hide_results'] == 1 ? 'true' : 'false';
        $testIdJs = $test_id;
        $isDbTestJs = 1;

        // Fetch questions
        $questions = [];
        $stmt = $conn->prepare("SELECT * FROM test_questions WHERE test_id = ? ORDER BY id ASC");
        $stmt->bind_param("i", $test_id);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $row['options'] = json_decode($row['options'], true) ?: ['', '', '', ''];
            $row['answer'] = $row['correct_answer'] ?? '';
            $questions[] = $row;
        }

        $newQuestionsHtml = "";
        // Sigurno renderiranje teksta pitanja - dopušta formatske tagove, escapa ostalo
        $renderQ = function(string $raw): string {
            // Escape sve, ali vrati dozvoljene formatirane tagove
            $escaped = htmlspecialchars($raw, ENT_QUOTES, 'UTF-8');
            $escaped = str_replace(
                ['&lt;strong&gt;','&lt;/strong&gt;','&lt;em&gt;','&lt;/em&gt;','&lt;u&gt;','&lt;/u&gt;','&lt;sup&gt;','&lt;/sup&gt;','&lt;sub&gt;','&lt;/sub&gt;','&lt;code&gt;','&lt;/code&gt;','&lt;pre&gt;','&lt;/pre&gt;'],
                ['<strong>','</strong>','<em>','</em>','<u>','</u>','<sup>','</sup>','<sub>','</sub>','<code>','</code>','<pre>','</pre>'],
                $escaped
            );
            return nl2br($escaped);
        };

        foreach ($questions as $q) {
            $qType = $q['type'] ?? 'multiple_choice';
            
            if ($qType === 'explanation') {
                $newQuestionsHtml .= "            <!-- Objašnjenje -->\n";
                $newQuestionsHtml .= "            <fieldset class=\"explanation bg-blue-900/20 border border-blue-800/50 rounded-2xl p-5 sm:p-7 transition-all duration-300 shadow-sm\">\n";
                $newQuestionsHtml .= "              <legend style=\"display:none\">Info</legend>\n";
                $newQuestionsHtml .= "              <div class=\"flex items-center gap-3 mb-3 text-blue-400 font-bold uppercase tracking-wider text-xs\"><i class=\"fas fa-info-circle text-lg\"></i> Objašnjenje / Info</div>\n";
                $newQuestionsHtml .= "              <div class=\"explanation-content text-blue-100 leading-relaxed\">" . $renderQ($q['question']) . "</div>\n";
            } else {
                $pts = $q['points'] ?? 1;
                $ptsText = ($pts == 1) ? '1 bod' : "{$pts} bodova";
                $newQuestionsHtml .= "            <!-- Pitanje {$q['numb']} -->\n";
                $newQuestionsHtml .= "            <fieldset class=\"bg-gray-800/60 border border-gray-700 rounded-2xl p-5 sm:p-7 transition-all duration-300 shadow-sm hover:shadow-md\">\n";
                $newQuestionsHtml .= "              <legend style=\"display:none\">Pitanje " . $q['numb'] . "</legend>\n";
                $newQuestionsHtml .= "              <div class=\"flex justify-between items-start gap-4 mb-5\">\n";
                $newQuestionsHtml .= "                  <div class=\"question-text text-white font-semibold text-lg leading-snug\"><span class=\"text-purple-400 mr-1\">{$q['numb']}.</span> " . $renderQ($q['question']) . "</div>\n";
                $newQuestionsHtml .= "                  <div class=\"points-badge flex-shrink-0 bg-gray-700 text-gray-300 text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-600\">{$ptsText}</div>\n";
                $newQuestionsHtml .= "              </div>\n";
            }
            
            if (!empty($q['image']) && file_exists($q['image'])) {
                $newQuestionsHtml .= "              <div class=\"mb-6 flex justify-center\"><img src=\"" . htmlspecialchars($q['image']) . "\" alt=\"Slika za pitanje\" class=\"max-w-full h-auto rounded-xl border border-gray-700 shadow-sm\"></div>\n";
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
                    $newQuestionsHtml .= "                  <label class=\"flex items-center gap-4 p-4 rounded-xl bg-gray-900/50 border border-gray-700/50 hover:bg-gray-800 hover:border-purple-500/50 cursor-pointer transition-all group\">\n";
                    $newQuestionsHtml .= "                      <div class=\"relative flex items-center justify-center w-5 h-5 flex-shrink-0\">\n";
                    $newQuestionsHtml .= "                          <input type=\"{$inputType}\" name=\"{$inputName}\" value=\"" . htmlspecialchars($opt) . "\" class=\"peer w-5 h-5 border-2 border-gray-500 {$roundedClass} bg-gray-800 checked:border-purple-500 appearance-none transition-all cursor-pointer shadow-sm\">\n";
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

        require __DIR__ . '/../views/student/take_test.php';
    }
}
