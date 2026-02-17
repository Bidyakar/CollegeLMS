<?php
// Database configuration for InfinityFree
$host = 'kcmitlms.is-best.net'; 
$dbname = 'if0_41176961_lms';
$username = 'if0_41176961';
$password = 'bidyakarbhatt#45';

try {
    // Connect to MySQL server - On InfinityFree you usually connect directly to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to Database successfully.<br>";

    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        student_id VARCHAR(50),
        role ENUM('student', 'faculty', 'admin') DEFAULT 'student',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'users' created successfully.<br>";

    // Create books table
    $sql = "CREATE TABLE IF NOT EXISTS books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(255) NOT NULL,
        isbn VARCHAR(50),
        course ENUM('BIM', 'BCA', 'BBA', 'BITM') NOT NULL,
        semester INT NOT NULL,
        available_copies INT DEFAULT 1,
        total_copies INT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'books' created successfully.<br>";

    // Create issued_books table
    $sql = "CREATE TABLE IF NOT EXISTS issued_books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        book_id INT,
        issue_date DATE NOT NULL,
        due_date DATE NOT NULL,
        return_date DATE DEFAULT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (book_id) REFERENCES books(id),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'issued_books' created successfully.<br>";

    // Insert sample users
    $hashed_password = password_hash('password123', PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password, student_id, role) VALUES 
            ('Student User', 'student@example.com', '$hashed_password', 'STD001', 'student'),
            ('Admin User', 'admin@example.com', '$hashed_password', 'ADM001', 'admin')
            ON DUPLICATE KEY UPDATE name=VALUES(name)";
    $pdo->exec($sql);
    echo "Sample users inserted.<br>";

    // Insert sample books
    $sql = "INSERT INTO books (title, author, isbn, course, semester, available_copies, total_copies) VALUES 
            ('Digital Logic', 'Mio Morris', '978-0132145321', 'BIM', 1, 5, 5),
            ('C Programming', 'Dennis Ritchie', '978-0131103627', 'BIM', 1, 3, 5),
            ('Discrete Mathematics', 'Kenneth Rosen', '978-0073383095', 'BIM', 2, 4, 4),
            ('Computer Fundamentals', 'Pradeep K. Sinha', '978-8176567527', 'BCA', 1, 10, 10),
            ('Principles of Management', 'P.C. Tripathi', '978-0070146467', 'BBA', 1, 7, 7)
            ON DUPLICATE KEY UPDATE title=VALUES(title)";
    $pdo->exec($sql);
    echo "Sample books inserted.<br>";

    echo "<h3>Database setup completed successfully!</h3>";
    echo "<a href='index.php'>Go to Home</a>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
