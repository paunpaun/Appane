<?php
    session_start()
?>
<html>
    <head>

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


    </head>
    <body>

    <header class="header">
        <h1 onclick="window.location.href = 'index.php'">Appane</h1>
        <?php
        if (isset($_SESSION['username'])){
            echo "<h3>{$_SESSION['username']}</h3>";
        }
        ?>
    </header>
    
    <div class="main-content">

    <div class="buttons-container">
        <div class="cliente">
            <h4>Riepilogo</h4>
            <div class="dettagli ">

            </div>
        </div>
    </div>
    </div>
    

    <footer class="footer">

    </footer>

    </body>
</html>