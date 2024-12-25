<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProductModel;
use Exception;

class ProductController extends Controller {
    private $productModel;

    public function __construct() {
        $conn = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->productModel = new ProductModel($conn);
    }

    public function listProducts() {
        try {
            $products = $this->productModel->getProducts();
            $data = [
                'title' => 'Danh sách sản phẩm',
                'products' => $products
            ];
            $this->render('product_list', $data);
        } catch (Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    public function viewProduct($productId) {
        $product = $this->productModel->getProductById($productId);
        $title = 'Chi tiết sản phẩm';
        ob_start();
        include __DIR__ . '/../View/views/product_detail.php';
        $content = ob_get_clean();
        include __DIR__ . '/../View/layouts/HomePage.php';
    }

    public function createProduct($data) {
        $this->productModel->addProduct($data['category_id'], $data['name'], $data['description'], $data['price'], $data['img_path'], $data['status']);
        $this->listProducts();
    }

    public function editProduct($productId, $data) {
        $this->productModel->updateProduct($productId, $data['category_id'], $data['name'], $data['description'], $data['price'], $data['img_path'], $data['status']);
        $this->viewProduct($productId);
    }

    public function deleteProduct($productId) {
        $this->productModel->deleteProduct($productId);
        $this->listProducts();
    }
}
?>
