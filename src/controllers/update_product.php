<?php
require_once __DIR__ . '/../models/productModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $old_image = $_POST['old_image'];

    $image = $old_image;

    // Check if new image uploaded
    if (!empty($_FILES['image']['tmp_name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = mime_content_type($imageTmp); // image/jpeg, image/png

        $imageData = file_get_contents($imageTmp);
        $base64 = base64_encode($imageData);

        // Store as Data URI (BEST PRACTICE)
        $image = "data:$imageType;base64,$base64";
    }

    // Update database
    updateProduct(
        $id,
        $name,
        $category,
        $price,
        $description,
        $image
    );

    header('Location: /products');
    exit();

} else {
    header('Location: /product');
    exit();
}
