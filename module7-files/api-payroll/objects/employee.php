<?php
class Employee{
    private $conn;
    private $table_name = "employee";

    public $employee_id;
    public $user_id;
    public $job_title_id;
    public $hire_date;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT e.employee_id, u.name, jt.job_title, jt.pay_rate, e.job_title_id, e.hire_date FROM " . $this->table_name . " e JOIN user u ON e.user_id=u.user_id LEFT JOIN job_title jt ON e.job_title_id=jt.job_title_id ORDER BY e.employee_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne(){
        $query = "SELECT e.employee_id, e.user_id, u.name, jt.job_title, jt.pay_rate, e.job_title_id, e.hire_date FROM " . $this->table_name . " e JOIN user u ON e.user_id=u.user_id LEFT JOIN job_title jt ON e.job_title_id=jt.job_title_id WHERE e.employee_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->employee_id);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (user_id, job_title_id, hire_date) VALUES (:uid, :job_title_id, :hire_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $this->user_id);
        $stmt->bindParam(':job_title_id', $this->job_title_id);
        $stmt->bindParam(':hire_date', $this->hire_date);
        return $stmt->execute();
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . " SET job_title_id = :job_title_id, hire_date = :hire_date WHERE employee_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':job_title_id', $this->job_title_id);
        $stmt->bindParam(':hire_date', $this->hire_date);
        $stmt->bindParam(':id', $this->employee_id);
        return $stmt->execute();
    }
}

?>
