<?php
session_start();
require 'db.php';


$userId = $_SESSION['userId'] ?? null;
if (!$userId) {
    echo "<p>Please log in to view your cart.</p>";
    exit;
}


$cartCleared = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clear_cart'])) {
        $clearSql = 'DELETE FROM ProductInUserCart WHERE UserId = :userId';
        $clearStmt = $pdo->prepare($clearSql);
        $clearStmt->execute([':userId' => $userId]);
        $cartCleared = true;
    }

    if (isset($_POST['remove_one']) && isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        $sql = 'SELECT Quantity FROM ProductInUserCart WHERE UserId = :userId AND ProductId = :productId';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':userId' => $userId, ':productId' => $productId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            if ((int)$item['Quantity'] > 1) {
                $updateSql = 'UPDATE ProductInUserCart SET Quantity = Quantity - 1 WHERE UserId = :userId AND ProductId = :productId';
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->execute([':userId' => $userId, ':productId' => $productId]);
            } else {
                $deleteSql = 'DELETE FROM ProductInUserCart WHERE UserId = :userId AND ProductId = :productId';
                $deleteStmt = $pdo->prepare($deleteSql);
                $deleteStmt->execute([':userId' => $userId, ':productId' => $productId]);
            }
        }
    }

    if (isset($_POST['remove_all']) && isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        $deleteSql = 'DELETE FROM ProductInUserCart WHERE UserId = :userId AND ProductId = :productId';
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteStmt->execute([':userId' => $userId, ':productId' => $productId]);
    }

    
    header('Location: cart.php');
    exit;
}


$sql = '
SELECT p.ProductId, p.Name, p.Price, p.ImageUrl, p.Inventory, puc.Quantity
FROM ProductInUserCart puc
JOIN Product p ON puc.ProductId = p.ProductId
WHERE puc.UserId = :userId
';
$stmt = $pdo->prepare($sql);
$stmt->execute([':userId' => $userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
$hasOutOfStock = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/cart.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php require 'header.php'; ?>

<main>
    <h1>Your Shopping Cart</h1>

    <?php if ($cartCleared): ?>
        <div class="success-message">
            ✅ Your cart has been cleared!
        </div>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <p style="text-align: center;">Your cart is empty.</p>

        <div class="continue-shopping">
            <a href="index.php" class="continue-shopping-button">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <?php foreach ($cartItems as $item): ?>
                <?php
                    $itemTotal = $item['Price'] * $item['Quantity'];
                    $total += $itemTotal;

                    if ($item['Inventory'] <= 0) {
                        $hasOutOfStock = true;
                    }
                ?>
                <div class="cart-item">
                    <img src="<?= htmlspecialchars($item['ImageUrl']) ?>" alt="<?= htmlspecialchars($item['Name']) ?>">
                    <div class="cart-item-details">
                        <div class="cart-item-name"><?= htmlspecialchars($item['Name']) ?></div>
                        <div class="cart-item-price">Price: $<?= number_format($item['Price'], 2) ?></div>
                        <div class="cart-item-quantity">Quantity: <?= (int) $item['Quantity'] ?></div>
                        <div class="cart-item-total">Item Total: $<?= number_format($itemTotal, 2) ?></div>

                        <?php if ($item['Inventory'] <= 0): ?>
                            <div class="out-of-stock-label">OUT OF STOCK</div>
                        <?php endif; ?>

                        
                        <form method="POST" class="remove-one-form">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['ProductId']) ?>">
                            <button type="submit" name="remove_one" class="remove-one-button">Remove 1</button>
                        </form>

                        
                        <form method="POST" class="remove-all-form">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['ProductId']) ?>">
                            <button type="submit" name="remove_all" class="remove-all-button">Remove All</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-total">
            Total: $<?= number_format($total, 2) ?>
        </div>

        
        <form method="post" class="clear-cart-form">
            <input type="hidden" name="clear_cart" value="1">
            <button type="submit" class="clear-cart-button">Clear Cart</button>
        </form>

        
        <div class="continue-shopping">
            <a href="index.php" class="continue-shopping-button">Continue Shopping</a>
        </div>

       
        <div class="continue-checkout">
            <a href="checkout.php" class="continue-checkout-button">Continue to Checkout</a>
        </div>
    <?php endif; ?>
</main>


<script>
document.querySelector('.clear-cart-form')?.addEventListener('submit', function(e) {
    if (!confirm('Are you sure you want to clear your cart?')) {
        e.preventDefault();
    }
});
</script>

</body>
</html>
