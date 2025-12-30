<?php
require_once __DIR__ . '/../models/categoryModel.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    addCategory($name, $description);

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
