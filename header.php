<?php

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isEmployee() {
    return isset($_SESSION['IsEmployee']) && $_SESSION['IsEmployee'] == 1;
}

$userId = $_SESSION['userId'];

$stmt = $pdo->prepare("SELECT COUNT(*) AS CartProductCount FROM ProductInUserCart WHERE UserId = ?");
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
                    <li><a href="admin_products.php">Admin Products</a></li>
                <?php endif; ?>

                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>

            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
            <?php endif; ?>

            <li>
                <a href="cart.php">
                    Cart (<?php echo $cartItemCount; ?>)
                </a>
            </li>
        </ul>
    </nav>
</header>
<hr>