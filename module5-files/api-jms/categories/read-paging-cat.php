<?php
// REQUIRED HEADERS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// REQUIRED FILES
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/category.php';

// UTILITIES
$utilitiesJMS = new Utilities();

// DATABASE
$databaseJMS = new Database();
$dbJMS = $databaseJMS->getConnection();

// CATEGORY OBJECT
$categoryJMS = new Category($dbJMS);

// READ CATEGORIES (PAGING)
$stmtJMS = $categoryJMS->readPaging($from_record_numJMS, $records_per_pageJMS);
$numJMS = $stmtJMS->rowCount();

if ($numJMS > 0) {

    $categories_arrJMS = [];
    $categories_arrJMS["records"] = [];
    $categories_arrJMS["paging"]  = [];

    while ($rowJMS = $stmtJMS->fetch(PDO::FETCH_ASSOC)) {
        extract($rowJMS);

        $category_itemJMS = [
            "id"          => $id,
            "name"        => $name,
            "description" => $description,
            "created"     => $created
        ];

        array_push($categories_arrJMS["records"], $category_itemJMS);
    }

    // PAGING INFO
    $total_rowsJMS = $categoryJMS->count();
    $page_urlJMS   = "{$home_urlJMS}categories/read-paging-cat.php?";
    $pagingJMS     = $utilitiesJMS->getPaging(
        $pageJMS,
        $total_rowsJMS,
        $records_per_pageJMS,
        $page_urlJMS
    );

    $categories_arrJMS["paging"] = $pagingJMS;

    http_response_code(200);
    echo json_encode($categories_arrJMS);

} else {

    http_response_code(404);
    echo json_encode([
        "message" => "No categories found."
    ]);
}
