<?php require_once 'includes/access_control.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Programs - KCMIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base {
            body { @apply bg-gray-50; font-family: 'Open Sans', sans-serif; }
            h1, h2, h3 { font-family: 'Merriweather', serif; }
        }
    </style>
</head>
<body class="antialiased text-gray-800">

    <?php include 'includes/navbar.php'; ?>

    <!-- Main Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-24 bg-white">
        <div class="max-w-7xl mx-auto mb-20 text-center">
            <span class="text-blue-600 tracking-widest uppercase font-bold text-xs mb-2 block">Our Offerings</span>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-6">Undergraduate <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-red-600">Programs</span></h1>
            <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed">Choose from our diverse range of programs designed to equip you with the skills needed for the future.</p>
        </div>

        <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-10">

            <!-- Program Card 1 -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-100 hover:shadow-2xl hover:shadow-blue-100 transition-all duration-300 group ring-1 ring-gray-100">
                <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center text-blue-600 text-2xl mb-8 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">BIM / BITM</h3>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Bachelor of Information Management</p>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">A blend of IT and Management courses preparing students for the dynamic business world. Focuses on software engineering, database management, and business strategy.</p>
                
                <div class="space-y-3 mb-8">
                    <div class="flex items-center text-xs font-bold text-gray-400">
                        <i class="fas fa-check text-green-500 mr-2"></i> 4 Years Duration
                    </div>
                    <div class="flex items-center text-xs font-bold text-gray-400">
                        <i class="fas fa-check text-green-500 mr-2"></i> 8 Semesters
                    </div>
                    <div class="flex items-center text-xs font-bold text-gray-400">
                        <i class="fas fa-check text-green-500 mr-2"></i> 126 Credit Hours
                    </div>
                </div>

                <a href="faculty/bim.php" class="block w-full py-4 bg-gray-50 text-slate-800 font-bold text-center rounded-xl hover:bg-blue-600 hover:text-white transition-all text-sm">View Details</a>
            </div>

            <!-- Program Card 2 -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-100 hover:shadow-2xl hover:shadow-red-100 transition-all duration-300 group ring-1 ring-gray-100 transform md:-translate-y-4">
                <div class="bg-red-50 w-16 h-16 rounded-2xl flex items-center justify-center text-red-600 text-2xl mb-8 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-code"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-2 group-hover:text-red-600 transition-colors">BCA</h3>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Bachelor of Computer Applications</p>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">Focuses purely on technical aspects of computer applications. Ideal for students aspiring to become software developers, system analysts, and network administrators.</p>
                
                <div class="space-y-3 mb-8">
                    <div class="flex items-center text-xs font-bold text-gray-400">
                        <i class="fas fa-check text-blue-500 mr-2"></i> 4 Years Duration
                    </div>
                    <div class="flex items-center text-xs font-bold text-gray-400">
                        <i class="fas fa-check text-blue-500 mr-2"></i> Programming Intensive
                    </div>
                    <div class="flex items-center text-xs font-bold text-gray-400">
                        <i class="fas fa-check text-blue-500 mr-2"></i> Project Based Learning
                    </div>
                </div>

                <a href="faculty/bca.php" class="block w-full py-4 bg-gray-50 text-slate-800 font-bold text-center rounded-xl hover:bg-red-600 hover:text-white transition-all text-sm">View Details</a>
            </div>

            <!-- Program Card 3 -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-100 hover:shadow-2xl hover:shadow-blue-100 transition-all duration-300 group ring-1 ring-gray-100">
                <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center text-blue-600 text-2xl mb-8 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">BBA</h3>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Bachelor of Business Administration</p>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">Develops leadership and managerial skills. Covers finance, marketing, HR, and operations to prepare students for corporate roles and entrepreneurship.</p>
                
                <div class="space-y-3 mb-8">
                    <div class="flex items-center text-xs font-bold text-gray-400">
                        <i class="fas fa-check text-green-500 mr-2"></i> 4 Years Duration
                    </div>
                    <div class="flex items-center text-xs font-bold text-gray-400">
                        <i class="fas fa-check text-green-500 mr-2"></i> Case Study Approach
                    </div>
                    <div class="flex items-center text-xs font-bold text-gray-400">
                        <i class="fas fa-check text-green-500 mr-2"></i> Internships Included
                    </div>
                </div>

                <a href="faculty/bba.php" class="block w-full py-4 bg-gray-50 text-slate-800 font-bold text-center rounded-xl hover:bg-blue-600 hover:text-white transition-all text-sm">View Details</a>
            </div>

        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
