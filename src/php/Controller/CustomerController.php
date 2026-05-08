<?php

require_once "./src/php/Model/Customer.php";

class CustomerController {

    private $customer;

    public function __construct() {
        $this->customer = new Customer();
    }

    public function addToCart($customerId, $productId, $quantity = 1) {
        return $this->customer->addToCart($customerId, $productId, $quantity);
    }

    public function removeFromCart($cartId, $customerId) {
        return $this->customer->removeFromCart($cartId, $customerId);
    }

    public function loadCart($customerId) {
        return $this->customer->loadCart($customerId);
    }

    public function getCartTotal($customerId) {
        return $this->customer->getCartTotal($customerId);
    }

    public function getCartCount($customerId) {
        return $this->customer->getCartCount($customerId);
    }

    public function addToFavorites($customerId, $productId) {
        return $this->customer->addToFavorites($customerId, $productId);
    }

    public function removeFromFavorites($favoriteId, $customerId) {
        return $this->customer->removeFromFavorites($favoriteId, $customerId);
    }

    public function loadFavorites($customerId) {
        return $this->customer->loadFavorites($customerId);
    }

    public function moveToCart($favoriteId, $customerId) {
        return $this->customer->moveToCart($favoriteId, $customerId);
    }

    public function placeOrder($customerId, $address, $apartment, $city, $country, $zipcode) {
        return $this->customer->placeOrder($customerId, $address, $apartment, $city, $country, $zipcode);
    }

    public function getOrders($customerId) {
        return $this->customer->getOrders($customerId);
    }

    public function getCustomerDetails($email) {
        return $this->customer->getCustomerDetails($email);
    }
}
