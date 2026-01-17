<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/category.php';

$dbJMS = (new Database())->getConnection();
$category = new Category($dbJMS);

/* ✅ ACCEPT JSON OR FORM DATA */
$dataJMS = json_decode(file_get_contents("php://input"));

if ($dataJMS) {
    $category->nameJMS = $dataJMS->name ?? null;
    $category->descriptionJMS = $dataJMS->description ?? null;
} else {
    $category->nameJMS = $_POST['name'] ?? null;
    $category->descriptionJMS = $_POST['description'] ?? null;
}

/* ✅ VALIDATION (NO DB CHANGE) */
if (empty($category->nameJMS) || empty($category->descriptionJMS)) {
    http_response_code(400);
    echo json_encode([
        "error" => "Name and description are required"
    ]);
    exit;
}

$category->createdJMS = date("Y-m-d H:i:s");

/* ✅ CREATE */
if ($category->create()) {
    echo json_encode(["message" => "Category created successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Unable to create category"]);
}
