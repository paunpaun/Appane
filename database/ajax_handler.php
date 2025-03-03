<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'connection.php';
require_once 'carrello.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => 'Azione non valida'];

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update':
                if (isset($_POST['idListaProdotto']) && isset($_POST['delta'])) {
                    $response = aggiornaQuantita(
                        intval($_POST['idListaProdotto']),
                        intval($_POST['delta']),
                    );
                }
                break;

            case 'remove':
                if (isset($_POST['idListaProdotto'])) {
                    $response = rimuoviProdotto(intval($_POST['idListaProdotto']));
                }
                break;
        }
    } elseif (isset($_POST['idProdotto']) && isset($_POST['quantita'])) {
        $response = aggiungiAlCarrello(
            intval($_POST['idProdotto']),
            intval($_POST['quantita']),
        );
    }

    echo json_encode($response);
    exit;
}
?>