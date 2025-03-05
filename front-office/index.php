<?php
session_start();
include 'database/recall.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/hero.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.body.classList.remove("hidden");
        });
    </script>
</head>

<body class="hidden">
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
    <div class="main-content-navigation_bar">
        <?php
        if (isset($_SESSION["idUser"])) {
            echo "<a style='margin-right:25px'; href='logout.php'>Logout</a>";
        } else {
            echo "<a style='margin-right:25px'; href='login.php'>Login</a>";
        }
        ?>
    </div>

    <div class="hero">
        <h1>Welcome to Appane</h1>
        <p>Prodotti freschi, biologici e di qualita'</p>
        <a href="menu.php" class="hero-button">Shop Now</a>
    </div>
    <footer class="footer">
        @serbanRazban StefanPaun
    </footer>
</body>

</html>