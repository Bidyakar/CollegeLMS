<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$message = '';
$error = '';

// Handle Add/Edit Book
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $total_copies = $_POST['total_copies'];

    try {
        if ($id) {
            // Update
            $stmt = $pdo->prepare("UPDATE books SET title=?, author=?, isbn=?, course=?, semester=?, total_copies=?, available_copies=total_copies WHERE id=?");
            $stmt->execute([$title, $author, $isbn, $course, $semester, $total_copies, $id]);
            $message = "Book updated successfully!";
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO books (title, author, isbn, course, semester, total_copies, available_copies) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $author, $isbn, $course, $semester, $total_copies, $total_copies]);
            $message = "Book added successfully!";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $message = "Book deleted successfully!";
    } catch (PDOException $e) {
        $error = "Error deleting book: Maybe it's currently issued?";
    }
}

// Fetch all books
try {
    $books = $pdo->query("SELECT * FROM books ORDER BY created_at DESC")->fetchAll();
} catch (PDOException $e) {
    $error = "Error fetching books: " . $e->getMessage();
}

// Fetch book for editing
$edit_book = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_book = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books - Admin Dashboard</title>
    <link href="../assets/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
    </style>
</head>
<body class="bg-gray-50 flex">

    <!-- Sidebar (Same as dashboard) -->
    <aside class="w-64 bg-gray-900 min-h-screen text-white fixed lg:static hidden lg:block">
        <div class="p-6">
            <img src="../assets/images/logo.png" alt="Logo" class="h-10 mb-8 filter brightness-200">
            <nav class="space-y-4">
                <a href="dashboard.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-colors">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="manage_books.php" class="flex items-center space-x-3 p-3 bg-red-600 rounded-lg">
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
    </aside>

    <!-- Main Content -->
    <main class="flex-1 min-h-screen">
        <header class="bg-white shadow-sm p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Manage Book Collection</h1>
            <div class="flex items-center space-x-4">
               <a href="../auth/logout.php" class="text-red-600 font-bold hover:underline">Logout</a>
            </div>
        </header>

        <div class="p-8">
            <?php if ($message): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded-r-lg">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-r-lg">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Book Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-6"><?php echo $edit_book ? 'Edit Book' : 'Add New Book'; ?></h2>
                        <form action="manage_books.php" method="POST" class="space-y-4">
                            <input type="hidden" name="id" value="<?php echo $edit_book['id'] ?? ''; ?>">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Book Title</label>
                                <input type="text" name="title" required value="<?php echo htmlspecialchars($edit_book['title'] ?? ''); ?>"
                                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Author</label>
                                <input type="text" name="author" required value="<?php echo htmlspecialchars($edit_book['author'] ?? ''); ?>"
                                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">ISBN</label>
                                <input type="text" name="isbn" value="<?php echo htmlspecialchars($edit_book['isbn'] ?? ''); ?>"
                                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Course</label>
                                    <select name="course" class="w-full px-4 py-2 border border-gray-200 rounded-lg outline-none">
                                        <option value="BIM" <?php echo ($edit_book['course'] ?? '') == 'BIM' ? 'selected' : ''; ?>>BIM</option>
                                        <option value="BCA" <?php echo ($edit_book['course'] ?? '') == 'BCA' ? 'selected' : ''; ?>>BCA</option>
                                        <option value="BBA" <?php echo ($edit_book['course'] ?? '') == 'BBA' ? 'selected' : ''; ?>>BBA</option>
                                        <option value="BITM" <?php echo ($edit_book['course'] ?? '') == 'BITM' ? 'selected' : ''; ?>>BITM</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Semester</label>
                                    <input type="number" name="semester" min="1" max="8" required value="<?php echo $edit_book['semester'] ?? '1'; ?>"
                                           class="w-full px-4 py-2 border border-gray-200 rounded-lg outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Total Copies</label>
                                <input type="number" name="total_copies" min="1" required value="<?php echo $edit_book['total_copies'] ?? '1'; ?>"
                                       class="w-full px-4 py-2 border border-gray-200 rounded-lg outline-none">
                            </div>
                            <button type="submit" class="w-full py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition shadow-lg">
                                <?php echo $edit_book ? 'Update Book' : 'Add Book'; ?>
                            </button>
                            <?php if($edit_book): ?>
                                <a href="manage_books.php" class="block text-center py-2 text-gray-500 hover:underline">Cancel Edit</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <!-- Books Table -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h2 class="text-xl font-bold text-gray-800">Current Collection</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase">
                                    <tr>
                                        <th class="px-6 py-4">Book Details</th>
                                        <th class="px-6 py-4">Course/Sem</th>
                                        <th class="px-6 py-4">Stock</th>
                                        <th class="px-6 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach($books as $book): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-900"><?php echo htmlspecialchars($book['title']); ?></p>
                                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($book['author']); ?></p>
                                            <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-wider">ISBN: <?php echo htmlspecialchars($book['isbn'] ?: 'N/A'); ?></p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold"><?php echo $book['course']; ?></span>
                                            <span class="text-gray-500 text-xs ml-1">Sem <?php echo $book['semester']; ?></span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <span class="font-bold <?php echo $book['available_copies'] > 0 ? 'text-green-600' : 'text-red-600'; ?>">
                                                    <?php echo $book['available_copies']; ?>
                                                </span>
                                                <span class="text-gray-400 text-xs ml-1">/ <?php echo $book['total_copies']; ?></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <a href="manage_books.php?edit=<?php echo $book['id']; ?>" class="text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="manage_books.php?delete=<?php echo $book['id']; ?>" onclick="return confirm('Are you sure?')" class="text-red-600 hover:bg-red-50 p-2 rounded-lg transition" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
