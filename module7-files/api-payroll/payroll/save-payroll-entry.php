<?php
header("Content-Type: application/json");

include_once '../config/database.php';

$db = (new Database())->getConnection();

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
    exit;
}

try {
    $db->beginTransaction();

    // Insert into payroll table
    $query = "INSERT INTO payroll (employee_id, pay_period, total_hours, gross_pay, net_pay) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([
        $data['employee_id'],
        $data['pay_period'],
        $data['total_hours'],
        $data['gross_pay'],
        $data['net_pay']
    ]);

    $payroll_id = $db->lastInsertId();

    // Insert deductions using the correct table structure
    $deduction_query = "INSERT INTO deduction (payroll_id, sss_amount, philhealth_amount, pagibig_amount, income_tax_amount) VALUES (?, ?, ?, ?, ?)";
    $deduction_stmt = $db->prepare($deduction_query);
    $deduction_stmt->execute([
        $payroll_id,
        $data['sss_deduction'],
        $data['philhealth_deduction'],
        $data['pagibig_deduction'],
        $data['income_tax_deduction']
    ]);

    $db->commit();

    echo json_encode(["success" => true, "message" => "Payroll entry saved successfully"]);

} catch (Exception $e) {
    $db->rollBack();
    echo json_encode(["success" => false, "message" => "Error saving payroll: " . $e->getMessage()]);
}
?>