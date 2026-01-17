<?php
$data = json_decode(file_get_contents("php://input"));

include "../config/database.php";
include "../objects/users.php";

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UsersJMS($db);

$obj->userNameJMS = $data->User_Name;
$obj->lastNameJMS = $data->Last_Name;
$obj->firstNameJMS = $data->First_Name;
$obj->middleNameJMS = $data->Middle_Name;
$obj->genderJMS = $data->Gender;
$obj->emailJMS = $data->Email_Address;
$obj->userTypeIdJMS = $data->User_Type_Id;
$obj->passwordJMS = $data->Password;

echo json_encode(["success"=>$obj->createJMS()]);
