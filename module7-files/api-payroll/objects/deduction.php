<?php
class Deduction{
    private $conn;
    private $table_name = "deduction";

    public $deduction_id;
    public $payroll_id;
    public $sss_amount;
    public $philhealth_amount;
    public $pagibig_amount;
    public $income_tax_amount;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT d.deduction_id, d.payroll_id, d.sss_amount, d.philhealth_amount, d.pagibig_amount, d.income_tax_amount FROM " . $this->table_name . " d ORDER BY d.deduction_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readByPayroll(){
        $query = "SELECT deduction_id, sss_amount, philhealth_amount, pagibig_amount, income_tax_amount FROM " . $this->table_name . " WHERE payroll_id = :payroll_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payroll_id', $this->payroll_id);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (payroll_id, sss_amount, philhealth_amount, pagibig_amount, income_tax_amount) VALUES (:payroll_id, :sss_amount, :philhealth_amount, :pagibig_amount, :income_tax_amount)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payroll_id', $this->payroll_id);
        $stmt->bindParam(':sss_amount', $this->sss_amount);
        $stmt->bindParam(':philhealth_amount', $this->philhealth_amount);
        $stmt->bindParam(':pagibig_amount', $this->pagibig_amount);
        $stmt->bindParam(':income_tax_amount', $this->income_tax_amount);
        return $stmt->execute();
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . " SET sss_amount = :sss_amount, philhealth_amount = :philhealth_amount, pagibig_amount = :pagibig_amount, income_tax_amount = :income_tax_amount WHERE deduction_id = :deduction_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sss_amount', $this->sss_amount);
        $stmt->bindParam(':philhealth_amount', $this->philhealth_amount);
        $stmt->bindParam(':pagibig_amount', $this->pagibig_amount);
        $stmt->bindParam(':income_tax_amount', $this->income_tax_amount);
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