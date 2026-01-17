<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/payroll.php';
include_once __DIR__ . '/../objects/employee.php';

$db = (new Database())->getConnection();
$p = new Payroll($db);
$e = new Employee($db);

$data = json_decode(file_get_contents("php://input"));
if(!$data){ echo json_encode(["success"=>false]); exit; }

$p->employee_id = $data->employee_id;
$p->pay_period = $data->pay_period;

// Fetch employee salary
$e->employee_id = $data->employee_id;
$stmt = $e->readOne();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$row){
    echo json_encode(["success"=>false, "message"=>"Employee not found"]);
    exit;
}
$salary = $row['salary'];

// Calculate deductions
$p->calculateDeductions($salary);

if($p->create()) echo json_encode(["success"=>true]); else echo json_encode(["success"=>false]);
