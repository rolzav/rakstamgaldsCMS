<?php
Flight::route('/blog', function () {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT * FROM posts ORDER BY created_at DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Flight::render('blog', ['title' => 'Blog', 'posts' => $posts]);
});
