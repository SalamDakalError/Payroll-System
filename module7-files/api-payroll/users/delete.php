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

$user->user_id = isset($_GET['id']) ? $_GET['id'] : die();

// Prevent deleting yourself
if ($user->user_id == $_SESSION['user_id']) {
    echo json_encode(["success" => false, "message" => "You cannot delete your own account"]);
    exit;
}

// Check if user has associated employee records
$query = "SELECT COUNT(*) as count FROM employee WHERE user_id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user->user_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row['count'] > 0){
    echo json_encode(["success" => false, "message" => "Cannot delete user with associated employee records"]);
    exit;
}

if($user->delete()){
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Unable to delete user"]);
}
?>