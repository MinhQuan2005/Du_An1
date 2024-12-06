
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
require_once './controllers/client/CheckoutController.php';
require_once './controllers/client/OrdersController.php';
// Require toàn bộ file models
require_once './models/client/categoryModel.php';
require_once './models/client/OrdersModel.php';
require_once './models/client/productModel.php';
require_once './models/client/cartModel.php';

// Phần show sản phẩm
$productModel = new ProductModel($conn);
$productController = new productController($productModel);

$cartModel = new CartModel($conn);
$OrdersModel = new OrdersModel($conn);
$cartController = new CartController($cartModel);



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
        'checkout' => (new CheckoutController())->checkout($_SESSION['user']['users_id']),
        'processOrder' => (new CheckoutController())->processOrder($_SESSION['user']['users_id'], $_POST),
        'vpnReturnUrl' => (new CheckoutController())->vpnReturnUrl(),
    'register' => (new UserController())->register(),
    'login' => (new UserController())->login(),
    'logout' => (new UserController())->logout(),
    'admin' => (new adminDashboardController())->adminDashboard(),
    'home' => (new dashboardController())->dashboard(),
    'dmnam' => (new productController($productModel))->showDMnam(),
    'dmnu' => (new productController($productModel))->showDMnu(),
    'dmtreem' => (new productController($productModel))->showDMtrmeem(),
    'detailpro' => $productController->detailPro($_GET['id']),
    'orderHistory' => (new OrdersController($OrdersModel))->orderHistory($_SESSION['user']['users_id']),
    'addComment' => $productController->addComment(),
    'search' => (new productController($productModel))->search(), // Thêm dòng này để xử lý tìm kiếm
    'addToCart' => $cartController->addAction(),
    'cart' => $cartController->viewAction(),
    'updateCart' => $cartController->updateAction(),
   'cancelOrder'=> (new OrdersController($OrdersModel))->cancelOrder(),
     
    
    'deleteFromCart' => $cartController->deleteAction(),
    default => header("Location: account/login.php")
};

?>
