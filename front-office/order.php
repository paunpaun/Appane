<?php
session_start();
require_once 'database/recall.php';

$userData = [];
if (isset($_SESSION['idUser'])) {
    $userData = getUserDataById($_SESSION['idUser']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/ordine.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riepilogo Ordine</title>
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="index.php">
                <img src="img/Appane_logo.png" alt="Appane Logo">
            </a>
        </div>
        <div class="header-text">
            <h1>Riepilogo Ordine</h1>
        </div>
    </header>
    <div class="main-content">
        <div class="main-content-navigation_bar">
            <a href="carrelloUtente.php">Torna al Carrello</a>
        </div>
        <div class="order-summary">
            <h2>Dettagli Ordine</h2>
            <?php
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo '<p>Il carrello è vuoto.</p>';
            } else {
                $totale = 0;
                echo '<table>';
                echo '<tr><th>Prodotto</th><th>Quantità</th><th>Prezzo</th><th>Subtotale</th></tr>';
                foreach ($_SESSION['cart'] as $idProdotto => $quantita) {
                    $dettagliProdotto = selectProdottiById($idProdotto);
                    if ($dettagliProdotto) {
                        $prodotto = $dettagliProdotto[0];
                        $subtotale = $prodotto['prezzo'] * $quantita;
                        $totale += $subtotale;
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($prodotto['nome'] ?? '') . '</td>';
                        echo '<td>' . htmlspecialchars($quantita) . '</td>';
                        echo '<td>€' . number_format($prodotto['prezzo'], 2) . '</td>';
                        echo '<td>€' . number_format($subtotale, 2) . '</td>';
                        echo '</tr>';
                    }
                }
                echo '<tr><td colspan="3"><strong>Totale</strong></td><td><strong>€' . number_format($totale, 2) . '</strong></td></tr>';
                echo '</table>';
            }
            ?>
        </div>
        <div class="user-details">
            <h2>Dati Utente</h2>
            <form action="api/process_order.php" method="post">
                <label for="residenza">Residenza:</label>
                <input type="text" id="residenza" name="residenza"
                    value="<?php echo htmlspecialchars($userData['residenza'] ?? ''); ?>" required>

                <label for="commento">Commento:</label>
                <textarea id="commento" name="commento" rows="4" cols="50"></textarea>
                <input type="hidden" name="commento" id="hiddenCommento">

                <button type="submit">Conferma Ordine</button>
            </form>
        </div>
    </div>
    <footer class="footer">
        @serbanRazban StefanPaun
    </footer>
    <script src="js/carrello.js"></script>
    <script>
        document.getElementById('commento').addEventListener('input', function () {
            document.getElementById('hiddenCommento').value = this.value;
        });
    </script>
</body>

</html>