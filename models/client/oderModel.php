<?php
require_once './commons/function.php';
class Database{
    private static $host = '127.0.0.1'; // Địa chỉ máy chủ
    private static $dbname = 'x_shop'; // Tên cơ sở dữ liệu
    private static $username = 'root'; // Tên người dùng
    private static $password = '123123'; // Mật khẩu
    private static $charset = 'utf8mb4'; // Mã hóa
    private static $pdo = null; // Biến lưu trữ kết nối PDO

    // Hàm kết nối đến cơ sở dữ liệu
    public static function connect() {
        if (self::$pdo === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=" . self::$charset;
                self::$pdo = new PDO($dsn, self::$username, self::$password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Hiển thị lỗi PDO
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Mặc định lấy dữ liệu dạng mảng kết hợp
            } catch (PDOException $e) {
                die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    // Hàm ngắt kết nối (không bắt buộc)
    public static function disconnect() {
        self::$pdo = null;
    }
}
class CheckoutModel {

    // Lấy thông tin người dùng
    public static function getUserInfo($user_Id) {
        $db = connectDB(); // Sử dụng hàm connectDB()
        $stmt = $db->prepare('SELECT * FROM users WHERE users_id = :id');
        $stmt->execute([':id' => $user_Id]);
        return $stmt->fetch();
    }

    // Lấy thông tin chi tiết giỏ hàng
    public static function getCartDetails($user_id) {
        $db = connectDB();
        $stmt = $db->prepare("
            SELECT p.products_id, p.name, p.price, p.image, cd.quantity 
            FROM carts c
            JOIN cart_details cd ON c.carts_id = cd.carts_id
            JOIN products p ON cd.products_id = p.products_id
            WHERE c.users_id = ?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tạo đơn hàng
    public static function createOrder($users_id, $products_id, $name, $phone, $email, $address) {
        $db = Database::connect();
        $sql = "INSERT INTO orders (users_id, products_id, name, phone, email, address) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
    
        // Kiểm tra nếu users_id không hợp lệ
        if (empty($users_id)) {
            throw new Exception("User ID is required for creating an order");
        }
    
        $stmt->execute([$users_id ?? null, $products_id, $name, $phone, $email, $address]);

    }
    
    // Tạo chi tiết đơn hàng
    public static function createOrderDetails($orderId, $cartDetails) {
        $db = connectDB();
        foreach ($cartDetails as $item) {
            // Kiểm tra nếu sản phẩm có giá trị hợp lệ
            if (!isset($item['products_id'], $item['quantity'], $item['price'])) {
                continue; // Nếu thiếu thông tin thì bỏ qua
            }

            // Truyền giá trị vào câu SQL
            $stmt = $db->prepare("
                INSERT INTO order_details (orders_id, products_id, quantity, unit_price, total_price, status)
                VALUES (?, ?, ?, ?, ?, 'Pending')
            ");
            $stmt->execute([
                $orderId, 
                $item['products_id'], 
                $item['quantity'], 
                $item['price'], 
                $item['quantity'] * $item['price']
            ]);
        }
    }
    
    // Xóa giỏ hàng sau khi đặt hàng thành công
    public static function clearCart($user_Id) {
        $db = connectDB();
        $stmt = $db->prepare("
            DELETE cd FROM cart_details cd 
            JOIN carts c ON cd.carts_id = c.carts_id
            WHERE c.users_id = ?
        ");
        $stmt->execute([$user_Id]);
    }

    // Cập nhật trạng thái đơn hàng
    public static function updateOrderStatus($order_id, $status) {
        $db = connectDB();
        $stmt = $db->prepare("UPDATE orders SET status = ? WHERE orders_id = ?");
        $stmt->execute([$status, $order_id]);
    }
}
