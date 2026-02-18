<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/staff-login.php");
    exit();
}

$message = '';
$error = '';

// Handle Add/Edit Book
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'] ?? null;
    $book_title = $_POST['book_title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $book_copies = $_POST['book_copies'];
    $book_pub = $_POST['book_pub'];
    $publisher_name = $_POST['publisher_name'];
    $copyright_year = $_POST['copyright_year'];
    $status = $_POST['status'];
    $semester = $_POST['semester'] ?: null; // Handle optional semester
    $date_added = date('Y-m-d H:i:s');

    try {
        if ($book_id) {
            // Update
            $stmt = $pdo->prepare("UPDATE book SET book_title=?, author=?, isbn=?, book_copies=?, book_pub=?, publisher_name=?, copyright_year=?, status=?, semester=? WHERE book_id=?");
            $stmt->execute([$book_title, $author, $isbn, $book_copies, $book_pub, $publisher_name, $copyright_year, $status, $semester, $book_id]);
            $message = "Book updated successfully!";
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO book (book_title, author, isbn, book_copies, book_pub, publisher_name, copyright_year, status, semester, date_added) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$book_title, $author, $isbn, $book_copies, $book_pub, $publisher_name, $copyright_year, $status, $semester, $date_added]);
            $message = "Book added successfully!";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM book WHERE book_id = ?");
        $stmt->execute([$_GET['delete']]);
        $message = "Book deleted successfully!";
    } catch (PDOException $e) {
        $error = "Error deleting book: " . $e->getMessage();
    }
}

// Fetch all books
$books = $pdo->query("SELECT * FROM book ORDER BY date_added DESC")->fetchAll();

// Fetch book for editing
$edit_book = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM book WHERE book_id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_book = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base {
            body { @apply bg-gray-50; font-family: 'Open Sans', sans-serif; }
            h1, h2, h3 { font-family: 'Merriweather', serif; font-weight: 700; }
        }
    </style>
</head>
<body class="bg-gray-50 flex">
    <!-- Sidebar -->
    <?php $active_page = 'books'; include 'includes/sidebar.php'; ?>

    <main class="flex-1 min-h-screen pt-20 lg:pt-0">
        <header class="bg-white shadow-sm p-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Manage Collection</h1>
            <a href="../auth/logout.php" class="text-red-600 font-bold">Logout</a>
        </header>

        <div class="p-8">
            <?php if ($message): ?><div class="bg-green-100 p-4 mb-6 text-green-700 rounded"><?php echo $message; ?></div><?php endif; ?>
            <?php if ($error): ?><div class="bg-red-100 p-4 mb-6 text-red-700 rounded"><?php echo $error; ?></div><?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold mb-6"><?php echo $edit_book ? 'Edit' : 'Add New'; ?> Book</h2>
                    <form action="manage_books.php" method="POST" class="space-y-4">
                        <input type="hidden" name="book_id" value="<?php echo $edit_book['book_id'] ?? ''; ?>">
                        <div><label class="text-xs font-bold uppercase text-gray-500">Title</label>
                        <input type="text" name="book_title" required value="<?php echo htmlspecialchars($edit_book['book_title'] ?? ''); ?>" class="w-full p-2 border rounded"></div>
                        <div><label class="text-xs font-bold uppercase text-gray-500">Author</label>
                        <input type="text" name="author" required value="<?php echo htmlspecialchars($edit_book['author'] ?? ''); ?>" class="w-full p-2 border rounded"></div>
                        <div><label class="text-xs font-bold uppercase text-gray-500">ISBN</label>
                        <input type="text" name="isbn" value="<?php echo htmlspecialchars($edit_book['isbn'] ?? ''); ?>" class="w-full p-2 border rounded"></div>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="text-xs font-bold uppercase text-gray-500">Copies</label>
                            <input type="number" name="book_copies" required value="<?php echo $edit_book['book_copies'] ?? '1'; ?>" class="w-full p-2 border rounded"></div>
                            <div><label class="text-xs font-bold uppercase text-gray-500">Target Semester</label>
                            <select name="semester" class="w-full p-2 border rounded font-bold">
                                <option value="">General/All</option>
                                <?php for($i=1; $i<=8; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($edit_book['semester']??'') == $i ? 'selected' : ''; ?>>Semester <?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select></div>
                        </div>
                        <div><label class="text-xs font-bold uppercase text-gray-500">Status</label>
                        <select name="status" class="w-full p-2 border rounded">
                            <option value="New" <?php echo ($edit_book['status']??'')=='New'?'selected':'';?>>New</option>
                            <option value="Old" <?php echo ($edit_book['status']??'')=='Old'?'selected':'';?>>Old</option>
                            <option value="Archive" <?php echo ($edit_book['status']??'')=='Archive'?'selected':'';?>>Archive</option>
                            <option value="Damage" <?php echo ($edit_book['status']??'')=='Damage'?'selected':'';?>>Damage</option>
                        </select></div>
                        <div><label class="text-xs font-bold uppercase text-gray-500">Publisher</label>
                        <input type="text" name="book_pub" value="<?php echo htmlspecialchars($edit_book['book_pub'] ?? ''); ?>" class="w-full p-2 border rounded"></div>
                        <div><label class="text-xs font-bold uppercase text-gray-500">Publisher Name</label>
                        <input type="text" name="publisher_name" value="<?php echo htmlspecialchars($edit_book['publisher_name'] ?? ''); ?>" class="w-full p-2 border rounded"></div>
                        <div><label class="text-xs font-bold uppercase text-gray-500">Copyright Year</label>
                        <input type="number" name="copyright_year" value="<?php echo $edit_book['copyright_year'] ?? date('Y'); ?>" class="w-full p-2 border rounded"></div>
                        <button type="submit" class="w-full py-3 bg-red-600 text-white rounded font-bold hover:bg-red-700 shadow-lg shadow-red-200"><?php echo $edit_book ? 'Update' : 'Add'; ?> Book to Collection</button>
                    </form>
                </div>

                <!-- Table -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                                <tr><th class="p-6">Book Details</th><th class="p-6">Curriculum</th><th class="p-6">Copies</th><th class="p-6 text-right">Actions</th></tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                <?php foreach($books as $book): ?>
                                <tr>
                                    <td class="p-6">
                                        <p class="font-bold text-slate-800"><?php echo htmlspecialchars($book['book_title']); ?></p>
                                        <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest"><?php echo htmlspecialchars($book['author']); ?></p>
                                    </td>
                                    <td class="p-6">
                                        <?php if($book['semester']): ?>
                                            <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-100 italic">SEM <?php echo $book['semester']; ?></span>
                                        <?php else: ?>
                                            <span class="bg-slate-50 text-slate-400 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-slate-100">General</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-6 font-black text-slate-600"><?php echo $book['book_copies']; ?></td>
                                    <td class="p-6 text-right space-x-4">
                                        <a href="manage_books.php?edit=<?php echo $book['book_id']; ?>" class="text-blue-600"><i class="fas fa-edit"></i></a>
                                        <a href="manage_books.php?delete=<?php echo $book['book_id']; ?>" onclick="return confirm('Delete?')" class="text-red-600"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
