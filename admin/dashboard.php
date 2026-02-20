<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/staff-login.php");
    exit();
}

try {
    // Total Books Stock
    $total_books = $pdo->query("SELECT SUM(book_copies) FROM book")->fetchColumn() ?: 0;
    
    // Total Approved Students
    $total_users = $pdo->query("SELECT COUNT(*) FROM student_login WHERE status = 'Approved'")->fetchColumn();
    
    // Total Pending Account Requests
    $pending_stud_count = $pdo->query("SELECT COUNT(*) FROM student_login WHERE status = 'Pending'")->fetchColumn();
    
    // Currently Borrowed Books (Active)
    $issued_books = $pdo->query("SELECT COUNT(*) FROM borrowdetails WHERE borrow_status = 'pending'")->fetchColumn();
    
    // Total Blogs
    $total_blogs = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn() ?: 0;

    // Total Resources
    $total_resources = $pdo->query("SELECT COUNT(*) FROM resources")->fetchColumn() ?: 0;

    // Recent Transactions
    $stmt = $pdo->query("SELECT bd.*, s.firstname, s.lastname, b.book_title, br.date_borrow 
                         FROM borrowdetails bd
                         JOIN book b ON bd.book_id = b.book_id
                         JOIN borrow br ON bd.borrow_id = br.borrow_id
                         JOIN student_login s ON br.member_id = s.student_id
                         ORDER BY br.date_borrow DESC LIMIT 5");
    $recent_activities = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KCMIT Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; background: #f9f9fb; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="flex">

    <!-- Sidebar -->
    <?php $active_page = 'dashboard'; include 'includes/sidebar.php'; ?>

    <main class="flex-1 p-8 pt-20 lg:pt-8">
        <header class="bg-white border-b border-gray-100 p-6 flex justify-between items-center sticky top-0 z-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Library Control Panel</h1>
                <p class="text-xs text-gray-500 mt-1">Manage books, students and daily operations</p>
            </div>
            <div class="flex items-center space-x-4">
               <div class="text-right">
                   <p class="text-sm font-bold text-gray-800"><?php echo htmlspecialchars($_SESSION['name']); ?></p>
                   <p class="text-[10px] text-red-600 font-bold uppercase tracking-wider">Administrator</p>
               </div>
               <div class="h-10 w-10 bg-red-50 rounded-full flex items-center justify-center text-red-600 font-bold border border-red-100">
                   <?php echo substr($_SESSION['name'], 0, 1); ?>
               </div>
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-10">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 text-red-600 rounded-xl"><i class="fas fa-rss text-xl"></i></div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Blogs</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800"><?php echo number_format($total_blogs); ?></h3>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-[10px] text-gray-500">Articles</p>
                        <a href="manage_blogs.php" class="text-[10px] font-bold text-red-600 hover:underline">Write &rarr;</a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl"><i class="fas fa-file-alt text-xl"></i></div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Resources</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800"><?php echo number_format($total_resources); ?></h3>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-[10px] text-gray-500">Academic Files</p>
                        <a href="manage_resources.php" class="text-[10px] font-bold text-indigo-600 hover:underline">Add &rarr;</a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl"><i class="fas fa-book text-xl"></i></div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Books</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800"><?php echo number_format($total_books); ?></h3>
                    <p class="text-xs text-gray-500 mt-1">Physical stock</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-50 text-green-600 rounded-xl"><i class="fas fa-users-graduate text-xl"></i></div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Members</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800"><?php echo number_format($total_users); ?></h3>
                    <p class="text-xs text-gray-500 mt-1">Profiles</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-slate-50 text-slate-600 rounded-xl"><i class="fas fa-exchange-alt text-xl"></i></div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Borrowed</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800"><?php echo number_format($issued_books); ?></h3>
                    <p class="text-xs text-gray-500 mt-1">Active issues</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-200 bg-red-50/10 stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl"><i class="fas fa-user-clock text-xl"></i></div>
                        <span class="text-[10px] font-bold text-amber-600 uppercase">Pending</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800"><?php echo $pending_stud_count; ?></h3>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-[10px] text-gray-500">Waitlist</p>
                        <a href="manage_students.php" class="text-[10px] font-bold text-red-600 hover:underline">Verify &rarr;</a>
                    </div>
                </div>

                <?php 
                    $pending_req_count = $pdo->query("SELECT COUNT(*) FROM book_requests WHERE status = 'pending'")->fetchColumn(); 
                ?>
                
                <?php if($pending_req_count > 0): ?>
                <div class="bg-indigo-600 p-6 rounded-2xl shadow-sm border border-indigo-700 stat-card text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-500 rounded-xl"><i class="fas fa-inbox text-xl"></i></div>
                        <span class="text-[10px] font-bold text-indigo-300 uppercase animate-pulse">Action Required</span>
                    </div>
                    <h3 class="text-2xl font-black"><?php echo $pending_req_count; ?></h3>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-[10px] text-indigo-200">New Book Requests</p>
                        <a href="manage_requests.php" class="text-[10px] font-bold text-white hover:underline">Review &rarr;</a>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-black text-slate-800">Recent Activity Log</h2>
                    <button class="text-xs font-bold text-gray-400 hover:text-slate-800">View All Logs</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 font-bold text-[10px] text-gray-400 uppercase tracking-widest">
                            <tr>
                                <th class="p-6">Member / Student</th>
                                <th class="p-6">Book Issued</th>
                                <th class="p-6 text-center">Issued Date</th>
                                <th class="p-6 text-right">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php foreach($recent_activities as $activity): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500 font-bold text-xs uppercase">
                                            <?php echo substr($activity['firstname'], 0,1).substr($activity['lastname'], 0,1); ?>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800"><?php echo $activity['firstname'] . ' ' . $activity['lastname']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <p class="text-gray-900 font-medium"><?php echo $activity['book_title']; ?></p>
                                </td>
                                <td class="p-6 text-center text-gray-500">
                                    <?php echo date('M d, Y', strtotime($activity['date_borrow'])); ?>
                                </td>
                                <td class="p-6 text-right">
                                    <span class="px-3 py-1 <?php echo $activity['borrow_status'] == 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700'; ?> rounded-full text-[9px] font-black uppercase tracking-widest">
                                        <?php echo $activity['borrow_status']; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($recent_activities)): ?>
                            <tr><td colspan="4" class="p-12 text-center text-gray-400 italic">No recent activities found</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
