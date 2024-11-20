<?php
class CategoryModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getAllCategories() {
        $query = "SELECT * FROM categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        if ($stmt->errorCode() != '00000') {
            die('Error executing query: ' . implode(', ', $stmt->errorInfo()));
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
