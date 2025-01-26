<?php include __DIR__ . '/partials/header.php'; ?>
<div class="container">
    <h1><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <ul class="list-group mt-3">
        <?php foreach ($categories as $category) : ?>
        <li class="list-group-item">
            <a href="/category/<?php echo htmlspecialchars($category['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
