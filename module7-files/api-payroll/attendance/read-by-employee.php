<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/attendance.php';

$db = (new Database())->getConnection();
$att = new Attendance($db);

$empId = $_GET['employee_id'] ?? null;
if(!$empId){ echo json_encode(["records"=>[]]); exit; }

$stmt = $att->readAllByEmployee($empId);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(["records"=>$rows]);
