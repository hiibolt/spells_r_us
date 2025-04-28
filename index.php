<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
        <?php
            require 'header.php';
            require 'db.php';
        ?>
        <h1>Welcome</h1>

        <div class="product-container">
            <?php
                $sql = 'SELECT * FROM Product';
                $prepared = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $success = $prepared->execute();

                if ($success) {
                    $products = $prepared->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($products as $product) {
                        echo "<div class='product'>";
                        echo "<h2>{$product['Name']}</h2>";
                        echo "<p>Price: \${$product['Price']}</p>";
                        echo "<p>Description: {$product['Description']}</p>";
                        echo "<p>Inventory: {$product['Inventory']}</p>";
                        echo "<img src='{$product['ImageUrl']}' alt='{$product['Name']}' width=103px height=154px/>";
                        echo "<form method='POST' action='add_to_cart.php'>";
                        echo "<input type='hidden' name='product_id' value='{$product['ProductID']}' />";
                        echo "<input type='number' name='quantity' value='1' min='1' max='{$product['Inventory']}' />";
                        echo "<input type='submit' value='Add to Cart' />";
                        echo "</form>";
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
