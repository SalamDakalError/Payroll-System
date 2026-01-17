<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));
if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$current_password = $data->current_password;
$new_password = $data->new_password;

// Get current user data
$user->user_id = $user_id;
$user->readOne();

if (!$user->email) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit;
}

// Verify current password
if (!password_verify($current_password, $user->password)) {
    echo json_encode(["success" => false, "message" => "Current password is incorrect"]);
    exit;
}

// Hash new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update password
$user->password = $hashed_password;
if ($user->updatePassword()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update password"]);
}
?>