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
        // Check if already requested
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM book_requests WHERE user_id = ? AND book_id = ? AND status = 'pending'");
        $stmt->execute([$student_id, $book_id]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Already requested']);
            exit;
        }

        // Check if already borrowed (active)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM borrowdetails bd 
                               JOIN borrow b ON bd.borrow_id = b.borrow_id 
                               WHERE b.member_id = ? AND bd.book_id = ? AND bd.borrow_status = 'pending'");
        $stmt->execute([$student_id, $book_id]);
        if ($stmt->fetchColumn() > 0) {
             echo json_encode(['success' => false, 'message' => 'You already have this book borrowed']);
             exit;
        }
        
        // Check availability
        $stmt = $pdo->prepare("SELECT book_copies FROM book WHERE book_id = ?");
        $stmt->execute([$book_id]);
        $copies = $stmt->fetchColumn();
        
        if ($copies <= 0) {
             echo json_encode(['success' => false, 'message' => 'Book is out of stock']);
             exit;
        }

        // Insert request
        $stmt = $pdo->prepare("INSERT INTO book_requests (user_id, book_id) VALUES (?, ?)");
        $stmt->execute([$student_id, $book_id]);

        echo json_encode(['success' => true, 'message' => 'Request submitted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
