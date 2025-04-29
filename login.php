<?php
session_start();
require 'db.php';
require 'header.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM User WHERE Email = ? AND Password = ?');
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user'] = $user['Email'];
        $_SESSION['userId'] = $user['UserId'];
        $_SESSION['isEmployee'] = $user['IsEmployee'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid login';
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/login.css">
    </head>
    <body>
        <div class="login-container">
            <h1>Login</h1>
            <form method="post" class="login-form">
                <label for="email">Email:</label>
                <input id="email" name="email" required>

                <label for="password">Password:</label>
                <input id="password" type="password" name="password" required>

                <button type="submit">Login</button>
            </form>
            <?php if ($error): ?>
                <p class="login-alert"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </div>
    </body>
    <?php
        require 'footer.php';
    ?>
</html>
