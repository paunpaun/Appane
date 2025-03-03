<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'connection.php';

$mysql = new MysqlClass();
$connessione = $mysql->connetti();

header('Content-Type: application/json');

function aggiungiAlCarrello($idProdotto, $quantita)
{
    global $connessione;

    if (!isset($_SESSION['idUser'])) {
        return ['success' => false, 'message' => 'Utente non loggato'];
    }

    try {
        // Verifica se esiste già un ordine non completato per l'utente
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

        // Verifica se il prodotto è già nel carrello
        $sql = "SELECT idListaProdotto, quantita FROM tListaProdotto WHERE idOrdine = ? AND idProdotto = ?";
        $stmt = $connessione->prepare($sql);
        if (!$stmt) {
            throw new Exception($connessione->error);
        }
        $stmt->bind_param("ii", $idOrdine, $idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Aggiorna quantità esistente
            $row = $result->fetch_assoc();
            $nuovaQuantita = $row['quantita'] + $quantita;
            $sql = "UPDATE tListaProdotto SET quantita = ? WHERE idListaProdotto = ?";
            $stmt = $connessione->prepare($sql);
            if (!$stmt) {
                throw new Exception($connessione->error);
            }
            $stmt->bind_param("ii", $nuovaQuantita, $row['idListaProdotto']);
        } else {
            // Inserisci nuovo prodotto
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

function aggiornaQuantita($idListaProdotto, $delta)
{
    global $connessione;

    try {
        // Verifica la quantità attuale
        $sql = "SELECT quantita FROM tListaProdotto WHERE idListaProdotto = ?";
        $stmt = $connessione->prepare($sql);
        $stmt->bind_param("i", $idListaProdotto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nuovaQuantita = max(1, $row['quantita'] + $delta); // Impedisce quantità < 1

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

function rimuoviProdotto($idListaProdotto)
{
    global $connessione;

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

function rimuoviDalCarrello($idProdotto)
{
    if (isset($_SESSION['carrello'][$idProdotto])) {
        unset($_SESSION['carrello'][$idProdotto]);
    }
}

function ottieniCarrello()
{
    return isset($_SESSION['carrello']) ? $_SESSION['carrello'] : [];
}

function visualizzaCarrello()
{
    global $connessione;

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

// Gestisci solo le richieste AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

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