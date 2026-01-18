<?php
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/user.php';

$db = (new Database())->getConnection();
$user = new User($db);

$stmt = $user->readAll();
$num = $stmt->rowCount();

if ($num > 0) {
    $users_arr = array();
    $users_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user_item = array(
            "user_id" => $user_id,
            "name" => $name,
            "email" => $email,
            "role_id" => $role_id
        );
        array_push($users_arr["records"], $user_item);
    }
    echo json_encode($users_arr);
} else {
    echo json_encode(array("records" => array()));
}
?>