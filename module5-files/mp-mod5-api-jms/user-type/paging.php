<?php
include "../config/database.php";
include "../objects/usertype.php";

$page = $_GET['page'] ?? 1;
$limit = 5;
$from = ($page - 1) * $limit;

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UserTypeJMS($db);

$stmt = $obj->pagingJMS($from, $limit);
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
