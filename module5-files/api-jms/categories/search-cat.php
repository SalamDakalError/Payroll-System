<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/category.php';

$dbJMS = (new Database())->getConnection();
$category = new Category($dbJMS);

$keywordsJMS = $_GET['s'] ?? "";

$stmtJMS = $category->search($keywordsJMS);
echo json_encode($stmtJMS->fetchAll(PDO::FETCH_ASSOC));
