<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/shift.php';

$db = (new Database())->getConnection();
$shift = new Shift($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->shift_id)) {
    $shift->shift_id = $data->shift_id;

    if ($shift->delete()) {
        echo json_encode(array("message" => "Shift deleted successfully."));
    } else {
        echo json_encode(array("message" => "Unable to delete shift."));
    }
} else {
    echo json_encode(array("message" => "Shift ID required."));
}
?>