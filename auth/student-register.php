<?php
session_start();
require_once '../includes/access_control.php';
require_once '../config/db.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $program = $_POST['program'];
    $semester = $_POST['semester'];
    $contact = $_POST['contact'];

    try {
        // Check if username/email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM student_login WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetchColumn() > 0) {
            $error = "Username or Email already exists!";
        } else {
            // Insert with 'Pending' status
            $stmt = $pdo->prepare("INSERT INTO student_login (username, password, email, firstname, lastname, program, semester, contact, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
            $stmt->execute([$username, $password, $email, $firstname, $lastname, $program, $semester, $contact]);
            $message = "Request submitted successfully! Please wait for Admin approval.";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - KCMIT Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base { body { @apply bg-white; font-family: 'Open Sans', sans-serif; } h1, h2 { font-family: 'Merriweather', serif; } }
    </style>
</head>
<body class="bg-blue-50/50 flex items-center justify-center min-h-screen p-4 overflow-hidden relative">
    <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('../assets/images/kcmit.png'); filter: blur(4px);"></div>
    
    <div class="w-full max-w-2xl bg-white rounded-[2.5rem] shadow-2xl p-10 relative z-10 border-t-8 border-blue-600">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-gray-900">Create Account</h1>
            <p class="text-gray-500 text-sm mt-2">Request access to the KCMIT Digital Library</p>
        </div>

        <?php if ($message): ?>
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm border border-green-100 flex items-center italic">
                <i class="fas fa-check-circle mr-2"></i> <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="bg-red-50 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm border border-red-100 flex items-center italic">
                <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest pl-1">First Name</label>
                    <input name="firstname" type="text" required class="w-full px-4 py-3 bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-xl outline-none" placeholder="e.g. Ram">
                </div>
                <div>
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest pl-1">Last Name</label>
                    <input name="lastname" type="text" required class="w-full px-4 py-3 bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-xl outline-none" placeholder="e.g. Sharma">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest pl-1">Faculty / Program</label>
                    <select name="program" class="w-full px-4 py-3 bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-xl outline-none font-bold">
                        <option value="BIM">BIM / BITM</option>
                        <option value="BBA">BBA</option>
                        <option value="BCA">BCA</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest pl-1">Current Semester</label>
                    <input name="semester" type="number" min="1" max="8" required class="w-full px-4 py-3 bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-xl outline-none" placeholder="1">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest pl-1">Username</label>
                    <input name="username" type="text" required class="w-full px-4 py-3 bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-xl outline-none" placeholder="ram123">
                </div>
                <div>
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest pl-1">Password</label>
                    <input name="password" type="password" required class="w-full px-4 py-3 bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-xl outline-none" placeholder="••••••••">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest pl-1">Email</label>
                    <input name="email" type="email" required class="w-full px-4 py-3 bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-xl outline-none" placeholder="ram@example.com">
                </div>
                <div>
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest pl-1">Contact No.</label>
                    <input name="contact" type="text" required class="w-full px-4 py-3 bg-gray-50 border-0 focus:ring-2 focus:ring-blue-500 rounded-xl outline-none" placeholder="98XXXXXXXX">
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black text-lg hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                Submit Request
            </button>
        </form>

        <div class="mt-8 text-center text-xs font-bold uppercase tracking-widest">
            <a href="login.php" class="text-gray-400 hover:text-blue-500 transition-colors">
                <i class="fas fa-chevron-left mr-1"></i> Already requested? Login
            </a>
        </div>
    </div>
</body>
</html>
