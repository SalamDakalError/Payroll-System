<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';

$db = (new Database())->getConnection();

// Simple payroll summary: total payroll per pay_period
$stmt = $db->prepare("SELECT pay_period, COUNT(*) as count, SUM(net_salary) as total FROM payroll GROUP BY pay_period ORDER BY pay_period DESC");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(["payroll_summary"=>$rows]);
