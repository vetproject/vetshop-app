<?php
require_once __DIR__ . '/../models/productModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = trim($_POST['product_name']);
    $category    = trim($_POST['category']);
    $price       = $_POST['price'];
    $description = trim($_POST['description']);

    // ✅ Convert image to Base64
    if (!empty($_FILES['image']['tmp_name'])) {

        $imageType = mime_content_type($_FILES['image']['tmp_name']);
        $imageData = file_get_contents($_FILES['image']['tmp_name']);

        // Base64 format with mime type (BEST PRACTICE)
        $base64Image = 'data:' . $imageType . ';base64,' . base64_encode($imageData);

    } else {
        die("No image uploaded");
    }

    // ✅ Save to database
    addProduct(
        $name,
        $category,
        $price,
        $description,
        $base64Image
    );

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
