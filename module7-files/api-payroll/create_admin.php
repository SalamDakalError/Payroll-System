<?php
header("Content-Type: application/json");

// Include database configuration
include_once 'config/database.php';
include_once 'objects/user.php';
include_once 'objects/role.php';

try {
    $db = (new Database())->getConnection();

    // First, ensure admin role exists
    $role = new Role($db);
    $role->role_name = 'Admin';

    // Check if admin role already exists
    $stmt = $db->prepare("SELECT role_id FROM role WHERE role_name = 'Admin'");
    $stmt->execute();
    $existing_role = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing_role) {
        // Create admin role
        if ($role->create()) {
            echo json_encode(["message" => "Admin role created successfully."]);
            $role_id = $db->lastInsertId();
        } else {
            echo json_encode(["message" => "Failed to create admin role."]);
            exit;
        }
    } else {
        $role_id = $existing_role['role_id'];
        echo json_encode(["message" => "Admin role already exists."]);
    }

    // Now create admin user
    $user = new User($db);
    $user->name = 'Admin User';
    $user->email = 'admin@payroll.com';
    $user->password = password_hash('password', PASSWORD_DEFAULT);
    $user->role_id = $role_id;

    // Check if admin user already exists
    $stmt = $db->prepare("SELECT user_id FROM user WHERE email = 'admin@payroll.com'");
    $stmt->execute();
    $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing_user) {
        // Create admin user
        if ($user->create()) {
            echo json_encode([
                "message" => "Admin user created successfully.",
                "email" => "admin@payroll.com",
                "password" => "password"
            ]);
        } else {
            echo json_encode(["message" => "Failed to create admin user."]);
        }
    } else {
        echo json_encode([
            "message" => "Admin user already exists.",
            "email" => "admin@payroll.com",
            "password" => "password"
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>