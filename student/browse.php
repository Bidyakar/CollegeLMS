<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/student-login.php");
    exit();
}

$program = $_SESSION['program'];
$search = $_GET['q'] ?? '';

try {
    if ($search) {
        $stmt = $pdo->prepare("SELECT * FROM book WHERE book_title LIKE ? OR author LIKE ? OR isbn LIKE ?");
        $stmt->execute(["%$search%", "%$search%", "%$search%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM book ORDER BY book_title ASC LIMIT 20");
    }
    $books = $stmt->fetchAll();
} catch (PDOException $e) { $error = $e->getMessage(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Books - KCMIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base { body { @apply bg-gray-50; font-family: 'Open Sans', sans-serif; } h1, h2 { font-family: 'Merriweather', serif; } }
    </style>
</head>
<body class="flex">
    <aside class="w-72 bg-gray-900 text-white p-8 flex flex-col sticky top-0 h-screen hidden lg:flex">
        <h2 class="text-2xl font-black text-blue-500 italic mb-12">KCMIT <span class="text-white"><?php echo $program; ?></span></h2>
        <nav class="space-y-3 flex-1">
            <a href="dashboard.php" class="flex items-center space-x-3 p-4 hover:bg-gray-800 rounded-2xl transition-all"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
            <a href="browse.php" class="flex items-center space-x-3 p-4 bg-gray-800 rounded-2xl text-blue-400 font-bold border-r-4 border-blue-500"><i class="fas fa-search"></i><span>Browse</span></a>
            <a href="history.php" class="flex items-center space-x-3 p-4 hover:bg-gray-800 rounded-2xl transition-all"><i class="fas fa-history"></i><span>History</span></a>
        </nav>
        <a href="../auth/logout.php" class="text-sm font-black text-red-400 mt-auto flex items-center italic"><i class="fas fa-sign-out-alt mr-2"></i> LOGOUT</a>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900">Library Catalog</h1>
                <p class="text-gray-400 font-bold text-xs uppercase mt-1">Search or Explore books</p>
            </div>
            <form action="" method="GET" class="relative w-96">
                <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search Title, Author, or ISBN..." class="w-full pl-12 pr-4 py-4 bg-white rounded-2xl shadow-sm border border-gray-100 outline-none focus:ring-2 focus:ring-blue-500 transition-all font-bold text-sm">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
            </form>
        </header>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach($books as $book): ?>
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-blue-900/5 transition-all flex flex-col">
                    <div class="h-32 bg-gray-50 rounded-2xl mb-4 flex items-center justify-center italic text-gray-300 text-5xl">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-black text-gray-900 text-sm leading-snug mb-1"><?php echo $book['book_title']; ?></h4>
                        <p class="text-[10px] text-gray-400 font-bold italic mb-4 uppercase tracking-widest"><?php echo $book['author']; ?></p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <span class="text-[10px] font-black <?php echo $book['book_copies'] > 0 ? 'text-blue-600' : 'text-red-500'; ?> italic">
                            <?php echo $book['book_copies'] > 0 ? $book['book_copies'].' IN STOCK' : 'OUT OF STOCK'; ?>
                        </span>
                        <button class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-xs hover:scale-110 transition-transform"><i class="fas fa-bookmark"></i></button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
