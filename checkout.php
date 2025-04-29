<?php session_start(); 
require 'db.php';
require 'header.php';


// check if user is logged in
$userId = $_SESSION['userId'] ?? null;

if (!$userId) {
    echo "<p>Please log in to checkout.</p>";
    exit;
}

// get cart items for this user
$sql = '
SELECT p.Name, p.Price, p.ImageUrl, puc.Quantity
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

//calculating cart total 
    $total = 0; 
    foreach($cartItems as $item){
        $total+=$item['Price'] * $item['Quantity']; 
    }


// valid forms 
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

        if(empty($shippingName) || empty($shippingAddress) || empty($shippingCity) 
           || empty($shippingState) || empty($shippingZip) || empty($cardNum) || empty($cardName)
           || empty($cardExp) || empty($cardCvv)) 
        {
            echo "<p style='color: red;'>Fill out all required fields. </p>"; 
        }
        else
        {   
            $_SESSION['cart'] = []; 
            
            echo '<div class="thank-you-container">
            <h2>Thank you for shopping with Spells R Us!</h2>
            <p> Your order has been placed and will be shipped to: </p>
            <p>' . htmlspecialchars($shippingAddress) . '</p>
            <p>Total Amount Charged: <strong>$' . number_format($total,2) . '</strong></p>
            <a class="continue-shopping-btn" href="index.php"> Continue Shopping</a>
            </div>';
            
            exit(); 
        }
        
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles/header.css">
</head>
<body> 

    <h1>Checkout</h1>

    <form method="POST" action="">

    <!-- cart summary-->
    <h2>Your Cart</h2>

    <?php if(!empty($_SESSION['cart'])): ?> 

        <ul>
        <?php foreach($cartItems as $item): ?>    
            <li>
                <?php echo htmlspecialchars($item['name']); ?>
                - $<?php echo number_format($item['price'], 2); ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total: $<?php echo number_format($total, 2);?></strong></p>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
    
    <!-- shipping form -->  

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



    <!-- billing form -->
    <h2>Billing Information</h2>

    <label for="cardNum">Card Number:</label><br>
    <input type="text" id="cardNum" name="cardNum" required><br><br>

    <label for="cardExp">Expiration Date (MM/YY):</label><br>
    <input type ="text" id="cardExp" name="cardExp" required><br><br> 

    <label for="cardCvv">CVV:</label><br>
    <input type="text" id="cardCvv" name="cardCvv" required><br><br>

    <label for="cardName">Name on Card:</label><br>
    <input type="text" id="cardName" name="cardName" required><br><br> 
    
    <!-- submit button--> 
    <input type="submit" value="Place Order">
    </form>
    </body>
</html>

