<?php
$pageTitle = 'Log in - Glitterhaus Cinema';
require __DIR__ . '/../../includes/header.php';
?>
<section class="form-card">
    <p class="eyebrow">Welcome back</p>
    <h1>Log in</h1>
    <?php if ($message): ?>
    <p class="alert"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form action="index.php?page=login" method="post">
        <label for="username">Username</label>
        <input id="username" type="text" name="user" maxlength="30" value="" required>
        <label for="password">Password</label>
        <input id="password" type="password" name="pass" maxlength="30" value="" required>
        <input class="button" type="submit" name="submit" value="Log in">
    </form>
    <p class="form-footer">New here? <a href="index.php?page=register">Create an account</a></p>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>