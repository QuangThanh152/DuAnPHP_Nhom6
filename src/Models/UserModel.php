<?php
namespace App\Models;

class UserModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Kiểm tra nếu người dùng không tồn tại
        if ($result->num_rows === 0) {
            return false;
        }

        return $result->fetch_assoc();
    }

    public function getUsers() {
        return $this->db->query("SELECT * FROM users")->fetch_all(MYSQLI_ASSOC);
    }

    public function addUser($name, $username, $password, $type) {
        $stmt = $this->db->prepare("INSERT INTO users (name, username, password, type) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $username, $password, $type]);
    }
}
?>
