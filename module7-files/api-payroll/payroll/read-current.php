<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);
    exit;
}

include_once '../config/database.php';

$db = (new Database())->getConnection();

try {
    // Get payroll records for the current logged-in employee with detailed deductions
    $query = "SELECT p.payroll_id, p.pay_period, p.total_hours, p.hours_worked, p.gross_pay, p.net_pay,
                     COALESCE(d.sss_amount, 0) as sss_amount,
                     COALESCE(d.philhealth_amount, 0) as philhealth_amount,
                     COALESCE(d.pagibig_amount, 0) as pagibig_amount,
                     COALESCE(d.income_tax_amount, 0) as income_tax_amount
              FROM payroll p
              JOIN employee e ON p.employee_id = e.employee_id
              LEFT JOIN deduction d ON p.payroll_id = d.payroll_id
              WHERE e.user_id = :user_id
              ORDER BY p.pay_period DESC";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();

    $records = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $deductions = floatval($row['sss_amount']) +
                     floatval($row['philhealth_amount']) +
                     floatval($row['pagibig_amount']) +
                     floatval($row['income_tax_amount']);

        $records[] = [
            'payroll_id' => $row['payroll_id'],
            'pay_period' => $row['pay_period'],
            'total_hours' => $row['total_hours'],
            'hours_worked' => $row['hours_worked'],
            'gross_pay' => $row['gross_pay'],
            'deductions' => $deductions,
            'sss_amount' => $row['sss_amount'],
            'philhealth_amount' => $row['philhealth_amount'],
            'pagibig_amount' => $row['pagibig_amount'],
            'income_tax_amount' => $row['income_tax_amount'],
            'net_pay' => $row['net_pay']
        ];
    }

    echo json_encode([
        'success' => true,
        'records' => $records
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error loading payroll records: ' . $e->getMessage()
    ]);
}
?>