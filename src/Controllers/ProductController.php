<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProductModel;

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
        $products = $this->productModel->getProducts();
        $this->render('product_list', ['products' => $products]);
    }

    public function viewProduct($productId) {
        $product = $this->productModel->getProductById($productId);
        $this->render('product_detail', ['product' => $product]);
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
