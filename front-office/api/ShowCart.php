<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../database/recall.php';
header('Content-Type: application/json');


function visualizzaCarrello()
{
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return [
            'success' => true,
            'prodotti' => [],
            'totale' => 0,
        ];
    }

    $prodotti = [];
    $totale = 0;

    foreach ($_SESSION['cart'] as $idProdotto => $quantita) {
        $dettagliProdotto = selectProdottiById($idProdotto);
        if ($dettagliProdotto) {
            $prodotto = $dettagliProdotto[0];
            $subtotale = $prodotto['prezzo'] * $quantita;
            $totale += $subtotale;

            $prodotti[] = [
                'idProdotto' => $idProdotto,
                'nome' => $prodotto['nome'],
                'descrizione' => $prodotto['descrizione'],
                'prezzo' => $prodotto['prezzo'],
                'path' => $prodotto['path'],
                'quantita' => $quantita,
                'subtotale' => $subtotale,
            ];
        }
    }

    return [
        'success' => true,
        'prodotti' => $prodotti,
        'totale' => $totale,
    ];
}
