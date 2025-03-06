<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="index.php">
                <img src="img/Appane_logo.png" alt="Appane Logo">
            </a>
        </div>
        <div class="header-text">
            <h1>Carrello</h1>
        </div>
    </header>

    <div class="main-content">
        <div class="main-content-navigation_bar">
            <a href="menu.php">Torna al Menu</a>
        </div>
        <div class="main-content-cart-container cart-container" id="cart-container">
            <!-- Il contenuto del carrello verrà caricato qui tramite JavaScript -->
        </div>
    </div>

    <footer class="footer">
        @serbanRazban StefanPaun
    </footer>

    <script src="js/carrello.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            caricaCarrello();
        });
    </script>
</body>

</html>