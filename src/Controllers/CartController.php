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
        $this->render('cart_list', ['cartItems' => $cartItems]);
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

    public function updateProductQtyInCart($id, $qty) {
        $this->cartModel->updateCartItemQty($id, $qty);
        $this->viewCart();
    }

    public function checkout() {
        // Implement checkout logic here
        $this->render('checkout');
    }
}
?>
