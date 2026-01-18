<?php
header("Content-Type: application/json");

include_once '../config/database.php';

$db = (new Database())->getConnection();

$payrollId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$payrollId) {
    echo json_encode([
        "success" => false,
        "message" => "Payroll ID is required"
    ]);
    exit;
}

try {
    $query = "SELECT
        p.payroll_id,
        p.employee_id,
        p.pay_period,
        p.total_hours,
        p.hours_worked,
        p.gross_pay,
        p.net_pay,
        u.name as employee_name,
        e.job_title_id,
        jt.job_title,
        jt.pay_rate,
        d.sss_amount,
        d.philhealth_amount,
        d.pagibig_amount,
        d.income_tax_amount
    FROM payroll p
    JOIN employee e ON p.employee_id = e.employee_id
    JOIN user u ON e.user_id = u.user_id
    LEFT JOIN job_title jt ON e.job_title_id = jt.job_title_id
    LEFT JOIN deduction d ON p.payroll_id = d.payroll_id
    WHERE p.payroll_id = :payroll_id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':payroll_id', $payrollId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Parse deductions
        $deductions = [
            'SSS' => floatval($row['sss_amount'] ?? 0),
            'PhilHealth' => floatval($row['philhealth_amount'] ?? 0),
            'Pag-IBIG' => floatval($row['pagibig_amount'] ?? 0),
            'Income Tax' => floatval($row['income_tax_amount'] ?? 0)
        ];

        echo json_encode([
            "success" => true,
            "payroll" => [
                'payroll_id' => $row['payroll_id'],
                'employee_id' => $row['employee_id'],
                'employee_name' => $row['employee_name'],
                'pay_period' => $row['pay_period'],
                'total_hours' => $row['total_hours'],
                'hours_worked' => $row['hours_worked'],
                'gross_pay' => $row['gross_pay'],
                'net_pay' => $row['net_pay'],
                'job_title' => $row['job_title'],
                'pay_rate' => $row['pay_rate'],
                'deductions' => $deductions
            ]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Payroll record not found"
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error loading payroll: " . $e->getMessage()
    ]);
}
?>