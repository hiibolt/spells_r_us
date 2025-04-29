<?php session_start(); 

$userId = $_SESSION['userId'] ?? null;

require_once 'db.php';

# Get all orders for the user
$sql = 'SELECT * FROM `Order` WHERE UserId = :userId';
$prepared = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$success = $prepared->execute([ ':userId' => $userId ]);

if ( $success ) {
    $orders = $prepared->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Error fetching orders.";
    exit;
}

# Calculate the total from all `TotalPrice` values
$total = 0;
foreach ( $orders as $order ) {
    $total += $order['TotalPrice'];
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
                        <p class="shipping-address">Shipping Address: <?php echo $order['ShippingAddress']; ?></p>
                        <p class="total-price">Total Price: $<?php echo number_format($order['TotalPrice'], 2); ?></p>
                        
                        <div class="order-button-container">
                            <form action="order.php" method="GET">
                                <input type="hidden" name="orderId" value="<?php echo $order['OrderId']; ?>">
                                <button type="submit" class="view-details">View Details</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="total-container">
                <h3>Total Spent: $<?php echo number_format($total, 2); ?></h3>
            </div>
        </div>
    </body>
    <?php
        require 'footer.php';
    ?>
</html>
