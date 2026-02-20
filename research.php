<?php require_once 'includes/access_control.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research & Innovation - KCMIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base {
            body { @apply bg-white; font-family: 'Open Sans', sans-serif; }
            h1, h2, h3 { font-family: 'Merriweather', serif; }
        }
    </style>
</head>
<body class="antialiased text-gray-800">

    <?php include 'includes/navbar.php'; ?>

    <!-- Main Content -->
    <div class="relative bg-slate-900 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-slate-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <span class="inline-block py-1 px-3 rounded-full bg-red-900 text-red-400 text-xs font-bold uppercase tracking-widest mb-4 border border-red-800">Innovation Hub</span>
                        <h1 class="text-4xl tracking-tight font-black text-white sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Pushing boundaries</span>
                            <span class="block text-blue-400 xl:inline">through research.</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Our research initiatives aim to solve real-world problems through technology and management science. Join us in shaping the future.
                        </p>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-slate-800">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full opacity-60 mix-blend-overlay" src="https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Research Lab">
        </div>
    </div>

    <!-- Research Areas -->
    <div class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-black text-slate-900">Key Research Areas</h2>
                <p class="mt-4 text-gray-500 max-w-2xl mx-auto">Exploring the frontiers of knowledge across multiple disciplines.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex items-start space-x-6 hover:shadow-xl transition-shadow group">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex-shrink-0 flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i class="fas fa-brain"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Artificial Intelligence</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Developing intelligent systems for healthcare diagnosis, natural language processing, and automated decision making.</p>
                        <a href="#" class="inline-block mt-4 text-xs font-bold text-blue-600 uppercase tracking-widest hover:underline">View Papers &rarr;</a>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex items-start space-x-6 hover:shadow-xl transition-shadow group">
                    <div class="w-16 h-16 bg-red-50 text-red-600 rounded-2xl flex-shrink-0 flex items-center justify-center text-2xl group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Sustainable Business</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Researching green business models and sustainable supply chain management practices for the modern economy.</p>
                        <a href="#" class="inline-block mt-4 text-xs font-bold text-red-600 uppercase tracking-widest hover:underline">View Papers &rarr;</a>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex items-start space-x-6 hover:shadow-xl transition-shadow group">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex-shrink-0 flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Cybersecurity</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Investigating network vulnerabilities and developing robust protocols to secure digital infrastructure and data privacy.</p>
                        <a href="#" class="inline-block mt-4 text-xs font-bold text-blue-600 uppercase tracking-widest hover:underline">View Papers &rarr;</a>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex items-start space-x-6 hover:shadow-xl transition-shadow group">
                    <div class="w-16 h-16 bg-red-50 text-red-600 rounded-2xl flex-shrink-0 flex items-center justify-center text-2xl group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Data Science</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Extracting insights from big data to solve complex social and economic problems through predictive analytics.</p>
                        <a href="#" class="inline-block mt-4 text-xs font-bold text-red-600 uppercase tracking-widest hover:underline">View Papers &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
