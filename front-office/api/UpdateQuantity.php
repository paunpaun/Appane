<?php


header('Content-Type: application/json');

function aggiornaQuantita($connessione, $idListaProdotto, $delta)
{

    try {
        $sql = "SELECT quantita FROM tListaProdotto WHERE idListaProdotto = ?";
        $stmt = $connessione->prepare($sql);
        $stmt->bind_param("i", $idListaProdotto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nuovaQuantita = max(1, $row['quantita'] + $delta);
            $sql = "UPDATE tListaProdotto SET quantita = ? WHERE idListaProdotto = ?";
            $stmt = $connessione->prepare($sql);
            $stmt->bind_param("ii", $nuovaQuantita, $idListaProdotto);

            if ($stmt->execute()) {
                return ['success' => true];
            }
        }
        return ['success' => false, 'message' => 'Prodotto non trovato'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}