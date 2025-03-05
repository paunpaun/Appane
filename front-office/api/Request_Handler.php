<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'AddToCart.php';
require_once 'RemoveFromCart.php';
require_once 'UpdateQuantity.php';
require_once 'ShowCart.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Azione non valida'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update':
                if (isset($_POST['idProdotto']) && isset($_POST['delta'])) {
                    $response = aggiornaQuantita(intval($_POST['idProdotto']), intval($_POST['delta']));
                }
                break;

            case 'remove':
                if (isset($_POST['idProdotto'])) {
                    $response = rimuoviProdotto(intval($_POST['idProdotto']));
                }
                break;

            case 'show':
                $response = visualizzaCarrello();
                break;
        }
    } elseif (isset($_POST['idProdotto']) && isset($_POST['quantita'])) {
        $response = aggiungiAlCarrello(intval($_POST['idProdotto']), intval($_POST['quantita']));
    }
}

echo json_encode($response);
exit;