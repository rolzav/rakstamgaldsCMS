<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
    <p>Welcome to the Admin Dashboard!</p>
    <a href="/admin/posts">Manage Posts</a>
    <a href="/admin/categories">Manage Categories</a>
    <a href="/admin/tags">Manage Tags</a>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
