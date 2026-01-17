<?php
class User{
    private $conn;

    public $User_Name;
    public $Last_Name;
    public $First_Name;
    public $Middle_Name;
    public $Gender;
    public $User_Type_Id;
    public $Email_Address;
    public $Password;

    public function __construct($db){
        $this->conn = $db;
    }

    function userExist(){
        $query = "SELECT * FROM tbluser WHERE User_Name=? AND Password=?";
        $stmt = $this->conn->prepare($query);

        $this->User_Name = htmlspecialchars(strip_tags($this->User_Name));
        $this->Password  = htmlspecialchars(strip_tags($this->Password));

        $stmt->bindParam(1, $this->User_Name);
        $stmt->bindParam(2, $this->Password);

        $stmt->execute();
        $num = $stmt->rowCount();

        if($num > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->User_Name     = $row['User_Name'];
            $this->First_Name    = $row['First_Name'];
            $this->Last_Name     = $row['Last_Name'];
            $this->Middle_Name   = $row['Middle_Name'];
            $this->Gender        = $row['Gender'];
            $this->User_Type_Id  = $row['User_Type_Id'];
            $this->Email_Address = $row['Email_Address'];
            $this->Password      = $row['Password'];

            return true;
        }
        return false;
    }
}
?>
