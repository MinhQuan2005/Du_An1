<?php
class CategoryModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getAllCategories() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        if ($stmt->errorCode() != '00000') {
            die('Error executing query: ' . implode(', ', $stmt->errorInfo()));
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
