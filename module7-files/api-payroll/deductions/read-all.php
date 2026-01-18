<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/deduction.php';

$db = (new Database())->getConnection();
$deduction = new Deduction($db);

$stmt = $deduction->readAll();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("records" => $rows));
?>