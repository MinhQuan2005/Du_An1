<?php
// Require toàn bộ file Commons
 require_once './commons/function.php';
 // Require toàn bộ file Controllers
 require_once './controllers/dashboardController.php';
 // Require toàn bộ file Models

 // Route
$act = $_GET['act'] ?? '/';
match ($act) {
    // Trang chủ quản trị
    '/' => (new dashboardController)->dashboard(),
}
?>