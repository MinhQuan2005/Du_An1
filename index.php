<?php
// Require toàn bộ file commons
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ


// Require toàn bộ file controllers
require_once './controllers/client/dashboardController.php';
require_once './controllers/admin/adminDashboardController.php';
require_once './controllers/client/userController.php';
require_once './controllers/client/dashboardController.php';


// Require toàn bộ file models


// Route
$act = $_GET['act'] ?? '/';

session_start();
$is_admin = $_SESSION['user']['is_admin'] ?? 0;

match ($act) {
    '/' => $is_admin ? 
        (new adminDashboardController): 
        (new dashboardController())->dashboard(),
    'register' => (new UserController())->register(),
    'login' => (new UserController())->login(),
    'logout' => (new UserController())->logout(),
    'admin' => (new adminDashboardController())->adminDashboard(),
    'home' => (new dashboardController())->dashboard(),
    default => header("Location: account/login.php")
};
?>