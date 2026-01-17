<?php
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/payroll.php';

$db = (new Database())->getConnection();
$p = new Payroll($db);

$data = json_decode(file_get_contents("php://input"));
if(!$data){ echo json_encode(["success"=>false]); exit; }

$p->employee_id = $data->employee_id;
$p->pay_period = $data->pay_period;
$p->net_salary = $data->net_salary;

if($p->create()) echo json_encode(["success"=>true]); else echo json_encode(["success"=>false]);
