<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

// get database connection
$databaseJMS = new Database(); // Variable uses JMS
$dbJMS = $databaseJMS->getConnection(); // Variable uses JMS

// prepare product object
$productJMS = new Product($dbJMS); // Variable uses JMS

// set ID property of record to read
$productJMS->idJMS = isset($_GET['id']) ? $_GET['id'] : die(); // Variable/Property uses JMS

// read the details of product to be edited
$productJMS->readOne();

if($productJMS->nameJMS != null){ // Variable/Property uses JMS
    // create array
    $product_arrJMS = array( // Variable uses JMS
        "id" => $productJMS->idJMS,
        "name" => $productJMS->nameJMS,
        "description" => $productJMS->descriptionJMS,
        "price" => $productJMS->priceJMS,
        "category_id" => $productJMS->category_idJMS,
        "category_name" => $productJMS->category_nameJMS
    );


    http_response_code(200);


    echo json_encode($product_arrJMS); 
}
else{
 
    http_response_code(404);

    echo json_encode(array("message" => "Product does not exist."));
}
?>