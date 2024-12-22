<?php
namespace App\Models;
class OrderListModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function addOrderItem($order_id, $product_id, $qty) {
        $stmt = $this->db->prepare("INSERT INTO order_list (order_id, product_id, qty) VALUES (?, ?, ?)");
        return $stmt->execute([$order_id, $product_id, $qty]);
    }

    public function getOrderItems($order_id) {
        return $this->db->query("SELECT * FROM order_list WHERE order_id = $order_id")->fetchAll();
    }

    public function deleteOrderItem($id) {
        return $this->db->query("DELETE FROM order_list WHERE id = $id");
    }
}
?>
