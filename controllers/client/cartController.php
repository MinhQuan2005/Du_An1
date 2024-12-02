<?php
class CartController {
    private $cartModel;

    public function __construct($cartModel) {
        $this->cartModel = $cartModel;
    }

    public function addAction() {
        if (isset($_POST['product_id'], $_POST['quantity'])) {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $userId = $_SESSION['user']['users_id'] ?? null;

            if ($userId) {
                $this->cartModel->addToCart($userId, $productId, $quantity);
                header("Location: index.php?act=cart");
                exit();
            } else {
                echo "<script>
        var isConfirmed = confirm('Vui lòng đăng nhập để thêm vào giỏ hàng. Bạn có muốn đăng nhập không?');
        if (isConfirmed) {
            window.location.href = '../../../Du an 1_Nhom 4/account/login.php'; // Chuyển hướng đến trang đăng nhập
        }
    </script>";
            }
        }
    }
    public function viewAction() {
        // Kiểm tra người dùng đã đăng nhập hay chưa
        if (!isset($_SESSION['user']['users_id'])) {
            echo "<script>
            var isConfirmed = confirm('Vui lòng đăng nhập để xem giỏ hàng. Bạn có muốn đăng nhập không?');
            if (isConfirmed) {
                window.location.href = '../../../Du an 1_Nhom 4/account/login.php'; // Chuyển hướng đến trang đăng nhập
            }else{
             window.location.href = '../../../Du an 1_Nhom 4/index.php?act=home';
            }
        </script>";
            exit(); 
        }
        // Người dùng đã đăng nhập, lấy ID người dùng
        $userId = $_SESSION['user']['users_id'];
        // Lấy các sản phẩm trong giỏ hàng của người dùng
        $cartItems = $this->cartModel->getCartItems($userId);
        $totalPrice = 0;
        foreach ($cartItems as $item) { 
            // Tính tổng tiền cho từng sản phẩm trong giỏ hàng
            $item['total_price'] = $item['price'] * $item['quantity'];
            $totalPrice += $item['total_price']; // Cộng dồn tổng tiền
        }
        require_once './views/client/carts.php';
    }
   
    
    

    // Cập nhật giỏ hàng
    public function updateAction() {
        if (isset($_POST['quantity'], $_POST['cart_details_id'])) {
            foreach ($_POST['quantity'] as $key => $quantity) {
                $cartDetailsId = $_POST['cart_details_id'][$key];
                $this->cartModel->updateQuantity($cartDetailsId, $quantity);
            }
            header("Location: index.php?act=cart");
            exit();
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteAction() {
        if (isset($_GET['cart_details_id'])) {
            $cartDetailsId = $_GET['cart_details_id'];
            $this->cartModel->removeItem($cartDetailsId);
            header("Location: index.php?act=cart");
            exit();
        }
    }
}
?>