<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $p_id    = $_POST['product_id'];
    $p_name  = $_POST['product_name'];
    $p_price = $_POST['product_price'];
    $p_category = $_POST['product_category'];
    $p_image = $_POST['product_image'];

    // Create cart if not exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If product already exists in cart → increase qty
    if (isset($_SESSION['cart'][$p_id])) {
        $_SESSION['cart'][$p_id]['quantity'] += 1;
    } else {
        // Add new product
        $_SESSION['cart'][$p_id] = [
            'id'       => $p_id,
            'name'     => $p_name,
            'price'    => $p_price,
            'image'    => $p_image,
            'category' => $p_category,
            'quantity' => 1
        ];
    }

    // Redirect back to product page
    header("Location: /");
    exit();
}