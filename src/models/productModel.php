<?php
require_once __DIR__ . '/../config/db.php';

function getAllProducts()
{
    global $conn;

    $sql = "SELECT * FROM products ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function addProduct($product_name, $category, $price, $description, $image)
{
    global $conn;

    $stmt = $conn->prepare(
        "INSERT INTO products (product_name, category, price, description, image)
         VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssdss",
        $product_name,
        $category,
        $price,
        $description,
        $image
    );

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    return $conn->insert_id;
}

function updateProduct($id, $product_name, $category, $price, $description, $image)
{
    global $conn;

    $stmt = $conn->prepare(
        "UPDATE products 
         SET product_name = ?, category = ?, price = ?, description = ?, image = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "ssdssi",
        $product_name,
        $category,
        $price,
        $description,
        $image,
        $id
    );

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    return true;
}

function deleteProduct($id)
{
    global $conn;

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    return true;
}
