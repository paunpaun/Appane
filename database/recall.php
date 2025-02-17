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

