<?php
class MysqlClass
{
    private $nomehost = "192.168.8.103";
    //private $nomehost = "localhost";
    private $nomeuser = "quintaf";
    //private $nomeuser = "root";
    private $password = "Qu!nta";
    //private $password = "";
    private $database = "appane_serbanpaun";


    function connetti()
    {
        $con = mysqli_connect($this->nomehost, $this->nomeuser, $this->password, $this->database);
        if (mysqli_connect_errno()) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $con;
    }
}