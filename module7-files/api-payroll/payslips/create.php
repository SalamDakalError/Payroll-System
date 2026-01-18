<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/payslip.php';

$db = (new Database())->getConnection();
$payslip = new Payslip($db);

$data = json_decode(file_get_contents("php://input"));

try {
    if (!empty($data->payroll_id)) {
        // Check if payslip already exists for this payroll
        $check_query = "SELECT payslip_id FROM payslip WHERE payroll_id = :payroll_id";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(':payroll_id', $data->payroll_id);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Payslip already exists for this payroll record.'
            ]);
            exit;
        }

        $payslip->payroll_id = $data->payroll_id;
        $payslip->issued_date = date('Y-m-d');

        if ($payslip->create()) {
            // Update payslip_status in payroll table
            $update_query = "UPDATE payroll SET payslip_status = 'issued' WHERE payroll_id = :payroll_id";
            $update_stmt = $db->prepare($update_query);
            $update_stmt->bindParam(':payroll_id', $data->payroll_id);
            $update_stmt->execute();

            echo json_encode([
                'success' => true,
                'message' => 'Payslip issued successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Unable to issue payslip.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Payroll ID is required.'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>