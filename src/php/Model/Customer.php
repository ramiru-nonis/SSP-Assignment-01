<?php

require_once "./src/php/Model/Database.php";

class Customer {

    protected $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // ─── CART ────────────────────────────────────────────────

    // Add product to cart
    public function addToCart($customerId, $productId, $quantity = 1) {
        // Check if already in cart
        $check = $this->conn->prepare(
            "SELECT id, quantity FROM cart WHERE customerID = ? AND productID = ?"
        );
        $check->bind_param("ii", $customerId, $productId);
        $check->execute();
        $existing = $check->get_result()->fetch_assoc();

        if ($existing) {
            $newQty = $existing['quantity'] + $quantity;
            $upd = $this->conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $upd->bind_param("ii", $newQty, $existing['id']);
            return $upd->execute();
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO cart (customerID, productID, quantity) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iii", $customerId, $productId, $quantity);
        return $stmt->execute();
    }

    // Remove item from cart
    public function removeFromCart($cartId, $customerId) {
        $stmt = $this->conn->prepare(
            "DELETE FROM cart WHERE id = ? AND customerID = ?"
        );
        $stmt->bind_param("ii", $cartId, $customerId);
        return $stmt->execute();
    }

    // Load cart with product + image info
    public function loadCart($customerId) {
        $stmt = $this->conn->prepare(
            "SELECT c.id AS cart_id, c.quantity,
                    p.id AS product_id, p.brand, p.model_name, p.price, p.stock,
                    pi.image_path AS main_image
             FROM cart c
             JOIN products p ON c.productID = p.id
             LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_main = 1
             WHERE c.customerID = ?"
        );
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get cart totals
    public function getCartTotal($customerId) {
        $items    = $this->loadCart($customerId);
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax   = round($subtotal * 0.08, 2);
        $total = $subtotal + $tax;
        return [
            'items'    => $items,
            'subtotal' => $subtotal,
            'tax'      => $tax,
            'total'    => $total,
        ];
    }

    // Count cart items
    public function getCartCount($customerId) {
        $stmt = $this->conn->prepare(
            "SELECT SUM(quantity) AS cnt FROM cart WHERE customerID = ?"
        );
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['cnt'] ?? 0;
    }

    // ─── FAVORITES ───────────────────────────────────────────

    public function addToFavorites($customerId, $productId) {
        $check = $this->conn->prepare(
            "SELECT id FROM favorites WHERE customerID = ? AND productID = ?"
        );
        $check->bind_param("ii", $customerId, $productId);
        $check->execute();
        if ($check->get_result()->num_rows > 0) return true; // already exists

        $stmt = $this->conn->prepare(
            "INSERT INTO favorites (customerID, productID) VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $customerId, $productId);
        return $stmt->execute();
    }

    public function removeFromFavorites($favoriteId, $customerId) {
        $stmt = $this->conn->prepare(
            "DELETE FROM favorites WHERE id = ? AND customerID = ?"
        );
        $stmt->bind_param("ii", $favoriteId, $customerId);
        return $stmt->execute();
    }

    public function loadFavorites($customerId) {
        $stmt = $this->conn->prepare(
            "SELECT f.id AS fav_id,
                    p.id AS product_id, p.brand, p.model_name, p.price,
                    pi.image_path AS main_image
             FROM favorites f
             JOIN products p ON f.productID = p.id
             LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_main = 1
             WHERE f.customerID = ?"
        );
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function moveToCart($favoriteId, $customerId) {
        // Get the productID from favorite
        $stmt = $this->conn->prepare(
            "SELECT productID FROM favorites WHERE id = ? AND customerID = ?"
        );
        $stmt->bind_param("ii", $favoriteId, $customerId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        if (!$row) return false;

        $this->addToCart($customerId, $row['productID'], 1);
        return $this->removeFromFavorites($favoriteId, $customerId);
    }

    // ─── ORDERS / CHECKOUT ───────────────────────────────────

    public function placeOrder($customerId, $address, $apartment, $city, $country, $zipcode) {
        $this->conn->begin_transaction();
        try {
            // Save billing
            $billCheck = $this->conn->prepare(
                "SELECT id FROM billing WHERE customerID = ?"
            );
            $billCheck->bind_param("i", $customerId);
            $billCheck->execute();

            if ($billCheck->get_result()->num_rows > 0) {
                $upd = $this->conn->prepare(
                    "UPDATE billing SET address=?, apartment=?, city=?, country=?, zipcode=?
                     WHERE customerID=?"
                );
                $upd->bind_param("sssssi", $address, $apartment, $city, $country, $zipcode, $customerId);
                $upd->execute();
            } else {
                $ins = $this->conn->prepare(
                    "INSERT INTO billing (customerID, address, apartment, city, country, zipcode)
                     VALUES (?, ?, ?, ?, ?, ?)"
                );
                $ins->bind_param("issssi", $customerId, $address, $apartment, $city, $country, $zipcode);
                $ins->execute();
            }

            // Create orders from cart
            $cartItems = $this->loadCart($customerId);
            foreach ($cartItems as $item) {
                $stmt = $this->conn->prepare(
                    "INSERT INTO orders (customerID, productID, quantity, price, status)
                     VALUES (?, ?, ?, ?, 'pending')"
                );
                $total = $item['price'] * $item['quantity'];
                $stmt->bind_param("iiid", $customerId, $item['product_id'], $item['quantity'], $total);
                $stmt->execute();
            }

            // Clear cart
            $del = $this->conn->prepare("DELETE FROM cart WHERE customerID = ?");
            $del->bind_param("i", $customerId);
            $del->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    // Get order history
    public function getOrders($customerId) {
        $stmt = $this->conn->prepare(
            "SELECT o.*, p.brand, p.model_name, pi.image_path AS main_image
             FROM orders o
             JOIN products p ON o.productID = p.id
             LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_main = 1
             WHERE o.customerID = ?
             ORDER BY o.created_at DESC"
        );
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get customer details
    public function getCustomerDetails($email) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM users WHERE email = ? AND role = 'customer'"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
