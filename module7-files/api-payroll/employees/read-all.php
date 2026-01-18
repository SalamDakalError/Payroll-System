<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/employee.php';

$db = (new Database())->getConnection();
$employee = new Employee($db);

$stmt = $employee->readAll();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("records" => $rows));
?>