<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
if(!$data){ echo json_encode(["success"=>false,"message"=>"No input"]); exit; }

$user->name = $data->name ?? '';
$user->email = $data->email ?? '';
$user->password = password_hash($data->password ?? 'password', PASSWORD_DEFAULT);
$user->role_id = $data->role_id ?? 3;

if($user->create()){
    echo json_encode(["success"=>true]);
}else{
    echo json_encode(["success"=>false]);
}
