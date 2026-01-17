<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

$stmt = $user->readAll();
$num = $stmt->rowCount();
if($num>0){
    $users=array();
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $users[] = ["user_id"=>$user_id,"name"=>$name,"email"=>$email,"role_id"=>$role_id];
    }
    echo json_encode(["records"=>$users]);
}else{
    echo json_encode(["records"=>[]]);
}
