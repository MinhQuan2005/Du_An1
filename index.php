<?php
session_start();
//Require toàn bộ file commons
require_once './commons/env.php'; 
require_once './commons/function.php'; 
require_once './commons/config.php';

// Require toàn bộ file controllers
require_once './controllers/client/dashboardController.php';
require_once './controllers/admin/adminDashboardController.php';
require_once './controllers/client/userController.php';
require_once './controllers/client/productController.php';

// Require toàn bộ file models
require_once './models/client/categoryModel.php';
require_once './models/client/productModel.php';
// Phần show sản phẩm
$productModel = new ProductModel($conn);
$productController = new productController($productModel);
$action = $_GET['act'] ?? 'home';
if ($action == 'home') {
    $productController->index();
}

// Xử lý route với match
$act = $_GET['act'] ?? '/';

$is_admin = $_SESSION['user']['is_admin'] ?? 0;

match ($act) {
    '/' => $is_admin ? 
        (new adminDashboardController())->adminDashboard() : 
        (new dashboardController())->dashboard(),
    'register' => (new UserController())->register(),
    'login' => (new UserController())->login(),
    'logout' => (new UserController())->logout(),
    'admin' => (new adminDashboardController())->adminDashboard(),
    'home' => (new dashboardController())->dashboard(),
    'detailpro' => $productController->detailPro($_GET['id']),
    default => header("Location: account/login.php")
};
?>
