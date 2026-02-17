<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch some stats for the dashboard
try {
    $total_books = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
    $total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $issued_books = $pdo->query("SELECT COUNT(*) FROM issued_books WHERE return_date IS NULL")->fetchColumn();
    
    // Recent Activities (latest 5 issues)
    $stmt = $pdo->query("SELECT ib.*, u.name as user_name, b.title as book_title 
                         FROM issued_books ib 
                         JOIN users u ON ib.user_id = u.id 
                         JOIN books b ON ib.book_id = b.id 
                         ORDER BY ib.created_at DESC LIMIT 5");
    $recent_activities = $stmt->fetchAll();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KCMIT Library</title>
    <link href="../assets/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
    </style>
</head>
<body class="bg-gray-50 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 min-h-screen text-white fixed lg:static hidden lg:block">
        <div class="p-6">
            <img src="../assets/images/logo.png" alt="Logo" class="h-10 mb-8 filter brightness-200">
            <nav class="space-y-4">
                <a href="#" class="flex items-center space-x-3 p-3 bg-red-600 rounded-lg">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="manage_books.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-colors">
                    <i class="fas fa-book"></i>
                    <span>Manage Books</span>
                </a>
                <a href="issue_books.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-colors">
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
        <div class="absolute bottom-0 w-64 p-6 border-t border-gray-800">
            <a href="../auth/logout.php" class="flex items-center space-x-3 p-3 hover:bg-red-600 rounded-lg transition-colors text-red-400 hover:text-white">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 min-h-screen overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-sm p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Library Management Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">Welcome, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['name']); ?>&background=ef4444&color=fff" class="h-10 w-10 rounded-full shadow-md">
            </div>
        </header>

        <!-- Content Area -->
        <div class="p-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-4 bg-blue-50 text-blue-600 rounded-xl">
                        <i class="fas fa-book text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase">Total Books</p>
                        <h3 class="text-2xl font-bold"><?php echo $total_books; ?></h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-4 bg-green-50 text-green-600 rounded-xl">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase">Total Students</p>
                        <h3 class="text-2xl font-bold"><?php echo $total_users; ?></h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                    <div class="p-4 bg-red-50 text-red-600 rounded-xl">
                        <i class="fas fa-exchange-alt text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-semibold uppercase">Issued Books</p>
                        <h3 class="text-2xl font-bold"><?php echo $issued_books; ?></h3>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Recent Activities Table -->
                <div class="lg:col-span-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Recent Issues</h2>
                        <button class="text-red-600 font-semibold text-sm hover:underline">View All</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Student</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Book</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach($recent_activities as $activity): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium"><?php echo htmlspecialchars($activity['user_name']); ?></td>
                                    <td class="px-6 py-4 text-gray-600"><?php echo htmlspecialchars($activity['book_title']); ?></td>
                                    <td class="px-6 py-4 text-gray-600"><?php echo date('M d, Y', strtotime($activity['issue_date'])); ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">Issued</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(empty($recent_activities)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">No recent activity found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="lg:col-span-4 space-y-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
                        <div class="space-y-4">
                            <a href="issue_books.php" class="block w-full text-center py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition">
                                Issue New Book
                            </a>
                            <a href="manage_books.php?action=add" class="block w-full text-center py-3 border-2 border-red-600 text-red-600 rounded-xl font-bold hover:bg-red-50 transition">
                                Add New Book
                            </a>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-red-600 to-red-700 p-6 rounded-2xl shadow-xl text-white">
                        <h3 class="text-lg font-bold mb-2">Need Help?</h3>
                        <p class="text-white/80 text-sm mb-4">Check out our documentation for using the library management system.</p>
                        <a href="#" class="inline-block bg-white text-red-600 px-4 py-2 rounded-lg text-sm font-bold shadow-md">Get Support</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
