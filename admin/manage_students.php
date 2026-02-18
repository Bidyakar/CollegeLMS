<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/staff-login.php");
    exit();
}

$message = '';
$error = '';

// Handle Approval/Decline
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = ($_GET['action'] == 'approve') ? 'Approved' : 'Declined';
    
    try {
        $stmt = $pdo->prepare("UPDATE student_login SET status = ? WHERE student_id = ?");
        $stmt->execute([$status, $id]);
        $message = "Student ID #$id has been $status.";
    } catch (PDOException $e) { $error = $e->getMessage(); }
}

// Handle Manual Registration (Directly Approved)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['manual_register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $program = $_POST['program'];
    $semester = $_POST['semester'];
    $contact = $_POST['contact'];

    try {
        $stmt = $pdo->prepare("INSERT INTO student_login (username, password, email, firstname, lastname, program, semester, contact, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Approved')");
        $stmt->execute([$username, $password, $email, $firstname, $lastname, $program, $semester, $contact]);
        $message = "Student manually added and approved!";
    } catch (PDOException $e) { $error = $e->getMessage(); }
}

// Fetch Pending Requests
$pending_requests = $pdo->query("SELECT * FROM student_login WHERE status = 'Pending' ORDER BY created_at DESC")->fetchAll();

// Fetch Approved Students
$approved_students = $pdo->query("SELECT * FROM student_login WHERE status = 'Approved' ORDER BY program, semester")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - KCMIT Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base { body { @apply bg-gray-50; font-family: 'Open Sans', sans-serif; } h1, h2, h3 { font-family: 'Merriweather', serif; } }
    </style>
