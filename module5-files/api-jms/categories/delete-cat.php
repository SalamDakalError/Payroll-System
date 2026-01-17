<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/category.php';

$dbJMS = (new Database())->getConnection();
$categoryJMS = new Category($dbJMS);

// accept JSON or form data
$dataJMS = json_decode(file_get_contents("php://input"));

$categoryJMS->idJMS = $dataJMS->id ?? $_POST['id'] ?? null;

// validate
if (empty($categoryJMS->idJMS)) {
    http_response_code(400);
    echo json_encode([
        "message" => "Category ID is required"
    ]);
    exit;
}

// delete
if ($categoryJMS->delete()) {
    http_response_code(200);
    echo json_encode([
        "message" => "Category deleted successfully"
    ]);
} else {
    http_response_code(503);
    echo json_encode([
        "message" => "Unable to delete category"
    ]);
}
