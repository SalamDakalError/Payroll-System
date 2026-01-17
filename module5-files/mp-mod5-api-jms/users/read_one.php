<?php
include "../config/database.php";
include "../objects/users.php";

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UsersJMS($db);
$obj->idJMS = $_GET['id'];

$stmt = $obj->readOneJMS();
$stmt->execute();
echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
