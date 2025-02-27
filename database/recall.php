<?php
include 'connection.php';

$mysql = new MysqlClass();
$connessione = $mysql->connetti();

function ricercaUtenti($email, $password){
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

function selectProdotto() {
    global $connessione;
    $sql = "SELECT nome, descrizione, prezzo, grandezza, macrotipologia FROM tProdotto WHERE 1";

    $stmt = $connessione->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="grid-item">';
            echo '<h3>' . htmlspecialchars($row['nome']) . '</h3>';
            echo '<img src="img/' . htmlspecialchars($row['nome']) . '.jpg" alt="">';
            echo '<p>' . htmlspecialchars($row['descrizione']) . '</p>';
            echo '<p>Prezzo: ' . htmlspecialchars($row['prezzo']) . '€</p>';
            echo '<p>Grandezza: ' . htmlspecialchars($row['grandezza']) . '</p>';
            echo '<p>Macrotipologia: ' . htmlspecialchars($row['macrotipologia']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No products found.</p>';
    }
    $stmt->close();
}
