<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/student-login.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$program = $_SESSION['program'];

try {
    $stmt = $pdo->prepare("SELECT bd.*, b.book_title, b.author, br.date_borrow, br.due_date 
                           FROM borrowdetails bd
                           JOIN book b ON bd.book_id = b.book_id
                           JOIN borrow br ON bd.borrow_id = br.borrow_id
                           WHERE br.member_id = ? 
                           ORDER BY br.date_borrow DESC");
    $stmt->execute([$student_id]);
    $history = $stmt->fetchAll();
} catch (PDOException $e) { $error = $e->getMessage(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account History - KCMIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base { body { @apply bg-gray-50; font-family: 'Open Sans', sans-serif; } h1, h2 { font-family: 'Merriweather', serif; } }
    </style>
</head>
<body class="flex">
    <!-- Repurposed Sidebar -->
    <aside class="w-72 bg-gray-900 text-white p-8 flex flex-col sticky top-0 h-screen hidden lg:flex">
        <div class="mb-12">
            <h2 class="text-2xl font-black text-blue-500 italic">KCMIT <span class="text-white"><?php echo $program; ?></span></h2>
        </div>
        <nav class="space-y-3 flex-1">
            <a href="dashboard.php" class="flex items-center space-x-3 p-4 hover:bg-gray-800 rounded-2xl transition-all"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
            <a href="browse.php" class="flex items-center space-x-3 p-4 hover:bg-gray-800 rounded-2xl transition-all"><i class="fas fa-search"></i><span>Browse</span></a>
            <a href="history.php" class="flex items-center space-x-3 p-4 bg-gray-800 rounded-2xl text-blue-400 font-bold border-r-4 border-blue-500"><i class="fas fa-history"></i><span>History</span></a>
        </nav>
        <a href="../auth/logout.php" class="text-sm font-black text-red-400 mt-auto flex items-center"><i class="fas fa-sign-out-alt mr-2"></i> LOGOUT</a>
    </aside>

    <main class="flex-1 p-8">
        <header class="mb-10">
            <h1 class="text-3xl font-black text-gray-900">Your Borrowing History</h1>
            <p class="text-gray-400 font-bold text-xs uppercase mt-1">Track your returns and pending dues</p>
        </header>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                    <tr><th class="p-6">Book Details</th><th class="p-6">Issued Date</th><th class="p-6">Due Date</th><th class="p-6">Status</th><th class="p-6">Action</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic">
                    <?php foreach($history as $h): ?>
                    <tr class="hover:bg-gray-50/50 transition-all">
                        <td class="p-6">
                            <span class="font-bold text-gray-900 not-italic"><?php echo $h['book_title']; ?></span><br>
                            <span class="text-xs text-gray-400"><?php echo $h['author']; ?></span>
                        </td>
                        <td class="p-6 text-sm text-gray-600 font-semibold"><?php echo date('M d, Y', strtotime($h['date_borrow'])); ?></td>
                        <td class="p-6 text-sm <?php echo (strtotime($h['due_date']) < time() && $h['borrow_status'] == 'pending') ? 'text-red-500 font-black' : 'text-gray-600 font-semibold'; ?>">
                            <?php echo $h['due_date']; ?>
                        </td>
                        <td class="p-6">
                            <?php if($h['borrow_status'] == 'pending'): ?>
                                <span class="bg-yellow-50 text-yellow-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm border border-yellow-100 italic">Borrowed</span>
                            <?php else: ?>
                                <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm border border-green-100 italic">Returned</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-6 font-black text-xs">
                             <span class="text-blue-600 hover:underline cursor-pointer">View Receipt</span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if(empty($history)): ?>
                <div class="p-20 text-center text-gray-400 font-bold italic">No borrowing history found. Start exploring the library!</div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
