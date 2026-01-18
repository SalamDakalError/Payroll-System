<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/deduction.php';

$db = (new Database())->getConnection();
$deduction = new Deduction($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->payroll_id) && !empty($data->deduction_type) && isset($data->amount)) {
    $deduction->payroll_id = $data->payroll_id;
    $deduction->deduction_type = $data->deduction_type;
    $deduction->amount = $data->amount;

    if ($deduction->create()) {
        echo json_encode(array("message" => "Deduction created successfully."));
    } else {
        echo json_encode(array("message" => "Unable to create deduction."));
    }
} else {
    echo json_encode(array("message" => "Incomplete data."));
}
?>