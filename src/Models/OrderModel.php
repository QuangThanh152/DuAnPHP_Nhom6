<?php
namespace App\Models;
class OrderModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function addOrder($name, $address, $mobile, $email, $status) {
        $stmt = $this->db->prepare("INSERT INTO orders (name, address, mobile, email, status) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $address, $mobile, $email, $status]);
    }

    public function getOrders() {
        return $this->db->query("SELECT * FROM orders")->fetchAll();
    }

    public function updateOrderStatus($id, $status) {
        return $this->db->query("UPDATE orders SET status = $status WHERE id = $id");
    }

    public function deleteOrder($id) {
        return $this->db->query("DELETE FROM orders WHERE id = $id");
    }
}
?>
