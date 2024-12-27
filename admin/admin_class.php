<?php

class Action {
    private $db;

    public function __construct() {
        include 'includes/db_connect.php';
        $this->db = $conn;
    }

    // Hàm đăng nhập
    public function login() {
        try {
            if (!isset($_POST['username']) || !isset($_POST['password'])) {
                return 2; // Thiếu thông tin
            }

            $username = $this->db->real_escape_string($_POST['username']);
            $password = $this->db->real_escape_string($_POST['password']);

            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $_SESSION['login_type'] = $data['type'];

                foreach ($data as $key => $value) {
                    if ($key != 'password' && !is_numeric($key)) {
                        $_SESSION['login_' . $key] = $value;
                    }
                }
                $_SESSION['login_time'] = time();
                return 1; // Đăng nhập thành công
            }
            return 2; // Sai thông tin
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return 2; // Lỗi ngoại lệ
        }
    }

    // Kiểm tra quyền admin
    public function isAdmin() {
        return isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1;
    }

    // Kiểm tra quyền nhân viên
    public function isStaff() {
        return isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2;
    }

    function save_menu() {
        try {
            // Validate required fields
            if(!isset($_POST['name']) || !isset($_POST['description']) || !isset($_POST['price']) || !isset($_POST['category_id'])) {
                error_log("Missing required fields");
                return 0;
            }
    
            // Sanitize inputs
            $name = $this->db->real_escape_string($_POST['name']);
            $description = $this->db->real_escape_string($_POST['description']);
            $price = floatval($_POST['price']);
            $category_id = intval($_POST['category_id']);
            $status = isset($_POST['status']) ? intval($_POST['status']) : 1;
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
            // Handle file upload first
            $img_path = '';
            if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
                $target_dir = "assets/uploads/";
                
                // Create directory if it doesn't exist
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
    
                $fname = strtotime(date('y-m-d H:i')).'_'.basename($_FILES['img']['name']);
                $target_file = $target_dir . $fname;
    
                // Check file upload
                if(move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
                    $img_path = $fname;
                } else {
                    error_log("File upload failed");
                    // Continue without image if upload fails
                }
            }
    
            // Prepare SQL statement
            if(empty($id)) {
                // Insert new record
                $stmt = $this->db->prepare("INSERT INTO product_list (name, description, price, category_id, status, img_path) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdiis", $name, $description, $price, $category_id, $status, $img_path);
            } else {
                // Update existing record
                if($img_path != '') {
                    // With new image
                    $stmt = $this->db->prepare("UPDATE product_list SET name=?, description=?, price=?, category_id=?, status=?, img_path=? WHERE id=?");
                    $stmt->bind_param("ssdiisi", $name, $description, $price, $category_id, $status, $img_path, $id);
                } else {
                    // Without changing image
                    $stmt = $this->db->prepare("UPDATE product_list SET name=?, description=?, price=?, category_id=?, status=? WHERE id=?");
                    $stmt->bind_param("ssdiii", $name, $description, $price, $category_id, $status, $id);
                }
            }
    
            // Execute statement
            $save = $stmt->execute();
            
            if($save) {
                return 1;
            }
            
            error_log("MySQL Error: " . $stmt->error);
            return 0;
            
        } catch(Exception $e) {
            error_log("Error in save_menu: " . $e->getMessage());
            return 0;
        }
    }

    function delete_menu() {
        try {
            extract($_POST);
            
            // Debug
            error_log("Deleting menu ID: " . $id);
            
            $delete = $this->db->query("DELETE FROM product_list WHERE id = ".$id);
            
            if($delete) {
                return 1;
            }
            
            // Debug
            error_log("MySQL Error: " . $this->db->error);
            return 0;
            
        } catch(Exception $e) {
            error_log("Error in delete_menu: " . $e->getMessage());
            return 0;
        }
    }
    public function getActiveMenuCount() {
        $qry = $this->db->query("SELECT COUNT(*) as count FROM product_list WHERE status = 1");
        return $qry->fetch_assoc()['count'];
    }

    public function getInactiveMenuCount() {
        $qry = $this->db->query("SELECT COUNT(*) as count FROM product_list WHERE status = 0");
        return $qry->fetch_assoc()['count'];
    }

    public function getPendingOrdersCount() {
        $qry = $this->db->query("SELECT COUNT(*) as count FROM orders WHERE status = 0");
        return $qry->fetch_assoc()['count'];
    }

    public function getConfirmedOrdersCount() {
        $qry = $this->db->query("SELECT COUNT(*) as count FROM orders WHERE status = 1");
        return $qry->fetch_assoc()['count'];
    }

}
?>
