<?php
header("Content-Type: application/json");
include_once "../config/database.php";
include_once "../objects/transaction.php";

$db = (new Database())->getConnection();
$transaction = new Transaction($db);

$stmt = $transaction->readAll();
echo json_encode([
    "records" => $stmt->fetchAll(PDO::FETCH_ASSOC)
]);
