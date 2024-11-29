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
require_once './controllers/client/cartController.php';

// Require toàn bộ file models
require_once './models/client/categoryModel.php';
require_once './models/client/cartModel.php';

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
    'addComment' => $productController->addComment(),

    'addToCart' => $cartController->addAction(),
    'cart' => $cartController->viewAction(),
    'updateCart' => $cartController->updateAction(),
    'deleteFromCart' => $cartController->deleteAction(),
    default => header("Location: account/login.php")
};
?>
