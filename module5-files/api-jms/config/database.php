<?php
class Database{ 
 
    private $hostJMS = "127.0.0.1"; 
    private $db_nameJMS = " payroll_system"; 
    private $usernameJMS = "root";
    private $passwordJMS = ""; 
    public $connJMS; 

    public function getConnection(){ 
        $this->connJMS = null; 

        try{
            $this->connJMS = new PDO("mysql:host=" . $this->hostJMS . ";dbname=" . $this->db_nameJMS, $this->usernameJMS, $this->passwordJMS);
            $this->connJMS->exec("set names utf8");
        }catch(PDOException $exceptionJMS){ 
            echo "Connection error: " . $exceptionJMS->getMessage();
        }

        return $this->connJMS;
    }
}
?>