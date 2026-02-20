<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/staff-login.php");
    exit();
}

$message = '';
$error = '';

// Handle Add/Edit Blog
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blog_id = $_POST['blog_id'] ?? null;
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['name'] ?? 'Admin';
    
    // Handle Image Upload
    $image_path = $_POST['existing_image'] ?? null;
    if (isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] == 0) {
        $target_dir = "../uploads/blogs/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["blog_image"]["name"]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["blog_image"]["tmp_name"], $target_file)) {
            $image_path = "uploads/blogs/" . $file_name;
        }
    }

    try {
        if ($blog_id) {
            // Update
            $stmt = $pdo->prepare("UPDATE blogs SET title=?, content=?, image_path=? WHERE blog_id=?");
            $stmt->execute([$title, $content, $image_path, $blog_id]);
            $message = "Blog updated successfully!";
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO blogs (title, content, author, image_path) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $content, $author, $image_path]);
            $message = "Blog posted successfully!";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM blogs WHERE blog_id = ?");
        $stmt->execute([$_GET['delete']]);
        $message = "Blog deleted successfully!";
    } catch (PDOException $e) {
        $error = "Error deleting blog: " . $e->getMessage();
    }
}

// Fetch all blogs
$blogs = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll();

// Fetch blog for editing
$edit_blog = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE blog_id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_blog = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs - KCMIT Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; background: #f9f9fb; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
    </style>
</head>
<body class="flex min-h-screen">
    <?php $active_page = 'blogs'; include 'includes/sidebar.php'; ?>

    <main class="flex-1 p-8 pt-20 lg:pt-8">
        <header class="flex justify-between items-center mb-10 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-3xl font-black text-gray-800 tracking-tight">Blog Management</h1>
                <p class="text-gray-400 font-bold text-xs uppercase tracking-widest mt-1">Publish & Manage Articles</p>
            </div>
        </header>

        <?php if ($message): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <i class="fas fa-check-circle mr-2"></i> <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <i class="fas fa-exclamation-triangle mr-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-12 gap-8">
            <!-- Form Section -->
            <div class="lg:col-span-12">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <i class="fas fa-pen-nib mr-3 text-red-600"></i>
                        <?php echo $edit_blog ? 'Edit Article' : 'Write New Article'; ?>
                    </h2>
                    <form action="manage_blogs.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <input type="hidden" name="blog_id" value="<?php echo $edit_blog['blog_id'] ?? ''; ?>">
                        <input type="hidden" name="existing_image" value="<?php echo $edit_blog['image_path'] ?? ''; ?>">
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Article Title</label>
                                <input type="text" name="title" required value="<?php echo htmlspecialchars($edit_blog['title'] ?? ''); ?>" 
                                       class="w-full bg-gray-50 p-4 rounded-2xl outline-none focus:ring-2 focus:ring-red-500 transition-all font-bold text-slate-700"
                                       placeholder="Enter a catchy title...">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Featured Image</label>
                                <input type="file" name="blog_image" class="w-full bg-gray-50 p-3 rounded-2xl outline-none text-xs font-bold text-slate-500 border-2 border-dashed border-gray-200">
                                <?php if($edit_blog && $edit_blog['image_path']): ?>
                                    <p class="text-[10px] text-gray-400 mt-1 italic">Current: <?php echo basename($edit_blog['image_path']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Content</label>
                            <textarea name="content" required rows="10" 
                                      class="w-full bg-gray-50 p-6 rounded-2xl outline-none focus:ring-2 focus:ring-red-500 transition-all text-slate-700 leading-relaxed"
                                      placeholder="Write your article content here..."><?php echo htmlspecialchars($edit_blog['content'] ?? ''); ?></textarea>
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <?php if($edit_blog): ?>
                                <a href="manage_blogs.php" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition-all">Cancel</a>
                            <?php endif; ?>
                            <button type="submit" class="px-10 py-4 bg-red-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-700 transition-all shadow-xl shadow-red-100">
                                <?php echo $edit_blog ? 'Update Article' : 'Publish Article'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List Section -->
            <div class="lg:col-span-12">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-100"><h2 class="text-xl font-bold">Published Articles</h2></div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <tr>
                                    <th class="p-8">Article</th>
                                    <th class="p-8">Author</th>
                                    <th class="p-8">Date</th>
                                    <th class="p-8 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach($blogs as $blog): ?>
                                <tr class="hover:bg-gray-50/50 transition-all group">
                                    <td class="p-8">
                                        <div class="flex items-center space-x-4">
                                            <?php if($blog['image_path']): ?>
                                                <img src="../<?php echo $blog['image_path']; ?>" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                            <?php else: ?>
                                                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-300">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-bold text-gray-900 line-clamp-1"><?php echo htmlspecialchars($blog['title']); ?></p>
                                                <p class="text-[10px] text-gray-400 font-bold uppercase truncate w-64"><?php echo substr(strip_tags($blog['content']), 0, 50); ?>...</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-8">
                                        <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full"><?php echo $blog['author']; ?></span>
                                    </td>
                                    <td class="p-8 text-xs text-gray-400 font-bold uppercase tracking-widest">
                                        <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
                                    </td>
                                    <td class="p-8 text-right space-x-4">
                                        <a href="manage_blogs.php?edit=<?php echo $blog['blog_id']; ?>" class="text-blue-500 hover:text-blue-700 transition-colors"><i class="fas fa-edit"></i></a>
                                        <a href="manage_blogs.php?delete=<?php echo $blog['blog_id']; ?>" onclick="return confirm('Delete this article?')" class="text-red-400 hover:text-red-600 transition-colors"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(empty($blogs)): ?>
                                <tr>
                                    <td colspan="4" class="p-20 text-center text-gray-400">
                                        <i class="fas fa-rss text-4xl mb-4 block text-gray-100"></i>
                                        <p class="text-sm font-bold uppercase tracking-widest italic">No articles published yet.</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
