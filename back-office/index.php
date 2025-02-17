<?php
    session_start()
?>

<html>
    <head>

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>

    </head>
    <body>

    <header class="header">
        <h1>Title</h1>
    </header>
    
    <div class="main-content">
        <?php
        if (isset($_POST['username'])){
            echo "<h3>{$_POST['username']}</h3>";
        }
        ?>

    <div class="buttons-container">
        <button id="view-products" onclick="window.location.href = 'products.php'"><h4>Visualizza i prodotti</h4></button>
        <button id="publish-menu" onclick="window.location.href = 'menu.php'"><h4>Pubblica nuovo menu</h4></button>
        <button id="view-clients" onclick="window.location.href = 'clients.php'"><h4>Visualizza i clienti</h4></button>
        <button id="view-orders" onclick="window.location.href = 'orders.php'"><h4>Visualizza gli ordini</h4></button>
        <button id="view-statistics" onclick="window.location.href = 'statistics.php'"><h4>Visualizza riepilogo</h4></button>
    </div>
    </div>
    

    <footer class="footer">
        <p>footer</p>
    </footer>

    </body>
</html>