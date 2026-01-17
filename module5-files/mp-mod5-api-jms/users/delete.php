<?php
include "../config/database.php";
include "../objects/users.php";

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UsersJMS($db);
$obj->idJMS = $_GET['id'];

echo json_encode(["success"=>$obj->deleteJMS()]);
