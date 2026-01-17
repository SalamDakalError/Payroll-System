<?php
class Department{
    private $conn;
    private $table_name = "department";

    public $department_id;
    public $department_name;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT department_id, department_name FROM " . $this->table_name . " ORDER BY department_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
