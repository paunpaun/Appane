<?php
class MysqlClass
{
    private $nomehost = "192.168.8.103";  // Cambiato da "192.168.8.103" a "localhost"
    private $nomeuser = "quintaf";       // Cambiato da "quintaf" a "root"
    private $password = "Qu!nta";           // Password vuota per l'installazione predefinita di XAMPP
    private $database = "";  // Mantieni il nome del database se lo hai già creato localmente

    function connetti()
    {
        $con = mysqli_connect($this->nomehost, $this->nomeuser, $this->password, $this->database);
        if (mysqli_connect_errno()) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $con;
    }
}