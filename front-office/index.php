<?php  
session_start();
include '../database/recall.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <?php  
            if(isset($_SESSION["idUser"])){
                echo "benvenuto ".$_SESSION["idUser"];
            }
            ?>
        </div>
    </header>
    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome to Appane</h1>
        <p>Your one-stop shop for all your needs</p>
        <a href="menu.php" class="hero-button">Shop Now</a>
    </div>
    <footer class="footer">
        @serbanRazban StefanPaun
    </footer>
</body>
</html>