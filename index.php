<?php require_once 'includes/access_control.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KCMIT Library - Knowledge Center for Modern Information Technology</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'uneza-red': '#DC2626',
                        'uneza-dark': '#1F2937',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base {
            body { @apply bg-gray-50; font-family: 'Open Sans', sans-serif; }
            h1, h2, h3 { font-family: 'Merriweather', serif; font-weight: 700; }
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="relative min-h-screen bg-cover bg-center flex items-center" style="background-image: url('assets/images/kcmit.png');">
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/65"></div>
        
        <!-- Content -->
        <div class="relative w-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 md:py-40">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left Side - Text Content -->
                    <div class="lg:col-span-8">
                        <!-- Main Heading -->
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-8 leading-tight">
                            Connecting Knowledge with<br>Discovery and Learning.
                        </h1>
                        
                        <!-- Decorative Border Line -->
                        <div class="flex items-start mb-8">
                            <div class="w-1 bg-white/80 mr-6 self-stretch min-h-[120px]"></div>
                            <div>
                                <!-- Subheading -->
                                <p class="text-lg md:text-xl text-white/95 leading-relaxed max-w-3xl">
                                    Discover endless possibilities with our extensive collection, innovative digital resources, and welcoming spaces. At KCMIT Library, we empower researchers, support lifelong learning, and provide the resources you need to thrive in an information-rich world. Visit us and expand your horizons today!
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Side - Watch Tour Button -->
                    <div class="lg:col-span-4 flex justify-center lg:justify-end">
                        <a href="#" class="inline-flex flex-col items-center justify-center bg-red-600 text-white rounded-full w-40 h-40 hover:bg-red-700 transition-all duration-300 hover:scale-110 group shadow-2xl">
                            <i class="fas fa-play text-4xl mb-3 group-hover:scale-110 transition-transform"></i>
                            <span class="text-base font-semibold">Watch Tour</span>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Content Sections (Optional - You can remove if not needed) -->
    
    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose KCMIT Library?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Explore what makes us a premier destination for research, study, and knowledge discovery.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-8 rounded-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-book text-red-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">World-Class Collection</h3>
                    <p class="text-gray-600 leading-relaxed">Access comprehensive collections and benefit from expert librarians committed to supporting your research and learning goals.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="text-center p-8 rounded-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-laptop text-red-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Digital Innovation</h3>
                    <p class="text-gray-600 leading-relaxed">Explore state-of-the-art digital resources and technologies that enhance your research capabilities and information access.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="text-center p-8 rounded-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-red-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Welcoming Spaces</h3>
                    <p class="text-gray-600 leading-relaxed">Experience comfortable study areas within a diverse and collaborative community of learners, scholars, and knowledge seekers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Blogs Section -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 px-4">
                <div class="max-w-xl">
                    <h2 class="text-4xl font-black text-slate-800 mb-4 tracking-tighter italic uppercase">Library <span class="text-red-600">Insights</span></h2>
                    <p class="text-gray-500 font-semibold leading-relaxed italic">Stay updated with the latest academic stories, research tips, and institutional updates from the KCMIT Blog.</p>
                </div>
                <a href="blog.php" class="mt-6 md:mt-0 px-8 py-4 bg-white border-2 border-slate-100 text-slate-800 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all shadow-sm">Explore All Articles</a>
            </div>

            <?php 
            require_once 'config/db.php';
            $latest_blogs = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC LIMIT 3")->fetchAll();
            ?>

            <div class="grid md:grid-cols-3 gap-10">
                <?php foreach($latest_blogs as $blog): ?>
                <article class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-gray-100 group">
                    <div class="h-56 overflow-hidden relative">
                        <?php if($blog['image_path']): ?>
                            <img src="<?php echo $blog['image_path']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <?php else: ?>
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                <i class="fas fa-image text-3xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-8">
                        <span class="text-[9px] font-black uppercase text-red-600 tracking-[0.2em] mb-4 block italic"><?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
                        <h3 class="text-xl font-black text-slate-800 mb-4 line-clamp-2 leading-tight italic group-hover:text-red-600 transition-colors">
                            <?php echo htmlspecialchars($blog['title']); ?>
                        </h3>
                        <p class="text-sm text-gray-500 font-semibold leading-relaxed line-clamp-2 mb-6">
                            <?php echo strip_tags($blog['content']); ?>
                        </p>
                        <a href="blog.php" class="text-[10px] font-black uppercase tracking-widest text-slate-800 hover:text-red-600 transition-colors flex items-center">
                            Read Story <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
                
                <?php if(empty($latest_blogs)): ?>
                <div class="col-span-3 py-16 text-center bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                    <i class="fas fa-rss text-4xl text-gray-200 mb-4"></i>
                    <p class="text-gray-400 font-bold italic">No stories published yet. Our faculty is preparing insights for you!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Begin Your Research Journey?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">Take the first step towards knowledge discovery. Get your library card today and become part of our vibrant learning community.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/lms/auth/student-login.php" class="inline-block bg-red-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-red-700 transition-colors duration-200 text-lg">
                    Student Login
                </a>
                <a href="/lms/auth/staff-login.php" class="inline-block bg-white text-gray-900 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200 text-lg">
                    Staff Portal
                </a>
            </div>
        </div>
    </section>
       <?php include 'includes/footer.php'; ?>

    <!-- JavaScript for Mobile Menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>

</body>
</html>