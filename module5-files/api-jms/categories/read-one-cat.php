<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/category.php';

$dbJMS = (new Database())->getConnection();
$categoryJMS = new Category($dbJMS);

// validate ID
$categoryJMS->idJMS = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($categoryJMS->idJMS <= 0) {
    http_response_code(400);
    echo json_encode([
        "message" => "Invalid category ID"
    ]);
    exit;
}

// fetch record
$categoryJMS->readOne();

// check if found
if (empty($categoryJMS->nameJMS)) {
    http_response_code(404);
    echo json_encode([
        "message" => "Category not found"
    ]);
    exit;
}

// success
http_response_code(200);
echo json_encode([
    "id" => $categoryJMS->idJMS,
    "name" => $categoryJMS->nameJMS,
    "description" => $categoryJMS->descriptionJMS,
    "created" => $categoryJMS->createdJMS
]);
