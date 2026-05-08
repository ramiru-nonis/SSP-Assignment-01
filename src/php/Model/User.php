<?php

require_once "./src/php/Model/Database.php";
require_once "./src/php/Model/Validator.php";

class User {

    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $role;
    protected $conn;

    private $table = "users";

    public function __construct($firstName = "", $lastName = "", $email = "", $password = "", $role = "") {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->email     = $email;
        $this->password  = $password;
        $this->role      = $role;

        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Register new user
    public function save() {
        if (!Validator::validateCredentials($this->firstName, $this->lastName, $this->email, $this->password)) {
            return false;
        }

        // Check email uniqueness
        $check = $this->conn->prepare("SELECT id FROM {$this->table} WHERE email = ?");
        $check->bind_param("s", $this->email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            return "duplicate";
        }

        $hashed = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $this->firstName, $this->lastName, $this->email, $hashed, $this->role);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Authenticate user
    public function authenticate($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    // Get user ID by email + role
    public function getUserId($email, $role) {
        $stmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE email = ? AND role = ?");
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            return $result->fetch_assoc()['id'];
        }
        return false;
    }

    // Get user details by email
    public function getUserDetails($email) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Edit user profile
    public static function editUser($conn, $id, $fname, $lname, $email, $password, $image) {
        try {
            $conn->begin_transaction();

            $imagePath = null;
            if (!empty($image['name'])) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Celario_lite/cellario_lite/uploads/";
                if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);

                $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
                $mime    = mime_content_type($image['tmp_name']);
                if (!in_array($mime, $allowed)) throw new Exception("Invalid image type.");

                $name      = time() . '_' . basename($image['name']);
                $targetPath = $uploadDir . $name;
                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    $imagePath = "/Celario_lite/cellario_lite/uploads/" . $name;
                } else {
                    throw new Exception("Upload failed.");
                }
            }

            $hashed = password_hash($password, PASSWORD_BCRYPT);

            if ($imagePath) {
                $stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, password=?, image_path=? WHERE id=?");
                $stmt->bind_param("ssssi", $fname, $lname, $hashed, $imagePath, $id);
            } else {
                $stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, password=? WHERE id=?");
                $stmt->bind_param("sssi", $fname, $lname, $hashed, $id);
            }

            $stmt->execute();
            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            return $e->getMessage();
        }
    }
}
