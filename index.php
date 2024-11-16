<?php
require_once './commons/function.php';
require_once './controllers/client/userController.php';
require_once './controllers/admin/dashboardController.php';
require_once './controllers/client/dashboardController.php';

$act = $_GET['act'] ?? '/';

session_start();
$is_admin = $_SESSION['user']['is_admin'] ?? 0;

match ($act) {
    '/' => $is_admin ? :
        (new dashboardController())->dashboard(),
    'register' => (new UserController())->register(),
    'login' => (new UserController())->login(),
    'logout' => (new UserController())->logout(),
    'home' => (new dashboardController())->dashboard(),
    default => header("Location: account/login.php")
};
?>