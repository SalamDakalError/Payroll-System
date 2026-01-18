<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/payroll.php';

$db = (new Database())->getConnection();
$payroll = new Payroll($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->employee_id) && !empty($data->pay_period) && isset($data->total_hours) && isset($data->gross_pay) && isset($data->net_pay)) {
    $payroll->employee_id = $data->employee_id;
    $payroll->pay_period = $data->pay_period;
    $payroll->total_hours = $data->total_hours;
    $payroll->gross_pay = $data->gross_pay;
    $payroll->net_pay = $data->net_pay;

    if ($payroll->create()) {
        echo json_encode(array("message" => "Payroll created successfully."));
    } else {
        echo json_encode(array("message" => "Unable to create payroll."));
    }
} else {
    echo json_encode(array("message" => "Incomplete data."));
}
?>