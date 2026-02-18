<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/student-login.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$program = $_SESSION['program'];
$current_semester = $_SESSION['semester'];
$view_semester = $_GET['sem'] ?? $current_semester;

try {
    // 1. Fetch Borrows for the WHOLE account
    $stmt = $pdo->prepare("SELECT bd.*, b.book_title, br.date_borrow, br.due_date 
                           FROM borrowdetails bd
                           JOIN book b ON bd.book_id = b.book_id
                           JOIN borrow br ON bd.borrow_id = br.borrow_id
                           WHERE br.member_id = ?");
    $stmt->execute([$student_id]);
    $all_history = $stmt->fetchAll();

    // 2. Filter active borrows for stats
    $active_borrows = array_filter($all_history, function($b) { return $b['borrow_status'] == 'pending'; });
    
    // 3. Fine Calculation (Global)
    $total_fine = 0;
    foreach($all_history as $book) {
        if($book['borrow_status'] == 'pending') {
            $due = strtotime($book['due_date']);
            if(time() > $due) {
                $days = ceil((time() - $due) / 86400);
                $total_fine += ($days * 10);
            }
        }
    }

    // 4. Semester-wise Books (Direct Semester Column)
    $stmt = $pdo->prepare("SELECT * FROM book WHERE semester = ?");
    $stmt->execute([$view_semester]);
    $semester_books = $stmt->fetchAll();

} catch (PDOException $e) { $error = $e->getMessage(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - KCMIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base { body { @apply bg-gray-50; font-family: 'Open Sans', sans-serif; } h1, h2, h3 { font-family: 'Merriweather', serif; } }
        .tab-active { @apply bg-blue-600 text-white shadow-lg shadow-blue-200 scale-105; }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Premium Sidebar -->
    <aside class="w-72 bg-gray-900 text-white p-8 flex flex-col sticky top-0 h-screen hidden lg:flex">
        <div class="mb-12">
            <h2 class="text-2xl font-black text-blue-500 italic tracking-tighter">KCMIT <span class="text-white"><?php echo $program; ?></span></h2>
            <p class="text-[10px] font-bold uppercase text-gray-500 tracking-[0.3em] mt-1 ml-1">LMS Portal</p>
        </div>

        <nav class="space-y-3 flex-1">
            <a href="dashboard.php" class="flex items-center space-x-3 p-4 bg-gray-800 rounded-2xl text-blue-400 font-bold border-r-4 border-blue-500">
                <i class="fas fa-th-large"></i><span>Dashboard</span>
            </a>
            <a href="browse.php" class="flex items-center space-x-3 p-4 hover:bg-gray-800 rounded-2xl transition-all">
                <i class="fas fa-search"></i><span>Browse Books</span>
            </a>
            <a href="history.php" class="flex items-center space-x-3 p-4 hover:bg-gray-800 rounded-2xl transition-all">
                <i class="fas fa-history"></i><span>Account History</span>
            </a>
        </nav>

        <div class="mt-auto pt-8 border-t border-gray-800">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-black italic">
                    <?php echo substr($_SESSION['name'], 0, 2); ?>
                </div>
                <div>
                    <h4 class="text-sm font-bold truncate w-32"><?php echo $_SESSION['name']; ?></h4>
                    <p class="text-[10px] text-gray-500 font-bold">Sem <?php echo $current_semester; ?></p>
                </div>
            </div>
            <a href="../auth/logout.php" class="text-sm font-black text-red-400 hover:text-red-300 transition-colors flex items-center">
                <i class="fas fa-sign-out-alt mr-2"></i> LOGOUT
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-10 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Academic Overview</h1>
                <p class="text-gray-400 font-bold text-xs uppercase tracking-widest mt-1">Portal / Dashboard</p>
            </div>
            <div class="flex space-x-4">
                <div class="bg-blue-50 text-blue-600 px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest">
                    Sem <?php echo $current_semester; ?> Active
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid lg:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 transition-all group-hover:scale-110"><i class="fas fa-book-reader"></i></div>
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Active Borrows</p>
                <h3 class="text-4xl font-black mt-2 text-gray-900"><?php echo count($active_borrows); ?></h3>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fas fa-book-open text-9xl"></i>
                </div>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6"><i class="fas fa-exclamation-triangle"></i></div>
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Overdue Items</p>
                <h3 class="text-4xl font-black mt-2 text-red-600">
                    <?php echo count(array_filter($active_borrows, function($b){ return strtotime($b['due_date']) < time(); })); ?>
                </h3>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-6"><i class="fas fa-wallet"></i></div>
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Unpaid Fines</p>
                <h3 class="text-4xl font-black mt-2 text-green-600">Rs. <?php echo $total_fine; ?></h3>
            </div>
        </div>

        <!-- Active Borrow Details Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-black text-gray-800">My Current Borrows</h2>
                <span class="text-xs font-bold text-red-600 uppercase">Track your returns</span>
            </div>

            <?php if (empty($active_borrows)): ?>
                <div class="bg-white p-10 rounded-[2.5rem] text-center border border-gray-100">
                    <div class="w-16 h-16 bg-gray-50 text-gray-300 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-double text-2xl"></i>
                    </div>
                    <p class="text-gray-400 font-bold italic text-sm">You have no active borrows at the moment.</p>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach($active_borrows as $borrow): 
                        $due = strtotime($borrow['due_date']);
                        $is_overdue = $due < time();
                        $days_left = floor(($due - time()) / 86400);
                    ?>
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border <?php echo $is_overdue ? 'border-red-200 bg-red-50/10' : 'border-gray-100'; ?> relative overflow-hidden group">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-10 h-10 <?php echo $is_overdue ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600'; ?> rounded-xl flex items-center justify-center">
                                <i class="fas fa-book"></i>
                            </div>
                            <?php if($is_overdue): ?>
                                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest animate-pulse">Overdue</span>
                            <?php else: ?>
                                <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest border border-emerald-100">Active</span>
                            <?php endif; ?>
                        </div>

                        <h4 class="font-black text-gray-900 text-sm leading-tight mb-1 truncate"><?php echo htmlspecialchars($borrow['book_title']); ?></h4>
                        
                        <div class="flex items-center space-x-2 mb-4">
                            <!-- Helper: We need the book's semester. Since we joined 'book b', we can use b.semester if we update our query -->
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                <?php 
                                    // Fetch the specific book's semester for this borrow
                                    $stmt_sem = $pdo->prepare("SELECT semester FROM book WHERE book_id = ?");
                                    $stmt_sem->execute([$borrow['book_id']]);
                                    $b_sem = $stmt_sem->fetchColumn();
                                    echo $b_sem ? "Semester $b_sem Material" : "General Collection";
                                ?>
                            </span>
                        </div>

                        <div class="pt-4 border-t border-gray-50 flex flex-col space-y-2">
                            <div class="flex justify-between items-center text-[10px] font-bold">
                                <span class="text-gray-400 uppercase">Due Date:</span>
                                <span class="<?php echo $is_overdue ? 'text-red-600' : 'text-gray-900'; ?>"><?php echo date('M d, Y', $due); ?></span>
                            </div>
                            <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-tighter">
                                <span class="text-gray-400">Time Left:</span>
                                <?php if($is_overdue): ?>
                                    <span class="text-red-600">Delayed by <?php echo abs($days_left); ?> days</span>
                                <?php else: ?>
                                    <span class="text-emerald-600"><?php echo $days_left; ?> Days Left</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Semester Tabs Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-black text-gray-800">Semester Curated Books</h2>
                <span class="text-xs font-bold text-blue-600 uppercase">Viewing Semester <?php echo $view_semester; ?></span>
            </div>
            
            <div class="flex space-x-3 overflow-x-auto pb-6 scrollbar-hide">
                <?php for($i=1; $i<=8; $i++): ?>
                    <a href="?sem=<?php echo $i; ?>" class="flex-shrink-0 px-8 py-4 rounded-2xl font-black text-sm transition-all border border-gray-100 <?php echo $view_semester == $i ? 'tab-active bg-blue-600 text-white' : 'bg-white text-gray-400 hover:bg-gray-50'; ?>">
                        SEM <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php if (empty($semester_books)): ?>
                    <div class="lg:col-span-4 bg-gray-100 p-12 rounded-3xl text-center border-2 border-dashed border-gray-200">
                        <i class="fas fa-folder-open text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-400 font-bold italic">No catalogued books found for Semester <?php echo $view_semester; ?>.</p>
                    </div>
                <?php else: ?>
                    <?php foreach($semester_books as $book): ?>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-blue-900/5 transition-all group">
                        <div class="h-40 bg-gray-50 rounded-2xl mb-4 flex items-center justify-center relative overflow-hidden">
                            <i class="fas fa-book text-gray-200 text-6xl group-hover:scale-110 transition-transform"></i>
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-[10px] font-black shadow-sm">
                                <?php echo $book['status']; ?>
                            </div>
                        </div>
                        <h4 class="font-black text-gray-900 text-sm leading-snug mb-2"><?php echo $book['book_title']; ?></h4>
                        <p class="text-[10px] text-gray-400 font-bold italic mb-4"><?php echo $book['author']; ?></p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                            <span class="text-[10px] font-black text-blue-600"><?php echo $book['book_copies']; ?> Copies Left</span>
                            <button class="text-blue-600 hover:text-blue-800"><i class="fas fa-plus-circle"></i></button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </main>
</body>
</html>
