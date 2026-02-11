<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<footer class="bg-gray-50 border-t border-gray-100 pt-16 pb-8 mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Brand & Description -->
            <div class="col-span-1 md:col-span-2">
                <div class=" items-center  mb-1">
                    <img src="assets/images/logo.png" alt="Logo" class="w-20 h-12">  
                    <span class="text-lg font-bold text-red-600 tracking-tight">KCMIT<span class="text-indigo-600">Library</span></span>
                </div>
                <p class="text-gray-500 max-w-sm leading-relaxed">
                    Empowering students and faculty with ready access to a world of knowledge. Our digital-first library management system ensures seamless book tracking and resource management.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-sm font-bold text-indigo-900 uppercase tracking-widest mb-6">System</h4>
                <ul class="space-y-4">
                    <li><a href="<?php echo __DIR__ . '/../index.php'; ?>" class="text-gray-600 hover:text-indigo-600 transition-colors">Home</a></li>
                    <li><a href="<?php echo __DIR__ . '/../auth/login.php'; ?>" class="text-gray-600 hover:text-indigo-600 transition-colors">Staff Login</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Library Catalog</a></li>
                </ul>
            </div>

            <!-- Contact/Support -->
            <div>
                <h4 class="text-sm font-bold text-indigo-900 uppercase tracking-widest mb-6">Support</h4>
                <ul class="space-y-4">
                    <li><a href="<?php echo __DIR__ . '/../auth/contact.php'; ?>" class="text-gray-600 hover:text-indigo-600 transition-colors">Contact Us</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Help Center</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 text-sm text-gray-500">
            <div>
                &copy; <?php echo date("Y"); ?> College Library LMS. All rights reserved.
            </div>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-indigo-600 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>
