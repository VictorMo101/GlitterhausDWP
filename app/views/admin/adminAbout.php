<?php
$pageTitle = 'Manage about - Glitterhaus Cinema';
require __DIR__ . '/../../../includes/header.php';
?>
<section class="page-heading">
    <a href="index.php?page=admin" class="button-small">↩ Back to Admin Dashboard</a>
    <h1>Manage About sections</h1>
</section>

<?php if (!empty($adminAboutMessage)): ?>
    <p class="alert"><?= htmlspecialchars($adminAboutMessage, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<section class="admin-about-section">
    <h2>Add a section</h2>
    <form action="index.php?page=adminAbout" method="post" class="about-admin-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="action" value="create">

        <label for="create-title">Title</label>
        <input id="create-title" name="title" type="text" maxlength="150" required>

        <label for="create-content">Content</label>
        <textarea id="create-content" name="content" rows="6" required></textarea>

        <label for="create-order">Display order</label>
        <input id="create-order" name="displayOrder" type="number" min="0" value="0" required>

        <button class="button" type="submit">Add section</button>
    </form>
</section>

<section class="admin-about-section">
    <h2>Existing sections</h2>
    <?php if (empty($sections)): ?>
        <p class="empty-state">No About sections exist yet.</p>
    <?php else: ?>
        <?php foreach ($sections as $section): ?>
            <article class="about-admin-card">
                <form action="index.php?page=adminAbout" method="post" class="about-admin-form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="aboutId" value="<?= (int) $section['aboutId'] ?>">

                    <label for="title-<?= (int) $section['aboutId'] ?>">Title</label>
                    <input id="title-<?= (int) $section['aboutId'] ?>"
                           name="title"
                           type="text"
                           maxlength="150"
                           value="<?= htmlspecialchars($section['title'], ENT_QUOTES, 'UTF-8') ?>"
                           required>

                    <label for="content-<?= (int) $section['aboutId'] ?>">Content</label>
                    <textarea id="content-<?= (int) $section['aboutId'] ?>"
                              name="content"
                              rows="6"
                              required><?= htmlspecialchars($section['content'], ENT_QUOTES, 'UTF-8') ?></textarea>

                    <label for="order-<?= (int) $section['aboutId'] ?>">Display order</label>
                    <input id="order-<?= (int) $section['aboutId'] ?>"
                           name="displayOrder"
                           type="number"
                           min="0"
                           value="<?= (int) $section['displayOrder'] ?>"
                           required>

                    <button class="button" type="submit">Save changes</button>
                </form>

                <form action="index.php?page=adminAbout"
                      method="post"
                      class="about-delete-form"
                      onsubmit="return confirm('Delete this About section?');">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="aboutId" value="<?= (int) $section['aboutId'] ?>">
                    <button class="button button-danger" type="submit">Delete</button>
                </form>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/../../../includes/footer.php'; ?>