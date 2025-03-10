<?php
session_start();
include 'database/recall.php';

$errore = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    ricercaUtenti($email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="index.php">
                <img src="img/Appane_logo.png" alt="Appane Logo">
            </a>
        </div>
        <div class="header-text">
            <h1>Title</h1>
        </div>
    </header>
    <div class="main-content">
        <div class="main-content-navigation_bar">
            <a href="index.php">Logout</a>
        </div>
        <div class="main-content-login">
            <div class="main-content-login-container">
                <header>Login</header>
                <?php if (!empty($errore))
                    echo "<p style='color: red; text-align: center;'>$errore</p>"; ?>
                <form class="main-content-login-container-content" method="POST" action="login.php">
                    <input type="text" name="email" placeholder="Username..." required>
                    <input type="password" name="password" placeholder="Password..." required>
                    <input type="submit" value="Login">
                </form>
                <p>Non hai un account? <a href="register.php">Registrati</a></p>
            </div>
        </div>
    </div>

    <footer class="footer">
        @serbanRazban StefanPaun
    </footer>
</body>

</html>