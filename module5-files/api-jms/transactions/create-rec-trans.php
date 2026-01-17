<?php
header("Content-Type: application/json");
include_once "../config/database.php";
include_once "../objects/transaction.php";

$db = (new Database())->getConnection();
$transaction = new Transaction($db);

$data = json_decode(file_get_contents("php://input"), true);

$required = ["Transaction_No","Customer_No","Product_ID","Quantity","Total_Amount"];
foreach($required as $f){
    if(!isset($data[$f]) || $data[$f]===""){
        http_response_code(400);
        echo json_encode(["error"=>"Missing $f"]);
        exit;
    }
}

$ok = $transaction->create($data);
echo json_encode(["success"=>$ok]);
