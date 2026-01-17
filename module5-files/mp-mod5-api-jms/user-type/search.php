<?php
include "../config/database.php";
include "../objects/usertype.php";

$key = "%".$_GET['s']."%";

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UserTypeJMS($db);

$stmt = $obj->searchJMS($key);
$stmt->bindParam(1, $key);
$stmt->execute();

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
