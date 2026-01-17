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
}

?>
