<?php
class Payroll{
    private $conn;
    private $table_name = "payroll";

    public $payroll_id;
    public $employee_id;
    public $pay_period;
    public $total_hours;
    public $hours_worked;
    public $gross_pay;
    public $net_pay;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        $query = "SELECT p.payroll_id, p.employee_id, u.name, p.pay_period, p.total_hours, p.hours_worked, p.gross_pay, p.net_pay FROM " . $this->table_name . " p JOIN employee e ON p.employee_id=e.employee_id JOIN user u ON e.user_id=u.user_id ORDER BY p.payroll_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readByEmployee(){
        $query = "SELECT payroll_id, pay_period, total_hours, hours_worked, gross_pay, net_pay FROM " . $this->table_name . " WHERE employee_id = :employee_id ORDER BY pay_period DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $this->employee_id);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (employee_id, pay_period, total_hours, hours_worked, gross_pay, net_pay) VALUES (:employee_id, :pay_period, :total_hours, :hours_worked, :gross_pay, :net_pay)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $this->employee_id);
        $stmt->bindParam(':pay_period', $this->pay_period);
        $stmt->bindParam(':total_hours', $this->total_hours);
        $stmt->bindParam(':hours_worked', $this->hours_worked);
        $stmt->bindParam(':gross_pay', $this->gross_pay);
        $stmt->bindParam(':net_pay', $this->net_pay);
        return $stmt->execute();
    }

    public function calculatePayroll($employee_id, $pay_period_start, $pay_period_end) {
        // Get employee hourly rate
        $query = "SELECT hourly_rate FROM employee WHERE employee_id = :employee_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hourly_rate = $row['hourly_rate'];

        // Calculate total hours from shifts in pay period
        $query = "SELECT SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_hours FROM shift WHERE employee_id = :employee_id AND shift_date BETWEEN :start AND :end";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindParam(':start', $pay_period_start);
        $stmt->bindParam(':end', $pay_period_end);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->total_hours = $row['total_hours'] ?: 0;

        $this->gross_pay = $this->total_hours * $hourly_rate;

        // Calculate deductions
        $query = "SELECT SUM(amount) as total_deductions FROM deduction WHERE payroll_id IN (SELECT payroll_id FROM payroll WHERE employee_id = :employee_id AND pay_period = :pay_period)";
        // For new payroll, deductions will be added after creation, so for now net_pay = gross_pay
        $this->net_pay = $this->gross_pay;
    }
}

?>
