<?php
$pageTitle = 'Page not found - Glitterhaus Cinema';
$message = $message ?? 'The page you requested could not be found.';
require __DIR__ . '/../../includes/header.php';
?>
<section class="empty-state">
    <h1>404</h1>
    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <a class="button" href="index.php?page=home">Back to movies</a>
</section>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
