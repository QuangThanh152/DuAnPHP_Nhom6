<?php
namespace App\Models;

class CartModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function addCartItem($client_ip, $user_id, $product_id, $qty) {
        $stmt = $this->db->prepare("INSERT INTO cart (client_ip, user_id, product_id, qty) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$client_ip, $user_id, $product_id, $qty]);
    }

    public function getCartItems($user_id) {
        $result = $this->db->query("SELECT * FROM cart WHERE user_id = $user_id");
        
        $cartItems = [];
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
        
        return $cartItems;
    }

    public function updateCartItemQty($id, $qty) {
        return $this->db->query("UPDATE cart SET qty = $qty WHERE id = $id");
    }

    public function deleteCartItem($id) {
        return $this->db->query("DELETE FROM cart WHERE id = $id");
    }
}
?>
