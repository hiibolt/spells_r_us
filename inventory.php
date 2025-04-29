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
        if (isset($_POST['set_inventory'])) {
            $productId = $_POST['product_id'];
            $newInventory = max(0, intval($_POST['new_inventory']));
        
            $sql = 'UPDATE Product SET Inventory = :newInventory WHERE ProductId = :productId';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'newInventory' => $newInventory,
                'productId' => $productId
            ]);
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
        
        <div class="product-grid">
            <?php foreach ( $products as $product ): ?>
                <div class="product">
                    <img src="<?= htmlspecialchars($product['ImageUrl']) ?>" alt="<?= htmlspecialchars($product['Name']) ?>">
                    <div class="product-details">
                        <div class="product-title"><?= htmlspecialchars($product['Name']) ?></div>
                        <div class="product-price">$<?= number_format($product['Price'], 2) ?></div>
                        <div class="product-description"><?= htmlspecialchars($product['Description']) ?></div>

                        <div class="product-inventory">
                            <p>Inventory: <?= htmlspecialchars($product['Inventory']) ?></p>
                            
                            <form method="POST" action="inventory.php" style="display: flex; gap: 0.5rem; align-items: center;">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['ProductId']) ?>">
                                <input type="number" name="new_inventory" min="0" value="<?= htmlspecialchars($product['Inventory']) ?>" style="width: 60px;">
                                <button type="submit" name="set_inventory" class="set-inventory-button">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </body>
    <?php
        require 'footer.php';
    ?>
</html>