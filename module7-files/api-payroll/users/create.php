<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->email) && !empty($data->password) && !empty($data->role_id)) {
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = password_hash($data->password, PASSWORD_DEFAULT);
    $user->role_id = $data->role_id;

    if ($user->create()) {
        echo json_encode(array("success" => true, "message" => "User created successfully."));
    } else {
        echo json_encode(array("success" => false, "message" => "Unable to create user."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Incomplete data."));
}
?>