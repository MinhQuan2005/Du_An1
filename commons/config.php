<?php
$host = 'localhost'; 
$username = 'root';  
$password = '123123'; 
$database = 'x_shop'; 

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8");
if ($conn->errno) {
    die("Lỗi thiết lập charset: " . $conn->error);
}
?>