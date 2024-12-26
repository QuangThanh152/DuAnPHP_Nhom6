<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\UserModel;

class LoginController extends Controller {
    private $userModel;

    public function __construct() {
        $conn = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->userModel = new UserModel($conn);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $this->userModel->getUserByUsername($username);

            if ($user === false) {
                $error = 'Username not found';
            } elseif ($password !== $user['password']) {
                $error = 'Incorrect password';
            } elseif ($user['type'] != 2) {
                $error = 'Only users can log in';
            } else {
                // Đăng nhập thành công
                $_SESSION['user'] = $user;
                $this->redirect('/products');
                return;
            }
            // Hiển thị thông báo lỗi cụ thể trong cùng trang
            $this->renderLoginPage($error);
        } else {
            $this->renderLoginPage();
        }
    }

    private function renderLoginPage($error = null) {
        // Chuyển đổi sang biến toàn cục để sử dụng trong HTML
        global $error;
        include __DIR__ . '/../View/layouts/LoginPage.php';
    }

    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        $this->redirect('/login.php');
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            if ($password !== $confirmPassword) {
                $error = 'Passwords do not match';
                $this->renderLoginPage($error);
                return;
            }

            $existingUser = $this->userModel->getUserByUsername($username);
            if ($existingUser) {
                $error = 'Username already exists';
                $this->renderLoginPage($error);
                return;
            }

            $result = $this->userModel->createUser($username, $password, $firstName, $lastName, $email, $phone, $address);
            if ($result) {
                // Đăng ký thành công, chuyển hướng đến trang đăng nhập
                $this->redirect('/login');
            } else {
                $error = 'Failed to create user';
                $this->renderLoginPage($error);
            }
        } else {
            $this->renderLoginPage();
        }
    }
}
?>
