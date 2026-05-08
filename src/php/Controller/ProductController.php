<?php

require_once "./src/php/Model/Product.php";

class ProductController {

    private $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function getAllProducts($category = null, $search = null) {
        return $this->product->getAllProducts($category, $search);
    }

    public function getProductById($id) {
        return $this->product->getProductById($id);
    }

    public function getProductByIdAdmin($id) {
        return $this->product->getProductByIdAdmin($id);
    }

    public function getAllProductsAdmin() {
        return $this->product->getAllProductsAdmin();
    }

    public function getFeaturedProducts($limit = 8) {
        return $this->product->getFeaturedProducts($limit);
    }

    public function getBrands() {
        return $this->product->getBrands();
    }

    public function getTotalProducts() {
        return $this->product->getTotalProducts();
    }

    // Add product + upload images
    public function addProduct($adminID, $brand, $modelName, $category, $description, $price, $stock, $images) {
        $productId = $this->product->addProduct($adminID, $brand, $modelName, $category, $description, $price, $stock);
        if (!$productId) return false;

        $this->handleImageUploads($productId, $images);
        return $productId;
    }

    // Update product details
    public function updateProduct($id, $brand, $modelName, $category, $description, $price, $stock, $status, $images = null) {
        $updated = $this->product->updateProduct($id, $brand, $modelName, $category, $description, $price, $stock, $status);
        if ($images) {
            $this->handleImageUploads($id, $images);
        }
        return $updated;
    }

    public function deleteProduct($id) {
        return $this->product->deleteProduct($id);
    }

    // Upload images helper
    private function handleImageUploads($productId, $images) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Celario_lite/cellario_lite/uploads/";
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);

        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $isFirst = true;

        for ($i = 0; $i < count($images['name']); $i++) {
            if (empty($images['name'][$i])) continue;

            $mime = mime_content_type($images['tmp_name'][$i]);
            if (!in_array($mime, $allowed)) continue;

            $name     = time() . '_' . uniqid() . '_' . basename($images['name'][$i]);
            $target   = $uploadDir . $name;
            $relative = "/Celario_lite/cellario_lite/uploads/" . $name;

            if (move_uploaded_file($images['tmp_name'][$i], $target)) {
                $this->product->addProductImage($productId, $relative, $isFirst ? 1 : 0);
                $isFirst = false;
            }
        }
    }
}
