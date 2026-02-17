<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch student stats
try {
    // Books currently borrowed
    $stmt = $pdo->prepare("SELECT ib.*, b.title, b.author, b.isbn 
                           FROM issued_books ib 
                           JOIN books b ON ib.book_id = b.id 
                           WHERE ib.user_id = ? AND ib.return_date IS NULL");
    $stmt->execute([$user_id]);
    $borrowed_books = $stmt->fetchAll();

    // Past borrowings
    $stmt = $pdo->prepare("SELECT ib.*, b.title 
                           FROM issued_books ib 
                           JOIN books b ON ib.book_id = b.id 
                           WHERE ib.user_id = ? AND ib.return_date IS NOT NULL 
                           ORDER BY ib.return_date DESC LIMIT 5");
    $stmt->execute([$user_id]);
    $history = $stmt->fetchAll();

    $total_borrowed = count($borrowed_books);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - KCMIT Library</title>
    <link href="../assets/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <?php include '../includes/navbar.php'; ?>

    <div class="pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center bg-cover bg-right" style="background-image: url('../assets/images/pattern.svg');">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
                    <p class="text-gray-500 mt-2">Manage your borrowed books and explore new resources.</p>
                </div>
                <div class="mt-6 md:mt-0 flex space-x-4">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-red-600"><?php echo $total_borrowed; ?></p>
                        <p class="text-xs font-bold text-gray-500 uppercase">Current Books</p>
                    </div>
                    <div class="w-px h-12 bg-gray-200"></div>
                     <div class="text-center">
                        <p class="text-3xl font-bold text-gray-800">0</p>
                        <p class="text-xs font-bold text-gray-500 uppercase">Overdue</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Current Borrowed Books -->
                <div class="lg:col-span-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-book-reader mr-3 text-red-600"></i>
                        Currently Borrowed
                    </h2>
                    
                    <?php if (empty($borrowed_books)): ?>
                    <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
                        <img src="https://illustrations.popsy.co/gray/searching.svg" class="w-48 mx-auto mb-6">
                        <h3 class="text-xl font-bold text-gray-800">No books borrowed yet</h3>
                        <p class="text-gray-500 mt-2">Browse the library and start your reading journey!</p>
                        <a href="../index.php" class="inline-block mt-6 px-6 py-3 bg-red-600 text-white rounded-xl font-bold shadow-lg hover:bg-red-700 transition">Browse Books</a>
                    </div>
                    <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach($borrowed_books as $book): ?>
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Active</span>
                                <span class="text-xs text-gray-400">Due: <?php echo date('M d, Y', strtotime($book['due_date'])); ?></span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($book['title']); ?></h3>
                            <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($book['author']); ?></p>
                            <div class="flex items-center justify-between mt-auto">
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-barcode mr-1"></i> <?php echo htmlspecialchars($book['isbn']); ?>
                                </div>
                                <button class="text-red-600 font-bold text-sm hover:underline">Request Renewal</button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- History and Quick Links -->
                <div class="lg:col-span-4 space-y-8">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 uppercase text-sm tracking-wider">Quick Links</h2>
                        <div class="space-y-3">
                            <a href="#" class="flex items-center p-4 rounded-xl border border-gray-100 hover:bg-red-50 hover:border-red-100 transition group">
                                <span class="w-10 h-10 flex items-center justify-center bg-red-100 text-red-600 rounded-lg mr-4 group-hover:bg-red-600 group-hover:text-white transition">
                                    <i class="fas fa-search"></i>
                                </span>
                                <span class="font-semibold text-gray-700">Search Catalogue</span>
                            </a>
                            <a href="#" class="flex items-center p-4 rounded-xl border border-gray-100 hover:bg-blue-50 hover:border-blue-100 transition group">
                                <span class="w-10 h-10 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg mr-4 group-hover:bg-blue-600 group-hover:text-white transition">
                                    <i class="fas fa-user-edit"></i>
                                </span>
                                <span class="font-semibold text-gray-700">Update Profile</span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 uppercase text-sm tracking-wider">Recent Returns</h2>
                        <div class="space-y-4">
                            <?php foreach($history as $record): ?>
                            <div class="flex items-start space-x-3">
                                <div class="mt-1">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800"><?php echo htmlspecialchars($record['title']); ?></p>
                                    <p class="text-xs text-gray-500">Returned on <?php echo date('M d, Y', strtotime($record['return_date'])); ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php if(empty($history)): ?>
                            <p class="text-sm text-gray-400 text-center py-4">No return history yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