</head>
<body class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white p-6 hidden lg:block sticky top-0 h-screen">
        <h2 class="text-xl font-bold text-red-500 mb-8 uppercase tracking-widest leading-tight">Admin<br>Navigation</h2>
        <nav class="space-y-4">
            <a href="dashboard.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-all"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <a href="manage_books.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition-all"><i class="fas fa-book"></i><span>Manage Books</span></a>
            <a href="manage_students.php" class="flex items-center space-x-3 p-3 bg-red-600 rounded-lg transition-all shadow-lg shadow-red-900/40 font-bold"><i class="fas fa-users-graduate"></i><span>Manage Students</span></a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h1 class="text-3xl font-black text-gray-800 tracking-tight">Student Governance</h1>
            <div class="flex items-center space-x-4">
               <span class="bg-red-50 text-red-600 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest"><?php echo count($pending_requests); ?> Pending Requests</span>
            </div>
        </header>

        <?php if ($message): ?><div class="bg-green-50 text-green-700 p-4 mb-6 rounded-2xl border border-green-100 flex items-center italic text-sm"><i class="fas fa-check-circle mr-2"></i> <?php echo $message; ?></div><?php endif; ?>
        <?php if ($error): ?><div class="bg-red-50 text-red-700 p-4 mb-6 rounded-2xl border border-red-100 flex items-center italic text-sm"><i class="fas fa-exclamation-triangle mr-2"></i> <?php echo $error; ?></div><?php endif; ?>

        <!-- Pending Requests Section -->
        <?php if (!empty($pending_requests)): ?>
        <section class="mb-12">
            <h2 class="text-xl font-bold mb-6 text-gray-800 flex items-center"><i class="fas fa-clock mr-2 text-yellow-500"></i> New Account Requests</h2>
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-xs font-bold text-gray-400 uppercase tracking-widest">
                        <tr><th class="p-6">Applicant Info</th><th class="p-6">Faculty/Sem</th><th class="p-6">Applied Date</th><th class="p-6 text-right">Decision</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach($pending_requests as $req): ?>
                        <tr class="hover:bg-gray-50/50 transition-all">
                            <td class="p-6">
                                <span class="font-bold text-gray-900"><?php echo $req['firstname'].' '.$req['lastname']; ?></span><br>
                                <span class="text-xs text-gray-400 italic"><?php echo $req['email']; ?></span>
                            </td>
                            <td class="p-6 text-sm font-bold text-gray-600"><?php echo $req['program']; ?> • S<?php echo $req['semester']; ?></td>
                            <td class="p-6 text-xs text-gray-400 font-semibold"><?php echo date('M d, Y', strtotime($req['created_at'])); ?></td>
                            <td class="p-6 text-right space-x-3">
                                <a href="manage_students.php?action=approve&id=<?php echo $req['student_id']; ?>" class="bg-green-100 text-green-700 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-green-600 hover:text-white transition-all">Verify</a>
                                <a href="manage_students.php?action=decline&id=<?php echo $req['student_id']; ?>" class="bg-red-50 text-red-400 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all" onclick="return confirm('Decline this request?')">Decline</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Manual Add Form -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold mb-6 flex items-center"><i class="fas fa-user-plus mr-2 text-red-600"></i> Manual Addition</h2>
                <form action="" method="POST" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="text-[10px] font-black uppercase text-gray-400">First Name</label>
                        <input name="firstname" type="text" required class="w-full bg-gray-50 p-3 rounded-xl outline-none border border-transparent focus:border-red-200 focus:bg-white transition-all"></div>
                        <div><label class="text-[10px] font-black uppercase text-gray-400">Last Name</label>
                        <input name="lastname" type="text" required class="w-full bg-gray-50 p-3 rounded-xl outline-none border border-transparent focus:border-red-200 focus:bg-white transition-all"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="text-[10px] font-black uppercase text-gray-400">Program</label>
                        <select name="program" class="w-full bg-gray-50 p-3 rounded-xl outline-none font-bold">
                            <option value="BIM">BIM</option><option value="BCA">BCA</option><option value="BBA">BBA</option>
                        </select></div>
                        <div><label class="text-[10px] font-black uppercase text-gray-400">Semester</label>
                        <input name="semester" type="number" min="1" max="8" required class="w-full bg-gray-50 p-3 rounded-xl outline-none"></div>
                    </div>
                    <div><label class="text-[10px] font-black uppercase text-gray-400">Username</label>
                    <input name="username" type="text" required class="w-full bg-gray-50 p-3 rounded-xl outline-none"></div>
                    <div><label class="text-[10px] font-black uppercase text-gray-400">Email</label>
                    <input name="email" type="email" required class="w-full bg-gray-50 p-3 rounded-xl outline-none"></div>
                    <div><label class="text-[10px] font-black uppercase text-gray-400">Password</label>
                    <input name="password" type="text" required class="w-full bg-gray-50 p-3 rounded-xl outline-none"></div>
                    <div><label class="text-[10px] font-black uppercase text-gray-400">Contact</label>
                    <input name="contact" type="text" required class="w-full bg-gray-50 p-3 rounded-xl outline-none"></div>
                    <button type="submit" name="manual_register" class="w-full py-4 bg-red-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg shadow-red-100">Directly Add Student</button>
                </form>
            </div>

            <!-- Approved Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b"><h2 class="text-xl font-bold">Verified Students Portfolio</h2></div>
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <tr><th class="p-6">Student</th><th class="p-6">Program</th><th class="p-6">Status</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach($approved_students as $s): ?>
                            <tr>
                                <td class="p-6">
                                    <span class="font-bold text-gray-900"><?php echo $s['firstname'].' '.$s['lastname']; ?></span><br>
                                    <span class="text-xs text-gray-400 italic">@<?php echo $s['username']; ?></span>
                                </td>
                                <td class="p-6"><span class="bg-gray-100 px-3 py-1 rounded-lg text-xs font-bold text-gray-600"><?php echo $s['program']; ?> (S<?php echo $s['semester']; ?>)</span></td>
                                <td class="p-6 text-sm"><span class="text-green-500 font-bold italic"><i class="fas fa-check-circle mr-1"></i> Verified</span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
