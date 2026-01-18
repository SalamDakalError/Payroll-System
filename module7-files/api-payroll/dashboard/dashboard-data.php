<?php
header("Content-Type: application/json");

include_once '../config/database.php';

$db = (new Database())->getConnection();

try {
    // Get total employees
    $employee_query = "SELECT COUNT(*) as total FROM employee";
    $employee_stmt = $db->prepare($employee_query);
    $employee_stmt->execute();
    $employee_result = $employee_stmt->fetch(PDO::FETCH_ASSOC);
    $total_employees = $employee_result['total'];

    // Get recent hires (last 30 days)
    $recent_hires_query = "SELECT u.name, e.hire_date FROM employee e JOIN user u ON e.user_id = u.user_id WHERE e.hire_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) ORDER BY e.hire_date DESC LIMIT 5";
    $recent_hires_stmt = $db->prepare($recent_hires_query);
    $recent_hires_stmt->execute();
    $recent_hires = $recent_hires_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get current pay period (next month)
    $current_date = date('Y-m');
    $next_month = date('Y-m', strtotime('+1 month'));
    $current_pay_period = $next_month;

    // Get upcoming payroll count (employees who need payroll for next period)
    $upcoming_payroll_query = "SELECT COUNT(DISTINCT e.employee_id) as upcoming FROM employee e LEFT JOIN payroll p ON e.employee_id = p.employee_id AND p.pay_period = :next_period WHERE p.payroll_id IS NULL";
    $upcoming_payroll_stmt = $db->prepare($upcoming_payroll_query);
    $upcoming_payroll_stmt->bindParam(':next_period', $next_month);
    $upcoming_payroll_stmt->execute();
    $upcoming_result = $upcoming_payroll_stmt->fetch(PDO::FETCH_ASSOC);
    $upcoming_payroll = $upcoming_result['upcoming'];

    // Format recent hires for response
    $recent_hires_formatted = array_map(function($hire) {
        return [
            'name' => $hire['name'],
            'hire_date' => date('Y-m-d', strtotime($hire['hire_date']))
        ];
    }, $recent_hires);

    echo json_encode([
        'success' => true,
        'data' => [
            'total_employees' => $total_employees,
            'current_pay_period' => $current_pay_period,
            'payroll_status' => $upcoming_payroll . ' pending',
            'recent_hires' => $recent_hires_formatted
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error loading dashboard data: ' . $e->getMessage()
    ]);
}
?>