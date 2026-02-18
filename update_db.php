<?php
require_once 'config/db.php';

echo "<h2>Database Synchronization Tool</h2>";

try {
    // 1. Add columns to student_login for the new Approval System
    $sql = "ALTER TABLE `student_login` 
            ADD COLUMN IF NOT EXISTS `firstname` VARCHAR(100) NOT NULL AFTER `password`,
            ADD COLUMN IF NOT EXISTS `lastname` VARCHAR(100) NOT NULL AFTER `firstname`,
            ADD COLUMN IF NOT EXISTS `program` ENUM('BIM', 'BITM', 'BBA', 'BCA') NOT NULL AFTER `lastname`,
            ADD COLUMN IF NOT EXISTS `semester` INT(2) NOT NULL AFTER `program`,
            ADD COLUMN IF NOT EXISTS `contact` VARCHAR(50) DEFAULT NULL AFTER `semester`,
            ADD COLUMN IF NOT EXISTS `status` ENUM('Pending', 'Approved', 'Declined') DEFAULT 'Pending' AFTER `contact`";
            
    $pdo->exec($sql);
    echo "<p style='color: green;'>✓ Success: 'student_login' table updated with status and profile columns.</p>";

    // 2. Ensuring the Admin exists in your users table (as per your dump)
    $checkAdmin = $pdo->query("SELECT COUNT(*) FROM users WHERE username = 'admin'")->fetchColumn();
    if ($checkAdmin == 0) {
        $pdo->exec("INSERT INTO users (username, password, firstname, lastname) VALUES ('admin', 'admin', 'Bidyakar', 'Bhatta')");
        echo "<p style='color: green;'>✓ Success: Default Admin account created (user: admin / pass: admin).</p>";
    }

    echo "<h3>System is now ready!</h3>";
    echo "<a href='admin/dashboard.php' style='padding: 10px 20px; background: #DC2626; color: white; text-decoration: none; border-radius: 5px;'>Go to Dashboard</a>";

} catch (PDOException $e) {
    echo "<p style='color: red;'>Error updating database: " . $e->getMessage() . "</p>";
    echo "<p>Please ensure your database 'if0_41176961_lms' exists.</p>";
}
?>
