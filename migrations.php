<?php
require_once 'config.php';

echo "<h2>Pokretanje migracija baze podataka...</h2>";

// 1. USERS TABELA
$col_check = $conn->query("SHOW COLUMNS FROM users LIKE 'parent_admin_id'");
if ($col_check->num_rows == 0) {
  $conn->query("ALTER TABLE users ADD COLUMN parent_admin_id INT NULL DEFAULT NULL AFTER id");
  echo "Dodata kolona parent_admin_id u users.<br>";
}

$col_check = $conn->query("SHOW COLUMNS FROM users LIKE 'class_id'");
if ($col_check->num_rows == 0) {
    $conn->query("ALTER TABLE users ADD COLUMN class_id INT NULL DEFAULT NULL AFTER parent_admin_id");
    echo "Dodata kolona class_id u users.<br>";
}

// 2. SUBJECTS TABELA
$col_check = $conn->query("SHOW COLUMNS FROM subjects LIKE 'admin_id'");
if ($col_check->num_rows == 0) {
  $conn->query("ALTER TABLE subjects ADD COLUMN admin_id INT NOT NULL DEFAULT 1 AFTER id");
  echo "Dodata kolona admin_id u subjects.<br>";
}

$col_check = $conn->query("SHOW COLUMNS FROM subjects LIKE 'hide_tests'");
if ($col_check->num_rows == 0) {
    $conn->query("ALTER TABLE subjects ADD COLUMN hide_tests TINYINT(1) DEFAULT 0");
    echo "Dodata kolona hide_tests u subjects.<br>";
}

$col_check = $conn->query("SHOW COLUMNS FROM subjects LIKE 'is_archived'");
if ($col_check->num_rows == 0) {
    if ($conn->query("ALTER TABLE subjects ADD COLUMN is_archived TINYINT(1) DEFAULT 0")) {
        echo "✅ Dodata kolona is_archived u subjects.<br>";
    } else {
        echo "❌ Greška pri dodavanju kolone is_archived: " . $conn->error . "<br>";
    }
}

// 3. FILES TABELA
$col_check = $conn->query("SHOW COLUMNS FROM files LIKE 'admin_id'");
if ($col_check->num_rows == 0) {
  $conn->query("ALTER TABLE files ADD COLUMN admin_id INT NOT NULL DEFAULT 1 AFTER id");
  echo "Dodata kolona admin_id u files.<br>";
}

$col_check = $conn->query("SHOW COLUMNS FROM files LIKE 'section_id'");
if ($col_check->num_rows == 0) {
  $conn->query("ALTER TABLE files ADD COLUMN section_id INT NULL DEFAULT NULL");
  echo "Dodata kolona section_id u files.<br>";
}

