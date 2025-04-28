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

            $userId = $_SESSION['user'] ?? null;

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']) && isset($_POST['product_id']) && $userId) {
                $productId = (int)$_POST['product_id'];
            
                // Check if product already in cart
                $stmt = $pdo->prepare("SELECT Quantity FROM ProductInUserCart WHERE UserId = ? AND ProductId = ?");
                $stmt->execute([$userId, $productId]);
                $existing = $stmt->fetch();
            
                if ($existing) {
                    // Update quantity
                    $stmt = $pdo->prepare("UPDATE ProductInUserCart SET Quantity = Quantity + 1 WHERE UserId = ? AND ProductId = ?");
                    $stmt->execute([$userId, $productId]);
                } else {
                    // Insert new row
                    $stmt = $pdo->prepare("INSERT INTO ProductInUserCart (UserId, ProductId, Quantity) VALUES (?, ?, 1)");
                    $stmt->execute([$userId, $productId]);
                }
                exit;
            }
        ?>
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
                                echo "<form method='POST'>";
                                    echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($product['ProductID']) . "'>";
                                    echo "<button type='submit' name='add_to_cart'>Add to Cart</button>";
                                echo "</form>";
                            echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Failed to retrieve products.</p>";
                }
            ?>
        </div>
    </body>
</html>
