<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in and is faculty or admin
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['faculty', 'admin'])) {
    header("Location: ../auth/staff-login.php");
    exit();
}

// Fetch some data for faculty (e.g., books in their department)
$user_id = $_SESSION['user_id'];
$faculty_role = $_SESSION['role'];

try {
    // Just a placeholder for now - maybe show popular books or dept stats
    $stats = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard - KCMIT Library</title>
    <link href="../assets/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2 { font-family: 'Merriweather', serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <?php include '../includes/navbar.php'; ?>

    <div class="pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-10 shadow-sm border border-orange-100 mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Faculty Dashboard</h1>
                    <p class="text-gray-500 mt-2">Welcome, Prof. <?php echo htmlspecialchars($_SESSION['name']); ?>. Access your research materials and department resources.</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-chalkboard-teacher text-orange-200 text-7xl"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:border-orange-200 transition">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-book-open text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Request Books</h3>
                    <p class="text-gray-600 text-sm mb-4">Request new acquisitions for your department's curriculum.</p>
                    <a href="#" class="text-orange-600 font-bold text-sm hover:underline italic">Launch Request Form &rarr;</a>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:border-orange-200 transition">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-microscope text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">E-Resources</h3>
                    <p class="text-gray-600 text-sm mb-4">Access premium journals and research database subscriptions.</p>
                    <a href="#" class="text-green-600 font-bold text-sm hover:underline italic">Access Portal &rarr;</a>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:border-orange-200 transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-users-cog text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Student Monitoring</h3>
                    <p class="text-gray-600 text-sm mb-4">View reading progress and book citations for your classes.</p>
                    <a href="#" class="text-blue-600 font-bold text-sm hover:underline italic">View Reports &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
