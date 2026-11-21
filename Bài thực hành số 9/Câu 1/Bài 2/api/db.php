<?php
// Kết nối database MySQL

$host = "localhost";
$username = "root";
$password = "";
$database = "product_management";

$conn = new mysqli(
    $host,
    $username,
    $password,
    $database
);

// Kiểm tra kết nối
if ($conn->connect_error) {
    http_response_code(500);
    header("Content-Type: application/json; charset=UTF-8");

    echo json_encode([
        "success" => false,
        "message" => "Không thể kết nối database"
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

// Thiết lập UTF-8
$conn->set_charset("utf8mb4");
