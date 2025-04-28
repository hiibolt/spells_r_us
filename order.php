<?php session_start(); 
    require_once 'db.php';

    $orderId = $_GET['orderId'] ?? null;
    $userId = $_SESSION['userId'] ?? null;

    # Verify if user is logged in and there is an orderId
    if ( !isset($userId) ) {
        header('Location: login.php');
        exit;
    }
    if ( !isset($orderId) ) {
        header('Location: profile.php');
        exit;
    }

    # Get the order details and make sure it belongs to the user
    $sql = 'SELECT * FROM `Order` WHERE OrderId = :orderId';
    $prepared = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $success = $prepared->execute([ ':orderId' => $orderId ]);

    if ( $success ) {
        $order = $prepared->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Error fetching order.";
        exit;
    }
    if ( $order['UserId'] != $userId ) {
        header('Location: profile.php');
        exit;
    }

    # Get the order products along with each product's details
    $sql = 'SELECT p.Name, p.Price, p.ImageUrl, op.Quantity
            FROM ProductPartOfOrder op
            JOIN Product p ON op.ProductId = p.ProductId
            WHERE op.OrderId = :orderId';
    $prepared = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $success = $prepared->execute([ ':orderId' => $orderId ]);
    if ( $success ) {
        $products = $prepared->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Error fetching products.";
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
        <link rel="stylesheet" href="styles/order.css">
        <link rel="stylesheet" href="styles/header.css">
    </head>
    <body>
        <?php
            require 'header.php';
        ?>
        <div class="profile-container">
            <div class="order-details">
                <div class="order-header">
                    <h3>Order ID: <?php echo $order['OrderId']; ?></h3>
                    <span class="status"><?php echo $order['Status']; ?></span>
                </div>
                <p class="notes">Notes: <?php echo $order['Notes']; ?></p>
                <p class="total-price">Total Price: $<?php echo number_format($order['TotalPrice'], 2); ?></p>
                <div profile-container>
                    <h3>Products:</h3>
                    <ul>
                        <?php foreach ( $products as $product ): ?>
                            <div class="product-item">
                                <table class="product-table">
                                    <td>
                                        <img src="<?php echo $product['ImageUrl']; ?>" alt="<?php echo $product['ProductName']; ?>" class="product-image">
                                    </td>
                                    <td>
                                        <h4><?php echo $product['Name']; ?></h4>
                                    </td>
                                    <td>
                                        <p>Quantity: <?php echo $product['Quantity']; ?></p>
                                    </td>
                                    <td>
                                        <p>Price: $<?php echo number_format($product['Price'], 2); ?></p>
                                    </td>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    </ul>
                    <div class="order-button-container">
                        <form action="profile.php" method="POST">
                            <button type="submit" class="back-button">Back to Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
