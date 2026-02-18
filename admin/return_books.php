<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/staff-login.php");
    exit();
}

$message = '';
$error = '';

// Handle Book Return
if (isset($_GET['return_id'])) {
    $bd_id = $_GET['return_id']; // borrow_details_id
    $return_date = date('Y-m-d H:i:s');

    try {
        $pdo->beginTransaction();

        // Update borrowdetails
        $stmt = $pdo->prepare("UPDATE borrowdetails SET borrow_status = 'returned', date_return = ? WHERE borrow_details_id = ?");
        $stmt->execute([$return_date, $bd_id]);

        $pdo->commit();
        $message = "Book marked as returned successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = "Error: " . $e->getMessage();
    }
}

// Fetch all currently issued books (pending)
try {
    $stmt = $pdo->query("SELECT bd.*, s.firstname, s.lastname, s.student_id as stud_custom_id, b.book_title, br.due_date 
                         FROM borrowdetails bd
                         JOIN book b ON bd.book_id = b.book_id
                         JOIN borrow br ON bd.borrow_id = br.borrow_id
                         JOIN student_login s ON br.member_id = s.student_id
                         WHERE bd.borrow_status = 'pending'
                         ORDER BY br.due_date ASC");
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; background: #f9f9fb; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
    </style>
</head>
<body class="flex">

    <!-- Sidebar -->
    <?php $active_page = 'return'; include 'includes/sidebar.php'; ?>

    <main class="flex-1 min-h-screen pt-20 lg:pt-0">
        <header class="bg-white border-b border-gray-100 p-6 flex justify-between items-center sticky top-0 z-10">
            <h1 class="text-2xl font-bold text-gray-800">Return Processing</h1>
            <a href="../auth/logout.php" class="text-red-600 font-bold hover:underline">Logout</a>
        </header>

        <div class="p-8">
            <?php if ($message): ?>
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded shadow-sm flex items-center">
                    <i class="fas fa-check-circle mr-3"></i> <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-white">
                    <div>
                        <h2 class="text-xl font-black text-slate-800">Pending Returns</h2>
                        <p class="text-xs text-gray-400 mt-1 font-bold">Books currently out with students</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                            <tr>
                                <th class="px-8 py-5">Student</th>
                                <th class="px-8 py-5">Book Title</th>
                                <th class="px-8 py-5">Due Date</th>
                                <th class="px-8 py-5 text-center">Status</th>
                                <th class="px-8 py-5 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach($issued_books as $issued): 
                                $due = strtotime($issued['due_date']);
                                $is_overdue = $due < time();
                                $fine = 0;
                                if($is_overdue) {
                                    $days = ceil((time() - $due) / 86400);
                                    $fine = $days * 10;
                                }
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-8 py-6">
                                    <p class="font-black text-slate-800"><?php echo htmlspecialchars($issued['firstname'] . ' ' . $issued['lastname']); ?></p>
                                    <p class="text-[10px] text-gray-400 font-bold">ID: #<?php echo $issued['student_id']; ?></p>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-slate-700"><?php echo htmlspecialchars($issued['book_title']); ?></p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold <?php echo $is_overdue ? 'text-red-600' : 'text-slate-600'; ?>">
                                            <?php echo date('M d, Y', $due); ?>
                                        </span>
                                        <?php if($is_overdue): ?>
                                            <span class="text-[10px] font-black text-red-500 uppercase tracking-tighter">Fine: Rs. <?php echo $fine; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <?php if ($is_overdue): ?>
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[9px] font-black uppercase tracking-widest border border-red-200">Overdue</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[9px] font-black uppercase tracking-widest border border-amber-200">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="return_books.php?return_id=<?php echo $issued['borrow_details_id']; ?>" 
                                       onclick="return confirm('Confirm book return?')"
                                       class="inline-block px-6 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-600 transition shadow-lg shadow-slate-200 hover:shadow-red-200">
                                        Process Return
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($issued_books)): ?>
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center text-gray-400">
                                    <i class="fas fa-check-circle text-5xl mb-4 block text-emerald-100"></i>
                                    <p class="text-sm font-bold uppercase tracking-widest">No books currently pending return</p>
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
