<?php

require_once "./src/php/Model/Database.php";

class Admin {

    protected $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Get all non-admin users
    public function getAllCustomers() {
        $stmt = $this->conn->prepare(
            "SELECT * FROM users WHERE role = 'customer' ORDER BY id DESC"
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Delete user
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Get admin details by email
    public function getAdminDetails($email) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM users WHERE email = ? AND role = 'admin'"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Get count from any table
    public function getTotal($table) {
        $allowed = ['users', 'products', 'orders', 'cart', 'favorites'];
        if (!in_array($table, $allowed)) return 0;
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM `{$table}`");
        return $result->fetch_assoc()['total'];
    }

    // Total revenue from completed orders
    public function getTotalRevenue() {
        $result = $this->conn->query(
            "SELECT SUM(price) AS total FROM orders WHERE status = 'completed'"
        );
        return $result->fetch_assoc()['total'] ?? 0;
    }

    // Get recent orders
    public function getRecentOrders($limit = 10) {
        $stmt = $this->conn->prepare(
            "SELECT o.*, u.firstName, u.lastName, p.brand, p.model_name
             FROM orders o
             JOIN users u ON o.customerID = u.id
             JOIN products p ON o.productID = p.id
             ORDER BY o.created_at DESC
             LIMIT ?"
        );
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get user by ID for editing
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update user account
    public function updateUser($id, $fname, $lname, $email) {
        $stmt = $this->conn->prepare(
            "UPDATE users SET firstName=?, lastName=?, email=? WHERE id=?"
        );
        $stmt->bind_param("sssi", $fname, $lname, $email, $id);
        return $stmt->execute();
    }

    // Get low stock products
    public function getLowStockProducts($threshold = 5) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM products WHERE stock <= ? AND status = 'active' ORDER BY stock ASC"
        );
        $stmt->bind_param("i", $threshold);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
