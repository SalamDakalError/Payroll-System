<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

// instantiate database and product object
$databaseJMS = new Database(); // Variable uses JMS
$dbJMS = $databaseJMS->getConnection(); 

$productJMS = new Product($dbJMS);


$stmtJMS = $productJMS->readAll(); 
$numJMS = $stmtJMS->rowCount(); 

if($numJMS > 0){ 
    
    $products_arrJMS=array(); 
    $products_arrJMS["records"]=array();

   
    while ($rowJMS = $stmtJMS->fetch(PDO::FETCH_ASSOC)){ 
     
        extract($rowJMS);
        
        $product_itemJMS=array( 
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );

        array_push($products_arrJMS["records"], $product_itemJMS); 
    }


    http_response_code(200);

 
    echo json_encode($products_arrJMS); 
}
else{
  
    http_response_code(404);


    echo json_encode(
        array("message" => "No products found.")
    );
}
?>