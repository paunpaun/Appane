<?php
$host = '192.168.8.103';
$user = 'quintaf';
$pass = 'Qu!nta';
$db_name = 'appane_paun';

$db_remoto = mysqli_connect($host, $user, $pass, $db_name);

if (!$db_remoto) {
    die("Errore di connessione al database: " . mysqli_connect_error());
}
?>