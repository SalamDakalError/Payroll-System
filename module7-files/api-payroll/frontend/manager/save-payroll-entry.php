<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Content-Type: application/json");
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

include_once __DIR__ . '/../../config/core.php';
include_once __DIR__ . '/../../config/database.php';

$db = (new Database())->getConnection();

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
    exit;
}

try {
    // Start transaction
    $db->beginTransaction();

    // Insert payroll record
    $payrollQuery = "INSERT INTO payroll (employee_id, pay_period, total_hours, hours_worked, gross_pay, net_pay) VALUES (:employee_id, :pay_period, :total_hours, :hours_worked, :gross_pay, :net_pay)";
    $payrollStmt = $db->prepare($payrollQuery);
    $payrollStmt->bindParam(':employee_id', $data['employee_id']);
    $payrollStmt->bindParam(':pay_period', $data['pay_period']);
    $payrollStmt->bindParam(':total_hours', $data['total_hours']);
    $payrollStmt->bindParam(':hours_worked', $data['total_hours']); // Set hours_worked to same as total_hours
    $payrollStmt->bindParam(':gross_pay', $data['gross_pay']);
    $payrollStmt->bindParam(':net_pay', $data['net_pay']);

    if (!$payrollStmt->execute()) {
        throw new Exception("Failed to save payroll record");
    }

    // Get the payroll_id
    $payrollId = $db->lastInsertId();

    // Insert deductions (single row with all deduction types as columns)
    $deductionQuery = "INSERT INTO deduction (payroll_id, sss_amount, philhealth_amount, pagibig_amount, income_tax_amount) VALUES (:payroll_id, :sss_amount, :philhealth_amount, :pagibig_amount, :income_tax_amount)";
    $deductionStmt = $db->prepare($deductionQuery);
    $deductionStmt->bindParam(':payroll_id', $payrollId);
    $deductionStmt->bindParam(':sss_amount', $data['sss_deduction']);
    $deductionStmt->bindParam(':philhealth_amount', $data['philhealth_deduction']);
    $deductionStmt->bindParam(':pagibig_amount', $data['pagibig_deduction']);
    $deductionStmt->bindParam(':income_tax_amount', $data['income_tax_deduction']);

    if (!$deductionStmt->execute()) {
        throw new Exception("Failed to save deductions");
    }

    // Insert payslip record
    $payslipQuery = "INSERT INTO payslip (payroll_id, issued_date) VALUES (:payroll_id, CURDATE())";
    $payslipStmt = $db->prepare($payslipQuery);
    $payslipStmt->bindParam(':payroll_id', $payrollId);

    if (!$payslipStmt->execute()) {
        throw new Exception("Failed to create payslip");
    }

    // Get the payslip_id
    $payslipId = $db->lastInsertId();

    // Commit transaction
    $db->commit();

    echo json_encode([
        "success" => true,
        "message" => "Payroll entry saved successfully",
        "payroll_id" => $payrollId,
        "payslip_id" => $payslipId
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $db->rollBack();
    echo json_encode([
        "success" => false,
        "message" => "Error saving payroll: " . $e->getMessage()
    ]);
}
?>