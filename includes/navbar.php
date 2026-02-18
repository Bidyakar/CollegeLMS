<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_role = $_SESSION['role'] ?? null;
$is_logged_in = isset($_SESSION['user_id']);
?>

<!-- Navigation Bar Component -->
<nav class="bg-white/95 backdrop-blur-sm shadow-md fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Logo Section -->
            <div class="flex items-center space-x-3">
                <div class=" flex items-center justify-center">
                    <div class="text-white font-bold text-xs text-center leading-tight">
                        <img src="/lms/assets/images/logo.png" alt="College Library" >
                    </div>
                </div>
                
            </div>

            <!-- Navigation Links -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="/lms/index.php" class="text-gray-900 hover:text-red-600 font-medium transition-colors duration-200">Home</a>
                <a href="#" class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200">Academics</a>
 <!-- Faculty Dropdown -->
                <div class="relative group">
                    <button class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200 flex items-center">
                        Faculty
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full left-0 mt-2 w-48 bg-white shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="/lms/faculty/bim.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600">BIM/BITM</a>
                        <a href="/lms/faculty/bba.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600">BBA</a>
                        <a href="/lms/faculty/bca.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600">BCA</a>
                    </div>
                </div>                
                <a href="https://kcmit.edu.np/" class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200">Our Campus</a>
                
                <!-- Pages Dropdown -->
                <div class="relative group">
                    <button class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200 flex items-center">
                        Pages
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full left-0 mt-2 w-48 bg-white shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="/lms/about.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600">About Us</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600">Admissions</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600">Programs</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600">Research</a>
                    </div>
                </div>
                
                <a href="#" class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200">News</a>
                <a href="#" class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200">Contact</a>
            </div>

            <!-- Right Side Actions -->
            <div class="hidden lg:flex items-center space-x-4">
                <?php if ($is_logged_in): ?>
                    <?php 
                        $dash_link = '/lms/student/dashboard.php';
                        if ($user_role === 'admin') $dash_link = '/lms/admin/dashboard.php';
                        if ($user_role === 'faculty') $dash_link = '/lms/faculty/dashboard.php';
                    ?>
                    <a href="<?php echo $dash_link; ?>" class="text-sm font-semibold text-gray-700 hover:text-red-600">
                        <i class="fas fa-th-large mr-1"></i> Dashboard
                    </a>
                    <a href="/lms/auth/logout.php" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition-colors duration-200 text-sm font-medium">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="/lms/auth/login.php" class="bg-red-600 text-white px-8 py-2.5 rounded-full hover:bg-red-700 transition-all duration-300 text-sm font-bold shadow-lg shadow-red-100 flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <button class="lg:hidden text-gray-700 focus:outline-none" id="mobile-menu-button">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="lg:hidden hidden" id="mobile-menu">
        <div class="px-4 pt-2 pb-4 space-y-2 bg-white border-t">
            <a href="/lms/index.php" class="block py-2 text-gray-900 hover:text-red-600 font-medium">Home</a>
            <a href="#" class="block py-2 text-gray-700 hover:text-red-600 font-medium">Academics</a>
            <?php if ($is_logged_in): ?>
                <?php 
                    $dash_link = '/lms/student/dashboard.php';
                    if ($user_role === 'admin') $dash_link = '/lms/admin/dashboard.php';
                    if ($user_role === 'faculty') $dash_link = '/lms/faculty/dashboard.php';
                ?>
                <a href="<?php echo $dash_link; ?>" class="block py-2 text-gray-700 hover:text-red-600 font-medium">Dashboard</a>
                <a href="/lms/auth/logout.php" class="block py-2 text-red-600 font-bold">Logout</a>
            <?php else: ?>
                <a href="/lms/auth/login.php" class="block py-3 bg-red-600 text-white px-4 rounded-xl text-center font-bold shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login to Portal
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Mobile Menu Script -->
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