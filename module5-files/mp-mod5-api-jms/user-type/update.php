<?php
$data = json_decode(file_get_contents("php://input"));

include "../config/database.php";
include "../objects/usertype.php";

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UserTypeJMS($db);

$obj->idJMS = $data->id;
$obj->nameJMS = $data->Name;
$obj->descriptionJMS = $data->Description;

echo json_encode(["success"=>$obj->updateJMS()]);
