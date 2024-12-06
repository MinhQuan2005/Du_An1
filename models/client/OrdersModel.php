<?php
class OrdersModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createOrder($userId, $name, $phone, $email, $address, $orderDate, $status) {
        $query = "INSERT INTO orders (users_id, name, phone, email, address, order_date, status)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issssss", $userId, $name, $phone, $email, $address, $orderDate, $status);
        $stmt->execute();
        return $this->conn->insert_id; // Trả về ID của đơn hàng vừa tạo
    }

    public function addOrderDetail($orderId, $productId, $quantity, $price) {
        echo $orderId ;
         
        $query = "INSERT INTO order_details (orders_id, products_id, quantity, unit_price)
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
        $stmt->execute();
    }
    public function updateOrderStatus($orderId, $status) {
        $query = "UPDATE orders SET payment_status = ? WHERE orders_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('si', $status, $orderId);
        $stmt->execute();
        $stmt->close();
    }
    public function getOrdersByUserId($userId) {
        $query = "SELECT * FROM orders WHERE users_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Trả về danh sách đơn hàng
    }
    public function updateOrderStatus_($orderId, $status) {
        $query = "UPDATE orders SET status = ? WHERE orders_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('si', $status, $orderId);
        $stmt->execute();
        $stmt->close();
    }
}
?>
