<?php
session_start();
require 'db.php';
require 'header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['signup_email'] ?? '';
    $password = $_POST['signup_password'] ?? '';
    $confirmPassword = $_POST['signup_confirm_password'] ?? '';

    if (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM User WHERE Email = ?');
        $stmt->execute([$email]);
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            $error = 'Email already registered. Please use a different email.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO User (Email, Password, IsEmployee) VALUES (?, ?, 0)');
            $successfullyInserted = $stmt->execute([$email, $password]);

            if ($successfullyInserted) {
                $success = 'Account created successfully! You can now <a href="login.php">login</a>.';
            } else {
                $error = 'An error occurred. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/signup.css">
    </head>
    <body>
        <div class="signup-container">
            <h1>Sign Up</h1>
            <form method="post" class="signup-form">
                <label for="signup_email">Email:</label>
                <input id="signup_email" name="signup_email" type="email" required>

                <label for="signup_password">Password (minimum 8 characters):</label>
                <input id="signup_password" name="signup_password" type="password" required>

                <label for="signup_confirm_password">Confirm Password:</label>
                <input id="signup_confirm_password" name="signup_confirm_password" type="password" required>

                <button type="submit">Sign Up</button>
            </form>

            <?php if ($error): ?>
                <p class="signup-alert"><?= htmlspecialchars($error) ?></p>
            <?php elseif ($success): ?>
                <p style="color: green; text-align: center;"><?= $success ?></p>
            <?php endif; ?>
        </div>
    </body>
    <?php
        require 'footer.php';
    ?>
</html>
