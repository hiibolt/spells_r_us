
<?php session_start(); 

if(empty($_SESSION['cart'])) 
{
    echo"<p>Your cart is empty. Please add items before checking out </p>";
    exit();
}

//calculating cart total 
    $total = 0; 
    foreach($_SESSION['cart'] as $item){
        $total+=$item['price']; 
    }


// valid forms 
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $shippingName = $_POST['shipping_name'] ?? '';
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
            echo "<p style='color: red;' Fill out all required fields. </p>"; 
        }
        else
        {
            echo"<h2>Thank you for shopping with Spells R Us!</h2>";
            echo"<p> Your order has been placed and will be shipped to: </p>";
            echo"<p>$shippingAddress</p>";
            echo"<p>Total Amount Charged: <strong>$$total</strong></p>";
            $_SESSION['cart'] = []; 
            exit(); 
        }
        
    }
?>

<!DOCTYPE html>
<html>
<body> 

    <h1>Checkout</h1>

    <form method="POST" action="">

    <!-- cart summary-->
    <h2>Your Cart</h2>

    <?php if(!empty($_SESSION['cart'])): ?> 

        <ul>
        <?php foreach($_SESSION['cart'] as $item): ?>    
            <li>
                <?php echo htmlspecialchars($item['name']); ?>
                - $<?echo number_format($item['price'], 2); ?>
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

