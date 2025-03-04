<?php

header('Content-Type: application/json');

function rimuoviProdotto($connessione, $idListaProdotto)
{
    try {
        $sql = "DELETE FROM tListaProdotto WHERE idListaProdotto = ?";
        $stmt = $connessione->prepare($sql);
        $stmt->bind_param("i", $idListaProdotto);

        if ($stmt->execute()) {
            return ['success' => true];
        }
        return ['success' => false, 'message' => 'Errore nella rimozione del prodotto'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
