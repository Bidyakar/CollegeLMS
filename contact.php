<?php 
session_start();
require_once 'includes/access_control.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - KCMIT Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; background: #fafbfc; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
    </style>
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="bg-slate-900 text-white py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-red-600 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-600 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-5xl lg:text-6xl font-black mb-6 tracking-tighter uppercase">Connect With Us</h1>
            <p class="text-xl text-gray-400 font-bold max-w-2xl mx-auto">Have questions? Reach out to the KCMIT Library team for assistance with resources, accounts, or research.</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid lg:grid-cols-2 gap-16">
            
            <!-- Contact Info -->
            <div class="space-y-12">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 mb-8 uppercase tracking-tight">Contact Information</h2>
                    <div class="grid sm:grid-cols-2 gap-8">
                        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                            <div class="h-12 w-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-600 group-hover:text-white transition-all">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 mb-2">Location</h3>
                            <p class="text-sm text-gray-500 leading-relaxed font-semibold">Mid-Baneshwor, Kathmandu<br>Nepal</p>
                        </div>
                        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                            <div class="h-12 w-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                <i class="fas fa-phone-alt text-xl"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 mb-2">Call Us</h3>
                            <p class="text-sm text-gray-500 leading-relaxed font-semibold">+977-1-4479685<br>+977-1-4479686</p>
                        </div>
                        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                            <div class="h-12 w-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 mb-2">Email</h3>
                            <p class="text-sm text-gray-500 leading-relaxed font-semibold">info@kcmit.edu.np<br>library@kcmit.edu.np</p>
                        </div>
                        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                            <div class="h-12 w-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-600 group-hover:text-white transition-all">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 mb-2">Library Hours</h3>
                            <p class="text-sm text-gray-500 leading-relaxed font-semibold">Sun - Fri: 9:00 AM - 3:00 PM<br>Sat: Closed</p>
                        </div>
                    </div>
                </div>

                <!-- Map Placeholder -->
                <div class="h-80 w-full bg-slate-100 rounded-[2.5rem] relative overflow-hidden group shadow-inner border-4 border-white">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.6082528386896!2d85.33812657508042!3d27.698500276187616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb199bc3725273%3A0x2237abfde1ac9646!2sKantipur%20College%20of%20Management%20and%20Information%20Technology!5e0!3m2!1sen!2snp!4v1771566320322!5m2!1sen!2snp" 
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white p-12 rounded-[3.5rem] shadow-xl shadow-slate-200/50 border border-gray-100 flex flex-col h-fit">
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-3xl font-black text-slate-800 mb-2 uppercase tracking-tight">Send a Message</h2>
                    <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">Our team will get back to you within 24 hours.</p>
                </div>
                <form action="#" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest px-2">Full Name</label>
                            <input type="text" placeholder="John Doe" class="w-full bg-slate-50 p-4 rounded-2xl outline-none focus:ring-4 focus:ring-red-100 focus:bg-white transition-all font-bold text-slate-700">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest px-2">Email Address</label>
                            <input type="email" placeholder="john@example.com" class="w-full bg-slate-50 p-4 rounded-2xl outline-none focus:ring-4 focus:ring-red-100 focus:bg-white transition-all font-bold text-slate-700">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest px-2">Subject</label>
                        <select class="w-full bg-slate-50 p-4 rounded-2xl outline-none focus:ring-4 focus:ring-red-100 focus:bg-white transition-all font-bold text-slate-700 appearance-none">
                            <option>General Inquiry</option>
                            <option>Resource Request</option>
                            <option>Account Support</option>
                            <option>Technical Issue</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest px-2">Message</label>
                        <textarea rows="6" placeholder="How can we help you today?" class="w-full bg-slate-50 p-6 rounded-2xl outline-none focus:ring-4 focus:ring-red-100 focus:bg-white transition-all font-bold text-slate-700 leading-relaxed"></textarea>
                    </div>
                    <button type="submit" class="w-full py-5 bg-red-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-slate-900 transition-all shadow-xl shadow-red-200 hover:shadow-slate-200">
                        Deliver Message
                    </button>
                </form>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
