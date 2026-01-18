<?php
class JobTitle{
    private $conn;
    private $table_name = "job_title";

    public $job_title_id;
    public $job_title;
    public $pay_rate;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT job_title_id, job_title, pay_rate FROM " . $this->table_name . " ORDER BY job_title";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne(){
        $query = "SELECT job_title_id, job_title, pay_rate FROM " . $this->table_name . " WHERE job_title_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->job_title_id);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (job_title, pay_rate) VALUES (:job_title, :pay_rate)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':job_title', $this->job_title);
        $stmt->bindParam(':pay_rate', $this->pay_rate);
        return $stmt->execute();
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . " SET job_title = :job_title, pay_rate = :pay_rate WHERE job_title_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':job_title', $this->job_title);
        $stmt->bindParam(':pay_rate', $this->pay_rate);
        $stmt->bindParam(':id', $this->job_title_id);
        return $stmt->execute();
    }

    public function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE job_title_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->job_title_id);
        return $stmt->execute();
    }
}

?>