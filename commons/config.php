<?php
$host = 'localhost'; 
$username = 'root';  
$password = 123123;  // No password
$database = 'x_shop';
$port = 3306;  // Specify the port number

// Establish connection
$conn = new mysqli($host, $username,$password,  $database, $port);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8");
if ($conn->errno) {
    die("Lỗi thiết lập charset: " . $conn->error);
}
?>
