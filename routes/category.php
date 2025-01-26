<?php
Flight::route('/category/@slug', function ($slug) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT * FROM categories WHERE slug = ?");
    $stmt->execute([$slug]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        Flight::halt(404, 'Category not found');
    }

    $stmt = $db->prepare("SELECT * FROM posts WHERE category_id = ? ORDER BY created_at DESC");
    $stmt->execute([$category['id']]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    Flight::render('category', ['title' => $category['name'], 'category' => $category, 'posts' => $posts]);
});
