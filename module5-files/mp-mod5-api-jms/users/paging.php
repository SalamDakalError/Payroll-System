<?php
include "../config/database.php";
include "../objects/users.php";

$page = $_GET['page'] ?? 1;
$limit = 5;
$from = ($page - 1) * $limit;

$db = (new DatabaseJMS())->getConnectionJMS();
$obj = new UsersJMS($db);

$stmt = $obj->pagingJMS($from, $limit);
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
