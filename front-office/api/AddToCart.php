<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

function aggiungiAlCarrello($idProdotto, $quantita)
{
    if (!isset($_SESSION['idUser'])) {
        return [
            'success' => false,
            'message' => 'Devi effettuare il login per aggiungere prodotti al carrello',
        ];
    }

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or update product in cart
    if (isset($_SESSION['cart'][$idProdotto])) {
        $_SESSION['cart'][$idProdotto] += $quantita;
    } else {
        $_SESSION['cart'][$idProdotto] = $quantita;
    }

    return [
        'success' => true,
        'message' => 'Prodotto aggiunto al carrello',
        'cart' => $_SESSION['cart'],
    ];
}

