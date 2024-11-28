<?php
class CartModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function addToCart($userId, $productId, $quantity) {
        $cartId = $this->getCartId($userId);
        $sql = "INSERT INTO cart_details (carts_id, products_id, quantity) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE quantity = quantity + ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiii", $cartId, $productId, $quantity, $quantity);
        $stmt->execute();
    }

    public function getCartItems($userId) {
        $sql = "SELECT cd.cart_details_id, p.name, p.price, p.image, cd.quantity 
                FROM cart_details cd
                JOIN products p ON cd.products_id = p.products_id
                WHERE cd.carts_id = (SELECT carts_id FROM carts WHERE users_id = ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateQuantity($cartDetailsId, $quantity) {
        $sql = "UPDATE cart_details SET quantity = ? WHERE cart_details_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $quantity, $cartDetailsId);
        $stmt->execute();
    }

    public function removeItem($cartDetailsId) {
        $sql = "DELETE FROM cart_details WHERE cart_details_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $cartDetailsId);
        $stmt->execute();
    }

    private function getCartId($userId) {
        $sql = "SELECT carts_id FROM carts WHERE users_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart = $result->fetch_assoc();

        if (!$cart) {
            $sql = "INSERT INTO carts (users_id) VALUES (?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            return $this->db->insert_id;
        }
        return $cart['carts_id'];
    }
}
?>
