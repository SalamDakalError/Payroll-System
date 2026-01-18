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

    // Insert deductions
    $deductions = [
        ['SSS', $data['sss_deduction']],
        ['PhilHealth', $data['philhealth_deduction']],
        ['Pag-IBIG', $data['pagibig_deduction']],
        ['Income Tax', $data['income_tax_deduction']]
    ];

    $deduction_query = "INSERT INTO deduction (payroll_id, deduction_type, amount) VALUES (?, ?, ?)";
    $deduction_stmt = $db->prepare($deduction_query);

    foreach ($deductions as $deduction) {
        if ($deduction[1] > 0) {
            $deduction_stmt->execute([$payroll_id, $deduction[0], $deduction[1]]);
        }
    }

    $db->commit();

    echo json_encode(["success" => true, "message" => "Payroll entry saved successfully"]);

} catch (Exception $e) {
    $db->rollBack();
    echo json_encode(["success" => false, "message" => "Error saving payroll: " . $e->getMessage()]);
}
?>