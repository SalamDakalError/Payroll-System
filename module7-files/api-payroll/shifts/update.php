<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/shift.php';

$db = (new Database())->getConnection();
$shift = new Shift($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->shift_id)) {
    $shift->shift_id = $data->shift_id;
    $shift->shift_date = $data->shift_date ?? '';
    $shift->start_time = $data->start_time ?? '';
    $shift->end_time = $data->end_time ?? '';

    if ($shift->update()) {
        echo json_encode(array("message" => "Shift updated successfully."));
    } else {
        echo json_encode(array("message" => "Unable to update shift."));
    }
} else {
    echo json_encode(array("message" => "Shift ID required."));
}
?>