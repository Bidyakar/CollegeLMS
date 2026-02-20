<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/staff-login.php");
    exit();
}

$message = '';

// Handle Rejection
if (isset($_GET['reject'])) {
    $req_id = $_GET['reject'];
    try {
        $stmt = $pdo->prepare("UPDATE book_requests SET status = 'rejected' WHERE request_id = ?");
        $stmt->execute([$req_id]);
        $message = "Request rejected.";
    } catch (PDOException $e) { $error = $e->getMessage(); }
}

// Handle Approval (Convert to Issued Book)
if (isset($_GET['approve'])) {
    $req_id = $_GET['approve'];
    try {
        // Fetch request details
        $stmt = $pdo->prepare("SELECT * FROM book_requests WHERE request_id = ?");
        $stmt->execute([$req_id]);
        $request = $stmt->fetch();

        if ($request) {
            // Check book availability again
            $stmt_book = $pdo->prepare("SELECT book_copies FROM book WHERE book_id = ?");
            $stmt_book->execute([$request['book_id']]);
            $copies = $stmt_book->fetchColumn();

            if ($copies > 0) {
                $pdo->beginTransaction();

                // 1. Create Borrow Record
                $due_date = date('Y-m-d', strtotime('+30 days')); // Default 30 days
                $stmt_borrow = $pdo->prepare("INSERT INTO borrow (member_id, date_borrow, due_date) VALUES (?, NOW(), ?)");
                $stmt_borrow->execute([$request['user_id'], $due_date]);
                $borrow_id = $pdo->lastInsertId();

                // 2. Create Borrow Details
                $stmt_details = $pdo->prepare("INSERT INTO borrowdetails (book_id, borrow_id, borrow_status) VALUES (?, ?, 'pending')");
                $stmt_details->execute([$request['book_id'], $borrow_id]);

                // 3. Update Book Stock
                $stmt_upd = $pdo->prepare("UPDATE book SET book_copies = book_copies - 1 WHERE book_id = ?");
                $stmt_upd->execute([$request['book_id']]);

                // 4. Update Request Status
                $stmt_req = $pdo->prepare("UPDATE book_requests SET status = 'approved' WHERE request_id = ?");
                $stmt_req->execute([$req_id]);

                $pdo->commit();
                $message = "Request approved and book issued successfully.";
            } else {
                $error = "Cannot approve. Book is out of stock.";
            }
        }
    } catch (PDOException $e) { 
        $pdo->rollBack();
        $error = "Error: " . $e->getMessage(); 
    }
}

// Fetch Pending Requests
$requests = $pdo->query("SELECT br.*, b.book_title, b.book_copies, s.firstname, s.lastname, s.program, s.semester 
                         FROM book_requests br
                         JOIN book b ON br.book_id = b.book_id
                         JOIN student_login s ON br.user_id = s.student_id
                         WHERE br.status = 'pending'
                         ORDER BY br.request_date ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Book Requests - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base { body { @apply bg-gray-50; font-family: 'Open Sans', sans-serif; } }
    </style>
</head>
<body class="bg-gray-50 flex">

    <?php $active_page = 'requests'; include 'includes/sidebar.php'; ?>

    <main class="flex-1 min-h-screen pt-20 lg:pt-0">
        <header class="bg-white shadow-sm p-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Book Requests</h1>
            <a href="../auth/logout.php" class="text-red-600 font-bold">Logout</a>
        </header>

        <div class="p-8">
            <?php if ($message): ?><div class="bg-green-100 p-4 mb-6 text-green-700 rounded shadow-sm border border-green-200"><?php echo $message; ?></div><?php endif; ?>
            <?php if (isset($error) && $error): ?><div class="bg-red-100 p-4 mb-6 text-red-700 rounded shadow-sm border border-red-200"><?php echo $error; ?></div><?php endif; ?>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <?php if (empty($requests)): ?>
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-inbox text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-bold">No pending requests at the moment.</p>
                    </div>
                <?php else: ?>
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="p-6">Student Details</th>
                                <th class="p-6">Requested Book</th>
                                <th class="p-6">Stock Status</th>
                                <th class="p-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php foreach($requests as $req): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-6">
                                    <p class="font-bold text-gray-800"><?php echo htmlspecialchars($req['firstname'] . ' ' . $req['lastname']); ?></p>
                                    <p class="text-xs text-gray-500 mt-1"><?php echo $req['program']; ?> - Sem <?php echo $req['semester']; ?></p>
                                    <p class="text-[10px] text-gray-400 mt-1"><i class="far fa-clock mr-1"></i> <?php echo date('M d, H:i', strtotime($req['request_date'])); ?></p>
                                </td>
                                <td class="p-6">
                                    <p class="font-bold text-blue-600"><?php echo htmlspecialchars($req['book_title']); ?></p>
                                </td>
                                <td class="p-6">
                                    <?php if($req['book_copies'] > 0): ?>
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold"><?php echo $req['book_copies']; ?> Available</span>
                                    <?php else: ?>
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Out of Stock</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-6 text-right space-x-2">
                                    <a href="manage_requests.php?approve=<?php echo $req['request_id']; ?>" onclick="return confirm('Approve request and issue book?')" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg font-bold text-xs hover:bg-blue-700 transition shadow-sm">Approve</a>
                                    <a href="manage_requests.php?reject=<?php echo $req['request_id']; ?>" onclick="return confirm('Reject this request?')" class="inline-block px-4 py-2 bg-white text-red-600 border border-red-200 rounded-lg font-bold text-xs hover:bg-red-50 transition">Reject</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
