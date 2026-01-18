<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/payroll.php';

$db = (new Database())->getConnection();
$payroll = new Payroll($db);

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['employee_id']) || !isset($data['pay_period'])) {
    echo json_encode(["success" => false, "message" => "Missing required data"]);
    exit;
}

// Check if payroll already exists for this employee and pay period
$query = "SELECT payroll_id FROM payroll WHERE employee_id = :employee_id AND pay_period = :pay_period";
$stmt = $db->prepare($query);
$stmt->bindParam(':employee_id', $data['employee_id']);
$stmt->bindParam(':pay_period', $data['pay_period']);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo json_encode(["success" => false, "message" => "Payroll already exists for this employee and pay period"]);
    exit;
}

// Set payroll data
$payroll->employee_id = $data['employee_id'];
$payroll->pay_period = $data['pay_period'];
$payroll->total_hours = $data['total_hours'];
$payroll->hours_worked = $data['total_hours']; // For backward compatibility
$payroll->gross_pay = $data['gross_pay'];
$payroll->net_pay = $data['net_pay'];

if ($payroll->create()) {
    $payroll_id = $db->lastInsertId();

    // Insert deductions
    $deductions = [
        ['SSS', $data['sss_deduction']],
        ['PhilHealth', $data['philhealth_deduction']],
        ['Pag-IBIG', $data['pagibig_deduction']],
        ['Income Tax', $data['income_tax_deduction']]
    ];

    foreach ($deductions as $deduction) {
        if ($deduction[1] > 0) {
            $query = "INSERT INTO deduction (payroll_id, deduction_type, amount) VALUES (:payroll_id, :type, :amount)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':payroll_id', $payroll_id);
            $stmt->bindParam(':type', $deduction[0]);
            $stmt->bindParam(':amount', $deduction[1]);
            $stmt->execute();
        }
    }

    echo json_encode([
        "success" => true,
        "message" => "Payroll entry saved successfully",
        "payroll_id" => $payroll_id
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to save payroll entry"
    ]);
}
?>