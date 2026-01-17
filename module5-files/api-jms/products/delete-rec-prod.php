<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/product.php';


$databaseJMS = new Database();
$dbJMS = $databaseJMS->getConnection(); 


$productJMS = new Product($dbJMS); 


$dataJMS = json_decode(file_get_contents("php://input")); 


$productJMS->idJMS = $dataJMS->id;


if($productJMS->delete()){ 
  
    http_response_code(200);


    echo json_encode(array("message" => "Product was deleted."));
}

else{

    http_response_code(503);


    echo json_encode(array("message" => "Unable to delete product."));
}
?>