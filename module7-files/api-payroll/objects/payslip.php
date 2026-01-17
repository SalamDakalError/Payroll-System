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
}

?>
