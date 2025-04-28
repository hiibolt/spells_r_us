<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head><title>Home</title></head>
<body>
    <h1>Welcome</h1>
	<?php
		require 'header.php';
	?>
    <?php if (isset($_SESSION['user'])): ?>
        <p>Hello, <?= htmlspecialchars($_SESSION['user']) ?>!</p>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <p>You are not logged in.</p>
        <a href="login.php">Login</a>
    <?php endif; ?>
</body>
</html>
