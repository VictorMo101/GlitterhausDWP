<?php
$pageTitle = 'Log in - Glimmerhaus Cinema';
require __DIR__ . '/../../includes/header.php';
?>
<h2>Please login</h2>
<?php if ($message): ?>
<p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<form action="index.php?page=login" method="post">
Username:
<input type="text" name="user" maxlength="30" value="" />
Password:
<input type="password" name="pass" maxlength="30" value="" />
<input type="submit" name="submit" value="Login" />
</form>
<p><a href="index.php?page=register">Create an account</a></p>

<?php require __DIR__ . '/../../includes/footer.php'; ?>