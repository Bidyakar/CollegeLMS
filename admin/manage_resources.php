<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/staff-login.php");
    exit();
}

$message = '';
$error = '';

// Handle Add Resource
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_resource'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $faculty = $_POST['faculty'];
    $semester = $_POST['semester'];
    $subject = $_POST['subject'];
    $link_url = $_POST['link_url'];
    
    // Handle File Upload
    $file_path = null;
    if (isset($_FILES['resource_file']) && $_FILES['resource_file']['error'] == 0) {
        $target_dir = "../uploads/resources/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["resource_file"]["name"]);
        $file_path = "uploads/resources/" . $file_name;
        move_uploaded_file($_FILES["resource_file"]["tmp_name"], "../" . $file_path);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO resources (title, description, faculty, semester, subject, file_path, link_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $faculty, $semester, $subject, $file_path, $link_url]);
        $message = "Resource added successfully!";
    } catch (PDOException $e) { $error = $e->getMessage(); }
}

// Handle Delete Resource
if (isset($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM resources WHERE resource_id = ?");
        $stmt->execute([$_GET['delete']]);
        $message = "Resource deleted!";
    } catch (PDOException $e) { $error = $e->getMessage(); }
}

// Fetch all resources
$resources = $pdo->query("SELECT * FROM resources ORDER BY faculty, semester, subject")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resources - KCMIT Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; background: #f9f9fb; }
        h1, h2, h3 { font-family: 'Merriweather', serif; }
    </style>
</head>
<body class="flex min-h-screen">
    <?php $active_page = 'resources'; include 'includes/sidebar.php'; ?>

    <main class="flex-1 p-8 pt-20 lg:pt-8">
        <header class="flex justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 uppercase tracking-widest">
            <h1 class="text-2xl font-black text-gray-800">Academic Resources</h1>
            <span class="text-[10px] font-bold text-red-600">Syllabus & Notes Manager</span>
        </header>

        <?php if ($message): ?><div class="bg-green-50 text-green-700 p-4 mb-6 rounded-2xl border border-green-100 flex items-center italic text-sm"><i class="fas fa-check-circle mr-2"></i> <?php echo $message; ?></div><?php endif; ?>
        <?php if ($error): ?><div class="bg-red-50 text-red-700 p-4 mb-6 rounded-2xl border border-red-100 flex items-center italic text-sm"><i class="fas fa-exclamation-triangle mr-2"></i> <?php echo $error; ?></div><?php endif; ?>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Add Form -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold mb-6 flex items-center"><i class="fas fa-plus-circle mr-2 text-red-600"></i> New Resource</h2>
                <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="text-[10px] font-black uppercase text-gray-400">Resource Title</label>
                        <input name="title" type="text" placeholder="e.g. C Programming Syllabus" required class="w-full bg-gray-50 p-4 rounded-xl outline-none focus:ring-2 focus:ring-red-500 transition-all font-bold">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400">Faculty</label>
                            <select name="faculty" class="w-full bg-gray-50 p-4 rounded-xl outline-none font-bold">
                                <option value="BIM">BIM</option>
                                <option value="BCA">BCA</option>
                                <option value="BBA">BBA</option>
                                <option value="BITM">BITM</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400">Semester</label>
                            <select name="semester" class="w-full bg-gray-50 p-4 rounded-xl outline-none font-bold">
                                <?php for($i=1; $i<=8; $i++) echo "<option value='$i'>Sem $i</option>"; ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase text-gray-400">Subject Name</label>
                        <input name="subject" type="text" placeholder="e.g. Discrete Structure" required class="w-full bg-gray-50 p-4 rounded-xl outline-none font-bold">
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase text-gray-400">Optional Link (URL)</label>
                        <input name="link_url" type="url" placeholder="https://example.com/syllabus" class="w-full bg-gray-50 p-4 rounded-xl outline-none font-bold">
                    </div>

                    <div>
                        <label class="text-[10px] font-black uppercase text-gray-400">Upload File (PDF/Doc)</label>
                        <input name="resource_file" type="file" class="w-full bg-gray-50 p-4 rounded-xl outline-none font-bold text-xs">
                    </div>

                    <button type="submit" name="add_resource" class="w-full py-4 bg-red-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-700 transition-all shadow-xl shadow-red-100">Publish Resource</button>
                </form>
            </div>

            <!-- List Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b"><h2 class="text-xl font-bold">Document Repository</h2></div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <tr>
                                    <th class="p-6">Resource / Subject</th>
                                    <th class="p-6">Course Context</th>
                                    <th class="p-6">Type</th>
                                    <th class="p-6 text-right">Delete</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach($resources as $r): ?>
                                <tr class="hover:bg-gray-50 transition-all">
                                    <td class="p-6">
                                        <p class="font-bold text-gray-900"><?php echo $r['title']; ?></p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase"><?php echo $r['subject']; ?></p>
                                    </td>
                                    <td class="p-6">
                                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-[10px] font-black"><?php echo $r['faculty']; ?> • SEM <?php echo $r['semester']; ?></span>
                                    </td>
                                    <td class="p-6 text-sm">
                                        <?php if($r['file_path']): ?>
                                            <i class="fas fa-file-pdf text-red-500 mr-1"></i> File
                                        <?php elseif($r['link_url']): ?>
                                            <i class="fas fa-link text-blue-500 mr-1"></i> Link
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-6 text-right">
                                        <a href="manage_resources.php?delete=<?php echo $r['resource_id']; ?>" onclick="return confirm('Remove document?')" class="text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(empty($resources)): ?>
                                <tr><td colspan="4" class="p-12 text-center text-gray-400 font-bold italic">No resources catalogued yet.</td></tr>
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
