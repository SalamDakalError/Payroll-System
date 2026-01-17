<?php
header("Content-Type: application/json");
include_once "../config/database.php";
include_once "../objects/transaction.php";

$db = (new Database())->getConnection();
$transaction = new Transaction($db);

$id = $_GET["id"] ?? "";
echo json_encode($transaction->readOne($id));
