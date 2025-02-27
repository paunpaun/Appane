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
        <h1 onclick="window.location.href = 'index.php'">Title</h1>
        <?php
        if (isset($_POST['username'])){
            echo "<h3>{$_POST['username']}</h3>";
        }
        ?>
    </header>
    
    <div class="main-content">
        <h4>Prodotti</h4>
        <div class="records-scroll">
            <?php
                $query = "SELECT nome,prezzo,macrotipologia,grandezza,descrizione,'path' FROM tProdotto";
                $result = mysqli_query($db_remoto, $query);

                while($prodotto = mysqli_fetch_assoc($result)){
                    echo "  <div style='flex: 0.4'>
                                <img src='{$prodotto['path']}' style='width: 3em; height: 3em;'>
                                <h1>{$prodotto['nome']}</h1>
                                <p>prezzo: {$prodotto['prezzo']}€</p>
                                <p>macrotipologia: {$prodotto['macrotipologia']}</p>
                                <p>grandezza: {$prodotto['grandezza']}€</p>
                                <p>descrizione: {$prodotto['descrizione']}</p>
                            </div>";
                }
            ?>
        </div>
    </div>
    

    <footer class="footer">

    </footer>

    </body>
</html>