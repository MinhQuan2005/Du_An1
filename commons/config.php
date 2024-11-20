<?php
// Cấu hình kết nối cơ sở dữ liệu
$host = 'localhost'; // Địa chỉ máy chủ MySQL
$username = 'root';  // Tên người dùng MySQL
$password = '0017'; // Mật khẩu MySQL
$database = 'x_shop'; // Tên cơ sở dữ liệu

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($host, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
