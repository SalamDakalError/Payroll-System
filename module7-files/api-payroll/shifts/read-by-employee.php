<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/shift.php';

$db = (new Database())->getConnection();
$shift = new Shift($db);

$data = json_decode(file_get_contents("php://input"));
$shift->employee_id = $data->employee_id ?? $_GET['employee_id'] ?? 0;

$stmt = $shift->readByEmployee();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("records" => $rows));
?>