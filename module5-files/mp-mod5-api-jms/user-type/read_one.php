<?php
include "../config/database.php";
include "../objects/usertype.php";

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UserTypeJMS($db);
$obj->idJMS = $_GET['id'];

$stmt = $obj->readOneJMS();
$stmt->execute();
echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
