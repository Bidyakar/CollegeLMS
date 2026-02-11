<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - KCMIT</title>
    
    <!-- Tailwind CSS -->
    <link href="assets/style.css" rel="stylesheet">
    
    <!-- Font Awesome -->
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
    
    <!-- Include Navigation -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="relative h-[60vh] bg-cover bg-center flex items-center" style="background-image: url('assets/images/kcmit.png');">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/50"></div>
        <div class="relative max-w-7xl mx-auto ">
            <div class="max-w-3xl ">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">About KCMIT</h1>
                <p class="text-xl md:text-2xl text-white/90">
                    Shaping minds, building futures, and creating leaders for tomorrow's world.
                </p>
            </div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Who We Are</h2>
                    <div class="space-y-4 text-gray-700 text-lg leading-relaxed">
                        <p>
                            The Kantipur College of Management and Information Technology (KCMIT) stands as a beacon of academic excellence and innovation. Founded with a vision to transform lives through education, we have been at the forefront of higher education for decades.
                        </p>
                        <p>
                            Our institution is dedicated to fostering intellectual curiosity, critical thinking, and a passion for lifelong learning. We believe in empowering our students with the knowledge, skills, and values needed to thrive in an ever-changing global landscape.
                        </p>
                        <p>
                            With state-of-the-art facilities, renowned faculty, and a vibrant campus community, KCMIT provides an environment where students can explore, innovate, and excel.
                        </p>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-10">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-red-600 mb-2">25+</div>
                            <div class="text-sm text-gray-600 font-medium">Years of Excellence</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-red-600 mb-2">15K+</div>
                            <div class="text-sm text-gray-600 font-medium">Students Enrolled</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-red-600 mb-2">500+</div>
                            <div class="text-sm text-gray-600 font-medium">Expert Faculty</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Image -->
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=800" alt="KCMIT Campus" class="rounded-lg shadow-2xl">
                    <div class="absolute -bottom-6 -left-6 w-64 h-64 bg-red-600 rounded-lg -z-10"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Mission & Vision</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Guiding principles that drive everything we do
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Mission -->
                <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-red-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
                    <p class="text-gray-700 leading-relaxed">
                        To provide transformative education that empowers students to become ethical leaders, innovative thinkers, and responsible global citizens. We are committed to excellence in teaching, research, and community engagement, fostering an inclusive environment where diverse perspectives are valued and intellectual growth is encouraged.
                    </p>
                </div>
                
                <!-- Vision -->
                <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-red-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                    <p class="text-gray-700 leading-relaxed">
                        To be a globally recognized institution of higher learning that drives innovation, advances knowledge, and creates positive social impact. We aspire to cultivate a community of scholars and leaders who shape the future through groundbreaking research, creative expression, and dedicated service to humanity.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Core Values</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    The foundation of our academic community
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Value 1 -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-star text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Excellence</h3>
                    <p class="text-gray-600">
                        We pursue the highest standards in everything we do, from teaching to research to student support.
                    </p>
                </div>
                
                <!-- Value 2 -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-handshake text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Integrity</h3>
                    <p class="text-gray-600">
                        We uphold the highest ethical standards and foster a culture of honesty and accountability.
                    </p>
                </div>
                
                <!-- Value 3 -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-lightbulb text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Innovation</h3>
                    <p class="text-gray-600">
                        We encourage creative thinking and embrace new ideas that drive progress and positive change.
                    </p>
                </div>
                
                <!-- Value 4 -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Inclusivity</h3>
                    <p class="text-gray-600">
                        We celebrate diversity and create an environment where all voices are heard and respected.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- History Timeline Section -->
    <section class="py-20 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Our Journey</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Decades of growth, achievement, and impact
                </p>
            </div>
            
            <div class="space-y-12">
                <!-- Timeline Item 1 -->
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="md:w-1/4">
                        <div class="text-5xl font-bold text-red-500">1970</div>
                    </div>
                    <div class="md:w-3/4">
                        <h3 class="text-2xl font-bold mb-3">Foundation</h3>
                        <p class="text-gray-300 leading-relaxed">
                            KCMIT was founded with a vision to provide accessible, quality education to students from all backgrounds. Starting with just 200 students and a handful of programs.
                        </p>
                    </div>
                </div>
                
                <!-- Timeline Item 2 -->
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="md:w-1/4">
                        <div class="text-5xl font-bold text-red-500">2000</div>
                    </div>
                    <div class="md:w-3/4">
                        <h3 class="text-2xl font-bold mb-3">Research Excellence</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Established as the poineer collage for BIM in Nepal that offers IT and Management skills to the students along with the BBA program </p>
                    </div>
                </div>
                
                <!-- Timeline Item 3 -->
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="md:w-1/4">
                        <div class="text-5xl font-bold text-red-500">2000</div>
                    </div>
                    <div class="md:w-3/4">
                        <h3 class="text-2xl font-bold mb-3">Global Expansion</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Launched international partnerships and exchange programs, welcoming students from over 50 countries and establishing ourselves as a global institution.
                        </p>
                    </div>
                </div>
                
                <!-- Timeline Item 4 -->
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="md:w-1/4">
                        <div class="text-5xl font-bold text-red-500">2020</div>
                    </div>
                    <div class="md:w-3/4">
                        <h3 class="text-2xl font-bold mb-3">Digital Transformation</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Embraced cutting-edge technology and digital learning platforms, ensuring our students have access to world-class education regardless of location.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Team Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Leadership</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Meet the visionaries guiding KCMIT into the future
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Leader 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <div class="h-64 bg-gray-300 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400" alt="President" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Dr. James Anderson</h3>
                        <p class="text-red-600 font-medium mb-3">University President</p>
                        <p class="text-gray-600 text-sm">
                            Leading KCMIT with vision and dedication to academic excellence and student success.
                        </p>
                    </div>
                </div>
                
                <!-- Leader 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <div class="h-64 bg-gray-300 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400" alt="Provost" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Dr. Sarah Mitchell</h3>
                        <p class="text-red-600 font-medium mb-3">Provost & Chief Academic Officer</p>
                        <p class="text-gray-600 text-sm">
                            Overseeing academic programs and ensuring the highest standards of teaching and learning.
                        </p>
                    </div>
                </div>
                
                <!-- Leader 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <div class="h-64 bg-gray-300 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400" alt="Dean" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Dr. Michael Chen</h3>
                        <p class="text-red-600 font-medium mb-3">Dean of Research</p>
                        <p class="text-gray-600 text-sm">
                            Driving innovation and research excellence across all disciplines and departments.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Accreditation Section -->
    <section class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Accreditations & Recognition</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Proudly recognized by leading educational bodies worldwide
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
                <div class="bg-white p-8 rounded-lg text-center shadow">
                    <i class="fas fa-award text-red-600 text-5xl mb-3"></i>
                    <p class="text-sm font-semibold text-gray-700">Nationally Accredited</p>
                </div>
                <div class="bg-white p-8 rounded-lg text-center shadow">
                    <i class="fas fa-globe text-red-600 text-5xl mb-3"></i>
                    <p class="text-sm font-semibold text-gray-700">International Recognition</p>
                </div>
                <div class="bg-white p-8 rounded-lg text-center shadow">
                    <i class="fas fa-certificate text-red-600 text-5xl mb-3"></i>
                    <p class="text-sm font-semibold text-gray-700">Quality Assured</p>
                </div>
                <div class="bg-white p-8 rounded-lg text-center shadow">
                    <i class="fas fa-medal text-red-600 text-5xl mb-3"></i>
                    <p class="text-sm font-semibold text-gray-700">Top Ranked</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-red-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Join Our Community?</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Discover how KCMIT can help you achieve your academic and professional goals.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="admissions.php" class="inline-block bg-white text-red-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200 text-lg">
                    Apply Now
                </a>
                <a href="campus.php" class="inline-block bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-red-600 transition-colors duration-200 text-lg">
                    Visit Campus
                </a>
            </div>
        </div>
    </section>

    <!-- Include Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript -->
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