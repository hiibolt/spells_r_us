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
    <link rel="stylesheet" href="styles/employee_panel.css">
</head>
<body>

    <h1>Employee Panel</h1>

    <a href="outstanding_orders.php" class="button">Outstanding Orders</a>
    <a href="inventory_list.php" class="button">Inventory List</a>
    <a href="order_fulfillment.php" class="button">Order Fulfillment</a>

</body>
</html>
