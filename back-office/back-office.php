

<html>
    <head>

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">


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
        <button id="new-product"><h4>Visualizza i prodotti</h4></button>
        <button id="publish-menu"><h4>Pubblica nuovo menu</h4></button>
        <button id="see-clients"><h4>Visualizza i clienti</h4></button>
        <button id="view-orders"><h4>Visualizza gli ordini</h4></button>
        <button id="view-statistics"><h4>Visualizza riepilogo</h4></button>
    </div>
    </div>
    

    <footer class="footer">

    </footer>

    </body>
</html>