<?php
include "../config/database.php";
include "../objects/users.php";

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UsersJMS($db);

$stmt = $obj->readAllJMS();
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
