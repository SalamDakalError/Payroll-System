<?php
header("Content-Type: application/json");

include_once '../config/database.php';

$db = (new Database())->getConnection();

try {
    $query = "SELECT
        p.payroll_id,
        p.employee_id,
        p.pay_period,
        p.total_hours,
        p.hours_worked,
        p.gross_pay,
        p.net_pay,
        p.payslip_status,
        u.name as employee_name,
        d.sss_amount,
        d.philhealth_amount,
        d.pagibig_amount,
        d.income_tax_amount
    FROM payroll p
    JOIN employee e ON p.employee_id = e.employee_id
    JOIN user u ON e.user_id = u.user_id
    LEFT JOIN deduction d ON p.payroll_id = d.payroll_id
    ORDER BY p.payroll_id DESC";

    $stmt = $db->prepare($query);
    $stmt->execute();

    $records = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Build deductions array from individual columns
        $deductions = [
            'SSS' => floatval($row['sss_amount'] ?? 0),
            'PhilHealth' => floatval($row['philhealth_amount'] ?? 0),
            'Pag-IBIG' => floatval($row['pagibig_amount'] ?? 0),
            'Income Tax' => floatval($row['income_tax_amount'] ?? 0)
        ];

        $records[] = [
            'payroll_id' => $row['payroll_id'],
            'employee_id' => $row['employee_id'],
            'employee_name' => $row['employee_name'],
            'pay_period' => $row['pay_period'],
            'total_hours' => $row['total_hours'],
            'hours_worked' => $row['hours_worked'],
            'gross_pay' => $row['gross_pay'],
            'net_pay' => $row['net_pay'],
            'payslip_status' => $row['payslip_status'],
            'deductions' => $deductions
        ];
    }

    echo json_encode([
        "success" => true,
        "records" => $records
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error loading payroll records: " . $e->getMessage()
    ]);
}
?>