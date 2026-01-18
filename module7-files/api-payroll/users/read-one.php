<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

// Get user ID from query parameter
$user_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($user_id) {
    $user->user_id = $user_id;
    $user->readOne();

    if ($user->name) {
        echo json_encode([
            "success" => true,
            "user" => [
                "user_id" => $user->user_id,
                "name" => $user->name,
                "email" => $user->email,
                "role_id" => $user->role_id,
                "role_name" => $user->role_name
            ]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "User not found"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "User ID required"
    ]);
}
?>