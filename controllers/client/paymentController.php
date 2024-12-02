<?php
require_once './commons/function.php';

class PaymentController {
    // Xử lý thanh toán qua VNPay
    public function processVNPay() {
        $totalPrice = $_POST['total_price'];
        $orderId = $_POST['order_id'];
        
        // Cấu hình thanh toán VNPay
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://yourwebsite.com/index.php?act=vnpayReturn";
        $vnp_TmnCode = "YOUR_TMN_CODE"; // Mã website VNPay
        $vnp_HashSecret = "YOUR_HASH_SECRET"; // Chuỗi bí mật
        
        $vnp_TxnRef = $orderId;
        $vnp_Amount = $totalPrice * 100; // VNPay yêu cầu nhân với 100
        $vnp_Locale = "vn";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_BankCode = "";

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan don hang $orderId",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if ($vnp_HashSecret) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        header('Location: ' . $vnp_Url);
        die();
    }

    // Xử lý thanh toán qua MoMo
    public function processMoMo() {
        // Lấy giá trị tổng tiền và ID đơn hàng từ POST
        $totalPrice = $_POST['total_price'];
        $orderId = $_POST['order_id'];
    
        // Cấu hình thanh toán MoMo
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = "YOUR_PARTNER_CODE";  // Thay thế với partnerCode thực
        $accessKey = "YOUR_ACCESS_KEY";      // Thay thế với accessKey thực
        $secretKey = "YOUR_SECRET_KEY";      // Thay thế với secretKey thực
        $orderInfo = "Thanh toán đơn hàng $orderId";
        $redirectUrl = "http://yourwebsite.com/index.php?act=momoReturn";  // Thay thế với URL thực
        $ipnUrl = "http://yourwebsite.com/index.php?act=momoIpn";  // Thay thế với URL thực
        $extraData = "";
    
        // Tạo requestId và requestType
        $requestId = time() . "";
        $requestType = "captureWallet";
        $amount = $totalPrice;
    
        // Tạo chữ ký
        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
    
        // Dữ liệu gửi đi
        $data = array(
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
        );
    
        // Gửi yêu cầu thanh toán đến MoMo
        $result = json_decode($this->execPostRequest($endpoint, json_encode($data)), true);
    
        // Chuyển hướng người dùng đến trang thanh toán MoMo
        if (isset($result['payUrl'])) {
            header('Location: ' . $result['payUrl']);
            die();
        } else {
            // Nếu không có `payUrl`, hiển thị thông báo lỗi với chi tiết kết quả trả về
            echo "Lỗi trong quá trình thanh toán! Chi tiết lỗi: ";
            var_dump($result);  // Hiển thị kết quả trả về từ MoMo để kiểm tra
        }
    }
    
    private function execPostRequest($url, $data) {
        // Khởi tạo cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        // Thực hiện yêu cầu
        $result = curl_exec($ch);
        
        // Đóng kết nối cURL
        curl_close($ch);
        return $result;
    }
    

}    