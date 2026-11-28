<?php
$pageTitle = 'About - Glitterhaus Cinema';
require __DIR__ . '/partials/header.php';
?>
<section class="page-heading">
    <p class="eyebrow">About Glitterhaus</p>
    <h1>Our story</h1>
</section>

<?php if (empty($sections)): ?>
    <div class="empty-state">
        <p>About information is currently unavailable.</p>
    </div>
<?php else: ?>
    <section class="about-grid">
        <?php foreach ($sections as $section): ?>
            <article class="about-card">
                <h2><?= htmlspecialchars($section['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                <p><?= htmlspecialchars($section['content'], ENT_QUOTES, 'UTF-8') ?></p>
            </article>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>