<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$message = '';
$error = '';

// Handle Book Issuance
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $due_date = $_POST['due_date'];
    $issue_date = date('Y-m-d');

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Check if book is available
        $stmt = $pdo->prepare("SELECT available_copies FROM books WHERE id = ? FOR UPDATE");
        $stmt->execute([$book_id]);
        $book = $stmt->fetch();

        if ($book && $book['available_copies'] > 0) {
            // Insert into issued_books
            $stmt = $pdo->prepare("INSERT INTO issued_books (user_id, book_id, issue_date, due_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $book_id, $issue_date, $due_date]);

            // Update available copies
            $stmt = $pdo->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ?");
            $stmt->execute([$book_id]);

            $pdo->commit();
            $message = "Book issued successfully!";
        } else {
            $pdo->rollBack();
            $error = "Book is not available for issuing.";
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = "Error: " . $e->getMessage();
    }
}

// Fetch all students and available books
try {
    $students = $pdo->query("SELECT id, name, student_id FROM users WHERE role = 'student' ORDER BY name ASC")->fetchAll();
    $books = $pdo->query("SELECT id, title, available_copies FROM books WHERE available_copies > 0 ORDER BY title ASC")->fetchAll();
} catch (PDOException $e) {
    $error = "Error fetching data: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Books - Admin Dashboard</title>
    <link href="../assets/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
    </style>
</head>
<body class="bg-gray-50 flex">

    <aside class="w-64 bg-gray-900 min-h-screen text-white hidden lg:block">
        <!-- Sidebar content same as dashboard -->
        <div class="p-6">
            <img src="../assets/images/logo.png" alt="Logo" class="h-10 mb-8 filter brightness-200">
            <nav class="space-y-4">
                <a href="dashboard.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-colors">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="manage_books.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-colors">
                    <i class="fas fa-book"></i>
                    <span>Manage Books</span>
                </a>
                <a href="issue_books.php" class="flex items-center space-x-3 p-3 bg-red-600 rounded-lg">
                    <i class="fas fa-hand-holding"></i>
                    <span>Issue Books</span>
                </a>
                <a href="return_books.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-colors">
                    <i class="fas fa-undo"></i>
                    <span>Return Books</span>
                </a>
                <a href="reports.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-colors">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </nav>
        </div>
    </aside>

    <main class="flex-1 min-h-screen">
        <header class="bg-white shadow-sm p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Issue New Book</h1>
            <a href="../auth/logout.php" class="text-red-600 font-bold hover:underline">Logout</a>
        </header>

        <div class="p-8 max-w-2xl mx-auto">
            <?php if ($message): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
                <form action="" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Select Student</label>
                        <select name="user_id" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none transition appearance-none bg-no-repeat bg-right pr-10" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22/%3E%3C/svg%3E'); background-size: .65em auto;">
                            <option value="">Choose a student...</option>
                            <?php foreach($students as $student): ?>
                                <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['name']); ?> (<?php echo htmlspecialchars($student['student_id']); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Select Book</label>
                        <select name="book_id" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none transition appearance-none bg-no-repeat bg-right pr-10" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22/%3E%3C/svg%3E'); background-size: .65em auto;">
                            <option value="">Choose a book...</option>
                            <?php foreach($books as $book): ?>
                                <option value="<?php echo $book['id']; ?>"><?php echo htmlspecialchars($book['title']); ?> (<?php echo $book['available_copies']; ?> available)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Due Date</label>
                        <input type="date" name="due_date" required min="<?php echo date('Y-m-d'); ?>" 
                               value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none transition">
                        <p class="text-xs text-gray-500 mt-2">Default is 14 days from today.</p>
                    </div>

                    <button type="submit" class="w-full py-4 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition shadow-xl transform hover:scale-[1.01] flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i> Issue Book
                    </button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
