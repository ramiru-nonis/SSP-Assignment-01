<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: /Celario_lite/cellario_lite/Login");
    exit;
}

require_once "./src/php/Controller/CustomerController.php";
$controller = new CustomerController();

$favId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($favId > 0) {
    $controller->removeFromFavorites($favId, $_SESSION['user_id']);
}

header("Location: /Celario_lite/cellario_lite/Favorites");
exit;
