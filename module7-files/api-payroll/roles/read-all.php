<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/role.php';

$db = (new Database())->getConnection();
$role = new Role($db);

$stmt = $role->readAll();
$num = $stmt->rowCount();

if ($num > 0) {
    $roles_arr = array();
    $roles_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $role_item = array(
            "role_id" => $role_id,
            "role_name" => $role_name
        );
        array_push($roles_arr["records"], $role_item);
    }
    echo json_encode($roles_arr);
} else {
    echo json_encode(array("records" => array()));
}
?>