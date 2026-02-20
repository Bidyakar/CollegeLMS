<?php require_once 'includes/access_control.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admissions - KCMIT</title>
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

    <!-- Header -->
    <div class="relative bg-slate-900 text-white min-h-[500px] flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-800 to-transparent z-10 w-3/4"></div>
        <div class="absolute inset-0 bg-cover bg-right" style="background-image: url('https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full pt-16">
            <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight">Join Our <br><span class="text-blue-400 italic">Community</span></h1>
            <p class="text-xl text-slate-100 max-w-xl font-light mb-10 leading-relaxed">Begin your journey towards excellence. Apply today and become part of a legacy of innovation and leadership.</p>
            <div class="flex space-x-4">
                <a href="#apply" class="bg-red-600 text-white px-8 py-4 rounded-full font-bold text-sm hover:scale-105 transition-transform shadow-lg shadow-red-900/50">Apply Now</a>
                <a href="#requirements" class="bg-white/10 backdrop-blur-sm text-white border border-white/20 px-8 py-4 rounded-full font-bold text-sm hover:bg-white/20 transition-all">Learn More</a>
            </div>
        </div>
    </div>

    <!-- Steps -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 -mt-20 relative z-30">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-gray-200/50 hover:-translate-y-2 transition-transform duration-500 group">
                <div class="text-6xl font-black text-gray-100 mb-6 group-hover:text-blue-100 transition-colors">01</div>
                <h3 class="text-2xl font-black text-slate-800 mb-4">Check Eligibility</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Review the academic requirements for your desired program. Ensure you meet the minimum GPA and subject prerequisites.</p>
            </div>
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-gray-200/50 hover:-translate-y-2 transition-transform duration-500 group delay-100">
                <div class="text-6xl font-black text-gray-100 mb-6 group-hover:text-red-100 transition-colors">02</div>
                <h3 class="text-2xl font-black text-slate-800 mb-4">Submit Application</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Fill out the online application form. Upload necessary documents including transcripts and identification.</p>
            </div>
            <div class="bg-red-600 p-10 rounded-[2.5rem] shadow-xl shadow-red-200/50 hover:-translate-y-2 transition-transform duration-500 text-white transform md:scale-105">
                <div class="text-6xl font-black text-red-400 mb-6">03</div>
                <h3 class="text-2xl font-black mb-4">Entrance Exam</h3>
                <p class="text-red-50 text-sm leading-relaxed">Take the college entrance examination. Successful candidates will be interviewed before final selection.</p>
            </div>
        </div>
    </div>

    <!-- Application Form Section -->
    <div id="apply" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="bg-white rounded-[3rem] p-12 md:p-20 shadow-2xl border border-gray-100">
            <div class="text-center mb-16">
                <span class="text-red-600 font-bold tracking-widest uppercase text-xs">Start Your Future</span>
                <h2 class="text-4xl font-black text-slate-900 mt-2">Application Inquiry</h2>
            </div>
            
            <form class="space-y-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 tracking-widest ml-1">Full Name</label>
                        <input type="text" class="w-full bg-gray-50 border-0 rounded-2xl p-4 text-slate-800 focus:ring-2 focus:ring-blue-500 transition-all font-semibold" placeholder="John Doe">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 tracking-widest ml-1">Email Address</label>
                        <input type="email" class="w-full bg-gray-50 border-0 rounded-2xl p-4 text-slate-800 focus:ring-2 focus:ring-blue-500 transition-all font-semibold" placeholder="john@example.com">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 tracking-widest ml-1">Desired Program</label>
                        <select class="w-full bg-gray-50 border-0 rounded-2xl p-4 text-slate-800 focus:ring-2 focus:ring-blue-500 transition-all font-semibold appearance-none">
                            <option>BIM / BITM</option>
                            <option>BCA</option>
                            <option>BBA</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400 tracking-widest ml-1">Phone Number</label>
                        <input type="text" class="w-full bg-gray-50 border-0 rounded-2xl p-4 text-slate-800 focus:ring-2 focus:ring-blue-500 transition-all font-semibold" placeholder="+977 98XXXXXXXX">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase text-gray-400 tracking-widest ml-1">Message / Query</label>
                    <textarea class="w-full bg-gray-50 border-0 rounded-2xl p-4 text-slate-800 focus:ring-2 focus:ring-blue-500 transition-all font-semibold h-32" placeholder="Tell us about yourself..."></textarea>
                </div>

                <button type="button" class="w-full bg-slate-900 text-white font-black py-5 rounded-2xl text-lg hover:bg-slate-800 transition-all transform hover:scale-[1.01] shadow-xl shadow-slate-200">Submit Application Request</button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
