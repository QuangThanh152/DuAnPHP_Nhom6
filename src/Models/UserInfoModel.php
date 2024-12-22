<?php
namespace App\Models;
class UserInfoModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function addUserInfo($first_name, $last_name, $email, $password, $mobile, $address) {
        $stmt = $this->db->prepare("INSERT INTO user_info (first_name, last_name, email, password, mobile, address) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$first_name, $last_name, $email, $password, $mobile, $address]);
    }

    public function getUserInfos() {
        return $this->db->query("SELECT * FROM user_info")->fetchAll();
    }

    public function updateUserInfo($user_id, $first_name, $last_name, $email, $password, $mobile, $address) {
        $stmt = $this->db->prepare("UPDATE user_info SET first_name = ?, last_name = ?, email = ?, password = ?, mobile = ?, address = ? WHERE user_id = ?");
        return $stmt->execute([$first_name, $last_name, $email, $password, $mobile, $address, $user_id]);
    }

    public function deleteUserInfo($user_id) {
        return $this->db->query("DELETE FROM user_info WHERE user_id = $user_id");
    }
}
?>
