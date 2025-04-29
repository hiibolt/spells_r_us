<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'db.php';

// Only employees can access
if (!isset($_SESSION['userId']) || $_SESSION['isEmployee'] !== 1) {
    header("Location: login.php");
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['new_status'])) {
    $sql = "UPDATE `Order` SET Status = :newStatus WHERE OrderId = :orderId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':newStatus' => $_POST['new_status'],
        ':orderId' => $_POST['order_id']
    ]);
    header("Location: fulfillment.php");
    exit;
}

// Fetch orders not shipped or cancelled
$sql = "
    SELECT o.OrderId, o.Status, o.ShippingAddress, o.OrderedAt, u.Email, u.UserId
    FROM `Order` o
    JOIN UserPlacesOrder uo ON o.OrderId = uo.OrderId
    JOIN `User` u ON u.UserId = uo.UserId
    WHERE o.Status NOT IN ('Shipped', 'Cancelled')
    ORDER BY o.OrderedAt DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Fulfillment</title>
    <link rel="stylesheet" href="styles/fulfillment.css">
    <link rel="stylesheet" href="styles/header.css">
</head>
<body>
<?php require 'header.php'; ?>
<div class="profile-container">
    <h1>Order Fulfillment</h1>
    <div class="order-container">
        <?php if (empty($orders)): ?>
            <p style="text-align: center; font-size: 1.2rem; color: #666; margin-top: 20px;">
                No new orders to fulfill at this time. Please check back later.
            </p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="order">
                    <div class="order-header">
                        <h3>Order #<?= htmlspecialchars($order['OrderId']) ?></h3>
                        <span class="badge <?= strtolower($order['Status']) ?>"><?= htmlspecialchars($order['Status']) ?></span>
                    </div>
                    <p><strong>User ID:</strong> <?= htmlspecialchars($order['UserId']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($order['Email']) ?></p>
                    <p><strong>Order Date:</strong> <?= htmlspecialchars($order['OrderedAt']) ?></p>
                    <p><strong>Shipping Address:</strong><br><?= nl2br(htmlspecialchars($order['ShippingAddress'])) ?></p>
                    <div class="order-button-container">
                        <form method="GET" action="fulfillment_order.php">
                            <input type="hidden" name="order_id" value="<?= $order['OrderId'] ?>">
                            <button type="submit">View Order</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php require 'footer.php'; ?>
</body>
</html>