// 4. STUDENT_WORKS TABELA
$col_check = $conn->query("SHOW TABLES LIKE 'student_works'");
if ($col_check->num_rows == 0) {
  $conn->query("CREATE TABLE IF NOT EXISTS student_works (
    id INT PRIMARY KEY AUTO_INCREMENT, 
    subject_id INT, 
    user_id INT, 
    filename VARCHAR(255), 
    filepath VARCHAR(255), 
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  echo "Kreirana tabela student_works.<br>";
}
$col_check = $conn->query("SHOW COLUMNS FROM student_works LIKE 'admin_id'");
if ($col_check->num_rows == 0) {
  $conn->query("ALTER TABLE student_works ADD COLUMN admin_id INT NOT NULL DEFAULT 1");
  echo "Dodata kolona admin_id u student_works.<br>";
}

// 5. TESTS TABELA
$col_check = $conn->query("SHOW TABLES LIKE 'tests'");
if ($col_check->num_rows == 0) {
  $conn->query("CREATE TABLE IF NOT EXISTS tests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    subject_id INT,
    filename VARCHAR(255),
    filepath VARCHAR(255),
    admin_id INT DEFAULT 1,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  echo "Kreirana tabela tests.<br>";
}
$col_check = $conn->query("SHOW COLUMNS FROM tests LIKE 'hidden'");
if ($col_check->num_rows == 0) {
  $conn->query("ALTER TABLE tests ADD COLUMN hidden TINYINT(1) DEFAULT 0");
  echo "Dodata kolona hidden u tests.<br>";
}
$col_check = $conn->query("SHOW COLUMNS FROM tests LIKE 'section_id'");
if ($col_check->num_rows == 0) {
  $conn->query("ALTER TABLE tests ADD COLUMN section_id INT NULL DEFAULT NULL");
  echo "Dodata kolona section_id u tests.<br>";
}

// 6. SECTIONS TABELA
$col_check = $conn->query("SHOW TABLES LIKE 'sections'");
if ($col_check->num_rows == 0) {
  $conn->query("CREATE TABLE IF NOT EXISTS sections (
    id INT PRIMARY KEY AUTO_INCREMENT,
    subject_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  echo "Kreirana tabela sections.<br>";
}

$col_check = $conn->query("SHOW COLUMNS FROM sections LIKE 'hidden'");
if ($col_check->num_rows == 0) {
  $conn->query("ALTER TABLE sections ADD COLUMN hidden TINYINT(1) DEFAULT 0");
  echo "Dodata kolona hidden u sections.<br>";
}

// 7. NOTIFICATIONS TABELA
$col_check = $conn->query("SHOW TABLES LIKE 'notifications'");
if ($col_check->num_rows == 0) {
  $conn->query("CREATE TABLE IF NOT EXISTS notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NULL DEFAULT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'warning', 'urgent') NOT NULL DEFAULT 'info',
    recipient_id INT NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  echo "Kreirana tabela notifications.<br>";
} else {
  $col_check = $conn->query("SHOW COLUMNS FROM notifications LIKE 'title'");
  if ($col_check->num_rows == 0) {
      $conn->query("ALTER TABLE notifications ADD COLUMN title VARCHAR(255) NULL DEFAULT NULL AFTER id");
      echo "Dodata kolona title u notifications.<br>";
  }
  
  $col_check = $conn->query("SHOW COLUMNS FROM notifications LIKE 'type'");
  if ($col_check->num_rows == 0) {
      $conn->query("ALTER TABLE notifications ADD COLUMN type ENUM('info', 'warning', 'urgent') NOT NULL DEFAULT 'info'");
      echo "Dodata kolona type u notifications.<br>";
  }
  
  $col_check = $conn->query("SHOW COLUMNS FROM notifications LIKE 'recipient_id'");
  if ($col_check->num_rows == 0) {
      $conn->query("ALTER TABLE notifications ADD COLUMN recipient_id INT NULL DEFAULT NULL");
      echo "Dodata kolona recipient_id u notifications.<br>";
  }
}

// 8. NOTIFICATION_READS TABELA
$col_check = $conn->query("SHOW TABLES LIKE 'notification_reads'");
if ($col_check->num_rows == 0) {
  $conn->query("CREATE TABLE IF NOT EXISTS notification_reads (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    notification_id INT NOT NULL,
    read_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_read (user_id, notification_id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  echo "Kreirana tabela notification_reads.<br>";
}

// 9. CLASSES TABELA
$col_check = $conn->query("SHOW TABLES LIKE 'classes'");
if ($col_check->num_rows == 0) {
    $conn->query("CREATE TABLE IF NOT EXISTS classes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        admin_id INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "Kreirana tabela classes.<br>";
}

// 10. DODAVANJE DISPLAY_ORDER U SECTIONS
$checkColSectionsOrder = $conn->query("SHOW COLUMNS FROM `sections` LIKE 'display_order'");
if ($checkColSectionsOrder->num_rows == 0) {
    $conn->query("ALTER TABLE `sections` ADD COLUMN `display_order` INT NOT NULL DEFAULT 0");
    echo "Dodata kolona 'display_order' u tabelu 'sections'.<br>";
}

echo "<h3>Migracija uspješno završena! Osvježite stranicu aplikacije.</h3>";
?>