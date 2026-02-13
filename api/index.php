<?php
// Vercel Entry Point
// This file routes requests to the correct PHP file based on the URL
// This is a "Router" script common in PHP frameworks or single-entry setups

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove leading slash
$path = ltrim($uri, '/');

// Default to index.php if root
if (empty($path) || $path === '/') {
    $path = 'index.php';
}

// Security: prevent traversing up directories
if (strpos($path, '..') !== false) {
    http_response_code(403);
    echo "403 Forbidden";
    exit;
}

// Adjust path to look for files in the project root (parent of api/)
$file = __DIR__ . '/../' . $path;

// If it's a directory, look for index.php inside
if (is_dir($file)) {
    $file = rtrim($file, '/') . '/index.php';
}

// Check if file exists and is a PHP file
if (file_exists($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
    // Serve the PHP file
    chdir(dirname($file)); // Change working directory to the file's directory
    require $file;
} elseif (file_exists($file)) {
    // Serve static file (though Vercel routes should handle assets before this)
    // This is a fallback
    $mime = mime_content_type($file);
    header("Content-Type: $mime");
    readfile($file);
} else {
    // 404
    http_response_code(404);
    echo "404 Not Found: " . htmlspecialchars($path);
}
?>
