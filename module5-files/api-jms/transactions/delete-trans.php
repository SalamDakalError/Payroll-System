<?php
header("Content-Type: application/json");
include_once "../config/database.php";
include_once "../objects/transaction.php";

$db = (new Database())->getConnection();
$transaction = new Transaction($db);

$data = json_decode(file_get_contents("php://input"), true);
echo json_encode([
    "success" => $transaction->delete($data["Transaction_No"])
]);
