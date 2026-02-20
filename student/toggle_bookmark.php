<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'] ?? null;
    $student_id = $_SESSION['user_id'];

    if (!$book_id) {
        echo json_encode(['success' => false, 'message' => 'Invalid book ID']);
        exit;
    }

    try {
        // Check if bookmarked
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookmarks WHERE user_id = ? AND book_id = ?");
        $stmt->execute([$student_id, $book_id]);
        $exists = $stmt->fetchColumn() > 0;

        if ($exists) {
            // Remove bookmark
            $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE user_id = ? AND book_id = ?");
            $stmt->execute([$student_id, $book_id]);
            echo json_encode(['success' => true, 'action' => 'removed', 'message' => 'Bookmark removed']);
        } else {
            // Add bookmark
            $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, book_id) VALUES (?, ?)");
            $stmt->execute([$student_id, $book_id]);
            echo json_encode(['success' => true, 'action' => 'added', 'message' => 'Bookmarked successfully']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
