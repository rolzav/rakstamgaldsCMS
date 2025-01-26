<?php

require_once __DIR__ . '/includes/db.php';

// Ensure the data directory exists and is writable
$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

// Ensure the database file exists and is writable
$dbFile = $dataDir . '/nextgencmsblogging.db';
if (!file_exists($dbFile)) {
    touch($dbFile);
    chmod($dbFile, 0666);
}

try {
    $db = Database::getInstance()->getConnection();
    
    // Create users table
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            role TEXT NOT NULL
        );
    ");

    // Create posts table
    $db->exec("
        CREATE TABLE IF NOT EXISTS posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            content TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            category_id INTEGER,
            created_at TEXT NOT NULL,
            FOREIGN KEY (category_id) REFERENCES categories(id)
        );
    ");

    // Create categories table
    $db->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            parent_id INTEGER,
            FOREIGN KEY (parent_id) REFERENCES categories(id)
        );
    ");

    // Create tags table
    $db->exec("
        CREATE TABLE IF NOT EXISTS tags (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE
        );
    ");

    // Create post_tags table
    $db->exec("
        CREATE TABLE IF NOT EXISTS post_tags (
            post_id INTEGER,
            tag_id INTEGER,
            PRIMARY KEY (post_id, tag_id),
            FOREIGN KEY (post_id) REFERENCES posts(id),
            FOREIGN KEY (tag_id) REFERENCES tags(id)
        );
    ");

    // Insert default admin user
    $username = 'admin';
    $password = password_hash('admin123', PASSWORD_BCRYPT);
    $role = 'admin';

    $stmt = $db->prepare("INSERT OR IGNORE INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);

    echo "Database initialized successfully.";
} catch (PDOException $e) {
    echo "Database initialization failed: " . $e->getMessage();
}

?>
