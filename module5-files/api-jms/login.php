<?php
header("Content-Type: application/json");

include_once 'config/database.php';
include_once 'objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->User_Name) && !empty($data->Password)){
    $user->User_Name = $data->User_Name;
    $user->Password  = $data->Password;

    if($user->userExist()){
        http_response_code(201);
        echo json_encode(["message"=>"Log-In Successful"]);
    } else {
        http_response_code(503);
        echo json_encode(["message"=>"Log-In Failed"]);
    }
}
?>
