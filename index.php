<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KCMIT - Knowledge Center for Modern Information Technology</title>
    <!-- Tailwind CSS -->
    <link href="assets/style.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        h1, h2, h3 {
            font-family: 'Merriweather', serif;
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
                            Bridging Knowledge with<br>Real-World Impact.
                        </h1>
                        
                        <!-- Decorative Border Line -->
                        <div class="flex items-start mb-8">
                            <div class="w-1 bg-white/80 mr-6 self-stretch min-h-[120px]"></div>
                            <div>
                                <!-- Subheading -->
                                <p class="text-lg md:text-xl text-white/95 leading-relaxed max-w-3xl">
                                    Unlock your potential with world-class education, innovative research, and a vibrant community. At KCMIT University, we inspire leaders, foster innovation, and prepare you for success in a rapidly evolving world. Join us and shape your future today!
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
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose KCMIT?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Discover what makes us a leading institution for higher education and research excellence.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-8 rounded-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-graduation-cap text-red-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">World-Class Education</h3>
                    <p class="text-gray-600 leading-relaxed">Access top-tier programs and learn from renowned faculty members dedicated to your success.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="text-center p-8 rounded-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-flask text-red-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Innovative Research</h3>
                    <p class="text-gray-600 leading-relaxed">Engage in cutting-edge research that shapes the future and makes a global impact.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="text-center p-8 rounded-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-red-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Vibrant Community</h3>
                    <p class="text-gray-600 leading-relaxed">Join a diverse and supportive community of learners, leaders, and innovators.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Start Your Journey?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">Take the first step towards a brighter future. Apply now and become part of our thriving community.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="inline-block bg-red-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-red-700 transition-colors duration-200 text-lg">
                    Apply Now
                </a>
                <a href="#" class="inline-block bg-white text-gray-900 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200 text-lg">
                    Request Information
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