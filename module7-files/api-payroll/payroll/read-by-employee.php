<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/payroll.php';

$db = (new Database())->getConnection();
$payroll = new Payroll($db);

$data = json_decode(file_get_contents("php://input"));
$payroll->employee_id = $data->employee_id ?? $_GET['employee_id'] ?? 0;

$stmt = $payroll->readByEmployee();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("records" => $rows));
?>