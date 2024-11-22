<?php

class ProductModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }
    public function getProductsByCategory($CategoryId) {
        $sql= "SELECT products.* FROM products
                  JOIN categories ON products.categories_id = categories.categories_id
                  WHERE categories.categories_id = ?";
    
        $stmt = $this->db->prepare($sql);
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
        $result = $this->db->query($sql);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
    public function findProductById($id) {
        $id = (int)$id;
        $sql= "SELECT * FROM products WHERE products_id=$id";
        return $this->db->query($sql)->fetch_assoc();
    }
    
}
?>
