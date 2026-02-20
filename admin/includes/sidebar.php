<?php
// admin/includes/sidebar.php
$active_page = $active_page ?? '';
?>
<aside class="w-64 bg-slate-900 min-h-screen text-white fixed lg:static hidden lg:flex flex-col z-50">
    <div class="p-8 flex-1">
        <div class="flex items-center space-x-3 mb-10">
            <div class="h-10 w-10 bg-red-600 rounded-xl flex items-center justify-center shadow-lg shadow-red-900/20">
                <i class="fas fa-book-open text-white"></i>
            </div>
            <div>
                <h2 class="text-lg font-black tracking-tighter uppercase leading-none text-white">KCMIT</h2>
                <span class="text-[10px] font-black text-red-500 uppercase tracking-widest">Library System</span>
            </div>
        </div>

        <nav class="space-y-2">
            <a href="dashboard.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all group <?php echo $active_page == 'dashboard' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-th-large w-5 <?php echo $active_page == 'dashboard' ? 'text-white' : 'group-hover:text-red-500'; ?> transition-colors"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="manage_books.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all group <?php echo $active_page == 'books' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-book w-5 <?php echo $active_page == 'books' ? 'text-white' : 'group-hover:text-red-500'; ?> transition-colors"></i>
                <span>Manage Books</span>
            </a>

            <a href="manage_students.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all group <?php echo $active_page == 'students' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-users-graduate w-5 <?php echo $active_page == 'students' ? 'text-white' : 'group-hover:text-red-500'; ?> transition-colors"></i>
                <span>Manage Students</span>
            </a>

            <a href="manage_resources.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all group <?php echo $active_page == 'resources' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-file-alt w-5 <?php echo $active_page == 'resources' ? 'text-white' : 'group-hover:text-red-500'; ?> transition-colors"></i>
                <span>Manage Resources</span>
            </a>

            <a href="manage_blogs.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all group <?php echo $active_page == 'blogs' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-rss w-5 <?php echo $active_page == 'blogs' ? 'text-white' : 'group-hover:text-red-500'; ?> transition-colors"></i>
                <span>Manage Blogs</span>
            </a>

            <a href="manage_requests.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all group <?php echo $active_page == 'requests' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-inbox w-5 <?php echo $active_page == 'requests' ? 'text-white' : 'group-hover:text-red-500'; ?> transition-colors"></i>
                <span class="flex-1">Book Requests</span>
                <?php
                     // Check for pending requests using existing $pdo connection
                     if(isset($pdo)) {
                         $stmt = $pdo->query("SELECT COUNT(*) FROM book_requests WHERE status = 'pending'");
                         $pending = $stmt ? $stmt->fetchColumn() : 0;
                         if($pending > 0) echo '<span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">'.$pending.'</span>';
                     }
                ?>
            </a>

            <div class="pt-4 pb-2">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-3">Transactions</span>
            </div>

            <a href="issue_books.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all group <?php echo $active_page == 'issue' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-hand-holding w-5 <?php echo $active_page == 'issue' ? 'text-white' : 'group-hover:text-red-500'; ?> transition-colors"></i>
                <span>Issue Books</span>
            </a>

            <a href="return_books.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all group <?php echo $active_page == 'return' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-undo w-5 <?php echo $active_page == 'return' ? 'text-white' : 'group-hover:text-red-500'; ?> transition-colors"></i>
                <span>Return Books</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Section with Logout -->
    <div class="p-6 border-t border-slate-800 bg-slate-900/50">
        <div class="bg-slate-800/50 rounded-2xl p-4 mb-4">
            <div class="flex items-center space-x-3 mb-1">
                <div class="h-8 w-8 bg-slate-700 rounded-full flex items-center justify-center text-xs font-bold text-slate-300">
                    <?php echo substr($_SESSION['name'] ?? 'A', 0, 1); ?>
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-xs font-bold text-white truncate"><?php echo htmlspecialchars($_SESSION['name'] ?? 'Admin'); ?></p>
                    <p class="text-[10px] text-slate-500 font-bold truncate">Library Admin</p>
                </div>
            </div>
        </div>
        <a href="../auth/logout.php" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-red-600 hover:text-white transition-all group font-bold text-sm">
            <i class="fas fa-sign-out-alt w-5 group-hover:rotate-12 transition-transform"></i>
            <span>Sign Out</span>
        </a>
    </div>
</aside>

<!-- Mobile Header (Visible only on mobile) -->
<div class="lg:hidden bg-slate-900 text-white p-4 flex justify-between items-center w-full fixed top-0 z-[60]">
    <div class="flex items-center space-x-2">
        <div class="h-8 w-8 bg-red-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-book-open text-white text-xs"></i>
        </div>
        <span class="font-black tracking-tight text-sm uppercase">KCMIT LMS</span>
    </div>
    <button id="sidebarToggle" class="h-10 w-10 flex items-center justify-center rounded-xl bg-slate-800 text-white">
        <i class="fas fa-bars"></i>
    </button>
</div>

<!-- Mobile Drawer Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-[70] hidden backdrop-blur-sm transition-opacity duration-300"></div>

<!-- Mobile Sidebar (Drawer) -->
<div id="mobileSidebar" class="fixed inset-y-0 left-0 w-72 bg-slate-900 z-[80] transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden flex flex-col">
    <!-- Same content as desktop aside, can be optimized later but keeping it simple and professional -->
    <div class="p-8 flex-1">
        <div class="flex items-center justify-between mb-10">
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 bg-red-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book-open text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-black tracking-tighter uppercase leading-none text-white">KCMIT</h2>
                    <span class="text-[10px] font-black text-red-500 uppercase tracking-widest">Library System</span>
                </div>
            </div>
            <button id="sidebarClose" class="text-slate-400 hover:text-white"><i class="fas fa-times text-xl"></i></button>
        </div>

        <nav class="space-y-2">
            <a href="dashboard.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all <?php echo $active_page == 'dashboard' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-th-large w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="manage_books.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all <?php echo $active_page == 'books' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-book w-5"></i>
                <span>Manage Books</span>
            </a>
            <a href="manage_students.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all <?php echo $active_page == 'students' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-users-graduate w-5"></i>
                <span>Manage Students</span>
            </a>
            <a href="manage_blogs.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all <?php echo $active_page == 'blogs' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-rss w-5"></i>
                <span>Manage Blogs</span>
            </a>
            <div class="pt-4 pb-2"><span class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-3">Transactions</span></div>
            <a href="issue_books.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all <?php echo $active_page == 'issue' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-hand-holding w-5"></i>
                <span>Issue Books</span>
            </a>
            <a href="return_books.php" class="flex items-center space-x-3 p-3 rounded-xl transition-all <?php echo $active_page == 'return' ? 'bg-red-600 text-white shadow-lg shadow-red-900/40 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-white'; ?>">
                <i class="fas fa-undo w-5"></i>
                <span>Return Books</span>
            </a>
        </nav>
    </div>
    <div class="p-6 border-t border-slate-800 bg-slate-900/50">
        <a href="../auth/logout.php" class="flex items-center space-x-3 p-3 rounded-xl text-slate-400 hover:bg-red-600 hover:text-white transition-all font-bold text-sm">
            <i class="fas fa-sign-out-alt w-5"></i>
            <span>Sign Out</span>
        </a>
    </div>
</div>

<script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if(sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            mobileSidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    }

    if(sidebarClose) {
        sidebarClose.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    }

    if(sidebarOverlay) {
        sidebarOverlay.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    }
</script>
