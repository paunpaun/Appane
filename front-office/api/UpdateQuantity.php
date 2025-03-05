<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
function aggiornaQuantita($idProdotto, $delta)
{
    if (!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$idProdotto])) {
        return [
            'success' => false,
            'message' => 'Prodotto non trovato nel carrello',
        ];
    }
    try {
        $nuovaQuantita = $_SESSION['cart'][$idProdotto] + $delta;
        if ($nuovaQuantita < 1) {
            return [
                'success' => false,
                'message' => 'La quantità non può essere inferiore a 1',
            ];
        }
        $_SESSION['cart'][$idProdotto] = $nuovaQuantita;
        return [
            'success' => true,
            'message' => 'Quantità aggiornata con successo',
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage(),
            'quantita' => $_SESSION['cart'][$idProdotto],
        ];
    }
}
