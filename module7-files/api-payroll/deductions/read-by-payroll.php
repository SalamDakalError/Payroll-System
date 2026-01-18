<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/deduction.php';

$db = (new Database())->getConnection();
$deduction = new Deduction($db);

$data = json_decode(file_get_contents("php://input"));
$deduction->payroll_id = $data->payroll_id ?? $_GET['payroll_id'] ?? 0;

$stmt = $deduction->readByPayroll();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("records" => $rows));
?>