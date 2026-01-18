<?php
class Deduction{
    private $conn;
    private $table_name = "deduction";

    public $deduction_id;
    public $payroll_id;
    public $deduction_type;
    public $amount;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT d.deduction_id, d.payroll_id, d.deduction_type, d.amount FROM " . $this->table_name . " d ORDER BY d.deduction_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readByPayroll(){
        $query = "SELECT deduction_id, deduction_type, amount FROM " . $this->table_name . " WHERE payroll_id = :payroll_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payroll_id', $this->payroll_id);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (payroll_id, deduction_type, amount) VALUES (:payroll_id, :deduction_type, :amount)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payroll_id', $this->payroll_id);
        $stmt->bindParam(':deduction_type', $this->deduction_type);
        $stmt->bindParam(':amount', $this->amount);
        return $stmt->execute();
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . " SET deduction_type = :deduction_type, amount = :amount WHERE deduction_id = :deduction_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':deduction_type', $this->deduction_type);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':deduction_id', $this->deduction_id);
        return $stmt->execute();
    }

    public function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE deduction_id = :deduction_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':deduction_id', $this->deduction_id);
        return $stmt->execute();
    }
}
?>