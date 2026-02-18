<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/staff-login.php");
    exit();
}

try {
    // Total Books from 'book' table
    $total_books = $pdo->query("SELECT SUM(book_copies) FROM book")->fetchColumn() ?: 0;
    
    // Total Members from 'member' table
    $total_users = $pdo->query("SELECT COUNT(*) FROM member")->fetchColumn();
    
    // Issued Books count from 'borrowdetails' table
    $issued_books = $pdo->query("SELECT COUNT(*) FROM borrowdetails WHERE borrow_status = 'pending'")->fetchColumn();
    
    // Recent Activities (Join member, borrow, and borrowdetails)
    $stmt = $pdo->query("SELECT bd.*, m.firstname, m.lastname, b.book_title, br.date_borrow 
                         FROM borrowdetails bd
                         JOIN book b ON bd.book_id = b.book_id
                         JOIN borrow br ON bd.borrow_id = br.borrow_id
                         JOIN member m ON br.member_id = m.member_id
                         ORDER BY br.date_borrow DESC LIMIT 5");
    $recent_activities = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KCMIT Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'uneza-red': '#DC2626',
                        'uneza-dark': '#1F2937',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base {
            body { @apply bg-gray-50; font-family: 'Open Sans', sans-serif; }
            h1, h2, h3 { font-family: 'Merriweather', serif; }
        }
    </style>
</head>
<body class="bg-gray-50 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 min-h-screen text-white fixed lg:static hidden lg:block">
        <div class="p-6">
            <h2 class="text-xl font-bold text-red-500 mb-8 uppercase tracking-widest">KCMIT LMS</h2>
            <nav class="space-y-4">
                <a href="dashboard.php" class="flex items-center space-x-3 p-3 bg-red-600 rounded-lg">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="manage_books.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-all">
                    <i class="fas fa-book"></i>
                    <span>Manage Books</span>
                </a>
                <a href="manage_students.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-all">
                    <i class="fas fa-users-graduate"></i>
                    <span>Manage Students</span>
                </a>
            </nav>
        </div>
        <div class="absolute bottom-0 w-64 p-6">
            <a href="../auth/logout.php" class="text-red-400 hover:text-white flex items-center space-x-2">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 min-h-screen overflow-y-auto">
        <header class="bg-white shadow-sm p-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Library Control Panel</h1>
            <div class="flex items-center space-x-4">
               <span class="text-sm">Welcome, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong></span>
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-4 bg-blue-50 text-blue-600 rounded-xl"><i class="fas fa-book text-2xl"></i></div>
                    <div><p class="text-gray-500 text-xs font-bold uppercase">Total Stock</p><h3 class="text-2xl font-bold"><?php echo $total_books; ?></h3></div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-4 bg-green-50 text-green-600 rounded-xl"><i class="fas fa-users text-2xl"></i></div>
                    <div><p class="text-gray-500 text-xs font-bold uppercase">Members</p><h3 class="text-2xl font-bold"><?php echo $total_users; ?></h3></div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-4 bg-red-50 text-red-600 rounded-xl"><i class="fas fa-exchange-alt text-2xl"></i></div>
                    <div><p class="text-[10px] font-black uppercase text-gray-400">Issued Books</p><h3 class="text-2xl font-black"><?php echo $issued_books; ?></h3></div>
                </div>
                <!-- New Stat Card for Pending Student Requests -->
                <?php 
                    $pending_stud_count = $pdo->query("SELECT COUNT(*) FROM student_login WHERE status = 'Pending'")->fetchColumn(); 
                ?>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-4 bg-yellow-50 text-yellow-600 rounded-xl"><i class="fas fa-user-clock text-2xl"></i></div>
                    <div>
                        <p class="text-[10px] font-black uppercase text-gray-400">Account Requests</p>
                        <h3 class="text-2xl font-black"><?php echo $pending_stud_count; ?></h3>
                        <a href="manage_students.php" class="text-[10px] font-bold text-yellow-600 hover:underline">Verify Now &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100"><h2 class="text-xl font-bold text-gray-800">Recent Transactions</h2></div>
                <table class="w-full text-left">
                    <thead class="bg-gray-50 font-bold text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="p-6">Member</th>
                            <th class="p-6">Book</th>
                            <th class="p-6">Date</th>
                            <th class="p-6 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php foreach($recent_activities as $activity): ?>
                        <tr>
                            <td class="p-6"><?php echo $activity['firstname'] . ' ' . $activity['lastname']; ?></td>
                            <td class="p-6"><?php echo $activity['book_title']; ?></td>
                            <td class="p-6 text-gray-500"><?php echo $activity['date_borrow']; ?></td>
                            <td class="p-6 text-right">
                                <span class="px-2 py-1 <?php echo $activity['borrow_status'] == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700'; ?> rounded-full text-[10px] font-bold uppercase">
                                    <?php echo $activity['borrow_status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
