<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KCMIT Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base {
            body { @apply bg-white; font-family: 'Open Sans', sans-serif; }
            h1, h2, h3 { font-family: 'Merriweather', serif; }
        }
        .login-card { @apply transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl cursor-pointer; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Abstract Background Decorations -->
    <div class="absolute top-[-10%] left-[-5%] w-[40%] h-[40%] bg-red-100 rounded-full blur-[120px] opacity-60"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[40%] h-[40%] bg-blue-100 rounded-full blur-[120px] opacity-60"></div>

    <div class="max-w-4xl w-full relative z-10">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4 tracking-tight">Welcome Back</h1>
            <p class="text-gray-600 text-lg">Select your portal to continue to the KCMIT Library System</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Student Portal Option -->
            <a href="student-login.php" class="login-card group bg-white border border-gray-100 p-10 rounded-[2.5rem] shadow-xl hover:border-blue-200">
                <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-user-graduate text-4xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Student Portal</h2>
                <p class="text-gray-500 leading-relaxed mb-6">Access your borrowed books, library history, and digital resources.</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-blue-600 font-bold group-hover:underline">
                        <span>Student Login</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                    <a href="student-register.php" class="text-[10px] font-black uppercase text-gray-400 hover:text-blue-500 tracking-tighter">Create Account</a>
                </div>
            </a>

            <!-- Staff Portal Option -->
            <a href="staff-login.php" class="login-card group bg-white border border-gray-100 p-10 rounded-[2.5rem] shadow-xl hover:border-red-200">
                <div class="w-20 h-20 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-user-shield text-4xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Staff Portal</h2>
                <p class="text-gray-500 leading-relaxed mb-6">Administrative access for librarians and faculty members.</p>
                <div class="flex items-center text-red-600 font-bold">
                    <span>Staff Login</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </a>
        </div>

        <div class="text-center mt-12">
            <a href="../index.php" class="text-gray-400 hover:text-gray-900 transition-colors font-medium">
                <i class="fas fa-chevron-left mr-2"></i> Back to Homepage
            </a>
        </div>
    </div>
</body>
</html>
