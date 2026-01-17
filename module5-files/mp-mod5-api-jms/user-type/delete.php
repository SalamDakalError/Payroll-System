<?php
include "../config/database.php";
include "../objects/usertype.php";

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UserTypeJMS($db);
$obj->idJMS = $_GET['id'];

echo json_encode(["success"=>$obj->deleteJMS()]);
