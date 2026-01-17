<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
if(!$data){
    echo json_encode(["success" => false, "message" => "No input data"]);
    exit;
}

$user->user_id = $data->user_id;
$user->email = $data->email;
$user->role_id = $data->role_id;
if(isset($data->password) && !empty($data->password)){
    $user->password = $data->password;
}

if($user->update()){
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Unable to update user"]);
}
?>