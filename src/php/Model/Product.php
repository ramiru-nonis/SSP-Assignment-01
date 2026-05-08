<?php

require_once "./src/php/Model/Database.php";

class Product {

    protected $conn;
    private $table = "products";
    private $imagesTable = "product_images";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Get all active products with main image
    public function getAllProducts($category = null, $search = null) {
        $sql = "SELECT p.*, pi.image_path AS main_image
                FROM {$this->table} p
                LEFT JOIN {$this->imagesTable} pi ON p.id = pi.product_id AND pi.is_main = 1
                WHERE p.status = 'active'";

        $params = [];
        $types  = "";

        if ($category && $category !== 'all') {
            $sql    .= " AND p.category = ?";
            $params[] = $category;
            $types   .= "s";
        }
        if ($search) {
            $like     = "%" . $search . "%";
            $sql     .= " AND (p.brand LIKE ? OR p.model_name LIKE ? OR p.description LIKE ?)";
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $types   .= "sss";
        }

        $sql .= " ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get single product with all images
    public function getProductById($id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE id = ? AND status = 'active'"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if (!$product) return null;

        $imgStmt = $this->conn->prepare(
            "SELECT * FROM {$this->imagesTable} WHERE product_id = ? ORDER BY is_main DESC"
        );
        $imgStmt->bind_param("i", $id);
        $imgStmt->execute();
        $product['images'] = $imgStmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $product;
    }

    // Get product by ID for admin (including inactive)
    public function getProductByIdAdmin($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if (!$product) return null;

        $imgStmt = $this->conn->prepare(
            "SELECT * FROM {$this->imagesTable} WHERE product_id = ? ORDER BY is_main DESC"
        );
        $imgStmt->bind_param("i", $id);
        $imgStmt->execute();
        $product['images'] = $imgStmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $product;
    }

    // Get all products for admin (all statuses)
    public function getAllProductsAdmin() {
        $stmt = $this->conn->prepare(
            "SELECT p.*, pi.image_path AS main_image
             FROM {$this->table} p
             LEFT JOIN {$this->imagesTable} pi ON p.id = pi.product_id AND pi.is_main = 1
             ORDER BY p.created_at DESC"
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Add new product
    public function addProduct($adminID, $brand, $modelName, $category, $description, $price, $stock) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (adminID, brand, model_name, category, description, price, stock, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, 'active')"
        );
        $stmt->bind_param("issssdi", $adminID, $brand, $modelName, $category, $description, $price, $stock);
        $stmt->execute();
        return $this->conn->insert_id;
    }

    // Add product image
    public function addProductImage($productId, $imagePath, $isMain = 0) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->imagesTable} (product_id, image_path, is_main) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("isi", $productId, $imagePath, $isMain);
        return $stmt->execute();
    }

    // Update product
    public function updateProduct($id, $brand, $modelName, $category, $description, $price, $stock, $status) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table}
             SET brand=?, model_name=?, category=?, description=?, price=?, stock=?, status=?
             WHERE id=?"
        );
        $stmt->bind_param("ssssdisi", $brand, $modelName, $category, $description, $price, $stock, $status, $id);
        return $stmt->execute();
    }

    // Delete product and its images
    public function deleteProduct($id) {
        // Images cascade on delete (FK), but let's clean uploads too
        $imgs = $this->conn->prepare("SELECT image_path FROM {$this->imagesTable} WHERE product_id = ?");
        $imgs->bind_param("i", $id);
        $imgs->execute();
        $images = $imgs->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($images as $img) {
            $path = $_SERVER['DOCUMENT_ROOT'] . $img['image_path'];
            if (file_exists($path)) unlink($path);
        }

        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Get total count
    public function getTotalProducts() {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM {$this->table}");
        return $result->fetch_assoc()['total'];
    }

    // Get distinct brands
    public function getBrands() {
        $result = $this->conn->query(
            "SELECT DISTINCT brand FROM {$this->table} WHERE status='active' ORDER BY brand"
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get featured products (newest active)
    public function getFeaturedProducts($limit = 8) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, pi.image_path AS main_image
             FROM {$this->table} p
             LEFT JOIN {$this->imagesTable} pi ON p.id = pi.product_id AND pi.is_main = 1
             WHERE p.status = 'active'
             ORDER BY p.created_at DESC
             LIMIT ?"
        );
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
