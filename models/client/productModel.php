<?php
class ProductModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get products by category ID
    public function getProductsByCategory($categoryId) {
        // Ensure correct column names for the foreign key relationship
        $sql = "SELECT products.* 
                FROM products
                JOIN categories ON products.category_id = categories.id  -- Make sure this matches your DB schema
                WHERE categories.id = ?";  // Assuming 'id' is the primary key in categories table
    
        $stmt = $this->conn->prepare($sql);  
        $stmt->bind_param('i', $categoryId);  // Bind the category ID as an integer
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

    // Get popular products
    public function getPopularProducts() {
        $sql = "SELECT * FROM products ORDER BY views DESC LIMIT 8";
        $result = $this->conn->query($sql);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }

    // Search products by name
    public function getBySearch($search) {
        $query = "SELECT * FROM products WHERE name LIKE ?";
        $stmt = $this->conn->prepare($query);
        
        $searchParam = "%" . $search . "%";
        $stmt->bind_param("s", $searchParam); // "s" is for string type
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get product by ID
    public function findProductById($id) {
        $id = (int)$id;  // Ensure that $id is an integer
        $sql = "SELECT * FROM products WHERE products_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);  // Bind the product ID as an integer
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Get comments by product ID
    public function getCommentsByProductId($id) {
        $sql = "SELECT comments.comment, comments.created_at, users.username 
                FROM comments 
                JOIN users ON comments.users_id = users.users_id
                WHERE comments.products_id = ? 
                ORDER BY comments.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);  // Bind the product ID as an integer
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

    // Add a comment for a product
    public function addComment($productId, $userId, $comment) {
        $sql = "INSERT INTO comments (products_id, users_id, comment, created_at) 
                VALUES (?, ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iis', $productId, $userId, $comment);
        $stmt->execute();

        if ($stmt->error) {
            die('Error executing query: ' . $stmt->error);
        } else {
            echo "Bình luận đã được thêm thành công!";
        }
    }
}
?>