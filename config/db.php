<?php
// Flexible Database Configuration for Local vs Production
if (php_sapi_name() === 'cli' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    // LOCAL SETTINGS (XAMPP)
    $host = 'localhost';
    $dbname = 'if0_41176961_lms'; 
    $username = 'root';
    $password = '';
} else {
    // HOSTING SETTINGS (InfinityFree)
    // IMPORTANT: Ensure you use the 'MySQL Hostname' from your InfinityFree panel here
    $host = 'kcmitlms.is-best.net'; 
    $dbname = 'if0_41176961_lms';
    $username = 'if0_41176961';
    $password = 'bidyakarbhatt#45';
}

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
    
} catch(PDOException $e) {
    // Providing a more helpful error for development
    if ($host === 'localhost') {
        die("Local Connection Failed: Please ensure MySQL is started in XAMPP. Error: " . $e->getMessage());
    } else {
        die("Remote Connection Failed: InfinityFree databases only work when your code is uploaded to their server. Error: " . $e->getMessage());
    }
}
?>
