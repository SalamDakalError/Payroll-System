<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";

$db = (new Database())->getConnection();

$query = "SELECT id, name FROM categories";
$stmt = $db->prepare($query);
$stmt->execute();

$records = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $records[] = $row;
}

echo json_encode(["records" => $records]);
