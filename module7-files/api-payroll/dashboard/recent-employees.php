<?php
header("Content-Type: application/json");

include_once '../config/database.php';

$db = (new Database())->getConnection();

// Get recent employees (last 10 added)
$query = "SELECT e.employee_id, u.name, jt.job_title, jt.pay_rate
          FROM employee e
          JOIN user u ON e.user_id = u.user_id
          LEFT JOIN job_title jt ON e.job_title_id = jt.job_title_id
          ORDER BY e.employee_id DESC
          LIMIT 10";

$stmt = $db->prepare($query);
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "employees" => $employees
]);
?>