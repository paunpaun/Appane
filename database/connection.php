<?php
class MysqlClass
{
    private $nomehost = "192.168.8.103"; 
    private $nomeuser = "quintaf";       
    private $password = "Qu!nta";           
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