<?php
class MysqlClass
{
    private $nomehostSchool = "192.168.8.103";
    private $nomehost = "localhost";
    private $nomeuserSchool = "quintaf";
    private $nomeuser = "root";
    private $passwordSchool = "Qu!nta";
    private $password = "";
    private $database = "appane_paun";


    function connetti()
    {
        $con = mysqli_connect($this->nomehost, $this->nomeuser, $this->password, $this->database);
        if (mysqli_connect_errno()) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $con;
    }
}