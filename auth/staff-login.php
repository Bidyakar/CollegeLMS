<?php
session_start();
require_once '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && ($password === $user['password'] || password_verify($password, $user['password']))) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['firstname'] . ' ' . $user['lastname'];
            $_SESSION['role'] = 'admin'; 
            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials for Staff Access.";
        }
    } catch (PDOException $e) { $error = "System Error: " . $e->getMessage(); }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - KCMIT Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base { body { @apply bg-white; font-family: 'Open Sans', sans-serif; } h1, h2 { font-family: 'Merriweather', serif; } }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 overflow-hidden relative">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('../assets/images/kcmit.png'); filter: brightness(0.4);"></div>
    
    <div class="w-full max-w-4xl grid md:grid-cols-2 bg-white rounded-[2.5rem] shadow-2xl overflow-hidden relative z-10">
        <div class="hidden md:flex bg-red-600 p-12 flex-col justify-between text-white">
            <div>
                <h2 class="text-3xl font-black mb-4 tracking-tighter">KCMIT Staff</h2>
                <div class="w-16 h-1 bg-white/30 rounded-full mb-6"></div>
                <p class="text-red-50 text-lg italic opacity-90 leading-relaxed uppercase text-xs font-bold tracking-widest">
                    "Elevating Academic Standards Through Better Management."
                </p>
            </div>
            <div class="space-y-4">
                <div class="flex items-center space-x-3 text-sm">
                    <i class="fas fa-shield-check text-red-300"></i>
                    <span>Authorized Personnel Access</span>
                </div>
            </div>
        </div>

        <div class="p-10 md:p-14">
            <div class="mb-10">
                <h1 class="text-3xl font-black text-gray-900 mb-2">Staff Portal</h1>
                <p class="text-gray-500 text-sm">Enter credentials to enter dashboard</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-50 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm border border-red-100 flex items-center italic">
                    <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest pl-1">Username</label>
                    <input name="username" type="text" required class="w-full px-4 py-4 bg-gray-50 border-0 focus:ring-2 focus:ring-red-500 rounded-2xl outline-none transition-all placeholder:text-gray-300 font-semibold" placeholder="e.g. admin">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest pl-1">Password</label>
                    <input name="password" type="password" required class="w-full px-4 py-4 bg-gray-50 border-0 focus:ring-2 focus:ring-red-500 rounded-2xl outline-none transition-all placeholder:text-gray-300 font-semibold" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full py-5 bg-red-600 text-white rounded-2xl font-black text-lg hover:bg-red-700 transition-all shadow-lg shadow-red-100">
                    Enter Dashboard
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="login.php" class="text-xs font-bold text-gray-400 hover:text-red-600 tracking-widest uppercase"><i class="fas fa-chevron-left mr-1"></i> Switch Portal</a>
            </div>
        </div>
    </div>
</body>
</html>
