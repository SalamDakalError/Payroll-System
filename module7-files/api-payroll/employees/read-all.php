<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/employee.php';

$db = (new Database())->getConnection();
$emp = new Employee($db);

$stmt = $emp->readAll();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(["records"=>$rows]);
