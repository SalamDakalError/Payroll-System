<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/payslip.php';

$db = (new Database())->getConnection();
$payslip = new Payslip($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->payroll_id) && !empty($data->issued_date)) {
    $payslip->payroll_id = $data->payroll_id;
    $payslip->issued_date = $data->issued_date;

    if ($payslip->create()) {
        echo json_encode(array("message" => "Payslip created successfully."));
    } else {
        echo json_encode(array("message" => "Unable to create payslip."));
    }
} else {
    echo json_encode(array("message" => "Incomplete data."));
}
?>