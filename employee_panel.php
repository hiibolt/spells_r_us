<?php
    session_start();
    require 'db.php';
    require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Employee Panel</title>
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/cart.css">
    </head>
    <body>
        <div class="employee-container">
            <h1 style="text-align:center;padding-bottom:1.5rem;">Employee Panel</h1>

            <div class="continue-shopping">
                <a href="inventory.php" class="clear-cart-button">Inventory List</a>
            </div>
            <div class="continue-shopping">
                <a href="order_fulfillment.php" class="continue-shopping-button">Order Fulfillment</a>
            </div>
        </div>
    </body>
</html>
