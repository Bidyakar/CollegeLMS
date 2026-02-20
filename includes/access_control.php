<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['role'] ?? '';
    
    // Check role and redirect to appropriate dashboard
    if ($role === 'student') {
        header("Location: /lms/student/dashboard.php");
        exit;
    } elseif ($role === 'admin' || $role === 'staff') {
        header("Location: /lms/admin/dashboard.php");
        exit;
    } elseif ($role === 'faculty') {
        header("Location: /lms/faculty/dashboard.php");
        exit;
    }
}
?>
