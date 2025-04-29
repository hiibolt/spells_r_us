<?php
    session_start(); 
    require_once 'db.php';

    $userId = $_SESSION['userId'] ?? null;

    # Check that the user is an employee
    if ( !isset($userId) ) {
        header("Location: login.php");
        exit;
    }
    if ( !isset($_SESSION['isEmployee']) || $_SESSION['isEmployee'] !== 1 ) {
        header("Location: index.php");
        exit;
    }

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        if ( isset($_POST['increment_inv']) ) {
            $productId = $_POST['product_id'];
            $sql = 'UPDATE Product SET Inventory = Inventory + 1 WHERE ProductId = :productId';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['productId' => $productId]);
        } elseif ( isset($_POST['decrement_inv']) ) {
            # Check if inventory is greater than 0 before decrementing
            $sql = 'SELECT Inventory FROM Product WHERE ProductId = :productId';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['productId' => $_POST['product_id']]);
            $inventory = $stmt->fetchColumn();
            if ($inventory <= 0) {
                echo "<p>Cannot decrement inventory below 0.</p>";
                exit;
            }

            $productId = $_POST['product_id'];
            $sql = 'UPDATE Product SET Inventory = Inventory - 1 WHERE ProductId = :productId';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['productId' => $productId]);
        }
    }

    $sql = 'SELECT * FROM Product';
    $prepared = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $success = $prepared->execute();

    if ( $success ) {
        $products = $prepared->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $products = [];
        echo "<p>Failed to retrieve products.</p>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="styles/index.css">
        <link rel="stylesheet" href="styles/inventory.css">
        <link rel="stylesheet" href="styles/header.css">
    </head>
    <body>
        <?php
            require 'header.php';
        ?>
        <?php if ( isset($_GET['added']) ): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 1rem; text-align: center;">
                ✅ Product added to cart!
            </div>
        <?php endif; ?>
        
        <div class="product-grid">
            <?php foreach ( $products as $product ): ?>
                <div class="product">
                    <img src="<?= htmlspecialchars($product['ImageUrl']) ?>" alt="<?= htmlspecialchars($product['Name']) ?>">
                    <div class="product-details">
                        <div class="product-title"><?= htmlspecialchars($product['Name']) ?></div>
                        <div class="product-price">$<?= number_format($product['Price'], 2) ?></div>
                        <div class="product-description"><?= htmlspecialchars($product['Description']) ?></div>

                        <div class="product-inventory">
                            <p>
                                Inventory: <?= htmlspecialchars($product['Inventory']) ?>
                            </p>
                            <!-- Increment inventory button -->
                            <form method="POST" action="inventory.php">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['ProductId']) ?>">
                                <button type="submit" name="increment_inv" class="add-to-cart-button">+</button>
                            </form>
                            <!-- Decrement inventory button -->
                            <form method="POST" action="inventory.php">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['ProductId']) ?>">
                                <button type="submit" name="decrement_inv" class="remove-from-cart-button">-</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </body>
</html>
>>>>>>> 7aba2b3 (feat: Implemented `inventory.php` page)
