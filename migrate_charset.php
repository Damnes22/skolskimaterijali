<?php
require 'config.php';

echo "Updating database to utf8mb4...\n";
$tables = ['users', 'subjects', 'sections', 'files', 'tests', 'student_works', 'notifications', 'notification_reads'];

foreach ($tables as $table) {
    if ($conn->query("ALTER TABLE `$table` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
        echo "Table $table converted successfully.\n";
    } else {
        echo "Failed to convert $table: " . $conn->error . "\n";
    }
}
echo "Done.\n";
