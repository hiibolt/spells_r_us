<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'db.php';

if (!isset($_SESSION['userId']) || $_SESSION['isEmployee'] !== 1) {
    header("Location: login.php");
    exit;
}

$orderId = $_GET['order_id'] ?? null;
if (!$orderId) {
    header("Location: fulfillment.php");
    exit;
}

// Get order and user info
$sql = "
    SELECT o.*, u.Email
    FROM `Order` o
    JOIN UserPlacesOrder uo ON o.OrderId = uo.OrderId
    JOIN `User` u ON u.UserId = uo.UserId
    WHERE o.OrderId = :orderId
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['orderId' => $orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<p>Order not found.</p>";
    exit;
}

// Get product details
$sql = "
    SELECT p.Name, p.Price, p.ImageUrl, po.Quantity
    FROM ProductPartOfOrder po
    JOIN Product p ON p.ProductId = po.ProductId
    WHERE po.OrderId = :orderId
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['orderId' => $orderId]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total already stored in TotalPrice, but recompute just to verify:
$total = 0;
foreach ($products as $p) {
    $total += $p['Price'] * $p['Quantity'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order #<?= htmlspecialchars($orderId) ?></title>
    <link rel="stylesheet" href="styles/fulfillment_order.css">
    <link rel="stylesheet" href="styles/header.css">
</head>
<body>
<?php require 'header.php'; ?>
<div class="profile-container">
    <h1>Order #<?= htmlspecialchars($orderId) ?></h1>

    <div class="product-item">
        <div style="flex: 1;">
            <h2>Customer Info</h2>
            <div class="customer-header">
                <p><strong>Email:</strong> <?= htmlspecialchars($order['Email']) ?></p>
                <span class="badge <?= strtolower($order['Status']) ?>"><?= htmlspecialchars($order['Status']) ?></span>
            </div>
            <p><strong>Shipping Address:</strong><br><?= nl2br(htmlspecialchars($order['ShippingAddress'])) ?></p>
            <p><strong>Notes:</strong> <?= htmlspecialchars($order['Notes']) ?></p>
        </div>
    </div>

    <h2>Items</h2>
    <table class="product-table">
        <thead>
        <tr>
            <th>Product</th>
            <th>Price Each</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $item): ?>
            <tr>
                <td><img src="<?= htmlspecialchars($item['ImageUrl']) ?>" class="order-img" alt="<?= htmlspecialchars($item['Name']) ?>">
                <?= htmlspecialchars($item['Name']) ?></td>
                <td>$<?= number_format($item['Price'], 2) ?></td>
                <td><?= htmlspecialchars($item['Quantity']) ?></td>
                <td>$<?= number_format($item['Price'] * $item['Quantity'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p class="total-price">Total Paid: $<?= number_format($order['TotalPrice'], 2) ?></p>

    <div class="order-button-container">
        <form method="POST" action="fulfillment.php">
            <input type="hidden" name="order_id" value="<?= $orderId ?>">
            <button type="submit" name="new_status" value="Processing">Mark Processing</button>
            <button type="submit" name="new_status" value="Shipped">Mark Shipped</button>
            <button type="submit" name="new_status" value="Cancelled">Mark Cancelled</button>
        </form>
        <form action="fulfillment.php" method="get" style="margin-bottom: 20px;">
            <button type="submit" style="padding: 8px 14px; border-radius: 5px; border: 1px solid #999; background-color: #; font-weight: bold;">
                ← Back to All Orders
            </button>
        </form>
    </div>
</div>
<?php require 'footer.php'; ?>
</body>
</html>