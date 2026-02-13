<?php
// Function to get environment variable with fallback
function getEnvVar($key, $default = '') {
    $value = getenv($key);
    return $value !== false ? $value : $default;
}

// Database configuration
// If running on Vercel/Production, use environment variables
// If running locally (XAMPP), use default fallbacks
$host = getEnvVar('DB_HOST', 'localhost'); // Default: localhost
$dbname = getEnvVar('DB_NAME', 'library_db'); // Default: library_db
$username = getEnvVar('DB_USER', 'root'); // Default: root
$password = getEnvVar('DB_PASSWORD', ''); // Default: empty

// Port handling (TiDB/Aiven often use non-standard ports)
$port = getEnvVar('DB_PORT', '3306'); 

    // SSL handling (Required for most cloud databases)
    $ssl_ca = getEnvVar('DB_SSL_CA', ''); 
    
    // If SSL CA is just a filename, assume it's in the project root
    if (!empty($ssl_ca) && !is_absolute_path($ssl_ca) && file_exists(dirname(__DIR__) . '/' . $ssl_ca)) {
        $ssl_ca = dirname(__DIR__) . '/' . $ssl_ca;
    } 
    // Fallback: if no Env Var, check if cacert.pem exists in root (common for this setup)
    elseif (empty($ssl_ca) && file_exists(dirname(__DIR__) . '/cacert.pem')) {
        $ssl_ca = dirname(__DIR__) . '/cacert.pem';
    }

    // Build DSN
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    // TiDB on Vercel requires SSL verify options
    if (!empty($ssl_ca) || getEnvVar('VERCEL')) {
        $dsn .= ";ssl-mode=VERIFY_IDENTITY";
    }
    
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    // Add SSL options if needed (for production)
    if (!empty($ssl_ca)) {
        $options[PDO::MYSQL_ATTR_SSL_CA] = $ssl_ca;
        $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true; 
    } elseif (getEnvVar('VERCEL')) {
        // Vercel might have its own global CA, but usually providing one is safer for TiDB
        $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false; 
    }

    $pdo = new PDO($dsn, $username, $password, $options);
    
} catch(PDOException $e) {
    // In production, don't show exact error to user for security
    if (getEnvVar('VERCEL')) {
         error_log("DB Connection Failed: " . $e->getMessage()); // Log it
         die("Connection failed. Please check configuration."); 
    } else {
        die("Connection failed: " . $e->getMessage());
    }
}

function is_absolute_path($path) {
    return $path === '' || strpos($path, '/') === 0 || preg_match('#^[a-zA-Z]:\\\\#', $path);
}
?>
