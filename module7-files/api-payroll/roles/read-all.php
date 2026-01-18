<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/role.php';

$db = (new Database())->getConnection();
$role = new Role($db);

$stmt = $role->readAll();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(array("records" => $rows));
?>