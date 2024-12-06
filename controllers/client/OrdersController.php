<?php
class OrdersController {
    private $ordersModel;

    public function __construct($ordersModel) {
        $this->ordersModel = $ordersModel;
    }

    public function orderHistory($userId) {
        $orders = $this->ordersModel->getOrdersByUserId($userId);
        include './views/client/orderHistory.php'; // Đường dẫn đến file view
    }
    public function cancelOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
        
            $orderId = intval($_POST['orderId']);
        
            $this->ordersModel->updateOrderStatus_($orderId, 'Đã hủy');
            header('Location: index.php?act=orderHistory'); // Quay lại trang lịch sử đơn hàng
            exit();
        }
    }
    
}
