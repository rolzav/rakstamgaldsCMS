<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header>
    <nav>
        <a href="/">Home</a>
        <a href="/blog">Blog</a>
        <a href="/about">About</a>
        <?php if (isLoggedIn()): ?>
            <a href="/logout">Logout</a>
            <?php if (isAdmin()): ?>
                <a href="/admin">Admin</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="/login">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main>
