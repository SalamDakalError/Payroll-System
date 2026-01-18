<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

// Check if ID is in query parameter or POST body
$user_id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);

if (!$user_id) {
    $data = json_decode(file_get_contents("php://input"));
    $user_id = $data->user_id ?? null;
}

if (!empty($user_id)) {
    $user->user_id = $user_id;

    if ($user->delete()) {
        echo json_encode(array("success" => true, "message" => "User deleted successfully."));
    } else {
        echo json_encode(array("success" => false, "message" => "Unable to delete user."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "User ID required."));
}
?>