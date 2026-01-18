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
include_once '../objects/employee.php';

$db = (new Database())->getConnection();
$employee = new Employee($db);

$employee->employee_id = isset($_GET['id']) ? $_GET['id'] : die();

try {
    $stmt = $employee->readOne();
    $num = $stmt->rowCount();

    if($num > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $employee_item = array(
            "employee_id" => $row['employee_id'],
            "user_id" => $row['user_id'],
            "name" => $row['name'],
            "job_title_id" => $row['job_title_id'],
            "job_title" => $row['job_title'],
            "pay_rate" => $row['pay_rate'],
            "hire_date" => $row['hire_date']
        );

        echo json_encode([
            "success" => true,
            "employee" => $employee_item
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Employee not found"
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error loading employee: " . $e->getMessage()
    ]);
}
?>