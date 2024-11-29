<?php

class ProductModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    // sua lai
    public function getProductsByCategory($CategoryId) {
        $query = "SELECT products.* FROM products
                  JOIN categories ON products.categories_id = categories.id
                  WHERE categories.id = ?";

        $stmt = $this->db->prepare($query);
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
        $query = "SELECT * FROM products ORDER BY views DESC LIMIT 8";
        $result = $this->db->query($query);
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







































































































}
?>
