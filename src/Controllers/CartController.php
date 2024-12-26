<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\CartModel;

class CartController extends Controller {
    private $cartModel;

    public function __construct() {
        $conn = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->cartModel = new CartModel($conn);
    }
public function viewCart() {
    $user_id = $_SESSION['user']['id'];
    $cartItems = $this->cartModel->getCartItems($user_id);
    $data = [
        'title' => 'Giỏ hàng của bạn',
        'cartItems' => $cartItems,
        'notification' => isset($_SESSION['notification']) ? $_SESSION['notification'] : null
    ];
    unset($_SESSION['notification']);
    $this->render('cart_list', $data);
}

    public function addProductToCart($productId, $qty) {
        $client_ip = $_SERVER['REMOTE_ADDR'];
        $user_id = $_SESSION['user']['id'];
        $this->cartModel->addCartItem($client_ip, $user_id, $productId, $qty);
        $this->viewCart();
    }

    public function removeProductFromCart($id) {
        $this->cartModel->deleteCartItem($id);
        $this->viewCart();
    }

    public function updateProductQtyInCart($id) {
        if (isset($_POST['qty'])) {
            $qty = $_POST['qty'];
            $this->cartModel->updateCartItemQty($id, $qty);
            // Lưu thông báo vào session
            $_SESSION['notification'] = 'Cập nhật thành công!';
            // Chuyển hướng về trang giỏ hàng sau khi cập nhật số lượng
            $this->redirect('/cart');
        } else {
            // Xử lý lỗi nếu tham số 'qty' không tồn tại
            $this->redirect('/cart');
        }
    }

    public function checkout() {
        $user_id = $_SESSION['user']['id'];
        $this->cartModel->clearCart($user_id);
        // Lưu thông báo vào session
        $_SESSION['notification'] = 'Thanh toán thành công!';
        // Chuyển hướng về trang giỏ hàng sau khi thanh toán
        $this->redirect('/cart');
    }
}
?>
