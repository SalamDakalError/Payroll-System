<?php
class Employee{
    private $conn;
    private $table_name = "employee";

    public $employee_id;
    public $user_id;
    public $department_id;
    public $hire_date;
    public $salary;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT e.employee_id,u.name,e.hire_date,e.salary,d.department_name FROM " . $this->table_name . " e JOIN user u ON e.user_id=u.user_id JOIN department d ON e.department_id=d.department_id ORDER BY e.employee_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
