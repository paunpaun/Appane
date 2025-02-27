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
        <h4>Ordini</h4>
        <div class="records-scroll">
            <?php
                $query = "SELECT commento,indirizzo,idUser,idOrdine FROM tOrdine";
                $result = mysqli_query($db_remoto, $query);

                while($ordine = mysqli_fetch_assoc($result)){
                    $query2 = "SELECT email,telefono FROM tCliente WHERE idUser = {$ordine['idUser']}";
                    $result2 = mysqli_query($db_remoto, $query2);
                    $cliente = mysqli_fetch_assoc($result2);

                    echo "  <div style='flex: 0.4'>
                                <h1>{$cliente['email']}</h1>
                                <p>telefono: {$cliente['telefono']}</p>
                                <p>indirizzo: {$ordine['indirizzo']}</p>
                                <p>commento: {$ordine['commento']}</p>
                                <p><b>Lista prodotti:</b></p>
                                ";       

                    $query3 = "SELECT quantita,idProdotto FROM tListaProdotto WHERE idOrdine = {$ordine['idOrdine']}";
                    $result3 = mysqli_query($db_remoto, $query3);
                    while($listaProdotto = mysqli_fetch_assoc($result3)){

                        $query4 = "SELECT nome,grandezza FROM tProdotto WHERE idProdotto = {$listaProdotto['idProdotto']}";
                        $result4 = mysqli_query($db_remoto, $query4);
                        $prodotto = mysqli_fetch_assoc($result4);

                        echo" <p>prodotto: {$prodotto['nome']} - grandezza: {$prodotto['grandezza']} - quantita: {$listaProdotto['quantita']}</p>
                        </div>";
                    }
                }
            ?>
        </div>
    </div>
    

    <footer class="footer">

    </footer>

    </body>
</html>