<?php
session_start();
require_once '../database/carrello.php';

if (!isset($_SESSION['idUser'])) {
    header('Location: login.php');
    exit;
}

$risultato = visualizzaCarrello();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="index.php">
                <img src="img/Appane_logo.png" alt="Appane Logo">
            </a>
        </div>
        <div class="header-text">
            <h1>Carrello</h1>
        </div>
    </header>

    <div class="main-content">
        <div class="main-content-navigation_bar">
            <a href="menu.php">Torna al Menu</a>
        </div>
        <div class="main-content-cart-container">
            <?php if ($risultato['success']): ?>
                <?php if (empty($risultato['prodotti'])): ?>
                    <p class="cart-empty">Il carrello è vuoto</p>
                <?php else: ?>
                    <div class="cart-items">
                        <?php foreach ($risultato['prodotti'] as $prodotto): ?>
                            <div class="cart-item">
                                <img src="<?= htmlspecialchars($prodotto['path']) ?>"
                                    alt="<?= htmlspecialchars($prodotto['nome']) ?>">
                                <div class="cart-item-details">
                                    <h3><?= htmlspecialchars($prodotto['nome']) ?></h3>
                                    <p><?= htmlspecialchars($prodotto['descrizione']) ?></p>
                                    <p>Prezzo: €<?= number_format($prodotto['prezzo'], 2) ?></p>
                                    <div class="quantity-controls">
                                        <button class="quantity-btn"
                                            onclick="aggiornaQuantita(<?= $prodotto['idListaProdotto'] ?>, -1)">-</button>
                                        <span class="quantity"><?= $prodotto['quantita'] ?></span>
                                        <button class="quantity-btn"
                                            onclick="aggiornaQuantita(<?= $prodotto['idListaProdotto'] ?>, 1)">+</button>
                                    </div>
                                    <p>Subtotale: €<?= number_format($prodotto['subtotale'], 2) ?></p>
                                    <button class="remove-btn"
                                        onclick="rimuoviProdotto(<?= $prodotto['idListaProdotto'] ?>)">Rimuovi</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="cart-total">
                        <h3>Totale: €<?= number_format($risultato['totale'], 2) ?></h3>
                        <button class="checkout-btn" onclick="window.location.href='checkout.php'">
                            Procedi all'acquisto
                        </button>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="error-message">Errore: <?= htmlspecialchars($risultato['message']) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <footer class="footer">
        @serbanRazban StefanPaun
    </footer>

    <script src="js/scripts.js"></script>
</body>

</html>