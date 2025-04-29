<?php session_start(); 

$userId = $_SESSION['userId'] ?? null;

require_once 'db.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']) && isset($_POST['product_id']) && $userId ) {
    $productId = $_POST['product_id'];
    $toAdd = $_POST['quantity'] ?? 1;

    // Check if product already in cart
    $sql = 'SELECT Quantity FROM ProductInUserCart WHERE UserId = :userId AND ProductId = :productId';
    $stmt = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(':userId' => $userId, ':productId' => $productId));
    $existing = $stmt->fetch();

    if ( $existing ) {
        #echo "Product already in cart. Quantity: " . $existing['Quantity'] . ". Product ID: " . $productId;
        
        $sql = 'UPDATE ProductInUserCart SET Quantity = Quantity + :toAdd WHERE UserId = :userId AND ProductId = :productId';
        $stmt = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':userId' => $userId, ':productId' => $productId, ':toAdd' => $toAdd));
    } else {
        #echo "Product not in cart. Adding to cart.";
        
        $sql = 'INSERT INTO ProductInUserCart (UserId, ProductId, Quantity) VALUES (:userId, :productId, :toAdd)';
        $stmt = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $success = $stmt->execute(array(':userId' => $userId, ':productId' => $productId, ':toAdd' => $toAdd));
    }

    // Redirect to avoid form resubmission
    header("Location: index.php?added=1");
    exit;
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

                        <?php if ( $product['Inventory'] <= 0 ): ?>
                            <div class="product-out-of-stock" style="text-align:center;">Out of Stock</div>
                        <?php elseif ( $userId ): ?>
                            <form method="POST" style="display:flex;align-items:center;justify-content:space-between;">
                                <input type="number" name="quantity" min="1" value="1" max="<?= $product['Inventory'] ?>" class="quantity-input">
                                <input type="hidden" name="product_id" value="<?= $product['ProductId'] ?>">
                                <button type="submit" name="add_to_cart">Add to Cart</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </body>
</html>
