<?php

class Validator {

    public static function validateCredentials($firstName, $lastName, $email, $password) {
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if (strlen($password) < 6) {
            return false;
        }
        return true;
    }

    public static function sanitizeString($value) {
        return htmlspecialchars(strip_tags(trim($value)));
    }

    public static function validatePrice($price) {
        return is_numeric($price) && $price > 0;
    }

    public static function validateStock($stock) {
        return is_numeric($stock) && $stock >= 0;
    }
}
