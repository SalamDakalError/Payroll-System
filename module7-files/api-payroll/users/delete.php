<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->user_id)) {
    $user->user_id = $data->user_id;

    if ($user->delete()) {
        echo json_encode(array("message" => "User deleted successfully."));
    } else {
        echo json_encode(array("message" => "Unable to delete user."));
    }
} else {
    echo json_encode(array("message" => "User ID required."));
}
?>