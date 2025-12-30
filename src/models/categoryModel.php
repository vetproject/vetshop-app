<?php
require_once __DIR__ . '/../config/db.php';

function getAllCategories()
{
    global $conn;

    $sql = "SELECT * FROM categories ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function addCategory($name, $description)
{
    global $conn;

    $stmt = $conn->prepare(
        "INSERT INTO categories (name, description)
         VALUES (?, ?)"
    );

    $stmt->bind_param("ss", $name, $description);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    return $conn->insert_id;
}

function updateCategory($id, $name, $description)
{
    global $conn;

    $stmt = $conn->prepare(
        "UPDATE categories
         SET name = ?, description = ?
         WHERE id = ?"
    );

    $stmt->bind_param("ssi", $name, $description, $id);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    return true;
}

function deleteCategory($id)
{
    global $conn;

    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    return true;
}
