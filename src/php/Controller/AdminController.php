<?php

require_once "./src/php/Model/Admin.php";

class AdminController {

    private Admin $admin;

    public function __construct() {
        $this->admin = new Admin();
    }

    public function getAllCustomers() {
        return $this->admin->getAllCustomers();
    }

    public function deleteAccount(int $id) {
        return $this->admin->deleteUser($id);
    }

    public function getAdminDetails(string $email) {
        return $this->admin->getAdminDetails($email);
    }

    public function getTotal(string $table) {
        return $this->admin->getTotal($table);
    }

    public function getTotalRevenue() {
        return $this->admin->getTotalRevenue();
    }

    public function getRecentOrders(int $limit = 10) {
        return $this->admin->getRecentOrders($limit);
    }

    public function getUserById(int $id) {
        return $this->admin->getUserById($id);
    }

    public function updateUser(int $id, string $fname, string $lname, string $email) {
        return $this->admin->updateUser($id, $fname, $lname, $email);
    }

    public function getLowStockProducts(int $threshold = 5) {
        return $this->admin->getLowStockProducts($threshold);
    }
}
