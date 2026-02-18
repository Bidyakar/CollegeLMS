<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/student-login.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$program = $_SESSION['program'] ?? 'General';
$semester = $_SESSION['semester'] ?? 1;

try {
    // 1. Fetch Currently Borrowed Books
    // Note: Assuming student_id in student_login maps to member_id in borrow table for continuity
    $stmt = $pdo->prepare("SELECT bd.*, b.book_title, br.due_date 
                           FROM borrowdetails bd
                           JOIN book b ON bd.book_id = b.book_id
                           JOIN borrow br ON bd.borrow_id = br.borrow_id
                           WHERE br.member_id = ? AND bd.borrow_status = 'pending'");
    $stmt->execute([$student_id]);
    $borrowed_books = $stmt->fetchAll();

    // 2. Fetch Books available for my Semester & Faculty
    // Note: This assumes you added 'program' and 'semester' columns to your 'book' table or mapped category_id
    $stmt = $pdo->prepare("SELECT * FROM book WHERE (category_id IN (SELECT category_id FROM category WHERE classname = ?)) OR (copyright_year >= 2020) LIMIT 4");
    $stmt->execute([$program]);
    $suggested_books = $stmt->fetchAll();

    // 3. Simple Fine Logic (Example: Rs 10 per day overdue)
    $total_fine = 0;
    foreach($borrowed_books as $book) {
        $due = strtotime($book['due_date']);
        $today = time();
        if($today > $due) {
            $days = ceil(($today - $due) / 86400);
            $total_fine += ($days * 10);
        }
    }

} catch (PDOException $e) { $error = $e->getMessage(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KCMIT Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base { body { @apply bg-white; font-family: 'Open Sans', sans-serif; } h1, h2 { font-family: 'Merriweather', serif; } }
    </style>
</head>
<body class="bg-gray-50 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-900 min-h-screen text-white p-6 hidden lg:block">
        <div class="mb-12">
            <h2 class="text-2xl font-black italic">KCMIT <span class="text-blue-400"><?php echo $program; ?></span></h2>
            <p class="text-[10px] uppercase tracking-widest opacity-50 mt-1 font-bold">Library Student Hub</p>
        </div>
        <nav class="space-y-4">
            <a href="dashboard.php" class="flex items-center space-x-3 p-3 bg-blue-700/50 rounded-xl border-l-4 border-blue-400">
                <i class="fas fa-th-large"></i><span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 hover:bg-blue-800 rounded-xl transition-all">
                <i class="fas fa-search"></i><span>Browse Books</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 hover:bg-blue-800 rounded-xl transition-all">
                <i class="fas fa-history"></i><span>Account History</span>
            </a>
        </nav>
        <div class="mt-20 pt-10 border-t border-blue-800">
            <a href="../auth/logout.php" class="flex items-center space-x-3 p-3 text-blue-300 hover:text-white transition-all font-bold italic">
                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 p-8">
        <div class="max-w-7xl mx-auto">
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-black text-gray-900">Welcome, <?php echo explode(' ', $_SESSION['name'])[0]; ?>!</h1>
                    <p class="text-gray-400 font-bold text-sm"><?php echo $program; ?> Portal • Semester <?php echo $semester; ?></p>
                </div>
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100 text-blue-600">
                    <i class="fas fa-bell"></i>
                </div>
            </header>

            <div class="grid lg:grid-cols-3 gap-8 mb-10">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-6"><i class="fas fa-book-open"></i></div>
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Active Borrows</p>
                    <h3 class="text-3xl font-black mt-2"><?php echo count($borrowed_books); ?> <span class="text-sm font-normal text-gray-400">Books</span></h3>
                </div>
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-6"><i class="fas fa-clock"></i></div>
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Books Not Returned</p>
                    <h3 class="text-3xl font-black mt-2"><?php echo count(array_filter($borrowed_books, function($b){ return strtotime($b['due_date']) < time(); })); ?></h3>
                </div>
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mb-6"><i class="fas fa-wallet"></i></div>
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Outstanding Fine</p>
                    <h3 class="text-3xl font-black mt-2">Rs. <?php echo $total_fine; ?></h3>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Borrowed Books -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold mb-6">Current Borrows</h2>
                    <?php if (empty($borrowed_books)): ?>
                        <p class="text-gray-400 italic">No books borrowed currently.</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach($borrowed_books as $book): ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl">
                                <div>
                                    <h4 class="font-bold text-gray-900"><?php echo $book['book_title']; ?></h4>
                                    <p class="text-xs text-red-500 font-bold">Due: <?php echo $book['due_date']; ?></p>
                                </div>
                                <span class="bg-white px-3 py-1 rounded-full text-[10px] font-black border border-gray-100">PENDING</span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Faculty Recommendations -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold mb-6">Available for <?php echo $program; ?> S<?php echo $semester; ?></h2>
                    <div class="grid grid-cols-2 gap-4">
                        <?php foreach($suggested_books as $sb): ?>
                        <div class="p-4 border border-gray-100 rounded-2xl hover:border-blue-200 transition-all flex flex-col justify-between">
                            <i class="fas fa-book text-blue-100 text-3xl mb-4"></i>
                            <h4 class="text-sm font-bold truncate"><?php echo $sb['book_title']; ?></h4>
                            <p class="text-[10px] text-gray-400 italic"><?php echo $sb['author']; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
