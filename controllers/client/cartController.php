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
            exit(); // Dừng lại không thực thi tiếp
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
    
        // Truyền dữ liệu giỏ hàng và tổng tiền vào view
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
        if (isset($_GET['cart_details_id'])) {
            $cartDetailsId = $_GET['cart_details_id'];
            $this->cartModel->removeItem($cartDetailsId);
            header("Location: index.php?act=cart");
            exit();
        }
    }
}
?>
