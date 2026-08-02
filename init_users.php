<?php
require 'config.php';

// Definiši naloge
$users = [
    [
        'username' => 'admin',
        'password' => 'admin123', // možeš promijeniti
        'role' => 'admin'
    ],
    [
        'username' => 'ucenik',
        'password' => 'ucenik', // default lozinka za učenika
        'role' => 'student'
    ]
];

foreach ($users as $u) {
    $username = $u['username'];
    $password = password_hash($u['password'], PASSWORD_DEFAULT);
    $role = $u['role'];

    // Provjeri da li korisnik već postoji
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 0) {
        // Kreiraj korisnika
        $stmt_insert = $conn->prepare("INSERT INTO users (username,password,role) VALUES (?,?,?)");
        $stmt_insert->bind_param("sss", $username, $password, $role);
        $stmt_insert->execute();
        echo "Korisnik '$username' je kreiran.<br>";
    } else {
        echo "Korisnik '$username' već postoji.<br>";
    }
}

echo "<br>🎉 Svi default nalozi su inicijalizirani!";
?>
