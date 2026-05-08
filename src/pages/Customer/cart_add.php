<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: /Celario_lite/cellario_lite/Login");
    exit;
}

require_once "./src/php/Controller/CustomerController.php";
$controller = new CustomerController();

$productId = isset($_GET['id'])  ? (int)$_GET['id']  : 0;
$quantity  = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

if ($productId > 0) {
    $controller->addToCart($_SESSION['user_id'], $productId, $quantity);
}

header("Location: /Celario_lite/cellario_lite/Cart");
exit;
