<?php
header("Content-Type: application/json");

include_once '../config/database.php';

$db = (new Database())->getConnection();

// Get total users
$query = "SELECT COUNT(*) as total_users FROM user";
$stmt = $db->prepare($query);
$stmt->execute();
$total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

// Get total employees
$query = "SELECT COUNT(*) as total_employees FROM employee";
$stmt = $db->prepare($query);
$stmt->execute();
$total_employees = $stmt->fetch(PDO::FETCH_ASSOC)['total_employees'];

// Get total managers (users with role_id = 2)
$query = "SELECT COUNT(*) as total_managers FROM user WHERE role_id = 2";
$stmt = $db->prepare($query);
$stmt->execute();
$total_managers = $stmt->fetch(PDO::FETCH_ASSOC)['total_managers'];

// Get total payroll for current month
$current_month = date('Y-m');
$query = "SELECT COALESCE(SUM(net_pay), 0) as total_payroll FROM payroll WHERE pay_period LIKE ?";
$stmt = $db->prepare($query);
$stmt->execute([$current_month . '%']);
$total_payroll = $stmt->fetch(PDO::FETCH_ASSOC)['total_payroll'];

echo json_encode([
    "success" => true,
    "stats" => [
        "total_users" => (int)$total_users,
        "total_employees" => (int)$total_employees,
        "total_managers" => (int)$total_managers,
        "total_payroll" => number_format($total_payroll, 2, '.', '')
    ]
]);
?>