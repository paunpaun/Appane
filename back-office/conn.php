<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'appane_serbanpaun';

$db_remoto = mysqli_connect($host, $user, $pass, $db_name);

if (!$db_remoto) {
    die("Errore di connessione al database: " . mysqli_connect_error());
}
?>