<?php require_once 'includes/access_control.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academics - KCMIT</title>
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

    <!-- Hero Section -->
    <div class="relative bg-slate-900 text-white pt-32 pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <span class="inline-block py-1 px-3 rounded-full bg-red-600/20 text-red-400 text-xs font-bold uppercase tracking-widest mb-4 border border-red-600/30">Excellence in Education</span>
            <h1 class="text-5xl md:text-6xl font-black mb-6 leading-tight">Academic Excellence</h1>
            <p class="text-xl text-slate-300 max-w-2xl font-light leading-relaxed">Fostering a culture of critical thinking, innovation, and lifelong learning through our comprehensive academic programs.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        
        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-24 border-b border-gray-200 pb-12">
            <div class="text-center group hover:-translate-y-2 transition-transform duration-300">
                <div class="text-4xl font-black text-slate-900 mb-2 group-hover:text-red-600 transition-colors">20+</div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Years of History</div>
            </div>
            <div class="text-center group hover:-translate-y-2 transition-transform duration-300">
                <div class="text-4xl font-black text-slate-900 mb-2 group-hover:text-red-600 transition-colors">1500+</div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Graduates</div>
            </div>
            <div class="text-center group hover:-translate-y-2 transition-transform duration-300">
                <div class="text-4xl font-black text-slate-900 mb-2 group-hover:text-red-600 transition-colors">50+</div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Faculty Members</div>
            </div>
            <div class="text-center group hover:-translate-y-2 transition-transform duration-300">
                <div class="text-4xl font-black text-slate-900 mb-2 group-hover:text-red-600 transition-colors">100%</div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Commitment</div>
            </div>
        </div>

        <!-- Academic Philosophy -->
        <div class="grid md:grid-cols-2 gap-16 items-center mb-24">
            <div>
                <h2 class="text-3xl font-black text-slate-900 mb-6 relative pl-6 before:content-[''] before:absolute before:left-0 before:top-2 before:w-1 before:h-8 before:bg-red-600">Our Philosophy</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    At KCMIT, we believe that education extends beyond the classroom. Our academic philosophy is rooted in the combination of theoretical knowledge and practical application. We strive to create an environment where students are challenged to think critically and solve complex problems.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Our curriculum is constantly updated to meet the demands of the modern industry, ensuring that our graduates are not just degree holders, but ready-to-work professionals.
                </p>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 bg-red-100 rounded-[2.5rem] transform rotate-3 scale-95 opacity-50"></div>
                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Students learning" class="relative rounded-[2rem] shadow-2xl">
            </div>
        </div>

        <!-- Features Grid -->
        <div class="bg-white rounded-[3rem] p-12 shadow-sm border border-gray-100 mb-24">
            <h2 class="text-3xl font-black text-center text-slate-900 mb-16">Why Choose KCMIT Academics?</h2>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="space-y-4">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3 class="text-xl font-bold text-slate-900">Expert Faculty</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Learn from industry veterans and academic experts who bring real-world experience into the classroom.</p>
                </div>
                <div class="space-y-4">
                    <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-2xl mb-6"><i class="fas fa-laptop-code"></i></div>
                    <h3 class="text-xl font-bold text-slate-900">Modern Labs</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">State-of-the-art computer labs and research facilities designed to foster innovation and practical skills.</p>
                </div>
                <div class="space-y-4">
                    <div class="w-14 h-14 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center text-2xl mb-6"><i class="fas fa-handshake"></i></div>
                    <h3 class="text-xl font-bold text-slate-900">Industry Links</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Strong partnerships with leading tech companies providing internship and placement opportunities.</p>
                </div>
            </div>
        </div>

    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
