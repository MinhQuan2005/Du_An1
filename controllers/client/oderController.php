<?php
require_once './models/client/oderModel.php';

class CheckoutController {
    public function checkoutForm() {
        // Lấy thông tin người dùng đã đăng nhập
        $user_id = $_SESSION['user']['users_id'];
        $userInfo = CheckoutModel::getUserInfo($user_id);
        $cartDetails = CheckoutModel::getCartDetails($user_id);

        // Tính tổng tiền
        $totalPrice = array_reduce($cartDetails, function ($sum, $item) {
            return $sum + $item['price'] * $item['quantity'];
        }, 0);

        // Hiển thị view thanh toán
        include './views/client/oder.php';
    }

    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['users_id'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address'];
    
            // Lấy chi tiết giỏ hàng
            $cartDetails = CheckoutModel::getCartDetails($user_id);
    
            // Tính tổng tiền
            $totalPrice = array_reduce($cartDetails, function ($sum, $item) {
                return $sum + $item['price'] * $item['quantity'];
            }, 0);
    
            // Thêm đơn hàng
            $order_id = CheckoutModel::createOrder($user_id, $name, $phone, $email, $address,$totalPrice);
    
            // Thêm chi tiết đơn hàng
            CheckoutModel::createOrderDetails($order_id, $cartDetails);
    
            // Xóa giỏ hàng
            CheckoutModel::clearCart($user_id);
    
            // Chuyển hướng đến trang thành công
            header('Location: index.php?act=order_success');
        }
    }
    
}
