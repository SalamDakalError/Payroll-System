<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/shift.php';

$db = (new Database())->getConnection();
$shift = new Shift($db);

$stmt = $shift->readAll();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("records" => $rows));
?>