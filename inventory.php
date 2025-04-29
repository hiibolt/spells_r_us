<?php
    session_start();
    require 'db.php';
    require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory List</title>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/employee_panel.css">
</head>
<body>
    <h1>Inventory List Page</h1>
    <p>This is the Inventory List page.</p>
    <a href="employee_panel.php" class="back-link">← Back to Employee Panel</a>
</body>
</html>