<?php

$host = 'kcmitlms.is-best.net';
$dbname = 'if0_41176961_lms';
$username = 'if0_41176961';
$password = 'bidyakarbhatt#45';

try {
    // Build DSN
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
    
} catch(PDOException $e) {
    // Show error for debugging (you might want to hide this in final production)
    die("Database Connection failed: " . $e->getMessage());
}
?>
