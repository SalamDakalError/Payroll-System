<?php
class Payslip{
    private $conn;
    private $table_name = "payslip";

    public $payslip_id;
    public $payroll_id;
    public $issued_date;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT p.payslip_id, p.payroll_id, p.issued_date, pr.pay_period, pr.total_hours, pr.gross_pay, pr.net_pay, u.name FROM " . $this->table_name . " p JOIN payroll pr ON p.payroll_id = pr.payroll_id JOIN employee e ON pr.employee_id = e.employee_id JOIN user u ON e.user_id = u.user_id ORDER BY p.issued_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne(){
        $query = "SELECT p.payslip_id, p.payroll_id, p.issued_date, pr.pay_period, pr.total_hours, pr.gross_pay, pr.net_pay FROM " . $this->table_name . " p JOIN payroll pr ON p.payroll_id = pr.payroll_id WHERE p.payroll_id = :payroll_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payroll_id', $this->payroll_id);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (payroll_id, issued_date) VALUES (:payroll_id, :issued_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payroll_id', $this->payroll_id);
        $stmt->bindParam(':issued_date', $this->issued_date);
        return $stmt->execute();
    }
}

?>
