<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/payslip.php';

$db = (new Database())->getConnection();
$payslip = new Payslip($db);

$data = json_decode(file_get_contents("php://input"));
$payslip->payroll_id = $data->payroll_id ?? $_GET['payroll_id'] ?? 0;

$stmt = $payslip->readOne();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("records" => $rows));
?>