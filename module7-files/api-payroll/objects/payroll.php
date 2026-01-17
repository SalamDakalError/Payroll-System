<?php
class Payroll{
    private $conn;
    private $table_name = "payroll";

    public $payroll_id;
    public $employee_id;
    public $pay_period;
    public $net_salary;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (employee_id,pay_period,net_salary) VALUES (:eid,:pp,:ns)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':eid',$this->employee_id);
        $stmt->bindParam(':pp',$this->pay_period);
        $stmt->bindParam(':ns',$this->net_salary);
        return $stmt->execute();
    }
}

?>
