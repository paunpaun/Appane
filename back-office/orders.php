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
        <h4>Ordini</h4>
        <div class="records-scroll">
            <form method="POST" action="">
                <?php
                    $query = "SELECT commento,indirizzo,idUser,idOrdine FROM tOrdine";
                    $result = mysqli_query($db_remoto, $query);

                    while($ordine = mysqli_fetch_assoc($result)){
                        $query2 = "SELECT email,telefono FROM tCliente WHERE idUser = {$ordine['idUser']}";
                        $result2 = mysqli_query($db_remoto, $query2);
                        $cliente = mysqli_fetch_assoc($result2);

                        echo "<div style='flex: 0.4'>
                                <h1>{$cliente['email']}</h1>
                                <p>telefono: {$cliente['telefono']}</p>
                                <p>indirizzo: {$ordine['indirizzo']}</p>
                                <p>commento: {$ordine['commento']}</p>
                                <p><b>Lista prodotti:</b></p>";       

                        $query3 = "SELECT quantita,idProdotto FROM tListaProdotto WHERE idOrdine = {$ordine['idOrdine']}";
                        $result3 = mysqli_query($db_remoto, $query3);
                        while($listaProdotto = mysqli_fetch_assoc($result3)){
                            $query4 = "SELECT nome,grandezza FROM tProdotto WHERE idProdotto = {$listaProdotto['idProdotto']}";
                            $result4 = mysqli_query($db_remoto, $query4);
                            $prodotto = mysqli_fetch_assoc($result4);

                            echo "<p>prodotto: {$prodotto['nome']} - grandezza: {$prodotto['grandezza']} - quantita: {$listaProdotto['quantita']}</p>";
                        }
                        
                        echo "<div style='margin-top: 10px;'>
                                <input type='checkbox' name='completed_orders[]' value='{$ordine['idOrdine']}' id='ordine-{$ordine['idOrdine']}'>
                                <label for='ordine-{$ordine['idOrdine']}'>segna come completato</label>
                            </div>";
                        
                        echo "</div>";
                    }
                ?>
                
                <div style="margin: 20px 0;">
                    <button type="submit" name="remove_completed" class="submit-btn">Rimuovi ordini completati</button>
                </div>
            </form>
            
            <?php
                if(isset($_POST['remove_completed']) && isset($_POST['completed_orders'])) {
                    $completed_orders = $_POST['completed_orders'];
                    
                    foreach($completed_orders as $order_id) {
                        $query = "DELETE FROM tListaProdotto WHERE idOrdine = $order_id";
                        mysqli_query($db_remoto, $query);
                    
                        $query = "DELETE FROM tOrdine WHERE idOrdine = $order_id";
                        mysqli_query($db_remoto, $query);
                    }
                    
                    echo "<script>window.location.href = 'orders.php';</script>";
                }
            ?>
        </div>
    </div>

    <footer class="footer">

    </footer>

    </body>
</html>