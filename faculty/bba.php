<?php
session_start();

// Database configuration
require_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user information
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle book issue request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issue_book'])) {
    $book_id = $_POST['book_id'];
    
    // Check if book is available
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ? AND available_copies > 0");
    $stmt->execute([$book_id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($book) {
        // Check if user already has this book
        $stmt = $pdo->prepare("SELECT * FROM issued_books WHERE user_id = ? AND book_id = ? AND return_date IS NULL");
        $stmt->execute([$user_id, $book_id]);
        $already_issued = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$already_issued) {
            // Issue the book
            $issue_date = date('Y-m-d');
            $due_date = date('Y-m-d', strtotime('+14 days'));
            
            $stmt = $pdo->prepare("INSERT INTO issued_books (user_id, book_id, issue_date, due_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $book_id, $issue_date, $due_date]);
            
            // Update available copies
            $stmt = $pdo->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ?");
            $stmt->execute([$book_id]);
            
            $success_message = "Book issued successfully!";
        } else {
            $error_message = "You have already issued this book!";
        }
    } else {
        $error_message = "Book is not available!";
    }
}

// Handle book return
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_book'])) {
    $issued_id = $_POST['issued_id'];
    
    $stmt = $pdo->prepare("UPDATE issued_books SET return_date = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([date('Y-m-d'), $issued_id, $user_id]);
    
    // Get book_id to update available copies
    $stmt = $pdo->prepare("SELECT book_id FROM issued_books WHERE id = ?");
    $stmt->execute([$issued_id]);
    $issued_book = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ?");
    $stmt->execute([$issued_book['book_id']]);
    
    $success_message = "Book returned successfully!";
}

// Get all books grouped by semester
$books_by_semester = [];
for ($i = 1; $i <= 8; $i++) {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE course = 'BBA' AND semester = ? ORDER BY title");
    $stmt->execute([$i]);
    $books_by_semester[$i] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get user's issued books
$stmt = $pdo->prepare("
    SELECT ib.*, b.title, b.author, b.semester 
    FROM issued_books ib 
    JOIN books b ON ib.book_id = b.id 
    WHERE ib.user_id = ? AND ib.return_date IS NULL
    ORDER BY ib.issue_date DESC
");
$stmt->execute([$user_id]);
$issued_books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBA - Library Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .user-info {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            display: inline-block;
        }

        .user-info p {
            margin: 5px 0;
        }

        .message {
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .content {
            padding: 30px;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .tab {
            padding: 12px 24px;
            background: #f0f0f0;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }

        .tab:hover {
            background: #e0e0e0;
        }

        .tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .semester-section {
            display: none;
            animation: fadeIn 0.5s;
        }

        .semester-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .semester-title {
            font-size: 2em;
            color: #667eea;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .book-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s;
            position: relative;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }

        .book-title {
            font-size: 1.3em;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .book-author {
            color: #666;
            margin-bottom: 8px;
        }

        .book-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9em;
        }

        .availability {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
        }

        .availability.available {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .availability.unavailable {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            width: 100%;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .my-books-section {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #e0e0e0;
        }

        .issued-books-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .issued-books-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
        }

        .issued-books-table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .issued-books-table tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .status-due {
            background: #fff3cd;
            color: #856404;
        }

        .status-overdue {
            background: #f8d7da;
            color: #721c24;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: white;
            color: #667eea;
        }

        .no-books {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <div class="header">
            <h1>📚 BBA Library Management</h1>
            <p style="font-size: 1.1em;">Bachelor of Business Administration - 8 Semester Course</p>
            <div class="user-info">
                <p><strong>Welcome, <?php echo htmlspecialchars($user['name'] ?? 'Student'); ?></strong></p>
                <p>Student ID: <?php echo htmlspecialchars($user['student_id'] ?? $user_id); ?></p>
                <p>Books Issued: <?php echo count($issued_books); ?></p>
            </div>
            <a href="../auth/logout.php" class="logout-btn">Logout</a>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="content">
            <!-- Semester Tabs -->
            <div class="tabs">
                <?php for ($i = 1; $i <= 8; $i++): ?>
                    <button class="tab <?php echo $i === 1 ? 'active' : ''; ?>" onclick="showSemester(<?php echo $i; ?>)">
                        Semester <?php echo $i; ?>
                    </button>
                <?php endfor; ?>
                <button class="tab" onclick="showMyBooks()">My Books</button>
            </div>

            <!-- Semester Sections -->
            <?php for ($semester = 1; $semester <= 8; $semester++): ?>
                <div id="semester-<?php echo $semester; ?>" class="semester-section <?php echo $semester === 1 ? 'active' : ''; ?>">
                    <h2 class="semester-title">Semester <?php echo $semester; ?> Books</h2>
                    
                    <?php if (empty($books_by_semester[$semester])): ?>
                        <div class="no-books">No books available for this semester</div>
                    <?php else: ?>
                        <div class="books-grid">
                            <?php foreach ($books_by_semester[$semester] as $book): ?>
                                <?php
                                // Check if user has already issued this book
                                $stmt = $pdo->prepare("SELECT * FROM issued_books WHERE user_id = ? AND book_id = ? AND return_date IS NULL");
                                $stmt->execute([$user_id, $book['id']]);
                                $is_issued_by_user = $stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <div class="book-card">
                                    <div class="book-title"><?php echo htmlspecialchars($book['title']); ?></div>
                                    <div class="book-author">📖 by <?php echo htmlspecialchars($book['author']); ?></div>
                                    
                                    <div class="book-details">
                                        <span>📅 ISBN: <?php echo htmlspecialchars($book['isbn'] ?? 'N/A'); ?></span>
                                    </div>
                                    
                                    <div class="availability <?php echo $book['available_copies'] > 0 ? 'available' : 'unavailable'; ?>">
                                        <?php echo $book['available_copies']; ?> / <?php echo $book['total_copies']; ?> Available
                                    </div>
                                    
                                    <?php if ($is_issued_by_user): ?>
                                        <span class="status-badge status-due">Already Issued by You</span>
                                    <?php else: ?>
                                        <form method="POST" style="margin-top: 10px;">
                                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                            <button type="submit" name="issue_book" class="btn btn-primary" 
                                                    <?php echo $book['available_copies'] <= 0 ? 'disabled' : ''; ?>>
                                                <?php echo $book['available_copies'] > 0 ? 'Issue Book' : 'Not Available'; ?>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>

            <!-- My Books Section -->
            <div id="my-books" class="semester-section">
                <h2 class="semester-title">My Issued Books</h2>
                
                <?php if (empty($issued_books)): ?>
                    <div class="no-books">You haven't issued any books yet</div>
                <?php else: ?>
                    <table class="issued-books-table">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>Semester</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($issued_books as $issued): ?>
                                <?php
                                $due_date = new DateTime($issued['due_date']);
                                $today = new DateTime();
                                $is_overdue = $today > $due_date;
                                ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($issued['title']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($issued['author']); ?></td>
                                    <td>Semester <?php echo $issued['semester']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($issued['issue_date'])); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($issued['due_date'])); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $is_overdue ? 'status-overdue' : 'status-due'; ?>">
                                            <?php echo $is_overdue ? 'Overdue' : 'Active'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form method="POST" style="margin: 0;">
                                            <input type="hidden" name="issued_id" value="<?php echo $issued['id']; ?>">
                                            <button type="submit" name="return_book" class="btn btn-danger">Return Book</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function showSemester(semesterNum) {
            // Hide all sections
            const sections = document.querySelectorAll('.semester-section');
            sections.forEach(section => section.classList.remove('active'));
            
            // Remove active class from all tabs
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Show selected semester
            document.getElementById('semester-' + semesterNum).classList.add('active');
            event.target.classList.add('active');
        }

        function showMyBooks() {
            // Hide all sections
            const sections = document.querySelectorAll('.semester-section');
            sections.forEach(section => section.classList.remove('active'));
            
            // Remove active class from all tabs
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Show my books section
            document.getElementById('my-books').classList.add('active');
            event.target.classList.add('active');
        }
    </script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
