<?php
class Employee{
    private $conn;
    private $table_name = "employee";

    public $employee_id;
    public $user_id;
    public $job_title;
    public $hourly_rate;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT e.employee_id, u.name, e.job_title, e.hourly_rate FROM " . $this->table_name . " e JOIN user u ON e.user_id=u.user_id ORDER BY e.employee_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne(){
        $query = "SELECT e.employee_id, u.name, e.job_title, e.hourly_rate FROM " . $this->table_name . " e JOIN user u ON e.user_id=u.user_id WHERE e.employee_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->employee_id);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (user_id, job_title, hourly_rate) VALUES (:uid, :job_title, :hourly_rate)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $this->user_id);
        $stmt->bindParam(':job_title', $this->job_title);
        $stmt->bindParam(':hourly_rate', $this->hourly_rate);
        return $stmt->execute();
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . " SET job_title = :job_title, hourly_rate = :hourly_rate WHERE employee_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':job_title', $this->job_title);
        $stmt->bindParam(':hourly_rate', $this->hourly_rate);
        $stmt->bindParam(':id', $this->employee_id);
        return $stmt->execute();
    }
}

?>
