<?php
require 'config.php';

$queries = [
    "ALTER TABLE tests ADD COLUMN duration INT DEFAULT 40",
    "ALTER TABLE tests ADD COLUMN one_by_one TINYINT(1) DEFAULT 0",
    "ALTER TABLE tests ADD COLUMN hide_results TINYINT(1) DEFAULT 0",
    "ALTER TABLE tests ADD COLUMN is_db_test TINYINT(1) DEFAULT 0",
    
    "CREATE TABLE IF NOT EXISTS test_questions (
        id INT PRIMARY KEY AUTO_INCREMENT,
        test_id INT NOT NULL,
        numb INT NOT NULL,
        question TEXT NOT NULL,
        type VARCHAR(50) DEFAULT 'multiple_choice',    
        points DECIMAL(5,2) DEFAULT 1.0,
        image VARCHAR(255) DEFAULT '',
        options TEXT,
        correct_answer TEXT,
        FOREIGN KEY (test_id) REFERENCES tests(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS test_submissions (
        id INT PRIMARY KEY AUTO_INCREMENT,
        test_id INT NOT NULL,
        student_ime VARCHAR(100) NOT NULL,
        student_prezime VARCHAR(100) NOT NULL,
        student_hash VARCHAR(100) NOT NULL,
        ended_by_leave TINYINT(1) DEFAULT 0,
        score DECIMAL(10,2) DEFAULT 0,
        max_score DECIMAL(10,2) DEFAULT 0,
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (test_id) REFERENCES tests(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    "CREATE TABLE IF NOT EXISTS test_student_answers (
        id INT PRIMARY KEY AUTO_INCREMENT,
        submission_id INT NOT NULL,
        question_numb INT NOT NULL,
        question_text TEXT,
        answer TEXT,
        correct_answer TEXT,
        points_awarded DECIMAL(5,2),
        is_correct TINYINT(1),
        FOREIGN KEY (submission_id) REFERENCES test_submissions(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];

foreach ($queries as $query) {
    if (!$conn->query($query)) {
        if (!str_contains($conn->error, "Duplicate column name")) {
            echo "Error running query: " . $conn->error . "\n";
        }
    } else {
        echo "Query executed successfully.\n";
    }
}
echo "Database migration complete.\n";
