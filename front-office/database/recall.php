<?php
include 'connection.php';

$mysql = new MysqlClass();
$connessione = $mysql->connetti();

function ricercaUtenti($email, $password)
{
    global $connessione;
    $sql = "SELECT idUser FROM tCliente WHERE email = ? AND password = ?";

    if ($stmt = $connessione->prepare($sql)) {
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['idUser'];
            session_start();
            $_SESSION["idUser"] = $id;
            header("Location: index.php");
            exit();
        } else {
            echo "Email o password errati.";
        }

        $stmt->close();
    } else {
        echo "Errore nella query.";
    }
}

function selectProdotto()
{
    global $connessione;
    $sql = "SELECT idProdotto, nome, descrizione, prezzo, grandezza, macrotipologia, path FROM tProdotto WHERE 1";

    $stmt = $connessione->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="grid-item">';
            echo '<h3>' . htmlspecialchars($row['nome']) . '</h3>';
            echo '<img src="' . htmlspecialchars($row['path']) . '" alt="">';
            echo '<div class="product-details">';
            echo '<p>' . htmlspecialchars($row['descrizione']) . '</p>';
            echo '<p>Prezzo: ' . htmlspecialchars($row['prezzo']) . '€</p>';
            echo '<p>Grandezza: ' . htmlspecialchars($row['grandezza']) . '</p>';
            echo '<p>Macrotipologia: ' . htmlspecialchars($row['macrotipologia']) . '</p>';
            echo '<button class="add-to-cart" data-id="' . htmlspecialchars($row['idProdotto']) . '">Aggiungi al carrello</button>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No products found.</p>';
    }
    $stmt->close();
}

function selectProdottiById($id)
{
    global $connessione;
    $sql = "SELECT idProdotto, nome, descrizione, prezzo, grandezza, macrotipologia, path FROM tProdotto WHERE idProdotto = ?";

    if ($stmt = $connessione->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $prodotti = [];
            while ($row = $result->fetch_assoc()) {
                $prodotti[] = [
                    'idProdotto' => $row['idProdotto'],
                    'nome' => $row['nome'],
                    'descrizione' => $row['descrizione'],
                    'prezzo' => $row['prezzo'],
                    'grandezza' => $row['grandezza'],
                    'macrotipologia' => $row['macrotipologia'],
                    'path' => $row['path'],
                ];
            }
            return $prodotti;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function getUserDataById($id)
{
    global $connessione;
    $sql = "SELECT email, telefono, residenza FROM tcliente WHERE idUser = ?";

    if ($stmt = $connessione->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function insertOrder($commento, $indirizzo, $idUser)
{
    global $connessione;
    $sql = "INSERT INTO tordine (commento, indirizzo, idUser) VALUES (?, ?, ?)";

    if ($stmt = $connessione->prepare($sql)) {
        $stmt->bind_param("ssi", $commento, $indirizzo, $idUser);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function insertListaProdotto($idProdotto, $quantita, $idOrdine)
{
    global $connessione;

    if (empty($idProdotto) || empty($quantita) || empty($idOrdine)) {
        return false;
    }

    $idProdotto = (int) $idProdotto;
    $quantita = (int) $quantita;
    $idOrdine = (int) $idOrdine;

    $sql = "INSERT INTO tlistaprodotto (idProdotto, quantita, idOrdine) VALUES (?, ?, ?)";

    if ($stmt = $connessione->prepare($sql)) {
        $stmt->bind_param("iii", $idProdotto, $quantita, $idOrdine);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    } else {
        return false;
    }
}

