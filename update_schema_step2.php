<?php
require_once 'config/db.php';

try {
    echo "Starting Schema Update...<br>";

    // 1. Add book_image to book table
    $pdo->exec("ALTER TABLE `book` ADD COLUMN IF NOT EXISTS `book_image` varchar(255) DEFAULT NULL;");
    echo "- Added `book_image` to `book` table.<br>";

    // 2. Create bookmarks table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `bookmarks` (
        `bookmark_id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `book_id` int(11) NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`bookmark_id`),
        UNIQUE KEY `unique_bookmark` (`user_id`, `book_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "- Created `bookmarks` table.<br>";

    // 3. Create book_requests table (for the plus button)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `book_requests` (
        `request_id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `book_id` int(11) NOT NULL,
        `status` enum('pending','approved','rejected') DEFAULT 'pending',
        `request_date` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`request_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "- Created `book_requests` table.<br>";

    echo "<h3>Schema Updated Successfully!</h3>";
    echo "<a href='index.php'>Go to Home</a>";

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
