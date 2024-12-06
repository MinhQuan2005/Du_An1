<?php
class CheckoutController {
    public function checkout($userId) {
        // Lấy dữ liệu giỏ hàng
       
        $cartModel = new CartModel($GLOBALS['conn']);
        $cartItems = $cartModel->getCartItems($userId);

        if (empty($cartItems)) {
            $_SESSION['error'] = "Giỏ hàng của bạn trống!";
            header("Location: index.php?act=cart");
            exit;
        }

        // Hiển thị trang thanh toán
        require_once './views/client/checkout.php';
    }

    public function processOrder($userId, $postData) {
        $cartModel = new CartModel($GLOBALS['conn']);
        $cartItems = $cartModel->getCartItems($userId);
    
        if (empty($cartItems)) {
            $_SESSION['error'] = "Không có sản phẩm trong giỏ hàng để thanh toán.";
            header("Location: index.php?act=cart");
            exit;
        }
    
        // Lấy thông tin nhận hàng
        $name = mysqli_real_escape_string($GLOBALS['conn'], $postData['name']);
        $phone = mysqli_real_escape_string($GLOBALS['conn'], $postData['phone']);
        $email = mysqli_real_escape_string($GLOBALS['conn'], $postData['email']);
        $address = mysqli_real_escape_string($GLOBALS['conn'], $postData['address']);
        $orderDate = date('Y-m-d H:i:s');
        $status = "Đang chờ xử lý";
    
        // Tạo đơn hàng
        $ordersModel = new OrdersModel($GLOBALS['conn']);
        $orderId = $ordersModel->createOrder($userId, $name, $phone, $email, $address, $orderDate, $status);
    
        // Lưu chi tiết đơn hàng
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $ordersModel->addOrderDetail($orderId, $item['products_id'], $item['quantity'], $item['price']);
            $totalAmount += $item['quantity'] * $item['price'];
        }
    
        // Xóa giỏ hàng
        $cartModel->clearCart($userId);
    
        // Chuyển đến VNPAY
        $vnpUrl = $this->initiateVNPay($orderId, $totalAmount);
        header("Location: $vnpUrl");
        exit;
    }
    
    private function initiateVNPay($orderId, $amount) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8080/Du%20an%201_Nhom%204/index.php?act=vpnReturnUrl";
        $vnp_TmnCode = "R3E63P5P"; //Mã website tại VNPAY
        $vnp_HashSecret = "GXDEHIEBSREFTEALNKYBXMKDKVVBEJPC"; //Chuỗi bí mật
    
        $vnp_TxnRef = $orderId; //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $amount; // Số tiền thanh toán
        $vnp_Locale = 'vi'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = 'NCB'; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" ,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate"=>$expire
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
        
    }
    public function vpnReturnUrl() {
        // Lấy thông tin từ URL trả về
        $vnp_TransactionStatus = $_GET['vnp_TransactionStatus'] ?? '';
        $vnp_TxnRef = $_GET['vnp_TxnRef'] ?? '';
    
        // Tạo mô hình đơn hàng để thực hiện cập nhật
        $ordersModel = new OrdersModel($GLOBALS['conn']);
    
        if ($vnp_TransactionStatus == '00') {
            // Thanh toán thành công
            // Cập nhật trạng thái đơn hàng
            $updateStatus = "Thanh toán thành công";
            $ordersModel->updateOrderStatus($vnp_TxnRef, $updateStatus);
            
            // Thông báo thành công
            $_SESSION['success'] = "Thanh toán thành công!";
        } else {
            // Thanh toán thất bại
            $updateStatus = "Thanh toán thất bại";
            $ordersModel->updateOrderStatus($vnp_TxnRef, $updateStatus);
    
            // Thông báo thất bại
            $_SESSION['error'] = "Thanh toán không thành công. Vui lòng kiểm tra lại!";
        }
    
        // Điều hướng về trang chủ hoặc trang phù hợp
        header("Location: index.php?act=home");
        exit;
    }
    
}
?>
