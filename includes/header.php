<?php
$pageTitle = $pageTitle ?? 'Glimmerhaus Cinema';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
<header>
    <h1>Glimmerhaus Cinema</h1>
    <nav>
        <?php if (logged_in()): ?>
            <span>Welcome, <?= htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') ?></span>
            <form action="index.php?page=logout" method="post">
                <button type="submit">Log out</button>
            </form>
        <?php endif; ?>
    </nav>
</header>

<main>