<?php
class Customer {
    private $conn;

    public $Customer_No;
    public $Last_Name;
    public $First_Name;
    public $Middle_Name;

    public function __construct($db){
        $this->conn = $db;
    }

    function readOne(){
        $query = "SELECT * FROM tblcustomer WHERE Customer_No = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->Customer_No);
        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $this->Last_Name   = $row['Last_Name'];
            $this->First_Name  = $row['First_Name'];
            $this->Middle_Name = $row['Middle_Name'];
            return true;
        }
        return false;
    }
}
