<?php
header("Content-Type: application/json");
session_start();

if (isset($_SESSION['user_id'])) {
    echo json_encode([
        "logged_in" => true,
        "user" => [
            "user_id" => $_SESSION['user_id'],
            "name" => $_SESSION['user_name'],
            "email" => $_SESSION['user_email'],
            "role_id" => $_SESSION['role_id']
        ]
    ]);
} else {
    echo json_encode([
        "logged_in" => false
    ]);
}
?>