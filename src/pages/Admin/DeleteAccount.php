<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Celario_lite/cellario_lite/Login"); exit;
}

require_once "./src/php/Controller/AdminController.php";
$ctrl = new AdminController();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $ctrl->deleteAccount($id);
}

header("Location: /Celario_lite/cellario_lite/Admin/ManageAccounts");
exit;
