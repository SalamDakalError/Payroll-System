<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/deduction.php';

$db = (new Database())->getConnection();
$deduction = new Deduction($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->deduction_id)) {
    $deduction->deduction_id = $data->deduction_id;

    if ($deduction->delete()) {
        echo json_encode(array("message" => "Deduction deleted successfully."));
    } else {
        echo json_encode(array("message" => "Unable to delete deduction."));
    }
} else {
    echo json_encode(array("message" => "Deduction ID required."));
}
?>