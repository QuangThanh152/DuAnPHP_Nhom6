<?php
namespace App\Models;

class CartModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }
    public function getCartItems($user_id) {
        $query = "SELECT cart.id, cart.qty, product_list.name AS product_name, category_list.name AS category_name, product_list.price, product_list.img_path 
                  FROM cart 
                  JOIN product_list ON cart.product_id = product_list.id 
                  JOIN category_list ON product_list.category_id = category_list.id 
                  WHERE cart.user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $cartItems = [];
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
        
        return $cartItems;
    }
    
    
    public function addCartItem($client_ip, $user_id, $product_id, $qty) {
        $stmt = $this->db->prepare("INSERT INTO cart (client_ip, user_id, product_id, qty) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$client_ip, $user_id, $product_id, $qty]);
    }
    
    public function updateCartItemQty($id, $qty) {
        return $this->db->query("UPDATE cart SET qty = $qty WHERE id = $id");
    }

    public function deleteCartItem($id) {
        return $this->db->query("DELETE FROM cart WHERE id = $id");
    }

    public function clearCart($user_id) {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = ?");
        return $stmt->execute([$user_id]);
    }
}
?>
