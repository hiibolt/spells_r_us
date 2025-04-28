<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="styles/index.css">
        <link rel="stylesheet" href="styles/header.css">
    </head>
    <body>
        <?php
            require 'header.php';
            require 'db.php';
        ?>
        <h1>Welcome</h1>

        <div class="product-grid">
            <?php
                $sql = 'SELECT * FROM Product';
                $prepared = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $success = $prepared->execute();

                if ($success) {
                    $products = $prepared->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($products as $product) {
                        echo "<div class='product'>";
                            echo "<img src='{$product['ImageUrl']}' alt='{$product['Name']}' width=103px height=154px/>";
                            echo "<div class='product-details'>";
                                echo "<div class='product-title'>" . htmlspecialchars($product['Name']) . "</div>";
                                echo "<div class='product-price'>$" . htmlspecialchars($product['Price']) . "</div>";
                                echo "<div class='product-description'>" . htmlspecialchars($product['Description']) . "</div>";
                                echo "<button onclick=\"location.href='product.php?id=" . htmlspecialchars($product['ProductID']) . "'\">Add to Cart</button>";
                            echo "</div>";
                        echo "</div>";
                        
                    }
                } else {
                    echo "<p>Failed to retrieve products.</p>";
                }
            ?>
        </div>

        <?php if (isset($_SESSION['user'])): ?>
            <p>Hello, <?= htmlspecialchars($_SESSION['user']) ?>!</p>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <p>You are not logged in.</p>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </body>
</html>
