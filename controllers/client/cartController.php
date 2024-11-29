<?php
require_once './models/client/cartModel.php';
class CartController {
    private $cartModel;

    public function __construct($cartModel) {
        $this->cartModel = $cartModel;
    }
    
    // Thêm sản phẩm vào giỏ hàng
    public function addAction() {
        if (isset($_SESSION['user']['users_id']) && isset($_GET['product_id'])) {
            $userId = $_SESSION['user']['users_id'];
            $productId = $_GET['product_id'];
            $quantity = 1;  // Mặc định là 1 sản phẩm
            // Thêm sản phẩm vào giỏ hàng
            $this->cartModel->addToCart($userId, $productId, $quantity);
            // Chuyển hướng đến giỏ hàng
            header('Location:index.php?act=cart');
            exit;
        } else {
            echo 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!';
        }
    }

    // Hiển thị giỏ hàng
    public function viewAction() {
        if (isset($_SESSION['user']['users_id'])) {
            var_dump($_SESSION['user']['users_id']); 
            $userId = $_SESSION['user']['users_id'];
    
            $cartItems= $this->cartModel->getCart($userId);
            if (empty($cartItems)) {
                $cartItems = [];
            }
            require_once './views/client/carts.php';
        } else {
            echo 'Vui lòng đăng nhập để xem giỏ hàng!';
        }
    }

    // Cập nhật giỏ hàng
    public function updateAction() {
        if (isset($_SESSION['user']['users_id']) && isset($_POST['quantity'])) {
            $userId = $_SESSION['user']['users_id'];
            $cartId = $this->cartModel->getCartId($userId);
            $quantities = $_POST['quantity'];

            // Cập nhật số lượng sản phẩm trong giỏ hàng
            foreach ($quantities as $productId => $quantity) {
                $this->cartModel->updateQuantity($cartId, $productId, $quantity);
            }

            // Chuyển hướng lại giỏ hàng sau khi cập nhật
            header('Location: index.php?act=cart');
            exit;
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteAction() {
        if (isset($_SESSION['user']['users_id']) && isset($_GET['product_id'])) {
            $userId = $_SESSION['user']['users_id'];
            $productId = $_GET['product_id'];

            // Xóa sản phẩm khỏi giỏ hàng
            $this->cartModel->removeFromCart($userId, $productId);

            // Chuyển hướng lại giỏ hàng sau khi xóa
            header('Location: ../../../index.php?act=cart');
            exit;
        }
    }
}
?>
