<?php include __DIR__ . '/partials/header.php'; ?>
<div class="container">
    <h1><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <ul class="list-group mt-3">
        <?php foreach ($posts as $post) : ?>
        <li class="list-group-item">
            <a href="/post/<?php echo htmlspecialchars($post['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <p><?php echo substr($post['content'], 0, 50); ?>...</p>
            <p><em>Posted on: <?php echo htmlspecialchars($post['created_at'], ENT_QUOTES, 'UTF-8'); ?></em></p>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
