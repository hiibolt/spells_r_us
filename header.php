<?php
	require 'db.php';

	function isLoggedIn() {
		return isset($_SESSION['user']);
	}

	function isEmployee() {
		return isset($_SESSION['isEmployee']) && $_SESSION['isEmployee'] == 1;
	}

	$userId = $_SESSION['userId'];

	$stmt = $pdo->prepare("SELECT COALESCE(SUM(Quantity), 0) AS CartItemCount FROM ProductInUserCart WHERE UserId = ?;");
	$stmt->execute([$userId]);
	$cartItemCount = $stmt->fetchColumn();
?>

<header class="header">
    <div class="logo">
        <a href="index.php">
            <img src="https://github.com/user-attachments/assets/1ee556c6-eb4f-46d2-9193-1fa30767753e" style="height:50px;" alt="Logo">
        </a>
    </div>

    <nav class="nav">
		<ul class="nav-links">
			<?php if (isLoggedIn()): ?>
				<?php if (isEmployee()): ?>
					<li><a href="employee_panel.php" class="button-link">Employee Panel</a></li>
				<?php endif; ?>

				<li><a href="profile.php" class="button-link">Profile</a></li>
				<li><a href="logout.php" class="button-link">Logout</a></li>

			<?php else: ?>
				<li><a href="login.php" class="button-link">Login</a></li>
				<li><a href="signup.php" class="button-link">Sign Up</a></li>
			<?php endif; ?>

			<li>
				<a href="cart.php" class="button-link">
					Cart (<?php echo $cartItemCount; ?>)
				</a>
			</li>
		</ul>
    </nav>
</header>
<hr>