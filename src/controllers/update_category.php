<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../models/categoryModel.php';

    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    try {
        updateCategory($id, $name, $description);
        header('Location: ../views/pages/categories.php?status=success&message=Category updated successfully');
        exit();
    } catch (Exception $e) {
        header('Location: ../views/pages/categories.php?status=error&message=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: ../views/pages/categories.php');
    exit();
}