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

$db = (new Database())->getConnection();

// Get employee details for the current logged-in user
$query = "SELECT e.employee_id, e.user_id, u.name, jt.job_title, jt.pay_rate, e.job_title_id, e.hire_date
          FROM employee e
          JOIN user u ON e.user_id = u.user_id
          LEFT JOIN job_title jt ON e.job_title_id = jt.job_title_id
          WHERE e.user_id = :user_id";

$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "employee" => [
            "employee_id" => $row['employee_id'],
            "user_id" => $row['user_id'],
            "name" => $row['name'],
            "job_title_id" => $row['job_title_id'],
            "job_title" => $row['job_title'],
            "pay_rate" => $row['pay_rate'],
            "hire_date" => $row['hire_date']
        ]
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Employee record not found"
    ]);
}
?>