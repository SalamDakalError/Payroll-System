<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/payslip.php';

$db = (new Database())->getConnection();
$payslip = new Payslip($db);

try {
    $stmt = $payslip->readAll();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data for frontend
    $formatted_records = array_map(function($row) {
        return [
            'payslip_id' => $row['payslip_id'],
            'payroll_id' => $row['payroll_id'],
            'employee_name' => $row['name'],
            'pay_period' => $row['pay_period'],
            'gross_pay' => $row['gross_pay'],
            'net_pay' => $row['net_pay'],
            'issued_date' => $row['issued_date']
        ];
    }, $rows);

    echo json_encode([
        'success' => true,
        'records' => $formatted_records
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error loading payslips: ' . $e->getMessage()
    ]);
}
?>