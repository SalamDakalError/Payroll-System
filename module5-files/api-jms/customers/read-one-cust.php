<?php
header("Content-Type: application/json");
include_once "../config/database.php";

$db = (new Database())->getConnection();

$id = $_GET['id'] ?? '';

$stmt = $db->prepare("SELECT * FROM tblcustomer WHERE Customer_No=?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row){
    echo json_encode($row);
}else{
    http_response_code(404);
    echo json_encode(["message"=>"Customer not found"]);
}
