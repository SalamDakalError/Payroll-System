<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Content-Type: application/json");
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

include_once __DIR__ . '/../../config/core.php';
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../objects/employee.php';

$db = (new Database())->getConnection();
$employee = new Employee($db);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Get all employees
    $query = "SELECT e.employee_id, e.user_id, u.name, jt.job_title, jt.pay_rate, e.job_title_id, e.hire_date FROM employee e JOIN user u ON e.user_id=u.user_id LEFT JOIN job_title jt ON e.job_title_id=jt.job_title_id ORDER BY e.employee_id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $employees_arr = array();
    foreach ($rows as $row) {
        $employee_item = array(
            "employee_id" => $row['employee_id'],
            "user_id" => $row['user_id'],
            "name" => $row['name'],
            "job_title_id" => $row['job_title_id'],
            "job_title" => $row['job_title'],
            "pay_rate" => $row['pay_rate'],
            "hire_date" => $row['hire_date']
        );
        array_push($employees_arr, $employee_item);
    }

    echo json_encode([
        "success" => true,
        "employees" => $employees_arr
    ]);
} elseif ($method === 'POST') {
    // Create new employee
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['user_id']) && !empty($data['job_title_id'])) {
        // Get job title details
        $job_query = "SELECT job_title, pay_rate FROM job_title WHERE job_title_id = :job_title_id";
        $job_stmt = $db->prepare($job_query);
        $job_stmt->bindParam(':job_title_id', $data['job_title_id']);
        $job_stmt->execute();
        $job_data = $job_stmt->fetch(PDO::FETCH_ASSOC);

        if ($job_data) {
            $employee->user_id = $data['user_id'];
            $employee->job_title_id = $data['job_title_id'];
            $employee->hire_date = $data['hire_date'] ?? date('Y-m-d');

            if ($employee->create()) {
                echo json_encode([
                    "success" => true,
                    "message" => "Employee created successfully"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Failed to create employee"
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Invalid job title"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Missing required data"
        ]);
    }
} elseif ($method === 'PUT') {
    // Update employee
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['employee_id'])) {
        // Get job title details
        $job_query = "SELECT job_title, pay_rate FROM job_title WHERE job_title_id = :job_title_id";
        $job_stmt = $db->prepare($job_query);
        $job_stmt->bindParam(':job_title_id', $data['job_title_id']);
        $job_stmt->execute();
        $job_data = $job_stmt->fetch(PDO::FETCH_ASSOC);

        if ($job_data) {
            $employee->employee_id = $data['employee_id'];
            $employee->job_title_id = $data['job_title_id'];
            $employee->hire_date = $data['hire_date'] ?? date('Y-m-d');

            if ($employee->update()) {
                echo json_encode([
                    "success" => true,
                    "message" => "Employee updated successfully"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Failed to update employee"
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Invalid job title"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Missing employee ID"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
}
?>