<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/transaction.php';

$utilitiesJMS = new Utilities();
$dbJMS = (new Database())->getConnection();
$transactionJMS = new Transaction($dbJMS);

$stmtJMS = $transactionJMS->readPaging($from_record_num, $records_per_page);
$numJMS = $stmtJMS->rowCount();

if ($numJMS > 0) {
    $arrJMS["records"] = [];
    $arrJMS["paging"] = [];

    while ($rowJMS = $stmtJMS->fetch(PDO::FETCH_ASSOC)) {
        extract($rowJMS);
        $arrJMS["records"][] = [
            "Transaction_ID" => $Transaction_ID,
            "Transaction_No" => $Transaction_No,
            "Customer_No" => $Customer_No,
            "Last_Name" => $Last_Name,
            "First_Name" => $First_Name,
            "Middle_Name" => $Middle_Name,
            "Product_Name" => $Product_Name,
            "Product_Price" => $Product_Price,
            "Quantity" => $Quantity,
            "Total_Amount" => $Total_Amount
        ];
    }

    $total_rows = $transactionJMS->count();
    $page_url = "{$home_url}transactions/read-paging-trans.php?";
    $arrJMS["paging"] = $utilitiesJMS->getPaging($page, $total_rows, $records_per_page, $page_url);

    echo json_encode($arrJMS);
} else {
    http_response_code(404);
    echo json_encode(["message" => "No transactions found"]);
}
