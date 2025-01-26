<?php
Flight::route('/post/@slug', function ($slug) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT * FROM posts WHERE slug = ?");
    $stmt->execute([$slug]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        Flight::halt(404, 'Post not found');
    }

    Flight::render('post', ['title' => $post['title'], 'post' => $post]);
});
