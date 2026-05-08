<?php

require_once "./src/php/Model/User.php";

// ─── Admin Secret Key ───────────────────────────────────────────────────────
// Change this to your desired admin registration password.
// Keep this confidential — do not commit to public repos.
define('ADMIN_SECRET_KEY', 'admin123');

class UserController
{

    public function register(string $firstName, string $lastName, string $email, string $password, string $role, string $adminSecret = '')
    {
        // Only allow admin or customer
        $allowedRoles = ['admin', 'customer'];
        if (!in_array($role, $allowedRoles)) {
            echo "<script>alert('Invalid role selected.');</script>";
            return;
        }

        // ─── Admin secret key gate ───────────────────────────────────────
        if ($role === 'admin') {
            if (empty($adminSecret) || $adminSecret !== ADMIN_SECRET_KEY) {
                echo "<script>alert('Invalid admin secret key. Admin registration denied.');</script>";
                return;
            }
        }

        $user   = new User($firstName, $lastName, $email, $password, $role);
        $result = $user->save();

        if ($result === "duplicate") {
            echo "<script>alert('An account with this email already exists.');</script>";
            return;
        }

        if ($result) {
            session_start();
            $_SESSION['email']      = $email;
            $_SESSION['name']       = $firstName . " " . $lastName;
            $_SESSION['first_name'] = $firstName;
            $_SESSION['last_name']  = $lastName;
            $_SESSION['role']       = $role;
            $_SESSION['user_id']    = $user->getUserId($email, $role);

            if ($role === 'admin') {
                header("Location: /Celario_lite/cellario_lite/Admin/Dashboard");
            } else {
                header("Location: /Celario_lite/cellario_lite/Products");
            }
            exit;
        } else {
            echo "<script>alert('Registration failed. Please check your details.');</script>";
        }
    }

    public function login(string $email, string $password)
    {
        $user     = new User();
        $userData = $user->authenticate($email, $password);

        if ($userData) {
            session_start();
            $_SESSION['email']      = $userData['email'];
            $_SESSION['name']       = $userData['firstName'] . " " . $userData['lastName'];
            $_SESSION['first_name'] = $userData['firstName'];
            $_SESSION['last_name']  = $userData['lastName'];
            $_SESSION['role']       = $userData['role'];
            $_SESSION['user_id']    = $userData['id'];
            $_SESSION['image']      = $userData['image_path'];

            if ($userData['role'] === 'admin') {
                header("Location: /Celario_lite/cellario_lite/Admin/Dashboard");
            } else {
                header("Location: /Celario_lite/cellario_lite/Products");
            }
            exit;
        } else {
            echo "<script>alert('Invalid email or password.');</script>";
        }
    }
}
