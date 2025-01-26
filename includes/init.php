<?php
// Set session parameters before starting the session
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => '', // Set to your domain if necessary
    'secure' => true, // Ensure you're using HTTPS
    'httponly' => true,
    'samesite' => 'Lax', // Adjust based on your needs
]);

session_start();
session_regenerate_id(true); // Prevent session fixation attacks

// Error handling
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Generate a CSRF token if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/sessions.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/middleware.php';
?>
