<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function visualizzaCarrello($connessione)
{
    if (!isset($_SESSION['idUser'])) {
        return ['success' => false, 'message' => 'Utente non loggato'];
    }

    try {
        $sql = "SELECT lp.idListaProdotto, lp.quantita, p.nome, p.prezzo, p.path, p.descrizione 
                FROM tListaProdotto lp 
                JOIN tProdotto p ON lp.idProdotto = p.idProdotto 
                JOIN tOrdine o ON lp.idOrdine = o.idOrdine 
                WHERE o.idUser = ? AND o.commento IS NULL AND o.indirizzo IS NULL";

        $stmt = $connessione->prepare($sql);
        $stmt->bind_param("i", $_SESSION['idUser']);
        $stmt->execute();
        $result = $stmt->get_result();

        $prodotti = [];
        $totale = 0;

        while ($row = $result->fetch_assoc()) {
            $subtotale = $row['prezzo'] * $row['quantita'];
            $prodotti[] = [
                'idListaProdotto' => $row['idListaProdotto'],
                'nome' => $row['nome'],
                'descrizione' => $row['descrizione'],
                'prezzo' => $row['prezzo'],
                'quantita' => $row['quantita'],
                'path' => $row['path'],
                'subtotale' => $subtotale,
            ];
            $totale += $subtotale;
        }

        return ['success' => true, 'prodotti' => $prodotti, 'totale' => $totale];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
