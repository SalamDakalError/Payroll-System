<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/department.php';

$db = (new Database())->getConnection();
$dept = new Department($db);

$stmt = $dept->readAll();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(["records"=>$rows]);
