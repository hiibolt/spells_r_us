<?php
session_start(); // Always start session FIRST before any output
require 'db.php';

// Check if user is logged in
$userId = $_SESSION['userId'] ?? null;

if (!$userId) {
    echo "<p>Please log in to view your cart.</p>";
    exit;
}

// Get cart items for this user
$sql = '
SELECT p.Name, p.Price, p.ImageUrl, puc.Quantity
FROM ProductInUserCart puc
JOIN Product p ON puc.ProductId = p.ProductId
WHERE puc.UserId = :userId
';
$stmt = $pdo->prepare($sql);
$stmt->execute([':userId' => $userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
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

    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <div class="cart-container">
            <?php foreach ($cartItems as $item): ?>
                <?php
                    $itemTotal = $item['Price'] * $item['Quantity'];
                    $total += $itemTotal;
                ?>
                <div class="cart-item">
                    <img src="<?= htmlspecialchars($item['ImageUrl']) ?>" alt="<?= htmlspecialchars($item['Name']) ?>">
                    <div class="cart-item-details">
                        <div class="cart-item-name"><?= htmlspecialchars($item['Name']) ?></div>
                        <div class="cart-item-price">Price: $<?= number_format($item['Price'], 2) ?></div>
                        <div class="cart-item-quantity">Quantity: <?= (int) $item['Quantity'] ?></div>
                        <div class="cart-item-total">Item Total: $<?= number_format($itemTotal, 2) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-total">
            Total: $<?= number_format($total, 2) ?>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
