<?php
    require_once('conn.php');
    session_start();

    if(isset($_POST['submit'])) {
        $menu_name = $_POST['menu_name'];
        
        if(empty($menu_name)) {
            echo "<h2><red> Inserisci un nome per il menu </red></h2>";
        } 
        elseif(!isset($_POST['prodotti']) || empty($_POST['prodotti'])) {
            echo "<h2><red> Seleziona almeno un prodotto </red></h2>";
        }
        else {
            $query = "INSERT INTO tMenu (nome, attivo) VALUES ('$menu_name' , 0)";
            if(mysqli_query($db_remoto, $query)) {
                $menu_id = mysqli_insert_id($db_remoto);
                
                foreach($_POST['prodotti'] as $prodotto_id) {
                    $query = "INSERT INTO tlistaprodottomenu (idMenu, idProdotto) VALUES ($menu_id, $prodotto_id)";
                    mysqli_query($db_remoto, $query);
                }
            }
        }
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
        if (isset($_SESSION['username'])){
            echo "<h3>{$_SESSION['username']}</h3>";
        }
        ?>
    </header>
    
    <div class="main-content">
        <h4>Prodotti</h4>
        <div class="records-scroll" style="margin-left: 10%; margin-right: 10%;">
            <?php
                $query = "SELECT idMenu,nome FROM tMenu where attivo = 1";
                $result = mysqli_query($db_remoto, $query);

                while($menu = mysqli_fetch_assoc($result)){
                    echo "  <div style='flex: 0.4'>
                                        <h1>Menu corrente:{$menu['nome']}</h1>";
                    $query2 = "SELECT idProdotto FROM tlistaprodottomenu where idMenu = {$menu['idMenu']}";
                    $result2 = mysqli_query($db_remoto, $query2);
                    while($listaprodotto = mysqli_fetch_assoc($result2)){
                        $query3 = "SELECT nome,prezzo,path FROM tProdotto where idProdotto = {$listaprodotto['idProdotto']}";
                        $result3 = mysqli_query($db_remoto, $query3);
                        while($prodotto = mysqli_fetch_assoc($result3)){
                            echo "
                                        <img src='{$prodotto['path']}' style='width: 4em; height: 4em;'>
                                        <p>nome: {$prodotto['nome']}</p>
                                        <p>prezzo: {$prodotto['prezzo']}€</p>
                                    </div>";
                        }
                        
                    }
                    
                }
            ?>
    <div>
    </div>
    <div>
    <h2>Aggiungi nuovo menu</h2>
    <form action="" method="POST">
        <div>
            <p>Nome menu:</p>
            <input type="text" id="menu-name" name="menu_name" required>
        </div>
        
        <div>
            <h3>Seleziona i prodotti</h3>
                <?php
                $query4 = "SELECT idProdotto, nome, prezzo FROM tProdotto WHERE 1";
                $result4 = mysqli_query($db_remoto, $query4);
                
                while($prodotto = mysqli_fetch_assoc($result4)) {
                    echo "<div class='product-item'>";
                    echo "<input type='checkbox' name='prodotti[]' value='{$prodotto['idProdotto']}' id='prodotto-{$prodotto['idProdotto']}'>";
                    echo "<label for='prodotto-{$prodotto['idProdotto']}'>{$prodotto['nome']} - €{$prodotto['prezzo']}</label>";
                    echo "</div>";
                }
                ?>
        </div>
            <button type="submit" name="submit" class="submit-btn">Pubblica menu</button>
            </form>


    <h4>Seleziona Menu attivo</h4>
        <div style="margin-left: 10%; margin-right: 10%;">
            <form method="POST" action="">
                <?php
                    $query = "SELECT idMenu, nome, attivo FROM tMenu";
                    $result = mysqli_query($db_remoto, $query);
                    
                    while($menu = mysqli_fetch_assoc($result)){
                        if($menu['attivo'] == 1) {
                            $checked = 'checked';
                        } else {
                            $checked = '';
                        } 
                        echo "<div>
                                <input type='radio' name='active_menu' value='{$menu['idMenu']}' $checked>
                                <label>{$menu['nome']}</label>
                            </div>";
                    }
                ?>
                <input type="submit" name="update_active_menu" value="aggiorna menu attivo">
            </form>
        </div>

    <?php
        if(isset($_POST['update_active_menu']) && isset($_POST['active_menu'])) {
            $active_menu_id = $_POST['active_menu'];
            
            $query = "UPDATE tMenu SET attivo = 0";
            mysqli_query($db_remoto, $query);
            
            $query = "UPDATE tMenu SET attivo = 1 WHERE idMenu = $active_menu_id";
            mysqli_query($db_remoto, $query);
        }
    ?>

    </div>
    

    <footer class="footer">

    </footer>

    </body>
</html>