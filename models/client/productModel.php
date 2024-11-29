<?php
class ProductModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // sua lai
    public function getProductsByCategory($CategoryId) {
        $sql= "SELECT products.* FROM products
                  JOIN categories ON products.categories_id = categories.categories_id
                  WHERE categories.categories_id = ?";
    
        $stmt = $this->conn->prepare($sql);  
        $stmt->bind_param('i', $CategoryId); 
        $stmt->execute();

        if ($stmt->error) {
            die('Error executing query: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
    public function getPopularProducts() {
        $sql = "SELECT * FROM products ORDER BY views DESC LIMIT 8";
        $result = $this->conn->query($sql);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
    public function getBySearch($search) {
        // Sử dụng dấu hỏi (?) thay vì :search
        $query = "SELECT * FROM products WHERE name LIKE ?";
        $stmt = $this->db->prepare($query);
        
        // Liên kết tham số với dấu hỏi (?)
        $searchParam = "%" . $search . "%";
        $stmt->bind_param("s", $searchParam); // "s" là kiểu dữ liệu của tham số (string)
    
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Lấy kết quả
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public function laySPtheoID($id) {
        // Câu truy vấn SQL với tham số $id
        $sql = "SELECT * 
            FROM `products` 
            JOIN `categories` ON `products`.`categories_id` = `categories`.`category_id` 
            WHERE `products`.`categories_id` = :id
            LIMIT 0, 25;";

        // Kết nối đến cơ sở dữ liệu (giả sử bạn đã có kết nối PDO)
        $stmt = $this->db->prepare($sql);

        // Liên kết tham số với giá trị thực tế của $id
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Thực thi câu truy vấn
        $stmt->execute();

        // Lấy tất cả kết quả và trả về dưới dạng mảng
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findProductById($id) {
        $id = (int)$id;
        $sql= "SELECT * FROM products WHERE products_id=$id";
        return $this->conn->query($sql)->fetch_assoc();
    }

    //bình luận
    public function getCommentsByProductId($id) {
        $sql = "SELECT comments.comment, comments.created_at, users.username 
                FROM comments 
                JOIN users ON comments.users_id = users.users_id
                WHERE comments.products_id = ? 
                ORDER BY comments.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    
        if ($stmt->error) {
            die('Error executing query: ' . $stmt->error);  
        }
    
        $result = $stmt->get_result();
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        return $comments;
    }
    // Thêm bình luận
    public function addComment($id, $user_id, $comment) {
        $sql = "INSERT INTO comments (products_id, users_id, comment, created_at) 
                VALUES (?, ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iis', $id, $user_id, $comment);
        $stmt->execute();
        
        if ($stmt->error) {
            die('Lỗi khi thực thi truy vấn: ' . $stmt->error);
        } else {
            echo "Bình luận đã được thêm thành công!";
        }
    }
}
?>
