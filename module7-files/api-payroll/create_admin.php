<?php
include_once __DIR__ . '/config/core.php';
include_once __DIR__ . '/config/database.php';
include_once __DIR__ . '/objects/user.php';
include_once __DIR__ . '/objects/role.php';

$db = (new Database())->getConnection();
$user = new User($db);
$role = new Role($db);

// First, check if admin role exists
$role->role_name = 'admin';
$stmt = $role->readAll();
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$admin_role_id = null;
foreach ($roles as $r) {
    if ($r['role_name'] == 'admin') {
        $admin_role_id = $r['role_id'];
        break;
    }
}

// If not exists, create admin role
if (!$admin_role_id) {
    $role->role_name = 'admin';
    if ($role->create()) {
        $admin_role_id = $db->lastInsertId();
        echo "Admin role created with ID: $admin_role_id\n";
    } else {
        echo "Failed to create admin role\n";
        exit;
    }
} else {
    echo "Admin role already exists with ID: $admin_role_id\n";
}

// Now create admin user
$user->name = 'Admin User';
$user->email = 'admin@payroll.com';
$user->password = password_hash('admin123', PASSWORD_DEFAULT);
$user->role_id = $admin_role_id;

if ($user->create()) {
    echo "Admin user created successfully!\n";
    echo "Email: admin@payroll.com\n";
    echo "Password: admin123\n";
} else {
    echo "Failed to create admin user\n";
}
?>