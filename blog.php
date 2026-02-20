<?php
session_start();
require_once 'includes/access_control.php';
require_once 'config/db.php';

// Fetch all blogs
$blogs = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - KCMIT Library</title>
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

    <!-- Hero Header -->
    <section class="bg-slate-900 text-white py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-red-600 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-600 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-5xl lg:text-7xl font-black mb-6 tracking-tighter uppercase italic">The Library <span class="text-red-600">Blog</span></h1>
            <p class="text-xl text-gray-400 font-bold max-w-2xl mx-auto italic">Insights, updates, and educational stories from the heart of our academic community.</p>
        </div>
    </section>

    <!-- Blog Feed -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <?php if(empty($blogs)): ?>
            <div class="text-center py-20 bg-white rounded-[3rem] border border-gray-100 shadow-sm">
                <i class="fas fa-rss text-6xl text-gray-100 mb-6"></i>
                <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">No articles found</h2>
                <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-2">Check back later for new updates!</p>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php foreach($blogs as $blog): ?>
                <article class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-gray-100 group">
                    <div class="h-64 overflow-hidden relative">
                        <?php if($blog['image_path']): ?>
                            <img src="<?php echo $blog['image_path']; ?>" alt="Blog Image" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <?php else: ?>
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        <?php endif; ?>
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg">
                                <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="text-[9px] font-black uppercase text-red-600 tracking-[0.2em]">Academic Updates</span>
                        </div>
                        <h2 class="text-xl font-black text-slate-800 mb-4 line-clamp-2 leading-tight group-hover:text-red-600 transition-colors italic">
                            <?php echo htmlspecialchars($blog['title']); ?>
                        </h2>
                        <p class="text-sm text-gray-500 font-semibold leading-relaxed line-clamp-3 mb-8">
                            <?php echo strip_tags($blog['content']); ?>
                        </p>
                        
                        <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                            <div class="flex items-center space-x-3">
                                <div class="h-8 w-8 bg-red-50 text-red-600 rounded-full flex items-center justify-center font-black text-[10px]">
                                    <?php echo substr($blog['author'], 0, 1); ?>
                                </div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest"><?php echo $blog['author']; ?></span>
                            </div>
                            <button class="text-slate-800 hover:text-red-600 transition-colors font-black text-[10px] uppercase tracking-widest py-2 px-4 rounded-xl border border-slate-100 hover:border-red-600">
                                Read More <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
