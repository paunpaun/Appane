

<html>
    <head>

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">


    </head>
    <body>

    <h1>Title</h1>
   
    <?php
    if (isset($_POST['username'])){
        echo "<h3>{$_POST['username']}</h3>";
    }
    ?>

    <div class="buttons-container">
        <button id="new-product"><h3>Visualizza i prodotti</h3></button>
        <button id="publish-menu"><h3>Pubblica nuovo menu</h3></button>
        <button id="see-clients"><h3>Visualizza i clienti</h3></button>
        <button id="view-orders"><h3>Visualizza gli ordini</h3></button>
        <button id="view-statistics"><h3>Visualizza riepilogo</h3></button>
    </div>

    </body>
</html>