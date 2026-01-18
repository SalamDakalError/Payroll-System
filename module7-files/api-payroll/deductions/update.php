<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/deduction.php';

$db = (new Database())->getConnection();
$deduction = new Deduction($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->deduction_id)) {
    $deduction->deduction_id = $data->deduction_id;
    $deduction->deduction_type = $data->deduction_type ?? '';
    $deduction->amount = $data->amount ?? 0;

    if ($deduction->update()) {
        echo json_encode(array("message" => "Deduction updated successfully."));
    } else {
        echo json_encode(array("message" => "Unable to update deduction."));
    }
} else {
    echo json_encode(array("message" => "Deduction ID required."));
}
?>