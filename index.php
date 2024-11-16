<?php
// Require toàn bộ file Commons
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ


 // Require toàn bộ file Controllers
require_once './controllers/client/dashboardController.php';
require_once './controllers/admin/adminDashboardController.php';


 // Require toàn bộ file Models
 


 // Route
$act = $_GET['act'] ?? '/';
match ($act) {
    // Trang chủ
    '/' => (new dashboardController)->dashboard(),

    // Trang quản trị
    '/admin' => (new adminDashboardController)->adminDashboard(),
    
}
?>