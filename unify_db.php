<?php
require_once 'config/db.php';

try {
    echo "Starting Database Unification...<br>";

    // 1. Ensure 'users' table (Staff)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
        `user_id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(100) NOT NULL,
        `password` varchar(255) NOT NULL,
        `firstname` varchar(100) NOT NULL,
        `lastname` varchar(100) NOT NULL,
        PRIMARY KEY (`user_id`),
        UNIQUE KEY `username` (`username`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "- 'users' table checked.<br>";

    // 2. Ensure 'student_login' table (Students)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `student_login` (
        `student_id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(100) NOT NULL,
        `password` varchar(255) NOT NULL,
        `firstname` varchar(100) NOT NULL,
        `lastname` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `program` varchar(50) NOT NULL,
        `semester` int(2) NOT NULL,
        `contact` varchar(50) DEFAULT NULL,
        `status` enum('Pending','Approved','Declined') DEFAULT 'Pending',
        PRIMARY KEY (`student_id`),
        UNIQUE KEY `username` (`username`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "- 'student_login' table checked.<br>";

    // 3. Ensure 'book' table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `book` (
        `book_id` int(11) NOT NULL AUTO_INCREMENT,
        `book_title` varchar(255) NOT NULL,
        `author` varchar(100) NOT NULL,
        `isbn` varchar(50) DEFAULT NULL,
        `book_copies` int(11) NOT NULL DEFAULT 1,
        `book_pub` varchar(255) DEFAULT NULL,
        `publisher_name` varchar(255) DEFAULT NULL,
        `copyright_year` int(4) DEFAULT NULL,
        `date_added` datetime DEFAULT NULL,
        `status` varchar(50) DEFAULT 'New',
        `category_id` int(11) DEFAULT NULL,
        `semester` int(2) DEFAULT NULL,
        PRIMARY KEY (`book_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    
    // Also ensure the column is added if the table already exists
    $pdo->exec("ALTER TABLE `book` ADD COLUMN IF NOT EXISTS `semester` int(2) DEFAULT NULL AFTER `category_id`;");
    echo "- 'book' table (with semester) checked.<br>";

    // 4. Ensure 'borrow' table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `borrow` (
        `borrow_id` int(11) NOT NULL AUTO_INCREMENT,
        `member_id` int(11) NOT NULL,
        `date_borrow` datetime NOT NULL,
        `due_date` datetime DEFAULT NULL,
        PRIMARY KEY (`borrow_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "- 'borrow' table checked.<br>";

    // 5. Ensure 'borrowdetails' table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `borrowdetails` (
        `borrow_details_id` int(11) NOT NULL AUTO_INCREMENT,
        `book_id` int(11) NOT NULL,
        `borrow_id` int(11) NOT NULL,
        `borrow_status` enum('pending','returned') DEFAULT 'pending',
        `date_return` datetime DEFAULT NULL,
        PRIMARY KEY (`borrow_details_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "- 'borrowdetails' table checked.<br>";

    // 6. Ensure 'resources' table (Syllabus, Notes, etc.)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `resources` (
        `resource_id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` text,
        `faculty` enum('BIM', 'BCA', 'BBA', 'BITM') NOT NULL,
        `semester` int(2) NOT NULL,
        `subject` varchar(100) NOT NULL,
        `file_path` varchar(255) DEFAULT NULL,
        `link_url` varchar(255) DEFAULT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`resource_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "- 'resources' table checked.<br>";

    // Add default admin if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $hashed = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (username, password, firstname, lastname) VALUES ('admin', ?, 'System', 'Admin')")
            ->execute([$hashed]);
        echo "- Default admin created (admin / admin123).<br>";
    }

    echo "<h3>Database Unified Successfully!</h3>";
    echo "<a href='index.php'>Go to Home</a>";

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
