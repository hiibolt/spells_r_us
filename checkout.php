<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/checkout.css">
</head>
<body> 
<?php session_start(); 
require 'db.php';
require 'header.php';

$userId = $_SESSION['userId'] ?? null;

if (!$userId) {
    echo "<p>Please log in to checkout.</p>";
    exit;
}

$sql = '
SELECT p.ProductId, p.Name, p.Price, p.ImageUrl, puc.Quantity
FROM ProductInUserCart puc
JOIN Product p ON puc.ProductId = p.ProductId
WHERE puc.UserId = :userId
';
$stmt = $pdo->prepare($sql);
$stmt->execute([':userId' => $userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(empty($cartItems)) 
{
    echo"<p>Your cart is empty. Please add items before checking out </p>";
    exit();
}

    $total = 0; 
    foreach($cartItems as $item){
        $total+=$item['Price'] * $item['Quantity']; 
    }
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $shippingName = $_POST['shippingName'] ?? '';
        $shippingAddress = $_POST['shippingAddress'] ?? '';
        $shippingCity = $_POST['shippingCity'] ?? '';
        $shippingState = $_POST['shippingState'] ?? '';
        $shippingZip = $_POST['shippingZip'] ?? '';
        $cardNum = $_POST['cardNum'] ?? '';
        $cardExp = $_POST['cardExp'] ?? '';
        $cardCvv = $_POST['cardCvv'] ?? '';
        $cardName = $_POST['cardName'] ?? '';
        $notes = $_POST['Notes'] ?? '';

        $errors = [];

        if(empty($shippingName) || empty($shippingAddress) || empty($shippingCity) 
           || empty($shippingState) || empty($shippingZip) || empty($cardNum) || empty($cardName)
           || empty($cardExp) || empty($cardCvv)) 
        {
            $errors[] = "<p style='color: red;'>Fill out all required fields. </p>"; 
        }

        $cardNum = preg_replace('/[\s-]/', '', $cardNum);
        $cardExp = trim($cardExp);

        if (!preg_match('/^\d{5}$/', $shippingZip)) {
            $errors[] = "Please enter a valid 5-digit ZIP code.";
        }
        if (!preg_match('/^\d{16}$/', $cardNum)) {
            $errors[] = "Please enter a valid 16-digit credit card number.";
        }
        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $cardExp)) {
            $errors[] = "Please enter a valid expiration date (MM/YY).";
        }
        if (!preg_match('/^\d{3,4}$/', $cardCvv)) {
            $errors[] = "Please enter a valid 3 or 4-digit CVV.";
        }
    
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
            }
        } else {   
            $fullShippingAddress = $shippingAddress . ', ' . $shippingCity . ', ' . $shippingState . ' ' . $shippingZip;
            $sql = '
                    INSERT INTO `Order` (UserId, Status, Notes, TotalPrice, ShippingAddress)
                    VALUES (:userId, :status, :notes, :total, :address)
                    ';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':userId' => $userId,
                        ':status' => 'Pending',
                        ':notes' => $notes,
                        ':total' => $total,
                        ':address' => $fullShippingAddress
                    ]);
                    
            $orderId = $pdo->lastInsertId();

            $_SESSION['cart'] = []; 
            $sql = 'DELETE FROM ProductInUserCart WHERE UserId = :userId';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':userId' => $userId]);

            # Add code to insert ProductPartOfOrder
            foreach ($cartItems as $item) {
                $sql = '
                    INSERT INTO ProductPartOfOrder (OrderId, ProductId, Quantity)
                    VALUES (:orderId, :productId, :quantity)
                ';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':orderId' => $orderId,
                    ':productId' => $item['ProductId'],
                    ':quantity' => $item['Quantity']
                ]);
            }
            
            # Update product quantity in Product table
            foreach($cartItems as $item) {
                $sql = 'UPDATE Product SET Inventory = Inventory - :quantity WHERE ProductId = :productId';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':quantity' => $item['Quantity'],
                    ':productId' => $item['ProductId']
                ]);
            }

            # Add code to insert UserPlacesOrder
            $sql = ' INSERT INTO UserPlacesOrder (UserId, OrderId) VALUES (:userId, :orderId)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':userId' => $userId,
                ':orderId' => $orderId
            ]);

            echo '<div class="thank-you-container">
            <h2>Thank you for shopping with Spells R Us!</h2>
            <p> Your order has been placed and will be shipped to: </p>
            <p>' . htmlspecialchars($fullShippingAddress) . '</p>
            <p>Total Amount Charged: <strong>$' . number_format($total,2) . '</strong></p>
            <a class="continue-shopping-btn" href="index.php"> Continue Shopping</a>
            </div>
            </body>
            </html>';
            exit(); 
        }
    }
?>
    <h1>Checkout</h1>
    <form method="POST" action="">

    <h2>Your Cart</h2>
    <?php if(!empty($cartItems)): ?> 

        <ul>
        <?php foreach($cartItems as $item): ?>    
            <li>
                <?php echo (int)$item['Quantity']; ?>x - 
                <?php echo htmlspecialchars($item['Name']); ?>
                - $<?php echo number_format($item['Price'], 2); ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total: $<?php echo number_format($total, 2);?></strong></p>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
    

    <label for ="shippingName">Full Name:</label><br>
    <input type ="text" id="shippingName" name="shippingName" required><br><br>

    <label for="shippingAddress">Street Address:</label><br>
    <input type ="text" id="shippingAddress" name="shippingAddress" required><br><br> 

    <label for="shippingCity">City:</label><br>
    <input type="text" id="shippingCity" name="shippingCity" required><br><br>

    <label for="shippingState">State:</label><br>
    <input type="text" id="shippingState" name="shippingState" required><br><br> 

    <label for="shippingZip">Zip Code:</label><br>
    <input type="text" id="shippingZip" name="shippingZip" required><br><br> 


    <h2>Billing Information</h2>

    <label for="cardNum">Card Number:</label><br>
    <input type="text" id="cardNum" name="cardNum" required><br><br>

    <label for="cardExp">Expiration Date (MM/YY):</label><br>
    <input type ="text" id="cardExp" name="cardExp" required><br><br> 

    <label for="cardCvv">CVV:</label><br>
    <input type="text" id="cardCvv" name="cardCvv" required><br><br>

    <label for="cardName">Name on Card:</label><br>
    <input type="text" id="cardName" name="cardName" required><br><br> 
    
    <label for="Notes">Notes (optional):</label><br>
    <input type="text" id="Notes" name="Notes"><br><br>


    <input type="submit" value="Place Order">
    </form>
    </body>
</html>

