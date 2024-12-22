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

            if ($user === false || $user === null) {
                $this->render('login', ['error' => 'User not found']);
                return;
            }

            if ($password === $user['password']) {
                $_SESSION['user'] = $user;
                $this->redirect(BASE_URL . '/dashboard.php');
            } else {
                $this->render('login', ['error' => 'Invalid username or password']);
            }
        } else {
            $this->render('login');
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        $this->redirect(BASE_URL . '/login.php');
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            // Implement signup logic and render appropriate view
        } else {
            $this->render('signup');
        }
    }

    public function profile() {
        $this->render('profile', ['user' => $_SESSION['user']]);
    }
}
?>
