<?php
session_start();
require_once '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        // Master record search in student_login table
        $stmt = $pdo->prepare("SELECT * FROM student_login WHERE username = ?");
        $stmt->execute([$username]);
        $student = $stmt->fetch();

        // Checking password (Assuming plain text as per your SQL users sample, but recommended password_verify)
        if ($student && ($password === $student['password'] || password_verify($password, $student['password']))) {
            $_SESSION['user_id'] = $student['student_id'];
            $_SESSION['name'] = $student['firstname'] . ' ' . $student['lastname'];
            $_SESSION['role'] = 'student';
            $_SESSION['program'] = $student['program'];
            $_SESSION['semester'] = $student['semester'];
            
            header("Location: ../student/dashboard.php");
            exit();
        } else {
            $error = "Student credentials not found. Please verify your Faculty Username/Password.";
        }
    } catch (PDOException $e) { $error = "System error: " . $e->getMessage(); }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - KCMIT Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base { body { @apply bg-white; font-family: 'Open Sans', sans-serif; } h1, h2 { font-family: 'Merriweather', serif; } }
    </style>
</head>
<body class="bg-blue-50/50 flex items-center justify-center min-h-screen p-4 overflow-hidden relative">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('../assets/images/kcmit.png'); filter: brightness(0.6);"></div>
    
    <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-2xl p-10 relative z-10 border-t-8 border-blue-600">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 italic font-black text-2xl">
                KCMIT
            </div>
            <h1 class="text-3xl font-black text-gray-900">Student Portal</h1>
            <p class="text-gray-500 text-sm mt-2 font-semibold">Access BIM • BCA • BBA Resources</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-blue-50 text-blue-700 px-4 py-3 rounded-xl mb-6 text-xs border border-blue-100 flex items-center italic">
                <i class="fas fa-exclamation-circle mr-2 opacity-50"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-[0.2em] pl-1">Faculty Username</label>
                <div class="relative">
                    <input name="username" type="text" required class="w-full pl-12 pr-4 py-4 bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-2xl outline-none transition-all placeholder:font-normal" placeholder="e.g. ram_sharma">
                    <i class="fas fa-id-badge absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-[0.2em] pl-1">Security Password</label>
                <div class="relative">
                    <input name="password" type="password" required class="w-full pl-12 pr-4 py-4 bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-2xl outline-none transition-all" placeholder="••••••••">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                </div>
            </div>

            <button type="submit" class="w-full py-5 bg-blue-600 text-white rounded-2xl font-black text-lg hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-200 transition-all">
                Login to Library
            </button>
        </form>

        <div class="mt-8 pt-8 border-t border-gray-100 flex justify-center text-[10px] font-black uppercase tracking-widest">
            <a href="login.php" class="text-gray-400 hover:text-blue-500 transition-colors">
                <i class="fas fa-chevron-left mr-1"></i> Selection Menu
            </a>
        </div>
    </div>
</body>
</html>
