<?php

    require_once("conn.php");

    session_start();
    if (isset($_POST['username'])){
        $_SESSION['username'] = $_POST['username'];
    }
?>
<html>
    <head>

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


    </head>
    <body>

    <header class="header">
        <h1>Title</h1>
        <?php
        if (isset($_SESSION['username'])){
            echo "<h3>{$_SESSION['username']}</h3>";
        }
        ?>
    </header>
    
    <div class="main-content">

    <div class="buttons-container">
        <div class="cliente">
            <h4>Prodotti</h4>
            <div class="dettagli ">

            </div>
        </div>
    </div>
    </div>
    

    <footer class="footer">

    </footer>

    </body>
</html>