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

    // Fetch user bookmarks
    // Fetch user bookmarks
    $stmt = $pdo->prepare("SELECT book_id FROM bookmarks WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $my_bookmarks = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Fetch user requests
    $stmt = $pdo->prepare("SELECT book_id FROM book_requests WHERE user_id = ? AND status = 'pending'");
    $stmt->execute([$_SESSION['user_id']]);
    $my_requests = $stmt->fetchAll(PDO::FETCH_COLUMN);

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
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-blue-900/5 transition-all flex flex-col group">
                    <div class="h-32 bg-gray-50 rounded-2xl mb-4 flex items-center justify-center italic text-gray-300 text-5xl overflow-hidden relative">
                        <?php if(!empty($book['book_image'])): ?>
                            <img src="../<?php echo htmlspecialchars($book['book_image']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                        <?php else: ?>
                            <i class="fas fa-book"></i>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-black text-gray-900 text-sm leading-snug mb-1"><?php echo $book['book_title']; ?></h4>
                        <p class="text-[10px] text-gray-400 font-bold italic mb-4 uppercase tracking-widest"><?php echo $book['author']; ?></p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <span class="text-[10px] font-black <?php echo $book['book_copies'] > 0 ? 'text-blue-600' : 'text-red-500'; ?> italic">
                            <?php echo $book['book_copies'] > 0 ? $book['book_copies'].' IN STOCK' : 'OUT OF STOCK'; ?>
                        </span>
                        
                        <div class="flex space-x-2">
                             <?php if(in_array($book['book_id'], $my_requests)): ?>
                                <button class="text-green-500 cursor-default" title="Request Pending">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </button>
                            <?php else: ?>
                                <button onclick="requestBook(this, <?php echo $book['book_id']; ?>)" class="text-blue-600 hover:text-blue-800 transition-colors" title="Request Book">
                                    <i class="fas fa-plus-circle text-lg"></i>
                                </button>
                            <?php endif; ?>

                            <?php $is_bookmarked = in_array($book['book_id'], $my_bookmarks); ?>
                            <button onclick="toggleBookmark(this, <?php echo $book['book_id']; ?>)" 
                                    class="<?php echo $is_bookmarked ? 'bg-yellow-500 text-white' : 'bg-blue-600 text-white'; ?> w-8 h-8 rounded-full flex items-center justify-center text-xs hover:scale-110 transition-transform shadow-lg">
                                <i class="<?php echo $is_bookmarked ? 'fas' : 'far'; ?> fa-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        function requestBook(btn, bookId) {
            if(!confirm('Do you want to request this book?')) return;
            
            fetch('request_book.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'book_id=' + bookId
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Change icon to tick
                    btn.className = 'text-green-500 cursor-default transition-colors';
                    btn.innerHTML = '<i class="fas fa-check-circle text-lg"></i>';
                    btn.onclick = null; // Remove click handler
                    btn.title = 'Request Pending';
                    alert('Success: ' + data.message);
                } else {
                    alert('Notice: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred. Please try again.');
            });
        }

        function toggleBookmark(btn, bookId) {
            fetch('toggle_bookmark.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'book_id=' + bookId
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const icon = btn.querySelector('i');
                    if(data.action === 'added') {
                        btn.className = 'bg-yellow-500 text-white w-8 h-8 rounded-full flex items-center justify-center text-xs hover:scale-110 transition-transform shadow-lg';
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    } else {
                        btn.className = 'bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-xs hover:scale-110 transition-transform shadow-lg';
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(err => console.error(err));
        }
    </script>
</body>
</html>
