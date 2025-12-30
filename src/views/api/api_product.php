<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/productModel.php';

$method = $_SERVER['REQUEST_METHOD'];

try {

    // =========================
    // GET /api/products
    // =========================
    if ($method === 'GET') {
        echo json_encode([
            "status" => true,
            "data" => getAllProducts()
        ]);
        exit;
    }

    // =========================
    // POST /api/products
    // =========================
    if ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid JSON"]);
            exit;
        }

        $id = addProduct(
            $data['product_name'],
            $data['category'],
            $data['price'],
            $data['description'],
            $data['image']
        );

        echo json_encode([
            "status" => true,
            "message" => "Product created",
            "id" => $id
        ]);
        exit;
    }

    // =========================
    // PUT /apiproducts
    // =========================
    if ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);

        updateProduct(
            $data['id'],
            $data['product_name'],
            $data['category'],
            $data['price'],
            $data['description'],
            $data['image']
        );

        echo json_encode([
            "status" => true,
            "message" => "Product updated"
        ]);
        exit;
    }

    // =========================
    // DELETE /api/products?id=1
    // =========================
    if ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(["message" => "Product ID required"]);
            exit;
        }

        deleteProduct($id);

        echo json_encode([
            "status" => true,
            "message" => "Product deleted"
        ]);
        exit;
    }

    // =========================
    // Method not allowed
    // =========================
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "error" => $e->getMessage()
    ]);
}
