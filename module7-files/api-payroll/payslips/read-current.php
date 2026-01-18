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
    // Get payslips for the current logged-in employee
    $query = "SELECT p.payslip_id, p.payroll_id, p.issued_date, pr.pay_period, pr.total_hours, pr.gross_pay, pr.net_pay
              FROM payslip p
              JOIN payroll pr ON p.payroll_id = pr.payroll_id
              JOIN employee e ON pr.employee_id = e.employee_id
              WHERE e.user_id = :user_id
              ORDER BY p.issued_date DESC";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();

    $records = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $records[] = [
            'payslip_id' => $row['payslip_id'],
            'payroll_id' => $row['payroll_id'],
            'pay_period' => $row['pay_period'],
            'gross_pay' => $row['gross_pay'],
            'net_pay' => $row['net_pay'],
            'issued_date' => $row['issued_date']
        ];
    }

    echo json_encode([
        'success' => true,
        'records' => $records
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error loading payslips: ' . $e->getMessage()
    ]);
}
?>