<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/product.php';

// utilities
$utilitiesJMS = new Utilities(); // Variable uses JMS

// instantiate database and product object
$databaseJMS = new Database(); // Variable uses JMS
$dbJMS = $databaseJMS->getConnection(); // Variable uses JMS

// initialize object
$productJMS = new Product($dbJMS); // Variable uses JMS

// query products
$stmtJMS = $productJMS->readPaging($from_record_numJMS, $records_per_pageJMS); // Variables use JMS
$numJMS = $stmtJMS->rowCount(); // Variable uses JMS

if($numJMS > 0){ 
   
    $products_arrJMS=array();
    $products_arrJMS["records"]=array();
    $products_arrJMS["paging"]=array();


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

 
    $total_rowsJMS = $productJMS->count(); 
    $page_urlJMS = "{$home_urlJMS}products/read-paging-prod.php?";
    $pagingJMS = $utilitiesJMS->getPaging($pageJMS, $total_rowsJMS, $records_per_pageJMS, $page_urlJMS); 
    $products_arrJMS["paging"]=$pagingJMS; 

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