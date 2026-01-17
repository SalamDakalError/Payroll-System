<?php
class Role{
    private $conn;
    private $table_name = "role";

    public $role_id;
    public $role_name;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT role_id, role_name FROM " . $this->table_name . " ORDER BY role_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " SET role_name=:role_name";
        $stmt = $this->conn->prepare($query);
        $this->role_name = htmlspecialchars(strip_tags($this->role_name));
        $stmt->bindParam(":role_name", $this->role_name);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}

?>
