<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/shift.php';

$db = (new Database())->getConnection();
$shift = new Shift($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->employee_id) && !empty($data->shift_date) && !empty($data->start_time) && !empty($data->end_time)) {
    $shift->employee_id = $data->employee_id;
    $shift->shift_date = $data->shift_date;
    $shift->start_time = $data->start_time;
    $shift->end_time = $data->end_time;

    if ($shift->create()) {
        echo json_encode(array("message" => "Shift created successfully."));
    } else {
        echo json_encode(array("message" => "Unable to create shift."));
    }
} else {
    echo json_encode(array("message" => "Incomplete data."));
}
?>