<?php require_once 'includes/access_control.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - KCMIT</title>
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

    <!-- Hero Section -->
    <div class="relative bg-slate-900 text-white min-h-[60vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('https://images.unsplash.com/photo-1541829070764-84a7d30ddb93?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full pt-20 text-center">
            <span class="inline-block py-1 px-4 rounded-full bg-red-600/20 text-red-400 text-xs font-bold uppercase tracking-[0.2em] mb-6 border border-red-600/30">Est. 2000</span>
            <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight">Empowering <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-blue-600">Generations</span></h1>
            <p class="text-xl text-slate-300 max-w-2xl mx-auto font-light leading-relaxed">
                More than just a college, KCMIT is a community dedicated to academic excellence, innovation, and holistic development.
            </p>
        </div>
    </div>

    <!-- Our Story Section -->
    <div class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-red-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                <img src="https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Campus Life" class="relative rounded-[2.5rem] shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
                <div class="absolute -bottom-10 right-10 bg-white p-6 rounded-2xl shadow-xl max-w-xs hidden md:block">
                    <p class="text-sm font-bold text-gray-800 italic">"Education is the most powerful weapon which you can use to change the world."</p>
                    <p class="text-xs text-red-600 font-bold mt-2 uppercase tracking-wide">- Nelson Mandela</p>
                </div>
            </div>
            
            <div>
                <h2 class="text-4xl font-black text-slate-900 mb-6 relative pl-6 before:content-[''] before:absolute before:left-0 before:top-2 before:w-1 before:h-8 before:bg-red-600">Our Heritage</h2>
                <p class="text-lg text-gray-500 mb-6 leading-relaxed font-medium">
                    Kantipur College of Management and Information Technology (KCMIT) has been a pioneer in quality education since its inception.
                </p>
                <p class="text-gray-500 mb-6 leading-relaxed">
                    Affiliated with Tribhuvan University, KCMIT bridges the gap between academic theory and practical application. Our library stands as the intellectual heart of this institution, providing resources that fuel discovery and foster a culture of research.
                </p>
                <p class="text-gray-500 leading-relaxed mb-8">
                    We are committed to nurturing critical thinkers and ethical leaders who are prepared to tackle the challenges of the modern world.
                </p>
                
                <div class="grid grid-cols-3 gap-6 pt-8 border-t border-gray-100">
                    <div>
                        <div class="text-3xl font-black text-slate-900 mb-1">20+</div>
                        <div class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Years of Excellence</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-slate-900 mb-1">1500+</div>
                        <div class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Alumni Network</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-slate-900 mb-1">50+</div>
                        <div class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Industry Partners</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission & Vision Cards -->
    <div class="bg-slate-50 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-red-600 font-bold tracking-widest uppercase text-xs">Our Purpose</span>
                <h2 class="text-4xl font-black text-slate-900 mt-2">Mission & Vision</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-gray-200 hover:-translate-y-2 transition-transform duration-300 group">
                    <div class="w-16 h-16 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-4">Our Mission</h3>
                    <p class="text-gray-500 leading-relaxed">To provide a dynamic learning environment that fosters intellectual growth, ethical leadership, and professional competence through quality education and research.</p>
                </div>
                
                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-gray-200 hover:-translate-y-2 transition-transform duration-300 group delay-100">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i class="fas fa-binoculars"></i> <!-- Changed from fa-telescope -->
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-4">Our Vision</h3>
                    <p class="text-gray-500 leading-relaxed">To be a leading institution recognized for academic excellence, innovation, and social responsibility, producing globally competitive graduates.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Values -->
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-slate-900">Core Values</h2>
                <div class="w-20 h-1 bg-red-600 mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center p-6 rounded-3xl hover:bg-gray-50 transition-colors">
                    <div class="w-16 h-16 mx-auto bg-red-50 text-red-600 rounded-full flex items-center justify-center text-2xl mb-4">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Excellence</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Striving for the highest standards in all endeavors.</p>
                </div>
                
                <div class="text-center p-6 rounded-3xl hover:bg-gray-50 transition-colors">
                    <div class="w-16 h-16 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl mb-4">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Integrity</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Upholding honesty, transparency, and ethical conduct.</p>
                </div>

                <div class="text-center p-6 rounded-3xl hover:bg-gray-50 transition-colors">
                    <div class="w-16 h-16 mx-auto bg-red-50 text-red-600 rounded-full flex items-center justify-center text-2xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Inclusivity</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Creating a welcoming environment for vital diversity.</p>
                </div>

                <div class="text-center p-6 rounded-3xl hover:bg-gray-50 transition-colors">
                    <div class="w-16 h-16 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl mb-4">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Innovation</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Embracing creativity and new ideas for problem solving.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-slate-900 py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-6">Ready to Join Our Community?</h2>
            <p class="text-slate-400 mb-10 text-lg">Discover the opportunities waiting for you at KCMIT.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="admissions.php" class="bg-red-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-red-700 transition-all shadow-lg shadow-red-900/40">Apply Now</a>
                <a href="contact.php" class="bg-white/10 text-white px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition-all backdrop-blur-sm">Contact Us</a>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
