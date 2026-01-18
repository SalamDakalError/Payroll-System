<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/payroll.php';

$db = (new Database())->getConnection();
$payroll = new Payroll($db);

$stmt = $payroll->readAll();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("records" => $rows));
?>