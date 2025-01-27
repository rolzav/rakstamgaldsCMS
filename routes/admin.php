<?php
Flight::route('/admin', function () {
    checkAuth();
    checkRole('admin');
    Flight::render('admin/dashboard', ['title' => 'Admin Dashboard']);
});

// Manage posts
Flight::route('/admin/posts', function () {
    checkAuth();
    checkRole('admin');
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT * FROM posts ORDER BY created_at DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Flight::render('admin/posts', ['title' => 'Manage Posts', 'posts' => $posts]);
});

Flight::route('/admin/posts/create', function () {
    checkAuth();
    checkRole('admin');
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT * FROM categories ORDER BY name ASC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $db->query("SELECT * FROM tags ORDER BY name ASC");
    $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (Flight::request()->method == 'POST') {
        $title = htmlspecialchars(trim(Flight::request()->data->title), ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars(trim(Flight::request()->data->content), ENT_QUOTES, 'UTF-8');
        $category_id = Flight::request()->data->category_id;
        $slug = generateSlug($title);
        $db->prepare("INSERT INTO posts (title, content, category_id, slug, created_at) VALUES (?, ?, ?, ?, datetime('now'))")
            ->execute([$title, $content, $category_id, $slug]);

        $post_id = $db->lastInsertId();
        $tags = Flight::request()->data->tags;
        if (!empty($tags)) {
            $stmt = $db->prepare("INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)");
            foreach ($tags as $tag_id) {
                $stmt->execute([$post_id, $tag_id]);
            }
        }
        redirect('/admin/posts');
    } else {
        Flight::render('admin/create_post', ['title' => 'Create Post', 'categories' => $categories, 'tags' => $tags]);
    }
});

Flight::route('/admin/posts/edit/@slug', function ($slug) {
    checkAuth();
    checkRole('admin');
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT * FROM categories ORDER BY name ASC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $db->query("SELECT * FROM tags ORDER BY name ASC");
    $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (Flight::request()->method == 'POST') {
        $title = htmlspecialchars(trim(Flight::request()->data->title), ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars(trim(Flight::request()->data->content), ENT_QUOTES, 'UTF-8');
        $category_id = Flight::request()->data->category_id;
        $new_slug = generateSlug($title);
        $stmt = $db->prepare("UPDATE posts SET title = ?, content = ?, category_id = ?, slug = ? WHERE slug = ?");
        $stmt->execute([$title, $content, $category_id, $new_slug, $slug]);

        $stmt = $db->prepare("DELETE FROM post_tags WHERE post_id = (SELECT id FROM posts WHERE slug = ?)");
        $stmt->execute([$new_slug]);

        $tags = Flight::request()->data->tags;
        if (!empty($tags)) {
            $stmt = $db->prepare("INSERT INTO post_tags (post_id, tag_id) VALUES ((SELECT id FROM posts WHERE slug = ?), ?)");
            foreach ($tags as $tag_id) {
                $stmt->execute([$new_slug, $tag_id]);
            }
        }
        redirect('/admin/posts');
    } else {
        $stmt = $db->prepare("SELECT * FROM posts WHERE slug = ?");
        $stmt->execute([$slug]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $db->prepare("SELECT tag_id FROM post_tags WHERE post_id = ?");
        $stmt->execute([$post['id']]);
        $selected_tags = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        Flight::render('admin/edit_post', ['title' => 'Edit Post', 'post' => $post, 'categories' => $categories, 'tags' => $tags, 'selected_tags' => $selected_tags]);
    }
});

// Manage categories
Flight::route('/admin/categories', function () {
    checkAuth();
    checkRole('admin');
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT * FROM categories ORDER BY created_at DESC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Flight::render('admin/categories', ['title' => 'Manage Categories', 'categories' => $categories]);
});

Flight::route('/admin/categories/create', function () {
    checkAuth();
    checkRole('admin');
    if (Flight::request()->method == 'POST') {
        $name = htmlspecialchars(trim(Flight::request()->data->name), ENT_QUOTES, 'UTF-8');
        $parent_id = Flight::request()->data->parent_id ?: null;
        $slug = generateSlug($name);
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO categories (name, slug, parent_id) VALUES (?, ?, ?)");
        $stmt->execute([$name, $slug, $parent_id]);
        redirect('/admin/categories');
    } else {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM categories ORDER BY name ASC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Flight::render('admin/create_category', ['title' => 'Create Category', 'categories' => $categories]);
    }
});

Flight::route('/admin/categories/edit/@id', function ($id) {
    checkAuth();
    checkRole('admin');
    $db = Database::getInstance()->getConnection();
    if (Flight::request()->method == 'POST') {
        $name = htmlspecialchars(trim(Flight::request()->data->name), ENT_QUOTES, 'UTF-8');
        $parent_id = Flight::request()->data->parent_id ?: null;
        $slug = generateSlug($name);
        $stmt = $db->prepare("UPDATE categories SET name = ?, slug = ?, parent_id = ? WHERE id = ?");
        $stmt->execute([$name, $slug, $parent_id, $id]);
        redirect('/admin/categories');
    } else {
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $db->query("SELECT * FROM categories ORDER BY name ASC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Flight::render('admin/edit_category', ['title' => 'Edit Category', 'category' => $category, 'categories' => $categories]);
    }
});

// Manage tags
Flight::route('/admin/tags', function () {
    checkAuth();
    checkRole('admin');
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT * FROM tags ORDER BY created_at DESC");
    $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Flight::render('admin/tags', ['title' => 'Manage Tags', 'tags' => $tags]);
});

Flight::route('/admin/tags/create', function () {
    checkAuth();
    checkRole('admin');
    if (Flight::request()->method == 'POST') {
        $name = htmlspecialchars(trim(Flight::request()->data->name), ENT_QUOTES, 'UTF-8');
        $slug = generateSlug($name);
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO tags (name, slug) VALUES (?, ?)");
        $stmt->execute([$name, $slug]);
        redirect('/admin/tags');
    } else {
        Flight::render('admin/create_tag', ['title' => 'Create Tag']);
    }
});

Flight::route('/admin/tags/edit/@id', function ($id) {
    checkAuth();
    checkRole('admin');
    $db = Database::getInstance()->getConnection();
    if (Flight::request()->method == 'POST') {
        $name = htmlspecialchars(trim(Flight::request()->data->name), ENT_QUOTES, 'UTF-8');
        $slug = generateSlug($name);
        $stmt = $db->prepare("UPDATE tags SET name = ?, slug = ? WHERE id = ?");
        $stmt->execute([$name, $slug, $id]);
        redirect('/admin/tags');
    } else {
        $stmt = $db->prepare("SELECT * FROM tags WHERE id = ?");
        $stmt->execute([$id]);
        $tag = $stmt->fetch(PDO::FETCH_ASSOC);
        Flight::render('admin/edit_tag', ['title' => 'Edit Tag', 'tag' => $tag]);
    }
});

Flight::route('/admin/tags/delete/@id', function ($id) {
    checkAuth();
    checkRole('admin');
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("DELETE FROM tags WHERE id = ?");
    $stmt->execute([$id]);
    redirect('/admin/tags');
});
?>
