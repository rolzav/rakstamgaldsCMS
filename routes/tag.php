<?php
Flight::route('/tag/@slug', function ($slug) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT * FROM tags WHERE slug = ?");
    $stmt->execute([$slug]);
    $tag = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tag) {
        Flight::halt(404, 'Tag not found');
    }

    $stmt = $db->prepare("SELECT * FROM posts 
                          JOIN post_tags ON posts.id = post_tags.post_id 
                          WHERE post_tags.tag_id = ? ORDER BY posts.created_at DESC");
    $stmt->execute([$tag['id']]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    Flight::render('tag', ['title' => $tag['name'], 'tag' => $tag, 'posts' => $posts]);
});
