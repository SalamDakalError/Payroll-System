<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/employee.php';

$db = (new Database())->getConnection();
$employee = new Employee($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->user_id) && !empty($data->job_title_id)) {
    $employee->user_id = $data->user_id;
    $employee->job_title_id = $data->job_title_id;

    if ($employee->create()) {
        echo json_encode(array("message" => "Employee created successfully."));
    } else {
        echo json_encode(array("message" => "Unable to create employee."));
    }
} else {
    echo json_encode(array("message" => "Incomplete data."));
}
?>