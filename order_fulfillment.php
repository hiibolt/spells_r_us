<?php
    session_start();
    require 'db.php';
    require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Fulfillment</title>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/employee_panel.css">
</head>

<body>
    <h1>Order Fulfillment Page</h1>
    <p>This is the Order Fulfillment page.</p>
    <a href="employee_panel.php" class="back-link">← Back to Employee Panel</a>
</body>
</html>