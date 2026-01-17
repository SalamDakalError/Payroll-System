<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/payslip.php';

$db = (new Database())->getConnection();
$ps = new Payslip($db);

$stmt = $db->prepare("SELECT p.payslip_id,p.payroll_id,p.issued_date FROM payslip p ORDER BY p.issued_date DESC");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(["records"=>$rows]);
