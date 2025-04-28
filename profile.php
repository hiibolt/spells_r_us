<?php session_start(); 

$userId = $_SESSION['userId'] ?? null;

require_once 'db.php';

$sql = 'SELECT * FROM `Order` WHERE UserId = :userId';
$prepared = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$success = $prepared->execute([ ':userId' => $userId ]);

if ( $success ) {
    $orders = $prepared->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Error fetching orders.";
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
        <link rel="stylesheet" href="styles/profile.css">
        <link rel="stylesheet" href="styles/header.css">
    </head>
    <body>
        <?php
            require 'header.php';
        ?>       
        <div class="profile-container">
            <h1>Your Orders</h1>
            <div class="order-container">
                <?php foreach ( $orders as $order ): ?>
                    <div class="order">
                        <div class="order-header">
                            <h3>Order ID: <?php echo $order['OrderId']; ?></h3>
                            <span class="status"><?php echo $order['Status']; ?></span>
                        </div>
                        <p class="notes">Notes: <?php echo $order['Notes']; ?></p>
                        <p class="total-price">Total Price: $<?php echo number_format($order['TotalPrice'], 2); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </body>
</html>
