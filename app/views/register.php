<?php
$pageTitle = 'Register - Glitterhaus Cinema';
require __DIR__ . '/../../includes/header.php';
?>
<section class="form-card">
    <p class="eyebrow">Join the club</p>
    <h1>Create an account</h1>
    <?php if ($message): ?>
    <p class="alert"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form action="index.php?page=register" method="post">
        <label for="username">Username</label>
        <input id="username" type="text" name="user" maxlength="30" value="" required>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" maxlength="255" value="" required>
        <label for="password">Password</label>
        <input id="password" type="password" name="pass" maxlength="30" value="" required>
        <input class="button" type="submit" name="submit" value="Create account">
    </form>
    <p class="form-footer">Already have an account? <a href="index.php?page=login">Log in</a></p>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>