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
        <h1 onclick="window.location.href = 'index.php'">Appane</h1>
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
                $query = "SELECT nome,prezzo,categoria_id,grandezza,descrizione,path FROM tProdotto";
                $result = mysqli_query($db_remoto, $query);

                while($prodotto = mysqli_fetch_assoc($result)){
                    $query2 = "SELECT nome FROM tcategoria where id = {$prodotto['categoria_id']}";
                    $result2 = mysqli_query($db_remoto, $query2);
                    $categoria = mysqli_fetch_assoc($result2);
                    echo "  <div style='flex: 0.4'>
                                <h1>{$prodotto['nome']}</h1>
                                <img src='{$prodotto['path']}' style='width: 7em; height: 7em;'>
                                <p>prezzo: {$prodotto['prezzo']}€</p>
                                <p>macrotipologia: {$categoria['nome']}</p>
                                <p>grandezza: {$prodotto['grandezza']}</p>
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