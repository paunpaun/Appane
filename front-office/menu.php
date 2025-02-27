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
            <img src="img/Appane_logo.png" alt="">
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

    <div class="main-content">
        <div class="main-content-navigation_bar">
        <?php  
            if(isset($_SESSION["idUser"])){
                echo "<a style='margin-left:10px'; href='logout.php'>Logout</a>";
            }else{
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
</body>
</html>