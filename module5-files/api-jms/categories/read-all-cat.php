<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/category.php';

$dbJMS = (new Database())->getConnection();
$categoryJMS = new Category($dbJMS);

$stmtJMS = $categoryJMS->readAll();
$numJMS = $stmtJMS->rowCount();

if ($numJMS > 0) {

    $categories_arrJMS = array();
    $categories_arrJMS["records"] = array();

    while ($rowJMS = $stmtJMS->fetch(PDO::FETCH_ASSOC)) {
        extract($rowJMS);

        $category_itemJMS = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description)
        );

        array_push($categories_arrJMS["records"], $category_itemJMS);
    }

    http_response_code(200);
    echo json_encode($categories_arrJMS);

} else {

    http_response_code(404);
    echo json_encode(array(
        "message" => "No categories found."
    ));
}
