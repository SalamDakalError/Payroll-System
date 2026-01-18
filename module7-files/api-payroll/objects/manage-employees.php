<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/employee.php';

$db = (new Database())->getConnection();
$employee = new Employee($db);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Get all employees
    $stmt = $employee->readAll();
    $num = $stmt->rowCount();

    if($num > 0){
        $employees_arr = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $employee_item = array(
                "employee_id" => $row['employee_id'],
                "user_id" => $row['user_id'],
                "name" => $row['name'],
                "job_title_id" => $row['job_title_id'],
                "job_title" => $row['job_title'],
                "pay_rate" => $row['pay_rate']
            );
            array_push($employees_arr, $employee_item);
        }

        echo json_encode([
            "success" => true,
            "employees" => $employees_arr
        ]);
    } else {
        echo json_encode([
            "success" => true,
            "employees" => []
        ]);
    }
} elseif ($method === 'POST') {
    // Create new employee
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['user_id']) && !empty($data['job_title_id'])) {
        $employee->user_id = $data['user_id'];
        $employee->job_title_id = $data['job_title_id'];

        if ($employee->create()) {
            echo json_encode([
                "success" => true,
                "message" => "Employee created successfully"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Unable to create employee"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Incomplete data"
        ]);
    }
} elseif ($method === 'PUT') {
    // Update employee
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['employee_id'])) {
        $employee->employee_id = $data['employee_id'];
        $employee->job_title_id = $data['job_title_id'];

        if ($employee->update()) {
            echo json_encode([
                "success" => true,
                "message" => "Employee updated successfully"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Unable to update employee"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Employee ID required"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
}
?>