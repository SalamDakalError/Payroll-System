<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
if(!$data){
    
    echo json_encode(["message"=>"No input"]);
    exit;
}

// very small demo login (compare email + password plaintext for now)
$email = $data->email ?? '';
$password = $data->password ?? '';

$stmt = $db->prepare("SELECT user_id, name, email, password, role_id FROM user WHERE email=:email LIMIT 1");
$stmt->bindParam(':email',$email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row && password_verify($password,$row['password'])){
    echo json_encode(["success"=>true,"user"=>["user_id"=>$row['user_id'],"name"=>$row['name'],"email"=>$row['email'],"role_id"=>$row['role_id']]]);
}else{
    echo json_encode(["success"=>false,"message"=>"Invalid credentials"]);
}
