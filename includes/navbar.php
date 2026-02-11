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
                <a href="<?php echo __DIR__ . '/../index.php'; ?>" class="text-gray-900 hover:text-red-600 font-medium transition-colors duration-200">Home</a>
                <a href="#" class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200">Academics</a>
                <a href="#" class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200">Faculty</a>
                <a href="#" class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200">Our Campus</a>
                
                <!-- Pages Dropdown -->
                <div class="relative group">
                    <button class="text-gray-700 hover:text-red-600 font-medium transition-colors duration-200 flex items-center">
                        Pages
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full left-0 mt-2 w-48 bg-white shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-red-600">About Us</a>
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
                    <a href="<?php echo ($user_role === 'admin' ? 'admin/dashboard.php' : 'student/dashboard.php'); ?>" class="text-sm font-semibold text-gray-700 hover:text-red-600">
                        Dashboard
                    </a>
                    <a href="auth/logout.php" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition-colors duration-200 text-sm font-medium">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="auth/login.php" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition-colors duration-200 text-sm font-medium">
                        Staff Login
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
            <a href="index.php" class="block py-2 text-gray-900 hover:text-red-600 font-medium">Home</a>
            <a href="#" class="block py-2 text-gray-700 hover:text-red-600 font-medium">Academics</a>
            <?php if ($is_logged_in): ?>
                <a href="<?php echo ($user_role === 'admin' ? 'admin/dashboard.php' : 'student/dashboard.php'); ?>" class="block py-2 text-gray-700 hover:text-red-600 font-medium">Dashboard</a>
                <a href="auth/logout.php" class="block py-2 text-red-600 font-bold">Logout</a>
            <?php else: ?>
                <a href="auth/login.php" class="block py-2 bg-red-600 text-white px-4 rounded text-center">Staff Login</a>
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