<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/category.php';

$dbJMS = (new Database())->getConnection();
$categoryJMS = new Category($dbJMS);

// accept JSON or form data
$dataJMS = json_decode(file_get_contents("php://input"));

if ($dataJMS) {
    $categoryJMS->idJMS = $dataJMS->id ?? null;
    $categoryJMS->nameJMS = $dataJMS->name ?? null;
    $categoryJMS->descriptionJMS = $dataJMS->description ?? null;
} else {
    $categoryJMS->idJMS = $_POST['id'] ?? null;
    $categoryJMS->nameJMS = $_POST['name'] ?? null;
    $categoryJMS->descriptionJMS = $_POST['description'] ?? null;
}

// validation
if (
    empty($categoryJMS->idJMS) ||
    empty($categoryJMS->nameJMS) ||
    empty($categoryJMS->descriptionJMS)
) {
    http_response_code(400);
    echo json_encode([
        "message" => "All fields are required"
    ]);
    exit;
}

// update
if ($categoryJMS->update()) {
    http_response_code(200);
    echo json_encode([
        "message" => "Category updated successfully"
    ]);
} else {
    http_response_code(503);
    echo json_encode([
        "message" => "Unable to update category"
    ]);
}
