<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/role.php';

$db = (new Database())->getConnection();
$role = new Role($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->role_name)) {
    $role->role_name = $data->role_name;

    if ($role->create()) {
        echo json_encode(array("message" => "Role created successfully."));
    } else {
        echo json_encode(array("message" => "Unable to create role."));
    }
} else {
    echo json_encode(array("message" => "Role name required."));
}
?>