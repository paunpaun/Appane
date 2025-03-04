<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

function aggiungiAlCarrello($connessione, $idProdotto, $quantita)
{
    if (!isset($_SESSION['idUser'])) {
        return ['success' => false, 'message' => 'Utente non loggato'];
    }

    try {
        $sql = "SELECT idOrdine FROM tOrdine WHERE idUser = ? AND commento IS NULL AND indirizzo IS NULL";
        $stmt = $connessione->prepare($sql);
        if (!$stmt) {
            throw new Exception($connessione->error);
        }
        $stmt->bind_param("i", $_SESSION['idUser']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $idOrdine = $row['idOrdine'];
        } else {
            // Crea un nuovo ordine
            $sql = "INSERT INTO tOrdine (idUser, commento, indirizzo) VALUES (?, NULL, NULL)";
            $stmt = $connessione->prepare($sql);
            if (!$stmt) {
                throw new Exception($connessione->error);
            }
            $stmt->bind_param("i", $_SESSION['idUser']);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $idOrdine = $connessione->insert_id;
        }
        $sql = "SELECT idListaProdotto, quantita FROM tListaProdotto WHERE idOrdine = ? AND idProdotto = ?";
        $stmt = $connessione->prepare($sql);
        if (!$stmt) {
            throw new Exception($connessione->error);
        }
        $stmt->bind_param("ii", $idOrdine, $idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nuovaQuantita = $row['quantita'] + $quantita;
            $sql = "UPDATE tListaProdotto SET quantita = ? WHERE idListaProdotto = ?";
            $stmt = $connessione->prepare($sql);
            if (!$stmt) {
                throw new Exception($connessione->error);
            }
            $stmt->bind_param("ii", $nuovaQuantita, $row['idListaProdotto']);
        } else {
            $sql = "INSERT INTO tListaProdotto (quantita, idProdotto, idOrdine) VALUES (?, ?, ?)";
            $stmt = $connessione->prepare($sql);
            if (!$stmt) {
                throw new Exception($connessione->error);
            }
            $stmt->bind_param("iii", $quantita, $idProdotto, $idOrdine);
        }

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        return ['success' => true, 'message' => 'Prodotto aggiunto al carrello'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Errore: ' . $e->getMessage()];
    }
}
