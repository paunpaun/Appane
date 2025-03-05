<?php
session_start();
require_once '../database/recall.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $residenza = $_POST['residenza'];
    $commento = $_POST['commento'];
    $idUtente = $_SESSION['idUser'];

    $idOrdine = insertOrder($commento, $residenza, $idUtente);
    if ($idOrdine) {
        $allInserted = true;
        foreach ($_SESSION['cart'] as $idProdotto => $quantita) {
            if (!insertListaProdotto($idProdotto, $quantita, $idOrdine)) {
                $allInserted = false;
                break;
            }
        }
        if ($allInserted) {
            $_SESSION['success_message'] = 'Ordine effettuato con successo';
            unset($_SESSION['cart']);
            header("Location: ../menu.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Errore durante l\'inserimento dei prodotti';
            header("Location: ../menu.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Errore durante l\'inserimento dell\'ordine';
        header("Location: ../menu.php");
        exit();
    }
}


