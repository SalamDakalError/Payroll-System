<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/transaction.php';

$dbJMS = (new Database())->getConnection();
$transactionJMS = new Transaction($dbJMS);

$keywords = $_GET['s'] ?? "";

$stmtJMS = $transactionJMS->search($keywords);
$numJMS = $stmtJMS->rowCount();

if ($numJMS > 0) {
    $arrJMS["records"] = [];

    while ($rowJMS = $stmtJMS->fetch(PDO::FETCH_ASSOC)) {
        $arrJMS["records"][] = $rowJMS;
    }

    echo json_encode($arrJMS);
} else {
    http_response_code(404);
    echo json_encode(["message" => "No transactions found"]);
}
