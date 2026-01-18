<?php
session_start();
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/user.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password)) {
    $db = (new Database())->getConnection();
    $user = new User($db);

    // Find user by email
    $stmt = $db->prepare("SELECT user_id, name, email, password, role_id FROM user WHERE email = ?");
    $stmt->bindParam(1, $data->email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if (password_verify($data->password, $row['password'])) {
            // Password is correct, start session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['role_id'] = $row['role_id'];

            echo json_encode([
                "success" => true,
                "message" => "Login successful",
                "user" => [
                    "user_id" => $row['user_id'],
                    "name" => $row['name'],
                    "email" => $row['email'],
                    "role_id" => $row['role_id']
                ]
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Invalid password"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "User not found"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Email and password required"
    ]);
}
?>