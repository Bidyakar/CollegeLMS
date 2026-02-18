<?php
// faculty/bca.php
session_start();
require_once '../config/db.php';

$faculty_name = "BCA";
$faculty_full = "Bachelor of Computer Application";

// Handle Resource fetching per semester
$resources_by_sem = [];
for($i=1; $i<=8; $i++) {
    $stmt = $pdo->prepare("SELECT * FROM resources WHERE faculty = ? AND semester = ? ORDER BY created_at DESC");
    $stmt->execute([$faculty_name, $i]);
    $resources_by_sem[$i] = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $faculty_name; ?> Department - KCMIT Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; background: #fafbfc; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
        .tab-active { @apply border-red-600 text-red-600 bg-red-50/50; }
    </style>
</head>
<body class="bg-gray-50">

    <?php include '../includes/navbar.php'; ?>

    <!-- Hero Header -->
    <section class="bg-slate-900 text-white py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-red-600 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-600 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-5xl lg:text-7xl font-black mb-6 tracking-tighter uppercase"><?php echo $faculty_name; ?> HUB</h1>
            <p class="text-xl text-gray-400 font-bold max-w-2xl mx-auto"><?php echo $faculty_full; ?> • TU Affiliated Resources & Syllabus</p>
            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <span class="bg-white/10 backdrop-blur-md px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest border border-white/10">8 Semesters</span>
                <span class="bg-white/10 backdrop-blur-md px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest border border-white/10">TU Standard</span>
                <span class="bg-white/10 backdrop-blur-md px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest border border-white/10">Academic Excellence</span>
            </div>
        </div>
    </section>

    <!-- Content Area -->
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid lg:grid-cols-4 gap-12">
            
            <!-- Semester Sidebar (Tabs) -->
            <div class="lg:col-span-1 space-y-2 sticky top-24 h-fit">
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-[0.3em] mb-4 ml-2">Select Semester</p>
                <?php for($i=1; $i<=8; $i++): ?>
                <button onclick="showSem(<?php echo $i; ?>)" id="tab-<?php echo $i; ?>" class="sem-tab w-full text-left px-6 py-4 rounded-2xl transition-all font-bold text-sm flex items-center justify-between border-2 border-transparent <?php echo $i==1 ? 'bg-white border-red-600 shadow-xl shadow-red-900/5 text-red-600' : 'text-gray-500 hover:bg-white hover:border-gray-200'; ?>">
                    <span>Semester <?php echo $i; ?></span>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                </button>
                <?php endfor; ?>
            </div>

            <!-- Context Area -->
            <div class="lg:col-span-3">
                <?php for($i=1; $i<=8; $i++): ?>
                <div id="content-<?php echo $i; ?>" class="sem-content <?php echo $i!=1 ? 'hidden' : ''; ?> space-y-10 animate-fade-in">
                    
                    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-10 opacity-5">
                            <span class="text-9xl font-black"><?php echo $i; ?></span>
                        </div>
                        <h2 class="text-3xl font-black text-slate-800 mb-2">Semester <?php echo $i; ?> Materials</h2>
                        <p class="text-sm text-gray-400 font-bold uppercase tracking-widest mb-8">Official TU Syllabus & Subject Resources</p>
                        
                        <!-- Resource Grid -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <?php if(empty($resources_by_sem[$i])): ?>
                                <div class="col-span-2 py-20 text-center border-2 border-dashed border-gray-100 rounded-3xl">
                                    <i class="fas fa-folder-open text-gray-200 text-5xl mb-4"></i>
                                    <p class="text-gray-400 font-bold italic">Resources for this semester are being updated by the faculty.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach($resources_by_sem[$i] as $res): ?>
                                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 hover:border-red-200 transition-all group">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="h-12 w-12 bg-white rounded-2xl flex items-center justify-center shadow-sm text-red-600">
                                            <?php if($res['file_path']): ?><i class="fas fa-file-pdf text-xl"></i><?php else: ?><i class="fas fa-link text-xl"></i><?php endif; ?>
                                        </div>
                                        <span class="text-[9px] font-black uppercase bg-white px-3 py-1 rounded-full shadow-sm text-gray-500">Subject: <?php echo $res['subject']; ?></span>
                                    </div>
                                    <h3 class="font-black text-slate-800 mb-2 group-hover:text-red-600 transition-colors uppercase tracking-tight"><?php echo $res['title']; ?></h3>
                                    <p class="text-xs text-gray-500 leading-relaxed mb-6 italic"><?php echo $res['description'] ?: 'Official syllabus and resource material provided by KCMIT Faculty.'; ?></p>
                                    
                                    <div class="flex items-center gap-3">
                                        <?php if($res['file_path']): ?>
                                        <a href="../<?php echo $res['file_path']; ?>" download class="flex-1 bg-red-600 text-white py-3 rounded-xl text-center text-xs font-black uppercase tracking-widest hover:bg-slate-900 transition-all">Download PDF</a>
                                        <?php endif; ?>
                                        <?php if($res['link_url']): ?>
                                        <a href="<?php echo $res['link_url']; ?>" target="_blank" class="flex-1 border-2 border-slate-200 text-slate-600 py-3 rounded-xl text-center text-xs font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all">View Portal</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Curriculum Banner -->
                    <div class="bg-red-600 rounded-[2.5rem] p-10 text-white flex flex-col md:flex-row items-center justify-between gap-8 shadow-2xl shadow-red-200">
                        <div class="text-center md:text-left">
                            <h3 class="text-2xl font-black mb-2 uppercase tracking-tighter">Need Printed Material?</h3>
                            <p class="text-red-100 text-sm font-bold opacity-80">All TU textbooks for BCA Semester <?php echo $i; ?> are available in the KCMIT physical library.</p>
                        </div>
                        <a href="../auth/login.php" class="bg-white text-red-600 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all">Reserve Books Now</a>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script>
        function showSem(num) {
            // Content
            document.querySelectorAll('.sem-content').forEach(c => c.classList.add('hidden'));
            document.getElementById('content-' + num).classList.remove('hidden');

            // Tabs
            document.querySelectorAll('.sem-tab').forEach(t => {
                t.classList.remove('bg-white', 'border-red-600', 'shadow-xl', 'shadow-red-900/5', 'text-red-600');
                t.classList.add('text-gray-500');
            });
            const activeTab = document.getElementById('tab-' + num);
            activeTab.classList.remove('text-gray-500');
            activeTab.classList.add('bg-white', 'border-red-600', 'shadow-xl', 'shadow-red-900/5', 'text-red-600');
        }
    </script>
</body>
</html>
