<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);
    exit;
}

include_once '../config/database.php';
include_once '../objects/job_title.php';

$db = (new Database())->getConnection();
$jobTitle = new JobTitle($db);

$stmt = $jobTitle->readAll();
$num = $stmt->rowCount();

if($num > 0){
    $job_titles_arr = array();
    $job_titles_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $job_title_item = array(
            "job_title_id" => $job_title_id,
            "job_title" => $job_title,
            "pay_rate" => $pay_rate
        );
        array_push($job_titles_arr["records"], $job_title_item);
    }

    echo json_encode($job_titles_arr);
} else {
    echo json_encode(array("records" => array()));
}
?>