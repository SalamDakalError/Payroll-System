<?php
include "../config/database.php";
include "../objects/usertype.php";

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UserTypeJMS($db);

$stmt = $obj->readAllJMS();
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
