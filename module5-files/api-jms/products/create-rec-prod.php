<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../objects/product.php';

$databaseJMS = new Database(); 
$dbJMS = $databaseJMS->getConnection(); 

$productJMS = new Product($dbJMS); 

$dataJMS = json_decode(file_get_contents("php://input")); 


if(
    !empty($dataJMS->name) && 
    !empty($dataJMS->price) &&
    !empty($dataJMS->description) &&
    !empty($dataJMS->category_id)
){

    $productJMS->nameJMS = $dataJMS->name; 
    $productJMS->priceJMS = $dataJMS->price;
    $productJMS->descriptionJMS = $dataJMS->description;
    $productJMS->category_idJMS = $dataJMS->category_id;
    $productJMS->createdJMS = date('Y-m-d H:i:s');


    if($productJMS->create()){ 
      
        http_response_code(201);

    
        echo json_encode(array("message" => "Product was created."));
    }

    else{
        
        http_response_code(503);

       
        echo json_encode(array("message" => "Unable to create product."));
    }
}

else{

    http_response_code(400);

   
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>