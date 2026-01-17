<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/role.php';

$db = (new Database())->getConnection();
$role = new Role($db);

$stmt = $role->readAll();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(["records"=>$rows]);
