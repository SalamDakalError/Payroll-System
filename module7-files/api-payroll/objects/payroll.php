<?php
class Payroll{
    private $conn;
    private $table_name = "payroll";

    public $payroll_id;
    public $employee_id;
    public $pay_period;
    public $gross_salary;
    public $sss_employee;
    public $sss_employer;
    public $philhealth_employee;
    public $philhealth_employer;
    public $pagibig_employee;
    public $pagibig_employer;
    public $income_tax;
    public $total_deductions;
    public $net_salary;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (employee_id,pay_period,gross_salary,sss_employee,sss_employer,philhealth_employee,philhealth_employer,pagibig_employee,pagibig_employer,income_tax,total_deductions,net_salary) VALUES (:eid,:pp,:gs,:se,:ser,:pe,:per,:pge,:pger,:it,:td,:ns)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':eid',$this->employee_id);
        $stmt->bindParam(':pp',$this->pay_period);
        $stmt->bindParam(':gs',$this->gross_salary);
        $stmt->bindParam(':se',$this->sss_employee);
        $stmt->bindParam(':ser',$this->sss_employer);
        $stmt->bindParam(':pe',$this->philhealth_employee);
        $stmt->bindParam(':per',$this->philhealth_employer);
        $stmt->bindParam(':pge',$this->pagibig_employee);
        $stmt->bindParam(':pger',$this->pagibig_employer);
        $stmt->bindParam(':it',$this->income_tax);
        $stmt->bindParam(':td',$this->total_deductions);
        $stmt->bindParam(':ns',$this->net_salary);
        return $stmt->execute();
    }

    public function calculateDeductions($salary) {
        $this->gross_salary = $salary;

        // SSS: 15% of MSC, 5% employee, 10% employer
        // MSC is capped at certain amount, but for simplicity, assume salary is MSC
        $sss_total = $salary * 0.15;
        $this->sss_employee = $sss_total * (5/15);
        $this->sss_employer = $sss_total * (10/15);

        // PhilHealth: 5% of basic monthly salary, ceiling ₱100,000, 2.5% each
        $philhealth_base = min($salary, 100000);
        $philhealth_total = $philhealth_base * 0.05;
        $this->philhealth_employee = $philhealth_total / 2;
        $this->philhealth_employer = $philhealth_total / 2;

        // Pag-IBIG: 2% of monthly compensation, max ₱10,000, 1% each
        $pagibig_base = min($salary, 10000);
        $pagibig_total = $pagibig_base * 0.02;
        $this->pagibig_employee = $pagibig_total / 2;
        $this->pagibig_employer = $pagibig_total / 2;

        // Income Tax: Based on taxable income = gross - pre-tax deductions
        $taxable_income = $salary - ($this->sss_employee + $this->philhealth_employee + $this->pagibig_employee);
        
        // Philippine Income Tax brackets (monthly approximation for withholding)
        // Actually, BIR has specific withholding tables, but simplified:
        if ($taxable_income <= 250000 / 12) { // ~20833
            $this->income_tax = 0;
        } elseif ($taxable_income <= 400000 / 12) { // ~33333
            $this->income_tax = ($taxable_income - 20833.33) * 0.20;
        } elseif ($taxable_income <= 800000 / 12) { // ~66666
            $this->income_tax = (12500 * 0.20) + ($taxable_income - 33333.33) * 0.25;
        } elseif ($taxable_income <= 2000000 / 12) { // ~166666
            $this->income_tax = (12500 * 0.20) + (33333.33 * 0.25) + ($taxable_income - 66666.67) * 0.30;
        } elseif ($taxable_income <= 8000000 / 12) { // ~666666
            $this->income_tax = (12500 * 0.20) + (33333.33 * 0.25) + (100000 * 0.30) + ($taxable_income - 166666.67) * 0.32;
        } else {
            $this->income_tax = (12500 * 0.20) + (33333.33 * 0.25) + (100000 * 0.30) + (500000 * 0.32) + ($taxable_income - 666666.67) * 0.35;
        }

        $this->total_deductions = $this->sss_employee + $this->philhealth_employee + $this->pagibig_employee + $this->income_tax;
        $this->net_salary = $salary - $this->total_deductions;
    }
}

?>
