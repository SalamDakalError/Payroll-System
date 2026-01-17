<?php
$data = json_decode(file_get_contents("php://input"));

include "../config/database.php";
include "../objects/users.php";

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UsersJMS($db);

$obj->idJMS = $data->id;
$obj->lastNameJMS = $data->Last_Name;
$obj->firstNameJMS = $data->First_Name;
$obj->genderJMS = $data->Gender;
$obj->emailJMS = $data->Email_Address;

echo json_encode(["success"=>$obj->updateJMS()]);
