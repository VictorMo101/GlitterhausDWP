<h2>Create New User</h2>

<?php if ($message): ?>
<p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<form action="index.php?page=register" method="post">
Username:
<input type="text" name="user" maxlength="30" value="" />
Email:
<input type="email" name="email" maxlength="255" value="" />
Password:
<input type="password" name="pass" maxlength="30" value="" />
<input type="submit" name="submit" value="Create" />
</form>
<p><a href="index.php?page=login">Log in</a></p>

</body>
</html>