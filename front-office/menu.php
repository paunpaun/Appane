<?php
session_start();
include 'database/recall.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/ordine.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="index.php">
                <img src="img/Appane_logo.png" alt="Appane Logo">
            </a>
        </div>
        <div class="header-text">
            <h1>Menu</h1>
        </div>
    </header>

    <div class="main-content">
        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success-message">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error-message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>
        <div class="main-content-navigation_bar">
            <?php
            if (isset($_SESSION["idUser"])) {
                echo "<a style='margin-right:15px'; href='carrelloUtente.php'>Carrello</a>";
                echo "<a style='margin-right:15px'; href='logout.php'>Logout</a>";
            } else {
                echo "<a style='margin-left:10px'; href='login.php'>Login</a>";
            }
            ?>
        </div>
        <div class="main-content-menu-container">
            <header class="menu-container-header">
                <h2>menu container</h2>
            </header>
            <div class="menu-container-body">
                <?php
                selectProdotto();
                ?>
            </div>
        </div>
    </div>
    <footer class="footer">
        @serbanRazban StefanPaun
    </footer>
    <script src="js/menu.js"></script>
    <script src="js/carrello.js"></script>
    <script>
        setTimeout(function () {
            var successMessage = document.querySelector('.success-message');
            var errorMessage = document.querySelector('.error-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 5000);
    </script>
</body>

</html>