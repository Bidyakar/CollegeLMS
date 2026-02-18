<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/staff-login.php");
    exit();
}

$message = '';
$error = '';

// Handle Book Issuance
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $book_id = $_POST['book_id'];
    $due_date = $_POST['due_date'];
    $issue_date = date('Y-m-d H:i:s');

    try {
        $pdo->beginTransaction();

        // Check if book is available
        $stmt = $pdo->prepare("SELECT book_copies FROM book WHERE book_id = ? FOR UPDATE");
        $stmt->execute([$book_id]);
        $book = $stmt->fetch();

        // Count how many are already issued and pending
        $stmt_pending = $pdo->prepare("SELECT COUNT(*) FROM borrowdetails WHERE book_id = ? AND borrow_status = 'pending'");
        $stmt_pending->execute([$book_id]);
        $pending_count = $stmt_pending->fetchColumn();

        if ($book && ($book['book_copies'] - $pending_count) > 0) {
            // 1. Insert into borrow table
            $stmt = $pdo->prepare("INSERT INTO borrow (member_id, date_borrow, due_date) VALUES (?, ?, ?)");
            $stmt->execute([$student_id, $issue_date, $due_date]);
            $borrow_id = $pdo->lastInsertId();

            // 2. Insert into borrowdetails table
            $stmt = $pdo->prepare("INSERT INTO borrowdetails (book_id, borrow_id, borrow_status) VALUES (?, ?, 'pending')");
            $stmt->execute([$book_id, $borrow_id]);

            $pdo->commit();
            $message = "Book issued successfully to Student #" . $student_id;
        } else {
            $pdo->rollBack();
            $error = "Book is currently out of stock.";
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = "Error: " . $e->getMessage();
    }
}

// Fetch all approved students and books
try {
    $students = $pdo->query("SELECT student_id, firstname, lastname FROM student_login WHERE status = 'Approved' ORDER BY firstname ASC")->fetchAll();
    $books = $pdo->query("SELECT book_id, book_title, author, book_copies FROM book ORDER BY book_title ASC")->fetchAll();
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; background: #f9f9fb; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
    </style>
</head>
<body class="flex">

    <!-- Sidebar -->
    <?php $active_page = 'issue'; include 'includes/sidebar.php'; ?>

    <main class="flex-1 min-h-screen pt-20 lg:pt-0">
        <header class="bg-white border-b border-gray-100 p-6 flex justify-between items-center sticky top-0 z-10">
            <h1 class="text-2xl font-bold text-gray-800">Issue New Book</h1>
            <a href="../auth/logout.php" class="text-red-600 font-bold hover:underline">Logout</a>
        </header>

        <div class="p-10 max-w-3xl mx-auto">
            <?php if ($message): ?>
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r shadow-sm flex items-center italic">
                    <i class="fas fa-check-circle mr-3"></i> <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm flex items-center italic">
                    <i class="fas fa-exclamation-triangle mr-3"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="bg-white p-10 rounded-3xl shadow-xl border border-gray-100">
                <form action="" method="POST" class="space-y-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 mb-2 uppercase tracking-widest pl-1">Student / Member</label>
                            <select name="student_id" required class="w-full px-5 py-4 bg-gray-50 border-0 focus:ring-2 focus:ring-red-500 rounded-2xl outline-none font-bold text-slate-700 transition appearance-none">
                                <option value="">Select Student</option>
                                <?php foreach($students as $student): ?>
                                    <option value="<?php echo $student['student_id']; ?>">
                                        <?php echo htmlspecialchars($student['firstname'] . ' ' . $student['lastname']); ?> (#<?php echo $student['student_id']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 mb-2 uppercase tracking-widest pl-1">Book to Issue</label>
                            <select name="book_id" required class="w-full px-5 py-4 bg-gray-50 border-0 focus:ring-2 focus:ring-red-500 rounded-2xl outline-none font-bold text-slate-700 transition appearance-none">
                                <option value="">Select Book</option>
                                <?php foreach($books as $book): ?>
                                    <option value="<?php echo $book['book_id']; ?>">
                                        <?php echo htmlspecialchars($book['book_title']); ?> by <?php echo htmlspecialchars($book['author']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 mb-2 uppercase tracking-widest pl-1">Return Deadline (Due Date)</label>
                        <input type="date" name="due_date" required min="<?php echo date('Y-m-d'); ?>" 
                               value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>"
                               class="w-full px-5 py-4 bg-gray-50 border-0 focus:ring-2 focus:ring-red-500 rounded-2xl outline-none font-bold text-slate-700 transition">
                        <p class="text-[10px] text-gray-400 mt-3 font-bold uppercase tracking-wide flex items-center">
                            <i class="fas fa-info-circle mr-2 text-red-400"></i> Standard borrowing period is 14 days.
                        </p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-red-600 text-white rounded-2xl font-black text-lg hover:bg-red-700 transition shadow-2xl shadow-red-100 flex items-center justify-center group">
                            <i class="fas fa-paper-plane mr-3 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i> 
                            Confirm Issuance
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Authorized Transaction Portal</p>
            </div>
        </div>
    </main>

</body>
</html>
