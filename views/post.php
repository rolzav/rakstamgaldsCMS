<?php include __DIR__ . '/partials/header.php'; ?>
<div class="container">
    <h1><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p><?php echo htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8'); ?></p>
    <p><em>Posted on: <?php echo htmlspecialchars($post['created_at'], ENT_QUOTES, 'UTF-8'); ?></em></p>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
