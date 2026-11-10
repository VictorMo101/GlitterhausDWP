<?php
$pageTitle = $pageTitle ?? 'Glitterhaus Cinema';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<header>
    <div class="site-header">
        <a class="brand" href="index.php?page=home">Glitterhaus <span>Cinema</span></a>
        <nav class="site-nav">
            <a href="index.php?page=home">Home</a>
        <?php if (logged_in()): ?>
            <a href="index.php?page=bookings">My bookings</a>
            <span>Welcome, <?= htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') ?></span>
            <form action="index.php?page=logout" method="post">
                <button class="button button-small" type="submit">Log out</button>
            </form>
        <?php else: ?>
            <a href="index.php?page=login">Log in</a>
            <a class="button button-small" href="index.php?page=register">Register</a>
        <?php endif; ?>
        </nav>
    </div>
</header>

<main class="page-container">