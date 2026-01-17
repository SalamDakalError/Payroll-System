<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    echo json_encode(["message" => "Unauthorized"]);
    exit;
}

include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

$user->user_id = isset($_GET['id']) ? $_GET['id'] : die();
$user->readOne();

if($user->name != null){
    $user_arr = [
        "user_id" => $user->user_id,
        "name" => $user->name,
        "email" => $user->email,
        "role_id" => $user->role_id
    ];
    echo json_encode(["user" => $user_arr]);
} else {
    echo json_encode(["message" => "User not found."]);
}
?>