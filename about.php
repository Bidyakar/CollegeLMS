<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - KCMIT College Library</title>
    
    <link href="assets/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
    </style>
</head>

<body class="bg-gray-50">

<?php include 'includes/navbar.php'; ?>

<!-- Hero Section -->
<section class="relative h-[60vh] bg-cover bg-center flex items-center" style="background-image: url('assets/images/kcmit.png');">
    <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/50"></div>
    <div class="relative max-w-7xl mx-auto px-6">
        <div class="max-w-3xl">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">About KCMIT College Library</h1>
            <p class="text-xl md:text-2xl text-white/90">
                Empowering knowledge, supporting research, and inspiring lifelong learning.
            </p>
        </div>
    </div>
</section>

<!-- Introduction -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Who We Are</h2>
                <div class="space-y-4 text-gray-700 text-lg leading-relaxed">
                    <p>
                        The KCMIT College Library serves as the academic knowledge hub of the institution, providing students and faculty with access to essential learning and research resources.
                    </p>
                    <p>
                        Our library offers a diverse collection of books, journals, research materials, and digital resources in management, information technology, and related disciplines.
                    </p>
                    <p>
                        With modern catalog systems, digital integration, and a quiet study environment, the library fosters academic excellence and intellectual growth.
                    </p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mt-10 text-center">
                    <div>
                        <div class="text-4xl font-bold text-red-600 mb-2">20,000+</div>
                        <div class="text-sm text-gray-600 font-medium">Books & Resources</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-red-600 mb-2">5,000+</div>
                        <div class="text-sm text-gray-600 font-medium">Active Members</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-red-600 mb-2">100+</div>
                        <div class="text-sm text-gray-600 font-medium">Digital Journals</div>
                    </div>
                </div>
            </div>

            <div>
                <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=800" 
                     alt="KCMIT Library" 
                     class="rounded-lg shadow-2xl">
            </div>

        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Mission & Vision</h2>
            <p class="text-xl text-gray-600">Guiding principles that shape our services</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">

            <div class="bg-white p-8 rounded-lg shadow-lg">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-bullseye text-red-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Our Mission</h3>
                <p class="text-gray-700">
                    To provide accessible, organized, and high-quality academic resources that support student success, research excellence, and lifelong learning.
                </p>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-lg">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-eye text-red-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">Our Vision</h3>
                <p class="text-gray-700">
                    To become a modern academic library that integrates digital innovation and research support to meet evolving educational needs.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Core Values -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold text-gray-900 mb-12">Our Core Values</h2>

        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <i class="fas fa-star text-red-600 text-4xl mb-4"></i>
                <h3 class="font-bold text-xl mb-2">Excellence</h3>
                <p class="text-gray-600">Maintaining high standards in resource management and service.</p>
            </div>

            <div>
                <i class="fas fa-handshake text-red-600 text-4xl mb-4"></i>
                <h3 class="font-bold text-xl mb-2">Integrity</h3>
                <p class="text-gray-600">Promoting responsible and ethical use of information.</p>
            </div>

            <div>
                <i class="fas fa-laptop text-red-600 text-4xl mb-4"></i>
                <h3 class="font-bold text-xl mb-2">Accessibility</h3>
                <p class="text-gray-600">Ensuring inclusive access to physical and digital resources.</p>
            </div>

            <div>
                <i class="fas fa-lightbulb text-red-600 text-4xl mb-4"></i>
                <h3 class="font-bold text-xl mb-2">Innovation</h3>
                <p class="text-gray-600">Continuously improving through modern library technologies.</p>
            </div>
        </div>
    </div>
</section>


<!-- CTA -->
<section class="py-20  text-center" style="background-color:#101826;">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-white mb-6">Explore Knowledge at KCMIT Library</h2>
        <p class="text-white/90 mb-8">
            Access thousands of books, journals, and digital materials to support your academic journey.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="books.php" class="inline-block bg-red-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-red-700 transition-colors duration-200 text-lg">
                Browse Books
            </a>
            <a href="login.php" class="inline-block bg-white text-gray-900 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200 text-lg">
                Login to Library Portal
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

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
