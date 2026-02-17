<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$message = '';
$error = '';

// Handle Book Return
if (isset($_GET['return_id'])) {
    $issued_id = $_GET['return_id'];
    $return_date = date('Y-m-d');

    try {
        $pdo->beginTransaction();

        // Get book_id
        $stmt = $pdo->prepare("SELECT book_id FROM issued_books WHERE id = ?");
        $stmt->execute([$issued_id]);
        $issued_record = $stmt->fetch();

        if ($issued_record) {
            $book_id = $issued_record['book_id'];

            // Update return_date
            $stmt = $pdo->prepare("UPDATE issued_books SET return_date = ? WHERE id = ?");
            $stmt->execute([$return_date, $issued_id]);

            // Increment available_copies
            $stmt = $pdo->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ?");
            $stmt->execute([$book_id]);

            $pdo->commit();
            $message = "Book returned successfully!";
        } else {
            $pdo->rollBack();
            $error = "Issued record not found.";
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = "Error: " . $e->getMessage();
    }
}

// Fetch all currently issued books
try {
    $stmt = $pdo->query("SELECT ib.*, u.name as user_name, u.student_id, b.title as book_title 
                         FROM issued_books ib 
                         JOIN users u ON ib.user_id = u.id 
                         JOIN books b ON ib.book_id = b.id 
                         WHERE ib.return_date IS NULL 
                         ORDER BY ib.due_date ASC");
    $issued_books = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Error fetching data: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Books - Admin Dashboard</title>
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
                <a href="issue_books.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-colors">
                    <i class="fas fa-hand-holding"></i>
                    <span>Issue Books</span>
                </a>
                <a href="return_books.php" class="flex items-center space-x-3 p-3 bg-red-600 rounded-lg">
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
            <h1 class="text-2xl font-bold text-gray-800">Return Process</h1>
            <a href="../auth/logout.php" class="text-red-600 font-bold hover:underline">Logout</a>
        </header>

        <div class="p-8">
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

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Pending Returns</h2>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search student or book..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-red-500 transition">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase">
                            <tr>
                                <th class="px-6 py-4">Student</th>
                                <th class="px-6 py-4">Book Title</th>
                                <th class="px-6 py-4">Issue Date</th>
                                <th class="px-6 py-4">Due Date</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach($issued_books as $issued): 
                                $is_overdue = strtotime($issued['due_date']) < time();
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900"><?php echo htmlspecialchars($issued['user_name']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo htmlspecialchars($issued['student_id']); ?></p>
                                </td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($issued['book_title']); ?></td>
                                <td class="px-6 py-4"><?php echo date('M d, Y', strtotime($issued['issue_date'])); ?></td>
                                <td class="px-6 py-4"><?php echo date('M d, Y', strtotime($issued['due_date'])); ?></td>
                                <td class="px-6 py-4">
                                    <?php if ($is_overdue): ?>
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase tracking-wider">Overdue</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold uppercase tracking-wider">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="return_books.php?return_id=<?php echo $issued['id']; ?>" 
                                       onclick="return confirm('Mark this book as returned?')"
                                       class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-bold hover:bg-green-700 transition shadow-md">
                                        Mark Returned
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($issued_books)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-check-double text-4xl mb-4 block"></i>
                                    No books currently issued.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
