<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/employee.php';

$db = (new Database())->getConnection();
$employee = new Employee($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->employee_id)) {
    $employee->employee_id = $data->employee_id;
    $employee->job_title_id = $data->job_title_id ?? null;

    if ($employee->update()) {
        echo json_encode(array("message" => "Employee updated successfully."));
    } else {
        echo json_encode(array("message" => "Unable to update employee."));
    }
} else {
    echo json_encode(array("message" => "Employee ID required."));
}
?>