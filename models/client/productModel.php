<?php
class ProductModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
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
