<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

function rimuoviProdotto($idProdotto)
{
    if (!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$idProdotto])) {
        return [
            'success' => false,
            'message' => 'Prodotto non trovato nel carrello',
        ];
    }

    try {
        unset($_SESSION['cart'][$idProdotto]);

        return [
            'success' => true,
            'message' => 'Prodotto rimosso dal carrello',
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage(),
        ];
    }
}
