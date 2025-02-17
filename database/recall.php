<?php
include 'connection.php';
$mysql = new MysqlClass();
$connessione = $mysql->connetti();

function ricercaUtenti($email){
    global $connessione;

    
}