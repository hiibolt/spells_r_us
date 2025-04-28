<?php

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isEmployee() {
    return isset($_SESSION['IsEmployee']) && $_SESSION['IsEmployee'] == 1;
}

$cartItemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ToDo! Website</title>
    <link rel="stylesheet" href="styles/header.css">
</head>
<body>
<header class="header">
    <div class="logo">
        <a href="index.php">
            <img src="https://github.com/user-attachments/assets/f022246c-f63f-4733-afb5-b8f2889a3ceb" style="height:50px;" alt="Logo">
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